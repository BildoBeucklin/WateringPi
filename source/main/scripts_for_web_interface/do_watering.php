#!/usr/bin/php -q
<?php
shell_exec("php /var/www/html/get_adc_values.php");
date_default_timezone_set('CET');
//mysql server
$servername = "localhost";
$username = "root";
$password = "teamb";

$dbname = "PiProjectWateringPlant";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$sensor_ID = 'MOISEN';
$query = "SELECT Data From tblSensorData WHERE SensorID = '$sensor_ID'";
$arr = $conn->query($query)->fetch_assoc();
var_dump($arr);
extract($arr);
$moist = (int)$Data;
$watering_start = 1000;
$watering_goal = 1005;

if ($moist < $watering_start) {
	
echo "Start Watering: \n";
	$DATE=date("Y-m-d H:i:s"); 
	
	while ($moist <  $watering_goal) {
	$DATE=date("Y-m-d_H:i:s");  
	shell_exec("raspi-gpio set 2 op dh");
	shell_exec("php /var/www/html/get_adc_values.php");
	$arr = $conn->query($query)->fetch_assoc();
	extract($arr);
	$moist = (int)$Data;
	echo "Moisture: $moist \r";	
	sleep(1); 
	}
	
echo "Last Time Watering: $DATE CET\n";
shell_exec("raspi-gpio set 2 op dl");
$conn->close();
}
else $conn->close();
shell_exec("raspi-gpio set 2 ip");
echo "complete\n";

