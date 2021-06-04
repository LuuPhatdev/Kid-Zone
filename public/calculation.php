<?php include "../template/header.php";
?>
<form method="post">
    <div class="container">
        <label for="username">username</label>
        <input type="text" name="username" id="username"><br/>
        <label for="password">password</label>
        <input type="text" name="password" id="password"><br/>
        <input type="submit" name="Login" value="Login">
        <input type="submit" name="Register" value="Register">
    </div>
</form>
<?php include "../template/footer.php";
?>
