<?php
  include_once 'inc/head.php';
  include_once 'inc/nav.php';
?>

<div class="small-container cart-page">
  <?php if(count($carts) > 0): ?>
  <table>
    <tr>
      <th>Product</th>
      <th>Quantity</th>
      <th>SubTotal</th>
    </tr>
    <?php $subtotal = 0; ?>
    <?php foreach($carts as $cart): ?>
    <tr>
      <td>
        <div class="cart-info">
          <img src="<?= $cart['path'] ?>" alt="">
          <div>
            <p><?= $cart['title'] ?></p>
            <form action="/cart" method="post">
              <input 
                type="hidden" 
                name="id" 
                value="<?= $cart['id'] ?>"
              >
              <button 
                class="remove" 
                onclick="return confirm('Are you sure?')">
                Remove
              </button>
            </form>
          </div>
        </div>
      </td>
      <td><?= $cart['quantity'] ?></td>
      <td>$<?= $cart['price'] * $cart['quantity'] ?></td>
    </tr>
    <?php $subtotal += $cart['price'] * $cart['quantity']; ?>
    <?php endforeach ?>
  </table>
  <div class="total-price">
      <table>
          <tr>
              <td>Subtotal</td>
              <td>$<?= $subtotal ?></td>
          </tr>
          <tr>
              <td>Tax</td>
              <td>$<?= $tax = round($subtotal/20, 2) ?></td>
          </tr>
          <tr>
              <td>Total</td>
              <td>$<?= $subtotal + $tax ?></td>
          </tr>
      </table>
  </div>
  <?php else: ?>
    <h2>Your Cart is empty</h2>
  <?php endif ?>
</div>

<?php
  include_once 'inc/footer.php';
?>