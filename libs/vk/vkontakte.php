<?php

/**
 * VK cloud class
 *
 * @author: Askar
 */
class vkontakte extends cloud
{
	/**
	 * @var string
	 */
	private $baseUrl = 'http://m.vk.com';
	/**
	 * @var string
	 */
	private $temporaryDir = null;
	/**
	 * @var string
	 */
	private $cookieFile = null;

	/**
	 * Search initialization
	 */
	public function init()
	{
		// Get random account
		$logins = file(__DIR__ . '/logins.txt');
		$accountsCount = count($logins);

		if (0 == $accountsCount) {
			throw new AException('No vk accounts found');
		}

		list($this->_params['user'], $this->_params['password'], $this->_params['number']) = explode('|', str_replace("\n", '', $logins[rand(0, $accountsCount - 1)]));
		// Set dir for cookies
		$this->temporaryDir = __DIR__ . '/cookie/';
		if (!is_dir($this->temporaryDir)) {
			mkdir($this->temporaryDir, 0775, true);
		}

		$this->cookieFile = $this->temporaryDir . md5($this->_params['user'] . $this->_params['password']) . '.txt';
	}


	/**
	 * Return search results
	 *
	 * @param array $match
	 * @return array
	 */
	public function search(array $match = array())
	{
		$return = array();

		if (!$this->authorize()) {;
			return $return;
		}

		$result = $this->getResults($this->_params);

		// Check captcha
		if (trim(strtolower($this->_params['query'])) == 'eminem' && (!is_array($result) || count($result) == 0)) {
			saveToLog($this->_params['user'], __DIR__ . '/empty.txt');
		}

		if (!is_array($result) || count($result) == 0) {
			return $return;
		}

		foreach ($result as $item) {
			$this->clearstr($item['title']);
			$this->clearstr($item['artist']);

			$count = count(explode(' ', $item['title']));
			$len = mb_strlen($item['title'], 'utf-8');
			$countA = count(explode(' ', $item['artist']));
			$lenA = mb_strlen($item['artist'], 'utf-8');


			if (isset($match['artist'])) {
				$this->clearstr($match['artist']);
				if(strcasecmp($match['artist'], $item['artist']) != 0) {
					continue;
				}
			}

			if (($count <= 6 && $count != 0 && !empty($item['title']) && ($len > 1 && $len <= 98)) && (($countA <= 6 && $countA != 0 && !empty($item['artist'])) || ($lenA > 1 && $lenA <= 98))) {
				$return[] = $item;
			}
		}

		return $return;
	}

	/**
	 * Is user authorized
	 *
	 * @return boolean
	 */
	private function isAuth()
	{
		$client = new dHttp\Client($this->baseUrl . '/login', array(
				CURLOPT_REFERER => $this->baseUrl,
				CURLOPT_HEADER => false,
				CURLOPT_TIMEOUT => 10,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36',
			));

		$page = $client->setCookie($this->cookieFile)->get();

		return (strpos($page->getBody(), 'mmi_logout') !== false) ? true : $page->getBody();
	}

	/**
	 * Check security code
	 *
	 * @param $page
	 * @param $loginUrl
	 * @return bool
	 */
	private function checkSecure($page, $loginUrl)
	{
		$url = explode('login.php?act=security_check', $page);
		$url = explode('">', $url[1]);
		$url = trim($url[0]);
		$url = 'login.php?act=security_check' . $url;
		// Normalize url
		if (strpos($url, $this->baseUrl) === false) {
			if (substr($url, 0, 1) != '/') {
				$url = '/' . $url;
			}
			$url = $this->baseUrl . $url;
		}

		$client = new dHttp\Client($url, array(
				CURLOPT_REFERER => $loginUrl,
				CURLOPT_HEADER => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.102 Safari/537.36',
			));

		$page = $client->setCookie($this->cookieFile)
			->post(array(
					'code' => substr(substr('+' . $this->_params['number'], (substr($this->_params['number'], 0, 1) == 8) ? 1 : 2), 0, -2))
			);


		if (!(strstr($page->getBody(), 'pp_no_status') === false && strstr($page->getBody(), 'pp_status') === false)) {
			return true;
		}

		return false;
	}

	/**
	 * Authorize in vkontakte service
	 *
	 * @return boolean
	 */
	private function authorize()
	{
		$loginPage = $this->isAuth();

		if ($loginPage !== true) {
			preg_match('/action=\"([^\"]+)\"/iu', $loginPage, $matches);

			if (count($matches) < 2) {
				/* login url not found */
				return false;
			}

			$loginUrl = $matches[1];

			preg_match('/ip_h=([^\"]+)&/iu', $loginUrl, $matches);
			if (count($matches) < 2) {
				// No ip_h param in login form
				return false;
			}

			$client = new dHttp\Client($loginUrl, array(
					CURLOPT_REFERER => $this->baseUrl,
					CURLOPT_HEADER => false,
					CURLOPT_SSL_VERIFYPEER => false,
					CURLOPT_SSL_VERIFYHOST => false,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_TIMEOUT => 10,
				));

			$page = $client->setCookie($this->cookieFile)
				->post(array(
						'email' => $this->_params['user'],
						'pass' => $this->_params['password']
					)
				);


			$page = $page->getBody();

			if (strpos($page, 'mmi_friends') !== false) {
				return true;
			}

			if (strstr($page, 'act=security_check') !== false && strstr($page, 'field_prefix') !== false) {
				return $this->checkSecure($page, $loginUrl);
			}

			// Check captcha
			if (strstr($page, 'captcha') !== false) {
				// Remove bad account
				$this->removeAccount();
			}

			if (stripos($page, 'login_blocked') !== false) {
				// Remove bad account
				$this->removeAccount();
			}

			return false;
		}

		return true;
	}

	/**
	 * Get results from vkontakte
	 *
	 * @return array
	 */
	private function getResults()
	{
		$url = 'http://m.vk.com/audio?act=search&q=' . urlencode($this->_params['query']);
		if ($this->_params['offset'] > 0) {
			$url = $url . '&offset=' . (int)$this->_params['offset'];
		}

		$client = new dHttp\Client($url, array(
				CURLOPT_HEADER => false,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_TIMEOUT => 10,
				CURLOPT_REFERER => $url,
				CURLOPT_USERAGENT => isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36',
			));

		$page = $client->setCookie($this->cookieFile)->get();

		$audios = array();

		if (count($page->getErrors()) == 0) {
			$doc = Sunra\PhpSimple\HtmlDomParser::str_get_html($page->getBody());
			$elements = $doc->find('.ai_body');

			foreach ($elements AS $element) {
				$artist = $this->wordFilter(strip_tags($element->find('.ai_artist', 0)->innertext()));
				$title = $this->wordFilter(strip_tags($element->find('.ai_title', 0)->innertext()));

				if ($this->isInBlacklist($artist . ' ' . $title)) {
					continue;
				}

				$duration = explode(':', $element->find('.ai_dur', 0)->innertext());

				if ($duration[0] == 0 || count($duration) > 2 || $duration[0] > 7) {
					continue;
				}

				$url = $element->find('input', 0)->attr['value'];

				$audios[] = array(
					'artist' => $artist,
					'title' => $title,
					'duration' => $duration[0] . ':' . $duration[1],
					'url' => $url
				);
			}
		}

		return $audios;
	}

	/**
	 * Remove account from file
	 */
	private function removeAccount()
	{
		$logins = file(__DIR__ . '/logins.txt');
		$fp = fopen(__DIR__ . '/logins.txt', "w+");

		if (flock($fp, LOCK_EX)) {
			foreach ($logins as $key => $val) {
				if (strpos($val, $this->_params['number']) !== false) {
					unset($logins[$key]);
					break;
				}
			}

			fwrite($fp, implode("", $logins));
			flock($fp, LOCK_UN);
		}
		fclose($fp);
	}
}