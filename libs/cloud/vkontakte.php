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
    protected $baseUrl = 'http://vk.com';
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
        parent::init();
        $this->getRandomAccount();

        // Set dir for cookies
        $this->temporaryDir = __DIR__ . '/tmp/cookie/';
        if (!is_dir($this->temporaryDir)) {
            mkdir($this->temporaryDir, 0775, true);
        }

        $this->cookieFile = $this->temporaryDir . md5($this->_params['user'] . $this->_params['password']) . '.txt';
    }

    /**
     * Set randomly account
     *
     * @throws AException
     */
    private function getRandomAccount()
    {
        $logins = file(__DIR__ . '/tmp/logins.txt');
        $accountsCount = count($logins);

        if (0 == $accountsCount) {
            throw new Exception('No vk accounts found');
        }

        list($this->_params['user'], $this->_params['password'], $this->_params['number']) = explode('|',
            str_replace("\n", '', $logins[rand(0, $accountsCount - 1)]));
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

        if (!$this->authorize()) {
            return $return;
        }

        return $this->getResults($this->_params);
    }

    /**
     * Is user authorized
     *
     * @return boolean
     */
    private function isAuth()
    {
        $page = $this->getClient($this->baseUrl . '/login')->setCookie($this->cookieFile)->get();
        return (strpos($page->getBody(), 'mmi_logout') !== false) ? true : $page->getBody();
    }

    /**
     * Check security code
     *
     * @param $loginUrl
     * @return bool
     */
    private function checkSecure($source, $loginUrl)
    {
        $url = $this->baseUrl . '/login.php?act=security_check&to=&al_page=3';
        $page = $this->getClient($url, array(
            CURLOPT_REFERER => $loginUrl,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ))->setCookie($this->cookieFile)->post([
                'code' => substr(substr('+' . $this->_params['number'],
                        (substr($this->_params['number'], 0, 1) == 8) ? 1 : 2), 0, -2),
                'al' => 1,
                'al_page' => 3,
                'hash' => $this->hash($source),
                'to' => ''
            ]);

        if (strpos($page->getBody(), 'myprofile_wrap') !== false) {
            return true;
        }

        return false;
    }

    /**
     * @param $source
     * @return string
     */
    private function hash($source)
    {
        preg_match('/hash=([a-z0-9]+)/i', $source, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        }
        return '';
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
            $loginUrl = 'https://login.vk.com/?act=login';

            $page = $this->getClient($loginUrl, array(
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ))->setCookie($this->cookieFile)->post(array(
                'email' => $this->_params['user'],
                'pass' => $this->_params['password']
            ));

            $page = $page->getBody();

            if (strstr($page, 'name="code"') !== false) {
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

            if (strpos($page, 'href="/friends"') !== false) {
                return true;
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
        $url = 'http://vk.com/audio';

        $page = $this->getClient($url, array(
            CURLOPT_REFERER => $url
        ))->setCookie($this->cookieFile)->post([
            'act' => 'search',
            'al' => 1,
            'autocomplete' => 1,
            'offset' => $this->_params['offset'],
            'q' => urlencode($this->_params['query'])
        ]);

        $audios = array();
        if (count($page->getErrors()) == 0) {
            $doc = Sunra\PhpSimple\HtmlDomParser::str_get_html($page->getBody());

            $elements = $doc->find('.audio');
            foreach ($elements AS $element) {
                $artist = $this->wordFilter(strip_tags($element->find('.title_wrap a', 0)->innertext()));
                $title = $this->wordFilter(strip_tags($element->find('span.title', 0)->innertext()));

                $duration = explode(':', $element->find('div.duration', 0)->innertext());

                if ($duration[0] == 0 || count($duration) > 2 || $duration[0] > 7) {
                    continue;
                }

                $url = $element->find('input', 0)->attr['value'];

                $artist = $this->clearstr($artist);
                $title = $this->clearstr($title);

                $count = count(explode(' ', $title));
                $countA = count(explode(' ', $artist));

                if (($count <= 7 && $count != 0 && !empty($title) && (($countA <= 7 && $countA != 0 && !empty($artist))))) {
                    $audios[] = array(
                        'artist' => [
                            'name' => html_entity_decode($artist)
                        ],
                        'title' => html_entity_decode($title),
                        'duration' => (strlen($duration[0]) == 1 ? '0' . $duration[0] : $duration[0]) . ':' . $duration[1],
                        'url' => $url
                    );
                }
            }
        }

        return $audios;
    }

    /**
     * Remove account from file
     */
    private function removeAccount()
    {
        $logins = file(__DIR__ . '/tmp/logins.txt');
        $fp = fopen(__DIR__ . '/tmp/logins.txt', "w+");

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