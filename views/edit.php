<?php
    include_once 'inc/head.php';
    include_once 'inc/nav.php';
?>

<div class="edit-page"> 
    <div class="row">
        <div class="edit">
            <form action="" method="post">
                <input 
                    class="input-edit" 
                    type="text" name="title" 
                    value="<?= $_POST['title'] ?? $product['title']  ?>"
                >
                <?php if(isset($errors['title'])): ?>
                    <p class="error"><?= $errors['title'] ?></p>
                <?php endif ?>
                <textarea 
                    class="input-edit" 
                    name="desc" 
                    cols="30" 
                    rows="10"><?= $_POST['desc'] ?? $product['description'] ?>
                </textarea>
                <?php if(isset($errors['desc'])): ?>
                    <p class="error"><?= $errors['desc'] ?></p>
                <?php endif ?>
                <input 
                    class="input-edit" 
                    type="number" step="0.01" 
                    name="price" value="<?= $_POST['price'] ?? $product['price'] ?>"
                >
                <?php if(isset($errors['price'])): ?>
                    <p class="error"><?= $errors['price'] ?></p>
                <?php endif ?>
                <select 
                    class="input-edit" 
                    name="category">
                        <option value="0">Select a Category</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category['id'] ?>">
                            <?= $category['name'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
                <?php if(isset($errors['category'])): ?>
                    <p class="error"><?= $errors['category'] ?></p>
                <?php endif ?>
                <button 
                    class="edit-btn">
                    Update
                </button>
            </form>
                <a  href="/manage"
                    class="cancel-btn">
                    Cancel
                </a>
            <a  class="update-image" 
                href="/upload?id=<?= $_GET['id'] ?>"
            >
                Upload Images for this Product
            </a>
        </div>
    </div>
</div>

<?php
    include_once 'inc/footer.php';
?>