<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header("Location: category-show.php");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        while (0 == 0) {
            include "../dao/database.php";
            $_POST['user_name'] = trim($_POST['user_name']);
            $_POST['password'] = trim($_POST['password']);
            if ($_POST['user_name'] == '' || $_POST['password'] == '') {
                Message::ShowMessage('Username and password cannot be blank!');
                break;
            }
            if (strlen($_POST['user_name']) > 15 || strlen($_POST['password']) > 15) {
                Message::ShowMessage('Username and password cannot be longer than 15 characters!');
                break;
            }
            if ($_POST['password'] != $_POST['repassword']) {
                Message::ShowMessage('You must retype your password correctly!');
                break;
            }
            if (!preg_match("/[a-zA-Z0-9]/i",$_POST['user_name'])){
                Message::ShowMessage('Your username cannot have special characters!');
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
            $pawword_hashed=password_hash($_POST['password'], PASSWORD_DEFAULT);
            $query = "insert into admin (user_name, password) values (?,?)";
            $params = [
                $_POST['user_name'],
                $pawword_hashed
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