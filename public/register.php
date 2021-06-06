<?php
    session_start();
    if (isset($_SESSION['username'])) {
        header("Location:");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        while (0 == 0) {
            include "../dao/database.php";
            if (trim($_POST['user_name']) == '' || trim($_POST['password']) == '') {
                Message::ShowMessage('Username and password cannot be blank!');
                break;
            }

            if ($_POST['password'] != $_POST['repassword']) {
                Message::ShowMessage('You must retype your password correctly!');
                break;
            }

            $db = new Database();
//          check for existing username
            $query = "select user_name from admin";
            $temp = 1;
            $stmt = $db->EditData($query);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($_POST['user_name'] == $row['user_name']) {
                    $db->CloseConn();
                    Message::ShowMessage('There already exists this username!');
                    $temp = 0;
                    break;
                }
            }

            if ($temp == 0) {
                break;
            }

//          insert to db
            $query = "insert into admin (user_name, password) values (?,?)";
            $params = [
                $_POST['user_name'],
                $_POST['password']
            ];

            $db->EditDataParam($query, $params);
            $db->CloseConn();
            header("Location:login.php");
        }
    }
?>
<link rel="stylesheet" type="text/css" href="css/login.css">
<div class="main">
    <!-- Register form -->
    <section class="signup">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title"> Sign up </h2>
                    <form method="POST" class="register-form" id="register-form">
                        <div class="form-group">
                            <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="user_name" id="name" placeholder="Your Name"/>
                        </div>
                        <div class="form-group">
                            <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="pass" placeholder="Password"/>
                        </div>
                        <div class="form-group">
                            <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                            <input type="password" name="repassword" id="re_pass" placeholder="Repeat your password"/>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                        </div>
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                    <a href="./login.php" class="signup-image-link"> I am already member </a>
                </div>
            </div>
        </div>
    </section>
</div>