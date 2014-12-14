<?php

/**
 * iplayer.fm cloud class
 *
 * @author: Askar
 */
class iplayer extends cloud
{
    /**
     * @var string
     */
    protected $baseUrl = 'http://iplayer.fm/';

    /**
     * @return mixed|void
     */
    public function search()
    {
        $page = $this->getSource();
        $doc = Sunra\PhpSimple\HtmlDomParser::str_get_html($page->getBody());

        $elements = $doc->find('li.track');

        $audios = [];
        foreach ($elements as $item) {
            preg_match('/[0-9\:]+/iu', strip_tags($item->find('em', 0)->innertext()), $match);

            if (isset($match[0])) {
                $audios[] = array(
                    'artist' => [
                        'name' => ucwords($this->clearstr(html_entity_decode(trim($item->find('b', 0)->innertext()))))
                    ],
                    'title' => ucwords($this->clearstr(html_entity_decode(trim($item->find('span', 0)->innertext())))),
                    'duration' => $match[0],
                    'url' => $item->find('a.playlist-down', 0)->href
                );
            }
        }

        return $audios;
    }

    /**
     * @return \dHttp\Response
     */
    private function getSource()
    {
        return $this->getClient($this->baseUrl . 'q/' . urlencode($this->_params['query'] . '/'))->get();
    }
}