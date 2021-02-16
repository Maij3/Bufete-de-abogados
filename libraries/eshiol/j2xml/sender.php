<?php
/**
 * @version		16.5.281 libraries/eshiol/j2xml/sender.php
 * @package		J2XML
 * @subpackage	lib_j2xml
 * @since		1.5.3beta3.38
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2010, 2016 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * J2XML is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access.');

// Includes the required class file for the XML-RPC Client
jimport('eshiol.core.xmlrpc');

jimport('eshiol.j2xml.messages');
jimport('eshiol.j2xml.version');

class J2XMLSender
{
	private static $codes = array(
		'message',		// LIB_J2XML_MSG_ARTICLE_IMPORTED
		'notice',		// LIB_J2XML_MSG_ARTICLE_NOT_IMPORTED
		'message',  	// LIB_J2XML_MSG_USER_IMPORTED
		'notice',		// LIB_J2XML_MSG_USER_NOT_IMPORTED
		//'message',	// LIB_J2XML_MSG_SECTION_IMPORTED
		//'notice',		// LIB_J2XML_MSG_SECTION_NOT_IMPORTED
		6=>'message',	// LIB_J2XML_MSG_CATEGORY_IMPORTED
		'notice',		// LIB_J2XML_MSG_CATEGORY_NOT_IMPORTED
		'message',		// LIB_J2XML_MSG_FOLDER_WAS_SUCCESSFULLY_CREATED
		'notice',		// LIB_J2XML_MSG_ERROR_CREATING_FOLDER
		'message',		// LIB_J2XML_MSG_IMAGE_IMPORTED
		'notice',		// LIB_J2XML_MSG_IMAGE_NOT_IMPORTED
		'message',		// LIB_J2XML_MSG_WEBLINK_IMPORTED
		'notice',		// LIB_J2XML_MSG_WEBLINK_NOT_IMPORTED
		//'notice',		// LIB_J2XML_MSG_WEBLINKCAT_NOT_PRESENT
		15 => 'error',		// LIB_J2XML_MSG_XMLRPC_NOT_SUPPORTED
		'notice',		// LIB_J2XML_MSG_CATEGORY_ID_PRESENT
		'error',		// LIB_J2XML_MSG_FILE_FORMAT_NOT_SUPPORTED
		'error',		// LIB_J2XML_MSG_FILE_FORMAT_UNKNOWN
		'error',		// JERROR_ALERTNOTAUTH
		'message',		// LIB_J2XML_MSG_TAG_IMPORTED
		'notice',		// LIB_J2XML_MSG_TAG_NOT_IMPORTED
		'message',		// LIB_J2XML_MSG_CONTACT_IMPORTED
		'notice',		// LIB_J2XML_MSG_CONTACT_NOT_IMPORTED
		'message',		// LIB_J2XML_MSG_VIEWLEVEL_IMPORTED
		'notice',		// LIB_J2XML_MSG_VIEWLEVEL_NOT_IMPORTED
		'message',		// LIB_J2XML_MSG_BUTTON_IMPORTED
		'notice',		// LIB_J2XML_MSG_BUTTON_NOT_IMPORTED
	);	
	
	/*
	 * Send data
	 * @param $xml		data
	 * @param $debug
	 * @param $export_gzip
	 * @param $sid		remote server id
	 * @since		1.5.3beta3.38
	 */
	static function send($xml, $options, $sid)
	{
		JLog::add(new JLogEntry(__METHOD__,JLOG::DEBUG,'lib_j2xml'));
		$app = JFactory::getApplication();
		/*
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('element'));
		$query->from($db->quoteName('#__extensions'));
		$query->where($db->quoteName('type') . ' = ' . $db->quote('library'));
		$query->where($db->quoteName('element') . ' = ' . $db->quote('xmlrpc'));
		$query->where($db->quoteName('enabled') . ' = 1');
		$db->setQuery($query);
		$xmlrpclib = ($db->loadResult() != null);

		if (!$xmlrpclib)
		{
			// Merge the default translation with the current translation
			$jlang = JFactory::getLanguage();
			// Back-end translation
			$jlang->load('lib_j2xml', JPATH_SITE, 'en-GB', true);
			$jlang->load('lib_j2xml', JPATH_SITE, $jlang->getDefault(), true);
			$jlang->load('lib_j2xml', JPATH_SITE, null, true);
			
			$app->enqueueMessage(JText::_('LIB_J2XML_XMLRPC_ERROR'), 'error');
			return;
		}
*/
/*
		if ($debug > 0)
		{
			$data = ob_get_contents();
			if ($data)
			{	
				$app->enqueueMessage(JText::_('LIB_J2XML_MSG_ERROR_EXPORT'), 'error');
					$app->enqueueMessage($data, 'error');
				return false;
			}
		}		
*/		
		ob_clean();
		
		$version = explode(".", J2XMLVersion::$DOCVERSION);
		$xmlVersionNumber = $version[0].$version[1].substr('0'.$version[2], strlen($version[2])-1);
		
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($xml->asXML());
		$data = $dom->saveXML();
		
		// modify the MIME type
		//$document = JFactory::getDocument();
		if ($options['gzip'])
		{
//			$document->setMimeEncoding('application/gzip-compressed', true);
//			JResponse::setHeader('Content-disposition', 'attachment; filename="j2xml'.$xmlVersionNumber.date('YmdHis').'.gz"', true);
			$data = gzencode($data, 9);
		}
		/*
		else 
		{
			$document->setMimeEncoding('application/xml', true);
			JResponse::setHeader('Content-disposition', 'attachment; filename="j2xml'.$xmlVersionNumber.date('YmdHis').'.xml"', true);
		}
		*/
		$db = JFactory::getDBO();
		$query = 'SELECT `title`, `remote_url`, `username`, `password` '
			. 'FROM `#__j2xml_websites` WHERE `state`= 1 AND `id` = '.$sid;
		$db->setQuery($query);
		$server = $db->loadAssoc();		

		if (!$server) return;
		
		$str = $server['remote_url'];

		if (strpos($str, "://") === false)
			$server['remote_url'] = "http://".$server['remote_url'];
				
		if ($str[strlen($str)-1] != '/')
			$server['remote_url'] .= '/';
		$server['remote_url'] .= 'index.php?option=com_j2xml&task=cpanel.import&format=xmlrpc';

		$res = 
			self::_xmlrpc_j2xml_send(
				$server['remote_url'], 
				$data, 
				$server['username'], 
				$server['password'], 
				$options['debug']
			);
		JLog::add(new JLogEntry(print_r($res, true),JLOG::DEBUG,'lib_j2xml'));
		if ($res->faultcode())
			$app->enqueueMessage($server['title'].': '.JText::_($res->faultString()), 'error');
		else
		{
			$msgs = $res->value();
			$len=$msgs->arraysize();
			for ($i = 0; $i < $len; $i++)
			{
				$msg=$msgs->arraymem($i);
				$code = $msg->structmem('code')->scalarval();
				$string = $msg->structmem('string')->scalarval();
				if (!isset(J2XMLMessages::$messages[$code]))
					$app->enqueueMessage($server['title'].': '.$msg->structmem('message')->scalarval(),'notice');
				elseif ($string)
					$app->enqueueMessage($server['title'].': '.JText::sprintf(J2XMLMessages::$messages[$code], $string), self::$codes[$code]);
				else
					$app->enqueueMessage($server['title'].': '.JText::_(J2XMLMessages::$messages[$code]), self::$codes[$code]);
			}
		}
	}

	/**
	* Send xml data to
	* @param string $remote_url
	* @param string $xml
	* @param string $username
	* @param string $password
	* @param int $debug when 1 (or 2) will enable debugging of the underlying xmlrpc call (defaults to 0)
	* @return xmlrpcresp obj instance
	*/
	private static function _xmlrpc_j2xml_send($remote_url, $xml, $username, $password, $debug=0) 
	{
		$protocol = '';
		$GLOBALS['xmlrpc_internalencoding'] = 'UTF-8';
		$client = new xmlrpc_client($remote_url);
		$client->return_type = 'xmlrpcvals';
		$client->request_charset_encoding = 'UTF-8';
		$client->user_agent = J2XMLVersion::$PRODUCT.' '.J2XMLVersion::getFullVersion();
		$client->setDebug($debug);
		$msg = new xmlrpcmsg('j2xml.import');
		$p1 = new xmlrpcval(base64_encode($xml), 'base64');
		$msg->addparam($p1);
		$p2 = new xmlrpcval($username, 'string');
		$msg->addparam($p2);
		$p3 = new xmlrpcval($password, 'string');
		$msg->addparam($p3);
		$res = $client->send($msg, 0);

		if (!$res->faultcode())
			return $res;
		
		if ($res->faultString() == "Didn't receive 200 OK from remote server. (HTTP/1.1 301 Foun)")
		{
			$res = $client->send($msg, 0, $protocol = 'http11');
			if (!$res->faultcode())
				return $res;
		}
		if ($res->faultString() == "Didn't receive 200 OK from remote server. (HTTP/1.1 303 See other)")
		{
			$headers = http_parse_headers($res->raw_data);
			$url = $headers['Location'];
			$parse = parse_url($url);
			if (!isset($parse['host']))
			{
				$parse = parse_url($remote_url);
				$url = $parse['scheme'].'://'.$parse['host'].$url;
			}
			$client = new xmlrpc_client($url);
			$client->return_type = 'xmlrpcvals';
			$client->request_charset_encoding = 'UTF-8';
			$client->user_agent = J2XMLVersion::$PRODUCT.' '.J2XMLVersion::getFullVersion();
			$client->setDebug($debug);
			$res = $client->send($msg, 0, $protocol);
		}
		return $res;
	}
}

if (!function_exists('http_parse_headers'))
{
	function http_parse_headers($raw_headers)
	{
		$headers = array();
		$key = '';

		foreach(explode("\n", $raw_headers) as $i => $h)
		{
			$h = explode(':', $h, 2);

			if (isset($h[1]))
			{
				if (!isset($headers[$h[0]]))
					$headers[$h[0]] = trim($h[1]);
				elseif (is_array($headers[$h[0]]))
				{
					$headers[$h[0]] = array_merge($headers[$h[0]], array(trim($h[1])));
				}
				else
				{
					$headers[$h[0]] = array_merge(array($headers[$h[0]]), array(trim($h[1]))); // [+]
				}
				$key = $h[0];
			}
			else
			{
				if (substr($h[0], 0, 1) == "\t")
					$headers[$key] .= "\r\n\t".trim($h[0]);
				elseif (!$key)
				$headers[0] = trim($h[0]);trim($h[0]);
			}
		}

		return $headers;
	}
}
?>