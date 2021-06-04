<?php include "../template/header.php";
?>
    <h4 class="mt-5 mb-3 text-center">REGISTER ACCOUNT</h4>
    <div class="d-flex justify-content-center">
        <form action="#" method="POST" class="w-50">
            <div class="mb-3 row">
                <label for="user" class="col-sm-4 col-form-label">Your new username:</label>
                <div class="col-sm-8">
                    <input type="text" name="user" id="user" class="form-control">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="pass" class="col-sm-4 col-form-label">Your new password:</label>
                <div class="col-sm-8">
                    <input type="password" name="pass" id="pass" class="form-control">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="repass" class="col-sm-4 col-form-label">Re-enter your password:</label>
                <div class="col-sm-8">
                    <input type="password" name="repass" id="repass" class="form-control">
                </div>
            </div>
            <br />
            <div class="d-flex justify-content-center">
                <input class="concept" type="submit" class="btn btn-info" value="Register">
            </div>
        </form>
    </div>
<?php include "../template/footer.php";
?>