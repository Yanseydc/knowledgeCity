<?php 
    header('Access-Control-Allow-Origin: *');    
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');   
    header('Access-Control-Allow-Headers: application/json'); 

    session_start();
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();

    // set the expiration date to one hour ago
    $session_lifetime = time() - 3600;
    ini_set('session.cookie_lifetime', $session_lifetime);
    ini_set('session.gc_maxlifetime', $session_lifetime); 
    
    echo json_encode( 
        array(
        "status" => 200,
        "message" => "Successfully logged out"
        )
    );
    
?>