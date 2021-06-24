<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location:login.php");
}
include "../dao/database.php";
while (0==0) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        break;
    }
//    check for blank input
    $_POST['name'] = trim($_POST['name']);
    if ($_POST['name'] == '') {
        echo "<script>alert('CATEGORY\'S NAME CANNOT BE BLANK')</script>";
        break;
    }
    $db = new Database();
//    check for unique names
    $query = "select category_name from category where id_c != ? ;";
    $params = [
        $_GET['id']
    ];
    $result = $db->EditDataParam($query, $params);
    $temp = 1;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        if ($row['category_name'] == $_POST['name']) {
            echo "<script>alert('OTHER CATEGORY ALREADY HAS THIS NAME, PLEASE FILL IN ANOTHER NAME')</script>";
            $temp = 0;
            break;
        }
    }
    if ($temp == 0) {
        $db->CloseConn();
        break;
    }
//    check for active storages and files
    $query = "select count(s.id_e) + count(f.id_f) "
    . "from category c inner join storage s on c.id_c = s.id_c "
    . "inner join file f on s.id_e = f.id_e "
    . "where c.id_c = ? "
	. "and ("
	. "(s.active = 1 and f.active = 1) "
	. "or (s.active = 1 and f.active = 0)"
	. "); ";
    $param = [
        $_GET['id']
    ];
    $result = $db->EditDataParam($query, $param);
    $result_array = $result->fetch(PDO::FETCH_NUM);
    if ($_POST['active'] == 0 &&  $result_array[0] > 0) {
        echo "<script>alert('ALL RELATED STORAGES AND FILES MUST TURN INACTIVE BEFORE THIS CATEGORY CAN TURN INACTIVE!')</script>";
        $db->CloseConn();
        break;
    }
//    actual update
    $query = "update category set category_name = ? , description = ?, ACTIVE = ? where ID_C = ? ;";
    $params = [
        $_POST['name'],
        $_POST['desc'],
        $_POST['active'],
        $_GET['id']
    ];
    $db->EditDataParam($query, $params);
    $db->CloseConn();
    header("Location: category-show.php");
    break;
}
if (isset($_GET['id'])) :
$db = new Database();
$query = "select * from category where ID_C=?";
$param = [
    $_GET['id']
];
$results = $db->EditDataParam($query, $param);
$editing = $results->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Categories
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <link href="css/admin.css" rel="stylesheet" />
</head>

<body class="">
<div class="wrapper ">
    <div class="sidebar" data-color="red">
        <div class="logo">
            <a href="category-show.php" class="simple-text logo-normal">
                KIDS-ZONE
            </a>
        </div>
        <div class="sidebar-wrapper" id="sidebar-wrapper">
            <ul class="nav">

                <li class="active ">
                    <a href="category-show.php">
                        <i class="now-ui-icons objects_diamond"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li>
                    <a href="show-storage.php">
                        <i class="now-ui-icons shopping_box"></i>
                        <p>Storage</p>
                    </a>
                </li>
                <li>
                    <a href="file-show.php">
                        <i class="now-ui-icons files_single-copy-04"></i>
                        <p>Files</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel" id="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-transparent  bg-primary  navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <p>User: <b><?=$_SESSION['user']?></b></p>
                </div>
                <div class=" justify-content-end" id="navigation">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php?logout=1">
                                <i class="now-ui-icons sport_user-run"></i>
                                <p>
                                    <span class="d-md-block">Log out</span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="panel-header panel-header-sm">
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">Edit the Form</h5>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST" enctype="multipart/form-data">
                                <div class="mb-3 row">
                                    <label for="name" class="col-sm-3 col-form-label">Category's Name: </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" id="name" class="form-control" value="<?=$editing['category_name']?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="name" class="col-sm-3 col-form-label">Active or not? </label>
                                    <div class="col-sm-4">
                                        <select name="active" id="active" class="search-selections">
                                            <option value="1" <?=$editing['active']==1?'selected':''?>>Yes</option>
                                            <option value="0" <?=$editing['active']!=1?'selected':''?>>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="desc" id="desc"><?=$editing['description']?></textarea>
                                    <label for="desc">Description </label>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <input type="submit" class="btn btn-success" value="Edit The Category">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class=" container-fluid ">
                <div class="copyright" id="copyright">
                    &copy; <script>
                        document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                    </script>, KIDS-ZONE
                </div>
            </div>
        </footer>
    </div>
</div>
<!--   Core JS Files   -->
<script src="js/core/jquery.min.js"></script>
<script src="js/core/popper.min.js"></script>
<script src="js/core/bootstrap.min.js"></script>
<script src="js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- Chart JS -->
<script src="js/plugins/chartjs.min.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
<script src="js/admin.js"></script>
<?php
$db->CloseConn();
endif;
?>
</body>
</html>