$(document).ready(function(){     
            init();    
            var showingSourceCode = false;
            var isInEditMode = true;
            function init(){
                $('#htmlEditorIframe').contents().prop('designMode', 'on');
                htmlEditor.document.execCommand('styleWithCSS', false, null);
                if(!(navigator.userAgent.match(/MSIE/i) && navigator.userAgent.match(/Windows NT.*Trident\//))){	
                    htmlEditor.document.execCommand('enableObjectResizing', false, null);
                    htmlEditor.document.execCommand('enableInlineTableEditing', false, null);
                }
                    htmlEditor.document.execCommand("defaultParagraphSeparator", false, "p");     
                    htmlEditor.document.body.style.wordWrap = 'break-word';
                htmlEditor.document.addEventListener('keyup', updateStatus, false);
            }
    
            function updateStatus(){
                s = $(this).text();
                s = s.replace(/(^\s*)|(\s*$)/gi,"");
                s = s.replace(/[ ]{2,}/gi," ");
                s = s.replace(/\n /,"\n");
                $("#editor-word-count").text("Words Count: "+s.split(' ').length);
            }
                function allowDrop(ev) {
                    ev.preventDefault();
                }
                function drop(ev) {
                    ev.preventDefault();
                    var data = ev.dataTransfer.getData("text");
                    ev.target.appendChild(document.getElementById(data));
                }
            $('#boldButton').click(function(){
                htmlEditor.document.execCommand('bold', false, null);
                return false;
            });
            $('#italicButton').click(function(){ 
                htmlEditor.document.execCommand('italic', false, null);
                return false;
            });
            $('#underLineButton').click(function(){ 
                htmlEditor.document.execCommand('underline', false, null);
                return false;
            });
            $('#strikeButton').click(function(){ 
                htmlEditor.document.execCommand('strikeThrough', false, null);
                return false;
            });
            $('#subscriptButton').click(function(){ 
                htmlEditor.document.execCommand('subscript', false, null);
                return false;
            });
            $('#superscriptButton').click(function(){ 
                htmlEditor.document.execCommand('superscript', false, null);
                return false;
            });
            $('#listOlButton').click(function(){ 

                htmlEditor.document.execCommand('insertOrderedList', false, null);
                return false;
            });
            $('#listUlButton').click(function(){ 
                
                htmlEditor.document.execCommand('insertUnorderedList', false, null);
                return false;
            });
            $('#paragraphButton').click(function(){ 
                htmlEditor.document.execCommand('formatBlock', false, 'p');
                return false;
            });
            $('#leftAlignButton').click(function(){ 
                htmlEditor.document.execCommand('justifyLeft', false, null);
                return false;
            });
            $('#centerAlignButton').click(function(){ 
                htmlEditor.document.execCommand('justifyCenter', false, null);
                return false;
            });
            $('#rightAlignButton').click(function(){ 
                htmlEditor.document.execCommand('justifyRight', false, null);
                return false;
            });
            $('#justifyAlignButton').click(function(){ 
                htmlEditor.document.execCommand('justifyFull', false, null);
                return false;
            });
            $('#undoButton').click(function(){ 
                htmlEditor.document.execCommand('undo', false, null);
                return false;
            });
            $('#redoButton').click(function(){ 
                htmlEditor.document.execCommand('redo', false, null);
                return false;
            });
            $('#insertLink').click(function(){ 
                
                htmlEditor.document.execCommand('createLink', false, prompt('Enter URL', 'http://'));
                return false;
            });
            $('#unlinkButton').click(function(){
                htmlEditor.document.execCommand('unlink', false, null);
                return false;
            });
            $('#indentButton').click(function(){ 
                htmlEditor.document.execCommand('indent', false, null);
                return false;
            });
            $('#dedentButton').click(function(){ 
                htmlEditor.document.execCommand('outdent', false, null);
                return false;
            });
            $('#editButton').click(function(){
                if(isInEditMode){
                    $('#htmlEditorIframe').contents().prop('designMode', 'off');
                    isInEditMode = false;
                }else{
                    $('#htmlEditorIframe').contents().prop('designMode', 'on');
                    isInEditMode = true;
                }
                return false;
            });
            $('#codeButton').click(function(){ 
                $(this).toggleClass('button-active');
                lines = $("#htmlEditorIframe").html().split("<br>");
                $("#htmlEditorIframe").html('<p>' + lines.join("</p><p>") + '</p>');
                if(showingSourceCode){
                    htmlEditor.document.getElementsByTagName('body')[0].innerHTML = htmlEditor.document.getElementsByTagName('body')[0].textContent;
                    showingSourceCode = false;
                }else{
                    htmlEditor.document.getElementsByTagName('body')[0].textContent = htmlEditor.document.getElementsByTagName('body')[0].innerHTML;
                    showingSourceCode = true;
                }
                return false;
            });
            $('#horizontalLineButton').click(function(){ 
                htmlEditor.document.execCommand('insertHorizontalRule', false, null);
                return false;
            });
            $('#insertImage').click(function(){ 
                //htmlEditor.document.execCommand('insertImage', false, prompt('Enter Image URL', 'http://'));
            });
            $('#selectAllButton').click(function(){ 
                htmlEditor.document.execCommand('selectAll', false, null);
                return false;
            });
            $('#headingSelect').change(function(){ 
               var selectedHeading = $(this).val();
               htmlEditor.document.execCommand('formatBlock', false, selectedHeading);    
                return false;
            });
            $('#fontSelect').change(function(){ 
                var selectedFont = $(this).val();
                htmlEditor.document.execCommand('fontName', false, selectedFont);      
                return false;
            });
            var colorButton = "";
            $('#color-select').on('click hover', function(){
                colorButton = 'fontColor';
                return false;
            });
            $('#back-color-select').on('click hover', function(){
                colorButton = 'highlightColor';
                return false;
            });
            $('#fore-color > ul > li > a ').on("click",function(){
                var selectedColor = $(this).attr('value').trim();
                if(colorButton == 'fontColor'){
                    htmlEditor.document.execCommand('foreColor', false, selectedColor);      
                    $('#color-select').css('color', selectedColor);
                }else if(colorButton == 'highlightColor'){
                    
                    htmlEditor.document.execCommand('hiliteColor', false, selectedColor);    
                    $('#back-color-select').css('color', selectedColor);
                }
                return false;
            });
            $('#blockquoteSelect').click(function(){
                if(navigator.userAgent.match(/MSIE/i) || navigator.userAgent.match(/Windows NT.*Trident\//)){													 
                    htmlEditor.document.execCommand('indent', false, null); 	
                }
                else{
                    htmlEditor.document.execCommand('formatBlock', false, '<blockquote>');
                }
                return false;
            });
            $('#clearFormat').click(function(){
                htmlEditor.document.execCommand('removeFormat', false, null);
                return false;
            });
            $('#fullScreen').click(function(){
                $(this).toggleClass('button-active');
                $('.editor-container').toggleClass('fullscreen');
                return false;
                    
            });
            $('#InsertItems').click(function(){
                return false;
            });
});