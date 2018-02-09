<?php
if(isset($_GET['tag_type']) && $_GET['tag_type'] == 'category')
    $current = "Category";
else
    $current = "Tag";
    require_once 'header.php';
?>
<div class = "cell">
    <h3>Add <?php echo $current; ?></h3>
            <?php echo messages(); ?>

</div>
<div class = "cell">
    
    <?php
        if(isset($_POST['category-add-button'])){
            GetDashboardData::insertCategory($_POST['category-name'], $_POST['slug'], $_POST['description'], $_POST['category-parent'], $_POST['tag-type']);           
            header("Location:".$_SERVER['REQUEST_URI']);
        }
    ?>
<div class = "grid-x grid-padding-x">
    <div class = "small-12 medium-6 large-6 cell">            
        <form action = "" method = "post">
            <div class = "grid-x grid-padding-x">
                    <div class = "small-12 medium-6 cell">
                        <label>Title</label>
                    </div>
                    <div class = "small-12 medium-6 cell">
                        <input type = "text" autocomplete = "off" placeholder="Enter Title" name = "category-name">
                    </div>
                </div>
                <input type = "hidden" value = "<?php echo $current; ?>" name = "tag-type">
                <div class = "grid-x grid-padding-x">
                    <div class = "small-12 medium-6 cell">
                        <label>Slug</label>
                    </div>
                    <div class = "small-12 medium-6 cell">
                        <input type = "text" autocomplete = "off" placeholder="Enter Slug" name = "slug">
                    </div>
                </div>
                <?php if($current == 'Category'){ ?>
                <div class = "grid-x grid-padding-x">
                    <div class = "small-12 medium-6 cell">
                        <label>Parent</label>
                    </div>
                    <div class = "small-12 medium-6 cell">
                        <select name = "category-parent">
                            <option>None</option>
                            <?php
                                $data = GetDashboardData::fetchCategory();
                                while($row = mysqli_fetch_assoc($data)){
                            ?>
                            <option><?php echo ucwords($row['cat_title']); ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <?php } ?>
                <div class = "grid-x grid-padding-x">
                    <div class = "small-12 medium-6 cell">
                        <label>Description</label>
                    </div>
                    <div class = "small-12 medium-6 cell">
                        <textarea rows = "5" name = "description" placeholder="Enter Description"></textarea>
                    </div>
                </div>
            
        <input type = "submit" name = "category-add-button" value = "Add <?php echo $current;?>" class = "button">

            </form>
        </div>
        <div class = "small-12 medium-6 cell">
            <?php if(isset($_GET['tag_type']) && $_GET['tag_type'] == 'category') {
            ?>
             <table class = "stack">
                        <tr>
                            <th><input type = "checkbox" class = "table-selector"></th>
                            <th><a href = "<?php echo $url;?>/taxonomy.php?tag_type=category&orderby=cat_title&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'asc') echo 'desc'; else echo 'asc';?>">
                        Title  
                        <?php 
                        if(isset($_GET['orderby']) && $_GET['orderby'] == 'cat_title' && isset($_GET['order']) && $_GET['order'] == 'asc')
                            echo '<i class = "fa fa-caret-up"></i>'; 
                        else if(isset($_GET['orderby']) && $_GET['orderby'] == 'cat_title') 
                            echo '<i class = "fa fa-caret-down"></i>';?>
                        </a></th>
                            <th><a href = "<?php echo $url;?>/taxonomy.php?tag_type=category&orderby=cat_description&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'asc')echo 'desc';else echo 'asc';?>">Description  <?php 
                            if(isset($_GET['orderby']) && $_GET['orderby'] == 'cat_description' && isset($_GET['order']) && $_GET['order'] == 'asc')
                                echo '<i class = "fa fa-caret-up"></i>';
                            else if(isset($_GET['orderby']) && $_GET['orderby'] == 'cat_description') 
                                echo '<i class = "fa fa-caret-down"></i>';?>
                            </a></th>
                            <th><a href = "<?php echo $url;?>/taxonomy.php?tag_type=category&orderby=cat_slug&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'asc')echo 'desc';else echo 'asc';?>">Slug  <?php 
                            if(isset($_GET['orderby']) && $_GET['orderby'] == 'cat_slug' && isset($_GET['order']) && $_GET['order'] == 'asc')
                                echo '<i class = "fa fa-caret-up"></i>';
                            else if(isset($_GET['orderby']) && $_GET['orderby'] == 'cat_slug') 
                                echo '<i class = "fa fa-caret-down"></i>';?>
                            </a></th>
                            <th><a href = "<?php echo $url;?>/taxonomy.php?tag_type=category&orderby=user_email&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'asc')echo 'desc';else echo 'asc';?>">Count  <?php 
                            if(isset($_GET['orderby']) && $_GET['orderby'] == 'user_email' && isset($_GET['order']) && $_GET['order'] == 'asc')
                                echo '<i class = "fa fa-caret-up"></i>';
                            else if(isset($_GET['orderby']) && $_GET['orderby'] == 'user_email') 
                                echo '<i class = "fa fa-caret-down"></i>';?>
                            </a></th>
                        </tr>
                 
                    <?php
                        $result = GetDashboardData::fetchCategory();
                        while($row = mysqli_fetch_assoc($result)){
                    ?>
                 <tr>
                     
                    <td><input type = "checkbox" name = 'expand[]' value = "<?php echo $row['ID'];?>" class = "table-selector"></td>
                    <td data-label = "Title"><?php echo $row['cat_title'];?> <?php /*<div><a id  "edit-user-details">Edit</a> <?php if($row['ID'] != $_SESSION['ID']) {?><a id = "delete-user">Delete</a><?php } </div>*/ ?><a class = "show-hidden-details"><i class = "fa fa-caret-down"></i></a></td>
                    <td data-label = "Description"><?php echo $row['cat_description'];?></td>
                    <td data-label = "Slug"><?php echo ucfirst($row['cat_slug']);?></td>
                     <?php 
                            if(!empty($row['posts_id']))
                            $counter = count(unserialize($row['posts_id']));?>
                    <td data-label = "Count"><?php if(!empty($row['posts_id'])) echo $counter; else echo '0';?></td>
                </tr>
                 <?php
                        }
                ?>
            </table>
            <?php
                }else{
            ?>
            <table class = "stack">
                        <tr>
                            <th><input type = "checkbox" class = "table-selector"></th>
                            <th><a href = "<?php echo $url;?>/taxonomy.php?orderby=tag_title&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'asc') echo 'desc'; else echo 'asc';?>">
                        Title  
                        <?php 
                        if(isset($_GET['orderby']) && $_GET['orderby'] == 'tag_title' && isset($_GET['order']) && $_GET['order'] == 'asc')
                            echo '<i class = "fa fa-caret-up"></i>'; 
                        else if(isset($_GET['orderby']) && $_GET['orderby'] == 'tag_title') 
                            echo '<i class = "fa fa-caret-down"></i>';?>
                        </a></th>
                            <th><a href = "<?php echo $url;?>/taxonomy.php?orderby=tag_description&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'asc')echo 'desc';else echo 'asc';?>">Description  <?php 
                            if(isset($_GET['orderby']) && $_GET['orderby'] == 'tag_description' && isset($_GET['order']) && $_GET['order'] == 'asc')
                                echo '<i class = "fa fa-caret-up"></i>';
                            else if(isset($_GET['orderby']) && $_GET['orderby'] == 'tag_description') 
                                echo '<i class = "fa fa-caret-down"></i>';?>
                            </a></th>
                            <th><a href = "<?php echo $url;?>/taxonomy.php?orderby=tag_slug&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'asc')echo 'desc';else echo 'asc';?>">Slug  <?php 
                            if(isset($_GET['orderby']) && $_GET['orderby'] == 'tag_slug' && isset($_GET['order']) && $_GET['order'] == 'asc')
                                echo '<i class = "fa fa-caret-up"></i>';
                            else if(isset($_GET['orderby']) && $_GET['orderby'] == 'tag_slug') 
                                echo '<i class = "fa fa-caret-down"></i>';?>
                            </a></th>
                            <th><a href = "<?php echo $url;?>/taxonomy.php?orderby=tag_count&order=<?php if(isset($_GET['order']) && $_GET['order'] == 'asc')echo 'desc';else echo 'asc';?>">Count  <?php 
                            if(isset($_GET['orderby']) && $_GET['orderby'] == 'tag_count' && isset($_GET['order']) && $_GET['order'] == 'asc')
                                echo '<i class = "fa fa-caret-up"></i>';
                            else if(isset($_GET['orderby']) && $_GET['orderby'] == 'tag_count') 
                                echo '<i class = "fa fa-caret-down"></i>';?>
                            </a></th>
                        </tr>
                
                    <?php
                        $result = GetDashboardData::fetchTag();
                        while($row = mysqli_fetch_assoc($result)){
                    ?>
                <tr>
                    
                    <td><input type = "checkbox" name = 'expand[]' value = "<?php echo $row['ID'];?>" class = "table-selector"></td>
                    <td data-label = "Title"><?php echo $row['tag_title'];?> <?php /*<div><a id  "edit-user-details">Edit</a> <?php if($row['ID'] != $_SESSION['ID']) {?><a id = "delete-user">Delete</a><?php } </div>*/ ?><a class = "show-hidden-details"><i class = "fa fa-caret-down"></i></a></td>
                    <td data-label = "Description"><?php echo $row['tag_description'];?></td>
                    <td data-label = "Slug"><?php echo ucfirst($row['tag_slug']);?></td>
                    <?php 
                            if(!empty($row['posts_id']))
                            $counter = count(unserialize($row['posts_id']));?>
                    <td data-label = "Count"><?php if(!empty($row['posts_id'])) echo $counter; else echo '0';?></td>
                </tr>
                <?php
                        }
                ?>
            </table>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
    require_once 'footer.php';
?>