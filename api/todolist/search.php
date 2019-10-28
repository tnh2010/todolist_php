<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once __DIR__ . '/../config/database.php';
    include_once __DIR__ . '/../objects/todoes.php';

    $database = new Database();
    $db = $database->getConnection();

    $todo = new Todoes($db);
    $value_search = $_GET["value"];
    if (!empty($value_search)){
        $stmt = $todo->search($value_search);
        $rowCount = $stmt->rowCount();
        $todo_array = array();
        $todo_array["records"] = array();
        if ($rowCount > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $todo_item = array(
                    "id" => $row["id"],
                    "name" => $row["name"],
                    "user_id" => $row["user_id"],
                    "note" => $row["note"],
                    "status" => $row["status"],
                );
                array_push($todo_array["records"], $todo_item);
            }
        }
        echo json_encode($todo_array, 200);
    } else {
        echo json_encode(["message"=>"Validate value search", 402]);
    }
