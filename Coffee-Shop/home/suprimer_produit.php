<?php
    session_start();
    require_once '../admin/pdo.php';
    $id = $_GET['id'];
    $id_per = $_SESSION['id'];
    unset($_SESSION['panier'][$id_per][$id]);
  
    header('location: panier.php');