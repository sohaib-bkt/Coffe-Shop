<?php
$count =0;
session_start();
$id_per = $_SESSION['id'];
if (isset($_SESSION['panier'][$id_per])) {
    $count = count($_SESSION['panier'][$id_per]);
} else{
    $count =0;

}
?>