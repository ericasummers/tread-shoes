<?php

    class Store
    {
        private $id;
        private $name;
        private $address;
        private $phone_number;

        function __construct($name, $address, $phone_number, $id = null)
        {
            $this->name = $name;
            $this->address = $address;
            $this->phone_number = $phone_number;
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

        function getAddress()
        {
            return $this->address;
        }

        function setAddress($new_address)
        {
            $this->address = (string) $new_address;
        }

        function getPhoneNumber()
        {
            return $this->phone_number;
        }

        function setPhoneNumber($phone_number)
        {
            $this->phone_number = (string) $phone_number;
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
            $GLOBALS['DB']->exec("INSERT IGNORE INTO stores (name, address, phone_number) VALUES ('{$this->getName()}', '{$this->getAddress()}', '{$this->getPhoneNumber()}');");

            $query = $GLOBALS['DB']->query("SELECT id FROM stores WHERE name = '{$this->getName()}';");
            $rs = $query->fetchAll(PDO::FETCH_ASSOC);
            $this->id = $rs[0]['id'];
        }

        static function getAll()
        {
            $all_stores = array();
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            foreach($returned_stores as $store) {
                $name = $store['name'];
                $address = $store['address'];
                $phone_number = $store['phone_number'];
                $id = $store['id'];
                $new_store = new Store($name, $address, $phone_number, $id);
                array_push($all_stores, $new_store);
            }
            return $all_stores;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
            $GLOBALS['DB']->exec("DELETE FROM stores_brands;");
        }

        static function find($search_id)
        {
            $found_store = null;
            $query = $GLOBALS['DB']->query("SELECT * FROM stores WHERE id = {$search_id};");
            $rs = $query->fetchAll(PDO::FETCH_ASSOC);
            $name = $rs[0]['name'];
            $address = $rs[0]['address'];
            $phone_number = $rs[0]['phone_number'];
            $id = $rs[0]['id'];
            return $found_store = new Store($name, $address, $phone_number, $id);
        }

        function addBrand($new_brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO stores_brands (store_id, brand_id) VALUES ({$this->getId()}, {$new_brand->getId()});");
        }

        function getBrands()
        {
            $all_store_brands = array();
            $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN stores_brands ON (stores_brands.store_id = stores.id) JOIN brands ON (brands.id = stores_brands.brand_id) WHERE stores.id = {$this->getId()};");
            foreach($returned_brands as $brand) {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($all_store_brands, $new_brand);
            }
            return $all_store_brands;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$this->getId()};");
        }

        function update($new_name, $new_address, $new_phone_number)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}', address = '{$new_address}', phone_number = '{$new_phone_number}' WHERE id = {$this->getId()};");
            $this->name = $new_name;
            $this->address = $new_address;
            $this->phone_number = $new_phone_number;
        }

        function removeBrand($brand)
        {
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE brand_id = {$brand->getId()} AND store_id = {$this->getId()};");
        }

        function removeAllBrands()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$this->getId()};");
        }


    }



?>
