<?php
session_start();
if(isset($_SESSION['your_name'])){
    //dia chi của show luu tru o day
    header("Location:");
}
if($_SERVER['REQUEST_METHOD']==='POST')
{
    //dia chi cua file trong dao
    include "../dao/database.php";
    $db = new Database();
    if(isset($_POST['signin'])){
        if(isset($_POST['your_name'])&&isset($_POST['your_pass']))
        {
            if($_POST['your_name']===""||$_POST['your_pass']===""){
                Message::ShowMessage("username or password not filled yet");
            }else{
                if(ctype_alnum($_POST['your_name']) && ctype_alnum($_POST['your_pass'])){
                    $query="select * from ADMIN where USER=?";
                    $param=[
                        $_POST['your_name']
                    ];
                    $stmt=$db->EditDataParam($query, $param);
                    $row=$stmt->fetch(PDO::FETCH_ASSOC);
                    if(empty($row)){
                        Message::ShowMessage("wrong username or password");
                    }else{
                        if($row['PASS']===$_POST['your_pass']){
                            $_SESSION['your_name']=$_POST['your_name'];
                            $_SESSION['login']="Login";
                            //dia chi cua show luu tru de o day
                            header("Location:index.php");
                        }else{
                            Message::ShowMessage("wrong username or password");
                        }
                    }

                }else{
                    Message::ShowMessage("special letters are not allowed");
                }
            }
        }
    }
    if(isset($_POST['Register'])){
        $_SESSION['Register']="Register";
        //dia chi cua page register
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
                            <input type="text" name="your_name" id="your_name" placeholder="Your Name"/>
                        </div>
                        <div class="form-group">
                            <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="your_pass" id="your_pass" placeholder="Password"/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="remember-me" id="remember-me" class="agree-term"/>
                            <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember
                                me</label>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
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

