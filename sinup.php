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
    <form action="" method="post" id="login-form" style="width: 80%;">
        <h2>create new account to watch, play and download</h2>
        <div class="field">
            <div class="input-field">
                <label for="">full_baby_name</label>
                <input type="text" name="full_baby_name" required>
            </div>

            <div class="input-field">
                <label for="">uName</label>
                <input type="text" name="uName" required>
            </div>

            <div class="input-field">
                <label for="">pass</label>
                <input type="password" name="pass" required>
            </div>
        </div>
        <div class="field">
            <div class="input-field">
                <label for="">date_of_birth</label>
                <input type="date" name="date_of_birth" required>
            </div>

            <div class="input-field">
                <label for="">baby_gender</label>
                <select name="baby_gender">
                    <option value="1">MALE</option>
                    <option value="2">FEMALE</option>
                </select>
            </div>

            <div class="input-field">
                <label for="">The_language_you_want_to_learn</label>
                <select name="The_language_you_want_to_learn">
                    <option value="1">Arabic Language</option>
                    <option value="2">English language</option>
                </select>
            </div>
        </div>

        <div class="field">
            <div class="input-field">
                <label for="">language_speaking_level</label>
                <select name="language_speaking_level">
                    <option value="1">YES</option>
                    <option value="2">NO</option>
                </select>
            </div>

            <div class="input-field">
                <label for="">studied_it_before</label>
                <select name="studied_it_before">
                    <option value="1">YES</option>
                    <option value="2">YES</option>
                </select>
            </div>

            <div class="input-field">
                <label for="">language_study_level</label>
                <select name="language_study_level">
                    <option value="1">junior</option>
                    <option value="2">Average</option>
                    <option value="3">advanced</option>
                </select>
            </div>
        </div>


        <div class="field">
            <div class="input-field">
                <label for="">Father_name</label>
                <input type="text" name="Father_name" required>
            </div>

            <div class="input-field">
                <label for="">mother_name</label>
                <input type="text" name="mother_name" required>
            </div>
            <div class="input-field">
                <label for="">supervisor</label>
                <select name="supervisor">
                    <option value="1">his mom</option>
                    <option value="2">His father</option>
                    <option value="3">Both</option>
                </select>
            </div>
        </div>

        <div class="field">
            <div class="input-field">
                <label for="">email</label>
                <input type="email" name="email">
            </div>

            <div class="input-field">
                <label for="">Telephone</label>
                <input type="text" name="Telephone" required>
            </div>

            <div class="input-field">
                <label for="">country</label>
                <input type="text" name="country" required>
            </div>

        </div>
        <div class="field">
            <div class="input-field">
                <label for="">current_residence</label>
                <input type="text" name="current_residence" required>
            </div>

            <div class="input-field">
                <label for="">current_residential_address</label>
                <textarea name="current_residential_address" rows="3" required></textarea>
            </div>

            <div class="input-field">
                <label for="">message_question</label>
                <textarea name="message_question" rows="3"></textarea>
            </div>
        </div>

        <div class="submit-field">
            <input type="submit" value="SINUP" name="BTNsend"> <br>
            <a href="login.php">LOGIN</a>
        </div>
    </form>
</body>

</html>

<?php
if (isset($_POST['BTNsend'])) {
    if (
        !empty($_POST['full_baby_name'])
        && !empty($_POST['uName'])
        && !empty($_POST['pass'])
        && !empty($_POST['baby_gender'])
        && !empty($_POST['The_language_you_want_to_learn'])
        && !empty($_POST['language_speaking_level'])
        && !empty($_POST['studied_it_before'])
        && !empty($_POST['language_study_level'])
        && !empty($_POST['Father_name'])
        && !empty($_POST['mother_name'])
        && !empty($_POST['supervisor'])
        && !empty($_POST['Telephone'])
        && !empty($_POST['country'])
        && !empty($_POST['current_residence'])
        && !empty($_POST['current_residential_address'])
    ) {
        $full_baby_name = $_POST['full_baby_name'];
        $uName = $_POST['uName'];
        $pass = $_POST['pass'];
        $date_of_birth = $_POST['date_of_birth'];
        $baby_gender = $_POST['baby_gender'];
        $The_language_you_want_to_learn = $_POST['The_language_you_want_to_learn'];
        $language_speaking_level = $_POST['language_speaking_level'];
        $studied_it_before = $_POST['studied_it_before'];
        $language_study_level = $_POST['language_study_level'];
        $Father_name = $_POST['Father_name'];
        $mother_name = $_POST['mother_name'];
        $supervisor = $_POST['supervisor'];
        $email = $_POST['email'];
        $Telephone = $_POST['Telephone'];
        $country = $_POST['country'];
        $current_residence = $_POST['current_residence'];
        $current_residential_address = $_POST['current_residential_address'];
        $message_question = $_POST['message_question'];

        include('connect.php');

        $sql = "SELECT * FROM studentform WHERE uName = '$uName'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            echo 'You cannot create an account with this name' . $uName;
        } else {
            $query = "
            INSERT INTO studentform
            (full_baby_name, uName, pass, date_of_birth, baby_gender, The_language_you_want_to_learn, language_speaking_level, studied_it_before, language_study_level, Father_name,
            mother_name, supervisor, email, Telephone, country, current_residence, current_residential_address, message_question)
            VALUES 
            ('$full_baby_name', '$uName', '$pass', '$date_of_birth', '$baby_gender', '$The_language_you_want_to_learn', '$language_speaking_level', '$studied_it_before', '$language_study_level',
             '$Father_name', '$mother_name', '$supervisor', '$email', '$Telephone', '$country', '$current_residence', '$current_residential_address', '$message_question')
            ";
            if ($conn->query($query) === TRUE) {
                $sql = "SELECT * FROM studentform WHERE uName = '$uName'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $_SESSION['child_ID'] = $row['child_ID'];
                $_SESSION['uName'] = $row['uName'];
                $_SESSION['pass'] = $row['pass'];
                header('REFRESH:0;URL=cheak.php');
            } else {
                echo $conn->error;
            }
        }
    } else {
        echo "warning! Please fill in the fields";
    }
}
ob_end_flush();
