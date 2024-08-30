<?php
require_once '../classes/Database.php';
require_once '../classes/Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();
    $product = new Product($conn);

    $name = $_POST['name'] ?? '';
    $description = $_POST['desc'] ?? '';
    $price = $_POST['price'] ?? 0;

    $image = '';

    if (isset($_FILES['image']) && is_array($_FILES['image'])) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $_FILES["image"]["name"];
            $filetype = $_FILES["image"]["type"];
            $filesize = $_FILES["image"]["size"];
        
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!array_key_exists($ext, $allowed)) {
                die("Error: Please select a valid file format.");
            }
        
            $maxsize = 5 * 1024 * 1024;
            if ($filesize > $maxsize) {
                die("Error: File size is larger than the allowed limit.");
            }
        
            if (in_array($filetype, $allowed)) {
                $uniqueFilename = uniqid() . '_' . time() . '.' . $ext;
                
                if (file_exists("../images/" . $uniqueFilename)) {
                    echo $uniqueFilename . " already exists.";
                } else {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], "../images/" . $uniqueFilename)) {
                        $image = $uniqueFilename;
                    } else {
                        echo "Error: There was an error uploading your file.";
                        exit();
                    }
                }
            } else {
                echo "Error: There was a problem with your upload.";
                exit();
            }
        } else {
            switch ($_FILES['image']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    echo "Error: The uploaded file exceeds the allowed size.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "Error: The uploaded file was only partially uploaded.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "Error: No file was uploaded.";
                    break;
                default:
                    echo "Error: Unknown error occurred with file upload.";
            }
            exit();
        }
    } else {
        echo "Error: No file was uploaded.";
        exit();
    }

    if ($product->create($name, $description, $image, $price)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error adding product";
    }
}