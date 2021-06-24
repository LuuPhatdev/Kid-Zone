<?php include '../template/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $to      = 'phat.dl545@aptechlearning.edu.vn';
    $subject = 'Contact Form';
    $message = $_POST['message'];
    $content="From: $name \n Message: $message";
    $headers = "From: $email" . "\r\n" ;
    mail($to, $subject, $message, $headers,$content);
    echo "Thank You!";
    }
?>

    <link rel="stylesheet" type="text/css" href="css/contact.css?v=3">
    <section class="contact-us">
        <div class="container">
            <form action="#" method="POST" class="contact">
                <p>Name</p> <input type="text" name="name">
                <p>Email</p> <input type="text" name="email">
                <p>Message</p><textarea name="message" rows="6" cols="25"></textarea><br/>
                <input type="submit" value="Send" style="margin-bottom:20px; color:#68C2E8;"><br/>
                <input type="reset" value="Clear" style="color:#68C2E8">
            </form>
        </div>
    </section>
<?php include '../template/footer.php' ?>