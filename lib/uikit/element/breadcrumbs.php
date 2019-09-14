<?php
function uikit_breadcrumbs($custom_taxonomy='category') {
    // Settings
    $breadcrums_id      = '';
    $breadcrums_class   = 'uk-breadcrumb';
    $home_title         = '首页';
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    //$custom_taxonomy    = 'products';
    // Get the query & post information
    global $post,$wp_query;
    // Do not display on the homepage
    if ( !is_front_page() ) {
        // Build the breadcrums
        echo '<ul class="uk-margin-remove-bottom ' . $breadcrums_class . '" >';
        // Home page
        echo '<li><a href="' . get_home_url() . '">' . $home_title . '</a></li>';
        
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
            echo '<li><span>' . post_type_archive_title($prefix, false) . '</span></li>';
        }
        else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
            // If post is a custom post type
            $post_type = get_post_type();
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
                echo '<li><a href="' . $post_type_archive . '">' . $post_type_object->labels->name . '</a></li>';
            }
            $custom_tax_name = get_queried_object()->name;
            echo '<li><span>' . $custom_tax_name . '</span></li>';
        }
        else if ( is_single() ) {
            // If post is a custom post type
            $post_type = get_post_type();
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
                echo '<li><a href="' . $post_type_archive . '">' . $post_type_object->labels->name . '</a></li>';
            }
            // Get post category info
            $category = get_the_category();
            if(!empty($category)) {
                // Get last category post is in
                $last_category = end(array_values($category));
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li>'.$parents.'</li>';
                }
            }
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
            }
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                //echo '<li><a class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</a></li>';
                // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                echo '<li><a href="' . $cat_link . '">' . $cat_name . '</a></li>';
               // echo '<li><a class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</a></li>';
            } else {
               // echo '<li><a class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</a></li>';
            }
        } else if ( is_category() ) {
            // Category page
            echo '<li><a class="bread-current bread-cat">' . single_cat_title('', false) . '</a></li>';
        } else if ( is_page() ) {
            // Standard page
            if( $post->post_parent ){
                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );
                // Get parents in the right order
                $anc = array_reverse($anc);
                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>';
                }
                // Display parent pages
                echo $parents;
                // Current page
                echo '<li><a title="' . get_the_title() . '"> ' . get_the_title() . '</a></li>';
            } else {
                // Just display current page if not parents
                echo '<li><a class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</a></li>';
            }
        } else if ( is_tag() ) {
            // Tag page
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
            // Display the tag name
            echo '<li><a class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</a></li>';
        } elseif ( is_day() ) {
            // Day archive
            // Year link
            echo '<a href="' . get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . ' Archives</a>';
            // Month link
            echo '<a href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '">' . get_the_time('M') . ' Archives</a>';
            // Day display
            echo '<li ><a class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</a></li>';
        } else if ( is_month() ) {
            // Month Archive
            // Year link
            echo '<a href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a>';
            // Month display
            echo '<li><a class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
        } else if ( is_year() ) {
            // Display year archive
            echo '<li><a class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
        } else if ( is_author() ) {
            // Auhor archive
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
            // Display author name
            echo '<li><a class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . '作者: ' . $userdata->display_name . '</a></li>';
        } else if ( get_query_var('paged') ) {
            // Paginated archives
            echo '<li><a class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</a></li>';
        } else if ( is_search() ) {
            // Search results page
            echo '<li><a class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">搜索结果: ' . get_search_query() . '</a></li>';
        } elseif ( is_404() ) {
            // 404 page
            echo '<a>' . '错误 404' . '</a>';
        }
        echo '</ul>';
    }
}