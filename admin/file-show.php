<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    } else {
        include "../dao/database.php";
        $db = new database();
        $select = "select f.id_f, f.file_name, c.id_c, c.category_name, sr.id_e, sr.name, f.file_type, f.active";
        $fromjoinon = " from file f join storage sr on sr.id_e=f.id_e join category c on c.id_c=sr.id_c";
        $orderbylimit = " order by c.id_c, sr.id_e, f.file_name limit 10";
        $selectcount = "select count(*)";

        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }

        $false = 1;
        if (isset($_GET['search']) && isset($_GET['searchoption']) && $_GET['search'] !== "" && $_GET['searchoption'] !== "") {
            if ($_GET['searchoption'] === 'sr.id_e' || $_GET['searchoption'] === 'c.id_c' || $_GET['searchoption'] === 'f.id_f') {
                if (is_numeric($_GET['search'])) {
                    if ($_GET['searchoption'] === 'sr.id_e') {
                        $query = $select . $fromjoinon . " where sr.id_e = ? " . $orderbylimit;
                        $querycount = $selectcount . $fromjoinon . " where sr.id_e = ? ";
                    } elseif ($_GET['searchoption'] === 'c.id_c') {
                        $query = $select . $fromjoinon . " where c.id_c = ? " . $orderbylimit;
                        $querycount = $selectcount . $fromjoinon . " where c.id_c = ? ";
                    } else {
                        $query = $select . $fromjoinon . " where f.id_f = ? " . $orderbylimit;
                        $querycount = $selectcount . $fromjoinon . " where f.id_f = ? ";
                    }

                    if ($page > 1) {
                        $query = $query . " offset " . ($page - 1) * 10;
                    }

                    $param = [
                        $_GET['search']
                    ];
                    $stmt = $db->EditDataParam($query, $param);
                    $count = $db->EditDataParam($querycount, $param);
                    $countrow = $count->fetch(PDO::FETCH_COLUMN);
                    $search = $_GET['search'];
                    $searchoption = $_GET['searchoption'];
                    $false--;
                } else {
                    Message::ShowMessage("only numbers allowed in this column");
                }
            } elseif ($_GET['searchoption'] === 'f.file_type') {
                if (ctype_alpha($_GET['search'])) {
                    if (strtolower($_GET['search']) === 'picture' || strtolower($_GET['search'] === 'sound')) {
                        if (strtolower($_GET['search']) === 'picture') {
                            $type = "0";
                        } else {
                            $type = "1";
                        }

                        $query = $select . $fromjoinon . " where f.file_type = ? " . $orderbylimit;

                        if ($page > 1) {
                            $query = $query . " offset " . ($page - 1) * 10;
                        }

                        $param = [
                            $type
                        ];
                        $querycount = $selectcount . $fromjoinon . " where f.file_type = ? ";
                        $stmt = $db->EditDataParam($query, $param);
                        $count = $db->EditDataParam($querycount, $param);
                        $countrow = $count->fetch(PDO::FETCH_COLUMN);
                        $search = $_GET['search'];
                        $searchoption = $_GET['searchoption'];
                        $false--;
                    } else {
                        Message::ShowMessage("only 'picture' or 'sound' are allowed in search for File_Type");
                    }
                } else {
                    Message::ShowMessage("numbers are not allowed when searching in File_Type");
                }
            } else {
                $string = "%" . $_GET['search'] . "%";

                if ($_GET['searchoption'] === 'f.file_name') {
                    $query = $select . $fromjoinon . " where f.file_name like ? " . $orderbylimit;
                    $querycount = $selectcount . $fromjoinon . " where f.file_name like ? ";
                } elseif ($_GET['searchoption'] === 'c.category_name') {
                    $query = $select . $fromjoinon . " where c.category_name like ? " . $orderbylimit;
                    $querycount = $selectcount . $fromjoinon . " where c.category_name like ? ";
                } else {
                    $query = $select . $fromjoinon . " where sr.name like ? " . $orderbylimit;
                    $querycount = $selectcount . $fromjoinon . " where sr.name like ? ";
                }

                if ($page > 1) {
                    $query = $query . " offset " . ($page - 1) * 10;
                }

                $param = [
                    $string
                ];
                $stmt = $db->EditDataParam($query, $param);
                $count = $db->EditDataParam($querycount, $param);
                $countrow = $count->fetch(PDO::FETCH_COLUMN);
                $search = $_GET['search'];
                $searchoption = $_GET['searchoption'];
                $false--;
            }
        }

        if ($false === 1) {
            $query = $select . $fromjoinon . $orderbylimit;

            if ($page > 1) {
                $query = $query . " offset " . ($page - 1) * 10;
            }

            $querycount = $selectcount . $fromjoinon;
            $stmt = $db->EditData($query);
            $count = $db->EditData($querycount);
            $countrow = $count->fetch(PDO::FETCH_COLUMN);
            $search = "";
            $searchoption = "";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['deletebutton'])) {
                if (empty($_POST['checkes'])) {
                    Message::ShowMessage("must check an item you want to delete first");
                } else {
                    foreach ($_POST['checkes'] as $value) {
                        $querydelete = "delete from file where id_f=?";
                        $paramdelete = [
                            $value
                        ];
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Show File</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet"/>
    <link href="css/admin.css" rel="stylesheet"/>
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
                    <p>User: <b><?= $_SESSION['user'] ?></b></p>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navigation">
                    <form method="get">
                        <div class="row justify-content-end">
                            <select name="searchoption" class="col-4 search-selections">
                                <option value="f.id_f">ID_F</option>
                                <option value="f.file_name">FILE NAME</option>
                                <option value="c.id_c">ID_C</option>
                                <option value="c.category_name">CATEGORY NAME</option>
                                <option value="sr.id_e">ID_E</option>
                                <option value="sr.name">STORAGE NAME</option>
                                <option value="f.file_type">FILE TYPE</option>
                            </select>
                            <div class="col-6">
                                <div class="input-group no-border">
                                    <input type="text" name="search" id="search" value="" class="form-control"
                                           placeholder="Search...">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <button type="submit" name="searchbutton" class="hidden-button"><i
                                                        class="now-ui-icons ui-1_zoom-bold"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="file-insert.php">
                                <i class="now-ui-icons ui-1_simple-add"></i>
                                <p>
                                    <span class="d-md-block">Add New File</span>
                                </p>
                            </a>
                        </li>

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
                        <form method="post">
                            <div class="card-header">
                                <h4 class="card-title"> ALL YOUR DATA</h4>
                                <p>You can only delete a file if it is inactive.</p>
                                <!--                                    nut next and prev-->
                                <?php
                                    if ($page > 1) {
                                        ?>
                                        <input type="button" name="prev" class="btn btn-success" value="Prev"
                                               onclick="location.href='<?php
                                                   echo "file-show.php?search=" . $search . "&searchoption=" . $searchoption . "&page=" . ($page - 1); ?>';">
                                        <?php
                                    }
                                    if ($page * 10 < $countrow) {
                                        ?>
                                        <input type="button" name="next" class="btn btn-success" value="Next"
                                               onclick="location.href='<?php
                                                   echo "file-show.php?search=" . $search . "&searchoption=" . $searchoption . "&page=" . ($page + 1); ?>';">
                                        <?php
                                    }
                                ?>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <!--                                        here-->
                                        <thead class=" text-primary">
                                        <th><label class="customcheckbox m-b-20"> <input type="checkbox"
                                                                                         id="mainCheckbox"
                                                                                         onclick="toggle(this)"> <span
                                                        class="checkmark"></span> </label></th>
                                        <th>id_f</th>
                                        <th>file name</th>
                                        <th>id_c</th>
                                        <th>category name</th>
                                        <th>id_e</th>
                                        <th>storage name</th>
                                        <th>file type</th>
                                        <th>active</th>
                                        <th>update</th>
                                        </thead>
                                        <tbody>
                                        <!--                                            phan show thong tin trong bang file-->
                                        <?php
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <tr>
                                                    <th> <?php if ($row['active'] == 0) { ?> <label
                                                                class="customcheckbox"> <input type="checkbox"
                                                                                               class="listCheckbox"
                                                                                               name="checkes[]"
                                                                                               value="<?php echo $row['id_f']; ?>">
                                                            <span class="checkmark"></span> </label> <?php } ?> </th>
                                                    <td><?php echo $row['id_f']; ?></td>
                                                    <td><?php echo $row['file_name']; ?></td>
                                                    <td><?php echo $row['id_c']; ?></td>
                                                    <td><?php echo $row['category_name']; ?></td>
                                                    <td><?php echo $row['id_e']; ?></td>
                                                    <td><?php echo $row['name']; ?></td>
                                                    <td><?php
                                                            if ($row['file_type'] === '0') {
                                                                echo "picture";
                                                            } else {
                                                                echo "sound";
                                                            }
                                                        ?></td>
                                                    <td><?php
                                                            if ($row['active'] == 1) {
                                                                echo "active";
                                                            } else {
                                                                echo "inactive";
                                                            }
                                                        ?></td>
                                                    <td><input type="button" name="update" class="btn btn-secondary"
                                                               value="Update"
                                                               onclick="location.href='file-update.php?id_f=<?php echo $row['id_f']; ?>';">
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <input type="submit" name="deletebutton" class='btn btn-danger' data-bs-toggle='modal'
                                   data-bs-target='#warning' value="Delete">
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <footer class="footer">
            <div class=" container-fluid ">
                <div class="copyright" id="copyright">
                    &copy;
                    <script>
                        document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                    </script>
                    , KIDS-ZONE
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
<script language="JavaScript">
    function toggle(source) {
        checkboxes = document.getElementsByName('checkes[]');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
</body>
</html>
