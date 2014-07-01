<?php 
/***************************
 * MINI SITE PROJETS MEDIA *
 *        ~ JOSUA GONZALEZ *
 ***************************/

require('database.php');

// taken from http://cubiq.org/the-perfect-php-clean-url-generator
function toAscii($str, $replace=array(), $delimiter='-') {
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}

	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;
}

?>
<!doctype html>
<html>
<head><!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<title>Projets Media 2014</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="webfont/bebasneue.css" />
	<link rel="stylesheet" type="text/css" href="webfont/roboto-condensed.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="icon" type="image/png" href="img/favicon.png"/>
	<link href="js/lib/video-js/video-js.css" rel="stylesheet">
	<meta name="description" content="Liste des projets média de l'IUT Info Aix de 2014" />
</head>
<body>
<?php
try {
	$db = new PDO($dbLogin['driver'], $dbLogin['username'], $dbLogin['password']);
} catch(Exception $e) {
	exit('Erreur de connexion : ' . $e->getMessage());
}

$days = array();
$days[0] = $db->query('SELECT * FROM `media` WHERE `Show` = "Y" AND `Jour` = 1 ORDER BY `Ordre` ASC') or exit(print_r($db->errorInfo()));
$days[1] = $db->query('SELECT * FROM `media` WHERE `Show` = "Y" AND `Jour` = 2 ORDER BY `Ordre` ASC') or exit(print_r($db->errorInfo()));

?>
	<p class="info">IUT Info Aix</p>
	<header>
		<div class="logo">
			<img src="img/logo.png" alt="PROJETS MEDIA 2014" />
		</div>
		<div class="tabs">
			<!--<p class="tab recherche">
				<input type="text" placeholder="Rechercher par titre..." id="search" />
			</p>-->
			<p class="tab lundi"><a href="#lundi">Lundi</a></p>
			<p class="tab mardi"><a href="#mardi">Mardi</a></p>
			<p class="tab archives"><a href="http://iut.nerdbox.fr/archive/">Archives</a></p>
		</div>
		<div class="triangle"></div>
	</header>

	<div id="wrapper">
	<div id="page">
	<?php for($j = 0; $j < 2; $j++) { $day = $days[$j]; $nd = "lundi"; if($j == 1) $nd = "mardi"; ?>
	<section class="<?php echo $nd; ?>" id="<?php echo $nd; ?>">
		<h2><?php echo $nd; ?></h2>

		<?php
			while($d = $day->fetch()) {
				$liens = preg_split('/$\R?^/m', $d['Liens']);
				$mime = 'video/mp4';
				$typeDuree = "minutes";
				$slug = "projet-".$d['Id']."-".toAscii(utf8_encode($d['Titre']));

				if($d['Type'] == 'AUD') $mime = 'audio/mp3';

				foreach ($liens as $key => $value) {
					$v = explode('|', $value);
					$liens[$key] = array('link' => $v[0], 'quality' => $v[1], 'size' => $v[2]);
				}
				?>
		<article id="<?php echo $slug; ?>">
			<div class="player <?php echo $d['Type']; ?>">
			<?php if($d['Type'] != 'MAG') { ?>
				<div class="playercontent">
					<!--poster="http://video-js.zencoder.com/oceans-clip.png" width="640" height="264"<video controls src="http://iut.nerdbox.fr/projets/compressed/360/Inside.mp4"></video>-->
					<video id="example_video_1" class="video-js vjs-default-skin"
					  controls preload="none" width="500" height="281" 
					  <?php if(isset($d['Poster'])) { echo ' poster="'.$d['Poster'].'" '; } ?>
					  data-setup='{"example_option":true}'>
					 <source src="<?php echo $liens[0]['link'];?>" type='<?php echo $mime; ?>' />
					 <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
					</video>
				</div>
				<p class="pInfo">
				Streaming <?php echo $liens[0]['quality'];?><br />
				Télécharger : 
				<?php for($i = 0; $i < count($liens); $i++) { $lien = $liens[$i]; ?>
					<a href="<?php echo $lien['link']; ?>"><?php echo $lien['quality']; ?> (<?php echo $lien['size']; ?>Mo)</a>
					<?php echo ($i < count($liens) - 1) ? ' · ' : ''; ?> 
				<?php } ?>
				</p>
			<?php } else { $typeDuree = "pages"; ?>
				<div class="playercontent">
					<a href="<?php echo $liens[0]['link'];?>"><img src="<?php if(isset($d['Poster'])) { echo $d['Poster']; } ?>" class="poster" /></a>
				</div>
				<p class="pInfo">
				Télécharger : 
				<?php for($i = 0; $i < count($liens); $i++) { $lien = $liens[$i]; ?>
					<a href="<?php echo $lien['link']; ?>"><?php echo $lien['quality']; ?> (<?php echo $lien['size']; ?>Mo)</a>
					<?php echo ($i < count($liens) - 1) ? ' · ' : ''; ?> 
				<?php } ?>
				</p>
			<?php } ?>
			</div>
			<h3><a href="#<?php echo $slug; ?>"><?php echo utf8_encode($d['Titre']); ?></a></h3>
			<p>
				<strong><?php echo utf8_encode($d['Categorie']); ?> - <?php echo $d['Duree']; ?> <?php echo $typeDuree; ?></strong><br />
				Groupe :<br />
				<?php if(!empty($d['Auteurs'])) { echo nl2br(utf8_encode($d['Auteurs'])); } else echo '(no data)'; ?>
			</p>
			<!--<p><a href="#fiche">Fiche complète &raquo;</a>-->

		</article>
		<?php
			}
		?>
	</section>
	<?php } ?>
	<footer>
		<p>
			<strong>IUT Info Aix</strong> - <acronym title="Vous pouvez retrouver les films dont l'autorisation n'a pas été obtenue à l'Asso">Seuls les films dont les autorisations de ses auteurs respectifs ont été obtenues sont diffusés sur ce site</acronym> - <a href="archive/index.php">Archives</a><br />
			Site hébergé par <a href="http://xorus.nerdbox.fr/">Josua Gonzalez</a>, un lien mort ? Votre film est absent ? <a href="mailto:jdpepi@gmail.com">Contactez moi</a><br /><br />

			Les films appartiennent (copyright) à leurs auteurs respectifs.<br />
			Le style et la disposition du site est placé sous licence Creative Commons BY (Josua Gonzalez).
		</p>
	</footer>
	</div>
	</div>


	<script src="js/jquery-1.11.0.min.js"></script>
	<script src="js/lib/video-js/video.js"></script>
	<script src="js/main.js"></script>
	<script>
	  videojs.options.flash.swf = "js/lib/video-js/video-js.swf"
	</script>

	<script>
	  /* Je sais c'est le diable incarné mais c'est temporaire, en attendant que j'installe mon propre système, genre piwik ou autres */
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-52301192-1', 'auto');
	  ga('send', 'pageview');
	</script>
 </body>
</html>