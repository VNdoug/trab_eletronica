int pir = 7;
int ledAlarme = 8;
int ledAtivo = 9;
int buzzer = 3;

int movimento;

int alarmeAtivo = 0;
int intrusoDetectado = 0;

#include "etherShield.h"
#include "ETHER_28J60.h"

static uint8_t mac[6] = {0x54, 0x55, 0x58, 0x10, 0x00, 0x24};   // this just needs to be unique for your network,
// so unless you have more than one of these boards
// connected, you should be fine with this value.

static uint8_t ip[4] = {192, 168, 0, 106};                       // the IP address for your board. Check your home hub
// to find an IP address not in use and pick that
// this or 10.0.0.15 are likely formats for an address
// that will work.

static uint16_t port = 80;                                      // Use port 80 - the standard for HTTP

ETHER_28J60 ethernet;

void setup()
{
  ethernet.setup(mac, ip, port);
  pinMode(pir, INPUT);
  pinMode(ledAlarme, OUTPUT);
  pinMode(ledAtivo, OUTPUT);
  pinMode(buzzer, OUTPUT);
}

void loop()
{
 
  
  Serial.begin(9600);

  char* param;

  if (param = ethernet.serviceRequest())
  {
    if (strcmp(param, "desativar?token=o43DS89") == 0) {
      desativar();
      retornaStatus();
    } else {
      if (strcmp(param, "ativar?token=o43DS89") == 0) {
        ativar();
        retornaStatus();
      } else if (strcmp(param, "status?token=o43DS89") == 0){
        retornaStatus();
      }
    }
    return;
  }

  if (alarmeAtivo && !intrusoDetectado) {

    movimento = digitalRead(pir);

    if (movimento == 1) {
      alertar();
    }

  }

  delay(50);
}

void alertar() {
  Serial.println("Alertado!");
  intrusoDetectado = 1;
  digitalWrite(ledAlarme, HIGH);
  tone(buzzer, 200);
}

void ativar() {
  alarmeAtivo = 1;
  intrusoDetectado = 0;
//  Serial.println("Alarme ativado!");
  digitalWrite(ledAtivo, HIGH);
}

void desativar() {
//  Serial.println("Alarme desativado!");
  digitalWrite(ledAlarme, LOW);
  digitalWrite(ledAtivo, LOW);
  intrusoDetectado = 0;
  alarmeAtivo = 0;
  noTone(buzzer);
}

void retornaStatus() {
  //  ethernet.print("HTTP/1.1 200 OK\r\n");
  //  ethernet.print("Content-Type: application/json;charset=utf-8\r\n");
  //  ethernet.print("Server: Arduino\r\n");
  //  ethernet.print("Connection: close\r\n");
  if (alarmeAtivo) {
    ethernet.print("{\"ativo\":1}");
  } else {
    ethernet.print("{\"ativo\":0}\r\n");
  }

  ethernet.respond();
}
