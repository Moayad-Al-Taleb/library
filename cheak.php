<?php
session_start();
if (!empty($_SESSION['child_ID'])) {
    if ($_SESSION['uName'] == 'admin' && $_SESSION['pass'] == '123') {
        header('REFRESH:0;URL=admin/pdf_content.php');
    } else {
        header('REFRESH:0;URL=library.php');
    }
}
