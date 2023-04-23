#!/usr/bin/php -q
<?php
// open usb
$fp =fopen("/dev/ttyACM0", "w+");
if( !$fp) {
        echo "Error";die();
}
//save Data 
$sensor_buffer = fread($fp, 100);
$sensor_data = explode(";", $sensor_buffer);

fclose($fp);

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
$stmt = $conn->prepare("UPDATE tblSensorData SET  Data = ? WHERE SensorID = ?");
$stmt->bind_param("is", $update_value, $sensor_ID);

// set parameters and execute

for($i=0; $i<count($sensor_data); $i++) {
  if (preg_match('/TEMSEN(\d+)/', $sensor_data[$i], $matches)) {
      $temp = mb_substr($matches[0],6,strlen($matches[0]));
  }
  if (preg_match('/LIGSEN(\d+)/', $sensor_data[$i], $matches)) {
      $light = mb_substr($matches[0],6,strlen($matches[0]));
  }
  if (preg_match('/MOISEN(\d+)/', $sensor_data[$i], $matches)) {
      $moist = mb_substr($matches[0],6,strlen($matches[0]));
  }
}

$update_value = $temp;
$sensor_ID = 'TEMSEN';
$stmt->execute();
$update_value = $light;
$sensor_ID = 'LIGSEN';
$stmt->execute();
$update_value = $moist;
$sensor_ID = 'MOISEN';
$stmt->execute();

echo " Temprature = $temp ,Light = $light ,Moisture = $moist \n completed \n";

$stmt->close();
$conn->close();

?>
