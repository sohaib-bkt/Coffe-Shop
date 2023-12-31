<?php
session_start();
if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
   }

   include("../admin/pdo.php");
    $id_per = $_SESSION['id'];
    $panier = $_SESSION['panier'][$id_per];
    $idProduits = array_keys($panier);
    $idProduits = implode(',', $idProduits);
    $produits = $pdo->query("SELECT * FROM produit WHERE id IN ($idProduits)")->fetchAll(PDO::FETCH_ASSOC);
    
    $sql = 'INSERT INTO ligne_commande(id_produit,id_commande,prix,quantite,total) VALUES';
    $total = 0;
    $prixProduits = [];
    foreach ($produits as $produit) {
         $idProduit = $produit['id'];
         $qty = $panier[$idProduit];
         $discount = $produit['discount'];
         $prix = $produit['prix'] - (($produit['prix']*$produit['discount'])/100);

         $total += $qty * $prix;
         $prixProduits[$idProduit] = [
             'id' => $idProduit,
             'prix' => $prix,
             'total' => $qty * $prix,
             'qty' => $qty
         ];
     }

     $sqlStateCommande = $pdo->prepare('INSERT INTO commande(id_client,total) VALUES(?,?)');
     $sqlStateCommande->execute([$id_per, $total]);
    $idCommande = $pdo->lastInsertId();
     $args = [];
     foreach ($prixProduits as $produit) {
         $id = $produit['id'];
         $sql .= "(:id$id,'$idCommande',:prix$id,:qty$id,:total$id),";
     }
     $sql = substr($sql, 0, -1);
     $sqlState = $pdo->prepare($sql);
    foreach ($prixProduits as $produit) {
         $id = $produit['id'];
         $sqlState->bindParam(':id' . $id, $produit['id']);
         $sqlState->bindParam(':prix' . $id, $produit['prix']);
         $sqlState->bindParam(':qty' . $id, $produit['qty']);
        $sqlState->bindParam(':total' . $id, $produit['total']);
    }
    $inserted = $sqlState->execute();
    if ($inserted) {
         $_SESSION['panier'][$id_per] = [];
        header("Location: panier.php?success=true&total=$total");
            } else {?>
               <div class="alert alert-error" role="alert"> 
                 Erreur (contactez l'administrateur). 
                 </div> 
            <?php
                 }


?>