#include <AddicoreRFID.h>
#include <Ethernet.h>
#include <SPI.h>

byte mac[] = {0x00, 0xAA, 0xBB, 0xCC, 0x2E, 0x02};
char server[] = "*****.com";
String key = "*****"; // password for running PHP scripts
boolean alarmState = false;

/* Unsigned long variables are extended size variables for number storage, and
store 32 bits (4 bytes). Unlike standard longs unsigned longs won't store
negative numbers, making their range from 0 to 4,294,967,295 (2^32 - 1). This
means it can run for around 49 days before the varable overflows. */
unsigned long previousMillis = 0; // will store last time of checking the server
const long interval = 30000; // interval at which to blink (milliseconds)

// LED variables
#define red 6
#define green 9
#define blue 3

// RFID variables
#define uchar unsigned char
#define uint  unsigned int
#define MAX_LEN 16 // maximum length of the RFID array
uchar fifobytes;
uchar fifoValue;

AddicoreRFID myRFID;
EthernetClient client;

const int ssSD = 4; // SD slave select pin
const int ssEthernet = 10; // Ethernet chip slave select pin
const int chipSelectPin = 8; // RFID slave select pin
const int NRSTPD = 5; // RFID reset pin
const int pirPin = 7; // PIR sensor pin

void setup() {
  Serial.begin(9600);
  SPI.begin();

  Serial.println("Initializing...");

  // enable PIR sensor
  pinMode(pirPin, INPUT);
  digitalWrite(pirPin, LOW);

  // start RFID reader
  pinMode(chipSelectPin, OUTPUT); // set digital pin 8 as OUTPUT to connect it to the RFID /ENABLE pin
  digitalWrite(chipSelectPin, LOW); // activate the RFID reader
  pinMode(NRSTPD, OUTPUT); // set digital pin 5 , not reset and power-down
  digitalWrite(NRSTPD, HIGH);
  myRFID.AddicoreRFID_Init();

  // disable SD card
  pinMode(ssSD, OUTPUT);
  digitalWrite(ssSD, HIGH);

  // start Ethernet connection
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
  }

  delay(5000);
  printIPAddress();
  post("addEntry", "action=Power ON");
  Serial.println("--- READY ---");
  Serial.println();
}

void loop() {
  uchar i, tmp;
  uchar status;
  uchar str[MAX_LEN];
  uchar RC_size;
  uchar blockAddr;  //Selection operation block address 0 to 63
  String mynum = "";
  str[1] = 0x4400;

  status = myRFID.AddicoreRFID_Request(PICC_REQIDL, str); // find tags, return tag type
  status = myRFID.AddicoreRFID_Anticoll(str); // anti-collision, return tag serial number 4 bytes

  if (status == MI_OK) {
    int sourceTag[] = {str[0], str[1], str[2], str[3], str[4]};

    // MasterTag handling
    if (checkMaster(sourceTag) == true) {
      Serial.println("MasterTag detected, waiting for another tag...");
      led(0,0,50);
      myRFID.AddicoreRFID_Halt();
      str[1] = 0x4400;
      while (status == MI_OK) {
        status = myRFID.AddicoreRFID_Request(PICC_REQIDL, str);
        status = myRFID.AddicoreRFID_Anticoll(str);
      }
      delay(1000);
      while (status != MI_OK) {
        status = myRFID.AddicoreRFID_Request(PICC_REQIDL, str);
        status = myRFID.AddicoreRFID_Anticoll(str);
      }

      if (status == MI_OK) {
        int sourceTag[] = {str[0], str[1], str[2], str[3], str[4]};
        readTag(sourceTag);

        String data = "uid1=" + String(sourceTag[0]) + "&uid2=" + String(sourceTag[1]) + "&uid3=" + String(sourceTag[2]) + "&uid4=" + String(sourceTag[3]);
        post("manageTags", data);
      }
    }

    // normal Tag detected
    else {
      readTag(sourceTag);
      led(50,50,0);
      Serial.print("Is tag trusted? ");
      boolean trusted = verifyTrusted(sourceTag);
      if (trusted == true) {
        alarmToggle(sourceTag);
      }
      else if (trusted == false) {
        String action = "Access DENIED";
        String data = "uid1=" + String(sourceTag[0]) + "&uid2=" + String(sourceTag[1]) + "&uid3=" + String(sourceTag[2]) + "&uid4=" + String(sourceTag[3]) + "&action=" + String(action);
        post("addEntry", data);
      }
    }
    Serial.println();
    delay(500);
  }

  myRFID.AddicoreRFID_Halt(); //Command tag into hibernation

  // check server for state if the interval has passed
  unsigned long currentMillis = millis();
  if (currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis; // save the last time you checked server
    manageState("get"); // synchronizes the state with server
  }

  if (alarmState == true) {
    led(50,0,0);

    if (digitalRead(pirPin) == HIGH) {
      post("addEntry", "action=BREACH");
      delay(200);
      post("sendMail", "");

      while (digitalRead(pirPin) == HIGH) {
        led(50,0,0);
        delay(100);
        led(0,0,0);
        delay(100);
      }
    }
  }

  if (alarmState == false) {
    led(0,50,0);
  }
}

void printIPAddress() {
  Serial.print("My IP address: ");

  for (byte thisByte = 0; thisByte < 4; thisByte++) {
    Serial.print(Ethernet.localIP()[thisByte], DEC);
    Serial.print(".");
  }

  Serial.println();
}

// this method checks, if the tag read is a Master Tag
boolean checkMaster(int sourceTag[]) {
  int masterTag[] = {42, 52, 108, 16};

  for (int i=0; i<4; i++) {
    if (sourceTag[i] != masterTag[i]) {
      return false;
    }
  }
  return true;
}

void manageState(String option) {
  String data = "option=" + option;
  if (option == "get") {
    String response = post("manageState", data);
    if (response == "OK; alarmState=1") {
      alarmState = true;
    } else {
      alarmState = false;
    }
  }
  else if (option == "change") {
    post("manageState", data);
  }
}

// toggles the Alarm State and calls server script to add entry to the log
void alarmToggle(int sourceTag[]) {
  alarmState = !alarmState;

  String action;
  if (alarmState == true) {
    action = "Alarm ENABLED";
    manageState("change");
  }
  else if (alarmState == false) {
    action = "Alarm DISABLED";
    manageState("change");
  }

  String data = "uid1=" + String(sourceTag[0]) + "&uid2=" + String(sourceTag[1])
    + "&uid3=" + String(sourceTag[2]) + "&uid4=" + String(sourceTag[3]) + "&action=" + String(action);
  post("addEntry", data);
}

boolean verifyTrusted(int sourceTag[]) {
  String data = "uid1=" + String(sourceTag[0]) + "&uid2=" + String(sourceTag[1])
    + "&uid3=" + String(sourceTag[2]) + "&uid4=" + String(sourceTag[3]);

  String response = post("verifyTrusted", data);

  if (response == "OK; tag=1") {
    return true;
  } else {
    return false;
  }
}

String post(String page, String data) {
  data += "&key=" + key;
  String response;

  if (client.connect(server, 80)) {
    client.println("POST /" + page + ".php HTTP/1.1");
    client.println("Host: " + String(server));
    client.println("Content-Type: application/x-www-form-urlencoded");
    client.println("Content-Length: " + String(data.length()) );
    client.println();
    client.println(data);
  } else {
    client.stop();
    Serial.println("*disconnected*");
    return response = "*disconnected*";
  }

  response = getResponse();
  Serial.println(response);

  client.stop();
  return response;
}

String getResponse() {
  String output = "";
  boolean insideResp = false;

  for (int i = 0; i < 25000; i++) { // allows maximum message length X chars, can be changed if needed
    if (client.available()) {
      char c = client.read();
      String str(c);

      if (str == "<") {
        insideResp = true;
      }
      else if (insideResp == true) {
        if (str != ">") {
          output += str;
        }
        else {
          return output;
        }
      }
    }
  }
  return output = "ERROR: Response not found";
}

void led(int redVal, int greenVal, int blueVal) {
  analogWrite(red, redVal);
  analogWrite(green, greenVal);
  analogWrite(blue, blueVal);
}

void readTag(int sourceTag[]) {
  uchar checksum = sourceTag[0] ^ sourceTag[1] ^ sourceTag[2] ^ sourceTag[3];

  Serial.print("The tag's number is:\t");
  for (int i = 0; i < 3; i++) {
    Serial.print(String(sourceTag[i]) + ", ");
  }
  Serial.println(sourceTag[3]);

  Serial.print("Read Checksum:\t\t");
  Serial.println(sourceTag[4]);
  Serial.print("Calculated Checksum:\t");
  Serial.println(checksum);
}
