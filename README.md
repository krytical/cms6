# cms6 CS319 Project

VERSIONS

XAMPP/PHP (Download PHP 7.0.2 version!):

Windows: https://www.apachefriends.org/xampp-files/7.0.2/xampp-win32-7.0.2-1-VC14-installer.exe

Mac 32bit: https://www.apachefriends.org/xampp-files/7.0.2/xampp-linux-7.0.2-1-installer.run

Mac 64bit: https://www.apachefriends.org/xampp-files/7.0.2/xampp-linux-x64-7.0.2-1-installer.run

Symfony: 2.8

SETUP INSTRUCTIONS

- download and setup XAMPP

- in the XAMPP console terminal:

	cd to C:/xampp/htdocs/Symfony/

	php -r "readfile('https://symfony.com/installer');" > symfony

	php symfony

- download composer (https://getcomposer.org/download/)

- reboot your system!

- in the terminal:

	cd to C:/xampp/htdocs/Symfony/

	git clone this repo

	cd to cms6 (project folder)

	composer install (If prompted for input just hit return a bunch of times)

-----You're done!--------

RUNNING SERVER

- start appache server and MYSQL in XAMPP 

- go to http://localhost/symfony/cms6/web/
