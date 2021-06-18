<?php include "../template/header.php";
    include "../dao/database.php";
    $db = new database();
    //select mọi element trong category rau quả
    $string = "vegetables";
    $query = "select sr.name from storage sr join category c on c.id_c=sr.id_c where c.category_name like ?";
    $param = [
        $string
    ];
    $stmt = $db->EditDataParam($query, $param);
    //tạo array với mọi tên rau quả trong db
    $arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($arr, $row['name']);
    }
    //pick ngẫu nhiên 3 câu trả lời
    $question = array_rand($arr, 3);
    $questionname = array();
    foreach ($question as $value) {
        array_push($questionname, $arr[$value]);
    }
    //select hình ngẫu nhiên trong 3 câu trả lời
    $answer = array_rand($questionname, 1);
    $pic = "%" . $questionname[$answer] . "%";
    $query = "select fl.file_name from file fl join storage sr on sr.id_e = fl.id_e where sr.name like ? and fl.file_type=?";
    $param = [
        $pic,
        0
    ];
    $stmt = $db->EditDataParam($query, $param);
    $radpic = $stmt->fetch(PDO::FETCH_ASSOC);
    //shuffle 3 câu trả lời
    shuffle($question);
    $db->CloseConn();
?>
<link type="text/css" rel="stylesheet" href="css/vegetables.css?v=1"/>
<section class="bg">
    <div class="container">
        <form method="post">
            <img src="images/<?php echo $radpic['file_name']; ?>" width="200px" id="img"><br/>
            <h2 class="text-warning">which one is the correct answer?</h2><br/>
            <div class="container">
                <div class="row">
                    <!--bắt đầu trải dài 3 câu trả lời ra nút-->
                    <?php
                        $i = 0;
                        while ($i < 3) {
                            ?>
                            <div class="col"><input class="btn btn-primary" type="button" name="answers"
                                                    value="<?php echo $arr[$question[$i]]; ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="<?php echo ($questionname[$answer] == $arr[$question[$i]]) ? "#correctmodal" : "#uncorrectmodal"; ?>">
                            </div>
                            <?php
                            $i++;
                        }
                    ?>
                </div>
            </div>
            <!--correct modal-->
            <div class="modal fade" id="correctmodal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                <div class="modal-dialog" style="padding-top:150px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Congratulation</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="images/happy.png" width="200px" id="star"><br/>
                            <h1>CORRECT!</h1>
                        </div>
                        <div class="modal-footer position-relative" style="height: 50px">
                            <button type="button" class="btn btn-success position-absolute bottom-0 end-0"
                                    data-bs-dismiss="modal" id="homepage" onclick="window.location.reload();">Next
                            </button>
                            <button type="button" class="btn btn-primary position-absolute bottom-0 start-0"
                                    data-bs-dismiss="modal">close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--uncorrect modal-->
            <div class="modal fade" id="uncorrectmodal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true"
                 data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog" style="padding-top:200px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Sorry...</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="images/sad.png" width="200px" id="brokenstar"><br/>
                            <h1>INCORRECT!</h1>
                        </div>
                        <div class="modal-footer position-relative" style="height: 50px">
                            <button type="button" class="btn btn-primary position-absolute bottom-0 end-0"
                                    data-bs-dismiss="modal">Try again
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
<?php include "../template/footer.php"; ?>
