<?php
//评论列表样式
function simple_comment($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
    <li id="comment-<?php comment_ID(); ?>">
        <article id="comment-article-<?php comment_ID(); ?>" class="comment even thread-even depth-1 uk-comment uk-visible-toggle">
            <header class="uk-comment-header uk-position-relative">
                <div class="uk-grid-medium uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                        <?php if (function_exists('get_avatar') && get_option('show_avatars')) { echo get_avatar($comment, 48); } ?>
                    </div>
                    <div class="uk-width-expand">
                        <h3 class="uk-comment-title uk-margin-remove"><?php comment_author()?></h3>
                        <p class="uk-comment-meta uk-margin-remove-top">
                            <time datetime="<?php echo get_comment_time('Y-m-d H:i'); ?>"><?php echo get_comment_time('Y-m-d H:i'); ?></time>
                        </p>
                    </div>
                </div>
                <div class="uk-position-top-right uk-hidden-hover">
                    <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => "<span uk-icon=\"icon: reply\"></span> 回复"))) ?>
                </div>
            </header>

            <div class="uk-comment-body">
                <?php comment_text() ?>
                <?php if ( $comment->comment_approved == '0' ) : ?>
                    您的评论正在等待审核中...
                <?php endif; ?>
            </div>

        </article>
    </li><!-- #comment-## -->

    <?php
    }
    ?>