<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost:3306;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function test_saveAndGetAll()
        {
            $name = "Adidas";
            $new_brand = new Brand($name);
            $new_brand->save();

            $result = Brand::getAll();

            $this->assertEquals([$new_brand], $result);
        }

        function test_find()
        {
            $name = "Adidas";
            $new_brand = new Brand($name);
            $new_brand->save();
            $name2 = "New Balance";
            $new_brand2 = new Brand($name2);
            $new_brand2->save();

            $result = Brand::find($new_brand2->getId());

            $this->assertEquals($new_brand2, $result);
        }







    }


?>
