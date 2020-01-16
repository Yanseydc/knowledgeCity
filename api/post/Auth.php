<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json*");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: application/json");

    include_once "../../config/DataBase.php";
    include_once "../../controller/Auth.php";

    //make DB instance 
    $database = new DataBase();
    $db = $database->connect();

    //make auth instance
    $auth = new Auth($db);

    //get post data
    $auth->username = isset($_POST['username']) ? $_POST['username'] : die();
    $auth->password = isset($_POST['password']) ? $_POST['password'] : die();
        
    //read user
    $result = $auth->read();

    //get row count
    $num = $result->rowCount();

    //check if user was found
    if( $num > 0 ) {
        $user_arr = array();        

        while( $row = $result->fetch(PDO::FETCH_ASSOC) ) {
            extract($row);

            $user_item = array("username" => $username);

            array_push($user_arr, $user_item);
        }
        
        //parse to JSON
        echo json_encode(
            array(
                "status" => 200,
                "data" => $user_arr
            )
        );

    } else {
        //no users
        echo json_encode(
            array(
                "status" => 404,
                "message" => "user not found"
            )
        );
    }
?>