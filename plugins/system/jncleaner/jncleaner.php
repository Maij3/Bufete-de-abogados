<?php defined('_JEXEC') or die;
/**
 * @copyright   Copyright (C) 2018 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */


class plgSystemJnCleaner extends JPlugin {
    public function __construct(& $subject, $config) {
        parent::__construct($subject, $config);
    }
    
    public function onAfterInitialise() {
        $doc = JFactory::getDocument();
        $user = JFactory::getUser();
        
        // Check timer
        $interval = $this->params->get('interval', 168)*60*60;
        $timer = (float)@file_get_contents(__DIR__."/timer.txt");
        $timer = microtime(true) - $timer;
        if(($timer >= $interval) || $this->params->get('debugMode')){
            // Create ajax callback
            $doc->addScriptDeclaration("
                (function($){
                	$(document).ready(function(){
                		$.get('index.php?jn-cleaner-run=true');
                	});
                })(jQuery);
            ");
            if($this->params->get('debugMode')){
                if(!$user->guest){
                    echo "<pre>Jn Cleaner | Debug mode is on</pre>";  // DEBUG
                    echo "<pre>Timer: $timer</pre>";  // DEBUG
                    echo "<pre>Interval: $interval</pre>";  // DEBUG
                }
            }
        }else{
            return;
        }
        
        $input = JFactory::getApplication()->input;
        
        // Check ajax callback var
        if(!$this->params->get('debugMode')){
            if($input->get('jn-cleaner-run') != "true") return;
            // Update timer
            file_put_contents(__DIR__.'/timer.txt', microtime(true));
        }
        
        $siteRoot = JPATH_SITE;
        $rules = array();
        $files = array();
        
        // Process Rules
        $ruleItems = file_get_contents(__DIR__."/rules.txt");
        $ruleItems = $ruleItems."\n".$this->params->get('rules');
        $ruleItems = explode("\n", $ruleItems);
        
        foreach ($ruleItems as $ruleItem) {
            // Normalize string
            $ruleItem = trim($ruleItem);
            // Skipt if line is a comment
            if(@$ruleItem[0] == "#") continue;
            $args = explode(":", $ruleItem, 2);
            // Skip if there aren't 2 arguments
            if(count($args) != 2) continue;
            
            $type = trim($args[0]);
            $rule = trim($args[1]);
            
            $rules[$type][] = $rule;
        }
        
        // Remove duplicates
        $rules["ignore"] =  array_unique($rules["ignore"]);
        $rules["delete"] =  array_unique($rules["delete"]);
        
        // Create list of files to ignore
        $files["ignore"] = array();
        foreach ($rules["ignore"] as $rule) {
            $files["ignore"] = array_merge($files["ignore"], $this->cglob("$siteRoot/$rule"));
        }
        
        // Create list of files to delete
        $files["delete"] = array();
        foreach ($rules["delete"] as $rule) {
            $files["delete"] = array_merge($files["delete"], $this->cglob("$siteRoot/$rule"));
        }
        
        // Remove ignore items from delete array
        $files["delete"] = array_diff($files["delete"], $files["ignore"]);
        
        // Delete files
        if(!$this->params->get('debugMode')){
            foreach ($files["delete"] as $file) {
                // Skipt if not a file
                if(!is_file($file)) continue;
                // Delete file
                @unlink($file);
            }
        }
        
        // Save to log
        if(!$this->params->get('debugMode') && count($files["delete"])){
            $log = array();
            $log[] = "======================";
            $log[] = date("Y-m-d H:i:s");
            $log[] = "Timer: $timer";
            $log[] = "Interval: $interval";
            $log[] = "======================";
            $log[] = "--Ignore";
            $log = array_merge($log, $files["ignore"]);
            $log[] = "--Delete";
            $log = array_merge($log, $files["delete"]);
            $log[] = "\n\n\n\n";
            $log = implode("\n", $log);
            file_put_contents(__DIR__.'/log.txt', $log.PHP_EOL , FILE_APPEND | LOCK_EX);
        }
        
        // Display debug data
        if($this->params->get('debugMode')){
            if(!$user->guest){
                echo "<pre>Rules:</pre>";  // DEBUG
                echo "<pre>"; var_dump($rules); echo "</pre>";  // DEBUG
                echo "<pre>Files:</pre>";  // DEBUG
                echo "<pre>"; var_dump($files); echo "</pre>";  // DEBUG
            }
        }else{
            die;
        }
    }
    
    
    // Custom glob implementation
    function cglob ($pattern, $flags = 0, $traversePostOrder = false) {
        // Do normal glob if there is no ** wildcard
        if (strpos($pattern, '/**/') === false) {
            return glob($pattern, $flags);
        }
        
        // Support ** wildcard
        $patternParts = explode('/**/', $pattern);
        // Get sub dirs
        $dirs = glob($patternParts[0].'/*', GLOB_ONLYDIR | GLOB_NOSORT);
        // Get files for current dir
        $files = glob($patternParts[0].'/'.$patternParts[1], $flags);
        foreach ($dirs as $dir) {
            $subDirContent = $this->cglob($dir.'/**/'.$patternParts[1], $flags, $traversePostOrder);
            if (!$traversePostOrder) {
                $files = array_merge($files, $subDirContent);
            } else {
                $files = array_merge($subDirContent, $files);
            }
        }
        return $files;
    }
    
    
}









