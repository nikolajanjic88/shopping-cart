<?php
    include_once 'inc/head.php';
    include_once 'inc/nav.php';
?>

<div class="edit-page">
    <div class="row">
        <div class="edit">
            <form method="post">
                <input
                  type="hidden",
                  name="product_id"
                  value="<?= $_GET['product'] ?>">
                <textarea 
                  class="input-edit" 
                  name="body" 
                  cols="30" 
                  rows="10">
                </textarea>
                <?php if(isset($errors['body'])): ?>
                    <p class="error"><?= $errors['body'] ?></p>
                <?php endif ?>
                <button 
                  class="edit-btn">
                  Add Comment
              </button>
            </form>
            <a  href="/product?id=<?= $_GET['product'] ?>"
                class="cancel-btn">
                Cancel
            </a>
        </div>
    </div>
</div>

<?php
    include_once 'inc/footer.php';
?>