/**
 * Use to URL:
 *  /profile/settings
 *  /profile/settings/*
 */

var func_profile_settings = {
    validator: function(){
        profile_settings_formValidator();
    },
    init: function(){
        this.validator();
    }
};

$(document).ready(function(){
    // init func
    func_profile_settings.init();
});

function profile_settings_formValidator(){
    bodyOffOn('submit', '.tab-content .form.settings-form', function(e){           
        var form = $(this);
        var status = $(form).find('input[name="settings-form"]');
        
        if($(status).val() == 0){            
            e.preventDefault();
            var url = $(form).find('input[name="validator"]').val();
            var vals = {
                username: $(form).find('input[name="username"]').val(),
                old_password: $(form).find('input[name="old_password"]').val(),
                password: $(form).find('input[name="password"]').val(),
                retry_password: $(form).find('input[name="retry_password"]').val()
            }

            $(form).find('.row .error').removeClass('error');

            $.post(url, vals, function(data){
                if(data.status == true){
                    $(status).val(1);
                    $(form).submit();
                }else{
                    if($(data.error).length > 0){
                        for(var i in data.error){                        
                            if(data.error[i] == false){
                                $(form).find('[name="'+i+'"]').addClass('error');
                            }else if(data.error[i] == true && i == 'username'){
                                $(form).find('[name="'+i+'"]').addClass('error');
                                alert('Такой логин уже существует, выберите другой.');
                            }
                        }
                    }
                }
            }); 
        }
        
    });
}