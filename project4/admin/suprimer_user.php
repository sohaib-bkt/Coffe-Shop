<?php
    require_once 'pdo.php';
    $id = $_GET['id'];
    $sqlState = $pdo->prepare('DELETE FROM users WHERE Id=?');
    $supprime = $sqlState->execute([$id]);
    header('location: gestion_users.php');