<?php
// ESTE ES EL FILTRO ANT-SPAM. PUEDES MODIFICAR LA LISTA DE PALABRAS NO ADMITIDAS AQUI.
function esSpam($txt) {

	$txt = strtolower($txt);
	$spamWords = array('</url>', 'adderall', 'adipex', 'allegra', 'alprazolam', 
	'ambien', 'buy', 'bontril', 'buspar', 'butalbital',  'cheap', 'carisoprodol', 
	'celebrex', 'celexa', 'cialis', 'cipro', 'claritin', 'codeine', 'diazepam', 
	'diflucan', 'tramadol', '<html>', '</img>', '<img', '</IFRAME>', '</div>', '</DIV>', 
	'</script>', '</SCRIPT>', '</font>', '</embed>', '</table>', '<strong>', '</strong>', 
	'</h1>', '</h2>', '<hr>', 'src=', 'gilipollas', 'caraculo', 'polla', 'nabo', 'follar', 
	'tonto', 'chupapollas', 'www', '.com', 'http');
	$spamCount = 0;
	foreach ( $spamWords as $spamWord ) {
		$spamCount = $spamCount + substr_count($txt, $spamWord);
	}
	
	return $spamCount;

}
?>