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
 * @param $limit
 * @return array
 */
function topArtists($limit = 100)
{
    $artists = [
        'Meghan Trainor',
        'Kenny Chesney',
        'Taylor Swift',
        'Barbra Streisand',
        'Maroon 5',
        'Ariana Grande',
        'Nicki Minaj',
        'Sam Smith',
        'Iggy Azalea',
        'Jason Aldean',
        'Chris Brown',
        'Ed Sheeran',
        'Florida Georgia Line',
        'alt-J',
        'Lady Gaga',
        'Katy Perry',
        'Tony Bennett',
        '5 Seconds Of Summer',
        'Blake Shelton',
        'Tove Lo',
        'Drake',
        'Luke Bryan',
        'Charli XCX',
        'Pentatonix',
        'OneRepublic',
        'Sia',
        'Jason Derulo',
        'Coldplay',
        'Wiz Khalifa',
        'Kendrick Lamar',
        'Tim McGraw',
        'Beyonce',
        'MAGIC!',
        'Eminem',
        'Imagine Dragons',
        'Echosmith',
        'Miley Cyrus',
        'Jeremih',
        'Clean Bandit',
        'Pharrell Williams',
        'Pitbull',
        'John Legend',
        'Enrique Iglesias',
        'Nico & Vinz',
        'Bruno Mars',
        'Calvin Harris',
        'Bobby Shmurda',
        'Trey Songz',
        'Sam Hunt',
        'Justin Timberlake',
        'One Direction',
        'Jessie J',
        'George Strait',
        'Justin Bieber',
        'Joe Bonamassa',
        'Rita Ora',
        'Fall Out Boy',
        'T.I.',
        'Jennifer Hudson',
        'Rae Sremmurd',
        'Cole Swindell',
        'Lee Brice',
        'Aphex Twin',
        'Demi Lovato',
        'Lorde',
        'Brantley Gilbert',
        'ScHoolboy Q',
        'Bastille',
        'YG',
        'Train',
        'Chase Rice',
        'Leonard Cohen',
        'Lenny Kravitz',
        'Dustin Lynch',
        'Michael Jackson',
        'Jhene Aiko',
        'Mr. Probz',
        'Lady Antebellum',
        'Jackie Evancho',
        'Jeezy',
        'Miranda Lambert',
        'Jennifer Lopez',
        'Usher',
        'John Mellencamp',
        'Vance Joy',
        'Rich Homie Quan',
        'Adele',
        'August Alsina',
        'Lana Del Rey',
        'Tweedy',
        'Hozier',
        'Lecrae',
        'Zedd',
        'Migos',
        'Young Thug',
        'Disclosure',
        'Dierks Bentley',
        'Becky G',
        'Avicii',
        'Nick Jonas'
    ];
    return array_slice($artists, 0, $limit);
}
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
		'One Direction'
	];

	shuffle($artists);

	return array_slice($artists, 0, $limit);
}