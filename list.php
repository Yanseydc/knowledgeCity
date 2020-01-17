<?php    
    session_start();          
    if(!isset($_SESSION["username"]) || $_SESSION["username"] == null || $_SESSION["username"] == "") {
      if(!isset($_COOKIE['uuid'])) {  
          header("Location: login.php");
      }
    }
?>
<?php include 'layouts/default_header.html' ?>
<div class="row">
    <div class="col col-md-10 mx-auto">
      <h1 class="display-4 text-center" > User List </h1>
      <table class="table" id="users-table"></table>
      <div class="d-flex justify-content-center">
        <nav aria-label="Page navigation example">
          <ul class="pagination" id="page-list"></ul>
        </nav>
      </div>      
  </div>
</div>  
<?php include 'layouts/default_footer.html' ?>
<div class="footer">
  <button class="btn logout btn-block" id="logout-btn">Log Out</button>      
</div>