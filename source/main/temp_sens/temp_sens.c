#include <stdio.h>
#include <stdlib.h>
#include <wiringPi.h>

#define DS18B20_PIN 7  // GPIO4

int main(void) {
    int data[5];
    float temperature;
    FILE *fp;

    if (wiringPiSetup() == -1) {
        printf("Error: WiringPi setup failed\n");
        return 1;
    }

    while (1) {
        system("sudo /usr/bin/tee /sys/bus/w1/devices/28-*/w1_slave > /dev/null");
        fp = fopen("/sys/bus/w1/devices/28-*/w1_slave", "r");
        if (fp == NULL) {
            printf("Error: Failed to open file\n");
            return 1;
        }
        fseek(fp, 69, SEEK_SET);
        fscanf(fp, "%d", &data[0]);
        fclose(fp);

        temperature = (float)data[0] / 1000;
        printf("Temperature: %.2f C\n", temperature);

        delay(1000);
    }

    return 0;
}
