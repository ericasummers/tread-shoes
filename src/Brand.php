<?php

    class Brand
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = $new_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT IGNORE INTO brands (name) VALUES ('{$this->getName()}');");

            $query = $GLOBALS['DB']->query("SELECT id FROM brands WHERE name = '{$this->getName()}';");
            $rs = $query->fetchAll(PDO::FETCH_ASSOC);
            $this->id = $rs[0]['id'];
        }

        static function getAll()
        {
            $all_brands = array();
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            foreach($returned_brands as $brand) {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($all_brands, $new_brand);
            }
            return $all_brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
            $GLOBALS['DB']->exec("DELETE FROM stores_brands;");
        }

        static function find($search_id)
        {
            $found_brand = null;
            $query = $GLOBALS['DB']->query("SELECT * FROM brands WHERE id = {$search_id};");
            $rs = $query->fetchAll(PDO::FETCH_ASSOC);
            $name = $rs[0]['name'];
            $id = $rs[0]['id'];
            return $found_brand = new Brand($name, $id);
        }

        function addStore($new_store)
        {
            $GLOBALS['DB']->exec("INSERT INTO stores_brands (store_id, brand_id) VALUES ({$new_store->getId()}, {$this->getId()});");
        }

        function getStores()
        {
            $all_brand_stores = array();
            $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands JOIN stores_brands ON (stores_brands.brand_id = brands.id) JOIN stores ON (stores.id = stores_brands.store_id) WHERE brands.id = {$this->getId()};");
            foreach($returned_stores as $store) {
                $name = $store['name'];
                $address = $store['address'];
                $phone_number = $store['phone_number'];
                $id = $store['id'];
                $new_store = new Store($name, $address, $phone_number, $id);
                array_push($all_brand_stores, $new_store);
            }
            return $all_brand_stores;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE brand_id = {$this->getId()};");
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->name = $new_name;
        }

        function removeStore($store)
        {
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$store->getId()} AND brand_id = {$this->getId()};");
        }

        function removeAllStores()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE brand_id = {$this->getId()};");
        }

    }

?>
