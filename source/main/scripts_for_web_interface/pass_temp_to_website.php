<?php

// Connect to the USB serial port
$usb = fopen("/dev/ttyUSB0", 'r+');

// Monitor the UART input stream
// Read data from the USB serial port
$uart_input = fread($usb,1024);

// Use regular expression to search for temperature value
if (preg_match('/TEMP(\d+)/', $uart_input, $matches)) {
    $temp = $matches[1];
}
 // Display the temperature value on your website
echo "The temperature is: " . $temp;

?>
