<?php        
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');    

    //unauthorized user
    session_start();
    if(!isset($_SESSION["username"]) || $_SESSION["username"] == null || $_SESSION['username'] == ""){
        echo json_encode(
            array(
                "status" => 401,
                "message" => "Unauthorized user"
            )
        );
        die();
    }


    include_once "../../config/DataBase.php";
    include_once "../../controller/Users.php";

    //make DB instance 
    $database = new DataBase();
    $db = $database->connect();

    //make auth instance
    $users = new Users($db);
            
    //read users
    $result = $users->read();

    //get row count
    $num = $result->rowCount();

    //check if user was found
    if( $num > 0 ) {
        $users_arr = array();        

        while( $row = $result->fetch(PDO::FETCH_ASSOC) ) {
            extract($row);
            
            $user_items = array(
                "firstName" => $first_name,
                "lastName" => $last_name,
                "group" => $group
            );

            array_push($users_arr, $user_items);
        }
        
        //parse to JSON
        echo json_encode(
            array(
                "status" => 200,
                "data" => $users_arr
            )
        );

    } else {
        //no users
        echo json_encode(
            array(
                "status" => 404,
                "message" => "no users found"
            )
        );
    }
?>