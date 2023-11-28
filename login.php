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
    <div class="overflowBG">
        <div class="blur"></div>
    </div>
    <form id="login-form" action="" method="post">
        <h2>please login</h2>
        <div class="input-field">
            <label for="">user name</label>
            <input type="text" name="uName" required>
        </div>

        <div class="input-field">
            <label for="">password</label>
            <input type="password" name="pass" required>
        </div>

        <div class="submit-field">
            <input type="submit" value="LOGIN" name="BTNlogin">
            <a href="sinup.php">or register now!</a>
        </div>
    </form>
</body>

</html>

<?php
if (isset($_POST['BTNlogin'])) {
    if (
        !empty($_POST['uName'])
        && !empty($_POST['pass'])
    ) {
        $uName = $_POST['uName'];
        $pass = $_POST['pass'];

        include('connect.php');

        $sql = "SELECT * FROM studentform WHERE uName = '$uName' AND pass = '$pass'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['child_ID'] = $row['child_ID'];
            $_SESSION['uName'] = $row['uName'];
            $_SESSION['pass'] = $row['pass'];
            header('REFRESH:0;URL=cheak.php');
        } else {
            echo 'Please check the data';
        }
    } else {
        echo "warning! Please fill in the fields";
    }
}
ob_end_flush();
