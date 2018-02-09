<?php
$current = "Export";
require_once 'header.php';
require_once 'includes/pageInsert.php';
?>
<div class = "cell">
    <h3><?php echo $current; ?></h3>
</div>
<div class = "cell">
    <?php 
    if (isset($_POST['export-button-all'])){
        
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>';
        $xml .= "\n <data>";

        // Create the rest of your XML Data...

        $xml .= "\n </data>";
        downloader($xml, 'yourFile.xml', 'application/xml');
    }
    ?>
    <h6>Choose what to export</h6>
    <form action  = "" method = "post">
        <div class = "cell">       
            <input type = "submit" value = "Export everything" name = "export-button-all" class = 'button primary'>
            <p class = "help-text">Export all the contents present in the website. Once the file is generated, you can download the file to your system and import to anoter site running serendipity easily.</p>
        </div>
    </form>
    <h6>Custom Export</h6>
    <p class = "help-text">Export only certain contents from the database by using the checkboxes below.</p>
    <form action  = "" method = "post">

        <div class = "cell">        
            <input type = "checkbox" value = "post" name = "export[]"> Posts
        </div>
        <div class = "cell">        
            <input type = "checkbox" value = "page" name = "export[]"> Pages
        </div>
        <div class = "cell">        
            <input type = "checkbox" value = "event" name = "export[]"> Events
        </div>
        <div class = "cell">        
            <input type = "checkbox" value = "user" name = "export[]"> Users
        </div>
        <div class = "cell">        
            <input type = "checkbox" value = "media" name = "export[]"> Media
        </div>
        <div class = "cell">       
            <input type = "submit" value = "Export" name = "export-button" class = 'button primary'>
        </div>
    </form>
</div>
<?php
require_once 'footer.php';
?>