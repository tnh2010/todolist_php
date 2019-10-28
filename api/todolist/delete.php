<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/todoes.php';

$database = new Database();
$db = $database->getConnection();
$todo = new Todoes($db);
// get product id
$data = json_decode(file_get_contents("php://input"));
$todo->id = $data->id;
// Query todoes
if ($todo->delete()) {
    http_response_code(200);
    echo json_encode(array("message"=>"Todo was deleted"));
} else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message"=> "Unable to delete todo"));
}