jQuery(document).on('click', '.footer-upgrade', function(event) {
    event.preventDefault();

    var that = jQuery(this);
    var text = that.text();

    if( that.hasClass('disabled') ){
        return false;
    }

    var index = layer.load(1, {
        shade: [0.1,'#000']
    });
    that.addClass('disabled').text('正在升级...');

    jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'json',
        data: {action: 'nc-store-plugin-updata', module: that.data('key') },
        success: function(data, textStatus, xhr) {
            if( data.status == 200 ){
                that.text('升级成功');
                layer.msg(data.msg);
            }else{
                that.removeClass('disabled').text(text);
                layer.msg(data.msg);
            }
            layer.close(index);
        },
        error: function(xhr, textStatus, errorThrown) {
            that.removeClass('disabled').text(text);
            layer.close(index);
            layer.msg('网络错误，请稍后再试！');
        }
    });

});

jQuery(document).on('click', '.csf-header-left', function(event) {

    event.preventDefault();

    var that = jQuery(this);

    if( that.hasClass('disabled') ){
        return false;
    }

    var index = layer.load(1, {
        shade: [0.1,'#000']
});

    jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'json',
        data: {action: 'xyz_plugin_check_update' },
        success: function(data, textStatus, xhr) {
            if( data.status == 200 ){

                var confirm = layer.confirm(data.msg, {
                    btn: ['升级','取消'] //按钮
                }, function(){

                    layer.close(confirm);

                    var index = layer.load(1, {
                        shade: [0.1,'#000']
                    });

                    jQuery.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        dataType: 'json',
                        data: {plugin: data.plugin, slug: data.slug, _ajax_nonce: data._ajax_nonce, action: data.action },
                        success: function(data, textStatus, xhr) {

                            if( data.success == true ){
                                layer.msg('升级成功');
                                setTimeout(function(){
                                    window.location.href = window.location.href;
                                },1500);
                            }else{
                                layer.msg('升级失败');
                            }

                            layer.close(index);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            layer.close(index);
                            layer.msg('网络错误，请稍后再试！');
                        }
                    });

                }, function(){

                });

            }else{
                that.removeClass('disabled');
                layer.msg(data.msg);
            }
            layer.close(index);
        },
        error: function(xhr, textStatus, errorThrown) {
            that.removeClass('disabled');
            layer.close(index);
            layer.msg('网络错误，请稍后再试！');
        }
    });

});
