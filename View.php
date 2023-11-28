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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
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
                <a href="login.php">logout</a>
            </div>
        <?php
        }
        ?>
    </nav>
    <?php
    if (isset($_GET['box'])) {
        if ($_GET['box'] == 'View_pdf') {
            $Class_ID = intval($_GET['Class_ID']);
            if (!isset($_SESSION['child_ID'])) {
    ?>
                <h4 class="alert alert-warning">If you want to download a file, you must log in or create an account with us</h4>
            <?php
            }
            require 'connect.php';
            $query = "SELECT * FROM pdf_record WHERE Class_ID = '$Class_ID' AND Attachment_Status = '1'";
            $result = mysqli_query($conn, $query);
            $count = mysqli_num_rows($result);
            if ($count > 0) {
            ?>
                <table class="table table-hover text-center" style="width: 80%; margin: 10px auto; vertical-align: middle;">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>size</th>
                            <th>preview</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                    <tr>
                        <th>" . $row['Title'] . "</th>
                        <th>" . floor($row['size'] / 1000) . " KB</th>
                        <th><a href='admin/uploads/" . $row['Attached'] . "' class='btn btn-warning'>preview</a></th>
                        <th><a href='?box=Download&Attachment_ID=" . $row['Attachment_ID'] . "&Class_ID=" . $Class_ID . "' class='btn btn-primary'>Download</a></th>
                    </tr>
                  ";
                    }
                    ?>
                </table>
            <?php
            } else {
                echo 'No data has been added for now...Soon we will add data';
            }
        } elseif ($_GET['box'] == 'View_record') {
            $Class_ID = intval($_GET['Class_ID']);
            if (!isset($_SESSION['child_ID'])) {
            ?>
                <h4 class="alert alert-warning">If you want to download a file, you must log in or create an account with us</h4>
            <?php
            }
            require 'connect.php';
            $query = "SELECT * FROM pdf_record WHERE Class_ID = '$Class_ID' AND Attachment_Status = '1'";
            $result = mysqli_query($conn, $query);
            $count = mysqli_num_rows($result);
            if ($count > 0) {
            ?>
                <table class="table table-hover text-center" style="width: 80%; margin: 10px auto; vertical-align: middle;">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>size</th>
                            <th>preview</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                    <tr>
                        <th>" . $row['Title'] . "</th>
                        <th>" . floor($row['size'] / 1000) . " KB</th>
                        <th>
                            <audio controls>
                                <source src='admin/uploads/" . $row['Attached'] . "' type='audio/ogg'>
                                <source src='admin/uploads/" . $row['Attached'] . "' type='audio/mpeg'>
                                Your browser does not support the audio element.
                            </audio>
                        </th>
                        <th><a href='?box=Download&Attachment_ID=" . $row['Attachment_ID'] . "&Class_ID=" . $Class_ID . "' class='btn btn-primary'>Download</a></th>
                    </tr>
                  ";
                    }
                    ?>
                </table>
    <?php
            } else {
                echo 'No data has been added for now...Soon we will add data';
            }
        } elseif ($_GET['box'] == 'Download') {
            if (empty($_SESSION['child_ID'])) {
                echo "Please log in or create an account to be able to download <a href='login.php'>Click here</a>";
            } else {
                $Attachment_ID = intval($_GET['Attachment_ID']);
                $Class_ID = intval($_GET['Class_ID']);

                require 'connect.php';
                $query = "SELECT * FROM pdf_record WHERE Attachment_ID = '$Attachment_ID'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);

                $filepath = 'admin/uploads/' . $row['Attached'];
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