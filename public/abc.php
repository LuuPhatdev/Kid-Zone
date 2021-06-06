<?php include "../template/header.php";
?>
<link rel="stylesheet" type="text/css" href="./css/abc.css"/>
<div class="container">
    <?php
        $string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $length = strlen($string);

        echo "<table>";

        for ($i = 0; $i < $length; $i++) {
            if ($i % 4 == 0) echo "<tr>";
            echo "<td>" . $string[$i] . "</td>";
            if ($i % 4 == 3 || $i == $length) echo "</tr>";
        }
    ?>
</div>
<?php include "../template/footer.php"; ?>

