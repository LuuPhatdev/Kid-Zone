<?php include "../template/header.php";
    include "../dao/database.php";
    $db = new database();
    $query = "select f.file_name, sr.name from file f join storage sr on f.id_e=sr.id_e where f.file_type=1";
    $stmt = $db->EditData($query);
?>
<link rel="stylesheet" type="text/css" href="./css/abc.css"/>
<div class="container">
    <div class="grid-container">
        <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>

                <div class="grid-container">
                    <div class="grid-item" onclick="play()"><?php echo $row['name']; ?>
                        <audio id="audio" src="voice/<?php echo $row['file_name']; ?>" type="audio/wav"></audio>
                    </div>
                </div>
                <?php
            }
            $db->CloseConn();
        ?>
    </div>

    <script>
        function play() {
            let myAudio = document.getElementById("audio");
            myAudio.play();
        }
    </script>
</div>
<?php include "../template/footer.php"; ?>

