<?php
function JOYTHEME_alert(){
  $notice_switcher=JOYTHEME('notice_switcher');
  $notice_content=JOYTHEME('notice_content');
  if($notice_switcher):
    $notice_bgc=JOYTHEME('notice_bgc');
    switch ($notice_bgc):
        case 'red' :   $alert_class = 'uk-alert-danger'   ;break;
        case 'orange': $alert_class = 'uk-alert-warning'  ;break;
        case 'green':  $alert_class = 'uk-alert-success'  ;break;
        default:       $alert_class = 'uk-alert-primary uk-background-primary uk-light'  ;break;
    endswitch;

?>
<div class="uk-margin-remove <?php echo $alert_class;?>" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <div class="uk-container">
        <p><?php echo $notice_content;?></p>
    </div>
</div>
<?php endif;}?>