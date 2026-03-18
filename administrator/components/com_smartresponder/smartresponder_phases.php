<?php

// Get content with cURL
function sr_get_content($link, $data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);   

    return $result;
}

// Start session
session_start();

switch($_REQUEST['phase']) {
    // Synchronization
    case 'sync':
        $api_key = htmlspecialchars($_GET['api_key']);
            
        $link = 'http://api.smartresponder.ru/account.html';

        $data = array();
        $data['format'] = 'json';
        $data['action'] = 'info';
        $data['api_key'] = $api_key;

        $result = sr_get_content($link, $data);
        $obj = json_decode($result);
        if($obj->result == '1') {
            $_SESSION['api_key'] = $api_key;
        }
        echo $result;
        
        break;
    // Get Deliveries
    case 'get_deliveries':
        $api_key = $_SESSION['api_key'];

        $link = 'http://api.smartresponder.ru/deliveries.html';

        $data = array();
        $data['format'] = 'json';
        $data['action'] = 'list';
        $data['api_key'] = $api_key;

        $result  = sr_get_content($link, $data);

        echo $result;
        
        break;
    // Get Tracks
    case 'get_tracks':
        $api_key = $_SESSION['api_key'];

        $link = 'http://api.smartresponder.ru/tracks.html';

        $data = array();
        $data['format'] = 'json';
        $data['action'] = 'list';
        $data['api_key'] = $api_key;

        $result  = sr_get_content($link, $data);

        echo $result;
        
        break;
    // Get Groups
    case 'get_groups':
        $api_key = $_SESSION['api_key'];

        $link = 'http://api.smartresponder.ru/groups.html';

        $data = array();
        $data['format'] = 'json';
        $data['action'] = 'list';
        $data['api_key'] = $api_key;

        $result  = sr_get_content($link, $data);

        echo $result;
        
        break;
    // Get Users
    case 'get_users':
        JFactory::getApplication('site')->initialise();
        $db = JFactory::getDBO();
        
        $query = "SELECT id, username, email, registerDate FROM #__users ";
        if(isset($_POST['period']) or isset($_POST['email'])) {
            $data_mode = $_POST['period'];
            $email = $_POST['email'];
            if(strlen($data_mode) > 0) {
                if($data_mode == 'TODAY') {
                    $query .= "WHERE registerDate = date(now()) AND email LIKE '%$email%' $send_users_ch ORDER BY id";
                }
                if($data_mode == 'YESTERDAY') {
                    $query .= "WHERE registerDate = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND email LIKE '%$email%' $send_users_ch ORDER BY id";
                }
                if($data_mode == 'WEEK') {
                    $query .= "WHERE (registerDate >= NOW()-INTERVAL 7 DAY) AND email LIKE '%$email%' $send_users_ch ORDER BY id";
                }
            }
            else {
                $query .= "WHERE email LIKE '%$email%' $send_users_ch ORDER BY id";
            }
        }
        $db->setQuery($query);
        $column= $db->loadRowList();
        
        $post_data = json_encode($column);
        
        echo json_encode($column);

        break;
    // Import
    case 'import':
        //Ключ доступа
        $api_key = $_SESSION['api_key'];
        //Get destination
        $destination = htmlspecialchars($_POST['destination']);
        //Get nickname
        $nickname = htmlspecialchars($_POST['nickname']);
        $nickname_arr = explode(",",$nickname);
        //Get email
        $email = htmlspecialchars($_POST['email']);
        $email_arr = explode(",",$email);
        //Import
        $import_data = array();
        $import_data['service_key'] = 'NLAMBua0b45mu03FAEGKA4qvunmJh3ss';
        //$import_data['format'] = 'JSON';
        $import_data['format'] = 'xml';
        $import_data['api_key'] = $api_key;
        $import_data['action'] = 'import';
        $import_data['email_source'] = 'otherservice';
        $import_data['details'] = 'Импорт пользователей используя smartresponder plugin.';

        $subscribers = array();
        for($i = 0; $i < count($nickname_arr); $i++){
            for($i = 0; $i < count($email_arr); $i++) {
                $subscribers[] = $email_arr[$i].";".$nickname_arr[$i].";;;;;;;;;;";
            } 
        }

        $import_data['input_data'] = implode("\n", $subscribers);
        $import_data['destination'] = $destination;
        $import_data['description'] = 'Импорт пользователей используя smartresponder plugin.';
        $import_data['charset'] = 'utf-8';

        $link = 'http://smartresponder.ru/api/import.html';

        $result = sr_get_content($link, $import_data);

        $result = trim($result);
        //End import
        $tmp_result = simplexml_load_string($result);
        $result = json_encode($tmp_result);

        echo $result;

        break;
    // Result
    case 'result':
        //Ключ доступа
        $api_key = $_SESSION['api_key'];
        //import_key
        $import_key = htmlspecialchars($_POST['import_key']);

        //Import
        $import_data2 = array();
        $import_data2['service_key'] = 'NLAMBua0b45mu03FAEGKA4qvunmJh3ss';
        $import_data2['format'] = 'xml';
        $import_data2['import_key'] = $import_key;
        $import_data2['action'] = 'result';
        $import_data2['api_key'] = $api_key;

        $link = 'http://smartresponder.ru/api/import.html';

        $result2 = sr_get_content($link, $import_data2);

        $result2 = trim($result2);
        $tmp_result = simplexml_load_string($result2);
        $result2 = json_encode($tmp_result);
        //End import

        echo $result2;

        break;
};

?>