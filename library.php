<?php
session_start();
ob_start();
?>
<?php
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
    <div class="sec-title">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#FFD24C" fill-opacity="0.8" d="M0,192L30,165.3C60,139,120,85,180,74.7C240,64,300,96,360,122.7C420,149,480,171,540,176C600,181,660,171,720,192C780,213,840,267,900,250.7C960,235,1020,149,1080,106.7C1140,64,1200,64,1260,85.3C1320,107,1380,149,1410,170.7L1440,192L1440,0L1410,0C1380,0,1320,0,1260,0C1200,0,1140,0,1080,0C1020,0,960,0,900,0C840,0,780,0,720,0C660,0,600,0,540,0C480,0,420,0,360,0C300,0,240,0,180,0C120,0,60,0,30,0L0,0Z"></path>
        </svg>
        <h2>our stories and books</h2>
    </div>
    <div class="cards-container">
        <?php
        require 'connect.php';
        $Category_type_1 = 1;
        $query_Category_type_1 = "SELECT * FROM category WHERE Category_type = '$Category_type_1'";
        $result_Category_type_1 = mysqli_query($conn, $query_Category_type_1);
        $count_Category_type_1  = mysqli_num_rows($result_Category_type_1);
        $counter_Category_type_1 = 1;
        if ($count_Category_type_1 > 0) {
            while ($row_Category_type_1 = mysqli_fetch_assoc($result_Category_type_1)) {
        ?>
                <div class="card-container">
                    <div class="details">
                        <?php echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row_Category_type_1['picture']) . " '/> " ?>
                        <h4><?php echo $row_Category_type_1['Category_title'] ?></h4>
                        <span><?php echo $row_Category_type_1['Category_details'] ?></span>
                    </div>
                    <div class="btn">
                        <a class="view-btn" href='View.php?box=View_pdf&Class_ID=<?php echo $row_Category_type_1['Class_ID'] ?>'>View</a>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>

    <div class="sec-title">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#FFD24C" fill-opacity="0.8" d="M0,192L30,165.3C60,139,120,85,180,74.7C240,64,300,96,360,122.7C420,149,480,171,540,176C600,181,660,171,720,192C780,213,840,267,900,250.7C960,235,1020,149,1080,106.7C1140,64,1200,64,1260,85.3C1320,107,1380,149,1410,170.7L1440,192L1440,0L1410,0C1380,0,1320,0,1260,0C1200,0,1140,0,1080,0C1020,0,960,0,900,0C840,0,780,0,720,0C660,0,600,0,540,0C480,0,420,0,360,0C300,0,240,0,180,0C120,0,60,0,30,0L0,0Z"></path>
        </svg>
        <h2>our recorded classes and songs</h2>
    </div>

    <div class="cards-container">
        <?php
        $Category_type_2 = 2;
        $query_Category_type_2 = "SELECT * FROM category WHERE Category_type = '$Category_type_2'";
        $result_Category_type_2 = mysqli_query($conn, $query_Category_type_2);
        $count_Category_type_2  = mysqli_num_rows($result_Category_type_2);
        $counter_Category_type_2 = 1;
        if ($count_Category_type_2 > 0) {
            while ($row_Category_type_2 = mysqli_fetch_assoc($result_Category_type_2)) {
        ?>
                <div class="card-container">
                    <div class="details">
                        <?php echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row_Category_type_2['picture']) . " '/> " ?>
                        <h4><?php echo $row_Category_type_2['Category_title'] ?></h4>
                        <span><?php echo $row_Category_type_2['Category_details'] ?></span>
                    </div>
                    <div class="btn">
                        <a class="view-btn" href='View.php?box=View_record&Class_ID=<?php echo $row_Category_type_2['Class_ID'] ?>'>View</a>
                    </div>
                </div>
        <?php
            }
        } else {
            echo 'No data has been added for now...Soon we will add data';
        }
        ?>
    </div>
    <div class="sec-title">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#FFD24C" fill-opacity="0.8" d="M0,192L30,165.3C60,139,120,85,180,74.7C240,64,300,96,360,122.7C420,149,480,171,540,176C600,181,660,171,720,192C780,213,840,267,900,250.7C960,235,1020,149,1080,106.7C1140,64,1200,64,1260,85.3C1320,107,1380,149,1410,170.7L1440,192L1440,0L1410,0C1380,0,1320,0,1260,0C1200,0,1140,0,1080,0C1020,0,960,0,900,0C840,0,780,0,720,0C660,0,600,0,540,0C480,0,420,0,360,0C300,0,240,0,180,0C120,0,60,0,30,0L0,0Z"></path>
        </svg>
        <h2>our short films and movies</h2>
    </div>
    <div class="cards-container">
        <?php
        require 'connect.php';
        $query = "SELECT * FROM film WHERE Attachment_Status = '1'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <div class="movie-card">
                    <video width='250' height='150' controls>
                        <source src='admin/uploads/' type='video/mp4'>
                        <source src='admin/uploads/<?php echo $row['film'] ?>' type='video/ogg'>
                        Your browser does not support the video tag.
                    </video>
                    <div class="title"><?php echo $row['Title'] ?></div>
                    <div class="details"><?php echo $row['movie_details'] ?></div>
                    <a href="?box=Download&Movie_ID=<?php echo $row['Movie_ID'] ?>">download</a>
                </div>
            <?php
            }
            ?>
    </div>
    <div class="sec-footer">

    </div>
<?php
        } else {
            echo 'No data to display';
        }

        if (isset($_GET['box'])) {
            if ($_GET['box'] == 'Download') {
                if (empty($_SESSION['child_ID'])) {
                    echo "Please log in or create an account to be able to download <a href='login.php'>Click here</a>";
                } else {
                    $Movie_ID = intval($_GET['Movie_ID']);

                    require 'connect.php';
                    $query = "SELECT * FROM film WHERE Movie_ID = '$Movie_ID'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);

                    $filepath = 'admin/uploads/' . $row['film'];
                    if (file_exists($filepath)) {
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename=' . basename($filepath));
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize('admin/uploads/' . $file['name']));
                        readfile('admin/uploads/' . $file['name']);
                    } else {
                        echo 'An error occurred in the download';
                    }
                }
            }
        }
?>
</body>

</html>

<?php
ob_end_flush();
?>