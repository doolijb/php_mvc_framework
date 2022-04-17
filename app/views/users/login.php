<?php require APPROOT . '/views/includes/head.php' ?>

<div id="navbar">
    <?php require APPROOT . '/views/includes/navigation.php' ?>
</div>

<div id="container-form">
    <div id="wrapper-form">
        <h2>Login</h2>

        <form action="<?=URLROOT?>/users/login" method="POST">
            <input type="text" placeholder="Username *" name="username" value="<?=$data['username']?>">
            <span class="invalidfeedback">
                <?=$data['usernameError']?>
            </span>
            <input type="password" placeholder="Password *" name="password">
            <span class="invalidfeedback">
                <?=$data['passwordError']?>
            </span>
            <br>
            <button id="submit" type="submit" value="Submit">Submit</button>

            <p class="options">
                Not registered yet? <a href="<?=URLROOT?>/users/register">Create an account!</a>
            </p>
        </form>

    </div>
</div>

<?php require APPROOT . '/views/includes/foot.php' ?>