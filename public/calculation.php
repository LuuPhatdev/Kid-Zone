<?php
    include "../dao/database.php";
    $db = new database();
    $query = "select s.name, f.file_name "
        . "from category c inner join storage s on c.id_c = s.id_c "
        . "inner join file f on s.id_e = f.id_e "
        . "where c.category_name like 'calculation' "
        . "order by s.id_e";
    $result = $db->EditData($query);
    $calculation = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        array_push($calculation, $row);
    }
    // bảng STORAGE, field NAME cần phải thêm điều kiện unique not null, nếu không đoạn code này phải viết thêm điều kiện
    for ($i = count($calculation) - 1; $i > 0; $i--) {
        if ($calculation[$i]['name'] == $calculation[$i - 1]['name']) {
            $calculation[$i] = $calculation[count($calculation) - 1];
            array_pop($calculation);
        }
    }
    $cal = array();
    $temp2 = array();
    foreach ($calculation as $key => $value) {
        $temp2[$calculation[$key]['name']] = $calculation[$key]['file_name'];
        $cal = array_merge($cal, $temp2);
    }
    if (!(isset($cal["plus-sign"]) && isset($cal["minus-sign"]))) {
        die("<script language='JavaScript'>alert('ERROR: INSUFFICIENT PICTURES FROM DATABASE')</script>");
    }
    $z = rand(0, 1);
    $a = rand(0, 9);
    if ($z == 1) {
        $b = rand(0, 9);
    } else {
        $b = rand(0, $a);
    }
    include "../template/header.php";
?>
<link rel="stylesheet" type="text/css" href="css/calculation.css?v=3"/>
<section class="calculation">
    <div class="container">
        <?php
            for ($i = 0; $i < 10; $i++) {
                if (isset($cal["number-" . $i])) {
                    echo "<img src='images/" . $cal["number-" . $i] . "' style='width:200px' id='number-" . $i . "' onclick='input(this)'>";
                } else {
                    die("<script language='JavaScript'>alert('ERROR: INSUFFICIENT PICTURES FROM DATABASE')</script>");
                }
            }
        ?>
        <div class="result">
            <img src="images/<?= $cal["number-" . $a] ?>" style="width: 150px" id="first-number" alt="<?= $a ?>">
            <img src="images/<?= ($z) ? $cal["plus-sign"] : $cal["minus-sign"] ?>" style="width:100px"
                 id="plus-or-minus"
                 alt="<?= $z ?>">
            <img src="images/<?= $cal["number-" . $b] ?>" style="width: 150px" id="second-number" alt="<?= $b ?>">
            <img src="images/<?= $cal["equal-sign"] ?>" style="width: 100px">
            <img id="img-x" src="" style="width: 150px">
            <img id="img-y" src="" style="width: 150px">
        </div>
        <div class="d-flex justify-content-center">
            <button id="submit" class="btn btn-info" data-bs-toggle='modal' data-bs-target="#incorrect">SUBMIT</button>
        </div>
    </div>
</section>


<div class="modal fade" id="correct" tabindex="-1" aria-labelledby="correct" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Correct</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="images/star.jpg" alt="star" style="width:100px">
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
<script src="js/calculation.js"></script>


<?php include "../template/footer.php";
?>
