/**
 * Use to URL:
 *  /
 *  /index
 *  /index/*
 */


var func_application_index = {
    validator: function(){
        application_subscribe_formValidator();
    },
    init: function(){
        this.validator();
    }
};

$(document).ready(function(){
    //init func
    func_application_index.init();
});

function application_subscribe_formValidator(){
    bodyOffOn('submit', '.mailing .srch', function(e){
        var form = $(this);
        var status = $(form).find('input[name="subscribe-form"]');
        if($(status).val() == 0){
            e.preventDefault();
            application_removeErrors(form);
            var url = $(form).find('input[name="validator"]').val();
            var vals = {
                subscribe_email: $(form).find('input[name="subscribe_email"]').val()
            };
            console.log(vals);
            $.post(url, vals, function(data){
                if(data.status == true){
                    var subUrl = $(form).attr('action');
                    $.post(subUrl, vals, function(data){
                        if (data.status == true){
                            alert('Ваш email успешно подписан на рассылку');
                            $(form).find('input[name="subscribe_email"]').val('');
                        } else {
                            alert('При сохранении прозошла ошибка!');
                        }
                    });
                }else{
                    application_createErrors(form, data);
                }
            });
        }
    });
}
