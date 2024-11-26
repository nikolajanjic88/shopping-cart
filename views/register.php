<?php
    include_once 'inc/head.php';
    include_once 'inc/nav.php';
?>

<div class="account-page">
    <div class="container">
        <div class="row">
            <div class="col-2">
                <img src="images/image1.png" width="100%">
            </div>
            <div class="col-2">
                <div class="form-container">
                    <div class="form-btn">
                        <span>Register</span>
                    </div>
                    <form action="" method="post">
                        <input  type="text" 
                                name="name" 
                                placeholder="Full name" 
                                value="<?= $_POST['name'] ?? null ?>"
                        >
                        <?php if(isset($errors['name'])): ?>
                        <p class="error"><?= $errors['name'] ?></p>
                        <?php endif ?>
                        <input  type="text" 
                                name="email" 
                                placeholder="email" 
                                value="<?= $_POST['email'] ?? null ?>"
                        >
                        <?php if(isset($errors['email'])): ?>
                        <p class="error"><?= $errors['email'] ?></p>
                        <?php endif ?>
                        <input  type="password" 
                                name="password" 
                                placeholder="password"
                        >
                        <?php if(isset($errors['password'])): ?>
                        <p class="error"><?= $errors['password'] ?></p>
                        <?php endif ?>
                        <input  type="password"
                                name="confirm_password" 
                                placeholder="Confirm password"
                        >
                        <?php if(isset($errors['confirm_password'])): ?>
                        <p class="error"><?= $errors['confirm_password'] ?></p>
                        <?php endif ?>
                        <button class="btn">Register</button>
                    </form>
                    <p>Alredy registered? <a href="/login">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include_once 'inc/footer.php';
?>