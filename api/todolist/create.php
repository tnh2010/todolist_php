<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once __DIR__ . '/../config/database.php';
    include_once __DIR__ . '/../objects/todoes.php';

    $database = new Database();
    $db = $database->getConnection();

    $todo = new Todoes($db);
    $data = json_decode(file_get_contents("php://input"));

    if(!empty($data->user_id) && !empty($data->name)) {
        $todo->user_id = $data->user_id;
        $todo->name = $data->name;
        $todo->note = $data->note;
        $todo->status = $data->status;

        if($todo->create()){
            // set response code - 201 created
            echo json_encode(["message"=>"Todo was created"], 201);
        } else {
            echo json_encode(["message"=> "Unable to create todo"], 503);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message"=>"Unable to create todo. Data is incomplete"], 400);
    }
