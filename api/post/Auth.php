<?php    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: application/json');

    include_once "../../config/DataBase.php";
    include_once "../../controller/Auth.php";

    //make DB instance 
    $database = new DataBase();
    $db = $database->connect();

    //make auth instance
    $auth = new Auth($db);

    //get post data
    $auth->username = isset($_POST['username']) ? $_POST['username'] : "";
    $auth->password = isset($_POST['password']) ? $_POST['password'] : "";      
    //read user
    $result = $auth->read();

    //get row count
    $num = $result->rowCount();

    //check if user was found
    if( $num > 0 ) {
                
        //if checked is true, keep session alive
        if(isset($_POST['isChecked']) && $_POST['isChecked'] == 'true') {                        
            $session_lifetime = 3600; // 1 hour
            // server should keep session data for AT LEAST 1 hour
            ini_set('session.cookie_lifetime', $session_lifetime);
            ini_set('session.gc_maxlifetime', $session_lifetime);                    
        }
        //start session 
        session_start();
        $_SESSION['username'] = $auth->username;
        
        // //parse to JSON
        echo json_encode(
            array(
                "status" => 200,
                "data" => $auth->username
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