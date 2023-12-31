<?php
require_once '../admin/pdo.php';
$idCommande = $_GET['id'];
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
   }
$sqlState = $pdo->prepare('SELECT commande.*,users.Username as "login" FROM commande 
            INNER JOIN users ON commande.id_client = users.Id 
                                               WHERE commande.id = ?
                                               ORDER BY commande.date_creation DESC');
$sqlState->execute([$idCommande]);
$commande = $sqlState->fetch(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Order | Numéro <?= $commande['id'] ?> </title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">   
    <style>
        body{
            background-image: url(../home/images/6092895.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .cont tr a{
            margin-top:0px;
        }
        .cont td{
            padding: 20px;
        }


    </style>

</head>



<body style="background-color: #d3ad7f;">



<!-- bar -->
<?php include 'nav.php'; ?>
<!-- DEBUT -->
<div>
    <a href="orders.php" class="btn" style="background-color:#fff;font-size:18px;color:#fff;border-radius:15px;
                background-color:#884A39;letter-spacing:1px;position:absolute;top:90px;left:20px"><i class="fas fa-arrow-left"></i> go back</a>
</div>

<div class="cont">
    <div style="margin-top:70px;font-size:19px;padding:80px">
    <h2 style="font-size: 25px;font-weight:600;">Détails Commandes <i class="fas fa-box fa-lg"></i> </h2>
    <br>
    <table class="table table-warning table-hover" >
        <thead>
        <tr class="table-dark" style="text-align: center;">
            <th ><i class="fas fa-key"></i> Commande Id</th>
            <th ><i class="fas fa-users"></i> Client</th>
            <th ><i class="fas fa-wallet"></i> Total</th>
            <th ><i class="fas fa-clock"></i> Date</th>
            <th ><i class="fas fa-eye"></i> Opérations</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sqlStateLigneCommandes = $pdo->prepare('SELECT ligne_commande.*,produit.name,produit.image from ligne_commande
                                                        INNER JOIN produit ON ligne_commande.id_produit = produit.id
                                                        WHERE id_commande = ?
                                                        ');
        $sqlStateLigneCommandes->execute([$idCommande]);
        $lignesCommandes = $sqlStateLigneCommandes->fetchAll(PDO::FETCH_OBJ);
        ?>
        <tr style="text-align: center;">
            <td><?php echo $commande['id'] ?></td>
            <td><?php echo $commande['login'] ?></td>
            <td><?php echo $commande['total'] ?> MAD <i class="fa fa-solid fa-dollar"></i></td>
            <td><?php echo $commande['date_creation'] ?></td>          
            <td>
                <?php if ($commande['valide'] == 0) : ?>
                    <a class="btn btn-outline-success btn-lg text-nowrap" style="font-size: 15px;letter-spacing: 1px;" href="valider_commande.php?id=<?= $commande['id']?>&etat=1"><i class="fas fa-check-circle"></i> Valider la commande</a>
                <?php else: ?>
                    <a class="btn btn-outline-danger btn-lg text-nowrap" style="font-size: 15px;letter-spacing: 1px;" href="valider_commande.php?id=<?= $commande['id']?>&etat=0"><i class="fas fa-times-circle"></i> Annuler la commande</a>
                <?php endif; ?>
            </td>
            <td>
            </td>
        </tr>
        <?php
        ?>
        </tbody>
    </table>
    </div>
    <hr style="margin-bottom:50px">
    <br>
    <h2 style="font-size: 25px;font-weight:600;" >Produits  <i class="fas fa-mug-hot"></i> </h2>
    <br>
    <table class="table table-warning table-hover" style="margin-bottom:50px;text-align:center;justify-content:center;font-size:19px;">
        <thead>
        <tr class="table-dark">
            <th><i class="fas fa-key"></i> Id Produit</th>
            <th><i class="fas fa-coffee"></i> Produit</th>
            <th><i class="fas fa-wallet"></i> Prix unitaire</th>
            <th><i class="fab fa-xing"></i> Quantité</th>
            <th><i class="fas fa-wallet"></i> Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($lignesCommandes as $lignesCommande) : ?>
            <tr>
                <td><?php echo $lignesCommande->id ?></td>  
                <td><?php echo $lignesCommande->name ?></td>               
                <td><?php echo $lignesCommande->prix ?> <i class="fas fa-dollar-sign"></i></td>
                <td>X <?php echo $lignesCommande->quantite ?></td>
                <td><?php echo $lignesCommande->total ?> <i class="fas fa-dollar-sign"></i></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>