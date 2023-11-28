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
    <link rel="stylesheet" href="../design/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>

<body>
    <nav class="navbar">
        <ul>
            <li>
                <a href="pdf_content.php">
                    all pdf
                </a>
            </li>
            <li>
                <a href="Recording_content.php">
                    all records and songs
                </a>
            </li>
            <li>
                <a href="film.php">
                    all flims and movies
                </a>
            </li>
        </ul>
        <div class="right">
            <a href="../library.php">go to library</a>
        </div>
    </nav>

    <?php
    if (
        !empty($_SESSION['child_ID'])
        and $_SESSION['uName'] == 'admin'
        and $_SESSION['pass'] == 123
    ) {
    ?>
        <div class="sec-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#FFD24C" fill-opacity="0.8" d="M0,192L30,165.3C60,139,120,85,180,74.7C240,64,300,96,360,122.7C420,149,480,171,540,176C600,181,660,171,720,192C780,213,840,267,900,250.7C960,235,1020,149,1080,106.7C1140,64,1200,64,1260,85.3C1320,107,1380,149,1410,170.7L1440,192L1440,0L1410,0C1380,0,1320,0,1260,0C1200,0,1140,0,1080,0C1020,0,960,0,900,0C840,0,780,0,720,0C660,0,600,0,540,0C480,0,420,0,360,0C300,0,240,0,180,0C120,0,60,0,30,0L0,0Z"></path>
            </svg>
            <h2>our stories and books</h2>
            <a href="category.php?box=pdf">Add a new category</a>
        </div>
        <div class="cards-container">
            <?php
            require '../connect.php';
            $Category_type = 1;
            $query = "SELECT * FROM category WHERE Category_type = '$Category_type'";
            $result = mysqli_query($conn, $query);
            $count = mysqli_num_rows($result);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="card-container">
                        <div class="details">
                            <?php echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['picture']) . " '/> " ?>
                            <h4><?php echo $row['Category_title'] ?></h4>
                            <span><?php echo $row['Category_details'] ?></span>
                        </div>
                        <div class="btn">
                            <?php echo "<a class='btn btn-primary' href='?box=Edit&Class_ID=" . $row['Class_ID'] . "'>Edit</a> " ?>
                            <a href='View_pdf.php?Class_ID=<?php echo $row['Class_ID'] ?>' class="btn btn-warning">View</a>
                            <?php echo "<a class='btn btn-danger' href='?box=delete&Class_ID=" . $row['Class_ID'] . "'>delete</a> " ?>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo 'No data to display';
            }
            ?>

        </div>

        <?php
    } else {
        header('REFRESH:0;URL=../login.php');
    }

    if (isset($_GET['box'])) {
        if ($_GET['box'] == 'Edit') {
            $Class_ID = intval($_GET['Class_ID']);

            require '../connect.php';
            $query = "SELECT * FROM category WHERE Class_ID = '$Class_ID'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
        ?>
            <div class="abs-form">
                <div class="overlay"></div>
                <form id="login-form" class="abs-form-fields" action="" method="post" enctype="multipart/form-data">
                    <h2>Edit category data</h2>
                    <div class="input-field">
                        <label>Category_title</label>
                        <input type="text" name="Category_title" required value="<?php echo $row['Category_title'] ?>">
                    </div>

                    <div class="input-field">
                        <label>Category_details</label>
                        <textarea name="Category_details" cols="30" rows="2" require><?php echo $row['Category_details'] ?></textarea>
                    </div>

                    <div class="input-field">
                        <label>picture</label>
                        <input type="file" name="picture">
                    </div>
                    <div class="submit-field">
                        <input type="submit" value="Edit" name="submit">
                    </div>
                </form>
            </div>
    <?php
            if (isset($_POST['submit'])) {
                if (
                    !empty($_POST['Category_title'])
                    && !empty($_POST['Category_details'])
                    && !empty($_FILES["picture"]["name"])
                ) {
                    $Category_title = $_POST['Category_title'];
                    $Category_details = $_POST['Category_details'];

                    $fileName = basename($_FILES["picture"]["name"]);
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        $image = $_FILES['picture']['tmp_name'];
                        $imgContent = addslashes(file_get_contents($image));

                        require '../connect.php';
                        $query = "UPDATE category SET Category_title = '$Category_title', Category_details = '$Category_details', picture = '$imgContent' WHERE Class_ID = '$Class_ID'";
                        if ($conn->query($query) === TRUE) {
                            echo 'Data has been modified!';
                            header('REFRESH:2;URL=pdf_content.php');
                        } else {
                            echo $conn->error;
                        }
                    } else {
                        echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                    }
                } elseif (
                    !empty($_POST['Category_title'])
                    && !empty($_POST['Category_details'])
                ) {
                    $Category_title = $_POST['Category_title'];
                    $Category_details = $_POST['Category_details'];

                    require '../connect.php';
                    $query = "UPDATE category SET Category_title = '$Category_title', Category_details = '$Category_details' WHERE Class_ID = '$Class_ID'";
                    if ($conn->query($query) === TRUE) {
                        echo 'Data has been modified!';
                        header('REFRESH:2;URL=pdf_content.php');
                    } else {
                        echo $conn->error;
                    }
                } else {
                    echo 'Please fill in the data';
                }
            }
        } elseif ($_GET['box'] == 'delete') {
            $Class_ID = intval($_GET['Class_ID']);

            require '../connect.php';
            $query = "DELETE FROM category WHERE Class_ID = '$Class_ID'";
            if ($conn->query($query) === TRUE) {
                echo 'File has been deleted!';
                header('REFRESH:2;URL=pdf_content.php');
            } else {
                echo 'You cannot delete it because this category has data belonging to it!';
            }
        }
    }
    ?>
</body>

</html>
<?php
ob_end_flush();
?>