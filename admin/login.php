<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header("Location:");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include "../dao/database.php";
        $db = new Database();

        if (isset($_POST['sign_in'])) {
            if (isset($_POST['user_name']) && isset($_POST['password'])) {
                if ($_POST['user_name'] === "" || $_POST['password'] === "") {
                    Message::ShowMessage("username or password not filled yet");
                } else {
                    if (ctype_alnum($_POST['user_name']) && ctype_alnum($_POST['password'])) {
                        $query = "select * from admin where user_name=?";
                        $param = [
                            $_POST['user_name']
                        ];
                        $stmt = $db->EditDataParam($query, $param);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        if (empty($row)) {
                            Message::ShowMessage("wrong username or password");
                        } else {
                            if ($row['password'] === $_POST['password']) {
                                $_SESSION['user'] = $_POST['user_name'];
                                $_SESSION['login'] = "log_in";
                                //dia chi cua show luu tru de o day
                                header("Location: category-show.php");
                            } else {
                                Message::ShowMessage("wrong username or password");
                            }
                        }

                    } else {
                        Message::ShowMessage("special letters are not allowed");
                    }
                }
            }
        }

        if (isset($_POST['register'])) {
            $_SESSION['register'] = "register";
            header("Location:register.php");
        }
        $db->CloseConn();

    }
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<div class="main">
    <!-- Sing in  Form -->
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                    <a href="./register.php" class="signup-image-link">Create an account</a>
                </div>

                <div class="signin-form">
                    <h2 class="form-title">Sign in</h2>
                    <form method="POST" class="register-form" id="login-form">
                        <div class="form-group">
                            <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="user_name" id="your_name" placeholder="Your Name"/>
                        </div>
                        <div class="form-group">
                            <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="your_pass" placeholder="Password"/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="remember-me" id="remember-me" class="agree-term"/>
                            <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember
                                me</label>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="sign_in" id="signin" class="form-submit" value="Log in"/>
                        </div>
                    </form>
                    <div class="social-login">
                        <span class="social-label">Or login with</span>
                        <ul class="socials">
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>

