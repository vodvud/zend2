/**
 * Use to URL:
 *  /admin/blog
 *  /admin/blog/*
 */

var func_admin_blog = {
    validator: function(){
        admin_blog_formValidator();
    },
    init: function(){
        this.validator();
    }
}

$(document).ready(function(){
    //init func
    func_admin_blog.init();
});

function admin_blog_formValidator(){
    bodyOffOn('submit', '.form-validator', function(e){
        var form = $(this);
        var status = $(form).find('input[name="'+($(form).hasClass('edit') ? 'edit' : 'add')+'-form"]');
        
        if($(status).val() == 0){            
            e.preventDefault();
            admin_removeErrors(form);
            
            var url = $(form).find('input[name="validator"]').val();
            var vals = {
                title: $(form).find('input[name="title"]').val(),
                description: $(form).find('textarea[name="description"]').val()
            };

            $.post(url, vals, function(data){
                if(data.status == true){
                    $(status).val(1);
                    $(form).submit();
                }else{
                    admin_createErrors(form, data);
                }
            });
        }
    });
}