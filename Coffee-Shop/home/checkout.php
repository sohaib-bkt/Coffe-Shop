<?php
session_start();

if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
   }
   
include '../admin/pdo.php';

require __DIR__ . '../../../vendor/autoload.php';

$stripe_secret_key = 'sk_test_51OQFkbK0WYdcz5M3AQltdCSBmHm7AxaDn2RuqGI5deFzVuKGQBctjYrxSNfcFi2VvUYfyEjbQd0x2SU22eYEvxhn00yMVGOqGj';

\Stripe\Stripe::setApiKey($stripe_secret_key);
$id_per = $_SESSION['id'];
foreach ($_SESSION['panier'][$id_per] as $id => $article) {
    
    $produit = $pdo->query("SELECT * FROM produit WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
    $price  = $produit['prix'];
    $sum = $price - ($price * $produit['discount']/100);
    $name = $produit['name'];
    
    $line_items[] = [
        "quantity" => $article,
        "price_data" => [
            "currency" => 'usd',
            "unit_amount" => $sum * 10 ,
            "product_data" => [
                "name" => $name
            ]
        ]
    ];
}



// You may need to convert your currency to the appropriate currency code for Stripe


$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/projects/Coffee-Shop/home/success.php",
    "cancel_url" => "http://localhost/projects/Coffee-Shop/home/products.php",
    "payment_method_types" => ["card"],
     // Add other supported payment methods if needed
    "line_items" => array($line_items)
]);

http_response_code(303);
header("Location: " . $checkout_session->url);
?>
