<?php

    if(isset($_GET['activate_account']) && isset($_GET['email'])){
        include '../checkup.php';
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        $_GET['email'] = mysqli_real_escape_string($conn, $_GET['email']);
        $sql = "SELECT * FROM se_users where user_email = '".$_GET['email']."'";
        if(mysqli_num_rows($result = mysqli_query($conn, $sql)) == 1){
            $row = mysqli_fetch_assoc($result);
            if($row['user_authenticate'] == $_GET['activate_account']){
                $sql = "UPDATE se_users SET user_authenticate = '' WHERE user_email = '".$_GET['email']."'";
                if(mysqli_query($conn, $sql)){
                    echo "<html>
                            <head>
                                <title>ACTIVATION SUCCESSFUL</title>
                                <link href = 'css/style.css' rel = 'stylesheet'/>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            </head>
                            <body>
                                <div class = 'success'><a href = 'login.php'>Go to Login</a></div>
                            </body>
                            </html>";
                }else{
                    echo "<html>
                            <head>
                                <title>ACTIVATION ERROR</title>
                                <link href = 'css/style.css' rel = 'stylesheet'/>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            </head>
                            <body>
                                <div class = 'danger'><a href = 'index.php'>Go to home</a></div>
                            </body>
                            </html>";
                }
            }
        }
    }

    else if(!defined('INCLUDED'))
        die(include '403.php');
?>