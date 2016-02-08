# cms6 CS319 Project

**VERSIONS**

XAMPP/PHP (Download PHP 7.0.2 version!):

Windows: https://www.apachefriends.org/xampp-files/7.0.2/xampp-win32-7.0.2-1-VC14-installer.exe

Mac: https://www.apachefriends.org/xampp-files/7.0.2/xampp-osx-7.0.2-1-installer.dmg

Symfony: 2.8

**SETUP INSTRUCTIONS**

- download and setup XAMPP

- in the XAMPP console terminal:
```
cd xampp/htdocs/Symfony/
php -r "readfile('https://symfony.com/installer');" > symfony
php symfony
```
- download composer (https://getcomposer.org/download/)

- reboot your system!

- in the terminal:
```
cd to C:/xampp/htdocs/Symfony/
git clone this repo
cd <cms6 project folder>
composer install (If prompted for input just hit return a bunch of times)
```
-----You're done!--------

RUNNING SERVER

- start appache server and MYSQL in XAMPP 

- go to http://localhost/symfony/cms6/web/

SETTING UP YOUR DATABASE (XAMPP)

- uncomment the following line in your php.ini file:
`extension=php_pdo_mysql.dll`

- make sure your app/config/parameters.yml file looks like this:
```
parameters:
    database_driver: pdo_mysql
    database_host: localhost
    database_port: null
    database_name: cms6
    database_user: root
    database_password: null
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt
```
- run the following in the command line:
`php app/console doctrine:database:create`

- go to localhost/phpmyadmin then cms6->operations. Set collation to utf8_general_ci. Click Go
