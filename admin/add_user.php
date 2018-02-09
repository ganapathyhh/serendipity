<?php
$current = "Add User";
require_once 'header.php';
?>
    
<div class = "cell">
    <h3>Add user</h3>
    <?php echo messages();?>
</div>
<div class = "cell">
    <?php 
        if(isset($_POST['add-users'])){
            GetDashboardData::addUsers($_POST['user-email'], $_POST['user-type'], $_POST['user-name'], $_POST['user-password']);
            header('Location:'.$_SERVER['REQUEST_URI']);
        }
    ?>
      <form action="" method = "post" id = "form" name = "form">
          <div class = "grid-x grid-padding-x ">
              <div class = "large-6 cell">
                  <?php //Field for User's name ?>
                    <div class = "grid-x grid-padding-x">
                            
                            <?php //For Mobile view on User's name ?>
                            <div class = "small-12 medium-6 large-6 cell">
                                <label>User Name <small>*</small></label>
                            </div>
                            <?php //User's name input ?>
                              <div class = "small-12 medium-6 large-6 cell">
                                <input type = "text" placeholder="User Name" name = "user-name" autocomplete = "off">
                            </div>
                        </div>
                <br/>
                    <?php //Field for User's email ?>
                        <div class = "grid-x grid-padding-x">
                            <?php //For User's email ?>
                            <div class = "small-12 medium-6 large-6 cell">
                                <label>User email <small>*</small></label>
                            </div>
                            <?php //User's email input ?>
                              <div class = "small-12 medium-6 large-6 cell">
                                <input type = "email" placeholder="User Email" name = "user-email" autocomplete="off">
                            </div>
                        </div>
                  <br/>
                  <?php //Field for User's password ?>
                        <div class = "grid-x grid-padding-x">
                            <?php //For User's password ?>
                            <div class = "small-12 medium-6 large-6 cell">
                                <label>User password <small>*</small></label>
                            </div>
                            <?php //User's password input ?>
                              <div class = "small-12 medium-6 large6 cell">
                                  <div id = "gen-pass" class = "button secondary expanded">Generate Password</div>
                                  <div id = "password-generate" style = "display:none">
                                      <input type = "password" placeholder="User Password" name = "user-password" value = "<?php echo generatePassword();?>"><div id = "shhi" class = "button secondary" style = "display:inline-block; cursor:pointer"><i class = "fa fa-eye"></i> </div><div id = "show-cancel" class = "button secondary" style = "display:inline-block">Cancel</div>
                                </div>
                            </div>
                        </div>
                  <br/>
                  <?php //Field for User's role ?>
                      <div class = "grid-x grid-padding-x">
                          <?php //For User's role ?>
                          <div class = "small-12 medium-6 large-6 cell">
                                <label>Role <small>*</small></label>
                            </div>
                          <?php //User's role input ?>
                          <div class = "small-12 medium-6 large-6 cell">
                              <select placeholder = "select" name = "user-type">
                                    <option>-- USER TYPE --</option>
                                    <option value = "administrator">Administrator</option>
                                    <option value = "author">Author</option>
                                    <option value = "editor">Editor</option>
                              </select>
                          </div>
                      </div>
                      <div class = "row">
                          <div class = "col-35">
                              <input type = "submit" value="Add" name="add-users" class = "button primary">
                          </div>
                      </div>
              </div>
              <div class = "large-6 cell"></div>
          </div>
      </form>
    </div>

<?php
    require_once 'footer.php';
?>