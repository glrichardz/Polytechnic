# Physical Card Sort Project
The Physical Card Sort Project has addressed the lack of research based physical card sorting application and have successfully built an open-source system to recognise and analyse card placement, groupings and rankings across different sorting scenarios.

## Install
Note: This install is for Ubuntu 14.04, we recommend using DigitalOcean and launching a LAMP stack application.
Note: We have split this installation into seperate commands to run so it can be easily seen what is being installed, as this may very from distro to distro, and while the packages will remain, their commands may change.

### Requirements
Ubuntu 14.04 or Linux distro capable of running a LAMP stack. (Linux, Apache, MySQL, Apache)

### Installation
How to install the Physical Card Sort project is listed below, follow the steps one by one.

**Update to latest package lists**

    sudo apt-get update

**Apache 2 Install**

    sudo apt-get install apache2

**MySQL Install**

    sudo apt-get install mysql-server libapache2-mod-auth-mysql php5-mysql

**MySQL Database Activation**

    sudo mysql_install_db

**Optional: Database Secure Script**

Note: If you are using an outside server to host the Database, make sure you don't 'Disallow root login remotely'

    sudo /usr/bin/mysql_secure_installation

**PHP Install**

    sudo apt-get install php5 libapache2-mod-php5 php5-mcrypt php5-mysql

**Unzip Github Contents into:**

    /var/www/html
    
**Delete Index.html**

    /var/www/html/index.html

**Login to MySQL**

    mysql -u root -p
  
**Create Database**

    CREATE DATABASE physicalcarddb;
    
**Exit MySQL**

    quit

**Input MySQL Details**

    /var/www/html/connect/connect.inc.php
    Edit the 'USERNAME' and 'PASSWORD' lines to reflect your settings.
    
    /var/www/html/card.py
    Line 6, Edit the 'USERNAME' and 'PASSWORD' lines to reflect your settings.
    
**Initialise physicalcarddb tables**

    Visit http://SERVERIP/setup.php

**If errors appear, check the connection to the database**

**Delete setup.php**

    rm -r /var/www/html/setup.php

**Install Packages**

    sudo apt-get install ipython
    sudo apt-get install python-pip
    sudo apt-get install python-opencv
    sudo apt-get install python-scipy
    sudo apt-get install python-numpy
    sudo apt-get install python-pygame
    sudo apt-get install python-setuptools
    sudo apt-get install mysql-python
    sudo apt-get install python-qrtools
    
    
**Install SimpleCV**

    sudo pip install https://github.com/sightmachine/SimpleCV/zipball/develop

**Install Dependencies**

    sudo pip install svgwrite mysql-connector-python --allow-external mysql-connector-python


**Edit the "/etc/apache2/sites-available/000-default.conf" file and place the following code within the virtual host section.**

    php_value display_errors On
    php_value display_startup_errors On
    php_value post_max_size 1073741824
    php_value upload_max_filesize 1073741824
    php_value memory_limit 1073741824
    php_value max_input_time 10000
    
**Grant Permissions**

While this is unsecure for a lot of reasons, this project isn't designed to be front facing on the web or be used regularly.

    chmod -R 777 /var/www/html

#### The System is now Ready for Use.

##Usage
The system is very straight forward and hold protections against false data and incorrect card entiries making the overall system hard to break for the average user.

**Create Experiment**

![alt tag](http://i.imgur.com/mA4yahs.png)

On this page, you enter an experiment name, under that you choose the Method to which the cards sort by.

    Ranking - The Ranking Method helps the system understand that you are ranking from left to right, row by row. (Future Implmentation will include erroring on blank spots between card placements to ensure proper ranking.
    
    Pairs - The Pairs Method makes sure to enforce an even amount of numbers to be entered into the system. (Future Implementation will identify pairs and properly show them in the .csv results
    
    (Future Implementation includes Groupings)
    
You enter the Card Description for the writing you want displayed on the card and use the '+' green button on the left to add more cards. The System is built to handle 50 cards.

Once submitted, the page returns you an ExperimentID Number.

The ExpeirmentID Number allows you to access the rest of the website and submit and recieve data.
    
**Get Cards**

![alt tag](http://i.imgur.com/sD6onoe.png)

The Get Cards page allows users to enter their experiment and display their statements on cards which can be printed off via Ctrl+P, but for best results, use a snipping or screenshot tool to paste the cards into a document which you can print out.

We recommend having them at the same size that you see them on screen, around the size of a playing card to achieve the best results.

**Run Experiment**

![alt tag](http://i.imgur.com/ky0dZFf.png)

The Run Experiment page allows users to enter the ExperimentID Number they were given when they registered their Experiment, then to enter the subject's age and gender, and the image of the 10x5 grid the cards are laid out upon.

The System takes the image and splits it into 50 rectangles, before using a grayscale to bring out the QR codes on each card  to which it then scans each image for the QR codes, before it submits any data, it makes sure that the amount of cards it has found is the same amount that the experiment has.

This system takes around 15 seconds over all for <5 cards. It may take slightly longer depending on how many cards are active.

**Get Results**

![alt tag](http://i.imgur.com/9xRYlXS.png)

As per the other pages, Get Results asks you to enter the ExperimentID, to which it gives you a .csv file print out of the data in a format which can be analysed. 

(Future Implementation includes much more customized .csv files depending on the method used to analyse the cards as well as hopefully graph implementation.


## Credits

**SimpleCV - https://github.com/sightmachine/simplecv**

**QR Tools - https://launchpad.net/qr-tools**

**Apache2 - https://httpd.apache.org/**

**PHP - https://www.php.net/**

**MySQL - https://www.mysql.com/**

**Other packages are included with the above links as requirements to run.**



