<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}else{
    include "../dao/database.php";
    $db= new database();
    $query="select * from category";
    $stmt=$db->EditData($query);
    if($_SERVER['REQUEST_METHOD']==='POST'){
        if(isset($_POST['add'])){
            if(!isset($_POST['category'])){
                Message::ShowMessage("please choose category to insert into.");
            }else{
                $queryadd="insert into storage (id_c, name, description) values (?,?,?)";
                $paramadd=[
                    $_POST['category'],
                    $_POST['ename'],
                    $_POST['description']
                ];
                $db->EditDataParam($queryadd,$paramadd);
                Message::ShowMessage("Added completed");
//                header("Location: show-storage.php");
            }
        }
    }
    $db->CloseConn();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Insert Storage</title>
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

                <li>
                    <a href="category-show.php">
                        <i class="now-ui-icons objects_diamond"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="active ">
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
                    <a class="navbar-brand" href="#pablo">Storages</a>
                </div>
                <div class=" justify-content-end" id="navigation">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#pablo">
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
                            <h5 class="title">Fill in the Form</h5>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST" enctype="multipart/form-data">
                                <div class="mb-3 row">
                                    <label for="ename" class="col-sm-3 col-form-label">Storage's Name: </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="ename" id="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="category" class="col-sm-3 col-form-label">Category: </label>
                                    <div class="col-sm-4">
                                        <select name="category" class="form-control">
                                            <option value="select" selected disabled>Select</option>
                                            <?php
                                            while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                                ?>
                                                <option value="<?php echo $row['id_c'];?>>"><?php echo $row['category_name'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="description" id="desc" required></textarea>
                                    <label for="description">Description </label>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <input name="add" type="submit" class="btn btn-success" value="Add New Storage">
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
</body>
</html>
