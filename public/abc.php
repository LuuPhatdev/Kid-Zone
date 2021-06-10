<?php include "../template/header.php";
    include "../dao/database.php";
    $db = new database();
    $query = "select f.file_name, sr.name from file f join storage sr on f.id_e =sr.id_e where f.file_type=1 and id_c=2 ";
    $stmt = $db->EditData($query);
?>
<link rel="stylesheet" type="text/css" href="./css/abc.css?v=1"/>
<div class="bg">
    <div class="container">
        <section>
            <div class="grid-container">
                <?php
                    $i = 0;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if ($i % 4 == 0)
                        ?>
                        <div class="grid-item" onclick="play<?php echo $row['name']; ?>()"><?php echo $row['name']; ?>
                            <audio id="<?php echo $row['name']; ?>" src="voice/<?php echo $row['file_name']; ?>"
                                   type="audio/wav"></audio>
                        </div>

                        <script>
                            function play<?php echo $row['name']; ?>() {
                                let myAudio = document.getElementById("<?php echo $row['name'];?>");
                                myAudio.play();
                            }
                        </script>
                        <?php
                    }
                    $db->CloseConn();
                ?>
            </div>
        </section>
    </div>
</div>

<?php include "../template/footer.php"; ?>

