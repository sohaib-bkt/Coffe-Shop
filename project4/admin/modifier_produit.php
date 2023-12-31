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
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Modifier produit</title>
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
?>
<?php include'nav.php';?>

<!-- body -->
<div class="container py-2">
    
    <?php
    $id = $_GET['id'];
    $sqlState = $pdo->prepare('SELECT * from produit WHERE id=?');
    $sqlState->execute([$id]);
    $produit = $sqlState->fetch(PDO::FETCH_OBJ);
    
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $prix = $_POST['prix'];
        $discount = $_POST['discount'];
        $description = $_POST['description'];

        $filename = '';
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $filename = uniqid() . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], '../upload/produit/' . $filename);
        }


        if (!empty($prix) && !empty($name)) {

            if (!empty($filename)) {
                $query = "UPDATE produit SET name=? ,
                                                    prix=? ,
                                                    discount=? ,
                                                    description=?,
                                                    image=?
                                                WHERE id = ? ";
                $sqlState = $pdo->prepare($query);
                $updated = $sqlState->execute([$name, $prix, $discount,$description, $filename, $id]);
            } else {
                $query = "UPDATE produit 
                                                SET name=? ,
                                                    prix=? ,
                                                    discount=? ,
                                                    description=?
                                                WHERE id = ? ";
                $sqlState = $pdo->prepare($query);
                $updated = $sqlState->execute([$name, $prix, $discount, $description, $id]);
            }
            if ($updated) {
                header('location: list_produits.php');
            } else {

                ?>
                <div class="message alert alert-danger" role="alert">
                    Database error (40023).
                </div>
                <?php
            }
        } else {
            ?>
            <div class="message alert alert-danger" role="alert">
                Name and price are required.
            </div>
            <?php
        }
    }
    ?>
<div class="container" style="margin-top: 100px;">
    <div class="box form-box">
        <header> Modifier <i class="fas fa-pen fa-sm"></i></header>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="field input">
                <label for="name" style="font-size: 20px;">Name</label>
                <input type="text" name="name" id="name" value="<?= $produit->name ?>" required>
            </div>
            <div class="field input">
                <label for="prix" style="font-size: 20px;">Price</label>
                <input type="number" name="prix" id="prix" step="0.01" value="<?= $produit->prix ?>" required min="0">
            </div>
            <div class="field input">
                <label for="discount" style="font-size: 20px;">Discount</label>
                <input type="number" name="discount" id="discount" min="0" value="<?= $produit->discount ?>" max="90">
            </div>
            <div class="field input">
                <label for="description" style="font-size: 20px;">description</label>
                <textarea name="description"  id="description"  cols="30" rows="4" maxlength="500" style="padding: 9px;font-size:15px;resize:none;"><?= $produit->description ?></textarea>

            </div>
            <div class="field input" style="text-align:center;padding:2%;">
                <label for="image" style="font-size: 20px;cursor:pointer;"><br/>image</label>
                <i class="fa fa-3x fa-image"></i>
                <input type="file" name="image" accept="image/png, image/jpg, image/gif, image/jpeg" id="image" ">
                <br/>
                <img width="250" style="margin-left: 70px;" class="img img-fluid" src="../upload/produit/<?= $produit->image ?>"><br>
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
</body>
</html>
