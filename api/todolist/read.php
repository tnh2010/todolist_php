<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once __DIR__ . '/../config/database.php';
    include_once __DIR__ . '/../objects/todoes.php';

    $database = new Database();
    $db = $database->getConnection();

    $todo = new Todoes($db);

    // Query todoes
    $stmt = $todo->read();
    $num = $stmt->rowCount();
    // Check if more than 0 record found
    if($num>0) {
        $todo_array = array();
        $todo_array["records"] = array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $todo_item = array(
                "id" => $id,
                "name" => $name,
                "user_id" => $user_id,
                "note" => $note,
                "status" => $status,
            );
            array_push($todo_array["records"], $todo_item);
        };

    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No todo list found.")
        );
    }

    //set response code 200 ok

    echo json_encode($todo_array, 200);