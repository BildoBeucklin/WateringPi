# Watering Pi Web Interface Setup Guide

This guide will walk you through setting up a web interface for your watering pi project.

## Step 1 Set Up Server

### Install Apache2

To install Apache2 on a Raspberry Pi, first open up the terminal window and enter the following command:

```bash
sudo apt-get install apache2 php7.4 php7.4-mysqli php7.4-mbstring
```

### Copy the HTML file
Next, copy the HTML file containing the code for the Raspberry Pi project into the /var/www/html directory. This is the directory where Apache2 will be serving the web page from.

### Configure Apache2
Next, open up the Apache2 configuration file with the command:
```bash
sudo nano /etc/apache2/apache2.conf
```
In the configuration file, add the following line at the end:
```xml
<Directory /var/www/html> 
  AllowOverride All
</Directory>
```
Save the configuration file and restart Apache2 with the following command:
```bash
sudo service apache2 restart
```
 

## Step 2 Set Up database

### Install and Start MySQL Server

Install MySQL Server using the following command:

```bash
sudo apt install mysql-server
sudo systemctl start mysql.service
````
### Set Up MySQL

```bash
sudo mysql
```
```sql
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'teamb';
exit
```
### Secure MySQL Installation
Run the MySQL Secure Installation script:
```bash
sudo mysql_secure_installation
```
Answer 'no' to all questions to keep the default settings.

### Update Root User Authentication Method
Access the MySQL command line interface again:
```bash
sudo mysql
```
Update the root user's authentication method:
```sql
ALTER USER 'root'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'teamb';
```

### Create Database and Tables
Log in to MySQL with the root user:
```bash
mysql -u root -p
```
Create a new database:
```sql
CREATE DATABASE PiProjectWateringPlant;
```
Switch to the newly created database:
```sql
USE PiProjectWateringPlant;
```
Create a table for storing sensor data:
```sql
CREATE TABLE tblSensorData (
    SensorID varchar(255),
    Data int
);

INSERT INTO tblSensorData (SensorID, Data) VALUES ("TEMSEN", 10);
INSERT INTO tblSensorData (SensorID, Data) VALUES ("LIGSEN", 10);
INSERT INTO tblSensorData (SensorID, Data) VALUES ("MOISEN", 10);
```

## Step 3 Set Up Cron

### Install Postfix

Postfix is a mail transfer agent used for sending emails, which can be useful for notifications or alerts.

```bash
sudo apt install postfix
```

### Set up Cron Jobs
Cron is a time-based job scheduler used to automate repetitive tasks. We'll use it to schedule periodic execution of PHP scripts.

```bash
sudo crontab -e
```

Add the following lines to the crontab file:

```bash
SHELL=/bin/bash
MAILTO=""

# Run get_adc_values.php every minute and log output
* * * * * /usr/bin/php -f /var/www/html/get_adc_values.php >> /var/www/html/get_values.log 2>&1

# Run make_picture.php every 10th minute of every hour and log output
10 * * * * /usr/bin/php -f /var/www/html/make_picture.php >> /var/www/html/take_photos.log 2>&1
```

