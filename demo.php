<?php
require(__DIR__.'/Regions.php');
$Regions = new Regions;
$isos = $Regions->iso;
foreach (array_column($isos,'iso') as $value) {
	$datas[$value] = rand(-10,10);
}
$map = $Regions->map($datas);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Regions demo</title>
<meta http-equiv="imagetoolbar" content="no">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no, maximum-scale=1" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
<meta name="Description" content="">
<script src="https://api-maps.yandex.ru/2.1/?apikey=c1bc478d-8699-4c34-a782-9d23b706e36d&lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
ymaps.ready(init);

function init() {

    var map = new ymaps.Map('map', {center: [63.3712,99.1716], zoom: 3, type: 'yandex#map', controls: ['zoomControl']},{restrictMapArea: [[10, 10], [85,-160]]}); 
    map.controls.get('zoomControl').options.set({size: 'large'});   
    var districtColors = <?php echo $map->colors;?>;
    var regionsData = <?php echo $map->data;?>; 

    ymaps.borders.load('RU', {
        lang: 'ru',
        quality: 2
    }).then(function (result) {     
        var districtCollections = {}; 
        for (var district in districtColors) {									
            districtCollections[district] = new ymaps.GeoObjectCollection(null, {
                fillColor: districtColors[district],
                strokeColor: districtColors[district],
                strokeOpacity: 0.9,
                fillOpacity: 0.9,
                hintCloseTimeout: 0,
                hintOpenTimeout: 0          
            });  
        }        
                    
        result.features.forEach(function (feature) {
            var iso = feature.properties.iso3166;
            var name = feature.properties.name;          
            feature.properties.hintContent = name+': '+regionsData[iso];                     
            districtCollections[iso].add(new ymaps.GeoObject(feature));         
			map.geoObjects.add(districtCollections[iso]);			
        });          
              
    })
}
</script>
<body>
	<div class="section">
		<div class="container">				
			<div id="map" style="height:600px"></div>
				<p><small>Шкала (от меньшего к большему, зеленое - положительные значения, красные - отрицательные, белое- отсутствие изменений):</small></p>	
				<?php foreach ($map->gradient as $onecolor) {?>				
					<div style="background-color:<?php echo $onecolor;?>; width:50px;height:50px;float:left"></div>
				<?php }?>
		</div>
	</div>	
</body>
</html>
