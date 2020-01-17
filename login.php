<?php include 'layouts/default_header.html' ?>   
<?php
    session_start();        
    if(isset($_COOKIE['uniqid'])) {        
        header("Location: list.php");
    } else if (isset($_SESSION["username"]) ) {
        if($_SESSION["username"] != null || !$_SESSION["username"] != "") {        
            header("Location: list.php");
        }
    } else {
        // destroy the session
        session_destroy();
        // set the expiration date to one hour ago
        $session_lifetime = time() - 3600;
        setcookie("uniqid", "", $session_lifetime, "/");
    }
?> 
    <div class="row">
        <div class="col col-md-5 mx-auto">
            <img src="public/images/Logo.svg" class="img-fluid" alt="Responsive image">
            <blockquote class="blockquote mt-5">
                <p class="h5">Welcome to the Learning Management System</p>
                <p><small>Please login to continue</small></p>
            </blockquote>
            <div class="alert alert-danger" role="alert" id="alert-message"></div>
            <form id="login-form">
                <div class="form-group">                            
                    <input type="text" class="form-control form-control-md pt-1 pb-1" id="username" name="username" aria-describedby="emailHelp" placeholder="Username">            
                </div>        
                <div class="form-group">        
                    <input type="password" class="form-control form-control-md pt-1 pb-1" id="password" name="password" placeholder="Password">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="remember-me" name="remember">
                    <label class="form-check-label" for="remember-me">Remember me</label>
                </div>
                <button type="button" class="btn btn-block login" id="login-btn">Log in <i class="fas fa-chevron-circle-right"></i></button>
            </form>
            
        </div>
    </div>
<?php include 'layouts/default_footer.html' ?>