<?php
/**
 * @copyright   Copyright (C) 2019 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */

defined('_JEXEC') or die;


/**
 * Jn Keeper Plugin Helper
 */
class plgSystemJnKeeperHelper{
    /**
     * Creates and/or checks if an interval has expired.
     * 
     * @param  string   $key      Interval key name.
     * @param  integer  $seconds  Expiration time in seconds.
     * @param  boolean  $first    If true the function will return true if 
     *                            the timer is created for the first time.
     * 
     * @return  boolean  True if interval expired.
     */
    public static function checkInterval($key, $seconds, $first = false){
        // Get data
        $filePath = __DIR__."/intervals.js";
        $snaptshots = @file_get_contents($filePath);
        $intervals = json_decode($intervals, true);
        $interval = $intervals[$key];
        $time = microtime(true);
        
        // Check if interval is being created for the first time
        if(!isset($interval)){
            $intervals[$key] = $time;
            $update = true;
            if($first) $expired = true;
        }else{
            // Check if interval expired
            if(($time-$interval) >= $seconds) {
                $intervals[$key] = $time;
                $expired = true;
                $update = true;
            }
        }
        
        // Update data
        if($update){
            $intervals = json_encode($intervals);
            file_put_contents($filePath, $intervals);
        }
        
        // Return value
        if($expired){
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * Creates and/or compares a snapshot of a value
     *
     * @param  string   $key      Value key name.
     * @param  integer  $value    Value to store.
     * @param  boolean  $first    If true the function will return true if 
     *                            the snapshot is created for the first time.
     * 
     * @return  boolean  True if interval expired.
     */
    public static function checkSnapshot($key, $value, $first = false){
        // Get data
        $filePath = __DIR__."/snapshots.js";
        $snaptshots = @file_get_contents($filePath);
        $snaptshots = json_decode($snaptshots, true);
        $snaptshot = $snaptshots[$key];
        
        // Check if snapshot is being created for the first time
        if(!isset($snaptshot)){
            $snaptshots[$key] = $value;
            $update = true;
            if($first) $changed = true;
        }else{
            // Check if snapshot changed
            if($snaptshot != $value) {
                $snaptshots[$key] = $value;
                $changed = true;
                $update = true;
            }
        }
        
        // Update data
        if($update){
            $snaptshots = json_encode($snaptshots);
            file_put_contents($filePath, $snaptshots);
        }
        
        // Return value
        if($changed){
            return true;
        }else{
            return false;
        }
    }
    
    
	/**
     * Set values on the site configuration file.
     * 
     * @param  string  $key    Configuration key name.
     * @param  string  $value  Configuration value.
     * 
     * @return  boolean  True if success
     */
	public static function setSiteConfiguration($key, $value){
	    // Get data
	    $filePath = JPATH_CONFIGURATION.'/configuration.php';
	    $configuration = @file_get_contents($filePath);
	    
	    // Makes file writable
	    @chmod($filePath, 0644);
	    
	    // Prepare new value
	    $value = addslashes($value);
	    $value = str_replace("'", "\'", $value);
	    $val = "public $$key = '$value';";

	    // Replace old value
	    $re = '/public \$'.$key.' = \'((?:\\\\\'|[^\'])*)\';/i';
	    $configuration = preg_replace($re, $val, $configuration);
	    
	    // Store changes
	    @file_put_contents($filePath, $configuration);
	}
	
}







