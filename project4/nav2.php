<?php
include('home/check.php');

?>
<header class="header" >
    <a href="home.php" class="logo">
        <img src="../home/images/logo2.png" alt="">
    </a>
    <nav class="navbar"">
    <a href="home.php "  style="text-decoration: none;">home</a>
    <a href="home.php #about" style="text-decoration: none;">about</a>      
    <a href="products.php "style="text-decoration: none;">products</a> 
    <a href="commandes.php"  style="text-decoration: none;">commandes</a>    
    <a href="home.php #contact"style="text-decoration: none;">contact</a>
    <a href="home.php #blogs"style="text-decoration: none;">blogs</a>
    <a href="../php/logout.php"style="text-decoration: none;">logout</a> 
</nav>
<div class="icons" style="position: relative;display: inline-block;">
                <a href="panier.php" class="fas fa-shopping-cart" style="font-size: 20px;color:azure"></a>
                <span id="cartItemCount" style=" position: absolute;top: -10px;right: -10px; background-color: #d3ad7f;color: #ffffff;padding: 5px 8px;border-radius: 50%;font-size: 9px;font-weight:800">
                <?php echo $count ?></span>
</div>
<div class="icons">
    <div class="fas fa-bars" id="menu-btn"></div>
</div>


</header>
<!-- end navbar -->
