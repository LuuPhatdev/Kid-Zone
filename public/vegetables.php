<?php include "../template/header.php";
    include "../dao/database.php";
    $db = new database();
    $query = "select active from category where category_name like '%vegetables%'";
    $check = $db->EditData($query);
    $checkcate = $check->fetch(PDO::FETCH_ASSOC);
    $query = "select count(*) from storage sr join category c on c.id_c=sr.id_c where c.category_name like '%vegetables%' and sr.active=1";
    $count = $db->EditData($query);
    $countstorage = $count->fetch(PDO::FETCH_ASSOC);
    if (empty($checkcate)) {
        Message::ShowMessage("please make category named 'vegetables' and add data in it for this website to use");
    } elseif ($checkcate['active'] == 0) {
        Message::ShowMessage("please active category named 'vegetables' ");
    } elseif ($countstorage['count(*)'] < 3) {
        Message::ShowMessage("please active or add at least 3 new storages and new image file(s) for each to category vegetables");
    } else {
        $query = "select sr.name from storage sr join category c on c.id_c=sr.id_c where c.category_name like '%vegetables%' and sr.active=1";
        $selectallstorage = $db->EditData($query);
        $query = "select count(*) from file f join storage sr on sr.id_e=f.id_e where f.active=1 and sr.name = ? and f.file_type = 0";
        $countveget = 0;
        while ($rowcount = $selectallstorage->fetch(PDO::FETCH_ASSOC)) {
            $param = [
                $rowcount['name']
            ];
            $countfile = $db->EditDataParam($query, $param);
            $sumfile = $countfile->fetch(PDO::FETCH_ASSOC);
            if ($sumfile['count(*)'] == 0) {
                $countveget--;
                break;
            }
        }
        if ($countveget < 0) {
            Message::ShowMessage("please make sure that each active storage in vegetables has at least 1 active file that is image to use");
        } else {
            //select mọi element trong category rau quả
            $query = "select sr.name from storage sr join category c on c.id_c=sr.id_c where sr.active=1 and c.category_name like '%vegetables%'";
            $selectallname = $db->EditData($query);
            //tạo array với mọi tên rau quả trong db
            $arr = array();
            while ($row = $selectallname->fetch(PDO::FETCH_ASSOC)) {
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
            $query = "select fl.file_name from file fl join storage sr on sr.id_e = fl.id_e where sr.name like ? and fl.file_type=? and fl.active=?";
            $param = [
                $pic,
                0,
                1
            ];
            $stmt = $db->EditDataParam($query, $param);
            $radpic = $stmt->fetch(PDO::FETCH_ASSOC);
            //shuffle 3 câu trả lời
            shuffle($question);
        }
    }
    $db->CloseConn();
?>
<link type="text/css" rel="stylesheet" href="css/vegetables.css?v=1"/>
<?php
    if (isset($radpic)) {
        ?>
        <section class="bg">
            <div class="container">
                <form method="post">
                    <div class="mx-auto rounded-pill bg-light w-50 border border-primary">
                        <img src="images/<?php echo $radpic['file_name']; ?>" width="200px">
                    </div>
                    <h2 class="box sb w-50">which one is the correct answer?</h2><br/>
                    <div class="container">
                        <div class="row">
                            <!--bắt đầu trải dài 3 câu trả lời ra nút-->
                            <?php
                                $i = 0;
                                while ($i < 3) {
                                    ?>
                                    <div class="col"><input class="button btn btn-info text-black" type="button"
                                                            name="answers"
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
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3>Congratulation</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="images/happy.png" width="200px"><br/>
                                    <h1>CORRECT!</h1>
                                </div>
                                <div class="modal-footer position-relative" style="height: 50px">
                                    <button type="button" class="btn btn-primary position-absolute bottom-0 start-0"
                                            onclick="window.location.href='index.php';">Home page
                                    </button>
                                    <button type="button" class="btn btn-success position-absolute bottom-0 end-0"
                                            data-bs-dismiss="modal" id="homepage" onclick="window.location.reload();">
                                        Next Question
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--uncorrect modal-->
                    <div class="modal fade" id="uncorrectmodal" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true"
                         data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3>Sorry</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="images/sad.png" width="200px"><br/>
                                    <h2>INCORRECT!</h2>
                                </div>
                                <div class="modal-footer position-relative" style="height: 50px">
                                    <button type="button" class="btn btn-primary position-absolute bottom-0 start-0"
                                            data-bs-dismiss="modal">Try again?
                                    </button>

                                    <button type="button" class="btn btn-success position-absolute bottom-0 end-0"
                                            onclick="window.location.reload();">Next Question
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </section>
        <?php
    }
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>

<?php include "../template/footer.php";
?>
