<?php
include_once '../admin/pdo.php';
$id = $_GET['id'];
$etat = $_GET['etat'];
$sqlState = $pdo->prepare('UPDATE commande SET valide = ? WHERE id = ?');
$sqlState->execute([$etat, $id]);
header('location: commande.php?id=' . $id);