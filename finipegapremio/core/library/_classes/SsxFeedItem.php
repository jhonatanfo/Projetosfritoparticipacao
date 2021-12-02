<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

class SsxFeedItem
{
	private $title;
	private $description;
	private $pubDate;
	private $link;
	
	/**
	 * Cria um elemento para ser adicionado no feed
	 * 
	 * @param $title string titulo do Item
	 * @param $description string Texto descritivo de no maximo 160 linhas
	 * @param $pubDate DATETIME exatamente no formato do Banco de Dados
	 * @param $link string url para o item
	 */
	public function SsxFeedItem($title, $description, $pubDate, $link)
	{
		$this->title = $title;
		$this->description = $description;
		$this->pubDate = $pubDate;
		$this->link = $link;
	}
	
	/**
	 * 
	 * @return string | Retorna a forma escrita desse elemento para ser enviado para a tela
	 */
	public function ToString()
	{
		$content = "<item>\n";
		$content .= " <title>".$this->title."</title>\n";
		$content .= " <link>".$this->link."</link>\n";
		$content .= " <description><![CDATA[".$this->description."]]></description>";
		$content .= " <pubDate>".date("D, d M Y H:i:s O", strtotime($this->pubDate))."</pubDate>\n";
		$content .= "</item>\n";
		return $content;
	}
} 