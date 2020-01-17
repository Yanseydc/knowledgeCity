<?php
    session_start();        
    if(!isset($_SESSION["username"]) || $_SESSION["username"] == null || $_SESSION["username"] == "") {
        header("Location: login.php");
    }
?>
<?php include 'layouts/default_header.html' ?>
  <h1> User List </h1>
  <table class="table" id="users-table"></table>
  <button class="btn btn-secondary" id="logout-btn"> log out </button>
<?php include 'layouts/default_footer.html' ?>