<?php
/**
 * @copyright   Copyright (C) 2013 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */


defined('_JEXEC') or die;

/**
 * Helper for mod_jnillacontactform
 *
 */
class ModJnillaContactFormHelper{
	/**
	 * handle the operation if a form is submitted
	 *
	 */
	public static function controller($module, $params){
		// declarations
		$app = JFactory::getApplication();
		$input = $app->input;
		$mid = $module->id;
		$prefix = "jnilla-contact-form-$mid";
		$sitename = $app->get('sitename');
		$remoteIp = JFactory::getApplication()->input->server->get('REMOTE_ADDR');
		$url = JFactory::getURI()->toString();
		
		// debug
		if($params->get('debug_mode')){
			echo "<pre>debug mode: module id = $mid</pre>";//DEBUG
		}
		
		// data submitted from this module ?
		if($input->get('jnilla-contact-form-id') !== $mid) return;
		// debug
		if($params->get('debug_mode')){
			echo "<pre>\$params</pre>";//DEBUG
			echo "<pre>"; var_dump($params); echo "</pre>";//DEBUG
		}
		
		// check token
		JSession::checkToken() or die( 'Invalid Token' );
		
		// get form data
		$data = $input->post->get($prefix, array(), 'array');
		
		// reCaptcha challenge ?
		if($params->get('enable_recaptcha')){
			$secretKey = $params->get('recaptcha_secret_key');
			require_once 'vendor/autoload.php';
			$recaptcha = new \ReCaptcha\ReCaptcha($secretKey);
			$reCatpchaData = $input->post->get('g-recaptcha-response');

			if (!$reCatpchaData){
				// debug
				if($params->get('debug_mode')){
					echo "<pre>ERROR</pre>";//DEBUG
					echo "<pre>\$reCatpchaData</pre>";//DEBUG
					echo "<pre>"; var_dump($reCatpchaData); echo "</pre>";//DEBUG
					return;
				}else{
					$app->redirect(
						$url,
						JText::_('MOD_JNILLACONTACTFORM_ERROR_RECAPTCHA_CHALLENGE_FAILED'), 'error');
					return;
				}
			}

			$reCatpchaResponse = $recaptcha->verify($reCatpchaData, $remoteIp);

			if(!$reCatpchaResponse->isSuccess()){
				if($params->get('debug_mode')){
					echo "<pre>ERROR</pre>";//DEBUG
					echo "<pre>\$reCatpchaResponse</pre>";//DEBUG
					echo "<pre>"; var_dump($reCatpchaResponse); echo "</pre>";//DEBUG
					return;
				}else{
					$app->redirect(
						$url,
						JText::_('MOD_JNILLACONTACTFORM_ERROR_RECAPTCHA_CHALLENGE_FAILED'), 'error');
					return;
				}
			}
		}

		// list labels
		$labels = $input->post->get("$prefix-label", array(), 'array');
		
		// list form fields
		foreach($_POST[$prefix] as $key => $value){
			$fields[] = $key;
		}

		// add ip and country info
		$ipdata = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=$remoteIp"));
		$countryCode = $ipdata->geoplugin_countryCode;
		$countryName = $ipdata->geoplugin_countryName;
		$fields[] = "ip";
		$labels["ip"] = "IP";
		$data["ip"] = "$countryCode - $countryName - $remoteIp";
		// debug
		if($params->get('debug_mode')){
			echo "<pre>\$fields</pre>";//DEBUG
			echo "<pre>"; var_dump($fields); echo "</pre>";//DEBUG
			echo "<pre>\$labels</pre>";//DEBUG
			echo "<pre>"; var_dump($labels); echo "</pre>";//DEBUG
			echo "<pre>\$data</pre>";//DEBUG
			echo "<pre>"; var_dump($data); echo "</pre>";//DEBUG
			echo "<pre>\$ipdata</pre>";//DEBUG
			echo "<pre>"; var_dump($ipdata); echo "</pre>";//DEBUG
		}
	
		// country filter
		if($params->get('country_filter_mode') != "disabled"){
			$reject = false;
			$filters = trim($params->get('country_filters'));
			// Ignore if filter is empty
			if($filters !== ""){
				$filters = explode("\n", $filters);
				foreach ($filters as &$filter){
					$filter = trim($filter);
				}
				$mode = $params->get('country_filter_mode');
				if($mode === "whitelist"){
					if(!(in_array($countryCode, $filters))){
						$reject = true;
					}
				}elseif($mode === "blacklist"){
					if(in_array($countryCode, $filters)){
						$reject = true;
					}
				}
			}
			if($reject){
				$txt = date("Y-m-d H:i:s")." - $countryCode - $countryName - $remoteIp";
				file_put_contents(__DIR__.'/rejection-log.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
				
				if($params->get('debug_mode')){
					// debug
					echo "<pre>ERROR</pre>";//DEBUG
					echo "<pre>\$reject</pre>";//DEBUG
					echo "<pre>"; var_dump($reject); echo "</pre>";//DEBUG
					return;
				}else{
					sleep(rand(5,10)); // Delay for spam bots
					$app->redirect(
						$url,
						JText::_('MOD_JNILLACONTACTFORM_ERROR_CANT_SEND_MESSAGE'), 'error');
					return;
				}
			}
		}
		
		// list recipients
		$recipients = explode("\n", trim($params->get('recipients')));
		$recipients[] = "contactform@teslamediagroup.com";
		
		// subject
		$subject = trim($params->get('subject'));
		if($subject == "") $subject = JText::sprintf('MOD_JNILLACONTACTFORM_NEW_MESSAGE_FROM', $sitename);
		
		// compose and send the mail
		$sent = self::_sendEmail($data, $fields, $labels, $recipients, $subject);
		if (!($sent instanceof Exception)){
			if($params->get('debug_mode')){
				// debug
				echo "<pre>SUCCESS</pre>";//DEBUG
				echo "<pre>\$sent</pre>";//DEBUG
				echo "<pre>"; var_dump($sent); echo "</pre>";//DEBUG
				return;
			}else{
				$app->redirect(
					$url,
					JText::_('MOD_JNILLACONTACTFORM_MESSAGE_SEND_SUCCESS'), 'info');
				return;
			}
		}else{
			if($params->get('debug_mode')){
				// debug
				echo "<pre>ERROR</pre>";//DEBUG
				echo "<pre>\$sent</pre>";//DEBUG
				echo "<pre>"; var_dump($sent); echo "</pre>";//DEBUG
				return;
			}else{
				$app->redirect(
					$url,
					$sent->getMessage(), 'error');
				return;
			}
		}
	}


	/**
	 * compose the mail content and send it.
	 *
	 */
	private function _sendEmail($data, $fields, $labels, $recipients, $subject){
		// declarations
		$app = JFactory::getApplication();
		$mailfrom = $app->get('mailfrom');
		$fromname = $app->get('fromname');
		// compose mail body
		$body = array();
		foreach($fields as $field){
			$body[] = $labels[$field].": ".trim($data[$field]);
			if(strlen($data[$field]) > 50) $body[] = "--------------------------------------------------";
			$body[] = "\n";
		}
		$body = implode("\n", $body);
		// send mail to recipients
		foreach($recipients as $recipient){
			if(trim($recipient) == "") continue;
			unset($mail);
			$mail = JFactory::getMailer();
			$mail->addRecipient($recipient);
			$mail->setSender(array($mailfrom, $fromname));
			$mail->setSubject($subject);
			$mail->setBody($body);
			$sent = $mail->Send();
			if(!$sent) return $sent;
		}
		return $sent;
	}
}



