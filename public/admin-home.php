<?php
//session_start();
//if(!isset($_SESSION['your_name'])){
//    header("Location: login.php");
//}
if(isset($_GET['logout'])){
    unset($_SESSION['your_name']);
    unset($_SESSION['login']);
    header("Location: login.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Show Categories</title>
</head>
<body>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-8 pt-3">
        <?php
        if(isset($_SESSION['user'])){
            echo "<h6>Current user is <span class='text-success'>" . $_SESSION['user'] ."</span></h6>";
        }
        ?>
    </div>
    <div class="p-2 col-sm-2">
        <form action="#" method="GET">
            <input type="submit" name="logout" class="btn btn-info" value="Sign out">
        </form>
    </div>
    <div class="col-sm-1"></div>
</div>
<div class="container row">
    <div class="col-sm-4">
        <a href="category-show.php" class="btn btn-success" role="button">Categories</a>
    </div>
    <div class="col-sm-4">
        <a href="#" class="btn btn-success" role="button">Storage</a>
    </div>
    <div class="col-sm-4">
        <a href="#" class="btn btn-success" role="button">Files</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
