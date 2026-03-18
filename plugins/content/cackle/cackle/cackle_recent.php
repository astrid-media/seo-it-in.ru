<?php
/**
 * @author Cackle - cackle.me
 * @date: 22.08.13
 *
 * @copyright  Copyright (C) 2013 cackle.me . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;
include_once ('engine/modules/cackle/cackle_api.php');

function echo_recent(){
    $cackle_api = new CackleAPI();
    ob_start()?>

<div id="mc-last"></div>
<script type="text/javascript">
    var mcSite = '<?php echo $cackle_api->cackle_get_param('site_id') ?>';
    var mcSize = '5';
    var mcAvatarSize = '32';
    var mcTextSize = '150';
    var mcTitleSize = '40';
    (function() {
        var mc = document.createElement('script');
        mc.type = 'text/javascript';
        mc.async = true;
        mc.src = '//cackle.me/mc.last-min.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(mc);
    })();
</script>

<?php
    echo  ob_get_clean();
}
echo_recent();
?>