<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}else {
    include "../dao/database.php";
    $db= new database();
    if(isset($_GET['id_e'])){
        $query="select sr.name, c.category_name, sr.description, sr.id_c, sr.active from storage sr join category c on c.id_c=sr.id_c where sr.id_e=?";
        $param=[
            $_GET['id_e']
        ];
        $stmt=$db->EditDataParam($query,$param);
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $query="select * from category";
        $stmt=$db->EditData($query);
    }
    if($_SERVER['REQUEST_METHOD']==='POST'){
        if($row['name']!==$_POST['ename']){
            $querycheck="select name from storage";
            $check=$db->EditData($querycheck);
            $okay=1;
            while($rowcheck=$check->fetch(PDO::FETCH_ASSOC)){
                if($rowcheck['name']===$_POST['ename']){
                    $okay--;
                    break;
                }
            }
        }
        if(isset($_POST['update'])){
            if ($_POST['ename']===""){
                Message::ShowMessage("please enter Storage's name.");
            }elseif(isset($okay) && $okay!=1 && $row['name']!==$_POST['ename']){
                Message::ShowMessage("there is an exist name in storage");
            }elseif($_POST['active']==="0"){
                $queryactive="select count(*) from file f join storage sr on sr.id_e=f.id_e where f.active=1 and f.id_e=?";
                $paramactive=[
                    $_GET['id_e']
                ];
                $count=$db->EditDataParam($queryactive, $paramactive);
                $countrow=$count->fetch(PDO::FETCH_COLUMN);
                if($countrow>0){
                    Message::ShowMessage("Error, file(s) inside this storage is(are) currently used in client");
                }else{
                    $query="update storage set id_c=?, name=?, description=?, active =? where id_e=?";
                    $param=[
                        $_POST['category'],
                        $_POST['ename'],
                        $_POST['description'],
                        $_POST['active'],
                        $_GET['id_e']
                    ];
                    $db->EditDataParam($query,$param);
                    header("Location: show-storage.php");
                }
            }else{
                $query="select active from category where id_c=?";
                $param=[
                        $_POST['category']
                ];
                $categoryactive=$db->EditDataParam($query,$param);
                $checkcategory=$categoryactive->fetch(PDO::FETCH_ASSOC);
                if($checkcategory['active']==0){
                    Message::ShowMessage("please active category you want to put this storage in first, id_c=".$_POST['category']);
                }else{
                    $query="update storage set id_c=?, name=?, description=?, active =? where id_e=?";
                    $param=[
                        $_POST['category'],
                        $_POST['ename'],
                        $_POST['description'],
                        $_POST['active'],
                        $_GET['id_e']
                    ];
                    $db->EditDataParam($query,$param);
                    header("Location: show-storage.php");
                }
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
    <title>Storage Update</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <link href="css/admin.css" rel="stylesheet" />
</head>
<body>
<?php
if(isset($_GET['id_e'])){
?>
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
                        <p>Storages</p>
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
                                    <label for="ename" class="col-sm-3 col-form-label">Storage's Name: </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="ename" id="name" class="form-control" value="<?php echo $row['name'];?>" placeholder="<?php echo $row['name'];?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="category" class="col-sm-3 col-form-label">Category: </label>
                                    <div class="col-sm-4">
                                        <select name="category" class="form-control">
                                            <option value="<?php echo $row['id_c'];?>" selected><?php echo $row['category_name'];?></option>
                                            <?php
                                            while($rowcategory=$stmt->fetch(PDO::FETCH_ASSOC)){
                                                ?>
                                                <option value="<?php echo $rowcategory['id_c'];?>>"><?php echo $rowcategory['category_name'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="active" class="col-sm-3 col-form-label">Active: </label>
                                    <div class="col-sm-8">
                                        <select name="active" class="form-control">
                                            <option value="<?php echo $row['active'];?>" selected><?php
                                                if($row['active']==1){
                                                    echo "yes";
                                                }else{
                                                    echo "no";
                                                }
                                                $firstopt=$row['active'];
                                                ?>
                                            </option>
                                            <option value="<?php if($firstopt==0){echo "1";}else{echo "0";}?>">
                                                <?php
                                                if($firstopt==0){
                                                    echo "yes";
                                                }else{
                                                    echo "no";
                                                }
                                                ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="description" id="desc" placeholder="<?php echo $row['description'];?>"><?php echo $row['description'];?></textarea>
                                    <label for="description">Description </label>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <input name="update" type="submit" class="btn btn-success" value="Edit The Storage">
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
<?php
}
?>
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
