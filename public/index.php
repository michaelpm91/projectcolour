<?php

require '../vendor/autoload.php';

Dotenv::load("../");

?>
<html>
  <head>
    
    <title>Project colour. A BBC hack day experiment.</title>
    
	<script src="scripts/jquery-2.1.1.min.js"></script>
	
	<script type="text/javascript" src="scripts/ui.js"></script>
	<link rel="stylesheet" type="text/css" href="css/ui.css" />
	
	
</head>

<body>



<div id="wrapper">

	

	<div id="header">
	
		<div id="album">
		
			<h1>Project 
				colour.
			</h1>
		
		
		
			<div id="red" class="weezer">
				<strong>Weezer - Red Album (2008)</strong>
			</div>
			<div id="green" class="weezer">
				<strong>Weezer - Green Album (2001)</strong>			
			</div>
			<div id="blue" class="weezer">
				<strong>Weezer - Blue Album (1994)</strong>			
			</div>
			
		</div>
	
		<div id="intro">
				<div id="logo"></div>


					<p>A project that will attempt to visualise trends in album artwork in genre over time.</p>

					<p>We examined <strong>23</strong> genres &mdash; from Children's to Rap and Hip Hop &mdash; and extracted the <strong>average</strong> colour used in each album cover in that genre over a <strong>10 year</strong> period.
					
					<p>Sampling over <strong>10,000</strong> individual album covers, we have visualised a progression of colour choice in album covers in each genre over time below.</p>

		
		</div>
		
	
	
	
	</div>
	
	<div id="main">
	
	
	
		<div id="genre">
		
		<form>
		<label for="genre-select">Select genre&nbsp;
		
			
				<select id="genre-select">
					
<option>Alternative/Indie</option>
<option>Blues</option>
<option>Cast Recordings/Cabaret</option>
<option>Christian/Gospel</option>
<option>Children's</option>
<option>Classical/Opera</option>
<option>Comedy/Spoken Word</option>
<option>Country</option>
<option>Electronica/Dance</option>
<option>Folk</option>
<option>Instrumental</option>
<option>Jazz</option>
<option>Latin</option>
<option>New Age</option>
<option>Pop</option>
<option>Rap/Hip Hop</option>
<option>Reggae/Ska</option>
<option>Rock</option>
<option>Seasonal</option>
<option>Soul/R&B</option>
<option>Soundtracks</option>
<option>Vocals</option>
<option>World</option>
			</select>
			</label>
			</form>
		
		</div>
	
		<div id="data">
		
			
		
		</div>
	
		<div id="key">
			<div id="start"><span>1995</span></div>
			<div id="mid"><span>2005</span></div>
			<div id="end"><span>2015</span></div>
		</div>
	
	
	</div>
	
	<div id="footer">
	
	<p><em>Development by Michael Patterson-Muir, Marcos Gurgel, Mark Noble and design by James Offer</em></p>
	
	</div>

</div>




</body>
</html>


