<?php

/*
  Plugin Name: Yandex Site Search Pinger
  Plugin URI: http://site.yandex.ru/cms-plugins/
  Description: Плагин оповещает сервис Яндекс.Поиск для сайта о новых и измененных документах.
  Version: 1.3
  Author: ООО "ЯНДЕКС" / YANDEX LLC
  Author URI: http://www.yandex.ru/
  License: GNU/GPL

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import library dependencies
jimport('joomla.event.plugin');
jimport('joomla.version');

/**
 * Плагин оповещает сервис Яндекс.Поиск для сайта о новых и измененных документах.
 *
 * @author     ООО "ЯНДЕКС" / YANDEX LLC
 * @license    GNU/GPL
 * @version    1.3
 * @link       http://site.yandex.ru/cms-plugins/
 * @since      Joomla 1.6.x
 */
class plgContentPinger extends JPlugin
{
	/**
	 * onContentAfterSave event handler.
	 * 
	 * @param type $context Accepted contexts are 'com_content.article', 'com_content.form' or empty
	 * @param type $article Object or numeric
	 * @param type $isNew boolean
	 * @return boolean
	 */
	public function onContentAfterSave($context, $article, $isNew)
	{

		if ((!empty($context) && !in_array($context, array('com_content.article', 'com_content.form'))) || empty($article)) {
			return true;
		}

		$articleId = is_object($article) ?
			$article->id : (string) $article;

		$this->ping($articleId, $article);
		return true;
	}

	function get_date($date)
	{
		$timestamp = strtotime($date);
		$delta = $timestamp - time(); //gmmktime();
		return $delta;
	}

	/**
	 * onContentChangeState event handler.
	 * 
	 * @param type $context Accepted contexts are 'com_content.article', 'com_content.form' or empty
	 * @param type $pks Array of articles' keys
	 * @param type $value Not used
	 * @return boolean
	 */
	public function onContentChangeState($context, $pks, $value)
	{

		if (!empty($context) && !in_array($context, array('com_content.article', 'com_content.form'))) {
			return true;
		}

		$articleId = $pks[0];
		$this->ping($articleId);
		return true;
	}

	/**
	 * Sends the "ping" to yandex service.
	 * 
	 * @param type $articleId ID of an article has been modified
	 * @param type $article Not used
	 * @param type $params Not used
	 * @return boolean
	 */
	function ping($articleId, $article = null, $params = null)
	{
		$key = $this->params->get("yakey");
		$yalogin = $this->params->get("yalogin");
		$searchId = $this->params->get("yasearchid");
		$pluginId = $this->params->get("pluginid");

		//Getting plugin params
		$pluginName = $this->_name;

		$jv = new JVersion();
		$cmsver = $jv->getShortVersion();
		//Getting article status
		$database = JFactory::getDBO();

		$database->setQuery("SELECT access, publish_up, state FROM #__content WHERE id='$articleId'");
		$articleInfo = $database->loadAssoc();


		$url = JUri::root() . "index.php?option=com_content&view=article&id=$articleId";


		if (($articleInfo['access'] == 1) && ($articleInfo['state'] == 1)) {
			$postdata = http_build_query(array(
				'key' => urlencode($key),
				'login' => urlencode($yalogin),
				'search_id' => urlencode($searchId),
				'pluginid' => urlencode($pluginId),
				'cmsver' => $cmsver,
				'publishdate' => $this->get_date($articleInfo['publish_up']),
				'urls' => $url
				));

			$host = 'site.yandex.ru';
			$length = strlen($postdata);

			$out = "POST /ping.xml HTTP/1.1\r\n";
			$out .= "HOST: " . $host . "\r\n";
			$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$out .= "Content-Length: " . $length . "\r\n\r\n";
			$out .= $postdata . "\r\n\r\n";
			try {
				$errno = '';
				$errstr = '';
				$result = '';
				$socket = @fsockopen($host, 80, $errno, $errstr, 30);
				if ($socket) {
					if (!fwrite($socket, $out)) {
						throw new Exception("unable to write");
					} else {
						while ($in = @fgets($socket, 1024)) {
							$result.=$in;
						}
					}
				} else {
					throw new Exception("unable to create socket");
				}
				fclose($socket);
				$result_xml = array();
				preg_match('/(<.*>)/u', $result, $result_xml);
				if (count($result_xml) && function_exists('simplexml_load_string')) {
					$result = array_pop($result_xml);
					$xml = simplexml_load_string($result);

				if(isset( $xml -> error ) && isset( $xml -> error -> code)) {
					if($xml -> error -> code){
						$errorcode = (string)$xml -> error -> code;

						if (($errorcode=="ILLEGAL_VALUE_TYPE")||($errorcode=="SEARCH_NOT_OWNED_BY_USER")||($errorcode=="NO_SUCH_USER_IN_PASSPORT"))
							$message = "Один или несколько параметров в настройках плагина указаны неверно - ключ (key), логин (login) или ID поиска (searchid).";
						elseif ($errorcode == "TOO_DELAYED_PUBLISH")
							$message = "Максимальный срок отложенной публикации - 6 месяцев";
						elseif ($errorcode=="USER_NOT_PERMITTED")
						{
							$errorparam = (string)$xml -> error -> param;
							$errorvalue = (string)$xml -> error -> value;
							if ($errorparam=="key")
								$message = "Неверный ключ (key) ".$errorvalue.". Проверьте настройки плагина.";
							elseif ($errorparam=="ip")
								$message = "Запрос приходит с IP адреса ".$errorvalue.", который не указан в списке адресов в настройках вашего поиска";
							else
								$message = "Запрос приходит с IP адреса, который не указан в списке адресов в настройках вашего поиска, либо Вы указали неправильный ключ (key) в настройках плагина.";

						}
						else $message=$errorcode;
					}
				}
				elseif(isset($xml -> invalid)) {
					$invalidurl = $xml->invalid->url;
					$errorcode = $xml->invalid["reason"];
					if ($errorcode=="NOT_CONFIRMED_IN_WMC")
						$message = "Сайт не подтвержден в сервисе Яндекс.Вебмастер для указанного имени пользователя.";

					elseif ($errorcode=="OUT_OF_SEARCH_AREA")
						$message = "Адрес ".$invalidurl." не принадлежит области поиска вашей поисковой площадки.";

					elseif ($errorcode=="MALFORMED_URLS")
						$message = "Невозможно принять некорректный адрес: ".$invalidurl;
					
					else $message=$errorcode;
					
					} elseif( isset($xml -> added) 
					&& isset($xml -> added['count']) 
					&& $xml -> added['count'] >0) {
						$addedaddress = $xml->added->url;
						$message = "Плагин работает корректно. Последний принятый адрес: ".$addedaddress;
				}


					if (isset($message) && $message) {
						$this->params->set("message", $message);
						$paramsString = $this->params->toString();
						$database->setQuery(sprintf("UPDATE #__extensions SET params=%s WHERE element=%s", $database->Quote($paramsString), $database->Quote($pluginName)
							));
						$database->query();
					}
				}
				return true;
			} catch (exception $e) {
				return false;
			}
			return false;
		}
	}

}
