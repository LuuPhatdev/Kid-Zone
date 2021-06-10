<?php
    include "../dao/database.php";
    $db = new database();
    $query = "select id_e from storage order by rand() limit 3";
    $result = $db->EditData($query);
    $query = "select F.file_name "
        . "from storage S inner join file F on S.id_e = F.id_e "
        . "inner join category C on S.id_c = C.id_c "
        . "where C.category_name like 'vehicle' and S.id_e = ? and F.file_type = 0 "
        . "limit 1";
    $vehicles = array();

    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $result2 = $db->EditDataParam($query, $row);
        $row2 = $result2->fetch(PDO::FETCH_NUM);
        $merged = array_merge($row, $row2);
        array_push($vehicles, $merged);
    }

    $correct = rand(0, 2);
    $query = "select name from storage where id_e = ?";
    $param = [
        $vehicles[$correct][0]
    ];
    $result3 = $db->EditDataParam($query, $param);
    $row3 = $result3->fetch(PDO::FETCH_NUM);
    include "../template/header.php";
?>

<div class="container text-warning">
    <h3>which picture is <?= $row3[0] ?> ?</h3>
    <div class="row">
        <?php
            for ($i = 0; $i < 3; $i++) {
                echo "<div class='col'><img src='images/" . $vehicles[$i][1] . "' style='width:100px;height:100px;object-fit: cover;' data-bs-toggle='modal' data-bs-target=" . (($i == $correct) ? '#correct' : '#incorrect') . "></div>";
            }
        ?>
    </div>
</div>

<div class="modal fade" id="correct" tabindex="-1" aria-labelledby="correct" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Correct</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="../../../../xampp/htdocs/Kid-Zone/public/images/star.jpg" alt="star" style="width:100px">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="location.reload();">Try Again</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="incorrect" tabindex="-1" aria-labelledby="incorrect" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Incorrect</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                TRY AGAIN PLEASE
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="location.reload();">Try Again</button>
            </div>
        </div>
    </div>
</div>
<?php include "../template/footer.php";
?>
