<?php
    include "../dao/database.php";
    $db = new database();
    $query = "select sr.name, f.file_name, sr.description from file f join storage sr on sr.id_e = f.id_e where sr.id_c=1";
    $stmt = $db->EditData($query);
    $db->CloseConn();
?>
<?php include "../template/header.php"; ?>
<link rel="stylesheet" type="text/css" href="css/homepage.css?v=3">
<link href='https://fonts.googleapis.com/css?family=Bubblegum Sans' rel='stylesheet'>
<section class="homepage">
    <div class="introduct-banner"></div>
</section>
<section class="course category-course">
    <div class="container">
        <div class="row ">
            <div class="col zoom">
                <div class="card">
                    <a href="abc.php">
                        <img src="images/alphabet-course.jpg" alt="Avatar" style="width:100%">
                    </a>
                    <div class="container">
                        <a class="title" href="abc.php"><b>ABC</b></a>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                </div>
            </div>
            <div class="col zoom">
                <div class="card">
                    <a href="calculation.php">
                        <img src="images/math-course.jpg" alt="Avatar" style="width:100%">
                    </a>
                    <div class="container">
                        <a class="title" href="calculation.php"><b>Math</b></a>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                </div>
            </div>
            <div class="col zoom">
                <div class="card">
                    <a href="vegetables.php">
                        <img src="images/vegetable-course.jpg" alt="Avatar" style="width:100%">
                    </a>
                    <div class="container">
                        <a class="title" href="vegetables.php"><b>Vegetables</b></a>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                </div>
            </div>
            <div class="col zoom">
                <div class="card">
                    <a href="vehicles.php">
                        <img src="images/vehicles-course.jpg" alt="Avatar" style="width:100%">
                    </a>
                    <div class="container">
                        <a class="title" href="vehicles.php"><b>Vehicles</b></a>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "../template/footer.php"; ?>



