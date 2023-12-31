<?php
    require_once 'pdo.php';
    
    $id = $_GET['id'];
    $sqlState = $pdo->prepare('DELETE FROM produit WHERE id=?');
    $supprime = $sqlState->execute([$id]);
    header('location: list_produits.php');