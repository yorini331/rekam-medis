#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <SoftwareSerial.h>
#include <ArduinoJson.h>

// Konfigurasi Wi-Fi
const char* ssid = "ERROR";
const char* password = "p3p3sk4k4p";

// URL endpoint Laravel
const char* serverUrl = "http://192.168.18.27:8888/api/rfid";

// Konfigurasi SoftwareSerial untuk komunikasi dengan Arduino
SoftwareSerial mcu(D6, D5); // RX, TX ESP8266

String data = ""; // Variabel untuk menyimpan data yang diterima

void setup() {
  Serial.begin(115200); // Komunikasi dengan komputer
  mcu.begin(9600);      // Komunikasi dengan Arduino

  // Koneksi Wi-Fi
  WiFi.begin(ssid, password);
  Serial.print("Menghubungkan ke ");
  Serial.println(ssid);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("Terhubung ke Wi-Fi");
  Serial.print("Alamat IP: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  // Kirim permintaan data ke Arduino

  // Terima data dari Arduino
  while (mcu.available()) {
    char c = mcu.read();
    if (c == '\n') { // Jika karakter '\n' (newline) terdeteksi, akhir dari data
      Serial.print("Data diterima: ");
      Serial.println(data);

      String rfidData = filterRFIDData(data);

      if (!rfidData.isEmpty()) {
        sendDataToServer(rfidData);
      }

      data = "";
    } else {
      data += c; // Tambahkan karakter ke string data
    }
  }

  delay(500); // Tambahkan delay untuk komunikasi yang stabil
}


void sendDataToServer(String data) {
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;
    Serial.println("MASUK KE SEND TO DATA SERVER");

    String boundary = "---------------------------" + String(random(0xffffff), HEX);
    String formData = "--" + boundary + "\r\n";
    formData += "Content-Disposition: form-data; name=\"rfid\"\r\n\r\n";
    formData += data + "\r\n";
    formData += "--" + boundary + "--\r\n";

    http.begin(client, serverUrl);

    http.addHeader("Content-Type", "multipart/form-data; boundary=" + boundary);
    Serial.println("POST DATA");
    int httpResponseCode = http.POST(formData);

    if (httpResponseCode > 0) {
      String payload = http.getString();
      Serial.println("Respons dari server:");
      Serial.println(payload);

      DynamicJsonDocument doc(1024);
      deserializeJson(doc, payload);
      String nama = doc["nama"].as<String>();

      mcu.print(nama);
      mcu.print('\n');
    } else {
      Serial.print("Error pada HTTP request: ");
      Serial.println(httpResponseCode);
    }

    http.end(); 
  } else {
    Serial.println("Tidak terhubung ke Wi-Fi");
  }
}

String filterRFIDData(String data) {
  String filteredData = "";
  bool isRfidData = false;

  for (int i = 0; i < data.length(); i++) {
    char c = data.charAt(i);

    if (isDigit(c)) {
      filteredData += c; 
      isRfidData = true;
    } else if (c == ' ' && isRfidData) {
      continue;
    } else {
      isRfidData = false;
    }
  }

  return filteredData;
}

