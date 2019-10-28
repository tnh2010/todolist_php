<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once __DIR__ . '/../config/database.php';
    include_once __DIR__ . '/../objects/todoes.php';

    $database = new Database();
    $db = $database->getConnection();
    $todo = new Todoes($db);
    // Query todoes
    $todo->readOne();
    if ($todo->name!= null) {
        $todo_array = array(
            "id" => $todo->id,
            "name" => $todo->name,
            "user_id" => $todo->user_id,
            "note" => $todo->note,
            "status" => $todo->status
        );
        http_response_code(200);
        echo json_encode($todo_array);
    } else {
        http_response_code(404);
        echo json_encode(array("message"=> "Todoes not exist."));
    }