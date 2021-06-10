<?php include "../template/header.php";
    include "../dao/database.php";
    $db = new database();
    //select mọi element trong category rau quả
    $query = "select name from storage where id_c=1";
    $stmt = $db->EditData($query);
    //tạo array với mọi tên rau quả trong db
    $arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($arr, $row['name']);
    }
    //pick ngẫu nhiên 3 câu trả lời
    $question = array_rand($arr, 3);
    //select hình ngẫu nhiên trong 3 câu trả lời
    $pic = $arr[array_rand($question, 1)];
    $query = "select fl.file_name from file fl inner join storage sr on sr.id_e = fl.id_e where sr.name like ? and fl.file_type=0";
    $param = [
        $pic
    ];
    $stmt = $db->EditDataParam($query, $param);
    $radpic = $stmt->fetch(PDO::FETCH_ASSOC);
    //shuffle 3 câu trả lời
    shuffle($question);
    $db->CloseConn();
?>
<div class="text-center">
    <form method="post">
        <img src="img/<?php echo $radpic['file_name']; ?>" width="200px" id="img"><br/>
        <h2>which one is the correct answer?</h2><br/>
        <div class="container">
            <div class="row">
                <!--                    bắt đầu trải dài 3 câu trả lời ra nút-->
                <?php
                    $i = 0;
                    while ($i < 3) {
                        ?>
                        <div class="col"><input type="button" name="answers" value="<?php echo $arr[$question[$i]]; ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="<?php echo ($pic == $arr[$question[$i]]) ? "#correctmodal" : "#uncorrectmodal"; ?>">
                        </div>
                        <?php
                        $i++;
                    }
                ?>
            </div>
        </div>
        <!--        correct modal-->
        <div class="modal fade" id="correctmodal" tabindex="-1" aria-labelledby="exampleModalLabel"
             data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <img src="img/star.jpg" width="200px" id="star"><br/>
                        <h1>CORRECT!</h1>
                    </div>
                    <div class="modal-footer position-relative" style="height: 50px">
                        <button type="button" class="btn btn-secondary position-absolute bottom-0 start-0"
                                data-bs-dismiss="modal" id="homepage" onclick="window.location.reload();">Try again?
                        </button>
                        <button type="button" class="btn btn-primary position-absolute bottom-0 end-0"
                                onclick="window.location.href='index.php';">Homepage
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--        uncorrect modal-->
        <div class="modal fade" id="uncorrectmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
             data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <img src="img/brokenstar.jpg" width="200px" id="brokenstar"><br/>
                        <h1>UNCORRECT...</h1>
                    </div>
                    <div class="modal-footer position-relative" style="height: 50px">
                        <button type="button" class="btn btn-secondary position-absolute bottom-0 start-0"
                                data-bs-dismiss="modal">Try again?
                        </button>
                        <button type="button" class="btn btn-primary position-absolute bottom-0 end-0"
                                onclick="window.location.href='index.php';">Homepage
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>

<?php include "../template/footer.php";
?>
