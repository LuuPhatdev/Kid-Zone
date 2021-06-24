<?php include "../template/header.php";
    include "../dao/database.php";
    $db = new database();
    $query = "select f.file_name, sr.name from file f join storage sr on f.id_e = sr.id_e where f.file_type=1 and id_c=2 and f.active=1";
    $stmt = $db->EditData($query);
?>
<link rel="stylesheet" type="text/css" href="./css/abc.css?v=3"/>
<script>
    function play(i) {
        let myAudio = document.getElementById("audio" + i);
        myAudio.play();
    }
</script>
<section class="bg">
    <section>
        <div class="container">
            <div class="grid-container">
                <?php
                    $i = 0;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        if ($i % 4 == 0)
                            ?>
                            <div class="grid-item"  id="<?php echo $i ?>" onclick="play(<?php echo $i ?>)">
                        <img src="images/<?php echo $row['name']; ?>"/>
                        <audio id="<?php echo 'audio' . $i ?>" src="voice/<?php echo $row['file_name']; ?>"
                               type="audio/wav"></audio>
                        </div>
                        <?php
                        $i++;
                    }
                    $db->CloseConn();
                ?>
            </div>
        </div>
    </section>
</section>

<?php include "../template/footer.php"; ?>

