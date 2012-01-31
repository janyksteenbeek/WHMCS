<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="nl">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 	<title>
		Compatibiliteitcontroles voor Mollie API
	</title>
	<style type="text/css">
	body
	{
		background: #eee;
		font-size: 11pt;
		font-family: Helvetica, Arial, sans-serif;
		margin: 0;
		padding: 0;
	}
	div 
	{
		width: 450px;
		background: #fff;
		-moz-box-shadow: 1px 1px 2px rgba(0,0,0,0.5);
		-webkit-box-shadow: 1px 1px 2px rgba(0,0,0,0.5);
		box-shadow: 1px 1px 2px rgba(0,0,0,0.5);
		-moz-border-radius: 3px;
		-webkit-border-radius: 3px;
		border-radius: 3px;
		margin: 50px auto 0;
		padding: 20px;
	}
	h3
	{
		text-align:center;
	}
	table
	{
		border-spacing: 0;
	}
	th
	{
		font-size: 12pt;
		border-bottom: 1px solid #ddd;
		padding: 13px 5px 6px;
	}
	td 
	{
		border-bottom: 1px solid #eee;
		padding: 12px 5px 5px;
	}
	.okay
	{
		font-weight: bold;
		color: #0a0;
	}
	.fail
	{
		font-weight: bold;
		color: #a00;
	}
	p
	{
		margin-top: 50px;
		text-align: center;
		color: #aaa;
		font-size: 9pt;
	}
	img
	{
		border: 0;
	}
	</style>
</head>
<body>
	<div>
		<h3>Is uw server compatible met de Mollie APIs?</h3>
		
		<table>
			<tr>
				<th style="width: 350px; text-align: left">Controles:</th>
				<th style="width: 80px; text-align: center"></th>
			</tr>
<?php

	error_reporting(E_ALL);

	$tests = array(
		'PHP 5 of hoger'                                  => (bool) version_compare(PHP_VERSION, '5.0', '>='),
		'Magic quotes runtime uitgeschakeld'              => (bool) !get_magic_quotes_runtime(),
		'SSL-verbindingen mogelijk'                       => (bool) in_array('ssl', stream_get_transports()),
		'Verbinding met Mollie.nl (via fsock) toegestaan' => (bool) ($s = @fsockopen('www.mollie.nl', 443)) and fclose($s),
		'SimpleXML-extensie aanwezig'                     => (bool) extension_loaded('simplexml'),
	);
	
	foreach ($tests as $name => $result)
	{
		echo "\t\t\t<tr><td>$name</td><td align=\"center\">". ($result ? '<span class="okay">&radic;</span>' : '<span class="fail">X</span>'). "</td></tr>\n";
	}
	
?>
		</table>
		
		<p>&copy; <?php echo date('Y') ?> Mollie B.V. <a href="https://www.mollie.nl"><img src="https://www.mollie.nl/images/logo.png" alt="Mollie B.V." style="position:relative; top:8px; height:24px" /></a></p>
	</div>
</body>
</html>