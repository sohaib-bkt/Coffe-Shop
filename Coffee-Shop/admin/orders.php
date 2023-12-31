<?php
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
   }
$user = $_SESSION['username'];
$totale = 0;
$nb = 1;
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
            background-image: url(../home/images/6092895.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .table-warning tr a{
            margin-top:0px;
        }
        .table-warning td{
            padding: 20px;
        }
    </style>
</head>




<body style="background-color: #d3ad7f;">
<!-- bar -->
<?php include 'nav.php'; ?>



<div class="container py-2" style="margin-top: 100px;text-align:center;justify-content:center;font-size:19px;">
    
    <table class="table table-hover table-warning " >
        <thead class="table-dark">
        <tr>
            <th ><i class="fas fa-key"></i> Id Commande</th>
            <th ><i class="fas fa-users"></i> Client</th>
            <th ><i class="fas fa-wallet"></i> Total (MAD)</th>
            <th ><i class="fas fa-clock"></i> Date</th>
            <th ><i class="fas fa-check"></i> IS Valide</th>
            <th ><i class="fas fa-eye"></i> Opérations</th>
        </tr>
        </thead>
        <tbody>
        <?php
        require_once 'pdo.php';
        $query = "SELECT commande.* ,users.Username as name
          FROM commande 
          INNER JOIN users ON commande.id_client = users.id 
           
          ORDER BY commande.date_creation DESC";

        $statement = $pdo->prepare($query);
        
        $statement->execute();
        $commandes = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($commandes as $commande) {
            ?>
            <tr>
                <?php 
                if ($commande['valide']) {
                    $totale = $commande['total'] + $totale;
                }
                ?>
                
                <td><?php echo $commande['id']?></td>
                <td><?php echo $commande['name']?></td>
    
                <td><?php echo $commande['total'] ?> <i class="fa fa-solid fa-dollar"></i></td>
                <td><?php echo $commande['date_creation'] ?></td>
                <td><?php if (!$commande['valide']) {
                    echo "NO";
                }
                else echo "YES"; ?></td>
                <td><a class="btn btn-outline-dark btn-lg " style="font-size: 15px;letter-spacing: 1px;" href="order.php?id=<?php echo $commande['id']?>">Afficher détails</a></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="6">Totale Est : <?=$totale?> MAD</td>
        </tr>
        </tbody>
    </table>
</div>

</body>
</html>