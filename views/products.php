<?php
    include_once 'inc/head.php';
    include_once 'inc/nav.php';
?>
<div class="store">
    <img src="images/store.jpg" alt="">
</div>

<div class="small-container">
    <div class="row">
        <nav class="products-nav">
            <ul>
                <li><a href="/products"
                       class="<?= !isset($_GET['category']) ? 'active' : '' ?>"    
                    >
                    All Products
                    </a>
                </li>
                <?php foreach($categories as $category): ?>
                <li><a 
                        href="/products?category=<?= $category['name'] ?>"
                        class="<?= issetCategory($category['name']) ?>"
                    ><?= $category['name'] ?>
                    </a>
                </li>
                <?php endforeach ?>
            </ul>
        </nav>        
    </div>
    <div class="wrap">
        <div class="search">
            <form action="" method="get">
                <input type="text" name="search" class="searchTerm" placeholder="Search product">
                <button type="submit" class="searchButton">
                    <i>Search</i>
                </button>
            </form>
        </div>
    </div>
    <div class="row">
        <?php foreach($products as $product): ?>
            <div class="col-4">
                <div class="product-image">
                    <img src=<?= $product['path'] ?> alt="">
                </div>              
                <a href="/product?id=<?= $product['id'] ?>"><h4><?= $product['title'] ?></h4></a>
                <p>$<?= $product['price'] ?></p>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?php
    include_once 'inc/footer.php';
?>