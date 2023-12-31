
<header class="header">
    <style>
        #imglogo{
            border-radius: 60px;
            }
        #imglogo:hover{
            transform: scale(1.1);
            background-color: #d3ad7f;

        }
    </style>
    <a href="home.php" class="logo" id="imglogo">
        <img src="images/logo2.png" alt="">
    </a>

    <nav class="navbar">
        <a href="home.php">home</a>
        <a href="home.php #about">about</a>      
        <a href="products.php ">products</a>
        <a href="commandes.php"  style="text-decoration: none;">commandes</a>     
        <a href="home.php #contact">contact</a>
        <a href="home.php #blogs">blogs</a>
        <a href="../php/logout.php">logout</a> 

		
    </nav>
    <div style="padding: 6px;" id="logoname">  
    <a href="edit.php"><p style="font-size: 18px;color:#d3ad7f"><i class="fas fa-user-circle fa-lg" style="font-size: 25px;color:#d3ad7f"></i>  <?= strtoupper($_SESSION['username']);?></p></a>
    </div>
 

	<div class="icons">
        <div class="fas fa-bars" id="menu-btn"></div>
    </div>



</header>