<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="design/css/main.css">
</head>

<body>
    <nav class="navbar">
        <ul>
            <li>
                <a href="index.php">
                    Home
                </a>
            </li>
            <li>
                <a href="About.php">
                    About
                </a>
            </li>
            <li>
                <a href="library.php">
                    library
                </a>
            </li>
        </ul>
        <?php
        if (!isset($_SESSION['child_ID'])) {
        ?>
            <div class="right">
                <a href="login.php">login | register</a>
            </div>
        <?php
        } else {
        ?>
            <div class="right">
                <a href="logout.php">logout</a>
            </div>
        <?php
        }
        ?>
    </nav>
    <section class="main-sec">
        <div class="left">
            <h2>best preschool education by proffesionals</h2>
            <p>this website has many files that it is important for the childs and also for young mens</p>
            <a href="library.php">explore</a>
        </div>
        <div class="right">
            <img src="design/images/flame-time-to-learn-lettering-with-flying-books-and-a-laptop.png" alt="">
        </div>
    </section>
</body>

</html>
<?php
ob_end_flush();
?>