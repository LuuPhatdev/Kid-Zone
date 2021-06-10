<?php
    include "../dao/database.php";
    $db= new database();
    $query="select sr.name, f.file_name, sr.description from file f join storage sr on sr.id_e = f.id_e where sr.id_c=1";
    $stmt=$db->EditData($query);
    $db->CloseConn();
?>
<?php include "../template/header.php"; ?>
<link rel="stylesheet" type="text/css" href="css/homepage.css?v=1">
<link href='https://fonts.googleapis.com/css?family=Bubblegum Sans' rel='stylesheet'>
<div id="banner" class="position-relative p-5">
    <h1 class="position-absolute top-0 start-0" id="welcome">WELCOME</h1><br/>
    <h1 class="position-absolute top-50 start-50 translate-middle">TO</h1><br/>
    <h1 class="position-absolute bottom-0 end-0" id="kidzone">KIDZONE!</h1>
</div>
<?php
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $lowcase=strtolower($row['name']);
        ?>
        <div class="container-fluid" id="<?php echo $row['name'];?>">
            <h1 class="text-center"><?php echo $row['name'];?></h1><br/>
            <!--            file hinh lay tu db-->
            <img src="images/<?php echo $row['file_name'];?>" class="img-fluid" onmouseover="imageEnlarge();" onmouseleave="imageReset();">
            <div class="text-center description">
                <!--                description lay tu db-->
                <p><?php echo $row['description'];?></p>
                <a class="btn btn-primary button" href="<?php echo "$lowcase.php";?>" role="button">Let Go!</a>
            </div>
        </div>
        <?php
    }
?>
<?php include "../template/footer.php"; ?>



