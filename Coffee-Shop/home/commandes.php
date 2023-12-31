<?php
session_start();
$user = $_SESSION['username'];

if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
   }
$totale = 0;
$nb = 1;
require_once '../admin/pdo.php';
$query = "SELECT commande.*
  FROM commande 
  INNER JOIN users ON commande.id_client = users.id 
  WHERE users.Username = :user 
  ORDER BY commande.date_creation DESC";

$statement = $pdo->prepare($query);
$statement->bindParam(':user', $user, PDO::PARAM_STR);
$statement->execute();
$commandes = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Commandes </title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">   
    
   <style>
        body{
            background-image: url(images/6092895.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .alert-warning a{
             margin-top:0px;
        }
        .table-warning tr a{
            margin-top:0px;
        }

    </style>
</head>




<body style="background-color: #d3ad7f;">
<!-- bar -->
<?php include '../nav2.php'; ?>

<?php
if (!empty($commandes)) {
    ?>
    
<div class="container py-2" style="margin-top: 100px;text-align:center;justify-content:center;font-size:19px;">
    
    <table class="table table-hover table-warning " >
        <thead class="table-dark">
        <tr>
            
            <th ><i class="fas fa-cube"></i> Commande</th>
            <th ><i class="fas fa-wallet"></i> Total (MAD)</th>
            <th ><i class="fas fa-clock"></i> Date</th>
            <th ><i class="fas fa-check"></i> IS Valide</th>
            <th ><i class="fas fa-eye"></i> Opérations</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($commandes as $commande) {
            ?>
            <tr>
                <?php 
                if ($commande['valide']) {
                    $totale = $commande['total'] + $totale;
                }
                ?>
                
                
                <td><?php echo $nb ;$nb++;?></td>
    
                <td><?php echo $commande['total'] ?> <i class="fa fa-solid fa-dollar"></i></td>
                <td><?php echo $commande['date_creation'] ?></td>
                <td><?php if (!$commande['valide']) {
                    echo "NO";
                }
                else echo "YES"; ?></td>
                <td><a class="btn btn-outline-dark btn-lg " style="font-size: 15px;letter-spacing: 1px;" href="commande.php?id=<?php echo $commande['id']?>">Afficher détails</a></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="5">totale des commandes valide : <?=$totale?> MAD</td>
        </tr>
        </tbody>
    </table>
</div>
<?php
    
}else { ?>
    <div class="alert alert-warning" role="alert" style="font-size:18px ;justify-content:center ;margin-top:100px;padding-left:28%">
    Vous n'avez pas encore commandé .
    Commençez vos achats <a class="btn btn-danger btn-sm" style="  letter-spacing: 1px;font-size: 18px " href="products.php">Acheter des
        produits</a>
    </div>
    <?php

}

?>

</body>
</html>