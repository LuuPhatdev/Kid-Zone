<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location:login.php");
}
// main part:
include "../dao/database.php";
$db = new Database();
if (isset($_GET['search']) && trim($_GET['search']) != '') {
    $query = "select * from category where concat(id_c, category_name) like ?";
    $param = [
        '%' . $_GET['search'] . '%'
    ];
    $results = $db->EditDataParam($query, $param);
} else {
    $results = $db->EditData("select * from category");
}
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
        <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>
                    <a class="navbar-brand" href="#pablo">Categories</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navigation">
                    <form>
                        <div class="input-group no-border">
                            <input type="text" name="search" id="search" value="" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <button class="hidden-button"><i class="now-ui-icons ui-1_zoom-bold"></i></button>

                                </div>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="category-add.php">
                                <i class="now-ui-icons ui-1_simple-add"></i>
                                <p>
                                    <span class="d-md-block">Add New Category</span>
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="admin-home.php?logout=1">
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
                            <h4 class="card-title"> ALL YOUR DATA</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class=" text-primary">
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($row = $results->fetch(PDO::FETCH_ASSOC)){
                                        echo "<tr>";
                                        foreach ($row as $item) {
                                            echo "<td>" . $item . "</td>";
                                        }
                                        echo "<td><a class='btn btn-secondary' role='button' href='category-edit.php?id=".$row['id_c']."'>Edit</a></td>";
                                        echo "<td><button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#warning' value='".$row['id_c']."' onclick='getRowId(this);'>Delete</button></td> </tr>";
                                    }
                                    $db->CloseConn();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
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
<!--   Core JS Files   -->
<script src="js/core/jquery.min.js"></script>
<script src="js/core/popper.min.js"></script>
<script src="js/core/bootstrap.min.js"></script>
<script src="js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- Chart JS -->
<script src="js/plugins/chartjs.min.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
<script src="js/admin.js"></script>
</body>
</html>
