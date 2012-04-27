<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
///////////////////////////////////////////
// Originally written by kitallis.       //
// Un-failed and featurized by nirbheek. //
///////////////////////////////////////////
$hacker_links = array(
	"beachbrake" => "http://www.priyakuber.in/",
	"devilsadvocate" => "http://blog.chintal.in/",
	"Ford_Prefect" => "http://arunraghavan.net",
	"GeneralMaximus" => "http://uncool.in",
	"Gurpartap" => "http://gurpartap.com",
	"ideamonk" => "http://ideamonk.in/",
	"iwikiwi" => "http://blog.vdavuluri.info/",
	"jai" => "http://www.retroficial.org/",
	"kitallis" => "http://code.scrapcrap.org",
	"kstar" => "http://kstars.wordpress.com/",
	"lifeeth" => "http://lifeeth.in",
	"lut4rp" => "http://pratul.in",
	"nikkar" => "http://github.com/Gurpartap/nikkar/",
	"nirbheek" => "http://bheekly.blogspot.com",
	"sid0" => "http://monogatari.doukut.su",
	"Stattrav" => "http://suryajith.in/",
	"Sup3rkiddo" => "http://sudharsh.wordpress.com/",
	"t3rmin4t0r" => "http://notmysock.org",
	"YuviPanda" => "http://yuvi.in",
	"shadeslayer" => "http://kshadeslayer.wordpress.com/",
);

$hacker_alts = array("Gurpartap" => "balle balle?",
	"nirbheek" => "did your mom.",
	"lut4rp" => "The Quintessential Nice Guy ®");

$known_pic_types = array("gif", "jpg", "png", "svg");

// We use a comma because that isn't allowed in OFTC nicks
$default_avatar_dir = "default,";

// no. of columns to divide the nicks into; must exist in CSS
$num_cols = 3;

$hacker_nicks = array_keys($hacker_links);
shuffle($hacker_nicks);

function get_default_avatar($nick) {
	global $default_avatar_dir;
	// Prevent infinite recursion
	if ($nick != $default_avatar_dir)
		get_avatar($default_avatar_dir);
	return;
}

function get_avatar($nick) {
	global $known_pic_types;
	$dir = "avatars/";
	$avatar_dir = $dir.$nick."/";

	if (!is_dir($avatar_dir)) {
		// lolwat no avatar dir, try default dir
		get_default_avatar($nick);
		return;
	}

	$avatars = scandir($avatar_dir);
	shuffle($avatars);
	// Avatars list contains '.' and '..'
	if (count($avatars) === 2) {
		// lolwat empty avatar dir, try default dir
		get_default_avatar($nick);
		return;
	}

	foreach ($avatars as $avatar) {
		if (in_array(substr($avatar, -3), $known_pic_types)) { 
			echo $avatar_dir.$avatar;
			return;
		}
	}
}

function get_blurb($nick) {
	$file_path = "blurbs/".$nick;
	if (file_exists($file_path)) {
	    $b = file($file_path);
	    echo array_rand(array_flip($b), 1);
	} else {
	    echo "Description-less nub this person is.";
	}
}

function get_nick_with_link($nick) {
	global $hacker_links;
	if (array_key_exists($nick, $hacker_links))
		echo '<a href="'.$hacker_links[$nick].'">'.$nick.'</a>';
}

function get_nick_url($nick) {
	global $hacker_links;
	if (array_key_exists($nick, $hacker_links))
		echo '<a href="'.$hacker_links[$nick].'">';
}

function get_title($nick) {
	global $hacker_alts;
	if (array_key_exists($nick, $hacker_alts))
		echo $hacker_alts[$nick];
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs"> 
 <head> 
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
  <link rel="stylesheet" href="style.css" type="text/css"/> 
  <link href="favicon.ico" rel="icon" type="image/x-icon" />
  <title>Hackers India • Indian F/OSS Hackers Collective</title> 
 </head> 
 <body> 
	<div id="wrapper">
		<div id="header">
			<a href=""><img src="images/hi.png" title="#hackers-india"/></a>
		</div>
		<div id="content">
			<?php for($n = 1; $n < $num_cols+1; $n++) { ?>
			<div id="col<?php echo $n; ?>">
				<?php
				foreach($hacker_nicks as $i => $nick) {
					if ((($i+1) % $num_cols) != ($n % $num_cols))
						continue; // distribute nicks equally amongst the columns
				?>
				<h4><?php get_nick_with_link($nick); ?></h4>
				<p>
					<?php get_nick_url($nick); ?>
					<img align="left" src="<?php get_avatar($nick); ?>" title="<?php get_title($nick) ?>"/>
					</a><br/>
					<?php get_blurb($nick); ?>
				</p>
				<!-- end of a hacker -->
				<?php } ?>
			</div>
			<?php } ?>
		</div>

		<div id="footer">
                        <h3><a href="http://ha.ckers.in/rules.html">The Constitution of hackers-india lies here.</a></h3><br/><br/>
			<p>Warning: The climate of Hackers India may unknowingly vary from geek to sexist to silence to foo. Lifeforms unaccustomed to sudden change and unforseen levels of behaviour might be permanently affected.</p><br/>
			<p>All rights reserved till the end of Time &mdash; #hackers-india @ irc.oftc.net</p><br/>
			<p>Design by ideamonk, code by kitallis and nirbheek.</p>
		</div>
	</div>
 </body>
</html>
