<img src="https://github.com/blekerfeld/serviz/blob/master/library/staticimages/logo.png?raw=true" width="400">

### Serviz

Out of frustration with free versions of survey software like SurveyMonkey, I started this project in order to easily create translation experiments (with sound files) for linguistic research. Momentarily it builds the survey out of the database, but I plan to create an admin panel later on.

It will (partly already is) also be capable of easily coding the data (grouping participants et cetera) and exporting it to csv for statistical analysis.

The code base of Serviz is based upon another project of mine, Donut: the dictionary toolkit, with all dictionary stuff taken out. 

### Requirements

* PHP 5.6+ (ideally PHP 7+), might work with PHP 5.4+ (not tested)
* MySQL or MariaDB-server

### Installation

Please note that Serviz still lacks a lot of features. At this moment you should only install Serviz if you want to take a look at its progress.

* Clone the git repository to a web server (alternativly just download its contents)
* Run `composer install` in the Serviz directory.
* Edit Configuration.php-template to fit your configuaration (database usernames etc.) and save it as `Configuration.php` (important)
* Import `Database.sql` to the database
* It should work now.


#### Test account
**Username**: Serviz
**Password**: yeast
