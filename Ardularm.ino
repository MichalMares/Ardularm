#include <AddicoreRFID.h>
#include <Ethernet.h>
#include <SPI.h>

byte mac[] = {0x00, 0xAA, 0xBB, 0xCC, 0xDE, 0x02};

char server[] = "192.168.1.101";
String serverIP = "192.168.1.101";

#define uchar unsigned char
#define uint  unsigned int

uchar fifobytes;
uchar fifoValue;

boolean alarmState = false;

AddicoreRFID myRFID;

EthernetClient client;

const int ssSD = 4; // SD slave select pin
const int ssEthernet = 10; // Ethernet chip slave select pin

const int chipSelectPin = 8; // RFID slave select pin
const int NRSTPD = 5; // RFID reset pin

const int pirPin = 7;
//RGB diode on pin 3,6,9

//Maximum length of the array
#define MAX_LEN 16

void setup() {
  // Open serial communications and wait for port to open
  Serial.begin(9600);
  SPI.begin();

  // enable PIR sensor
  pinMode(pirPin, INPUT);
  digitalWrite(pirPin, LOW);

  // start RFID reader
  pinMode(chipSelectPin, OUTPUT);              // Set digital pin 10 as OUTPUT to connect it to the RFID /ENABLE pin
  digitalWrite(chipSelectPin, LOW);         // Activate the RFID reader
  pinMode(NRSTPD, OUTPUT);                     // Set digital pin 10 , Not Reset and Power-down
  digitalWrite(NRSTPD, HIGH);
  myRFID.AddicoreRFID_Init();

  // disable SD card
  pinMode(ssSD, OUTPUT);
  digitalWrite(ssSD, HIGH);

  // start Ethernet connection
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
  }
  
  Serial.println("Initializing...");
  delay(5000);
  
  printIPAddress();
  Serial.println("READY");
}

void loop() {  
  uchar i, tmp, checksum1;
  uchar status;
  uchar str[MAX_LEN];
  uchar RC_size;
  uchar blockAddr;  //Selection operation block address 0 to 63
  String mynum = "";

  str[1] = 0x4400;

  //Find tags, return tag type
  status = myRFID.AddicoreRFID_Request(PICC_REQIDL, str);

  //Anti-collision, return tag serial number 4 bytes
  status = myRFID.AddicoreRFID_Anticoll(str);
  if (status == MI_OK) {
    checksum1 = str[0] ^ str[1] ^ str[2] ^ str[3];
    Serial.print("The tag's number is:\t");
    Serial.print(str[0]);
    Serial.print(" , ");
    Serial.print(str[1]);
    Serial.print(" , ");
    Serial.print(str[2]);
    Serial.print(" , ");
    Serial.println(int(str[3]));

    Serial.print("Read Checksum:\t\t");
    Serial.println(str[4]);
    Serial.print("Calculated Checksum:\t");
    Serial.println(checksum1);

    int sourceTag[] = {str[0], str[1], str[2], str[3], str[4]};

    // MasterTag detected
    if (checkMaster(sourceTag) == true) {
      Serial.println("MasterTag detected, waiting for another tag...");
      // TO DO
    }

    // normal Tag detected
    else {
      Serial.print("Is tag trusted? ");
      boolean trusted = verifyTrusted(sourceTag);
      if (trusted == true) {
        Serial.println("trusted");
        alarmToggle(sourceTag);
      }
      else if (trusted == false) {
        Serial.println("not trusted");
        String action = "Access DENIED";
        String data = "uid1=" + String(sourceTag[0]) + "&uid2=" + String(sourceTag[1]) + "&uid3=" + String(sourceTag[2]) + "&uid4=" + String(sourceTag[3]) + "&action=" + String(action);
        sendData(data);
        Serial.println(action);
      }
    }
    Serial.println("_______________________________");
    delay(500);
  }

  myRFID.AddicoreRFID_Halt(); //Command tag into hibernation

  // PIR side TO DO
}

void printIPAddress() {
  Serial.print("My IP address: ");
  for (byte thisByte = 0; thisByte < 4; thisByte++) {
    // print the value of each byte of the IP address:
    Serial.print(Ethernet.localIP()[thisByte], DEC);
    Serial.print(".");
  }
  
  Serial.println();
  Serial.println();
}

void sendData(String data) {  
  if (client.connect("192.168.1.101", 80)) {
    client.println("POST /ardularm/addEntry.php HTTP/1.1");
    client.println("Host: 192.168.1.101");
    client.println("Content-Type: application/x-www-form-urlencoded");
    client.println("Content-Length: " + String(data.length()) );
    client.println();
    client.println(data);
  }
  Serial.println("Data sent");

  client.stop();
}

boolean checkMaster(int sourceTag[]) {
  int masterTag[] = {226, 97, 225, 231};
  
  for (int i=0; i<4; i++) {
    if (sourceTag[i] != masterTag[i]) {
      return false;
    }
  }
  return true;
}

boolean verifyTrusted(int sourceTag[]) {
  String request = "?uid1=" + String(sourceTag[0]) + "&uid2=" + String(sourceTag[1])
    + "&uid3=" + String(sourceTag[2]) + "&uid4=" + String(sourceTag[3]);
  
  if (client.connect(server, 80)) {
    client.print("GET http://192.168.1.101/ardularm/verifyTrusted.php");
    client.println(request);
    client.println();
    delay(250);
  }

  char response;
  while (client.available()) {
    response = client.read();
  }
  client.stop();
  
  if (response == '1') {
    return true;
  }
  else if (response == '0') {
    return false;
  }
}

void alarmToggle(int sourceTag[]) {
  alarmState = !alarmState;
  
  String action;
  if (alarmState == true) {
      action = "Alarm ENABLED";
      Serial.println(action);
    }
  else if (alarmState == false) {
    action = "Alarm DISABLED";
    Serial.println(action);
  }
  
  String data = "uid1=" + String(sourceTag[0]) + "&uid2=" + String(sourceTag[1])
    + "&uid3=" + String(sourceTag[2]) + "&uid4=" + String(sourceTag[3]) + "&action=" + String(action);
  sendData(data);
  
  Serial.println("Log entered");
  client.stop();
}

void sendEmail() {
  if (client.connect(server, 80)) {
    client.println("GET http://192.168.1.101/ardularm/sendEmail.php");
  }
  client.stop();
}

