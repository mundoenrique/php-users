<!DOCTYPE html>
<html class="no-js" lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Publicidad - Conexión Personas Online</title>
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="" />
		<meta name="robots" content="noindex, nofollow" />
		<meta name="googlebot" content="none" />
		<link href="css/bases.css" rel="stylesheet" />
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.js"></script>

		<style type="text/css">

	/* ---------- BASE  -------------*/

		body { 
			padding:0px; 
			margin:0px;
			height:100%;
		}
		html {
		    font-family: Arial, Helvetica, sans-serif;
		}
		a {
		    color: #FFFFFF;
		    text-decoration: none;
		}
				
  /* ---------------  BACKGROUND  -------------------*/

		.ads-item-color-1x{ 
			background-image: url(img/img11.png);
		}
		.ads-item-color-5x{
			background: url(img/img33.png);
		}
		.ads-item-color-2x{
			background: url(img/img22.png);
		}
		.ads-item-color-2x, .ads-item-color-5x, .ads-item-color-1x {
			-webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover; 
			background-repeat: no-repeat;
		    color:black;
		    display: block;
		    background-attachment: scroll;
			background-position: center center;
			background-clip: border-box;
			background-origin: padding-box;
			height: 100%;
			width: 100%;
		}


/* ---------------  DIVS  -------------------*/
		
		.ttl {
			background-color: rgba(72, 75, 76, 0.65);
			color: white;
			padding: 15px 20px;
			font-size: 1.2em;
			display: inline-block;
		}
		.cpt {
			background-color: rgba(72, 75, 76, 0.65);
			color: white;
			width: 90%;
			padding: 10px 10px;
			font-size: 0.9em;
			margin-left: 0px;
		}

/* ------------  SINGLE  ------------- */

		.sngl {
			width: 100%;
			height: 100%;
			position: absolute;
			padding: 0px;
			margin: 0px;
			overflow: hidden;
			vertical-align: 50%;
		}
		.cont_sngl {
			top: 20px;
			position: relative;
		}

/*      animations       */	
		.ttl_sgl {
			position: absolute;
  			display: inline-block;
  			top: 0px;
  			-webkit-animation: ttl_move 12s infinite; /* Chrome, Safari, Opera */ 
		    animation: ttl_move 12s infinite;
		}
			/* Chrome, Safari, Opera */ 
			@-webkit-keyframes ttl_move {
			    0%   {left: -1000px;}
			    7%   {left: 0px;}
			    20%  {left: 0px;}
			    25%  {left: -1000px;}
			    100% {left: -1000px;}
			}
			/* Standard syntax */
			@keyframes ttl_move {
			    0%   {left: -1000px;}
			    7%   {left: 0px;}
			    20%  {left: 0px;}
			    25%  {left: -1000px;}
			    100% {left: -1000px;}
			}

		.cpt_sgl {
			position: absolute;
			-webkit-animation: cpt_move 12s infinite; /* Chrome, Safari, Opera */ 
		    animation: cpt_move 12s infinite;
		}
			/* Chrome, Safari, Opera */ 
			@-webkit-keyframes cpt_move {
			    0%   {left: -1000px;}
			    20%  {left: -1000px;}
			    30%  {left: 0px;}
			    85%  {left: 0px;}
			    100% {left: -1000px;}
			}
			/* Standard syntax */
			@keyframes cpt_move {
			    0%   {left: -1000px;}
			    20%  {left: -1000px;}
			    30%  {left: 0px;}
			    85%  {left: 0px;}
			    100% {left: -1000px;}
			}

/* ------------  LIST -----------*/
		.ads { 
			overflow: hidden;
		}
		.ads > div { 
			position: absolute; 
		}
		.container_list {
			height: 100%;
		}
		.ttl_list {
			margin-top: 20px;
		}
		.cpt_list {
			margin-top: 40px;
		}

		</style>

</head>

	<body>

	<!--  Conection and country Validation  -->

		<?php
				$country = null; $single = false; $json = null; $json_file = null; $message = null;
				if (isset($_GET['country']) === true):
					$country = strtolower($_GET['country']);
					$single = (!empty($_GET['single']) && filter_var(strtolower($_GET['single']), FILTER_VALIDATE_BOOLEAN) === true) ? strtolower($_GET['single']) : false;
					$json_file = './data/' . $country . '.json';
					if (file_exists($json_file) === true):
						$json = json_decode(file_get_contents($json_file), true);
						if ($single):
							$ad_index = array_rand($json['items'], 1);
							$css_class1 = 'ads-item-color-' . $json['items'][$ad_index]['class'];
							$css_class2 = 'item-color-' . $json['items'][$ad_index]['class']; 
		?>


<!--               siengle               -->
		<div class="sngl <?php echo $css_class1; ?>">
					<div class="cont_sngl">
						<div class="ttl ttl_sgl">

								<?php if ($json['items'][$ad_index]['type'] === 'tip'): 
								?>
									<strong>Tip:</strong>
								<?php endif; 
									echo $json['items'][$ad_index]['title']; 
								?>
						</div>
						<div class="cpt cpt_sgl">

								<?php if ($json['items'][$ad_index]['type'] === 'tip'): 
								?>
									<strong>Tip:</strong>
								<?php endif; 
									echo $json['items'][$ad_index]['caption']; 
								?>
						</div>
					</div>
		</div>
				<?php else: ?>

<!--              Countent                   -->
		<section class="ads">

					<?php
						foreach ($json['items'] as $ad):
							$css_class = 'ads-item';
							if ($ad['size'] === 'full') {
								$css_class .= ' ads-item-full';
							}
							$css_class .= ' ads-item-color-' . $ad['class'];
					?>
			
			<div class="pre <?php echo $css_class; ?>">
				<div class="container_list">
					
						<div class="ttl ttl_list">
							<?php if ($ad['type'] === 'tip'): 
							?>
								<strong>Tip:</strong> 
							<?php endif; 
								echo $ad['title']; 
							?>
						</div>
						<div class="cpt cpt_list"> 
							<?php if ($ad['type'] === 'tip'): 
							?>
							<strong>Tip:</strong> 
							<?php endif; 
								echo $ad['caption']; 
							?>
						</div>
					
				</div>
			</div>
					<?php endforeach;
						  endif; 
					?>
		</section>
					<?php
						else:
							$message = 'Disculpe, no existe publicidad a mostrar para su país.';
						endif;
						else:
							$message = 'Disculpe, no existe publicidad a mostrar para su país.';
						endif;

							if (!is_null($message)): 
					?>

		<div class="alert-warning" id="message">

			<p><?php echo $message; ?></p>
		</div>

				<?php
				endif;
				?>
	</body>
</html>






<style type="text/css">

</style>

<script type="text/javascript">
    $(".ads > div:gt(0)").hide();

setInterval(function() { 
  $('.ads > div:first')
    .fadeOut(1000)
    .next()
    .fadeIn(1000)
    .end()
    .appendTo('.ads');
},  8000);
</script>