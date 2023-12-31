<?php
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body{
            background-image: url(../home/images/6092895.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body style="background-color:white">
<?php
require_once 'pdo.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $prix = $_POST['prix'];
        $name = $_POST['name'];
        $discount = $_POST['discount'];
        $description = $_POST['description'];
        $date = date('Y-m-d');
        $filename = 'produit.png';
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $filename = uniqid() . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], '../upload/produit/' . $filename);
        }

        if (!empty($name) && !empty($prix)) {
            $sqlState = $pdo->prepare('INSERT INTO produit VALUES (null,?,?,?,?,?,?)');
            $inserted = $sqlState->execute([ $name,$prix, $discount ,$date ,$description ,$filename]);
            if ($inserted) {
                header('location: list_produits.php');
                exit();
            } else {
                ?>
                <div class="message" role="alert">
                    Database error (40023).
                </div>
                <?php
            }
            $stmt->close();
        } else {
            ?>
            <div class="message" role="alert">
                Name and price are required fields.
            </div>
            <?php
        }
    }
}
?>

<?php include'nav.php';?>
<!-- form -->
<div class="container" style="margin-top: 100px;">
    <div class="box form-box">
        <header><i class="fas fa-mug-hot"></i> ajouter</header>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="field input">
                <label for="name" style="font-size: 20px;">Name</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="field input">
                <label for="prix" style="font-size: 20px;">Price</label>
                <input type="number" name="prix" id="prix" step="0.01" required min="0">
            </div>
            <div class="field input">
                <label for="discount" style="font-size: 20px;">Discount</label>
                <input type="number" name="discount" id="discount" min="0" value="0" max="90">
            </div>
            <div class="field input">
                <label for="description" style="font-size: 20px;">description</label>
                <textarea name="description" id="description"  cols="30" rows="4" maxlength="500" style="padding: 9px;font-size:15px;resize:none;"></textarea>

            </div>
            <div class="field input" style="text-align:center;padding:2%;">
                <label for="image" style="font-size: 20px;cursor:pointer;"><br/>image</label>
                <i class="fa fa-2x fa-camera"></i>
                <input type="file" name="image" accept="image/png, image/jpg, image/gif, image/jpeg" id="image" ">
                <br/>
                <span id="imageName" style="color: green;"></span>
            </div>
            <div class="field">
                <input type="submit" class="btn" name="submit" value="Submit" style="font-size: 20px;">
            </div>
        </form>
    </div>
</div>
<script>
        let input = document.getElementById("image");
        let imageName = document.getElementById("imageName")

        input.addEventListener("change", ()=>{
            let inputImage = document.querySelector("input[type=file]").files[0];

            imageName.innerText = inputImage.name;
        })
    </script>
<script src="../js/script.js"></script> 
</body>
</html>
