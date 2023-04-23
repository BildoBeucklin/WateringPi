#!/usr/bin/php -q
<?php
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
$sensor_ID = 'LIGSEN';
$query = "SELECT Data From tblSensorData WHERE SensorID = '$sensor_ID'";
$light = $conn->query($query)->fetch_assoc();
$conn->close();
var_dump($light);
extract($light);
$light = (int)$Data;

if ($light>1000) {

date_default_timezone_set('CET');
$DATE=date("Ymd_H-i-s");   
shell_exec("/usr/bin/raspistill -rot 0 -q 70 -w 600 -h 400 -n -o /var/www/html/photos/image$DATE.jpg");
echo "Making picture is done. \n";

exec("/var/www/html/make_timelapse /var/www/html/photos");
 
echo "\n ##################### \n Timelapse ready for download. \n ###################### \n";
}

?>
