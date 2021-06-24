<?php
    include "../dao/database.php";
    $db = new database();
    $query = "select distinct s.id_e "
        . "from storage s inner join category c on s.id_c = c.id_c "
        . "inner join file f on s.id_e = f.id_e "
        . "where c.category_name like 'vehicle' and f.file_type = 0 and f.active = 1 "
        . "order by rand() "
        . "limit 3";
    $result = $db->EditData($query);
    $query = "select F.file_name "
        . "from storage S inner join file F on S.id_e = F.id_e "
        . "inner join category C on S.id_c = C.id_c "
        . "where C.category_name like 'vehicle' and S.id_e = ? and F.file_type = 0 and f.active = 1 "
        . "limit 1";
    $vehicles = array();

    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $result2 = $db->EditDataParam($query, $row);
        $row2 = $result2->fetch(PDO::FETCH_NUM);
        $merged = array_merge($row, $row2);
        array_push($vehicles, $merged);
    }
    if (count($vehicles) < 3) {
        die("<script language='JavaScript'>alert('ERROR: INSUFFICIENT PICTURES OF VEHICLES FROM DATABASE')</script>");
    }
    $correct = rand(0, 2);
    $buttons = ['A', 'B', 'C'];
    $query = "select name from storage where id_e = ?";
    $param = [
        $vehicles[$correct][0]
    ];
    $result3 = $db->EditDataParam($query, $param);
    $row3 = $result3->fetch(PDO::FETCH_NUM);
    include "../template/header.php";
?>

<link rel="stylesheet" type="text/css" href="css/vehicles.css?v=1">
<section class="vehicle">
    <div class="container text-warning">
        <div class="dia-box">

            <img src="images/pink-dialogue.png" alt="" class="dia-pic">
            <div class="dia-text">
                <h3>which picture is <?= $row3[0] ?> ?</h3>
            </div>

        </div>
        <div class="row">
            <?php
                for ($i = 0; $i < 3; $i++) {
                    echo "<div class='col'><button class='btn btn-warning btn-circle btn-lg' data-bs-toggle='modal' data-bs-target=" . (($i == $correct) ? '#correct' : '#incorrect') . ">".$buttons[$i]."</button><img src='images/" . $vehicles[$i][1] . "' class='vehicles' ></div>";
                }
            ?>
        </div>
    </div>

    <div class="modal fade" id="correct" tabindex="-1" aria-labelledby="correct" aria-hidden="true">
        <div class="modal-dialog" style="padding-top:200px">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Congratulation</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="images/carfun.png" width="200px" id="star"><br/>
                    <h1>CORRECT!</h1>
                </div>
                <div class="modal-footer position-relative" style="height: 50px">
                    <button type="button" class="btn btn-success position-absolute bottom-0 end-0"
                            data-bs-dismiss="modal" id="homepage" onclick="window.location.reload();">Next Question
                    </button>
                    <button type="button" class="btn btn-primary position-absolute bottom-0 start-0"
                            onclick="window.location.href='index.php';">Home page
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="incorrect" tabindex="-1" aria-labelledby="incorrect" aria-hidden="true">
        <div class="modal-dialog" style="padding-top: 200px">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Sorry</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="images/carsad.png" width="200px" ><br/>
                    <h1>INCORRECT!</h1>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-primary start-0" data-bs-dismiss="modal">Try again</button>
                    <button type="button" class="btn btn-success end-0" onclick="window.location.reload();">Next Question</button>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include "../template/footer.php";
?>
