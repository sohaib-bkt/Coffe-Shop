<?php

session_start();

include("../php/config.php");
if(!isset($_SESSION['valid'])){
 header("Location: ../index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<?php include'nav.php';?>

<section class="home" id="home">

    <div class="content">
    <p style="font-size: 40px;">hello <span class="span-admin" style="border-bottom:4px solid var(--main-color) ;color:var(--main-color);text-transform: uppercase;"><?php echo $_SESSION["username"]?></span></p>
    </div>

</section>

  
</body>
</html>
