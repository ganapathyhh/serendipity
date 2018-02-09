<?php
// Shows 403 error when opened directly
if(!defined('INCLUDED'))
    die(include '403.php');


if(defined('DBNAME') && defined('DBHOST') && defined('DBUSER') && defined('DBPASS'))
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

/*
   * Checks whether the user has logged in
   *
    *Returns TRUE when user logged in
    *
    *Otherwise return FALSE
*/

function logged_in(){
    if(isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED'] == true)
        return true;
    return false;
}

function obtainUserAgent(){
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}
/**
*Login to the account using username and password
*
*Checks form for empty fields
*
*Checks for invalid email
*
*Obtain parameters and make session varialbes
*/

function login($user, $pass){
    $bad_login_limit = 3;
    $lockout_time = 600;
    if($user == '' || $pass == '')
        $_SESSION['ERROR'] = 'Fill the form';
    else{
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        $user = mysqli_real_escape_string($conn, $user);
        $pass = mysqli_real_escape_string($conn, $pass);
        $pass = md5($pass);
        $sql = "SELECT * FROM se_users WHERE user_login = '".$user."' OR user_email = '".$user."' ";
        if((mysqli_num_rows($result = mysqli_query($conn, $sql)) == 1)){
            $row = mysqli_fetch_assoc($result);
            
            /**
            *Checks for number of logged in attempts made by the user
            *
            *If the user makes more than 3 incorrect attempts then a mai is sent
            *
            *With security purpose the mail can contain user to change his/her password
            *
            *This helps in protection against the brute force attacks
            *
            *Updates the failed login attempts to database and fetches again to check  for multiple attempts within certain time limit
            */
            
            $first_failed_login = $row['user_failed_login'];
            $failed_login_count = $row['user_failed_status'];
            if(
                ($failed_login_count >= $bad_login_limit)
                &&
                (time() - $first_failed_login < $lockout_time)
            ) {
              $_SESSION['ERROR'] = "You are currently locked out. Please try again after ".ceil((($lockout_time - (time() - $first_failed_login))/60))." minutes.";
                if(!check_server())
                    mailBody($user, 2);
              return false; // or return, or whatever.
            } else if( $pass != $row['user_pass'] ) {
              if( time() - $first_failed_login > $lockout_time ) {
                // first unsuccessful login since $lockout_time on the last one expired
                $first_failed_login = time(); // commit to DB
                $failed_login_count = 1; // commit to db
                mysqli_query($conn, "UPDATE se_users SET user_failed_login = ".$first_failed_login.", user_failed_status = ".$failed_login_count." WHERE user_email = '".$user."' OR user_login = '".$user."'");  
              } else {
                $failed_login_count++; // commit to db.
                mysqli_query($conn, "UPDATE se_users SET user_failed_status = ".$failed_login_count." WHERE user_email = '".$user."' OR user_login = '".$user."'");
              }
                $_SESSION['ERROR'] = "Incorrect password.";
                return false;
            }else{
                
                /**
                *Sets the session variables
                *
                *Type session variable sets the user type
                *
                *Set authorized session variable as true to denote the user is logged in
                *
                *Set the timestamp value as current time
                *
                *Set the user id value as user's id
                */
                
                $_SESSION['TYPE'] = $row['user_type'];
                $_SESSION['ID'] = $row['ID'];
                $_SESSION['AUTHORIZED'] = true;
                $_SESSION["USER"] = $user;
                $_SESSION['TIMESTAMP'] = time();
                if($row['user_enter'] != 0)
                    header('Location: dashboard.php');
                else{
                    updateFirstTime($user);   
                    header('location: index.php');
                }
                exit();
            }
        }else{
            $_SESSION['ERROR'] = 'Incorrect username. Sorry, you don\'t have access!';
        }
        mysqli_close($conn);
    }
    
}

/***
*Updates the first time view for the user
*
*First time the features of the product must be displayed
*
*During the display the field will be updated for next time view
*/

function updateFirstTime($ch){
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    mysqli_query($conn, "UPDATE se_users SET user_enter = 1 WHERE ID = ".$ch);
    mysqli_close($conn);
}

function mailBody($user, $ch, $password = 0, $conn = 0){
    $key = bin2hex(openssl_random_pseudo_bytes(16));
    switch($ch){
        case 0:
            $sql = "Update se_users set user_authenticate = '".$key."' WHERE user_email = '".$user."'";
            mysqli_query($conn, $sql);
            $mailto      = $user;
            $mailsubject = "Serendipity registration - Account Verification";
            $mailmessage = "<html>
                            <body>
                            <center><h3>Thank you for registering at Serendipity!</h3></center>
                            <br/> Please follow this link to activate your account. <a href = '".(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/activate.php?activate_account=".$key."&email=".$user."'>click here</a><br/><br/>";
            mail_send($mailto, $mailsubject, $mailmessage);
            break;
        case 1:
            $mailto = $user;
            $mailsubject = "Welcome to serendipity dashboard";
            $mailmessage = "<html>
                            <body>
                            <center><h3>Your account has been created successfully!</h3></center>
                            <br/>
                            <h3>Your account details:</h3><br/>
                            <strong>Username: </strong> <em>(Use this email address)</em><br/>
                            <strong>Password: </strong> <em>".$password."</em>
                            <br/>
                            <br/>Follow this link to go to <a href = '".(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/login.php'>login page.</a><br/>
                            <br/> Please follow this link to activate your account. <a href = '".(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/activate.php?activate_account=".$key."&email=".$user."'>click here</a><br/><br/>";
            mail_send($mailto, $mailsubject, $mailmessage);
            break;
        case 2:
            $mailto = $user;
            $sql = "SELECT * FROM se_users WHERE user_email = '".$user."'";
            global $conn;
            $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
            $mailsubject = "Security Alert";
            $userAgent = obtainUserAgent();
            $mailmessage = "<html>
                            <body>
                            <center><h3>Verify whether it's you</h3></center>
                            <br/>
                            <p>Your account was just signed in at <strong>".date("d F Y H:i:s", $row['user_failed_login'])."</strong> using <strong>".$userAgent['name']." ".$userAgent['version']."</string> from <strong>".$userAgent['platform']."</strong>. You're getting this email to make sure it was you.</p>
                            <br/>
                            <br/> Please follow this link to report and reset your password if it wasn't you by <a href = '".(isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/reset.php?report=true'>clicking here</a><br/><br/>";
            mail_send($mailto, $mailsubject, $mailmessage);
            break;
        case 3:
            $password = generatePassword();
            $pass = md5($password);
            $sql = "UPDATE se_users SET user_pass = '".$pass."', user_failed_status = 0, user_failed_login = 0 WHERE user_email = '".$user."'";
            global $conn;
            mysqli_query($conn, $sql);
            $mailto = $user;
            $mailsubject = "Forgot password";
            $mailmessage = "<html>
                            <body>
                            <center><h3>Reset password</h3></center>
                            <br/>
                            <p>New password for your account is: ".$password."</p><br/>
                            <p>Using above password follow through the below link to login to your account and reset your password.</p>
                            <br/>
                            <br/> Please follow this link to reset your password by <a href = '".(isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/login.php'>clicking here</a><br/><br/>";
            mail_send($mailto, $mailsubject, $mailmessage);
            break;
    }
}

/**
   * RESET PASSWORD
   *
   *Sends email to reset and change password
*/

function resetPass($user){
    if($user == '')
        $_SESSION['ERROR'] = 'Fill the form';
    else if (!filter_var($user, FILTER_VALIDATE_EMAIL))
        $_SESSION['ERROR'] = 'Invalid email';
    else{
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        $user = mysqli_real_escape_string($conn, $user);
        $getUser = "SELECT * FROM se_users WHERE user_email = '".$user."';";
        if(mysqli_num_rows($result = mysqli_query($conn, $getUser)) == 1){
            if(!check_server()){
                mailBody($user, 3);
                $_SESSION['SUCCESS'] = 'An email has been sent to your registered email address for resetting your password.';
                header('location: login.php');
                exit();
            }else{
                $sql1 = "UPDATE se_users SET user_pass = '".md5('password')."', user_failed_login = 0, user_failed_status = 0 WHERE user_email = '".$user."'";
                if(mysqli_query($conn, $sql1)){
                    $_SESSION['SUCCESS'] = "Use 'password' as your password to sign in.";
                    header('location: login.php');
                    exit();
                }else{
                    $_SESSION['ERROR'] = 'Error occurred. Try again.';
                    return false;
                }
            }
        }else{
            $_SESSION['ERROR'] = 'Sorry we cannot find such username.';
            return false;
        }
        mysqli_close($conn);
    }
    
}

/**
    *Sends the authentication key on regitsration by admin
    *
    *Used for sending mails when not in localhost
    *
    *This uses mailBody to have cases
    *
    *This uses basic PHP mail() function to send emails
    *
    *Returns true if the mail is sent
    *
    *Returns false if the mail is not sent
*/

function mail_send($to, $subject, $message){
    $message .= "<p>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</p>

                            <p><strong>Disclaimer:</strong></p>
                            <p>The contents of this e-mail message may be privileged and confidential. Therefore, if this message has been received in error, please delete it without reading it. Your receipt of this message is not intended to waive any applicable privilege. Please do not disseminate this message without the permission of the author.</p>

                            <p>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</p>
                            </body>
                            </html>";
    $mailheader = "MIME-Version: 1.0".PHP_EOL;
    $mailheader .= 'Content-type: text/html; charset=iso-8859-1'.PHP_EOL;
    $mailheader  .= "From: checkmail@serendipity.rf.gd <checkmail@serendipity.rf.gd>\n";
    if(mail($to, $subject, $message, $mailheader))
        return true;
    return false;
}

/*
    *Installs serendipity by checkin the database existance
    *
    *On connection success, inserts the table into the database
    *
    *Successful installation leads to login page
*/

function install($dbhost, $dbuser, $dbpass, $dbname, $website, $adminemail, $adminpass){
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    $websiteUrl = isset($_SERVER['HTTPS'])?'https://':'http://'.$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER["REQUEST_URI"]));
        $db = array('DBHOST' => $dbhost, 'DBUSER' => $dbuser, 'DBPASS' => $dbpass, 'DBNAME' => $dbname);
        if($conn){
            if(make_tables($conn)){
                $adminemail = mysqli_real_escape_string($conn, $adminemail);
                $adminpass = mysqli_real_escape_string($conn, $adminpass);
                $website = mysqli_real_escape_string($conn, $website);
                
                $adminpass = md5($adminpass);
                $sql = "INSERT INTO se_users (user_login, user_pass, user_email, user_type) VALUES ('admin', '".$adminpass."', '".$adminemail."', 'administrator');";
                if(mysqli_query($conn, $sql)){
                    if(!check_server())
                        mailBody($adminemail, 0, 0, $conn);
                    if(write_ini_file($db, '/tmp/config.ini')){
                        mysqli_query($conn, "UPDATE se_meta SET primary_admin = '".$adminemail."', website_title = '".ucfirst(strtolower($website))."', website_url = '".$websiteUrl."' WHERE ID = 1");
                        $_SESSION['SUCCESS'] = 'Installation successful';
                        return true;
                    }else
                        return false;
                }
            }else
                return "No table";
        }
        else
            return "No connection";
    mysqli_close($conn);
}

/**
    *Write database configuration file
    *
    *Configuration ini file create at /tmp/folder of the hosting site with apssed parameters from thei nstlal function
    *
    *Returns false when file cannot be created
    *
    *Returns success when file created and saved
*/

function write_ini_file($assoc_arr, $path) { 
    $content = "";  
        foreach ($assoc_arr as $key=>$elem) { 
            if(is_array($elem)) 
            { 
                for($i=0;$i<count($elem);$i++) 
                { 
                    $content .= $key."[] = \"".$elem[$i]."\"\n"; 
                } 
            } 
            else if($elem=="") $content .= $key." = \n"; 
            else $content .= $key." = \"".$elem."\"\n"; 
        } 

    if (!$handle = fopen($path, 'w')) { 
        return false; 
    }

    $success = fwrite($handle, $content);
    fclose($handle); 

    return $success; 
}

/**
    *Checks whether the working server is localhost or on internet server
    *
    *Returns true when server is localhost
*/

function check_server(){
    if( in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ) ) || in_array( $_SERVER['HTTP_HOST'], array( 'localhost', '127.0.0.1' ) ) ) 
            return true;
    return false;
}

/*
    *Make tables by getting from database.sql
*/

function make_tables($conn){
    $filename = '../database.sql';
    // Temporary variable, used to store current query
    $templine = '';
    // Read in entire file
    $lines = file($filename);
    // Loop through each line
    foreach ($lines as $line)
    {
        // Skip it if it's a comment
        if (substr($line, 0, 2) == '--' || $line == '')
            continue;

        // Add this line to the current segment
        $templine .= $line;
        // If it has a semicolon at the end, it's the end of the query
        if (substr(trim($line), -1, 1) == ';')
        {
            // Perform the query
            if(mysqli_query($conn, $templine)){
            // Reset temp variable to empty
                $templine = '';
            }else
                return false;
        }
    }
    return true;
}


/**
    *GENERATE RANDOM PASSWORD
    *
    *Using alphabets, numbers and specical characters
    *
    *Generates 14-digit random password 
    *
    *5 small characters, 5 big characters, 4 numbers
*/

function generatePassword($numAlpha = 5, $numCaps = 5, $numNonAlpha = 4)
{
   $listAlpha = 'abcdefghijklmnopqrstuvwxyz';
   $listCaps = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $number = '0123456789';
   return str_shuffle(
      substr(str_shuffle($listAlpha),0,$numAlpha) .
       substr(str_shuffle($listCaps),0,$numCaps) .
      substr(str_shuffle($number),0,$numNonAlpha)
    );
}

/**
    *ADD VARIABLE TO URL
*/

function add_var_to_url($variable_name,$variable_value,$url_string){
		// first we will remove the var (if it exists)
		// test if url has variables (contains "?")
		if(strpos($url_string,"?")!==false){
			$start_pos = strpos($url_string,"?");
			$url_vars_strings = substr($url_string,$start_pos+1);
			$names_and_values = explode("&",$url_vars_strings);
			$url_string = substr($url_string,0,$start_pos);
			foreach($names_and_values as $value){
				list($var_name,$var_value)=explode("=",$value);
				if($var_name != $variable_name){
					if(strpos($url_string,"?")===false){
						$url_string.= "?";
					} else {
						$url_string.= "&";
					}
					$url_string.= $var_name."=".$var_value;
				}
			}
		} 
		// add variable name and variable value
		if(strpos($url_string,"?")===false){
			$url_string .= "?".$variable_name."=".$variable_value;
		} else {
			$url_string .= "&".$variable_name."=".$variable_value;
		}
		return $url_string;
	}

/**
    *
    *Message alerts for errors and success
    *
    *Used in login and logout alerts
*/

function messages(){
    $message = '';
    if(isset($_SESSION['ERROR']) && $_SESSION['ERROR'] != ''){
        $message = '<div class="alert-box danger">'.$_SESSION['ERROR'].'</div>';
        $_SESSION['ERROR'] = '';
    }
    if(isset($_SESSION['SUCCESS']) && $_SESSION['SUCCESS'] != ''){
        $message = '<div class="success">'.$_SESSION['SUCCESS'].'</div>';
        $_SESSION['SUCCESS'] = '';
    }
    echo "$message";
}

/**
    *Logout of the account
    *
    *Unsets authorized session
    *
    *Redirects to login page
*/

function logout(){
	unset($_SESSION['AUTHORIZED']);
    $_SESSION['SUCCESS'] = 'Logged out successfully';
    header('Location: login.php');
	exit();
}

function themeUrl($theme_name){
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT theme_applied FROM se_meta WHERE ID = 1"));
    $theme = $row['theme_applied'];
    mysqli_close($conn);
    if($theme == $theme_name)
        return true;
    return false;
}

function themeName(){
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT theme_applied FROM se_meta WHERE ID = 1"));
    $theme = $row['theme_applied'];
    mysqli_close($conn);
    return $theme;
}

function themeWrite($theme_name){
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    $theme_name = mysqli_real_escape_string($conn, $theme_name);
    mysqli_query($conn, "UPDATE se_meta SET theme_applied = '".$theme_name."' WHERE ID = 1");
    mysqli_close($conn);
}


?>