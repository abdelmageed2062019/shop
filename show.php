<?php 
require_once 'classes/Database.php';
require_once 'classes/Product.php';

if(isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    $db = new Database();
    $product = new Product($db->getConnection());

    $productDetails = $product->read($productId);

    if(!$productDetails) {
    echo "Error: Product not found.";
    exit();
    }

} else {
    echo "Error: Product ID not provided.";
    exit();
}
?>

<?php include 'inc/header.php'; ?>




<div class="container my-5">

     <div class="row">


          <div class="col-lg-6">
               <img src="images/<?php echo htmlspecialchars($productDetails['image']); ?>" class="card-img-top">
          </div>
          <div class="col-lg-6">
               <h5><?php echo htmlspecialchars($productDetails['name']); ?></h5>
               <p class="text-muted">Price: <?php echo htmlspecialchars($productDetails['price']); ?> EGP</p>
               <p><?php echo htmlspecialchars($productDetails['description']); ?></p>
               <a href="index.php" class="btn btn-primary">Back</a>
               <a href="edit.php?id=<?php echo htmlspecialchars($productDetails['id']); ?>" class="btn btn-info">Edit</a>
               <a href="handlers/delete_product.php?id=<?php echo htmlspecialchars($productDetails['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
          </div>

     </div>
</div>



<?php include 'inc/footer.php'; ?>