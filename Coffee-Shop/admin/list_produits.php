<?php

session_start();
if(!isset($_SESSION['valid'])){
  header("Location: ../index.php");
 }
require_once 'pdo.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lists</title>
    
    <link rel="stylesheet" href="../style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
<?php include'nav.php';?>



<!-- lists -->
<table class="table table-hover table-warning" style="margin-top: 200px;font-size: 20px;text-align:center;margin-bottom:50px">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">image</th>
      <th scope="col">Name</th>
      <th scope="col">prix</th>
      <th scope="col">discount</th>
      <th scope="col">prix final</th>
      <th scope="col">date_d'ajout</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php
        
        $produits = $pdo->query('SELECT * FROM produit')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($produits as $produit){
            ?>
            <tr style="text-align:center;vertical-align: middle;" >
                <td><?php echo $produit['id'] ?></td>
                <td><img width="250" style="max-height: 210px;"  src="../upload/produit/<?= $produit['image'] ?>"><br></td>
                <td><?php echo $produit['name'] ?></td>
                <td><?php echo $produit['prix']." MAD" ?></td>
                <td><?php echo $produit['discount']."%" ?></td>
                <td><?php echo $produit['prix'] - (($produit['prix']*$produit['discount'])/100)." MAD" ?></td>
                <td><?php echo $produit['date_creation'] ?></td>
                <td style="width: 30%;">
                    <a href="modifier_produit.php?id=<?php echo $produit['id'] ?>" class="btn btn-dark" style="letter-spacing: 1px;font-size: 18px;" ><i class="fas fa-exchange-alt"></i> Modifier</a>
                    <a href="suprimer_produit.php?id=<?php echo $produit['id'] ?>" onclick="return confirm('Voulez vous vraiment supprimer se produit ');" class="btn btn-danger" style="letter-spacing: 1px;font-size: 18px;"><i class="fas fa-trash-alt"></i> Supprimer</a>
                </td>
            </tr>
            <?php
        }
        ?>
  </tbody>
</table> 

</body>
</html>
