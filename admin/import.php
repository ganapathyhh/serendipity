<?php
$current = "Import";
require_once 'header.php';
?>
<div class = "cell">
    <h3><?php echo $current; ?></h3>
</div>
<div class = "cell">
<h6>Choose what to import</h6>
    <form action  = "" method = "post">
        <div class = "cell">       
            Import file <input type = "file" name = "import-file" class = "inputfile">
            <input type = "submit" value = "Import everything" name = "import-button-all" class = 'button primary'>
            <p class = "help-text">Import all the contents present in the file. Upload file here</p> 
        </div>
    </form>
    <h6>Custom Import</h6>
    <p class = "help-text">Import only certain contents from the database by using the checkboxes below.</p>
    <form action  = "" method = "post">
        Import file <input type = "file" name = "import-file" class = "inputfile">
        <div class = "cell">        
            <input type = "checkbox" value = "post" name = "import[]"> Posts
        </div>
        <div class = "cell">        
            <input type = "checkbox" value = "page" name = "import[]"> Pages
        </div>
        <div class = "cell">        
            <input type = "checkbox" value = "event" name = "import[]"> Events
        </div>
        <div class = "cell">        
            <input type = "checkbox" value = "user" name = "import[]"> Users
        </div>
        <div class = "cell">        
            <input type = "checkbox" value = "media" name = "import[]"> Media
        </div>
        <div class = "cell">       
            <input type = "submit" value = "Import" name = "import-button" class = 'button primary'>
        </div>
    </form>

</div>
<?php
/*
if(file_exists('export.xml')){
    $xmlData = simplexml_load_file('export.xml');
    $count = 0;
    foreach($xmlData->children() as $xmlNode){
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        $result = mysqli_query($conn, "SELECT ID FROM se_users WHERE user_login ='".$xmlNode->author."'");
        if(mysqli_num_rows($result) != 1){
            $result = mysqli_query($conn, "SELECT ID FROM se_users WHERE user_type = 'administrator'");
        }
        $row = mysqli_fetch_assoc($result);
        $query = "INSERT INTO se_pages(page_title, page_content, page_template, page_meta, page_added, page_visible, page_visible_remove, page_status, author_ID) VALUES('".$xmlNode->title."', '".$xmlNode->content."', '".$xmlNode->template."', '".$xmlNode->meta."','".$xmlNode->adddate."', '".$xmlNode->visdate."', '".$xmlNode->remdate."', '".$xmlNode->status."', ".$row['ID'].")";
        if(mysqli_query($conn, $query))
            ++$count;
        else{
            echo 'oops gone wrong'.mysqli_error($conn);
            break;
        }
        mysqli_close($conn);
    }
    if($count == count($xmlData->children()))
        echo 'success import';
}
else
    die('error');*/


require_once 'footer.php';
?>