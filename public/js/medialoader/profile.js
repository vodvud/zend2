/**
 * Use to URL:
 *  /profile/*
 */

var func_profile = {
    add: function(){
        profile_galleryAddItem();
        profile_phoneAddItem();
    },
    change: function(){
        profile_phoneChangeMask();
    },
    confirm: function(){
        profile_removeConfirm();
    },
    remove: function(){
        profile_galleryRemoveImage();
        profile_phoneRemoveItem();
    },
    load: function(){
        profile_loadСustomForms();
        profile_loadFormatMoney();
        profile_loadTinymce();
    },
    helper:function(){
        view_helper();
    },
    init: function(){
        this.add();
        this.change();
        this.confirm();
        this.remove();
        this.load();
        this.helper();
    },

    keyupTimeout: 0
}

$(document).ready(function(){
    // init func
    func_profile.init();
});

function profile_loadСustomForms(){
	if(jcf.customForms != 'undefined'){ 
        jcf.customForms.replaceAll(); 
    }
}

function view_helper(){
    var helper = {
        show: function(el){
            $('.helper .helper-box').hide();
            $(el).closest('.row').find('.helper-box').show(); 
        },
        hide: function(el){
            $(el).closest('.row').find('.helper-box').hide();
        }
    }
    
    bodyOffOn('click', '.helper .helper-item', function(){
        helper.show(this);
    });
    
    bodyOffOn('focus', '.helper .helper-item', function(){
        helper.show(this);
    });

    bodyOffOn('focusout', '.helper .helper-item', function(){
        helper.hide(this);
    });

    /* TODO: Only for hover items */
    $('.helper .mouse-hover').hover(
        function(){
            helper.show(this);
        },
        function(){
            helper.hide(this);
        }
    );
}

function profile_loadFormatMoney(){
    Number.prototype.formatMoney = function(c, d, t){
        var n = this, 
            c = isNaN(c = Math.abs(c)) ? 2 : c, 
            d = d == undefined ? "." : d, 
            t = t == undefined ? "," : t, 
            s = n < 0 ? "-" : "", 
            i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
            j = (j = i.length) > 3 ? j % 3 : 0;

        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };  
}

/**
 * @description Load Tinymce
 */
function profile_loadTinymce(){
    $('textarea.tinymce').tinymce({
        script_url : '/js/tinymce/tinymce.min.js',
        plugins: [
            "advlist autolink lists link charmap preview",
            "textcolor code media paste"
        ],
        toolbar: "preview | styleselect forecolor backcolor | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link media charmap hr",
        width : '100%',
        height : 200,
        paste_as_text: true,
        statusbar : false,
        menubar : false,
        resize: false,
        element_format : "html",
        forced_root_block : '',
        force_p_newlines : false,
        language:"ru"
    });  
}


function profile_galleryAddItem(){
    bodyOffOn('change', '.gallery-add-item', function(e){
        e.preventDefault();
        var el = $(this);
        var files = '';
        
        if($(el[0].files).length > 0){
            if($(el[0].files).length > 10){
                alert('Допустимо загружать 10 фото за один раз');
                $(el).val('');
            }else{
                $(el[0].files).each(function(index, elem){
                    files += '<span>'+elem.name+'</span>';
                });   
            }
        }
        
        $('.gallery-upload-box').html(files); 
    });
}

function profile_phoneAddItem(){
    bodyOffOn('click', '.phone-add-item', function(e){
        e.preventDefault();
        var count = $('.phone-remove-item').length + $('.phone-box .phone-items').length;
        
        if(count > 4){
            alert('Допустимо 5 номеров');
        }else{
            var mask = $('.phone-item-data').attr('data-phone-mask');
            var placeholder = $('.phone-item-data').attr('data-phone-placeholder');
            var maskArray = $('.phone-change-mask:first').html();

            if($(maskArray).length > 0){
                maskArray = '&nbsp;<select class="phone-change-mask small" name="mask[]">'+
                                maskArray+
                            '</select>';
            }else{
                maskArray = '';
            }
            
            var html = '<div class="control-group">'+       
                            '<input type="text" class="phone-items bfh-phone small" data-format="'+mask+'" name="phone[]" placeholder="'+placeholder+'" maxlength="20" value="">'+
                            maskArray+
                        '</div>';

            $('.phone-box').append(html);
            $('.phone-box .phone-change-mask:last option').removeAttr('selected');
            bfhphone_init();
            profile_loadСustomForms();
            $('.phone-box .phone-items:last').focus();
        }
    });
}

function profile_phoneChangeMask(){
    bodyOffOn('change', '.phone-change-mask', function(e){
        e.preventDefault();
        
        var el = $(this);
        var input = $(el).parent('.control-group').find('.phone-items');
        var option = $(el).find('option:selected');
        
        var value = $(input).val();
        
        $(input).attr('data-format', $(option).attr('data-mask'))
                .attr('placeholder', $(option).text())
                .attr('data-number', value)
                .val('');
        

        var html = $(input).outerHTML();
        
        $(input).remove();
        $(el).parent('.control-group').prepend(html);
        
        bfhphone_init();
    });
}

/**
 * @description Confirm remove
 */
function profile_removeConfirm(){
    bodyOffOn('click', '.confirm-remove', function(e){
        if(confirm('Подтвердите удаление')){
            return true;
        }else{
            e.preventDefault();
            return false;
        }
    });
}

/**
 * @description Delete gallery image
 */
function profile_galleryRemoveImage(){
    bodyOffOn('click', '.gallery-remove-image', function(e){
        e.preventDefault();
        if(confirm('Подтвердите удаление')){
            var el = $(this);
            var url = $(el).attr('href');
            
            $.post(url, null, function(data){
                if(data.status == true){
                    $(el).parent().remove();
                }
            });
        }else{
            return false;
        }
    });
}

/**
 * @description Delete phone item
 */
function profile_phoneRemoveItem(){
    bodyOffOn('click', '.phone-remove-item', function(e){
        e.preventDefault();
        if(confirm('Подтвердите удаление')){
            var el = $(this);
            var url = $(el).attr('href');
            
            $.post(url, null, function(data){
                if(data.status == true){
                    $(el).parent().remove();
                }
            });
        }else{
            return false;
        }
    });
}

/**
 * @param object form
 * @param array data
 */
function profile_createErrors(form, data){
    if($(data.error).length > 0){
        for(var i in data.error){                        
            if(i == 'phoneArray' && $(data.error[i]).length > 0){                
                for(var k in data.error[i]){
                    if(data.error[i][k] == false){
                        $(form).find('.phone-box .phone-items').eq(k).addClass('error');
                    }
                };
            }else{
                if(data.error[i] == false){
                    $(form).find('[name="'+i+'"]').addClass('error');
                }
            }
        }
        
        var errorItem = $(form).find('.error:first').parent();
        if($(errorItem).length > 0){
            var top = $(errorItem).offset().top;
            $('html, body').animate({scrollTop : top},'slow');
        }
        
    }
}

/**
 * @param object form
 */
function profile_removeErrors(form){
    $(form).find('.error').removeClass('error');
}