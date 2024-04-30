# Watering Pi Web Interface Setup Guide

This guide will walk you through setting up a web interface for your watering pi project.

## Step 1: Install Postfix

Postfix is a mail transfer agent used for sending emails, which can be useful for notifications or alerts.

```bash
sudo apt install postfix
```

##Step 2: Set up Cron Jobs
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

