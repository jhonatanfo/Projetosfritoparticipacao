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
	
	public function __construct()
	{
		global $Ssx;
		
		 $Ssx->themes->add_head_content("
		    <script type=\"text/javascript\">
		      google.charts.load(\"current\", {packages:[\"corechart\",'bar']});
		    </script>"); 
		 load_js('https://www.gstatic.com/charts/loader.js',false);
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
	
	public function lineChart(array $keys, $values, $title_up="" ,$title_vertical="", $output_div="visualization", $title_horizontal="", $width=1200, $height=400)
	{
		if(!$keys || !$values)
			return false;
	
		$keys_view = implode("','", $keys);
		$values_view = implode(",", $values);
	
		$content = "";
		for($i = 0;$i < count($keys);$i++){
			$content .= "['".$keys[$i]."',".$values[$i]."],";
		}
		
		$this->charts[] = "
				
        data = google.visualization.arrayToDataTable([
          ['Dias', 'Diario'],
          ".$content."
        ]);
	
        new google.visualization.LineChart(document.getElementById('".$output_div."')).
            draw(data,
                 {title:'".$title_up."',
                  width:'100%', height:".$height.",
                  vAxis: {title: \"".$title_vertical."\"},
                  hAxis: {title: \"".$title_horizontal."\"}}
            );
         ";
		
		return;
	}

	public function areaChart(array $keys, $values,$title_up="",$title_vertical="", $output_div="visualization", $title_horizontal="", $width=1200, $height=400)
	{
		if(!$keys || !$values)
			return false;
	
		$keys_view = implode("','", $keys);
		$values_view = implode(",", $values);
	
		$content = "";
		for($i = 0;$i < count($keys);$i++){
			$content .= "['".$keys[$i]."',".$values[$i]."],";
		}
		
		$this->charts[] = "
				
        data = google.visualization.arrayToDataTable([
          ['Dias', 'Cadastros'],
          ".$content."
        ]);
        new google.visualization.AreaChart(document.getElementById('".$output_div."')).
            draw(data,
                 
                 {pointsVisible: true,
                  title:'".$title_up."',
                  width:'".$width."', height:".$height.",
                  vAxis: {title: \"".$title_vertical."\"},
                  hAxis: {title: \"".$title_horizontal."\",slantedText:true}}
            );
         ";
		
		return;
	}

	public function columnChart(array $arr,$title_up="",$title_vertical="", $output_div="visualization", $title_horizontal="", $width=800, $height=400,$isPorcent=false){
		if(!is_array($arr))
			return false;
		$chaves = "";
		$values = "";
		foreach ($arr as $key => &$value) {
			$chaves .= "'".$key."',{role:'annotation'},";
			if($isPorcent){
				$total = array_sum(array_values($arr));
				$porcent_value = round(floatval($value)*100/$total,2);
				$values .= $porcent_value.',"'.$value.'",';
			}else{
				$values .= $value.',"'.$value.'",';
			}			
		}
		$chaves = trim($chaves, ",");
		$values = trim($values,',');
		$this->charts[] = "				
					        data = google.visualization.arrayToDataTable([
					          ['',".$chaves."],
					          ['',".$values."]
					        ]);
					        new google.visualization.ColumnChart(document.getElementById('".$output_div."')).
					            draw(data,
					                 
					                 {
					                  title:'".$title_up."',
					                  width:'".$width."', height:".$height.",
					                  vAxis: {
				                  			title: \"".$title_vertical."\",
				            				ticks: [0,25,50,75,100]
				              		  },
					                  hAxis: {title: \"".$title_horizontal."\"},
					                  annotations: {alwaysOutside: true},
					                  bar: {groupWidth: '100px'},
					                }

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
			google.charts.setOnLoadCallback(ssxGoogleChartDraw);
			
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