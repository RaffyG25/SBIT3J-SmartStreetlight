// Define LED pins
const int ledPins[] = {3, 4, 5, 6, 7, 8};
const int numLeds = 6;

// Define LDR pin
const int ldrPin = A0;

// Threshold for lighting up LEDs
const int threshold = 200;

int ldrValue;
// int id = 0;  // Removed the global id variable

void setup() {
  Serial.begin(9600);
  for (int i = 0; i < numLeds; i++) {
    pinMode(ledPins[i], OUTPUT);
    digitalWrite(ledPins[i], LOW); // Ensure LEDs are off initially
  }
  pinMode(ldrPin, INPUT);
}

void loop() {
  // Read the LDR value
  ldrValue = analogRead(ldrPin);

  // Check if the LDR value is below or equal to the threshold
  if (ldrValue <= threshold) {
    // Turn on all LEDs
    for (int i = 0; i < numLeds; i++) {
      digitalWrite(ledPins[i], HIGH);
    }
  } else {
    // Turn off all LEDs
    for (int i = 0; i < numLeds; i++) {
      digitalWrite(ledPins[i], LOW);
    }
  }

  // Print the nested JSON structure
  Serial.print("[");
  for (int i = 0; i < numLeds; i++) {
    int ledId = i + 1; // Calculate LED ID (1 to 6)
    Serial.print("{\"ID\":");
    Serial.print(ledId);
    Serial.print(",\"LDR\":");
    Serial.print(ldrValue);
    Serial.print(",\"LED\":");
    if (digitalRead(ledPins[i]) == HIGH) {
      Serial.print("\"ON");
    } else {
      Serial.print("\"OFF");
    }
    Serial.print("\"}");
    if (i < numLeds - 1) { // Add comma except after the last element
      Serial.print(",");
    }
  }
  Serial.println("]");
  delay(500);
}