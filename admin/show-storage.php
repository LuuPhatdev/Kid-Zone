<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}else{
    include "../dao/database.php";
    $db = new database();
//    tao cau truc cho select va count select
    $select="select sr.id_e, sr.name, c.id_c, c.category_name, sr.description";
    $fromjoinon=" from storage sr join category c on c.id_c=sr.id_c";
    $orderbylimit=" order by sr.id_c, sr.name limit 10";
    $selectcount="select count(*)";
//    xac ding page
    if(!isset($_GET['page'])){
        $page=1;
    }else{
        $page=$_GET['page'];
    }
//    tim kiem cho table
    $false=1;
    if(isset($_GET['search'])&&isset($_GET['searchoption'])&&$_GET['search']!==""&&$_GET['searchoption']!==""){
        if($_GET['searchoption']==='sr.id_e' || $_GET['searchoption']==='c.id_c'){
            if(is_numeric($_GET['search'])){
                $query=$select.$fromjoinon." where ".$_GET['searchoption']." = ? ".$orderbylimit;
                if($page>1) {
                    $query = $query . " offset " . ($page - 1) * 10;
                }
                $param=[
                        $_GET['search']
                ];
                $querycount=$selectcount.$fromjoinon." where ".$_GET['searchoption']." = ? ";
                $stmt=$db->EditDataParam($query,$param);
                $count=$db->EditDataParam($querycount, $param);
                $countrow=$count->fetch(PDO::FETCH_COLUMN);
                $search=$_GET['search'];
                $searchoption=$_GET['searchoption'];
                $false--;
            }else{
                Message::ShowMessage("only numbers allowed in this column");
            }
        }else{
            $string="%".$_GET['search']."%";
            $query=$select.$fromjoinon." where ".$_GET['searchoption']." like ? ".$orderbylimit;
            if($page>1) {
                $query = $query . " offset " . ($page - 1) * 10;
            }
            $param=[
                $string
            ];
            $querycount=$selectcount.$fromjoinon." where ".$_GET['searchoption']." like ? ";
            $stmt=$db->EditDataParam($query,$param);
            $count=$db->EditDataParam($querycount, $param);
            $countrow=$count->fetch(PDO::FETCH_COLUMN);
            $search=$_GET['search'];
            $searchoption=$_GET['searchoption'];
            $false--;
        }
    }
    if($false===1){
        $query=$select.$fromjoinon.$orderbylimit;
        if($page>1) {
            $query = $query . " offset " . ($page - 1) * 10;
        }
        $querycount=$selectcount.$fromjoinon;
        $stmt=$db->EditData($query);
        $count=$db->EditData($querycount);
        $countrow=$count->fetch(PDO::FETCH_COLUMN);
        $search="";
        $searchoption="";
//        trong truong hop co submit
    }
    if($_SERVER['REQUEST_METHOD']==='GET'){
        if(isset($_GET['searchbutton'])){
                if($_GET['search']===''){
                    header("Location: show-storage.php");
                }else{
                    header("Location: show-storage.php?search=".$_GET['search']."&searchoption=".$_GET['searchoption']);
                }
        }
    }
    if($_SERVER['REQUEST_METHOD']==='POST'){
        if(isset($_POST['deletebutton'])) {
            if (empty($_POST['checkes'])) {
                Message::ShowMessage("must check an item you want to delete first");
            }else{
//                phan lap lai viec xoa cho bang file va storage cho moi o checked
                foreach($_POST['checkes'] as $value){
//                    delete trong file lien quan den storage
                    $querydelete="delete from file where id_e=?";
                    $paramdelete=[
                            $value
                    ];
                    $db->EditDataParam($querydelete, $paramdelete);
//                    delete trong storage
                    $querydelete="delete from storage where id_e=?";
                    $db->EditDataParam($querydelete, $paramdelete);
                }
                Message::ShowMessage("delete completed");
                header("Refresh:0");
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
    <title>Show Storage</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <link href="css/admin.css?v=2" rel="stylesheet" />
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
                        <a class="navbar-brand" href="#pablo">Storages</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <form method="get">
                            <div class="row justify-content-end">
                                <select name="searchoption" class="col-4 search-selections">
                                    <option value="sr.id_e">ID_E</option>
                                    <option value="sr.name">ELEMENT NAME</option>
                                    <option value="c.id_c">ID_C</option>
                                    <option value="c.category_name">CATEGORY NAME</option>
                                </select>
                                <div class="col-6">
                                    <div class="input-group no-border">
                                        <input type="text" name="search" id="search" value="" class="form-control" placeholder="Search...">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <button type="submit" name="searchbutton" class="hidden-button"><i class="now-ui-icons ui-1_zoom-bold"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="insert-storage.php">
                                    <i class="now-ui-icons ui-1_simple-add"></i>
                                    <p>
                                        <span class="d-md-block">Add New Storage</span>
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
                            <form method="post">
                                <div class="card-header">
                                    <h4 class="card-title"> ALL YOUR DATA</h4>
                                    <?php
                                    if($page>1){
                                        ?>
                                        <input type="button" name="prev" class="btn btn-success" value="Prev" onclick="location.href='<?php
                                        echo "show-storage.php?search=".$search."&searchoption=".$searchoption."&page=".($page-1);?>';">
                                        <?php
                                    }
                                    if($page*10<$countrow){
                                        ?>
                                        <input type="button" name="next" class="btn btn-success" value="Next" onclick="location.href='<?php
                                        echo "show-storage.php?search=".$search."&searchoption=".$searchoption."&page=".($page+1);?>';">
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead class=" text-primary">
                                            <th> <label class="customcheckbox m-b-20"> <input type="checkbox" id="mainCheckbox" onclick="toggle(this)"> <span class="checkmark"></span> </label> </th>
                                            <th>ID_E</th>
                                            <th>Element Name</th>
                                            <th>ID_C</th>
                                            <th>Category Name</th>
                                            <th>Description</th>
                                            <th>Update</th>
                                            </thead>
                                            <tbody>
                                            <?php
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                echo "<tr>";
                                                echo "<td> <label class='customcheckbox'> <input type='checkbox' class='listCheckbox' name='checkes[]' value='".$row['id_e']."'> <span class='checkmark'></span> </label> </td>";
                                                foreach ($row as $item) {
                                                    echo "<td>" . $item . "</td>";
                                                }
                                                echo "<td><a class='btn btn-secondary' role='button' href='update-storage.php?id_e=".$row['id_e']."'>Edit</a></td>";
                                            }
                                            $db->CloseConn();
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <input type="submit" name="deletebutton" class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#warning' value="Delete">
                            </form>
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
    <script language="JavaScript">
        function toggle(source) {
            checkboxes = document.getElementsByName('checkes[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
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
