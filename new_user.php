<!-- Link to Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
    }
    input {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        background-color: #4caf50;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
    }

    button:hover {
        background-color: #45a049;
    }

.login .notice-error {
    border-left-color: #d63638 !important;
}


</style>
<div class="container">
<?php
if(isset($_SESSION['msg'])){
?>
    <div id="login_error" >
        <ul class="login-error-list">
            <li><strong>Error:</strong> <?php echo $_SESSION['msg'] ?></li>
        </ul>
    </div>
<?php
}
?>
    <form action="" method="post">
        <label for="username">اسم المستخدم:</label>
        <input type="text" id="username" name="username" class="form-control" required>
        <label for="password">كلمة المرور:</label>
        <input type="password" id="password" name="password" class="form-control" required>

        <label for="confirm-password">تأكيد كلمة المرور:</label>
        <input type="password" id="confirm-password" class="form-control" name="confirm_password" required>
            <?php wp_nonce_field('my_action', 'my_nonce'); ?>


        <button type="submit" class="btn btn-primary" name="submit_registration" </button>تسجيل</button>
    </form>
<?php
if (isset($_SESSION['new_user']) && !empty($_SESSION['new_user'])) {
?>
<div class="alert alert-danger">
  <strong>خطأ!</strong> <?php echo $_SESSION['new_user'] ?>
</div>
<?php
}
?>
</div>
<!-- Link to Bootstrap JS and Popper.js -->
