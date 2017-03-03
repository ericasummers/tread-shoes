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

    class StoreTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function test_saveAndGetAll()
        {
            $name = "Shoetopia";
            $address = "12 Water St, Portland, OR 97219";
            $phone_number = "503-990-8876";
            $new_store = new Store($name, $address, $phone_number);
            $new_store->save();

            $result = Store::getAll();

            $this->assertEquals([$new_store], $result);
        }

        function test_find()
        {
            $name = "Shoetopia";
            $address = "12 Water St, Portland, OR 97219";
            $phone_number = "503-990-8876";
            $new_store = new Store($name, $address, $phone_number);
            $new_store->save();
            $name2 = "Best Shoe Deals";
            $address2 = "9 Best St, Portland, OR 97201";
            $phone_number2 = "503-112-5567";
            $new_store2 = new Store($name2, $address2, $phone_number2);
            $new_store2->save();

            $result = Store::find($new_store2->getId());

            $this->assertEquals($new_store2, $result);
        }

        function test_addAndGetStoreBrands()
        {
            $name = "Shoetopia";
            $address = "12 Water St, Portland, OR 97219";
            $phone_number = "503-990-8876";
            $new_store = new Store($name, $address, $phone_number);
            $new_store->save();
            $name = "Adidas";
            $new_brand = new Brand($name);
            $new_brand->save();
            $name2 = "New Balance";
            $new_brand2 = new Brand($name2);
            $new_brand2->save();

            $new_store->addBrand($new_brand);
            $new_store->addBrand($new_brand2);
            $result = $new_store->getBrands();

            $this->assertEquals([$new_brand, $new_brand2], $result);
        }

        function test_delete()
        {
            $name = "Shoetopia";
            $address = "12 Water St, Portland, OR 97219";
            $phone_number = "503-990-8876";
            $new_store = new Store($name, $address, $phone_number);
            $new_store->save();
            $name2 = "Best Shoe Deals";
            $address2 = "9 Best St, Portland, OR 97201";
            $phone_number2 = "503-112-5567";
            $new_store2 = new Store($name2, $address2, $phone_number2);
            $new_store2->save();

            $new_store->delete();
            $result = Store::getAll();

            $this->assertEquals([$new_store2], $result);
        }






    }


?>
