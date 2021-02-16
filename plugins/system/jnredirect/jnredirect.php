<?php defined('_JEXEC') or die;
/**
 * @copyright   Copyright (C) 2018 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */


defined('JPATH_BASE') or die;

class plgSystemJnRedirect extends JPlugin {
    public function __construct(& $subject, $config) {
        parent::__construct($subject, $config);
    }
    
    public function onAfterInitialise() {
        $app = JFactory::getApplication();
        
        // Exit if client is backend
        if($app->getClientId() == 1) return;
        
        $uri = JFactory::getURI();
        $url = $uri->toString();
        $baseUrl = $uri->base();
        $baseUrl = rtrim($baseUrl,"/");
        $ulrRel = preg_replace('/^'.preg_quote($baseUrl, '/').'/i', '', $url);
        $redirects = explode("\n", $this->params->get('redirects'));
        
        foreach ($redirects as $redirect) {
            $isMatch = false;
            
            // Normalize string
            $redirect = trim($redirect);
            $redirect = preg_replace('/\s+/i', ' ', $redirect);
            
            // Skipt if line is a comment
            if($redirect[0] == "#") continue;
            $items = explode(" ", $redirect);
            
            // Check regex mode
            if($items[0] == "regex"){
                // Skip if there aren't 4 items
                if(count($items) != 4) continue;
                $type = $items[1];
                $oldUrl = $items[2];
                $newUrl = $items[3];
                
                preg_match("/$oldUrl/", $url, $match);
                if($match) $isMatch = true;
            }else{
                // Skip if there aren't 3 items
                if(count($items) != 3) continue;
                
                $type = $items[0];
                $oldUrl = $items[1];
                $newUrl = $items[2];
                
                if($oldUrl == $url || $oldUrl == $ulrRel) $isMatch = true;
            }
            
            // Redirect if match
            if($isMatch){
                if($this->params->get('debugMode')){
                    echo "<pre>Jn Redirect | Debug Mode | Rule Match: $redirect</pre>";  // DEBUG
                }else{
                    // If newurl is relative make it absolute
                    if($newUrl[0] == "/") $newUrl = $baseUrl.$newUrl;
                    
                    // Redirect
                    header("Location: $newUrl", true, $type);
                }
                die();
            }
        }
    }
}


