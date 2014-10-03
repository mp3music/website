<?php
/**
 * @param $string
 * @return mixed|string
 */
function urlclean($string, $delimeter = ' ')
{
	// Clean
	$string = preg_replace('/[^\p{L}\d]/u', ' ', $string);
	return mb_strtolower(preg_replace('/(\s{1})\1*/ui', $delimeter, trim($string)), 'utf-8');
}

/**
 * Cut string by limit
 *
 * @param string $string
 * @param int $limit
 * @param boolean $points
 * @return string
 */
function s($string, $limit = 34, $points = true)
{
	if (mb_strlen($string) < $limit) {
		return $string;
	}

	return mb_substr($string, 0, $limit, 'utf-8') . ($points ? '...' : '');
}

/**
 * @param $limit
 * @return array
 */
function randomArtists($limit = 10)
{
	$artists = [
		'Chris Brown',
		'Barbra Streisand',
		'Meghan Trainor',
		'Taylor Swift',
		'Maroon 5',
		'Ariana Grande',
		'Nicki Minaj',
		'Iggy Azalea',
		'Sam Smith',
		'Tim McGraw',
		'Jason Aldean',
		'OneRepublic',
		'Ed Sheeran',
		'Katy Perry',
		'Florida Georgia Line',
		'Train',
		'George Strait',
		'Luke Bryan',
		'Charli XCX',
		'Drake',
		'Sia',
		'Tove Lo',
		'5 Seconds Of Summer',
		'Wiz Khalifa',
		'Coldplay',
		'Jason Derulo',
		'Blake Shelton',
		'Beyonce',
		'MAGIC!',
		'Eminem',
		'Imagine Dragons',
		'Echosmith',
		'Enrique Iglesias',
		'Pitbull',
		'Clean Bandit',
		'Miley Cyrus',
		'Jeremih',
		'John Legend',
		'Pharrell Williams',
		'Lecrae',
		'Calvin Harris',
		'Nico & Vinz',
		'Motionless In White',
		'Trey Songz',
		'Jhene Aiko',
		'Bruno Mars',
		'Lee Brice',
		'Sam Hunt',
		'Bobby Shmurda',
		'One Direction',
		'Jessie J',
		'George Strait',
		'Justin Bieber',
		'Joe Bonamassa',
		'Rita Ora',
		'Fall Out Boy',
		'Jennifer Hudson',
		'Rae Sremmurd',
		'Demi Lovato',
		'Lorde'
	];

	shuffle($artists);
	return array_slice($artists, 0, $limit);
}