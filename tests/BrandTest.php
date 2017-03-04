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

        function test_addAndGetBrandStores()
        {
            $name = "Adidas";
            $new_brand = new Brand($name);
            $new_brand->save();
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

            $new_brand->addStore($new_store);
            $new_brand->addStore($new_store2);
            $result = $new_brand->getStores();

            $this->assertEquals([$new_store, $new_store2], $result);
        }

        function test_delete()
        {
            $name = "Adidas";
            $new_brand = new Brand($name);
            $new_brand->save();
            $name2 = "New Balance";
            $new_brand2 = new Brand($name2);
            $new_brand2->save();

            $new_brand->delete();
            $result = Brand::getAll();

            $this->assertEquals([$new_brand2], $result);
        }

        function test_update()
        {
            $name = "Adidas";
            $new_brand = new Brand($name);
            $new_brand->save();
            $new_name = "Nike";

            $new_brand->update($new_name);

            $this->assertEquals($new_name, $new_brand->getName());
        }

        function test_removeStore()
        {
            $name = "Adidas";
            $new_brand = new Brand($name);
            $new_brand->save();
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

            $new_brand->addStore($new_store);
            $new_brand->addStore($new_store2);
            $new_brand->removeStore($new_store);
            $result = $new_brand->getStores();

            $this->assertEquals([$new_store2], $result);
        }

        function test_removeAllStores()
        {
            $name = "Adidas";
            $new_brand = new Brand($name);
            $new_brand->save();
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

            $new_brand->addStore($new_store);
            $new_brand->addStore($new_store2);
            $new_brand->removeAllStores();
            $result = $new_brand->getStores();

            $this->assertEquals([], $result);
        }

        function test_getAvailableStores()
        {
            $name = "Adidas";
            $new_brand = new Brand($name);
            $new_brand->save();
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

            $new_brand->addStore($new_store);
            $result = $new_brand->getStoresAvailable();

            $this->assertEquals([$new_store2], $result);
        }

    }


?>
