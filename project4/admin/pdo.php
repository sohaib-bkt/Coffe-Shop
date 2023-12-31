<?php
try
{
    $pdo = new PDO('mysql:host=localhost;dbname=project4;charset=utf8', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>