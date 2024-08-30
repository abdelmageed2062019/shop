<?php 
require_once 'classes/Database.php';
require_once 'classes/Product.php';


$db = new Database();
$product = new Product($db->getConnection());

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$productData = $product->read($id);

if(!$productData) {
    header("Location: index.php");
    exit();
}
?>

<?php include 'inc/header.php'; ?>

<div class="container my-5">
     <div class="row">
          <div class="col-lg-6 offset-lg-3">


               <form action="handlers/edit_product.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                         <label for="name" class="form-label">Name:</label>
                         <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($productData['name']); ?>">
                    </div>

                    <div class="mb-3">
                         <label for="price" class="form-label">Price:</label>
                         <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($productData['price']); ?>">
                    </div>

                    <div class=" mb-3">
                         <label for="exampleFormControlTextarea1" class="form-label">Description:</label>
                         <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="desc"><?php echo htmlspecialchars($productData['description']); ?></textarea>
                    </div>

                    <div class="mb-3">
                         <label for="formFile" class="form-label">Image:</label>
                         <input class="form-control" type="file" id="formFile" name="image">
                    </div>

                    <div class="col-lg-3">
                         <img src="images/<?php echo htmlspecialchars($productData['image']); ?>" class="card-img-top mb-4 w-50">
                    </div>

                    <center><button on type="submit" class="btn btn-primary" name="submit">Edit</button></center>
               </form>
          </div>
     </div>
</div>



<?php include 'inc/footer.php'; ?>