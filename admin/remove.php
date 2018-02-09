<?php
    require_once('../checkup.php');
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    $sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '".DBNAME."'";
    if($res = mysqli_query($conn, $sql)){
        while($row = mysqli_fetch_assoc($res)){
            mysqli_query($conn, 'DROP TABLE IF EXISTS '.$row['table_name']);
        }
    }
if(file_exists('../config.ini'))
    unlink('../config.ini');
else
    unlink('/tmp/config.ini');
header('location:index.php');
exit();
?>