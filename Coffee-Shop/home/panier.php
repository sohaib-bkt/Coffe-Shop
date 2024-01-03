<?php
session_start();

if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
   }
include("../admin/pdo.php");
$totale = 0;
$id_per= $_SESSION['id'];

if (isset($_POST['vider'])) {
    $_SESSION['panier'][$id_per]=[];
    header('location: panier.php');
}


if(isset($_POST['submit'])){
    $id  = $_POST['id'];
    $qty = $_POST['quantity'];

    if(!isset($_SESSION['panier'][$id_per])){
        $_SESSION['panier'][$id_per] = [];
        

    } 
    if($qty == 0){
        unset($_SESSION['panier'][$id_per][$id]);
    }else{
        $_SESSION['panier'][$id_per][$id] = $qty;
        
    }       

    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lists</title>
    
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
        .custom-table .alert-warning a{
            margin-top:0px;
        }
        #prod:hover{
            background-color: #3C2A21;
            border-radius: 70px;
            transform: scale(1.05);
        }

    </style>
    
</head>


<body  style="background-color: #d3ad7f;" >
   

<?php include '../nav2.php'; ?>



<!-- lists -->
<div class="custom-table">
    <?php 

if (isset($_GET['success'])) {?>
    <div style="margin-top: 150px;">
    <h1 style="text-align: center;font-size:25px;color:#3C2A21">Merci ! </h1>
    <div class="alert alert-warning" style="font-size:18px ;text-align:center" role="alert">
    Votre commande avec le montant <strong>(<?php echo $_GET['total'] ?? 0 ?>MAD)</strong> <i class="fa fa-solid fa-dollar"></i> est bien ajoutée.
    </div>
    
    </div>
    <?php
    }?>
    <?php 
if (!empty($_SESSION['panier'][$id_per])) {?>
<table class="table table-hover table-warning" style="margin-top: 120px;font-size: 20px;text-align:center ;margin-bottom:50px">
  <thead >
    <tr class="table-warning selected">
      <th scope="col"></th>
      <th scope="col"><i class="fas fa-coffee"></i> Name</th>
      <th scope="col"><i class="fas fa-dollar-sign"></i> prix par unite</th>
      <th scope="col"><i class="fab fa-xing"></i> quantity</th>
      <th scope="col"><i class="fas fa-credit-card"></i> prix final</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody class="custom-table">
  <?php
        
            foreach(array_keys($_SESSION['panier'][$id_per]) as $key ){
                $produits = $pdo->query("SELECT * FROM produit where id = '$key'");
                $produit = $produits->fetch(PDO::FETCH_ASSOC);
                $prix = $produit['prix'] - (($produit['prix']*$produit['discount'])/100);
                $totale = $totale + ($prix*$_SESSION['panier'][$id_per][$key]);
                
            ?>
                    <tr style="text-align:center">
                        
                        <td><img width="250" style="max-height: 210px;" id="prod" src="../upload/produit/<?= $produit['image'] ?>"><br></td>
                        <td><?php echo $produit['name'] ?></td>       
                        <td><?php echo $prix." MAD" ?></td>
                        <td><?php echo $_SESSION['panier'][$id_per][$key] ?></td>
                        <td><?php echo  $prix*$_SESSION['panier'][$id_per][$key]." MAD" ?></td>
                       
                        <td style="width: 30%;">
                            <a href="product_detail.php?id=<?php echo $key ?>" class="btn btn-primary" style="letter-spacing: 1px;font-size: 18px;background-color:#3C2A21 ;border-color:#3C2A21 ;" ><i class="fas fa-exchange-alt"></i> Modifier</a>
                            <a href="suprimer_produit.php?id=<?php echo $key ?>" onclick="return confirm('Voulez vous vraiment supprimer se produit ');" class="btn btn-danger" style="letter-spacing: 1px;font-size: 18px;"><i class="fas fa-trash-alt"></i> Supprimer</a>
                        </td>
                    </tr>
                    
                    <?php
                }
            ?>
    
    
      </tbody>
      <tfoot >
        <tr>
            <td><a href="products.php" class="btn"></a></td>
            <td colspan="4" align="right" ><strong>total</strong></td>
            <td><?=$totale?> MAD</td>
        </tr>
        <tr>
            <td colspan="5.5" align="right" >
                <form method="post">
                    
                    <input onclick="return confirm('Voulez vous vraiment vider le panier ?')" type="submit" class="btn btn-danger" style="letter-spacing: 1px;font-size: 20px;" name="vider" value="Vider le panier">
                </form>
                <form method="post" action="checkout.php" >      
                    <input type="hidden" name='totale' value="<?=$totale?>" >           
                    <input type="submit"  class="btn btn-success" name="valider" style="letter-spacing: 1px;font-size: 20px;background-color:#3C2A21 ;border-color:#3C2A21 ;" value="Valider la commande">                  
                </form>
            </td>
            <td></td>
        </tr>
    
    
      </tfoot>
    </table>        
        <?php }
        else{?>

            <div class="alert alert-warning" role="alert" style="font-size:18px ;justify-content:center ;margin-top:100px;padding-left:28%">
            Votre panier est vide !
            Commençez vos achats <a class="btn btn-danger btn-sm" style="  letter-spacing: 1px;font-size: 18px " href="products.php">Acheter des
                produits</a>
            </div>
       <?php }?>
        
</div>


</body>
</html>