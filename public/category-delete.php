<?php
//session_start();
//if(!isset($_SESSION['your_name'])){
//    header("Location: login.php");
//}
if (isset($_GET['id'])) {
    include "../dao/database.php";
    $db = new Database();
    $query = "delete from file where ID_F in "
    . "( "
    . "select f.ID_F "
    . "from file f inner join storage s on f.ID_E = s.ID_E "
    . "inner join category c on s.ID_C = c.ID_C "
    . "where c.ID_C = ? "
    . "); "
    . "delete from storage where ID_E in "
    . "( "
    . "select s.ID_E "
    . "from storage s inner join category c on s.ID_C = c.ID_C "
    . "where c.ID_C = ? "
    . "); "
    . "delete from category where ID_C = ? ; ";
    $param = [
        $_GET['id'],
        $_GET['id'],
        $_GET['id']
    ];
    $db->EditDataParam($query, $param);
    $db->CloseConn();
    header("Location: category-show.php");
}
?>
