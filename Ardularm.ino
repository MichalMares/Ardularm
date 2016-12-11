#include <AddicoreRFID.h>
#include <Ethernet.h>
#include <SPI.h>

#define  uchar unsigned char
#define uint  unsigned int

uchar fifobytes;
uchar fifoValue;

// create AddicoreRFID object to control the RFID module
AddicoreRFID myRFID;

const int chipSelectPin = 10;
const int NRSTPD = 5;

//Maximum length of the array
#define MAX_LEN 16

void setup() {
  // disable SD card
  pinMode(4, OUTPUT);
  digitalWrite(4, HIGH);
}

void loop() {
  // disable Ethernet chip
  pinMode(10, OUTPUT);
  digitalWrite(10, HIGH);
}
