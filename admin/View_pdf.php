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
        $Class_ID = intval($_GET['Class_ID']);
    ?>
        <div class="sec-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#FFD24C" fill-opacity="0.8" d="M0,192L30,165.3C60,139,120,85,180,74.7C240,64,300,96,360,122.7C420,149,480,171,540,176C600,181,660,171,720,192C780,213,840,267,900,250.7C960,235,1020,149,1080,106.7C1140,64,1200,64,1260,85.3C1320,107,1380,149,1410,170.7L1440,192L1440,0L1410,0C1380,0,1320,0,1260,0C1200,0,1140,0,1080,0C1020,0,960,0,900,0C840,0,780,0,720,0C660,0,600,0,540,0C480,0,420,0,360,0C300,0,240,0,180,0C120,0,60,0,30,0L0,0Z"></path>
            </svg>
            <h2>all pdf attachements</h2>
            <a href="pdf_record_form.php?box=pdf&Class_ID=<?php echo $Class_ID ?>"">Add  new pdf attachment</a>
    </div>
    <?php
        require '../connect.php';
        $query = "SELECT * FROM pdf_record WHERE Class_ID = '$Class_ID'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
    ?>
        <table class=" table table-hover table-warning text-center" style="width: 80%; margin: 10px auto; vertical-align: middle;">
                <thead class="table-dark">
                    <th>Title</th>
                    <th>size</th>
                    <th>preview</th>
                    <th>Download</th>
                    <th>Attachment Status</th>
                    <th>Edit</th>
                    <th>delete</th>
                </thead>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['Attachment_Status'] == 1) {
                        echo "
                    <tr>
                        <th>" . $row['Title'] . "</th>
                        <th>" . floor($row['size'] / 1000) . " KB</th>
                        <th><a class='btn btn-primary' href='uploads/" . $row['Attached'] . "'>preview</a></th>
                        <th><a class='btn btn-dark' href='?box=Download&Attachment_ID=" . $row['Attachment_ID'] . "&Class_ID=" . $Class_ID . "'>Download</a></th>
                        <th><a class='btn btn-info' href='?box=Not_activated&Attachment_ID=" . $row['Attachment_ID'] . "&Class_ID=" . $Class_ID . "'>Not activated</a></th>
                        <th><a class='btn btn-warning' href='?box=Edit&Attachment_ID=" . $row['Attachment_ID'] . "&Class_ID=" . $Class_ID . "'>Edit</a></th>
                        <th><a class='btn btn-danger' href='?box=delete&Attachment_ID=" . $row['Attachment_ID'] . "&Class_ID=" . $Class_ID . "'>delete</a></th>
                    </tr>
                  ";
                    } elseif ($row['Attachment_Status'] == 2) {
                        echo "
                    <tr>
                        <th>" . $row['Title'] . "</th>
                        <th>" . floor($row['size'] / 1000) . " KB</th>
                        <th><a class='btn btn-primary' href='uploads/" . $row['Attached'] . "'>preview</a></th>
                        <th><a class='btn btn-dark' href='?box=Download&Attachment_ID=" . $row['Attachment_ID'] . "&Class_ID=" . $Class_ID . "'>Download</a></th>
                        <th><a class='btn btn-info' href='?box=activation&Attachment_ID=" . $row['Attachment_ID'] . "&Class_ID=" . $Class_ID . "'>activation</a></th>
                        <th><a class='btn btn-warning' href='?box=Edit&Attachment_ID=" . $row['Attachment_ID'] . "&Class_ID=" . $Class_ID . "'>Edit</a></th>
                        <th><a class='btn btn-danger' href='?box=delete&Attachment_ID=" . $row['Attachment_ID'] . "&Class_ID=" . $Class_ID . "'>delete</a></th>
                    </tr>
                  ";
                    }
                }
                ?>
                </table>
            <?php
        } else {
            echo 'No data to display';
        }
    } else {
        header('REFRESH:0;URL=../login.php');
    }

    if (isset($_GET['box'])) {
        if ($_GET['box'] == 'Download') {
            $Attachment_ID = intval($_GET['Attachment_ID']);
            $Class_ID = intval($_GET['Class_ID']);

            require '../connect.php';
            $query = "SELECT * FROM pdf_record WHERE Attachment_ID = '$Attachment_ID'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            $filepath = 'uploads/' . $row['Attached'];
            if (file_exists($filepath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($filepath));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize('uploads/' . $file['name']));
                readfile('uploads/' . $file['name']);
            } else {
                echo 'An error occurred in the download';
                header('REFRESH:2;URL=View_pdf.php?Class_ID=' . $Class_ID);
            }
        } elseif ($_GET['box'] == 'Edit') {
            $Attachment_ID = intval($_GET['Attachment_ID']);
            $Class_ID = intval($_GET['Class_ID']);

            require '../connect.php';
            $query = "SELECT * FROM pdf_record WHERE Attachment_ID = '$Attachment_ID'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            ?>
                <div class="abs-form">
                    <div class="overlay"></div>
                    <form id="login-form" class="abs-form-fields" action="" method="post" enctype="multipart/form-data">
                        <h2>Edit Attachment</h2>
                        <h4 class="alert alert-info">please fill all fields</h4>

                        <div class="input-field">
                            <label>Title</label>
                            <input type="text" name="Title" required value="<?php echo $row['Title'] ?>">
                        </div>
                        <div class="input-field">
                            <label>Upload File</label>
                            <input type="file" name="myfile">
                        </div>
                        <div class="submit-field">
                            <input type="submit" value="Edit" name="submit">
                        </div>
                    </form>
                </div>
        <?php
            if (isset($_POST['submit'])) {
                if (
                    !empty($_POST['Title'])
                    && !empty($_FILES["myfile"]["name"])
                ) {
                    $Title = $_POST['Title'];

                    $filename = $_FILES['myfile']['name'];
                    $destination = 'uploads/' . $filename;
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $file = $_FILES['myfile']['tmp_name'];
                    $size = $_FILES['myfile']['size'];
                    if (!in_array($extension, ['pdf'])) {
                        echo "You file extension must be .pdf";
                    } elseif ($_FILES['myfile']['size'] > (1000000 * 100)) {
                        echo "File too large!";
                    } else {
                        if (move_uploaded_file($file, $destination)) {
                            require '../connect.php';
                            $query = "UPDATE pdf_record SET Title = '$Title', Attached = '$filename', size = '$size' WHERE Attachment_ID = '$Attachment_ID'";
                            if ($conn->query($query) === TRUE) {
                                echo 'Data has been modified!';

                                if (file_exists('uploads/' . $row['Attached'])) {
                                    unlink('uploads/' . $row['Attached']);
                                }

                                header('REFRESH:2;URL=View_pdf.php?Class_ID=' . $Class_ID);
                            } else {
                                echo $conn->error;
                            }
                        } else {
                            echo "Failed to upload file.";
                        }
                    }
                } elseif (
                    !empty($_POST['Title'])
                ) {
                    $Title = $_POST['Title'];

                    require '../connect.php';
                    $query = "UPDATE pdf_record SET Title = '$Title' WHERE Attachment_ID = '$Attachment_ID'";
                    if ($conn->query($query) === TRUE) {
                        echo 'Data has been modified!';
                        header('REFRESH:2;URL=View_pdf.php?Class_ID=' . $Class_ID);
                    } else {
                        echo $conn->error;
                    }
                } else {
                    echo 'Please fill in the data';
                }
            }
        } elseif ($_GET['box'] == 'delete') {
            $Attachment_ID = intval($_GET['Attachment_ID']);
            $Class_ID = intval($_GET['Class_ID']);

            require '../connect.php';
            $query = "SELECT * FROM pdf_record WHERE Attachment_ID = '$Attachment_ID'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            require '../connect.php';
            $query = "DELETE FROM pdf_record WHERE Attachment_ID = '$Attachment_ID'";
            if ($conn->query($query) === TRUE) {
                echo 'File has been deleted!';

                if (file_exists('uploads/' . $row['Attached'])) {
                    unlink('uploads/' . $row['Attached']);
                }

                header('REFRESH:2;URL=View_pdf.php?Class_ID=' . $Class_ID);
            } else {
                echo 'An error occurred during the deletion process!';
            }
        } elseif ($_GET['box'] == 'Not_activated') {
            $Attachment_ID = intval($_GET['Attachment_ID']);
            $Class_ID = intval($_GET['Class_ID']);

            $Attachment_Status = 2;
            require '../connect.php';
            $query = "UPDATE pdf_record SET Attachment_Status = '$Attachment_Status' WHERE Attachment_ID = '$Attachment_ID'";
            if ($conn->query($query) === TRUE) {
                echo 'Data has been modified!';
                header('REFRESH:2;URL=View_pdf.php?Class_ID=' . $Class_ID);
            } else {
                echo $conn->error;
            }
        } elseif ($_GET['box'] == 'activation') {
            $Attachment_ID = intval($_GET['Attachment_ID']);
            $Class_ID = intval($_GET['Class_ID']);

            $Attachment_Status = 1;
            require '../connect.php';
            $query = "UPDATE pdf_record SET Attachment_Status = '$Attachment_Status' WHERE Attachment_ID = '$Attachment_ID'";
            if ($conn->query($query) === TRUE) {
                echo 'Data has been modified!';
                header('REFRESH:2;URL=View_pdf.php?Class_ID=' . $Class_ID);
            } else {
                echo $conn->error;
            }
        }
    }
        ?>
</body>

</html>

<?php
ob_end_flush();
?>