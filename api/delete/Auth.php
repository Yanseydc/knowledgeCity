<?php 
    header('Access-Control-Allow-Origin: *');    
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');   
    header('Access-Control-Allow-Headers: application/json'); 

    session_start();
    session_destroy();

    echo json_encode( 
        array(
        "status" => 200,
        "message" => "Successfully logged out"
        )
    );
    
?>