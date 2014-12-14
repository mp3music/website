<?php

/**
 * Class cloud
 */
abstract class cloud
{
	/**
	 * @var array
	 */
	public $blacklist = array(
		'yoshlar.com',
		'uzhit.com',
		'mp3uz.com',
		'utkirstudio.com',
		'musicuz.com',
		'uznavo.com',
		'uzmusic.net',
		'muzmo.ru',
		'mp3uz.net',
		'hitmusic.uz',
		'wap.kengu.ru',
		'studio.ru',
		'musiclife.kz',
		'ummon.uz',
		'kazmusic.kz',
		'taxi.uz',
		'shou.uz',
		'kazhit.com',
		'okay.uz',
		'uzbekona.uz',
		'uzbek.com',
		'benom.uz',
		'bestmusic.uz',
		'primemusic.ru',
		'dvstudio.tv',
		'dvstudio.uz',
		'zaycev.net',
		'tac.az',
		'mail.ru',
		'rock.ru',
		'mp3host.ru',
		'destiny.kz',
		'uzfunny.com',
		'world.ru',
		'tarona.net',
		'mid.az',
		'vkontakte.ru',
		'UzStarS.BiZ',
		'Uzmusic.Uz',
		'MediaUz.com',
		'voydod.net',
		'Uz.NeT',
		'big.az',
		'vkhp.net',
		'Uzboys.Com',
		'http',
		'www',
		'Без названия',
		'Неизвестный исполнитель',
		'Неизвестен',
		'wapka4ka.ru',
		'prikol',
		'прикол',
		'пиздец',
		'quot',
		'.box.tj'
	);
	/**
	 * @var array
	 */
	public $filter = array(
		'Неизвестный исполнитель',
		'sekc',
		'порно',
		'°'
	);
	/**
	 * @var array
	 */
	protected $_params = array();
    /**
     * @var dHttp\Client
     */
    private $httpClient = null;
    /**
     * @var null
     */
    protected $baseUrl = null;

	/**
	 * @return mixed
	 */
	abstract public function search();

	/**
	 * @param array $params
	 */
	public function __construct(array $params)
	{
		$this->set_params($params);
		$this->init();
	}

	/**
	 * Initialization search
	 */
	public function init()
	{
	}

	/**
	 * Is string in blacklist
	 *
	 * @param string $check
	 * @return boolean
	 */
	public function isInBlacklist($check)
	{
		foreach ($this->blacklist as $word) {
			if (stripos(' ' . $check, $word) > 0) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Filter word
	 *
	 * @param string $check
	 * @return string
	 */
	public function wordFilter($check)
	{
		foreach ($this->filter as $word) {
			$check = str_ireplace($word, '', $check);
		}
		return $check;
	}

	/**
	 * @param array $params
	 * @return cloud
	 */
	public function set_params(array $params)
	{
		$this->_params = $params;
		return $this;
	}

	/**
	 * @param $str
	 * @return array
	 */
	protected function utf8_str_split($str)
	{
		// place each character of the string into and array
		$split = 1;
		$array = array();
		for ($i = 0; $i < strlen($str);) {
			$value = ord($str[$i]);
			if ($value > 127) {
				if ($value >= 192 && $value <= 223) {
					$split = 2;
				} elseif ($value >= 224 && $value <= 239) {
					$split = 3;
				} elseif ($value >= 240 && $value <= 247) {
					$split = 4;
				}
			} else {
				$split = 1;
			}
			$key = null;
			for ($j = 0; $j < $split; $j++, $i++) {
				$key .= isset($str[$i]) ? $str[$i] : '';
			}
			array_push($array, $key);
		}

		return $array;
	}

	/**
	 * @param $str
	 * @return mixed
	 */
	protected function clearstr($str)
	{
		$str = preg_replace('/[^\p{L}\d\.\&\#\(\)\;]/u', ' ', $str);
		return  preg_replace('/(\s{1})\1*/ui', ' ', trim($str));
	}

    /**
     * Return http client
     *
     * @param string $url
     * @param array $options
     * @return dHttp\Client
     */
    protected function getClient($url, $options = [])
    {
        if ($this->httpClient == null) {
            $this->httpClient = new dHttp\Client();
        }

        $defaultOptions = [
            CURLOPT_REFERER => $this->baseUrl,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.102 Safari/537.36'
        ];

        return $this->httpClient->reset()->addOptions($defaultOptions + $options)->setUrl($url);
    }
}