<?php
/**
 * @author Cackle - cackle.me
 * @date: 22.08.13
 *
 * @copyright  Copyright (C) 2013 cackle.me . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
// no direct access
defined('_JEXEC') or die;
define("CACKLE_TIMER",3);
define("DS","/");

jimport('joomla.plugin.plugin');

require_once dirname(__FILE__).'/cackle/cackle_sync.php';

class plgContentCackle extends JPlugin
{
    public function onContentBeforeDisplay($context, &$row, &$params, $limitstart = 0 ){
    // RequestsF
    $option = JRequest::getCmd('option');
    $view 	= JRequest::getCmd('view');
    if($view == 'category' || $view == 'featured'){
     //   $this->onContentPrepare('com_content.article', $row, $params, $limitstart,$execute=false);
    }
        if(isset($row->text)){
            $row->introtext = $row->text;
        }


}
    public function onContentPrepare($context, &$row, &$params, $page = 0, $execute=true) {
        if(!isset($row->id)) return;
        if (!$execute) return;
        $this->renderCackle($row, $params, $page = 0);
    }

    public function renderCackle(&$row, &$params, $page){
        $view 	= JRequest::getCmd('view');
        $option 		= JRequest::getCmd('option');
        if ($option=='com_content' && $view=='article') {
            if (!isset($row->catid)) {
                $row->catid = '';
            }

            $mcChannel = $row->id;
            $cat = is_array($this->params->def('categories')) ? $this->params->def('categories') : array($this->params->def('categories'));
            if (!in_array($row->catid, $cat)) {
                 if ($view == 'article') {
                    $sync = new Sync();
                    if ($this->time_is_over(CACKLE_TIMER)){
                        $sync->comment_sync();
                    }
                }
                if ($this->params->def('sso')==1) {
                    $userinfo = JFactory::getUser();
                    $mcSSOAuth	= $this->cackle_auth($this->params->def('siteApiKey'),$userinfo);
                    $auth="var mcSSOAuth = '".$mcSSOAuth."';";
                } else {
                    $auth="";
                }
                $siteId = $this->params->def('siteId');
                $comments_html = $this->list_comments($mcChannel);
                $text = <<<HTML
                <div id="mc-container">
                <div id="mc-content">
                    <ul id="cackle-comments">
                    $comments_html
                    </ul>
                </div>
                </div>
				<script type="text/javascript">
				$auth
                var mcSite = '$siteId';
                var mcChannel = '$mcChannel';
                document.getElementById('mc-container').innerHTML = '';
                (function() {
				    var mc = document.createElement('script');
					mc.type = 'text/javascript';
					mc.async = true;
					mc.src = 'http://cackle.me/mc.widget-min.js';
					(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(mc);
				})();
				</script>

HTML;


                $row->text .= $text;

                //$article->text = str_replace("{Cackle}",$text,$article->text);

            } else {
                $row->text = str_replace("{Cackle}", "", $row->text);
            }
        }
        elseif($option=='com_content' && ($view=='frontpage' || $view=="featured" || $view=='section' || $view=='category')) {
            $cat = is_array($this->params->def('categories')) ? $this->params->def('categories') : array($this->params->def('categories'));
            $enableCounter = $this->params->def('enableCounter');
            if (!in_array($row->catid, $cat) && $enableCounter) {
           // if(version_compare(JVERSION,'2.6.0','ge')) $row->text = $row->introtext;
            $mainframe = JFactory::getApplication();
            $jinput = $mainframe->getPathway();
            //echo DS;
            require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

            // Output object
            $output = new JObject;
            $user				= JFactory::getUser();
            // Article URLs
            $websiteURL = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https://".$_SERVER['HTTP_HOST'] : "http://".$_SERVER['HTTP_HOST'];

            if(version_compare(JVERSION,'1.6.0','ge')) {
                //$levels = $user->authorisedLevels();
                $row->access=true;
                //if (in_array($row->access, $levels)) {

                    if($view == 'article'){
                        $itemURL = $row->readmore_link;
                    } else {
                        $itemURL = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catid));
                    }
               // }
            } else {
                $itemURL = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
            }

            $itemURLbrowser = explode("#",$websiteURL.$_SERVER['REQUEST_URI']);
            $itemURLbrowser = $itemURLbrowser[0];

            // Article URL assignments
            $output->itemURL 		    = $websiteURL.$itemURL;
            $output->itemURLrelative 	= $itemURL;
            $output->itemURLbrowser		= $itemURLbrowser;

            $pluginGroup = 'content';
            $pluginName = 'cackle';
            $list_url = $output->itemURL;
            $row_id = $row->id;
            $getListingTemplate = <<<HTML
            <a class="jsCackleCounterLink" href="$list_url#mc-container" cackle-channel="$row_id">
            Comments
            </a>
HTML;



              //var_dump($getListingTemplate);
            // Output
            $row->text .= $getListingTemplate;
        }
        }
    }
    function onAfterRender() {

        // API
        $mainframe	= JFactory::getApplication();
        $document 	= JFactory::getDocument();

        // Assign paths
        $sitePath = JPATH_SITE;
        $siteUrl  = JURI::root(true);

        // Requests
        $option 		= JRequest::getCmd('option');
        $view 			= JRequest::getCmd('view');
        $layout 		= JRequest::getCmd('layout');
        $page 			= JRequest::getCmd('page');
        $secid 			= JRequest::getInt('secid');
        //$catid 			= JRequest::getInt('catid');
        $catid=JRequest::getVar( 'catid','' );
        $itemid 		= JRequest::getInt('Itemid');
        if(!$itemid) $itemid = 999999;
        $plugin = JPluginHelper::getPlugin('content', 'cackle');
        $pluginParams=json_decode($plugin->params);
        $enableCounter = $pluginParams->enableCounter;
            if(strpos(JResponse::getBody(),'#mc-container')===false) return;
            if($mainframe->isAdmin()) return;
            if(!$enableCounter){
                return;
            }

            $siteId = $pluginParams->siteId;
            // Append head includes only when the document is in HTML mode
            if(JRequest::getCmd('format')=='html' || JRequest::getCmd('format')==''){
                $elementToGrab = '</body>';
                $htmlToInsert = "

    <script type=\"text/javascript\">
    //<![CDATA[
    var mcSite = '{$siteId}';
    (function() {
        var mc = document.createElement('script');
        mc.type = 'text/javascript';
        mc.async = true;
        mc.src = '//cackle.me/mc.count-min.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(mc);
    })();
    //]]>
    </script>

                ";

                // Output
                $buffer = JResponse::getBody();
                $buffer = str_replace($elementToGrab, $htmlToInsert."\n\n".$elementToGrab, $buffer);
                JResponse::setBody($buffer);
            }


    }
    function time_is_over($cron_time){
        $cackle_api = new CackleAPI();
        $get_last_time = $cackle_api->cackle_get_param("last_time");
        $now=time();
        if ($get_last_time==""){
            $set_time = $cackle_api->cackle_set_param("last_time",$now);
            return time();
        }
        else{
            if($get_last_time + $cron_time > $now){
                return false;
            }
            if($get_last_time + $cron_time < $now){
                $set_time = $cackle_api->cackle_set_param("last_time",$now);
                return $cron_time;
            }
        }
    }

    function get_local_comments($mcChannel){
        //getting all comments for special post_id from database.
        $cackle_api = new CackleAPI();
        $post_id = $mcChannel;

        $get_all_comments = $cackle_api->db_connect("select * from ".PREFIX."_cackle_comments where post_id = $post_id and status = 1;",true,true);

        return $get_all_comments;
    }

    function list_comments($mcChannel){
        $obj = $this->get_local_comments($mcChannel);
        if($obj!=null){
            ob_start();
            foreach ($obj as $comment) {
                $this->cackle_comment($comment);
            }
            $result = ob_get_contents();
            ob_end_clean();
            return $result;
        }

    }
    function getTemplatePath($pluginName,$file){

        $mainframe = &JFactory::getApplication();
        $p = new JObject;
        $pluginGroup = 'content';

        if(file_exists(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.$pluginName.DS.str_replace('/',DS,$file))){
            $p->file = JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.$pluginName.DS.$file;
            $p->http = JURI::root(true).'/templates/'.$mainframe->getTemplate().'/html/'.$pluginName.'/'.$file;
        } else {
            if(version_compare(JVERSION,'1.6.0','ge')) {
                // Joomla! 1.6+
                $p->file = JPATH_SITE.DS.'plugins'.DS.$pluginGroup.DS.$pluginName.DS.$pluginName.DS.'tmpl'.DS.$file;
                $p->http = JURI::root(true).'/plugins/'.$pluginGroup.'/'.$pluginName.'/'.$pluginName.'/tmpl/'.$file;
            } else {
                // Joomla! 1.5
                $p->file = JPATH_SITE.DS.'plugins'.DS.$pluginGroup.DS.$pluginName.DS.'tmpl'.DS.$file;
                $p->http = JURI::root(true).'/plugins/'.$pluginGroup.'/'.$pluginName.'/tmpl/'.$file;
            }
        }
        return $p;
    }
    function cackle_auth($apiId,$userinfo){
        $timestamp = time();
        $siteApiKey = $apiId;

        if ($userinfo->guest==0){
            $user = array(
                'id' => $userinfo->id,
                'name' => $userinfo->name,
                'email' => $userinfo->email,
                'avatar' => ''
            );

            $user_data = base64_encode(json_encode($user));
        }
        else{
            $user = '{}';
            $user_data = base64_encode($user);
        }
        $sign = md5($user_data . $siteApiKey . $timestamp);
        return "$user_data $sign $timestamp";

    }

    function cackle_comment( $comment) {

        ?><li  id="cackle-comment-<?php echo $comment->comment_id; ?>">
        <div id="cackle-comment-header-<?php echo $comment->comment_id; ?>" class="cackle-comment-header">
            <cite id="cackle-cite-<?php echo $comment->comment_id;; ?>">
                <?php if(isset($comment->author_name)) : ?>
                <a id="cackle-author-user-<?php echo $comment->comment_id;; ?>" href="#" target="_blank" rel="nofollow"><?php echo $comment->author_name; ?></a>
                <?php else : ?>
                <span id="cackle-author-user-<?php echo $comment->comment_id;; ?>"><?php echo $comment->author_name; ?></span>
                <?php endif; ?>
            </cite>
        </div>
        <div id="cackle-comment-body-<?php echo $comment->comment_id;; ?>" class="cackle-comment-body">
            <div id="cackle-comment-message-<?php echo $comment->comment_id;; ?>" class="cackle-comment-message">
                <?php echo $comment->message; ?>
            </div>
        </div>
    </li><?php

    }
}

?>
