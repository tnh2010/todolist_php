<?php
    class Todoes {
        private $conn;
        private $table_name ="todoes";

        public $id;
        public $name;
        public $note;
        public $status;
        public $user_id;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function read(){
            // select all query
            $query = "select * from ".$this->table_name;
            $stmt = $this->conn->prepare($query);
            // Execute query
            $stmt->execute();
            return $stmt;
        }

        public function readOne(){
            $id = $_GET['id'];
            // select all query
            $query = "select * from ".$this->table_name." where id=".$id;
            $stmt = $this->conn->prepare($query);
            // Execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row["id"];
            $this->name = $row["name"];
            $this->user_id = $row["user_id"];
            $this->note = $row["note"];
            $this->status= $row["status"];
            return $row;
        }

        public function delete() {
            $query = "Delete from ".$this->table_name." where id=?";
            $stmt = $this->conn->prepare($query);
            $this->id=htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(1, $this->id); // 1 vi tri cua dau ?
            if ($stmt->execute()){
                return true;
            }
            return false;
        }

        public function create() {
             $query = "Insert into ".$this->table_name." set user_id=?, name=?, note=?, status=?";
            // $query = "Insert into ".$this->table_name." set user_id=:user_id, name=:name, note=:note, status=:status";
            // stmt->bindPram("::user_id", $this->user_id);
            $stmt = $this->conn->prepare($query);

            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->note = htmlspecialchars(strip_tags($this->note));
            $this->status = htmlspecialchars(strip_tags($this->status));

             $stmt->bindParam(1, $this->user_id);
             $stmt->bindParam(2, $this->name);
             $stmt->bindParam(3, $this->note);
             $stmt->bindParam(4, $this->status);
//            $stmt->bindParam(":user_id", $this->user_id);
//            $stmt->bindParam(":name", $this->name);
//            $stmt->bindParam(":note", $this->note);
//            $stmt->bindParam(":status", $this->status);
            if($stmt->execute()){
                return true;
            }
            return false;
        }

        public function search($value_search) {
            $query = "select * from ".$this->table_name. " where name like '%".$value_search."%' or note like '%".$value_search."%'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }