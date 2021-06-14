<?php
//session_start();
//if(!isset($_SESSION['your_name'])){
//    header("Location: login.php");
//}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../dao/database.php";
    $db = new Database();
    $query = "update category set CATEGORY_NAME = ? , DESCRIPTION = ? where ID_C = ? ;";
    $params = [
        $_POST['name'],
        $_POST['desc'],
        $_GET['id']
    ];
    $db->EditDataParam($query, $params);
    $db->CloseConn();
    header("Location: category-show.php");
}
if (isset($_GET['id'])) :
    include "../dao/Database.php";
    $db = new Database();
    $query = "select * from category where ID_C=?";
    $param = [
        $_GET['id']
    ];
    $results = $db->EditDataParam($query, $param);
    $editing = $results->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Edit Category</title>
</head>
<body class="bg-light">
<h5 class="mt-3 mb-3 text-center">Please fill in some information for new category:</h5>
<div class="d-flex justify-content-center">
    <form action="#" method="POST" enctype="multipart/form-data" class="w-75">
        <div class="mb-3 row">
            <label for="name" class="col-sm-3 col-form-label">Category's Name: </label>
            <div class="col-sm-9">
                <input type="text" name="name" id="name" class="form-control" value="<?=$editing['CATEGORY_NAME']?>">
            </div>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" name="desc" id="desc"><?=$editing['DESCRIPTION']?></textarea>
            <label for="desc">Description: </label>
        </div>
        <div class="d-flex justify-content-center">
            <input type="submit" class="btn btn-success" value="Edit Category">
        </div>
    </form>
</div>
<script src="../js/edit_products.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<?php
$db->CloseConn();
endif;
?>
</body>
</html>
