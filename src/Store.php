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

    }



?>
