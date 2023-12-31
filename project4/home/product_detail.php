<?php
session_start();

if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
   }
require_once '../admin/pdo.php';
$id = $_GET['id'];
$user_name = $_SESSION['username'];
$user_id = $_SESSION['id'];
$sqlState = $pdo->prepare("SELECT * FROM produit WHERE id=?");
$sqlState->execute([$id]);
$produit = $sqlState->fetch(PDO::FETCH_ASSOC);


// Fetch comments for the current product
$commentsSql = $pdo->prepare("SELECT * FROM comments WHERE product_id=? ORDER BY created_at DESC");
$commentsSql->execute([$id]);
$comments = $commentsSql->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit | <?php echo $produit['name'] ?></title>
    
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }
        .field input:hover{
            letter-spacing: 0.5px;
            background-color:#007bff;
            font-size: 20px;
            transition: 0.5s;

        }

        .count {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .count h4 {
            margin-right: 20px;
        }

        .count button {
            background-color:#d3ad7f;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 20px;
            cursor: pointer;
            margin: 0 10px;
        }
        body{
            background-image: url(images/6092895.jpg);
            
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
    /* Comment Section Styles */
    .container2 {
        margin-top: 20px;
    }

    .container2 h2 {
        color: #1A120B;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .container2 ul {
        list-style-type: none;
        padding: 0;
    }

    .container2 li {
        margin-bottom: 15px;
    }

    .container2 strong {
        color: #C38154;
    }

    /* Add Comment Form Styles */
    .container2 form {
        margin-top: 20px;
    }

    .container2 label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #1A120B;
    }

    .container2 input[type="text"],
    .container2 textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #d3ad7f;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
    }

    .container2 textarea {
        resize: vertical;
    }

    .container2 button {
        background-color: #C38154;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 4px;
    }

    .container2 button:hover {
        background-color: #884A39;
    }
    img:hover{
        transform: scale(1.05);

    }
    #container{
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0));
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 20px;
        
        border:1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

  
    </style>
</head>

<body >

<?php include '../nav2.php'; ?>
<div>
    <a href="products.php" class="btn" style="background-color:#007bff;font-size:18px;color:#fff;border-radius:15px;
                background-color:#884A39;letter-spacing:1px;position:absolute;left:20px"><i class="fas fa-arrow-left"></i> go back</a>
</div>

<div class="container py-2" style="font-size: 20px;margin-top:100px;text-align: center; " id="container">
    
    <div class="container">
        <div class="row">
            <div class="col-md-6" style="margin-bottom:20px">
                <img style="border-radius: 20px;max-height:450px;margin-top:20px;max-width:450px;padding:25px" class="img img-fluid w-75" id='prodim' src="../upload/produit/<?php echo $produit['image'] ?>"
                     alt="<?php echo $produit['name'] ?>">
            </div>
            <div class="col-md-6" style="background-color: #d3ad7f;padding:30px;border-radius:10%">
                <?php
                $discount = $produit['discount'];
                $prix = $produit['prix'];
                ?>
                <div class="d-flex align-items-center" style="background-color:#884A39;border-radius:15px">
                    <h1 class="w-100" style="font-size: 30px;color:#fff;padding-left:50px"><?php echo $produit['name'] ?></h1>
                    <?php if (!empty($discount)) {
                        ?>
                        <span class="badge text-bg" style="background-color: #C38154;">- <?php echo $discount ?> %</span>
                        <?php
                    } ?>
                </div>
                <hr>

                <p class="text-justify" style="display: flex;text-transform: none; background-color:#C38154;border-radius:15px;padding:5px">
                    <?php echo  $produit['description']; ?>
                </p>
                <hr>
                <div class="d-flex">
                    <?php
                    if (!empty($discount)) {
                        $total = $prix - (($prix * $discount) / 100);
                        ?>
                        <h5 class="mx-1">
                            <span style="font-size: 20px;text-decoration: line-through;background-color:#6B4F4F" class="badge text-bg"><strike> <?php echo $prix ?> MAD </strike></span>
                        </h5>
                        <h5 class="mx-1">
                            <span class="badge text-bg" style="font-size: 20px;background-color:#483434"><?php echo $total ?> MAD </span>
                        </h5>

                        <?php
                    } else {
                        $total = $prix;
                        ?>
                         <h5>
                            <span class="badge text-bg" style="font-size: 20px;background-color:#483434"><?php echo $total ?> MAD</span>
                        </h5>


                        <?php
                    }
                    ?>

                </div>
        
        <hr>
    <form  method="POST" action="panier.php">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="count">
            <label for="quantity" style="font-size: 20px;font-weight:400">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" min='0' max='99' style="width: 60px;font-size:18px;background-color:#F9E0BB;border-color:#F9E0BB" value="1">
            <button onclick="decrementQuantity()" style="background-color: #C38154;">-</button>
            <button onclick="incrementQuantity()" style="background-color: #C38154;">+</button>
        </div>
        <hr>
        
        <div class="field" >
                <input type="submit" class="btn" name="submit" value="ajouter au panier" style="background-color:#007bff;font-size:18px;color:#fff;border-radius:15px;
                background-color:#884A39;letter-spacing:1px">
        </div>

    </form>


    </div>
    
    <div class="container2" style="background-color: rgba(211, 173, 127); border-radius: 3%; min-height: 100px; padding: 5%; display: flex; flex-direction: column; align-items: center;">
    <h2 style="font-size: 30px; margin-bottom: 10px;">Comments :</h2>
    <ul>
        <?php foreach ($comments as $comment) : ?>
            <li>
                <strong><?php echo htmlspecialchars($comment['user_name']); ?> : </strong>
                <?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?>
                <hr style="width: 250px;">
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Add Comment Form -->
    <div style="display: inline-block;">
        <form method="POST" action="post_comment.php" style="display: inline;">
            <input type="hidden" name="product_id" value="<?= $id ?>">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <input type="hidden" name="user_name" value="<?= $user_name ?>">
            <label for="comment_text">Your Comment:</label>
            <textarea name="comment_text" rows="2" style="background-color: #F9E0BB; border-color: #F9E0BB"></textarea>

            <button type="submit">Post Comment</button>
        </form>

        <form method="POST" action="delete_comments.php" onsubmit="return confirm('Are you sure you want to delete all comments?');" style="display: inline;">
            <input type="hidden" name="product_id" value="<?= $id ?>">
            <input type="hidden" name="user_name" value="<?= $user_name ?>">
            <button type="submit">
                Delete All Your Comments
            </button>
        </form>
    </div>
</div>

</div>

<script src="../js/script.js"></script>
<script>

var quantityInput = document.getElementById("quantity");

function incrementQuantity() {
    var currentQuantity = parseInt(quantityInput.value);
    var newQuantity = currentQuantity + 1;
    if (newQuantity <= 99) {
        quantityInput.value = newQuantity;
    }

    event.preventDefault();
}

function decrementQuantity() {
    var currentQuantity = parseInt(quantityInput.value);
    if (currentQuantity > 1) {
        var newQuantity = currentQuantity - 1;
        quantityInput.value = newQuantity;
    }

    event.preventDefault();
}

quantityInput.addEventListener("input", function () {
    var currentQuantity = parseInt(quantityInput.value);
    if (isNaN(currentQuantity) || currentQuantity < 1) {       
        quantityInput.value = 1;
    } else if (currentQuantity > 99) {
        quantityInput.value = 99;
    }
});

    </script>
   
</body>
</html>
