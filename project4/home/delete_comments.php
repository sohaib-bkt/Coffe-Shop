<?php
session_start();

if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
   }
require_once '../admin/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $user_name  = $_POST['user_name'];


        // Delete comments for the specified product
        $deleteCommentsSql = $pdo->prepare("DELETE FROM comments WHERE product_id = ? and user_name = ?");
        $deleteCommentsSql->execute([$product_id,$user_name]);

        // Redirect back to the product detail page after deleting comments
        header("Location: product_detail.php?id=$product_id");
        exit();
    }else {
    // Redirect to the home page if accessed directly
    header("Location: home.php");
    exit();
}
?>
