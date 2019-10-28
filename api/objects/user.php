<?php
    class User {
        private $conn;
        private $table_name = "users";

        public $id;
        public $name;
        public $email;
        public $password;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function login($email, $password) {
            $query = "select * from ".$this->table_name." where email=".$email." and password=".$password;
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute()){
                return true;
            } else {
                return false;
            }
        }

        function emailExists(){

            // query to check if email exists
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";

            // prepare the query
            $stmt = $this->conn->prepare( $query );

            // sanitize
            $this->email=htmlspecialchars(strip_tags($this->email));

            // bind given email value
            $stmt->bindParam(1, $this->email);

            // execute the query
            $stmt->execute();

            // get number of rows
            $num = $stmt->rowCount();

            // if email exists, assign values to object properties for easy access and use for php sessions
            if($num>0){

                // get record details / values
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // assign values to object properties
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->password = $row['password'];

                // return true because email exists in the database
                return true;
            }

            // return false if email does not exist in the database
            return false;
        }
    }