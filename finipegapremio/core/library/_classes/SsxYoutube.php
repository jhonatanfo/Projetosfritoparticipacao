<?php
/**
 * 
 * Adaptado ao Ssx por jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

define('YOUTUBE_VIDEO_INFO_URL', 'https://gdata.youtube.com/feeds/api/videos/');


class SsxYoutube {
	
	/**
	 * Retorna dados sobre o vídeo informado, fazendo uma requisição na api do youtube
	 * @param string $vid Id do Vídeo do Youtube
	 * @return stdClass|NULL
	 */
	public static function getVideoInfo($vid){
		
		$feedURL = YOUTUBE_VIDEO_INFO_URL . $vid;
	    
		$entry = simplexml_load_file($feedURL);
		
	    if(!empty($entry) && $entry instanceof SimpleXMLElement)
	    {
			return SsxYoutube::parseVideoEntry($entry);
	    }
	    return null;	
	}
	
	private static function parseVideoEntry($entry) 
	{      
      $obj= new stdClass;
      
      // get nodes in media: namespace for media information
      $media = $entry->children('http://search.yahoo.com/mrss/');
      $obj->title = (string)$media->group->title;
      $obj->description = (string)$media->group->description;
      
      // get video player URL
      $attrs = $media->group->player->attributes();
      $obj->watchURL = (string)$attrs['url']; 
      
      // get video thumbnail
      $attrs = $media->group->thumbnail[0]->attributes();
      $obj->thumbnailURL = (string)$attrs['url']; 
            
      // get <yt:duration> node for video length
      $yt = $media->children('http://gdata.youtube.com/schemas/2007');
      $attrs = $yt->duration->attributes();
      $obj->length = (string)$attrs['seconds']; 
      
      // get <yt:stats> node for viewer statistics
      $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
      $attrs = $yt->statistics->attributes();
      $obj->viewCount = (string)$attrs['viewCount']; 
      
      // get <gd:rating> node for video ratings
      $gd = $entry->children('http://schemas.google.com/g/2005'); 
      if ($gd->rating) { 
        $attrs = $gd->rating->attributes();
        $obj->rating = (string)$attrs['average']; 
      } else {
        $obj->rating = 0;         
      }
        
      // get <gd:comments> node for video comments
      $gd = $entry->children('http://schemas.google.com/g/2005');
      if ($gd->comments->feedLink) { 
        $attrs = $gd->comments->feedLink->attributes();
        $obj->commentsURL = (string)$attrs['href']; 
        $obj->commentsCount = (string)$attrs['countHint']; 
      }
      
      // get feed URL for video responses
      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/
      2007#video.responses']"); 
      if (count($nodeset) > 0) {
        $obj->responsesURL = (string)$nodeset[0]['href'];      
      }
         
      // get feed URL for related videos
      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/2007#video.related']"); 
      if (count($nodeset) > 0) {
        $obj->relatedURL = (string)$nodeset[0]['href'];      
      }
    
      // return object to caller  
      return $obj;      
    }
	
}
