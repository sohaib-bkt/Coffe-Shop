<?php 
session_start();
require_once("../admin/pdo.php");
require_once("../php/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffe</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body{
            background-image: url(images/6092895.jpg);
            background-size: cover;           
            background-position: center;
            background-attachment: fixed;
        }
        @media only screen and (-webkit-min-device-pixel-ratio: 2),
        only screen and (min-resolution: 192dpi) {
        body {
            background-image: url(images/6092895.jpg);
            }
            }
        .box-container .box:hover{
            transform: scale(1.1);
            background-color: #3C2A21;
        }
 

    </style>
</head>
<body >
    
<!-- header section starts  -->

<?php include '../nav.php'; ?>

<!-- home section starts  -->

<section class="home" id="home">

    <div class="content">
        <h3 style="font-family: lora;">Start Your Day with <span>Coffee</span></h3>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Placeat labore, sint cupiditate distinctio tempora reiciendis.</p>
        <a href="products.php" class="btn" style="font-size: 20px;">get yours now</a>
    </div>

</section>

<!-- home section ends -->

<!-- about section starts  -->

<section class="about" id="about">

    <h1 class="heading"> <span>about</span> us </h1>

    <div class="row">

        <div class="image">
            <img src="images/home/pexels-olena-bohovyk-3749174.jpg" style="height: 600px;" alt="">
        </div>

        <div class="content">
            <h3>what makes our coffee special?</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus qui ea ullam, enim tempora ipsum fuga alias quae ratione a officiis id temporibus autem? Quod nemo facilis cupiditate. Ex, vel?</p>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odit amet enim quod veritatis, nihil voluptas culpa! Neque consectetur obcaecati sapiente?</p>
            <a href="#" class="btn">learn more</a>
        </div>

    </div>

</section>

<!-- about section ends -->



<section class="products" id="products">

    <h1 class="heading"> our <span>products</span> </h1>

    <?php $produits = $pdo->query('SELECT * FROM produit LIMIT 3')->fetchAll(PDO::FETCH_ASSOC);
   foreach ($produits as $produit){?>
    <div class="box-container" style="width: 32% ;display:inline-block;  margin-bottom:20px;margin-right:1.5px">

        <div class="box">
            <div class="icons">
                <a href="product_detail.php?id=<?=$produit['id']; ?>" class="fas fa-shopping-cart"></a>
            </div>
            <div class="image" >
                <img style="max-height:200px;border-radius:10% ;max-width: 100% ;" src="../upload/produit/<?php echo $produit['image'] ?>"  alt="">
            </div>
            <div class="content">
                <a href="product_detail.php?id=<?=$produit['id']; ?>"><h3 class="click"><?php echo $produit['name'] ?></h3></a>
                
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <div class="price"><?php echo $produit['prix'] - (($produit['prix']*$produit['discount'])/100)." MAD" ?><span><?php echo $produit['prix']." MAD" ?></span></div>
            </div>
        </div>       
    </div>
    <?php }?>

</section>



<!-- contact section starts  -->

<section class="contact" id="contact">

    <h1 class="heading"> <span>contact</span> us </h1>

    <div class="row">
    
        <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2831.1184979886802!2d-6.586095466934825!3d34.247786201048186!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda75981d7f4af7f%3A0x7c2f963603c5685d!2sEcole%20Sup%C3%A9rieure%20de%20Technologie%20-%20K%C3%A9nitra!5e0!3m2!1sfr!2sma!4v1695381183909!5m2!1sfr!2sma" allowfullscreen="" loading="lazy"></iframe>

        <form id='contact'  method="post" action="send_mail.php">
            <h3>get in touch</h3>
            
            <div class="inputBox">
                <span class="fas fa-user"></span>     
                <input type="text" placeholder="name" name="name" autocomplete="off" ">
            </div>
            <div class="inputBox">
                <span class="fas fa-envelope"></span>
                <?php $em = $_SESSION['valid']?>
                <input type="email" placeholder="email" name="email" autocomplete="off" value="<?=$em?>" readonly>
            </div>
            <div class="inputBox">
                <span class="fas fa-envelope-open-text"></span>
                <input type="text" placeholder="text" name="text" autocomplete="off">
            </div>
            <input type="submit" name="send" value="contact now" class="btn">
        </form>

    </div>

</section>

<!-- contact section ends -->

<!-- blogs section starts  -->

<section class="blogs" id="blogs">

    <h1 class="heading"> our <span>blogs</span> </h1>

    <div class="box-container">

        <div class="box">
            <div class="image">
                <img src="images/blog-1.jpeg" alt="">
            </div>
            <div class="content">
                <a href="#" class="title">tasty and refreshing coffee</a>
                <span>by admin</span>
                <a href="#" class="btn">read more</a>
            </div>
        </div>

        <div class="box">
            <div class="image">
                <img src="images/blog-2.jpeg" alt="">
            </div>
            <div class="content">
                <a href="#" class="title">tasty and refreshing coffee</a>
                <span>by admin</span>
                <a href="#" class="btn">read more</a>
            
            </div>
        </div>

        <div class="box">
            <div class="image">
                <img src="images/blog-3.jpeg" alt="">
            </div>
            <div class="content">
                <a href="#" class="title">tasty and refreshing coffee</a>
                <span>by admin </span>
                <a href="#" class="btn">read more</a>
            </div>
        </div>

    </div>

</section>

<!-- blogs section ends -->

<!-- footer section starts  -->

<section class="footer">

    <div class="share">
        <a href="#" class="fab fa-facebook-f"></a>
        <a href="#" class="fab fa-twitter"></a>
        <a href="#" class="fab fa-instagram"></a>
        <a href="#" class="fab fa-linkedin"></a>
        <a href="#" class="fab fa-pinterest"></a>
    </div>

    <div class="links">
        <a href="#home">home</a>
        <a href="#about">about</a>     
        <a href="products.php">products</a>  
        <a href="commandes.php">commande</a>    
        <a href="#contact">contact</a>
        <a href="#blogs">blogs</a>
		<a href="../php/logout.php">logout</a> 
    </div>

    <div class="credit">created by <span>Sohaib</span> | <i class="far fa-copyright"></i> all rights reserved</div>

</section>

<!-- footer section ends -->

<script src="../js/script.js"></script>

</body>
</html>