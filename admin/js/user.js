
$(document).ready(function(){
    var id = [];
    var name = [];
    var email = [];
    var date = [];
    fetch();
    function checker_check(){
        if($('.card .checkbox:checked').length > 0){
            $('#delete-button').css('display','block');
        }
        else{
            $('#delete-button').css('display', 'none');
        }
    }
    
    function fetch(){
       $('#users-list ul li').each(function(){
           id.push($(this).find('.card').find('img').attr('src'));
           name.push($(this).find('.card').find('.card-text').find('h4').text());
           email.push($(this).find('.card').find('.card-text').find('.title').first().text());
           date.push($(this).find('.card').find('.card-text').find('.date').text()); 
       });
    }
    function update(){
        var i = 0;
        $('#users-list ul li').each(function(){
           $(this).find('.card').find('img').attr('src', id[i]);
           $(this).find('.card').find('.card-text').find('h4').text(name[i]);
           $(this).find('.card').find('.card-text').find('.title').first().text(email[i]);
           $(this).find('.card').find('.card-text').find('.date').text(date[i]);
            i++;
       });
    }
    function sortByName(start, end){
        var temp1 = '', temp2 = '', temp3 = '', temp4 = '', j = 0;
        if(start < end){
            for(var i = start + 1; i < end; i++){
                temp1 = id[i];
                temp2 = name[i];
                temp3 = email[i];
                temp4 = date[i];
                j = i - 1;
                while(j >= 0 && temp2.localeCompare(name[j]) < 0){
                    name[j + 1] = name[j];
                    id[j + 1] = id[j];
                    email[j + 1] = email[j];
                    date[j + 1] = date[j];
                    j = j - 1;
                }
                id[j + 1] = temp1;
                name[j + 1] = temp2;
                email[j + 1] = temp3;
                date[j + 1] = temp4;                
            }
        }else{
            j = start - 1;
            for(var i = end; i < start / 2; i++, j--){
                temp1 = id[i];
                temp2 = name[i];
                temp3 = email[i];
                temp4 = date[i];
                id[i] = id[j];
                name[i] = name[j];
                email[i] = email[j];
                date[i] = date[j];
                id[j] = temp1;
                name[j] = temp2;
                email[j] = temp3;
                date[j] = temp4;
            }
        }
    }
    function sortByEmail(start, end){
        var temp1 = '', temp2 = '', temp3 = '', temp4 = '', j = 0;
        if(start < end){
            for(var i = start + 1; i < end; i++){
                temp1 = id[i];
                temp2 = name[i];
                temp3 = email[i];
                temp4 = date[i];
                j = i - 1;
                while(j >= 0 && temp3.localeCompare(email[j]) < 0){
                    name[j + 1] = name[j];
                    id[j + 1] = id[j];
                    email[j + 1] = email[j];
                    date[j + 1] = date[j];
                    j = j - 1;
                }
                id[j + 1] = temp1;
                name[j + 1] = temp2;
                email[j + 1] = temp3;
                date[j + 1] = temp4;                
            }
        }else{
            j = start - 1;
            for(var i = end; i < start / 2; i++, j--){
                temp1 = id[i];
                temp2 = name[i];
                temp3 = email[i];
                temp4 = date[i];
                id[i] = id[j];
                name[i] = name[j];
                email[i] = email[j];
                date[i] = date[j];
                id[j] = temp1;
                name[j] = temp2;
                email[j] = temp3;
                date[j] = temp4;
            }
        }
    }
    $('#sort-by-name').click(function(){
        var temp = '';
       if($(this).hasClass('desc')){
           $(this).removeClass('desc');
           sortByName(id.length, 0);
           update();
       }else{
           $(this).addClass('desc');
           sortByName(0, id.length);
           update();
       }
        
    });
    
    
    
    $('#sort-by-email').click(function(){
        var temp = '';
       if($(this).hasClass('desc')){
           $(this).removeClass('desc');
           sortByEmail(id.length, 0);
           update();
       }else{
           $(this).addClass('desc');
           sortByEmail(0, id.length);
           update();
       }
        
    });
    
    $('.card .checkbox').click(function(){
       checker_check(); 
    });

    

    
});