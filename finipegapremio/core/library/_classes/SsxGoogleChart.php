<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */
class SsxGoogleChart
{
	private $charts;
	
	public function SsxGoogleChart()
	{
		global $Ssx;
		
		 $Ssx->themes->add_head_content("
		    <script type=\"text/javascript\">
		      google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});
		    </script>"); 
		 
		 load_js('https://www.google.com/jsapi', false);
	}
	
	
	public function barChart(array $keys, $values, $title_vertical="", $output_div="visualization", $title_horizontal="", $width=600, $height=400)
	{
		if(!$keys || !$values)
			return false;
		
		$keys_view = implode("','", $keys);
		$values_view = implode(",", $values);
		
		$this->charts[] = " 

        data = google.visualization.arrayToDataTable([
          ['Estados', '".$keys_view."'],
          ['', ".$values_view."],
        ]);
      
        new google.visualization.BarChart(document.getElementById('".$output_div."')).
            draw(data,
                 {title:\"\",
                  width:".$width.", height:".$height.",
                  vAxis: {title: \"".$title_vertical."\"},
                  hAxis: {title: \"".$title_horizontal."\"}}
            );
         ";
		return;
	}
	
	public function chartWrapper(array $keys, $values, $title, $output_div="visualization")
	{
		if(!$keys || !$values)
			return false;
		
		$keys_view = implode("','", $keys);
		$values_view = implode(",", $values);
		
		$this->charts[] = "
			  wrapper = new google.visualization.ChartWrapper({
			    chartType: 'ColumnChart',
			    dataTable: [['', '".$keys_view."'],
			                ['', ".$values_view."]],
			    options: {'title': '".$title."'},
			    containerId: '".$output_div."'
			  });
			  wrapper.draw();
		";
		return;
	}
	
	public function pieChart($data, $title, $output_view="visualization", $width=800, $height=400)
	{
		if(!is_array($data) || !$data)
			return;
			
		$data_array = array();
		
		foreach($data as $key => $row)
		{
			$data_array[] = "['".$key."', ".$row."]";
		}
		
		$content = implode(",\n",$data_array);
		
		$this->charts[] =
		"
			data = google.visualization.arrayToDataTable([
			    ['Task', 'Reports'],
			    ".$content."
			  ]);
			
			  // Create and draw the visualization.
			  new google.visualization.PieChart(document.getElementById('".$output_view."')).
			      draw(data, {title:'".$title."',
							  width:".$width.", height:".$height.", is3d:true});
		";
	}

	public function draw()
	{
		if(!is_array($this->charts) || !$this->charts)
			return "";
			
		$content = implode("\n\n", $this->charts);
		
		$function = "
			google.setOnLoadCallback(ssxGoogleChartDraw);
			
		    function ssxGoogleChartDraw()
			{
				var data;
				var wrapper;
				
				".$content."
			}
		";
		
		return $function;
	}
}