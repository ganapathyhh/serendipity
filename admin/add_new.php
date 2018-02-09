<?php
if(isset($_GET['post_type']) && $_GET['post_type'] == 'page')
    $current = "Add Page";
else if(isset($_GET['post_type']) && $_GET['post_type'] == 'event')
    $current = 'Add Event';
else 
    $current = "Add Post";
require_once 'header.php';
//$data = new GetDashboardData();
//$id = $data->insertPaPo((isset($_GET['post_type']) && $_GET['post_type'] == 'page')?'page':'post', $_SESSION['ID']);
$id = '';
?>
<div class = "cell">
    
    <h3><?php echo $current;?></h3>
    
</div>
<div class = "cell">
        <?php echo messages(); ?>

    <?php
        if(isset($_POST['publisher'])){
            GetDashboardData::insertPaPoEv($_POST['title'], $_POST['page-content'], ($_POST['post-type'] != 'Event')?$_POST['metadata']:'', $_POST['post-type'], $_POST['publish-status-field'], $_POST['publish-time-field'], ($_POST['post-type'] == 'Event')?$_POST['publish-remove-time-field']:'', $_POST['page-content'], ($_POST['post-type'] == 'Post')?$_POST['category']:'', 'publisher');
            header('Location:'.$_SERVER['REQUEST_URI']);

        }
        if(isset($_POST['save-draft'])){
            GetDashboardData::insertPaPoEv($_POST['title'], $_POST['page-content'], ($_POST['post-type'] != 'Event')?$_POST['metadata']:'', $_POST['post-type'], $_POST['publish-status-field'], $_POST['publish-time-field'], ($_POST['post-type'] == 'Event')?$_POST['publish-remove-time-field']:'', $_POST['page-content'], ($_POST['post-type'] == 'Post')?$_POST['category']:'', 'save-draft');
            header('Location:'.$_SERVER['REQUEST_URI']);
        }
    ?>
    <form method = "post" action = "" id = "post_or_page_form" name = "post_or_page_form">
        <div class = "grid-x grid-padding-x">
            <div class = "large-9 cell">
                <div class = "cell">
                    <input type="text" name = "title" placeholder = "Enter <?php if(isset($_GET['post_type']) && $_GET['post_type'] == 'page') echo 'Page '; else if(isset($_GET['post_type']) && $_GET['post_type'] == 'event') echo 'Event'; else echo 'Post'; ?> Title" autocomplete = "off">
                </div>
                <input type = 'hidden'  name = 'post-type' value = "<?php if(isset($_GET['post_type']) && $_GET['post_type'] == 'page') echo 'Page '; else if(isset($_GET['post_type']) && $_GET['post_type'] == 'event') echo 'Event'; else echo 'Post'; ?>">
                
                
                <?php /*<div class = "cell editor-container">
                    <?php require_once 'toolbar.php'; ?>
                    <iframe id = "htmlEditorIframe" name = "htmlEditor"  width = "auto"  <?php if(isset($_GET['page_id'])) echo 'src = ""';?>>Hello world</iframe>
                    <div class = "editor-status-bar" unselectable = "on"><span id = "editor-word-count">Words Count : 0</span></div>
                </div>*/ ?>
                
                <textarea id = "mytextarea" ></textarea>
                <input type  = "hidden" id = "source-code-editor" name = 'page-content'>
                <span style = "padding: 2em"></span>
                <div class = "cell">
                    
                    <textarea name = "metadata" placeholder = "Enter <?php if(isset($_GET['post_type']) && $_GET['post_type'] == 'page') echo 'Page '; else echo 'Post'; ?> Meta Data" rows="3"></textarea>
                    
                    <input type = "checkbox" id = "custom-meta" value = "custom-meta" name = "custom-meta"> Insert custom meta for the <?php echo explode(' ', $current)[1]; ?>
                </div>
                
                
            </div>
            <div class = "large-3 cell">
                <div class = "part-container" style = "margin-bottom: 20px;">
                <div id = "publishDiv" class = "post-right-container clearfix">
                    <div class = "post-right-title">
                        <span>Publish</span>
                        <span class = "float-right post-right-button">
                            <i class = "fa fa-caret-down"></i>
                        </span>
                    </div>
                    <div class = "inner-container">
                        <div class = "save-publish clearfix">
                            <input type = "submit" id="page-publish-submit" class = "button hollow float-left" value = "Save Draft" name = "save-draft">
                           <?php 
                            if($id != ''){ ?> 
                                <a class = "button hollow float-right" href = "<?php echo WEBSITE_URL; ?>/?preview=true" >Preview</a>
                            <?php
                            }
                            ?>
                        </div>
                        
                        <?php
                        /***
                        *Status of the post
                        *
                        *The post can be saved as a draft or saved for pending review
                        *
                        *Based on the categorisation the post will be prioritised 
                        *
                        *This is used as explicit draft saving feature
                        */
                        ?>
                        
                        <div class = "status-getter">
                            <span>Status : <strong><span name = "page-status" id = "page-status-span">Draft</span></strong></span>
                            <a id = "status-edit" >Edit</a>
                            <input type = "hidden" id = "publish-status-field" value = "Draft" name = "publish-status-field">
                            <fieldset  id  = "select-status"  style = "display: none;">
                                <select name = "page-status" id = "page-status-select">
                                    <option value = "Draft">Draft</option>
                                    <option value = "Pending Review">Pending Review</option>
                                </select>
                                <a class = 'button hollow' id = "status-getter-ok-button" >Ok</a>
                                <a class = "button hollow" id = "status-getter-cancel-button">Cancel</a>
                            </fieldset>
                        </div>
                        
                        <?php
                        /**
                        *Get the date for scheduling the posts
                        *
                        *If the selection is immediate then the post will be published immediately
                        *
                        *Else the date will be obtained from the server and the date will be used based upon the user input for scheduling
                        *
                        */
                        ?>
                        
                        <div class = "publish-getter">
                            <span>Publish : <strong><span name = "page-publish" id = "page-publish-span">Immediately</span></strong></span>
                            <input type = "hidden" name = "publish-time-field" id = "publish-time-field" value = "Immediately">
                            <a id = "publish-edit" >Edit</a>
                            <div  id  = "publish-status"  style = "display: none;">
                                <?php 
                                    $get_current_date = date('Y-M-d-H-i', ceil($_SERVER['REQUEST_TIME'] / 60) * 60); 
                                    $get_current_date_array = explode("-", $get_current_date);
                                ?>
                                <select id = "month-of-calendar" style = "display: inline; width: 55px; font-size: 0.8em; font-size: 1em; height: 30px; padding-top: 0; padding-bottom: 0; padding-right: 20px; padding-left: 0;">
                                    <option value = "Jan" <?php if($get_current_date_array[1] == 'Jan') echo 'selected';?>>Jan</option>
                                    <option value = "Feb" <?php if($get_current_date_array[1] == 'Feb') echo 'selected';?>>Feb</option>
                                    <option value = "Mar" <?php if($get_current_date_array[1] == 'Mar') echo 'selected';?>>Mar</option>
                                    <option value = "Apr" <?php if($get_current_date_array[1] == 'Apr') echo 'selected';?>>Apr</option>
                                    <option value = "Jun" <?php if($get_current_date_array[1] == 'Jun') echo 'selected';?>>Jun</option>
                                    <option value = "Jul" <?php if($get_current_date_array[1] == 'Jul') echo 'selected';?>>Jul</option>
                                    <option value = "Aug" <?php if($get_current_date_array[1] == 'Aug') echo 'selected';?>>Aug</option>
                                    <option value = "Sep" <?php if($get_current_date_array[1] == 'Sep') echo 'selected';?>>Sep</option>
                                    <option value = "Oct" <?php if($get_current_date_array[1] == 'Oct') echo 'selected';?>>Oct</option>
                                    <option value = "Nov" <?php if($get_current_date_array[1] == 'Nov') echo 'selected';?>>Nov</option>
                                    <option value = "Dec" <?php if($get_current_date_array[1] == 'Dec') echo 'selected';?>>Dec</option>
                                </select>
                                <input id = "day-of-calendar" type = "text" maxlength="2" placeholder = "DD" style = "display:inline; font-size: 0.8em; height: 30px; width:30px;" max = "31" min = "1" value = "<?php echo $get_current_date_array[2];?>">
                                <input id = "year-of-calendar" type = "text" maxlength="4" placeholder = "YYYY" style = "display:inline; font-size: 0.8em; height: 30px; width:42px;" max = "31" min = "1" value = "<?php echo $get_current_date_array[0];?>"><span>@</span>
                                <input id = "hour-of-calendar" type = "text" maxlength="2" placeholder = "HH" style = "display:inline; font-size: 0.8em; height: 30px; width:30px;" max = "31" min = "1" value = "<?php echo $get_current_date_array[3];?>"><span>:</span>
                                <input id = "min-of-calendar" type = "text" maxlength="2" placeholder = "MM" style = "display:inline; font-size: 0.8em; height: 30px; width:30px;" max = "31" min = "1" value = "<?php echo $get_current_date_array[4];?>">
                                
                                
                                <a class = "button hollow" id = "publish-edit-ok" >Ok</a>
                                <a class = "button hollow" id = "publish-edit-cancel" >Cancel</a>
                            </div>
                        </div>
                        <?php
                            if($current == 'Add Event'){
                        ?>
                            <div class = "publish-getter">
                            <span>Close event : <strong><span name = "page-remove-publish" id = "page-publish-remove-span">After a Day</span></strong></span>
                            <input type = "hidden" name = "publish-remove-time-field" id = "publish-remove-time-field" value = "After a Day">
                            <a id = "publish-remove-edit" >Edit</a>
                            <div  id  = "publish-remove-status"  style = "display: none;">
                                <?php 
                                    $get_current_date = date('Y-M-d-H-i', strtotime("+1 day", ceil($_SERVER['REQUEST_TIME'] / 60) * 60)); 
                                    $get_current_date_array = explode("-", $get_current_date);
                                ?>
                                <select id = "month-of-calendar-2" style = "display: inline; width: 55px; font-size: 0.8em; font-size: 1em; height: 30px; padding-top: 0; padding-bottom: 0; padding-right: 20px; padding-left: 0;">
                                    <option value = "Jan" <?php if($get_current_date_array[1] == 'Jan') echo 'selected';?>>Jan</option>
                                    <option value = "Feb" <?php if($get_current_date_array[1] == 'Feb') echo 'selected';?>>Feb</option>
                                    <option value = "Mar" <?php if($get_current_date_array[1] == 'Mar') echo 'selected';?>>Mar</option>
                                    <option value = "Apr" <?php if($get_current_date_array[1] == 'Apr') echo 'selected';?>>Apr</option>
                                    <option value = "Jun" <?php if($get_current_date_array[1] == 'Jun') echo 'selected';?>>Jun</option>
                                    <option value = "Jul" <?php if($get_current_date_array[1] == 'Jul') echo 'selected';?>>Jul</option>
                                    <option value = "Aug" <?php if($get_current_date_array[1] == 'Aug') echo 'selected';?>>Aug</option>
                                    <option value = "Sep" <?php if($get_current_date_array[1] == 'Sep') echo 'selected';?>>Sep</option>
                                    <option value = "Oct" <?php if($get_current_date_array[1] == 'Oct') echo 'selected';?>>Oct</option>
                                    <option value = "Nov" <?php if($get_current_date_array[1] == 'Nov') echo 'selected';?>>Nov</option>
                                    <option value = "Dec" <?php if($get_current_date_array[1] == 'Dec') echo 'selected';?>>Dec</option>
                                </select>
                                <input id = "day-of-calendar-2" type = "text" maxlength="2" placeholder = "DD" style = "display:inline; font-size: 0.8em; height: 30px; width:30px;" max = "31" min = "1" value = "<?php echo $get_current_date_array[2];?>">
                                <input id = "year-of-calendar-2" type = "text" maxlength="4" placeholder = "YYYY" style = "display:inline; font-size: 0.8em; height: 30px; width:42px;" max = "31" min = "1" value = "<?php echo $get_current_date_array[0];?>"><span>@</span>
                                <input id = "hour-of-calendar-2" type = "text" maxlength="2" placeholder = "HH" style = "display:inline; font-size: 0.8em; height: 30px; width:30px;" max = "31" min = "1" value = "<?php echo $get_current_date_array[3];?>"><span>:</span>
                                <input id = "min-of-calendar-2" type = "text" maxlength="2" placeholder = "MM" style = "display:inline; font-size: 0.8em; height: 30px; width:30px;" max = "31" min = "1" value = "<?php echo $get_current_date_array[4];?>">
                                
                                
                                <a class = "button hollow" id = "publish-remove-edit-ok" >Ok</a>
                                <a class = "button hollow" id = "publish-remove-edit-cancel" >Cancel</a>
                            </div>
                        </div>
                        <?php } ?>
                        <div class = "schedule-container">
                            <button class = "button" id = "publish-button" name = "publisher">Publish/Schedule</button>
                        </div>
                    </div>
                </div>
                </div>
                <?php if($current == 'Add Post'){ ?>
                    <div class = "part-container" style = "margin-bottom: 20px;">
                        <div id = "tagDiv" class = "post-right-container clearfix">

                        <div class = "post-right-title">
                            <span>Tags</span>
                            <span class = "float-right post-right-button">
                                <i class = "fa fa-caret-down"></i>
                            </span>
                        </div>
                        <div class = "inner-container">
                            <input type = "text" placeholder="Enter tags" name = "tags"><button class = "button primary" id = "tag-add-button">Add</button>
                        </div>
                        </div>
                    </div>
                <div class = "part-container" style = "margin-bottom: 20px;">
                        <div id = "categoryDiv" class = "post-right-container clearfix">

                        <div class = "post-right-title">
                            <span>Categories</span>
                            <span class = "float-right post-right-button">
                                <i class = "fa fa-caret-down"></i>
                            </span>
                        </div>
                        <div class = "inner-container">
                            <?php
                                $data = GetDashboardData::fetchCategory();
                                while($res = mysqli_fetch_assoc($data)){
                            ?>
                                
                            <input type = "checkbox" name = "category[]" value = "<?php echo ucwords($res['cat_title']);?>" <?php if($res['cat_title'] == 'Uncategorized') echo 'checked'; ?>>
                            <?php
                                    echo ucwords($res['cat_title']); 
                                }
                              ?>
                            <a href = "taxonomy.php?tag_type=category" name = "new-category" class = "button primary">Add New Category</a>
                        </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </form>
</div>
<?php
    require_once 'footer.php';
?>