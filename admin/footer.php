
</div>
<script src = "js/jquery.min.js"></script>
<script src = "js/vendor/foundation.min.js"></script>
<script src = "js/Chart.min.js"></script>
<script>
var ctx = document.getElementById("chart");
    ctx.height = 150;
var myLineChart = new Chart(ctx, {
    type: 'line',
    height: 100,
    data: [{
        x: 10,
        y: 20
    }, {
        x: 15,
        y: 10
    }]
});
</script>
<?php
if($current == 'Add Page' || $current == 'Add Post' || $current == 'Add Event'){
?>
<script src = "js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({     
         init_instance_callback: function (editor) {
            editor.on('BeforeSetContent, focus, blur, keyup, Change', function (e) {
              $('#source-code-editor').val(tinyMCE.activeEditor.getContent());
            });
          },
        selector:'#mytextarea',
        menubar: '',
        plugins: "print powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern code importcss",
        toolbar: "undo redo | bold italic strikethrough | alignleft aligncenter alignright alignjustify | formatselect | fontselect | fontsizeselect | forecolor backcolor  | numlist bullist outdent indent hr  |  table image media link unlink blockquote | removeformat | code fullscreen",
        branding: false
    });
</script>
<script src = "js/pageAdd.js"></script>
<?php
}
?>
    <script>
        /*if(localStorage.getItem('sidebar') === '0' && $(window).width() <= 480){
            $('#side-bar, #content, .sidebar').addClass('hide');
        }
        */
    </script>
    
   <script>

        $(document).ready(function(){    
            
            $(document).foundation();
            
            
            $('#menu-open').click(function(){
                $('.side-bar').toggleClass('show');
                $('#side-bar').toggleClass('show');
            //    localStorage.setItem('sidebar', $('#side-bar').hasClass('hide')?0:1);
            });
            
            $('.is-active > a:first-of-type').click(function(e){
                e.preventDefault();
            });
            
            $('#gen-pass').click(function(e){
                $('#password-generate').css('display','block');
                $(this).css('display','none');
            });
            $('#shhi').click(function(){
                if($(this).prev('input').attr('type') == "text"){
                    $(this).prev('input').attr('type','password');
                    $(this).find('i').first().attr('class', 'fa fa-eye');
                }else{
                    $(this).prev('input').attr('type','text');
                    $(this).find('i').first().attr('class', 'fa fa-eye-slash');
                }
            });
            $('#show-cancel').click(function(){
               $('#gen-pass').css('display', 'inline-block') ;
                $('#password-generate').css("display", "none");
            });
            
            $('th .table-selector').click(function(e){
                var table= $(e.target).closest('.stack');
                $('td .table-selector',table).prop('checked',this.checked);
            });
            
            $('.show-hidden-details').click(function(){
                if($(this).find('i').attr('class') == 'fa fa-caret-down'){
                    $(this).find('i').attr('class', 'fa fa-caret-up');
                    $(this).parent().nextAll('td').css('display', 'block');
                }else{
                    $(this).find('i').attr('class', 'fa fa-caret-down');
                    $(this).parent().nextAll('td').css('display', 'none');
                }
            });
            
            
        });
       <?php 
       /**
       *Make the sidebar and topbar sticky on medium up devices
       *
       *This is a function called when window is resized
       *
       *As well as when window is opened
       */ ?>
       
       /*function stickyMaker(){
                    $(window).scroll(function(){
                        if($(window).scrollTop() >= 20){
                            $('.site-header').addClass('fixed');
                        }
                        else{
                            $('.site-header').removeClass('fixed');
                        }    
                    });
           $('.side-bar').addClass('side-bar-fixed');

       }
       stickyMaker();
       $(window).on('resize', function(){
              stickyMaker();           
       }); */
    </script>
</body>
</html>
<?php
ob_end_flush();
?>