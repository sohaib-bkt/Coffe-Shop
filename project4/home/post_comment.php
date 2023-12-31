<?php
require_once '../admin/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $user_name = $_POST['user_name'];
    $user_id = $_POST['user_id'];
    $comment_text = $_POST['comment_text'];

    // Insert the comment into the database
    $insertCommentSql = $pdo->prepare("INSERT INTO comments (product_id, user_name, comment_text,user_id) VALUES (?, ?, ? , ?)");
    $insertCommentSql->execute([$product_id, $user_name, $comment_text , $user_id]);

    // Redirect back to the product detail page after posting the comment
    header("Location: product_detail.php?id=$product_id");
    exit();
} else {
    // Redirect to the home page if accessed directly
    header("Location: home.php");
    exit();
}
?>
