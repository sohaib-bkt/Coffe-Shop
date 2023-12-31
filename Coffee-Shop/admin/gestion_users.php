<?php
session_start();
if(!isset($_SESSION['valid'])){
  header("Location: ../index.php");
 }
require_once 'pdo.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gestion users</title>
    
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body{
            background-image: url(../home/images/6092895.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .table-warning tr a{
        margin-top:0px;
        }
        .table-warning td {
        padding: 20px;
        }

    </style>
</head>
<body style="background-color:white">

<?php include'nav.php';?>
<!-- lists -->
<table class="table table-hover table-warning" style="margin-top: 200px;font-size: 20px;text-align:center;margin-bottom:50px">
  <thead>
    <tr>
      <th scope="col"><i class="fas fa-key"></i> id</th>
      <th scope="col"><i class="fas fa-users"></i> user name</th>
      <th scope="col"><i class="fas fa-child"></i> age</th>
      <th scope="col"><i class="fas fa-check-circle"></i> nb des commandes valide</th>
      <th scope="col"><i class="fas fa-dollar-sign"></i> totale</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php
        
        $users = $pdo->query('SELECT u.Id, u.Username, u.Age, COUNT(c.id) as nbr, SUM(c.total) as total FROM users u JOIN commande c ON u.Id = c.id_client WHERE c.valide = 1 GROUP BY u.Id')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $user){
            ?>
            <tr style="text-align:center">
                <td><?php echo $user['Id'] ?></td>
                <td><?php echo $user['Username'] ?></td>
                <td><?php echo $user['Age']?></td>
                <td><?php echo $user['nbr'] ?></td>
                <td><?php echo $user['total']." MAD" ?></td>
                <td style="width: 30%;">
                
                <a href="suprimer_user.php?id=<?php echo $user['Id'] ?>" onclick="return confirm('Voulez vous vraiment supprimer se utulisateur');" class="btn btn-danger" style="letter-spacing: 1px;font-size: 18px;"><i class="fas fa-trash-alt"></i> Supprimer</a>
                </td>
            </tr>
            <?php
        }
        ?>
  </tbody>
</table> 

</body>
</html>
