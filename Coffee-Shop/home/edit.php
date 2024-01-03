<?php
session_start();

include("../php/config.php");

// Check if the user is authenticated
if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}

$user = $_SESSION["username"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Change Profile|<?=$user?> </title>
    <style>
        body{
            background-image: url(images/6092895.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <!-- Header section starts -->
    <?php include '../nav.php'; ?>

    <div class="container" style="margin-top: 60px;">
        <div class="box form-box">
            <?php
                if (isset($_POST['submit'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];

                $id = $_SESSION['id'];

                // Use prepared statements to prevent SQL injection
                $edit_query = mysqli_prepare($con, "UPDATE users SET Username=?, Email=?, Age=? WHERE Id=?");
                mysqli_stmt_bind_param($edit_query, "ssii", $username, $email, $age, $id);
                $result = mysqli_stmt_execute($edit_query);

                if ($result) {
                    echo "<div class='message' style='font-size:20px; background-color:#3C2A21;'>
                        <p>Profile Updated!</p>
                    </div> <br>";
                    echo "<a href='home.php'><button class='btn'>Go Home</button></a>";
                } else {
                    die("Error occurred while updating profile");
                }
            } else {
                // Retrieve user data for pre-filling the form
                $id = $_SESSION['id'];
                $query = mysqli_query($con, "SELECT * FROM users WHERE Id=$id");

                while ($result = mysqli_fetch_assoc($query)) {
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_Age = $result['Age'];
                }
            ?>
            <header><i class="fas fa-pen fa-sm"></i> Change Profile</header>
            <!-- Form for updating user profile -->
            <form action="" method="post">
                <div class="field input">
                    <label for="username" style="font-size: 20px;">Username</label>
                    <input type="text" name="username" id="username" value="<?= $res_Uname; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email" style="font-size: 20px;">Email</label>
                    <input type="text" name="email" id="email" style="text-transform: none;" value="<?= $res_Email; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age" style="font-size: 20px;">Age</label>
                    <input type="number" name="age" id="age" value="<?= $res_Age; ?>" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Update" required>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/script.js"></script>
</body>

</html>
<?php } ?>
