TL;DR
-----

This plug-in enables a shortcode hook (i.e., [AB]) for an A-B test based on locally-stored HTML files. It makes use of a mySQL DB to keep track of user interaction by logging what files are displayed and counting user actions post-loading. The plug-in automatically records what file it displays. The logging of additional user-interaction, however, requires you to make use of an AJAX call.

This plug-in is licensed under an MIT licence. 

Usage
--------------

Placing the shortcode [AB] on a Wordpress post or page will result in the random display of pre-loaded content and tracking of user interaction. See Customization below. 


Customization
--------------

Edit the contents of the "options" directory to include as many HTML files as you like. The plug-in will randomly display the contents of a single file, log that it has displayed this file, and count the number of "clicks" made on its content. The name of the file will be used as its identifier in the database.

To count clicks in your HTML files, call the javascript function "logClick." You need to pass the content identifier (the file's name) to the function. To do this automatically, you can echo the $content variable from the plug-in function. For example: 

```
onClick="logClick('<?php echo $content ?>');"
```   

Installation 
-------------

Create a mySQL database named "abtest". Presumably, you could use the same mySQL server as your Wordpress install.

**SQL:**
```
CREATE database abtest;
```

Create a table in the "abtest" database, with columns for the content name (content), display count (displayed), and click count (clicked). 

**SQL:**
```
CREATE TABLE `abtest`.`test_results` (
  `content` VARCHAR(25) NOT NULL,
  `displayed` INT NULL,
  `clicked` INT NULL,
  PRIMARY KEY (`content`));
```

Hard-code your database credentials into the config.php file found in this plug-in's lib/ directory. 

**lib/confog.php:**
```
# Hard-code your DB's credentials into the line below. 
$dbh = new PDO("mysql:host=localhost;dbname=abtest", "[user]", "[password]");
```

Upload the plug-in folder "A-B" to [yoursite]/wp-content/plugins/ and activate the "A-B" plugin as you would any other Wordpress plugin. 

**It is very important that you maintain the standard directory structure. If the plugin does not reside at: [yoursite]/wp-content/plugins/A-B/ it will not work.** 


Reviewing Your Data
--------------------

To review your data, you will need to interrogate your DB. For example: 

```
SELECT * from abtest.test_results;
```

You may find it useful to compare the ratio of clicks to views using something like this:

```
SELECT *, clicked/displayed AS ratio from abtest.test_results ORDER BY ratio DESC;
```
