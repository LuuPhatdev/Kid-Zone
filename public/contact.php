<?php include '../template/header.php'; ?>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $from = $email;
        $to = 'phat.dl545@aptechlearning.edu.vn';
        $subject = 'Contact Us';
        $message = $_POST['message'];
        $send = mail( $to, $subject, $message,$from);

        if ($send) {
            echo "<script>alert('Success');</script>";
        } else {
            echo "<script>alert('Fail');</script>";
        }
    }
?>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css?v=2">
    <link rel="stylesheet" type="text/css" href="css/contact.css?v=3">
    <section class="contact-us">
        <div class="container">
            <div><h1 style="color: #68C2E8">Contact Us</h1></div>
            <br/>
            <div class="row">
                <div class="col-md-6">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4241674197965!2d106.68784161528392!3d10.77878916209632!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3a9d8d1bb3%3A0x1cf755f02e5a8b48!2zMjEyIE5ndXnhu4VuIMSQw6xuaCBDaGnhu4N1LCBQaMaw4budbmcgNiwgUXXhuq1uIDMsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1624609697075!5m2!1sen!2s"
                            height="350" style="border:0; width:100%; height:350px;" id="googlemap" allowfullscreen=""
                            loading="lazy"></iframe>
                </div>
                <br/>
                <div class="col-md-6">
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="form-name">Name</label>
                            <input type="name" class="form-control" id="form-name" placeholder="Name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="form-email">Email Address</label>
                            <input type="email" class="form-control" id="form-email" placeholder="Email Address"
                                   name="email">
                        </div>
                        <div class="form-group">
                            <label for="form-message">Message</label>
                            <textarea class="form-control" id="form-message" placeholder="Message"
                                      name="message"></textarea>
                        </div>
                        <button class="btn-contact" type="submit">Contact Us</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <style>
        label {
            font-family: Prompt;
            color: #68C2E8;
        }

        .my-form {
            color: #305896;
        }

        .my-form .btn-default {
            background-color: #0dcaf0;
            color: #fff;
            border-radius: 25px;
        }

        .my-form .btn-default:hover {
            background-color: #4498C6;
            color: #fff;
        }

        .my-form .form-control {
            border-radius: 0;
        }
    </style>
    <script src="./js/jquery-1.10.2.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            // Google Maps setup
            var googlemap = new google.maps.Map(
                document.getElementById('googlemap'),
                {
                    center: new google.maps.LatLng(10.778784602143634, 106.69003480973107),
                    zoom: 8,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
            );
        });
    </script>
<?php include '../template/footer.php' ?>