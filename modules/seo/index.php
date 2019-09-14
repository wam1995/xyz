<?php



# 去掉“分类：”
# ------------------------------------------------------------------------------
    add_filter('get_the_archive_title', function ($title) {
        if (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_tag()) {
            $title = single_tag_title('', false);
        } elseif (is_author()) {
            $title = '<span class="vcard">' . get_the_author() . '</span>';
        }
        return $title;
    });

// 防止该文件直接被访问
    if (!defined('ABSPATH')) {
        exit; // Exit if accessed directly.
    }

    if (!function_exists('jidi')) {
        function jidi()
        {
        }

        ;
    }

    CSF::createSection('xyz', array(
        'title' => '首页SEO',
        'id	' => 'seo',
        'fields' => array(

            array(
                'id' => 'index_title',
                'type' => 'text',
                'title' => '首页title',
            ),
            array(
                'id' => 'index_keywords',
                'type' => 'textarea',
                'title' => '首页keywords',
            ),
            array(
                'id' => 'index_description',
                'type' => 'textarea',
                'title' => '首页description',
            ),


        )
    ));

// 文章选项
    CSF::createMetabox('xyz_article_setting', array(
        'title' => '文章选项',
        'post_type' => 'post',
    ));
    CSF::createSection('xyz_article_setting', array(
        'title' => 'SEO',
        'fields' => array(

            array(
                'id' => 'title',
                'type' => 'text',
                'title' => '标题',
            ),
            array(
                'id' => 'keywords',
                'type' => 'text',
                'title' => '关键词',
            ),
            array(
                'id' => 'description',
                'type' => 'textarea',
                'title' => '描述',
            ),

        )
    ));
// 页面选项
    CSF::createMetabox('xyz_page_setting', array(
        'title' => '页面选项',
        'post_type' => 'page',
    ));
    CSF::createSection('xyz_page_setting', array(
        'title' => 'SEO',
        'fields' => array(
            array(
                'id' => 'title',
                'type' => 'text',
                'title' => '标题',
            ),
            array(
                'id' => 'keywords',
                'type' => 'text',
                'title' => '关键词',
            ),
            array(
                'id' => 'description',
                'type' => 'textarea',
                'title' => '描述',
            ),


        )
    ));

// 主题选项
    CSF::createMetabox('xyz_download_setting', array(
        'title' => '主题选项',
        'post_type' => 'download',
    ));
    CSF::createSection('xyz_download_setting', array(
            'title' => 'SEO',
            'fields' => array(

                array(
                    'id' => 'title',
                    'type' => 'text',
                    'title' => '标题',
                ),
                array(
                    'id' => 'keywords',
                    'type' => 'text',
                    'title' => '关键词',
                ),
                array(
                    'id' => 'description',
                    'type' => 'textarea',
                    'title' => '描述',
                ),

            )
        )
    );


// 分类页主题选项
    CSF::createTaxonomyOptions('archive_options', array(
        'taxonomy' => 'category',
        'data_type' => 'serialize',
    ));
    CSF::createSection('archive_options', array(
        'fields' => array(
            array(
                'id' => 'title',
                'type' => 'text',
                'title' => '标题',
            ),
            array(
                'id' => 'keywords',
                'type' => 'textarea',
                'title' => '关键词',
            ),
            array(
                'id' => 'description',
                'type' => 'textarea',
                'title' => '描述',
            ),


        )
    ));


    function xyz_title($sep = '&raquo;', $display = true, $seplocation = '')
    {

        $title_base = xyz('index_title');
        $keywords_base = xyz('index_keywords');
        $description_base = xyz('index_keywords');


        if (!$title_base) {
            $title_base = get_bloginfo('name') . '-' . get_bloginfo('description');
        }
        if (!$keywords_base) {
            $keywords_base = get_bloginfo('name') . ',' . get_bloginfo('description');
        }
        if (!$description_base) {
            $description_base = get_bloginfo('description');
        }

        // 首页
        if ((is_home() || is_front_page())) {

            $title = $title_base;
            $keywords = $keywords_base;
            $description = $description_base;

        }
        // 文章页
        if (is_single()) {

            $single_object = get_queried_object();
            if (get_post_type() == 'post') {
                $meta = get_post_meta($single_object->ID, 'xyz_article_setting', true);
            }
            if (get_post_type() == 'download') {
                $meta = get_post_meta($single_object->ID, 'xyz_download_setting', true);
            }
            if (get_post_type() == 'guide') {
                $meta = get_post_meta($single_object->ID, 'xyz_guide_setting', true);
            }
            if (get_post_type() == 'product') {
                $meta = get_post_meta($single_object->ID, 'xyz_product_setting', true);
            }
            if (get_post_type() == 'showcase') {
                $meta = get_post_meta($single_object->ID, 'xyz_showcase_setting', true);
            }
            if (get_post_type() == 'guide') {
                $meta = array(
                    'title' => '正在跳转至' . get_the_title() . '-' . get_bloginfo('name'),
                    'keywords' => get_the_title() . ',' . $keywords_base,
                    'description' => '本页面是' . get_bloginfo('name') . '跳转至' . get_the_title() . '的跳转页',
                );
            }

            if ($meta) {
                $title = $meta['title'];
                $keywords = $meta['keywords'];
                $description = $meta['description'];
            }
            if (!$title) {
                $title = single_post_title('', false) . '-' . get_bloginfo('name');
            }

            if (!$keywords) {
                $keywords = single_post_title('', false) . ',' . $keywords_base;
            }

            if (!$description) {
                $description = xyz_strimwidth($single_object->post_content, 90);
            }

        }
        if (is_page()) {

            $single_object = get_queried_object();
            $meta = get_post_meta($single_object->ID, 'xyz_article_setting', true);

            if ($meta) {
                $title = $meta['title'];
                $keywords = $meta['keywords'];
                $description = $meta['description'];
            }
            if (!$title) {
                $title = get_the_title() . '-' . get_bloginfo('name');
            }

            if (!$keywords) {
                $keywords = get_the_title() . ',' . $keywords_base;
            }

            if (!$description) {
                $description = xyz_strimwidth($single_object->post_content, 90);
            }

        }

        if (is_archive()) {

            $archive_object = get_queried_object();
            if (is_tax()) {
                if (get_post_type() == 'theme') {
                    $meta = get_term_meta($archive_object->term_id, 'theme_archive_options', true);
                } elseif (get_post_type() == 'product') {
                    $meta = get_term_meta($archive_object->term_id, 'product_archive_options', true);
                } elseif (get_post_type() == 'guide') {
                    $meta = get_term_meta($archive_object->term_id, 'guide_archive_options', true);
                } elseif (get_post_type() == 'showcase') {
                    $meta = get_term_meta($archive_object->term_id, 'showcase_archive_options', true);
                } else {
                    $meta = get_term_meta($archive_object->term_id, 'archive_options', true);
                }
            } else {
                if (get_post_type() == 'theme') {
                    $meta = get_option('theme_options');
                } elseif (get_post_type() == 'product') {
                    $meta = get_option('product_options');
                } elseif (get_post_type() == 'guide') {
                    $meta = get_option('product_options');
                } elseif (get_post_type() == 'download') {
                    $meta = get_option('download_archive_options');
                } else {
                    $meta = get_term_meta($archive_object->term_id, 'archive_options', true);
                }
            }
            if ($meta) {
                $title = $meta['title'];
                $keywords = $meta['keywords'];
                $description = $meta['description'];
            }
            if (!$title) {
                $title = get_the_archive_title() . '-' . get_bloginfo('name');
            }
            if (!$keywords) {
                $keywords = get_the_archive_title() . ',' . $keywords_base;
            }
            if (!$description) {
                $description = xyz_strimwidth(get_the_archive_description(), 90);
            }
        }

        // If there's a month
        if (is_archive() && !empty($m)) {

            global $wp_locale;
            $my_year = substr($m, 0, 4);
            $my_month = $wp_locale->get_month(substr($m, 4, 2));
            $my_day = intval(substr($m, 6, 2));
            $title = $my_year . ($my_month ? $t_sep . $my_month : '') . ($my_day ? $t_sep . $my_day : '');

            $keywords = $keywords_base;
            $description = $description_base;
        }

        // If there's a year
        if (is_archive() && !empty($year)) {
            $title = $year;
            if (!empty($monthnum)) {
                $title .= $t_sep . $wp_locale->get_month($monthnum);
            }
            if (!empty($day)) {
                $title .= $t_sep . zeroise($day, 2);
            }

            $keywords = $keywords_base;
            $description = $description_base;
        }

        // If it's a search
        if (is_search()) {
            /* translators: 1: separator, 2: search phrase */
            $search = get_query_var('s');
            $title = sprintf(__('搜索：'), strip_tags($search));

            $keywords = $keywords_base;
            $description = $description_base;
        }

        // If it's a 404 page
        if (is_404()) {
            $title = '404错误！页面未找到';
            $keywords = $keywords_base;
            $description = $description_base;
        }


        echo "<title>$title</title>";
        echo "<meta name=\"keywords\" content=\"$keywords\" />";
        echo "<meta name=\"description\" content=\"$description\" />";


    }

    add_action('wp_head', 'xyz_title', 1);
