<?php
/**
 *  WordPress API 方式自动推送到百度熊掌号*
 */




    if (!function_exists('Baidu_XZH_Submit')) {
        function Baidu_XZH_Submit($post_ID)
        {
            //已成功推送的文章不再推送
            if (get_post_meta($post_ID, 'BaiduXZHsubmit', true) == 1) return;
            $url = get_permalink($post_ID);
            $api = 'http://data.zz.baidu.com/urls?appid=你的APPID&token=你的TOKEN&type=realtime';
            $request = new WP_Http;
            $result = $request->request($api, array('method' => 'POST', 'body' => $url, 'headers' => 'Content-Type: text/plain'));
            $result = json_decode($result['body'], true);
            //如果推送成功则在文章新增自定义栏目BaiduXZHsubmit，值为1
            if (array_key_exists('success', $result)) {
                add_post_meta($post_ID, 'BaiduXZHsubmit', 1, true);
            }
        }

        add_action('publish_post', 'Baidu_XZH_Submit', 0);
    }
    CSF::createSection('xyz', array(
        'title' => '熊掌号',
        'id	' => 'xiongzhang',
        'fields' => array(
            array(
                'id' => 'xiongzhang_switcher',
                'type' => 'switcher',
                'title' => '熊掌号开关',
            ),
            array(
                'id' => 'xiongzhang_appid',
                'type' => 'text',
                'title' => '你的APPID',
            ),
            array(
                'id' => 'xiongzhang_token',
                'type' => 'text',
                'title' => '你的TOKEN',
            ),


        )
    ));
