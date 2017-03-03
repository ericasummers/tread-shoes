# _Tread Shoes Database Project_

#### _This web page allows a user to manage a list of shoe stores and brands, 3 March 2017_

#### By _**Erica Wright**_

## Description

_This web page allows a user to input a new shoe store, view a list of current stores, and edit or delete stores as needed. It also allows a user to input shoe brands, and search brands by store as well as display a list of brands for each store._

## Setup/Installation Requirements

* Ensure [composer](https://getcomposer.org/) is installed on your computer.

* In terminal run the following commands:

1. _Fork and clone this repository from_ [gitHub]https://github.com/ericaw21/tread-shoes.
2. Navigate to the root directory of the project in which ever CLI shell you are using and run the command: `composer install`.
3. To run tests enter `composer test` in terminal.
4. Start server with MAMP and make sure your mySQL server is set to 3306.
5. Open phpMyAdmin and import the database zip files named shoes.sql.zip and shoes_test.sql.zip located in the project folder to import the databases needed.
6. Create a local server in the /web directory within the project folder using the command: php -S localhost:8000 (assuming you are using a mac), or php -S localhost:8888 (if using windows). {Note: This step is not necessary if Apache server is working correctly with htaccess file.}
7. Open the directory http://localhost:8000/ (if on a mac) or http://localhost:8888/ (if on windows pc) in any standard web browser.

## Specifications

|    *Behavior*   |    *Input*    |     *Output*    |
|-----------------|---------------|-----------------|
|A user clicks on a store|Click "Shoetopia"|"Shoetopia" page appears with a list of shoe brands it carries|
|A user clicks on a brand|Click "Adidas"|"Adidas" page appears with information and a list of stores that carry this brand|
|A user enters a new store|Enter "Shoetopia, 12 Water St, Portland, OR, 503-990-8876"|Stores page updates with "Shoetopia" listed, database saves new entry in table|
|A user enters a new brand|Enter "Adidas"|Brands page updates with "Adidas" listed, database saves new entry in table|
|A user clicks "Delete" on button for store or brand|Click "Delete" on store or brand button|Page reloads with selected entry removed, entry removed from database|
|A user clicks "Update" on button for store|Click "Update" next to store name "Shoetopia", update to "Shoe World"|Store page reloads with updated "Shoe World" name listed|
|A user clicks "Delete All" button on stores or brands page| Click "Delete All" button|All stores list or all brands list cleared and removed from database|
|A user adds a brand to a store|Click "Add to store" next to selected brand|Brands list for store updates and database is updated|
|A user adds a store to a brand|Click "Add to brand" on brand page next to selected store|Brands page updates listed stores and database is updated|
|A user removes a brand from a store|Click "Remove brand" next to selected brand|Brands list for store updates and database is updated|
|A user removes a store from a brand|Click "Remove store" on brand page next to selected store|Brands page updates listed stores and database is updated|

## MySQL Commands Used

| *Command Text* | *Action* |
|----------------|----------|
| "SHOW DATABASES;"| Displays list of databases|
| "CREATE DATABASE shoes;"|Creates shoes production database|
| "CREATE DATABASE shoes_test;"|Creates shoes test database|
|"USE shoes;" and "USE shoes_test"|Attaches action to that database|
|"CREATE TABLE stores (id serial PRIMARY KEY, name VARCHAR (255), address VARCHAR (255), phone_number VARCHAR (20));"|Creates table within selected database with specified column types|
|"CREATE TABLE brands (id serial PRIMARY KEY, name VARCHAR (255));"|Creates table within selected database with specified column types|
|"CREATE TABLE stores_brands (id serial PRIMARY KEY, store_id INT, brand_id INT);"|Creates table within selected database with specified column types|
|"SHOW TABLES;"|Displays tables contained within selected database|
|"SELECT * FROM stores;"|Queries and displays all entries contained within a table|
|"SELECT * FROM brands ORDER BY name;"|Queries and displays all entries contained within a table and orders alphabetically by column selected|
|"INSERT IGNORE INTO brands (name) VALUES ('Adidas');"|Enters new values into table with information in parentheses, if not already existing in table|
|"DELETE FROM stores;"|Removes all entries within stores table in database|
|"DELETE FROM stores_brands WHERE brand_id = 2;"|Removes all entries within stores_brands table in database with the brand_id of 2|
|"UPDATE stores SET name = 'Shoe World', address = '21 Water St, Portland, OR', phone_number = '971-234-6789' WHERE id = 1;"|Updates values for database entry with id 1 with the new values given|

## Known Bugs

_None so far._

## Support and contact details

_Please contact ericaw21@gmail.com with concerns or comments._

## Technologies Used

* _Composer_
* _CSS_
* _HTML_
* _MySQL_
* _PHP_
* _PHPUnit_
* _Silex_
* _Twig_

### License

*MIT license*

Copyright (c) 2017 **Erica Wright** All Rights Reserved.
