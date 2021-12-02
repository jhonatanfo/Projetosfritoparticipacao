<?php
/**
 * Classe de controle de Feed do Ssx
 * É possível adicionar no feed os elementos
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

class SsxFeed
{
	
	private $rss_title;
	
	private $rss_description;
	
	private $rss_updatePeriod = "hourly";
	
	private $rss_updateFrequency = "1";
	
	private $rss_language = "en";
	
	private $rss_link;
	
	private $rss_items;
	
	private $items;
	
	public function setTitle($title)
	{
		if(!is_string($title))
			return false;

		$this->rss_title = $title;
		$this->items = array();
	}
	
	public function setDescription($description)
	{
		if(!is_string($description))
			return false;
			
		$this->rss_description = $description;
	}
	
	public function setLanguage($language)
	{
		if(!is_string($language))
			return false;
		
		$this->rss_language = $language;
	}
	
	public function setFeedItem(SsxFeedItem $item)
	{
		if(!$item)
			return false;
			
		array_push($this->items,$item);
	}
	
	public function setLink($link)
	{
		if(!is_string($link))
			return false;
			
		$this->rss_link = $link;
	}
	
	public function draw()
	{
		$content = "";
		
		$content .= "\n<title>".$this->rss_title."</title>\n";
		$content .= "<atom:link>".$this->rss_link."</atom:link>\n";
		$content .= "<description><![CDATA[".$this->rss_description."]]></description>\n";
		$content .= "<language>".$this->rss_language."</language>\n";
		$content .= "<sy:updatePeriod>".$this->rss_updatePeriod."</sy:updatePeriod>\n";
		$content .= "<sy:updateFrequency>".$this->rss_updateFrequency."</sy:updateFrequency>\n\n";
		
		if($this->items && count($this->items)>0)
		{
			foreach($this->items as $listing)
			{
				$content .= $listing->ToString();
			}
		}
		return $content;
	}
	
}

