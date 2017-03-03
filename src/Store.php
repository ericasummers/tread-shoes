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

            $query = $GLOBALS['DB']->query("SELECT id FROM stores WHERE name = '{$this->getName()}' AND address = '{$this->getAddress()}';");
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
        }

    }



?>