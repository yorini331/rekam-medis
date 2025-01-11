#include <SPI.h>
#include <Wire.h>
#include <RFID.h>
#include <LiquidCrystal_I2C.h>
#include <SoftwareSerial.h>

LiquidCrystal_I2C lcd(0x27, 16, 2); // Initialize LCD Display at address 0x27 / 0X3F
#define sda 10 // Pin Serialdata (SDA)
#define rst 9 // Pin Reset
RFID rfid(sda, rst);
const int buzzer = 7; // Deklarasikan pin buzzer sebagai konstanta global
SoftwareSerial uno(2, 3); // RX, TX for communication with ESP8266

const int buttonPin = 4; // Pin untuk tombol push button
bool isOn = false; // Status tombol
String receivedData = "";
void setup() {
  Serial.begin(9600); // Baud rate for serial monitor
  lcd.init(); // Initialize LCD
  lcd.backlight(); // Turn on LCD backlight
  lcd.setBacklight(255); // Set LCD backlight brightness (value between 0 and 255)
  SPI.begin(); // SPI interface initialization
  rfid.init(); // Initialize RFID module
  pinMode(buzzer, OUTPUT); // Set buzzer pin as OUTPUT
  uno.begin(9600); // Initialize communication with ESP8266

  pinMode(buttonPin, INPUT_PULLUP); // Mengatur pin tombol sebagai input dengan pull-up internal

  lcd.setCursor(0, 0);
  lcd.print(" SELAMAT DATANG");
  lcd.setCursor(0, 1);
  lcd.print("  diPOLIKLINIK  ");
  delay(5000);
  lcd.clear();
}

void loop() {
  // Check if power button is pressed to turn on/off the system
  int buttonState = digitalRead(buttonPin);
  if (buttonState == LOW) {
    if (!isOn) { // Jika sistem belum menyala
      // Nyalakan sistem
      lcd.setCursor(0, 0);
      lcd.print("     SISTEM");
      lcd.setCursor(0, 1);
      lcd.print("      MATI   ");
      delay(2000);
      lcd.clear();
      isOn = true;
    }
    else { // Jika sistem sudah menyala
      // Matikan sistem
//      lcd.setCursor(0, 0);
//      lcd.print("SISTEM");
//      lcd.setCursor(0, 1);
//      lcd.print("DIMATIKAN");
//      delay(2000);
      lcd.clear();
      isOn = false;
    }
  }

  // Jika sistem menyala, lanjutkan operasi normal
  if (isOn && buttonState == HIGH) {
    // Display instructions on LCD
    lcd.setCursor(0, 0);
    lcd.print("    SILAHKAN");
    lcd.setCursor(0, 1);
    lcd.print(" TAP KARTU ANDA");

    // Check if RFID card is detected
    // Jika RFID card terdeteksi
    if (rfid.isCard()) {
      if (rfid.readCardSerial()) {
        lcd.clear();
        lcd.setCursor(0, 0);
        lcd.print("ID terbaca :    ");

        lcd.setCursor(0, 1);
        for (int i = 0; i < 5; ++i) {
          Serial.print(rfid.serNum[i]); 
          Serial.print(" ");
          lcd.print(rfid.serNum[i]);
        }
        Serial.println();

        playSound(1000, 150);
        delay(500);

        uno.println("RFID Data:");
        for (int i = 0; i < 5; ++i) {
          uno.print(rfid.serNum[i]);
          uno.print(" ");
        }

        uno.println();
        delay(1000);

        while (uno.available()) {
          char c = uno.read();
          Serial.print(c);
          if (c == '\n') {
            lcd.clear();
            lcd.setCursor(0, 0);
            lcd.print("Nama: ");
            lcd.setCursor(0, 1);
            receivedData.trim();
            lcd.print(receivedData);
            receivedData = "";
          } else {
            receivedData += c; 
            Serial.print(receivedData);
          }
        }
        delay(2000);
        lcd.clear();
      }
    }
  }
}

// Function to play sound on buzzer with specified frequency and duration
void playSound(int frequency, int duration) {
  tone(buzzer, frequency, duration); // Play tone with specified frequency and duration
  delay(duration); // Wait until duration of tone is over
  noTone(buzzer); // Stop playing tone
}
