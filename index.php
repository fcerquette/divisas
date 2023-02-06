<?php
	$numero = count($_GET);
	$tags = array_keys($_GET); 
	$valores = array_values($_GET);
	$get = [];
	for ($i = 0; $i < $numero; $i++) $get[$tags[$i]] = $valores[$i]; 		
	$url = file_get_contents('https://www.bna.com.ar/Personas');
	$dom = new \DOMDocument();
	@$dom->loadHTML($url);
	$mains = $dom->getElementsByTagName('main');
	foreach ($mains as $main) {
		$divs = $dom->getElementsByTagName('div');
		foreach ($divs as $div) {	
			if ($div->getAttribute('id') === $get['type']) {
				$porciones = explode("\r\n", $div->textContent);
				$compra = ( $get['type'] === 'divisas') ? $porciones[5] : str_replace(',','.',(string)$porciones[6]);
				$venta = ( $get['type'] === 'divisas') ? $porciones[6] : str_replace(',','.', $porciones[7]);
			}
		}
	}
	$rta = [];
	$rta['tipo'] = $get['type'];
	$rta['compra'] = trim($compra);
	$rta['venta']= trim($venta);
	print_r(json_encode($rta));
?>
