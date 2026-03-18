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

function echo_counter(){
$cackle_api = new CackleAPI();
ob_start()?>
<script>
   var mcSite = '<?php echo $cackle_api->cackle_get_param('site_id') ?>';
   var mcCount = '<span title="Комментариев: {num}"><b>{num}</b></span>';
    (function () {
        var mc = document.createElement('script');
        mc.type = 'text/javascript';
        mc.async = true;
        mc.src = 'http://cackle.me/mc.count-min.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(mc);
    })();
</script>

<?php
echo  ob_get_clean();
}
echo_counter();
?>