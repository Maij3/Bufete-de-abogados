<?php defined('_JEXEC') or die;
/**
 * @copyright   Copyright (C) 2014 jnilla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
 */



defined('JPATH_BASE') or die;

/**
 * Main plugin class.
 *
 */
class plgSystemJnOpenGraph extends JPlugin {
	
	// Contructor
	public function __construct(& $subject, $config) {
		parent::__construct($subject, $config);
	}
	
	// Content before render
	function onBeforeRender() {
		// Init
		$app = JFactory::getApplication();
		if($app->isAdmin()) return true;
		
		$menuItem = $app->getMenu()->getActive();
		if(!isset($menuItem)) return true;
		
		$input =  $app->input;
		$option = $input->get('option');
		$view = $input->get('view');
		$uri = JFactory::getURI();
		$base = $uri->base();
		$doc = JFactory::getDocument();
		
		// Collect site data
		$siteConfig = JFactory::getConfig();
		$siteName = $siteConfig->get('sitename');
		$siteName = trim($siteName);
		
		// Collect article data
		if ($option == 'com_content' && $view == 'article'){
			$isArticle = true;
			$articleId = $input->get('id');
			$article = self::getArticleData($articleId);
			$articleAttributes = json_decode($article['attribs'], true);
			
			$articleTitle = $article['title'];
			$articleTitle = trim($articleTitle);
			$articleText = $article['introtext']." ".$article['fulltext'];
			$articleText = trim($articleText);
			
			// Try to find an image
			$articleImages = json_decode($article['images'], true);
			if($articleImages['image_intro']){
				// try to find intro image
				$articleImage = $articleImages['image_intro'];
			}else{
				// try to find full image
				if($articleImages['image_fulltext']){
					$articleImage = $articleImages['image_fulltext'];
				}else{
					// try to find an image on article text
					$articleImages = $articleText;
					preg_match_all('/<\s*img(.*)\/>/i', $articleImages, $articleImages);
					$articleImages = $articleImages[0][0];
					preg_match_all('/src\s*=\s*(["\'])(.*?)\1/i', $articleImages, $articleImages);
					$articleImage = $articleImages[2][0];
				}
			}
		}
		
		// Collect menu item data
		$menuItemTitle = $menuItem->title;
		$menuItemTitle = trim($menuItemTitle);
		$menuItemPageTitle = $menuItem->params->get('page_title');
		$menuItemPageTitle = trim($menuItemPageTitle);
		// page title overrides item title
		if($menuItemPageTitle != "") $menuItemTitle = $menuItemPageTitle;
		
		// Collect OpenGraph data
		$menuItemFacebookOgSiteName = $menuItem->params->get('facebook_og_site_name');
		$menuItemFacebookOgTitle = $menuItem->params->get('facebook_og_title');
		$menuItemFacebookOgDescription = $menuItem->params->get('facebook_og_description');
		$menuItemFacebookOgImage = $menuItem->params->get('facebook_og_image');
		
		$menuItemTwitterSite = $menuItem->params->get('twitter_site');
		$menuItemTwitterTitle = $menuItem->params->get('twitter_title');
		$menuItemTwitterDescription = $menuItem->params->get('twitter_description');
		$menuItemTwitterImage = $menuItem->params->get('twitter_image');
		
		
		if($isArticle){
			$articleFacebookOgSiteName = $articleAttributes['facebook_og_site_name'];
			$articleFacebookOgTitle = $articleAttributes['facebook_og_title'];
			$articleFacebookOgDescription = $articleAttributes['facebook_og_description'];
			$articleFacebookOgImage = $articleAttributes['facebook_og_image'];
			
			$articleTwitterSite = $articleAttributes['twitter_site'];
			$articleTwitterTitle = $articleAttributes['twitter_title'];
			$articleTwitterDescription = $articleAttributes['twitter_description'];
			$articleTwitterImage = $articleAttributes['twitter_image'];
		}
		
		// Compiles data (calculates inheritances and overrides)
		
		// og:url
		$ogUrl = $uri->toString();
		
		// og:site_name
		$ogSiteName = $siteName;
		
		if($articleFacebookOgSiteName != ""){
			$ogSiteName = $articleFacebookOgSiteName;
		}
		
		if($menuItemFacebookOgSiteName != ""){
			$ogSiteName = $menuItemFacebookOgSiteName;
		}
		
		// og:type
		$ogType = "article";
		
		// og:title
		$ogTitle = "";
		
		if($isArticle){
			$ogTitle = $articleTitle;
		}else{
			$ogTitle = $menuItemTitle;
		}
		
		if($articleFacebookOgTitle != ""){
			$ogTitle = $articleFacebookOgTitle;
		}
		
		if($menuItemFacebookOgTitle != ""){
			$ogTitle = $menuItemFacebookOgTitle;
		}
		
		// og:description
		$ogDescription = "";
		
		if($isArticle){
			$ogDescription = $articleText;
		}
		
		if($articleFacebookOgDescription != ""){
			$ogDescription = $articleFacebookOgDescription;
		}
		
		if($menuItemFacebookOgDescription != ""){
			$ogDescription = $menuItemFacebookOgDescription;
		}
		
		$ogDescription = strip_tags($ogDescription);
		$ogDescription = JHtml::_('string.truncate', $ogDescription, 280);
		$ogDescription = htmlentities($ogDescription);
		
		// og:image
		$ogImage = "";
		
		if($isArticle){
			$ogImage = $articleImage;
		}
		
		if($articleFacebookOgImage != ""){
			$ogImage = $articleFacebookOgImage;
		}
		
		if($menuItemFacebookOgImage != ""){
			$ogImage = $menuItemFacebookOgImage;
		}
		
		// twitter:site
		$twitterSite = "";
		
		if($articleTwitterSite != ""){
			$twitterSite = $articleTwitterSite;
		}
		
		if($menuItemTwitterSite != ""){
			$twitterSite = $menuItemTwitterSite;
		}
		
		// twitter:card
		$twitterCard = "summary";
		
		// twitter:title
		$twitterTitle = $ogTitle;
		
		if($articleTwitterTitle != ""){
			$twitterTitle = $articleTwitterTitle;
		}
		
		if($menuItemTwitterTitle != ""){
			$twitterTitle = $menuItemTwitterTitle;
		}
		
		// twitter:description
		$twitterDescription = $ogDescription;
		
		if($articleTwitterDescription != ""){
			$twitterDescription = $articleTwitterDescription;
		}
		
		if($menuItemTwitterDescription != ""){
			$twitterDescription = $menuItemTwitterDescription;
		}
		
		// twitter:image
		$twitterImage = $ogImage;
		
		if($articleTwitterImage != ""){
			$twitterImage = $articleTwitterImage;
		}
		
		if($menuItemTwitterImage != ""){
			$twitterImage = $menuItemTwitterImage;
		}
		
		// Append tags to header
		
		// Facebook
		
		$doc->addCustomTag('<meta property="og:url" content="'.$ogUrl.'" />');
		
		if($ogSiteName != ""){
			$doc->addCustomTag('<meta property="og:site_name" content="'.$ogSiteName.'" />');
		}
		
		$doc->addCustomTag('<meta property="og:type" content="'.$ogType.'" />');
		
		if($ogTitle != ""){
			$doc->addCustomTag('<meta property="og:title"  content="'.$ogTitle.'" />');
		}
		
		if($ogDescription != ""){
			$doc->addCustomTag('<meta property="og:description" content="'.$ogDescription.'" />');
		}
		
		if($ogImage != ""){
			$doc->addCustomTag('<meta property="og:image" content="'.$base.$ogImage.'" />');
			$doc->addCustomTag('<link rel="image_src" href="'.$base.$ogImage.'" />');
		}
		
		// Twitter
		
		if($twitterSite != ""){
			$doc->addCustomTag('<meta name="twitter:site" content="'.$twitterSite.'" />');
		}
		
		$doc->addCustomTag('<meta name="twitter:card" content="'.$twitterCard.'">');
		
		if($twitterTitle != ""){
			$doc->addCustomTag('<meta name="twitter:title" content="'.$twitterTitle.'" />');
		}
		
		if($twitterDescription != ""){
			$doc->addCustomTag('<meta name="twitter:description" content="'.$twitterDescription.'" />');
		}
		
		if($twitterImage != ""){
			$doc->addCustomTag('<meta name="twitter:image" content="'.$base.$twitterImage.'" />');
		}
		
		
		
	}
	
	//Content prepare form event
	public function onContentPrepareForm($form, $data){
		$app = JFactory::getApplication();
		if(!$app->isAdmin()) return true;
		
		// check if object is a form
		if (!($form instanceof JForm)){
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}
		
		// init
		JForm::addFormPath(__DIR__.'/forms');
		
		// load article form
		if ($form->getName() == "com_content.article"){
			$form->loadFile("article", false);
		}
		
		// load menu item form
		if ($form->getName() == "com_menus.item"){
			$form->loadFile("menu-item", false);
		}
		
		return true;
	}
	
	
	// Get article data by id
	private function getArticleData($id){
		if(is_null($id) || empty($id)) return;
		
		$db = JFactory::getDBO();
		$db->setQuery("
			SELECT *
			FROM #__content
			WHERE id = $id
		;");
		$db->query();
		
		return $db->loadAssoc();
	}
	
	
	// Get menu item data by id
	private function getMenuItemData($id){
		if(is_null($id) || empty($id)) return;
		
		$db = JFactory::getDBO();
		$db->setQuery("
			SELECT *
			FROM #__menu
			WHERE id = $id
		;");
		$db->query();
		
		return $db->loadAssoc();
	}
	
	
	
	
}






