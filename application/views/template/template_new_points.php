<style type="text/css">
	ul{
		list-style-type: none;
	}	
	li{
		float: left;
	}
	.left{
		font-weight: bold;
	}
</style>
<div>
	<h2>Al Mundial con Derby</h2>
	
		<H4>Puntos:</H4>
	<ul>
		<li class="left">Puntos ganados: </li>
		<li><?php echo $ganados; ?></li>
	</ul>
	<ul>
		<li class="left">Total de puntos: </li>
		<li><?php echo $total; ?></li>
	</ul>
	<ul>
		<li class="left">Tardaste: </li>
		<li><?php echo $time; ?></li>
	</ul>
</div>