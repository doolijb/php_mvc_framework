<?php require APPROOT . '/views/includes/head.php' ?>

    <div id="navbar">
        <?php require APPROOT . '/views/includes/navigation.php' ?>
    </div>

<div class="container">
    <?php if(isLoggedIn()): ?>
        <a class="btn green" href="<?=URLROOT?>/posts/create">Create</a>
    <?php endif; ?>
    <?php foreach($data['posts'] as $post): ?>
        <div class="container-item">
            <h2>
                <?=$post->title?>
            </h2>

            <h3>
                Created on <?=date('h:m F j, Y', strtotime($post->created_at))?>
            </h3>

            <p>
                <?=$post->body?>
            </p>
            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post->user_id): ?>
                <a class="btn orange" href="<?=URLROOT?>/posts/update/<?=$post->id?>">
                    Update
                </a>
            <form action="<?=URLROOT?>/posts/delete/<?=$post->id?>" method="POST">
                <button class="btn red" type="submit" value="Delete">
                    Delete
                </button>
            </form>
            <?php endif; ?>
        </div>
    <?php endforeach ?>
</div>

<?php require APPROOT . '/views/includes/foot.php' ?>