<?php
require_once 'classes/Database.php';
require_once 'classes/Product.php';


$db = new Database();
$product = new Product($db->getConnection());
$products = $product->getAll();

?>
<?php include 'inc/header.php'; ?>



<div class="container my-5">

     <div class="row">




          <?php foreach ($products as $product): ?>
          <div class="col-lg-4 mb-3">



               <div class="card">
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top">
                    <div class="card-body">
                         <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                         <p class="text-muted"><?php echo htmlspecialchars($product['price']); ?> EGP</p>
                         <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                         <a href="show.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="btn btn-primary">Show</a>

                         <a href="edit.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="btn btn-info">Edit</a>
                         <a href="handlers/delete_product.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>


                    </div>
               </div>

          </div>
          <?php endforeach ?>



     </div>

</div>



<?php include 'inc/footer.php'; ?>