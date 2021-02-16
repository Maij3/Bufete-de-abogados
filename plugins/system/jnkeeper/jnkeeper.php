<?php defined('_JEXEC') or die;
/**
 * @copyright   Copyright (C) 2019 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */

defined('JPATH_BASE') or die;


require_once __DIR__.'/helper.php';
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;


/**
 * Jn Keeper plugin class.
 */
class plgSystemJnKeeper extends CMSPlugin {
    /**
     * Constructor.
     */
    public function __construct(& $subject, $config) {
        parent::__construct($subject, $config);
    }
    
    /**
	 * After Initialise Event.
	 */
    public function onAfterInitialise() {
        $helper = new plgSystemJnKeeperHelper;
        $app = Factory::getApplication();
        //$isAdmin = $app->isClient('administrator');
        $changes = [];
        $changes['site_path'] = $helper::checkSnapshot('site_path', JPATH_SITE, true);
        $changes['log_path'] = $helper::checkSnapshot('log_path', $app->get('log_path'), true);
        $changes['tmp_path'] = $helper::checkSnapshot('tmp_path', $app->get('tmp_path'), true);
        
        // Notify if installation path changes
        if($changes['site_path']){
            $app->enqueueMessage('Jn Keeper: Site path change detected');
        }
        
        // Notify if $log_path changes
        if($changes['log_path']){
            $app->enqueueMessage('Jn Keeper: $log_path change detected');
        }
        
        // Set automatic $log_path
        if($this->params->get('automatic_log_path', 1) == 1){
            if($changes['site_path'] || $changes['log_path']){
                $path = JPATH_SITE.'/administrator/logs';
                $helper::setSiteConfiguration('log_path', $path);
                $cleanCache = true;
                $app->enqueueMessage('Jn Keeper: $log_path updated');
            }
        }
        
        // Notify if $tmp_path changes
        if($changes['tmp_path']){
            $app->enqueueMessage('Jn Keeper: $tmp_path change detected');
        }
        
        // Set automatic $tmp_path
        if($this->params->get('automatic_tmp_path', 1) == 1){
            if($changes['site_path'] || $changes['tmp_path']){
                $path = JPATH_SITE."/tmp";
                $helper::setSiteConfiguration('tmp_path', $path);
                $cleanCache = true;
                $app->enqueueMessage('Jn Keeper: $tmp_path updated');
            }
        }
        
        // Clean cache
        if($cleanCache){
            try {
                Factory::getCache()->clean();
                $app->enqueueMessage("Jn Keeper: Site cache cleaned");
            }catch (Exception $e){
                // Silence
            }
        }
    }
}


