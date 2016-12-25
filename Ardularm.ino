#include <AddicoreRFID.h>
#include <Ethernet.h>
#include <SPI.h>

byte mac[] = {0x00, 0xAA, 0xBB, 0xCC, 0xDE, 0x02};

#define uchar unsigned char
#define uint  unsigned int

uchar fifobytes;
uchar fifoValue;

// create AddicoreRFID object to control the RFID module
AddicoreRFID myRFID;

EthernetClient client;

const int ssSD = 4; //SD slave select pin
const int ssEthernet = 10; //Ethernet chip slave select pin

const int chipSelectPin = 8; //RFID slave select pin
const int NRSTPD = 5; //RFID some pin

const int pirPin = 7;
//RGB diode on pin 3,6,9

//Maximum length of the array
#define MAX_LEN 16

void setup() {
  // Open serial communications and wait for port to open
  Serial.begin(9600);

  SPI.begin();
  pinMode(chipSelectPin, OUTPUT);              // Set digital pin 10 as OUTPUT to connect it to the RFID /ENABLE pin
  digitalWrite(chipSelectPin, LOW);         // Activate the RFID reader
  pinMode(NRSTPD, OUTPUT);                     // Set digital pin 10 , Not Reset and Power-down
  digitalWrite(NRSTPD, HIGH);
  myRFID.AddicoreRFID_Init();

  // disable SD card
  pinMode(ssSD, OUTPUT);
  digitalWrite(ssSD, HIGH);

  // start the Ethernet connection:
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
  }
  printIPAddress();
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
    Serial.println(str[3]);

    Serial.print("Read Checksum:\t\t");
    Serial.println(str[4]);
    Serial.print("Calculated Checksum:\t");
    Serial.println(checksum1);

    sendData(str[0], str[1], str[2], str[3]);

    // Should really check all pairs, but for now we'll just use the first
    if (str[0] == 197)                     //You can change this to the first byte of your tag by finding the card's ID through the Serial Monitor
    {
      Serial.println("\nHello Craig!\n");
    } else if (str[0] == 244) {            //You can change this to the first byte of your tag by finding the card's ID through the Serial Monitor
      Serial.println("\nHello Erin!\n");
    }

    printIPAddress();
    delay(1000);
  }

  myRFID.AddicoreRFID_Halt(); //Command tag into hibernation
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

void sendData(uchar uid1, uchar uid2, uchar uid3, uchar uid4) {
  String action = "user logged";
  
  String data = "uid1=" + String(uid1) + "&uid2=" + String(uid2)
    + "&uid3=" + String(uid3) + "&uid4=" + String(uid4) + "&action=" + String(action);
  
  if (client.connect("192.168.1.109", 80)) { // REPLACE WITH YOUR SERVER ADDRESS
    client.println("POST /ardularm/add.php HTTP/1.1");
    client.println("Host: 192.168.1.109"); // SERVER ADDRESS HERE TOO
    client.println("Content-Type: application/x-www-form-urlencoded");
    client.println("Content-Length: " + String(data.length()) );
    client.println();
    client.println(data);
  }

  Serial.println("Data sent");

  if (client.connected()) {
    client.stop();  // DISCONNECT FROM THE SERVER
  }
}

