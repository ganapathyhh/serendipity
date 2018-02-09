<?php

/**
*Getting data from database MYSQL
*
*Static functions used to obtain data from the database without class objects
*/
class GetDashboardData{
    
    /**
    *Get users from the table se_users
    *
    *Selects the posts table too to select the posts made by the users
    *
    *Using LEFT Join both the results are added and obtained
    *
    *The results are passed through return statement to all_users.php
    */
    
    public static function getUsers($orderby = '', $order = ''){
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        $sql = "SELECT * FROM se_users users LEFT JOIN (SELECT author_ID, COUNT(*) AS pages_total FROM se_pages) pages ON users.ID = pages.author_ID LIMIT 50";
        if(!empty($orderby)){
            $sql .= " ORDER BY users.".$orderby." ".$order." ";
        }
        $result =  mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }
    
    /**
    *Insert page / post into table
    *
    *Gets the ID and then uses ID for updation of the field
    */
    
    public function insertPaPo($type, $userId){
        if($type == 'page'){
            $val = "?page=";
        }else if($type == 'post'){
            $val = "?p=";
        }
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        $query = "INSERT INTO se_pages (page_title, page_content, page_template, page_meta, page_status, author_ID) VALUES ('Auto Draft', '', '".$type."', '', 'auto-draft', ".$userId.")";
        mysqli_query($conn, $query);
        $papoId = mysqli_insert_id($conn);
        $query = "UPDATE se_pages SET page_url = '".WEBSITE_URL.$val.$papoId."' WHERE ID = ".$papoId.";";
        
        mysqli_query($conn, $query);
        mysqli_close($conn);
        return $papoId;
    }
    
    /**
        *ADD USERS TO DATABASE
        *
        *If user with the same user name exists then error is shown 
        *
        *Otherwise the user will be added into the table
    */
    
    public static function addUsers($email, $type, $username, $password){
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if(empty($email) || (empty($type) || $type == '-- USER TYPE --') || empty($username)){
            $_SESSION["ERROR"] = 'User not added. Form fields were empty.';
        }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['ERROR'] = 'Email is invalid';
        }else{
            
            /**
            *Make tthe variables as mysli real escape string to make it free from possible security attacks
            *
            *These data are passed to the database through insert statement
            */
            
            $email = mysqli_real_escape_string($conn, $email);
            $username = mysqli_real_escape_string($conn, $username);
            $password = mysqli_real_escape_string($conn, $password);
            $type = mysqli_real_escape_string($conn, $type);
            
            /**
            *Check for user existance in the table
            *
            *Select command is used to perform the checking against the username and email address provided
            *
            *If the user exists then an error is displayed to the user saying that the user cannot be added or already exists in the table
            */

            $sql = "SELECT * FROM se_users WHERE user_email = '".$email."' OR user_login = '".$username."'";
            if(mysqli_num_rows(mysqli_query($conn, $sql)) == 1){
                $_SESSION['ERROR'] = 'User already exists or cannot be added now.';
                return false;
            }
            else{
                
                /**
                *Insert the data into the table
                *
                *After checking for existance the user details are entered into the database
                */
                
                $sql1 = "INSERT INTO se_users(user_login, user_email, user_pass, user_type) VALUES ('".$username."', '".$email."', '".$password."', '".$type."')";
                if(mysqli_query($conn, $sql1)){
                    if(!check_server())
                        mailBody($email, 1, $password);
                    $_SESSION['SUCCESS'] = 'User added successfully';
                    return true;
                }

            }
        }
    }
    
    /**
    *Change role for user
    *
    *Using the details obtained from the checkbox and form submitted, the role of the users will be changed in bulk
    */
    
    public static function changeRole($checkedBoxes, $role){
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if($role != 'Change role'){ 
            foreach($checkedBoxes as $checkes){
                mysqli_query($conn, "UPDATE se_users SET user_type = '".strtolower($role)."' WHERE (ID = ".$checkes." AND ID NOT IN ( ".$_SESSION['ID']."))");
            }
            $count = mysqli_affected_rows($conn);
            if($count > 0)
                $_SESSION['SUCCESS'] = $count." row(s) affected. ".$count." user(s) role changed to ".$role;  
            else
                $_SESSION['ERROR'] ="0 rows affected.";
        }
        mysqli_close($conn);
    }

    /**
    *DeleteUser using the checkedboxes and action selected
    *
    *Shows success message on deletion
    */
    
    public static function deleteUser($checkedBoxes, $action){
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if($action != 'Action'){
            foreach($checkedBoxes as $checked){
                mysqli_query($conn, "DELETE FROM se_users WHERE (ID = ".$checked." AND ID NOT IN (".$_SESSION['ID']."))");
            }
            $count = mysqli_affected_rows($conn);
            if($count > 0)
                $_SESSION['SUCCESS'] = $count." row(s) removed.";
            else
                $_SESSION['ERROR'] = '0 rows removed.';
        }
        mysqli_close($conn);
    }
    
    /***
    *Inserts Post, Page, Event
    *
    *
    */
    
    public static function insertPaPoEv($pageTitle, $pageContent, $pageMeta = '', $postType, $pageStatus, $pagePublish, $pageRemove = '', $pageContent, $categories, $publisher = ''){
        
        /**
        *Get Page title
        *
        *Get the page content
        *
        *
        *Get post type Page, Post or Event
        *
        *Generate slug
        *
        *Get publish status 
        *
        *Get publish time
        *
        *Get the removal of publish for events only
        *
        *Tweak page publish according to time provided by user for inserting into database    
        */
        $published = '';

        $slug = str_replace(" ", "-", $pageTitle);

        if($pagePublish == 'Immediately'){
            $pagePublish = date('Y-m-d H:i:s', time());
        }else{
            $date = $pagePublish.":".(time()%60);
            $newFormat = DateTime::createFromFormat('M-d-Y @ H : i:s', $date);
            $pagePublish =  $newFormat->format('Y-m-d H:i:s');
        }
        
       if($postType == 'Event'){
            if($pageRemove == 'After a Day'){
                $pageRemove = date('Y-m-d H:i:s', strtotime("+1 day", time()));
            }else{
                $date = $pageRemove.":".(time()%60);
                $newFormat = DateTime::createFromFormat('M-d-Y @ H : i:s', $date);
                $pageRemove =  $newFormat->format('Y-m-d H:i:s');
            }
        }
        /**
        *Inserting into table based on the button clicked
        *
        *isset used to obtain the name of the button clicked
        *
        *Published, drafted, pending for review are the parameters present during this session
        */

        if($publisher == 'publisher'){
            if($pageStatus != 'Pending Review' && $pageStatus == 'Draft')
                $pageStatus = 'published';
            else 
                $pageStatus = 'pending-review';
            $published =  'Published';
        }
        else if($publisher == 'save-draft'){
            if($pageStatus != 'Pending Review' && $pageStatus == 'Draft')
                $pageStatus = 'drafted';
            else 
                $pageStatus = 'pending-review';
            $published =  'Drafted';
        }

        /**
        *Establishing database connection and inserting the values into the database
        *
        *The insertioon involves renaming the conflicting slug
        *
        *Successful insertion makes success message
        */

        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        $done = false;

        /**
        *If the post type is post then the category is obtained
        *
        *Get the category ids
        *
        *These ids are inserted into the post during insertion
        */
        if($postType == 'Post'){
            $cat_sel = '(';
            for($i = 0; $i < count($categories); $i++){
                $cat_sel .= "'".$categories[$i]."'";
                if($i != count($categories) - 1)
                    $cat_sel .= ', ';
            }
            $cat_sel .= ')';
            $query = "SELECT ID, posts_id FROM se_category WHERE cat_title IN ".$cat_sel." GROUP BY ID";
            $cat_id_fetch = array();
            $res_id_fetch = mysqli_query($conn, $query);
            $posts_id_fetch = array();
            while($row = mysqli_fetch_assoc($res_id_fetch)){
                array_push($cat_id_fetch, $row['ID']);
                array_push($posts_id_fetch, $row['posts_id']);
            }
            $cat_id_fetch = serialize($cat_id_fetch);

        }
        $result = mysqli_query($conn, "SELECT COUNT(page_url) as total FROM se_pages WHERE page_url LIKE '".$slug."%'");
        $row = mysqli_fetch_assoc($result);
        if($row['total'] >= 1)
            $slug = $slug.'-'.($row['total'] + 1);
        if($postType == 'Post'){
                if(mysqli_query($conn, "INSERT INTO se_pages (page_title, page_meta, page_content, page_visible, page_url, page_status, author_ID, page_template, cat_ID) VALUES ('".$pageTitle."', '".$pageMeta."', '".$pageContent."', '".$pagePublish."', '".$slug."' ,'".$pageStatus."', ".$_SESSION['ID'].", '".$postType."', '".$cat_id_fetch."')"))
                    $done = true;
                $cat_id_fetch = unserialize($cat_id_fetch);
                $inserted_id = mysqli_insert_id($conn);
                for($i = 0; $i < count($posts_id_fetch); $i++){
                    $posts_id_fetch[$i] = unserialize($posts_id_fetch[$i]);
                    if(empty($posts_id_fetch[$i]))
                        $posts_id_fetch[$i] =  array();
                    array_push($posts_id_fetch[$i], $inserted_id);
                    $posts_id_fetch[$i] = serialize($posts_id_fetch[$i]);
                    $update_query = "UPDATE se_category SET posts_id = '".$posts_id_fetch[$i]."' WHERE ID = ".intval($cat_id_fetch[$i]);
                    mysqli_query($conn, $update_query);
                }
            }else if($postType == 'Event'){
                $insertQuery = "INSERT INTO se_pages (page_title, page_content, page_visible, page_status, author_ID, page_template, page_url) VALUES('".$pageTitle."', '".$pageContent."', '".$pagePublish."', '".$pageStatus."', ".$_SESSION['ID'].", '".$postType."', '".$slug."')";
                if(mysqli_query($conn, $insertQuery)){
                    $inserted_id = mysqli_insert_id($conn);
                    if(mysqli_query($conn, "INSERT INTO se_events(page_visible_remove, event_id) VALUES('".$pageRemove."', ".$inserted_id.")"))
                        $done = true;
                }
            }else{
            $insertQuery = "INSERT INTO se_pages (page_title, page_meta, page_content, page_visible, page_url, page_status, author_ID, page_template) VALUES ('".$pageTitle."', '".$pageMeta."', '".$pageContent."', '".$pagePublish."', '".$slug."' ,'".$pageStatus."', ".$_SESSION['ID'].", '".$postType."')";
                if(mysqli_query($conn, $insertQuery))
                    $done = true;
            }
        if($done){
            $_SESSION['SUCCESS'] = $postType.' added successfully';
        }
        else{
            $_SESSION['ERROR'] = 'Unexpected error occurred in insertion of '.$postType;
        }
        mysqli_close($conn);
    }
    
    /**
    *Inserts category into database
    */
    
    public static function insertCategory($title, $slug, $description, $parent = '', $type){
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        $slug = str_replace(" ", "-", strtolower($slug));
        if($title == '' || $slug == '' || $description == ''){
            $_SESSION['ERROR'] = "Don't leave the fields empty";
            return false;
        }
        if($type == 'Category'){
            $p = false;
            if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM se_category WHERE cat_title = '".ucwords($title)."'")) >= 1){
                $_SESSION['ERROR'] = 'Category already exists';
                return false;
            }else{
                if($parent != 'None'){
                    $res = mysqli_query($conn, "SELECT * FROM se_category WHERE cat_title = '".$parent."'");
                    $p = true;
                    $row = mysqli_fetch_assoc($res);
                }
                $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(cat_slug) as TOTAL FROM se_category WHERE cat_slug LIKE '".$slug."%'"));
                if($count['TOTAL'] >= 1)
                    $slug .= '-'.($count['TOTAL'] + 1);
                $query = "INSERT INTO se_category(cat_title, cat_description, cat_slug";
                if($p){
                    $query .= ", cat_parent";
                }
                $query .= ") VALUES ('".ucwords($title)."', '".$description."', '".$slug."'";
                if($p){
                    $query .= ", ".$row['ID'];
                }
                $query .= ")";
            }
        }else if($type == "Tag"){
            $p = false;
            if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM se_tags WHERE tag_title = '".ucwords($title)."'")) >= 1){
                $_SESSION['ERROR'] = 'Tag already exists';
                return false;
            }else{
                $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(tag_slug) as TOTAL FROM se_tags WHERE tag_slug LIKE '".$slug."%'"));
                if($count['TOTAL'] >= 1)
                    $slug .= '-'.($count['TOTAL'] + 1);
                $query = "INSERT INTO se_tags(tag_title, tag_description, tag_slug) VALUES ('".ucwords($title)."', '".$description."', '".$slug."')";        
            }
        }
        if(mysqli_query($conn, $query))
            $_SESSION['SUCCESS'] = $type." added successfully";
        else
            $_SESSION['ERROR'] = "Error in adding ".$type.". Please try again.";
        mysqli_close($conn);
        return false;
    }
    
    /**
    *Fetch category from the category table
    *
    *Return the results as the fetch array
    */
    
    public static function fetchCategory(){
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);                     
        $res = mysqli_query($conn, "SELECT * FROM se_category ORDER BY cat_title ASC");
        mysqli_close($conn);
        return $res;
    }
    
    public static function fetchTag(){
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);                     
        $res = mysqli_query($conn, "SELECT * FROM se_tags ORDER BY tag_title ASC");
        mysqli_close($conn);
        return $res;
    }
    
    public static function saveSettings($siteTitle, $siteDescription, $siteAddr, $emailAddr, $metaData, $hits, $likes, $dislikes){
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if(mysqli_query($conn, "UPDATE se_meta SET website_title = '".$siteTitle."', website_description = '".$siteDescription."', website_url = '".$siteAddr."', primary_admin = '".$emailAddr."', website_meta = '".$metaData."', page_hit = ".$hits.", page_like = ".$likes.", page_dislike = ".$dislikes." WHERE ID = 1"))
            $_SESSION['SUCCESS'] = "Settings saved successfully";
        else
            $_SESSION['ERROR'] = "Error occurred while saving settings";
        mysqli_close($conn);
    }
}
?>