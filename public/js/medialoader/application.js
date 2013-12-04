/**
 * Use to URL:
 *  /*
 */

var func_main = {
    scrollToSearch: function(){
        main_scrollToSearch();
    },
    scrollToTestimonialsForm: function(){
        main_scrollToForm();
    },
    validator: function(){
        profile_login_formValidator();
        profile_registration_formValidator();
        profile_forgot_formValidator();
    },
    add: function(){
        testimonials_SubmitComment();
    },
    init: function(){
        this.add();
        this.validator();
    }
}

$(document).ready(function(){
    //init func
    func_main.init();
});

function main_scrollToSearch(){
    var top = $('#search-result').offset().top;
    $('html, body').animate({scrollTop : top},'slow');
}

function main_scrollToForm(){
    var top = $('#testimonialsForm').offset().top;
    $('html, body').animate({scrollTop : top},'slow');
}


function profile_login_formValidator(){
    bodyOffOn('submit', '.header .login-holder .popup.login-form', function(e){           
        var form = $(this);
        var status = $(form).find('input[name="login-form"]');
        
        if($(status).val() == 0){            
            e.preventDefault();
            var url = $(form).find('input[name="validator"]').val();
            var vals = {
                username: $(form).find('input[name="username"]').val(),
                password: $(form).find('input[name="password"]').val()
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
                            }
                        }
                    }
                }
            }); 
        }
        
    });
}

function profile_registration_formValidator(){
    bodyOffOn('submit', '.header .login-holder .popup.register', function(e){           
        var form = $(this);
        var status = $(form).find('input[name="registration-form"]');
        
        if($(status).val() == 0){            
            e.preventDefault();
            var url = $(form).find('input[name="validator"]').val();
            var vals = {
                username: $(form).find('input[name="username"]').val(),
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

function profile_forgot_formValidator(){
    bodyOffOn('submit', '.header .login-holder .popup.forgot', function(e){           
        var form = $(this);
        var status = $(form).find('input[name="forgot-form"]');
        
        if($(status).val() == 0){            
            e.preventDefault();
            var url = $(form).find('input[name="validator"]').val();
            var vals = {
                username: $(form).find('input[name="username"]').val()
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
                            }
                        }
                    }
                }
            }); 
        }
        
    });
}

function testimonials_SubmitComment(){
    bodyOffOn('submit', '.testimonial-form', function(e){
        e.preventDefault();
        var form = $(this);
        var url = $(form).find('input[name="validator"]').val();
        var vals = {
            name: $(form).find('input[name="name"]').val(),
            email: $(form).find('input[name="email"]').val(),
            comment: $(form).find('textarea[name="comment"]').val(),
            car_id: $(form).find('input[name="car_id"]').val(),
            cat_url: $(form).find('input[name="cat_url"]').val(),
            rate: $(form).find('input[name="rate"]').val()
        }

        $(form).find('.row.error-box').removeClass('error-box');

        $.post(url, vals, function(data){
            if(data.status == true){
                testimonials_AddComment(form, vals);
            }else{
                if($(data.error).length > 0){
                    for(var i in data.error){
                        if(data.error[i] == false){
                            $(form).find('[name="'+i+'"]').parent('.row').addClass('error-box');
                        }
                    }
                }
            }
        });
    });
}

function testimonials_AddComment(form, vals){
    var url = $(form).attr('action');

    $.post(url, vals, function(data){
        if(data.status == true){
            $(form).find('input[name="name"]').val('');
            $(form).find('input[name="email"]').val('');
            $(form).find('textarea[name="comment"]').val('');
            $(form).find('input[name="car_id"]').val('');
            $(form).find('input[name="cat_url"]').val('');
            $(form).find('input[name="rate"]').val('');

            alert('Спасибо, Ваш отзыв добавлен и отправлен на проверку.');
        }else{
            alert('Произошла серверная ошибка, попробуйте позже.');
        }
    });
}