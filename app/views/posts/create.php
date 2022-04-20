<?php require APPROOT . '/views/includes/head.php' ?>

    <div id="navbar">
        <?php require APPROOT . '/views/includes/navigation.php' ?>
    </div>

    <div class="container center">
        <h1>
            Create new post
        </h1>

        <form action="<?=URLROOT?>/posts/create" method="POST">
            <div class="form-item">

                <input type="text" name="title" placeholder="Title..." value="<?=$data['title']?>">
                <span class="invalidFeedback">
                    <?=$data['titleError']?>
                </span>

            </div>

            <div class="form-item">

                <textarea name="body" placeholder="Enter your post..."><?=$data['body']?></textarea>
                <span class="invalidFeedback">
                    <?=$data['bodyError']?>
                </span>
            </div>

        <button class="btn green" name="submit" type="submit">Submit</button>

        </form>
    </div>

<?php require APPROOT . '/views/includes/foot.php' ?>