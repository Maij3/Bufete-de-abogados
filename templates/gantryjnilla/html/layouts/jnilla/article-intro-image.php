<?php
defined('JPATH_BASE') or die;

// init
$item = $displayData["item"];
$params  = $displayData["params"];
$images = json_decode($item->images);
$attr = $displayData["attr"];
$id = $item->id;

// try to find intro image
if($images->image_intro)
{
	$image = $images->image_intro;
	if($images->image_intro_alt) $image_title = $images->image_intro_alt;
}
else
{
	// try to find full image
	if($images->image_fulltext)
	{
		$image = $images->image_intro;
		if($images->image_fulltext_alt) $image_title = $images->image_fulltext_alt;
	}
	else
	{
		// try to find first image on article text
		$content = $item->introtext." ".$item->fulltext;
		preg_match_all('/<\s*img(.*)\/>/i', $content, $content);
		$content = $content[0][0];
		preg_match_all('/src\s*=\s*(["\'])(.*?)\1/i', $content, $content);
		$image = $content[2][0];
		if($image)
		{
			$image_title = $item->title;
			// update intro image
			$db = JFactory::getDbo();
			$images->image_intro = $image;
			$images = $db->escape(json_encode($images));
			$db->setQuery("
				UPDATE #__content
				SET images = '$images'
				WHERE id = $id;
			");
			$db->execute();
		}
		else
		{
			// try youtube
			if($images->media_embed_code)
			{
				$content = $images->media_embed_code;
			}
			else
			{
				$content = $item->introtext." ".$item->fulltext;
			}
			// get poster url
			preg_match_all('/www\.youtube\.com.embed\/([^\&\?\/"]+)/i', $content, $content);
			$image = $content[1][0];
			if($image)
			{
				$image = "https://img.youtube.com/vi/$image/hqdefault.jpg";
				$image_title = $item->title;
				// update intro image
				$db = JFactory::getDbo();
				$images->image_intro = $image;
				$images = $db->escape(json_encode($images));
				$db->setQuery("
					UPDATE #__content
					SET images = '$images'
 					WHERE id = $id;
				");
				$db->execute();
			}
			else
			{
				// try vimeo
				if($images->media_embed_code)
				{
					$content = $images->media_embed_code;
				}
				else
				{
					$content = $item->introtext." ".$item->fulltext;
				}
				// get poster url
				preg_match_all('/player\.vimeo\.com\/video\/([^\&\?\/"]+)/i', $content, $content);
				$image = $content[1][0];
				if($image)
				{
					$image = @file_get_contents("http://vimeo.com/api/v2/video/$image.json");
					if($image)
					{
						$image = json_decode($image);
						$image = $image[0]->thumbnail_large;
						// update intro image
						$db = JFactory::getDbo();
						$images->image_intro = $image;
						$images = $db->escape(json_encode($images));
						$db->setQuery("
							UPDATE #__content
							SET images = '$images'
							WHERE id = $id;
						");
						$db->execute();
					}
				}
			}
		}
	}
}
if(!$image)
{
	// set default placeholder
	$image = "images/article-intro-default.png";
	$image_title = $item->title;
}
?>
<img src="<?php echo $image;?>" alt="<?php echo $image_title; ?>" <?php echo $attr; ?>>

