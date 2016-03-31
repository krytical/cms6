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
cd xampp/htdocs/Symfony/
git clone this repo
cd cms6
composer install (If prompted for input just hit return a bunch of times)
```
-----You're done!--------

**RUNNING SERVER (XAMPP)**

- start appache server and MYSQL in XAMPP 

- in the terminal: 
`php app/console server:run`

- go to http://localhost:8000/

**SETTING UP YOUR DATABASE**

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

**RUNNING MIGRATIONS** (https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html)

- make sure app/AppKernel.php has the following:
```
public function registerBundles()
{
    $bundles = array(
        //...
        new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
    );
}
```
- run the following in the command line: 
`composer require doctrine/doctrine-migrations-bundle "^1.0"`

If it errors out, you may have to update the php version in composer.json
```
"config": {
        "bin-dir": "bin",
        "platform": {
            "php": "7.0.2"
        }
    }
```
- you should now be able to apply migrations: 
`php app/console doctrine:migrations:migrate`

- check http://localhost/phpmyadmin/ to make sure the tables were properly created

**MIGRATION COMMANDS**
```
doctrine:migrations
  :diff     Generate a migration by comparing your current database to your mapping information.
  :execute  Execute a single migration version up or down manually.
  :generate Generate a blank migration class.
  :migrate  Execute a migration to a specified version or the latest available version.
  :status   View the status of a set of migrations.
  :version  Manually add and delete migration versions from the version table.
```

**CHANGING TABLES / CREATING MIGRATIONS**

- Create a table with the following command: 
`php app/console doctrine:generate:entitiy`

After editing DB tables, make sure to do the following:

- Generate the getter/setter methods using the following command (or write them manually): 
`php app/console doctrine:generate:entities AppBundle`

- Generate and apply the new migration scripts (WARNING: YOU COULD LOSE DATA THAT'S STORED IN THE DB):
```
php app/console doctrine:migrations:diff
php app/console doctrine:migrations:migrate
```

**FOSuserbundle Setup**

You can find more detailed instructions here: https://symfony.com/doc/master/bundles/FOSUserBundle/index.html

To download FOSUserBundle use composer:
```
composer require friendsofsymfony/user-bundle "~2.0@dev"
```

loginBranch has already setup the AppKernel.php, routing, config and security.yml parts

Visit http://localhost/Symfony/cms6/web/app_dev.php/login to see the login page (will look very ugly right now).

You may need to update your database to use the already created test account:
Username: usertest
Password: passtest

**VichUploader Setup**

Go to https://github.com/dustin10/VichUploaderBundle/blob/master/Resources/doc/installation.md


**CREATE DEFAULT ADMIN USER**

Download the fixtures bundle
(write this into your terminal or command prompt window)
composer require --dev doctrine/doctrine-fixtures-bundle

Load the admin user fixture
(write this into your terminal or command prompt window)
php app/console doctrine:fixtures:load

* this will delete all existing user records. If there are any records you'd like to keep enter this instead
php app/console —append doctrine:fixtures:load



