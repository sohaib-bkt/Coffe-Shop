<?php
require_once '../admin/pdo.php';
$idCommande = $_GET['id'];
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
   }

$totale =0;
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
    <title>Commande | Numéro <?= $commande['id'] ?> </title>
    <link rel="stylesheet" href="../style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  
    <style>
        body{
            background-image: url(images/6092895.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .table-warning tr a{
            padding-top:1px;
            margin-top:0px;
        }

    </style>

</head>



<body style="background-color: #d3ad7f;">



<!-- bar -->
<?php include '../nav2.php'; ?>
<!-- DEBUT -->
<div>
    <a href="commandes.php" class="btn" style="background-color:#007bff;font-size:18px;color:#fff;border-radius:15px;
                background-color:#884A39;letter-spacing:1px;position:absolute;left:20px;top:100px"><i class="fas fa-arrow-left"></i> go back</a>
</div>

<div class="cont">

        <?php
        $sqlStateLigneCommandes = $pdo->prepare('SELECT ligne_commande.*,produit.name,produit.image from ligne_commande
                                                        INNER JOIN produit ON ligne_commande.id_produit = produit.id
                                                        WHERE id_commande = ?
                                                        ');
        $sqlStateLigneCommandes->execute([$idCommande]);
        $lignesCommandes = $sqlStateLigneCommandes->fetchAll(PDO::FETCH_OBJ);
        ?>

    
    <div style="margin-top: 200px;">
    <h2 style="font-size: 30px;">Produits  <i class="fas fa-mug-hot"></i> </h2>
    <br>
    <table class="table table-warning table-hover" style="margin-bottom:50px;text-align:center;justify-content:center;font-size:19px;">
        <thead>
        <tr class="table-dark">
            <th><i class="fas fa-coffee"></i> Produit</th>
            <th><i class="fas fa-wallet"></i> Prix unitaire</th>
            <th><i class="fab fa-xing"></i> Quantité</th>
            <th><i class="fas fa-wallet"></i> Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($lignesCommandes as $lignesCommande) : ?>
            <tr>
                
                <td><?php echo $lignesCommande->name ?></td>               
                <td><?php echo $lignesCommande->prix;$totale +=$lignesCommande->prix*$lignesCommande->quantite; ?> <i class="fas fa-dollar-sign"></i></td>
                <td>X <?php echo $lignesCommande->quantite ?></td>
                <td><?php echo $lignesCommande->total ?> <i class="fas fa-dollar-sign"></i></td>
            </tr>

        <?php endforeach; ?>
        <tr>
            <td colspan="5">totale : <?=$totale?> MAD</td>
                  
        </tr>
        <tr>
            <td colspan="5"><a style="background-color:#007bff;font-size:18px;color:#fff;border-radius:15px;
                background-color:#884A39;letter-spacing:1px" class="btn" href="print.php?id=<?php echo $idCommande; ?>">print</a></td>
        </tr>
        </tbody>
    </table>


    </div>
    </div>

</body>
</html>