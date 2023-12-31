<?php
session_start();

include("../admin/pdo.php");
if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
}

// Handle live search
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $stmt = $pdo->prepare('SELECT * FROM produit WHERE name LIKE :search');
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Load all products by default
    $searchResults = $pdo->query('SELECT * FROM produit')->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <style>
            /* Add styles for the search icon */
         .search-container {
            position: relative;
            margin: 20px 0;
        }
        #searchInput {
        padding-left: 30px; /* Adjust the left padding to create space for the icon */
        background-image: url('../upload/produit/search-solid.svg'); /* Replace with the path to your icon */
        background-repeat: no-repeat;
        color: #3C2A21 ;
        background-position: 5px center; /* Adjust the position of the icon */
        background-size: 20px; /* Adjust the size of the icon */
        width: 100%; 
        

        }
        


        .image img {
            max-width: 100%;
            height: auto;
        }

        body {
            background-image: url(images/6092895.jpg);
            /* background-color: #764D29; */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .box-container {
            text-align: center;
        }

        .box-container .box {
            
            vertical-align: top; /* Align the boxes to the top */
            
            max-width: 400px;
        }


    .box-container .box .image {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 200px; /* Set a fixed height for the image container */
    }

    .box-container .box img {
        max-height: 100%;
        max-width: 100%;
        border-radius: 10%;
    }

        .box-container .box:hover {
            transform: scale(1.03);
            background-color: #3C2A21;
        }

        #liveSearchResults {
            margin-top: 20px;
            text-align: center;
        }

        #liveSearchResults .search-box {
            width: 100%;
            display: inline-block !important;
            margin-bottom: 20px;
        }

        #liveSearchResults .box {
            
            vertical-align: top; /* Align the boxes to the top */
        }

        #liveSearchResults .box:hover {
            transform: scale(1.03);
        }

        #liveSearchResults .content {
            padding: 10px;
        }

        #searchInput {
            position: absolute;
            top: 50px;
            left:1060px;
            width: 290px;
            font-size: 22px;
            border-radius: 5px;
            background-color: #EFE8C0;
            border: 1.3px solid #3C2A21; 
        
        }
        #searchInput:hover {
            background-color: #E8CCAB;

        
        }
    </style>
</head>

<body>

    <?php include '../nav2.php'; ?>

    <!-- Add live search input field -->

        <div class="search-container">
            <input type="text" id="searchInput" onkeyup="liveSearch()" placeholder="Search for products..." autocomplete="off">
        </div>



    <!-- products section -->
    <section class="products" id="products" style="margin-top: 140px;">

        <div class="box-container grid grid-cols-3 gap-0.1" style="margin-right: 0;padding-right:0">
            <?php foreach ($searchResults as $produit) { ?>
                <div class="box" >
                    <div class="icons">
                        <a href="product_detail.php?id=<?= $produit['id']; ?>" class="fas fa-shopping-cart"></a>
                    </div>
                    <div class="image" >
                        <img style="max-height:200px;border-radius:10%;" src="../upload/produit/<?php echo $produit['image'] ?>" alt="">
                    </div>
                    <div class="content">
                        <a href="product_detail.php?id=<?= $produit['id']; ?>">
                            <h3 class="click"><?php echo $produit['name'] ?></h3>
                        </a>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <div class="price"><?php echo $produit['prix'] - (($produit['prix'] * $produit['discount']) / 100) . " MAD" ?>
                        <?php if ($produit['discount'] > 0) {
                            ?><span><?php echo $produit['prix'] . " MAD" ?></span><?php
                        }
                        ?></div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Add live search results div inside the products section -->
        <div id="liveSearchResults"></div>

    </section>
    <script src="../js/script.js"></script>



<script>
    function liveSearch() {
        var input, filter, container, boxes, h3, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        container = document.getElementById("liveSearchResults");
        boxes = document.getElementsByClassName("box");

        
        container.innerHTML = '';

        for (i = 0; i < boxes.length; i++) {
            h3 = boxes[i].getElementsByTagName("h3")[0];
            txtValue = h3.textContent || h3.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                boxes[i].style.display = "inline-block";
            } else {
                boxes[i].style.display = "none";
            }
        }

        // Fetch and display live search results using AJAX
        if (filter !== '') {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    container.innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "search_results.php?search=" + filter, true);
            xhttp.send();
        }
    }
</script>


</body>

</html>
