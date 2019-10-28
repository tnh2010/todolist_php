<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    use Firebase\JWT\BeforeValidException;
    use Firebase\JWT\ExpiredException;
    use Firebase\JWT\SignatureInvalidException;
    use Firebase\JWT\JWT;

    include_once __DIR__ . '/../config/database.php';
    include_once __DIR__ . '/../objects/todoes.php';
    include_once __DIR__ . '/../objects/user.php';
    include_once __DIR__ . '/../config/core.php';

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    // get posted data
    $data = json_decode(file_get_contents("php://input"));

    // set product property values
    $user->email = $data->email;
    $email_exists = $user->emailExists();

    // files for jwt will be here
    // check if email exists and if password is correct
    $newPass = password_hash($data->password,PASSWORD_DEFAULT);
    if($email_exists && password_verify($user->password, $newPass)){
        $token = array(
            "iss" => $iss,
            "aud" => $aud,
            "iat" => $iat,
            "nbf" => $nbf,
            "data" => array(
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email
            )
        );



        // set response code
        http_response_code(200);

        // generate jwt
        $jwt = JWT::encode($token, $key);

         var_dump('hoatruong', $jwt); die;
        echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt
            )
        );

    }
    // login failed
    else{

        // set response code
        http_response_code(401);

        // tell the user login failed
        echo json_encode(array("message" => "Login failed."));
    }

     // login failed will be here