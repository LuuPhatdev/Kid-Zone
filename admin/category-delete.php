<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location:login.php");
}
if (isset($_GET['id'])) {
    include "../dao/database.php";
    $db = new Database();
//    check whether the category is truly inactive
    $query = "select active from category where id_c = ?";
    $param = [
        $_GET['id']
    ];
    $result = $db->EditDataParam($query, $param);
    $result_array = $result->fetch(PDO::FETCH_NUM);
    if ($result_array[0] == 1) {
        $db->CloseConn();
        header("Location: category-show.php");
    } else {
        //    actual delete
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

}
?>
