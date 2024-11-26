<?php
  include_once 'inc/head.php';
  include_once 'inc/nav.php';
?>

<div class="small-container cart-page">
    <div>
        <a href="/create" class="btn">Add New Product</a>
    </div>
    <table>
        <tr>
            <th>Product</th>
            <th>Product Title</th>
            <th>Action</th>
        </tr>
        <?php foreach($products as $product): ?>
        <tr>
            <td>
                <div class="cart-info">
                    <img src="<?= $product['path'] ?? 'images/products/no_image.jpg' ?>" alt="">
                </div>
            <td>
                <h4><?= $product['title'] ?></h4>
            </td>
            </td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <button class="remove" onclick="return confirm('Are you sure?')">Remove</button>
                </form>
                <a href="/edit?id=<?= $product['id'] ?>" class="update">Update</a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
</div>

<?php
  include_once 'inc/footer.php';
?>