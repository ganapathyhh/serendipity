<?php
    error_reporting(0);
    define('INCLUDED', 1);
    require_once 'includes/function.php';
    $databaseHost = $_POST['hostname'];
    $databaseUsername  = $_POST['username'];
    $databasePassword = $_POST['password'];
    $databaseName = $_POST['dbname'];
    $websiteTitle = $_POST['websitename'];
    $adminEmail = $_POST['adminemail'];
    $adminPassword = $_POST['adminpass'];
?>

<html>
    <head>
        <title>Install - Serendipity - Page 2</title>
        <?php require_once 'admin_header_styles.php'; ?>
    </head>
    <body>
        <div class = "grid-x grid-padding-x">
            <div class = "large-3 cell"></div>
            <div class = "large-6 cell">
                <div class = "callout">
                    <?php 
                        if(empty($databaseHost) || empty($databaseUsername) || empty($databasePassword) || empty($websiteTitle) || empty($adminEmail) || empty($adminPassword) || empty($databaseName)){
                    ?>
                    <h3>Please fill the form.</h3>
                    <p>You appear to leave the form fields empty. Please fill the form and try submitting again. </p>
                    <a href = "install.php" class = "button secondary">Go back</a>
                    <?php
                        }else if(!mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName)){
                    ?>
                    <h3>Couldn't connect to database.</h3>
                    <p>The details you entered are incorrect. We could not establish connection to your database. Please ensure the details you entered are correct. The error could be due to any of the reasons:
                        
                        <li>Database not present in the host.</li>
                        <li>Database Username/Password incorrect.</li>
                        <li>Database name incorrect. Some hosts use username_ as prefix for database name.</li>
                    </p>
                    <a href = "install.php" class = "button secondary">Go back</a>
                    <?php
                        }else if(install($databaseHost, $databaseUsername, $databasePassword, $databaseName, $websiteTitle, $adminEmail, $adminPassword)){
                    ?>
                    <h3>Tables added successfully.</h3>
                    <p>Installation successful and tables have been added to the database. Make your website fast. Login using your admin as username or email that you provided and the password that you entered to login into your account.
                    </p>
                    <a href = "login.php" class = "button secondary">Go to login page</a>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class = "large-6 cell"></div>
        </div>
    </body>
</html>