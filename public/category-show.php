<?php
//session_start();
//if(!isset($_SESSION['your_name'])){
//    header("Location: login.php");
//}
include "../dao/database.php";
$db = new Database();
if (isset($_GET['search']) && trim($_GET['search']) != '') {
    $query = "select * from category where concat(id, name_pro) like ?";
    $param = [
        '%' . $_GET['search'] . '%'
    ];
    $results = $db->EditDataParam($query, $param);
} else {
    $results = $db->EditData("select * from category");
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Show Categories</title>
</head>
<body>
<div class="row p-3 bg-warning">
    <div class="col-sm-1"></div>
    <div class="col-sm-8">
        <form class="row">
            <div class="col-sm-3">
                <label for="search" class="col-form-label">Search:</label>
            </div>
            <div class="col-sm-5">
                <input type="text" name="search" class="form-control" id="search">
            </div>
            <div class="col-sm-1">
                <input type="submit" class="btn btn-success" value="Tìm">
            </div>
        </form>
    </div>
    <div class="col-sm-2">
        <a href="category-add.php" class="btn btn-secondary" role="button">Add Category</a>
    </div>
    <div class="col-sm-1"></div>
</div>
<div class="table-responsive">
    <table class="table align-middle table-striped">
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php
        while ($row = $results->fetch(PDO::FETCH_ASSOC)){
            echo "<tr>";
            foreach ($row as $item) {
                echo "<td>" . $item . "</td>";
            }
            echo "<td><a class='btn btn-secondary' role='button' href='category-edit.php?id=".$row['ID_C']."'>Edit</a></td>";
            echo "<td><button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#warning' value='".$row['ID_C']."' onclick='getRowId(this);'>Delete</button></td> </tr>";
        }
        $db->CloseConn();
        ?>
    </table>
</div>
<div class="modal fade" id="warning" tabindex="-1" aria-labelledby="warning" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">WARNING</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You are about to delete the whole category and its objects and filenames. Are you sure you want to delete this category?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" value="2" onclick="toDelete();">Yes</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="js/category-show.js"></script>
</body>
</html>