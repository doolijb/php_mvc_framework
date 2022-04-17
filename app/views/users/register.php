<?php require APPROOT . '/views/includes/head.php'; ?>

<div id="navbar">
    <?php require APPROOT . '/views/includes/navigation.php' ?>
</div>

<div id="container-form">
    <div id="wrapper-form">
        <h2>Register</h2>

        <form action="<?=URLROOT?>/users/register" method="POST">
            <input type="text" placeholder="Username *" name="username" value="<?=$data['username']?>">
            <span class="invalidfeedback">
                <?=$data['usernameError']?>
            </span>
            <input type="email" placeholder="Email *" name="email" value="<?=$data['email']?>">
            <span class="invalidfeedback">
                <?=$data['emailError']?>
            </span>
            <input type="password" placeholder="Password *" name="password">
            <span class="invalidfeedback">
                <?=$data['passwordError']?>
            </span>
            <input type="password" placeholder="Confirm password *" name="confirmPassword">
            <span class="invalidfeedback">
                <?=$data['confirmPasswordError']?>
            </span>
            <button id="submit" type="submit" value="Submit">Submit</button>

            <p class="options">
                Already registered? <a href="<?=URLROOT?>/users/login">Login!</a>
            </p>
        </form>

    </div>
</div>

<?php require APPROOT . '/views/includes/foot.php' ?>