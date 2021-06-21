<?php
session_start();
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
}
include "../dao/database.php";
$db = new database();
if(isset($_GET['id_f'])){
    $query="select * from file where id_f = ?";
    $param=[
        $_GET['id_f']
    ];
    $stmt=$db->EditDataParam($query,$param);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $query="select * from storage";
    $stor=$db->EditData($query);
    $query="select * from storage sr join file f on f.id_e=sr.id_e where sr.id_e = ?";
    $param=[
        $row['id_e']
    ];
    $selected=$db->EditDataParam($query,$param);
    $selectedrow=$selected->fetch(PDO::FETCH_ASSOC);
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $true=1;
    while($true==1) {
        $query = "select file_name from file";
        $stmt = $db->EditData($query);
        if($_FILES['filename']['size'] !== 0){
            while ($rowloop = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($rowloop['file_name'] === $_FILES['filename']['name']) {
                    $true--;
                    Message::ShowMessage("there is alrady an exists name");
                    break;
                }
            }
            if ($true < 1) {
                break;
            }
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file($finfo, $_FILES['filename']['tmp_name']);
            $picallowed = ['image/jpeg', 'image/png', 'image/jpg'];
            $soundallowed = 'audio/x-wav';
            $picval = 0;
            $souval = 0;
            foreach ($picallowed as $value) {
                if ($value === $type) {
                    $picval++;
                }
            }
            if ($soundallowed === $type) {
                $souval++;
            }
            if($picval > 0 || $souval > 0){
                if ($picval > 0) {
                    $filetype = 0;
                    move_uploaded_file($_FILES['filename']['tmp_name'], '../public/images/' . $_FILES['filename']['name']);
                } else {
                    $filetype = 1;
                    move_uploaded_file($_FILES['filename']['tmp_name'], '../public/voice/' . $_FILES['filename']['name']);
                }
            }else{
                Message::ShowMessage("only jpeg, png, jpg(image) or wav(sound) allowed");
                $true--;
                break;
            }
            finfo_close($finfo);
        }
        if($_FILES['filename']['size'] === 0){
            $query="update file set id_e = ?, active=? where file_name = ?";
            $param=[
                $_POST['storage'],
                $_POST['active'],
                $_POST['oldfilename']
            ];
        }else{
            $query="update file set id_e = ?, file_name = ?, file_type = ?, active=? where id_f = ?";
            $param=[
                $_POST['storage'],
                $_FILES['filename']['name'],
                $filetype,
                $_POST['active'],
                $row['id_f']
            ];
        }
        $db->EditDataParam($query,$param);
        $true++;
        header("Location: file-show.php");
    }
}
$db->CloseConn();
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>File Update</title>
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
if(isset($_GET['id_f'])){
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
                    <li>
                        <a href="show-storage.php">
                            <i class="now-ui-icons shopping_box"></i>
                            <p>Storages</p>
                        </a>
                    </li>
                    <li class="active ">
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
                                        <label for="oldfilename" class="col-sm-3 col-form-label">File's Name: </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="oldfilename" id="oldfilename" class="form-control" value="<?php echo $row['file_name'];?>" readonly >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="filename" class="col-sm-3 col-form-label">Upload: </label>
                                        <div class="col-sm-9">
                                            <input type="file" name="filename" id="upload">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="active" class="col-sm-3 col-form-label">Active: </label>
                                        <div class="col-sm-8">
                                            <select name="active" class="form-control">
                                                <option value="<?php echo $selectedrow['active'];?>" selected><?php
                                                    if($selectedrow['active']==1){
                                                        echo "yes";
                                                    }else{
                                                        echo "no";
                                                    }
                                                    $firstopt=$selectedrow['active'];
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
                                    <div class="mb-3 row">
                                        <label for="storage" class="col-sm-3 col-form-label">Storage:</label>
                                        <div class="col-sm-8">
                                            <select name="storage" class="form-control">
                                                <option value="<?php echo $selectedrow['id_e'];?>" selected><?php echo $selectedrow['name'];?></option>
                                                <?php
                                                while($rowstor=$stor->fetch(PDO::FETCH_ASSOC)){
                                                    ?>
                                                    <option value="<?php echo $rowstor['id_e'];?>"><?php echo $rowstor['name'];?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <input name="update" type="submit" class="btn btn-success" value="Edit The File">
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
<script>
    document.getElementById('upload').onchange = uploadOnChange;

    function uploadOnChange() {
        var filename = this.value;
        var lastIndex = filename.lastIndexOf("\\");
        if (lastIndex >= 0) {
            filename = filename.substring(lastIndex + 1);
        }
        document.getElementById('oldfilename').value = filename;
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