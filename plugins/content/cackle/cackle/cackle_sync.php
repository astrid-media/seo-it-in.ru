<?php
/**
 * @author Cackle - cackle.me
 * @date: 22.08.13
 *
 * @copyright  Copyright (C) 2013 cackle.me . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;
include (dirname(__FILE__).'/cackle_api.php');
class Sync {
    function Sync() {
        $cackle_api = new CackleAPI();
        $this->accountApiKey = $cackle_api->cackle_get_param("accountApiKey");
        $this->siteApiKey = $cackle_api->cackle_get_param("siteApiKey");
    }

    function comment_sync_all($a = "") {
        $response_size = $this->comment_sync();

        if ($response_size == 100 && $a = "all_comments") {
            while ($response_size == 100) {
                $response_size = $this->comment_sync();
            }
        }
        return "success";
    }

    function comment_sync(){
        $cackle_api = new CackleAPI();
        $cackle_last_modified = 0;
        $get_last_modified = $cackle_api->cackle_get_param("last_modified");
        $get_last_modified = str_replace(",",".",$get_last_modified);
        if ($get_last_modified !="" & $get_last_modified!=null){
            $cackle_last_modified = $get_last_modified;
        }
        function to_i($number_to_format){
            return number_format($number_to_format, 0, '', '');
        }
        $cackle_last_modified = to_i($cackle_last_modified);
        $params1 = "accountApiKey=$this->accountApiKey&siteApiKey=$this->siteApiKey&modified=$cackle_last_modified";
        $host="cackle.me/api/comment/mutable_list?$params1";


        function curl($url)
        {
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL,$url);
            curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
            curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec ($ch);
            curl_close($ch);

            return $result;
        }
        $response = curl($host);
        $response = $this->cackle_json_decodes($response);
        $this->push_comments($response);
        return count($response['comments']);

    }

    function to_i($number_to_format){
        return number_format($number_to_format, 0, '', '');
    }


    function cackle_json_decodes($response){

        $obj = json_decode($response,true);

        return $obj;
    }

    function filter_cp1251($string){
        $cackle_api = new CackleAPI();
        if ($cackle_api->cackle_get_param("cackle_encoding") == "cp1251"){
            iconv("utf-8", "windows-1251",$string);
        }
        return $string;
    }
    function insert_comm($comment,$status){

        /*
         * Here you can convert $url to your post ID
         */


        //var_dump($comment);
        if ($comment['author']!=null){
            $author_name = ($comment['author']['name']) ? $comment['author']['name'] : "";
            $author_email=  ($comment['author']['email']) ? $comment['author']['email'] :"";
            $author_www = $comment['author']['www'];
            $author_avatar = $comment['author']['avatar'];
            $author_provider = $comment['author']['provider'];
            $author_anonym_name = "";
            $anonym_email = "";
        }
        else{
            $author_name = ($comment['anonym']['name']) ? $comment['anonym']['name']: "" ;
            $author_email= ($comment['anonym']['email']) ?  $comment['anonym']['email'] : "";
            $author_www = "";
            $author_avatar = "";
            $author_provider = "";
            $author_anonym_name = $comment['anonym']['name'];
            $anonym_email = $comment['anonym']['email'];

        }
        $get_parent_local_id = null;
        $comment_id = $comment['id'];
        $comment_modified = $comment['modified'];
        $cackle_api = new CackleAPI();
        if ($cackle_api->cackle_get_param("last_comment")==0){
            $cackle_api->cackle_db_prepare();
        }
        $date =strftime("%Y-%m-%d %H:%M:%S", $comment['created']/1000);
        $ip = ($comment['ip']) ? $comment['ip'] : "";
        $message = $comment['message'];
        $comment_url = $comment['url'];
        $user_agent = 'Cackle:' . $comment['id'];
        $comment_rating = $comment['rating'];
        $comment_created = strftime("%Y-%m-%d %H:%M:%S", $comment['created']/1000);
        $comment_ip = $comment['ip'];
        $parent_id = null;

        if ($comment['parentId']) {
            $comment_parent_id = $comment['parentId'];

            $query = "select comment_id from ". PREFIX ."_cackle_comments where user_agent ='Cackle:$comment_parent_id'";
            $parent_id = $cackle_api->db_connect( $query );
            if ($parent_id){
                $parent_id = $parent_id->comment_id;
            }
            else{
                $parent_id = null;
            }

        }

        // Create and populate an object.
        $comments = new stdClass();
        $comments->url = $comment_url;
        $comments->author_name=$author_name;
        $comments->author_email=$author_email;
        $comments->author_www=$author_www;
        $comments->author_avatar=$author_avatar;
        $comments->author_provider=$author_provider;
        $comments->anonym_name=$author_anonym_name;
        $comments->anonym_email=$anonym_email;
        $comments->created=$comment_created;
        $comments->ip=$comment_ip;
        $comments->message=$message;
        $comments->status=$status;
        $comments->user_agent=$user_agent;
        $comments->parent_id=$parent_id;
        $comments->post_id=$comment['channel'];



        try {
            // Insert the object into the user profile table.
            $result = JFactory::getDbo()->insertObject('#__cackle_comments', $comments);
        } catch (Exception $e) {
            // catch any errors.
        }



        //////////////////////

        $cackle_api->cackle_set_param("last_comment",$comment_id);
        $get_last_modified = $cackle_api->cackle_get_param("last_modified");
        $get_last_modified = (int)$get_last_modified;
        if ($comment['modified'] > $get_last_modified) {
            $cackle_api->cackle_set_param("last_modified",(string)$comment['modified']);
        }

    }

    function comment_status_decoder($comment) {
        $status;
        if (strtolower($comment['status']) == "approved") {
            $status = 1;
        }
        elseif (strtolower($comment['status'] == "pending") || strtolower($comment['status']) == "rejected") {
            $status = 0;
        }
        elseif (strtolower($comment['status']) == "spam") {
            $status = 0;
        }
        elseif (strtolower($comment['status']) == "deleted") {
            $status = 0;
        }
        return $status;
    }

    function update_comment_status($comment_id, $status, $modified, $comment_content) {
        $cackle_api = new CackleAPI();
        $sql = "update ". PREFIX ."_cackle_comments set status = $status , message = '$comment_content' where user_agent ='Cackle:$comment_id'";
        $conn = $cackle_api->db_connect($sql,false);

        //$cackle_api->db_connect("update dle_comments set approve = $status, text = '$comment_content' where user_agent = 'Cackle:$comment_id';");
        $cackle_api->cackle_set_param("last_modified",$modified);

    }

    function push_comments ($response){
        $obj = $response['comments'];
        if ($obj) {
            foreach ($obj as $comment) {
                $cackle_api = new CackleAPI();
                $get_last_modified = $cackle_api->cackle_get_param("last_modified");
                $get_last_comment = $cackle_api->cackle_get_param("last_comment");
                //$get_last_comment = $this->db_connect("select common_value from common where `common_name` = 'last_comment'","common_value");
                //$get_last_modified = $this->db_connect("select common_value from common where `common_name` = 'last_modified'","common_value");
                if ($comment['id'] > $get_last_comment) {
                    $this->insert_comm($comment, $this->comment_status_decoder($comment));
                } else {
                    if ($get_last_modified==""){
                        $get_last_modified == 0;
                    }
                    if ($comment['modified'] > $get_last_modified) {
                        $this->update_comment_status($comment['id'], $this->comment_status_decoder($comment), $comment['modified'], $comment['message'] );
                    }
                }

            }
        }
    }

}
?>