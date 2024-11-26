<?php
  include_once 'inc/head.php';
  include_once 'inc/nav.php';
?>

<div class="small-container">
    <div class="row">
        <?php if(count($images) < 1): ?>
            <h1>No Images for this Product (Upload Images)</h1>
        <?php else: ?>
            <?php foreach($images as $image): ?>
                <div class="col-4 product-image">
                    <img src=<?= $image['path'] ?> alt="">
                    <form action="/delete-image" method="post">
                        <input type="hidden" name="id" value="<?= $image['id'] ?>">
                        <input type="hidden" name="product_id" value="<?= $_GET['id'] ?>">
                        <button>Delete</button>
                    </form>
                </div>  
            <?php endforeach ?>
        <?php endif ?>
    </div>
    <div class="row">
        <div class="edit">
            <form action="" method="post" enctype="multipart/form-data">
                <input class="file" type="file" name="image">
                <?php if(isset($errors['image'])): ?>
                    <p class="error"><?= $errors['image'] ?></p>
                <?php endif ?>
                <button class="edit-btn">Upload images</button>
            </form>
        </div>
    </div>
</div>

<?php
  include_once 'inc/footer.php';
?>