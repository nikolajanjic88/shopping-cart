<?php if(isset($_SESSION['login'])): ?>
<script>swal("Logged In!", "<?= $_SESSION['login'] ?>", "success");</script>
<?php unset($_SESSION['login']);
endif ?>

<?php if(isset($_SESSION['register'])): ?>
<script>swal("Nice job!", "<?= $_SESSION['register'] ?>", "success");</script>
<?php unset($_SESSION['register']);
endif ?>

<?php if(isset($_SESSION['product_created'])): ?>
<script>swal("Good job!", "<?= $_SESSION['product_created'] ?>", "success");</script>
<?php unset($_SESSION['product_created']);
endif ?>

<?php if(isset($_SESSION['product_deleted'])): ?>
<script>swal("Good job!", "<?= $_SESSION['product_deleted'] ?>", "success");</script>
<?php unset($_SESSION['product_deleted']);
endif ?>

<?php if(isset($_SESSION['product_updated'])): ?>
<script>swal("Good job!", "<?= $_SESSION['product_updated'] ?>", "success");</script>
<?php unset($_SESSION['product_updated']);
endif ?>

<?php if(isset($_SESSION['add_to_cart'])): ?>
<script>swal("Good job!", "<?= $_SESSION['add_to_cart'] ?>", "success");</script>
<?php unset($_SESSION['add_to_cart']);
endif ?>

<?php if(isset($_SESSION['delete_from_cart'])): ?>
<script>swal("Good job!", "<?= $_SESSION['delete_from_cart'] ?>", "success");</script>
<?php unset($_SESSION['delete_from_cart']);
endif ?>
