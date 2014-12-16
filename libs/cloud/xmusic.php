<?php

/**
 * eee.fm cloud class
 *
 * @author: Askar
 */
class eee extends cloud
{
    /**
     * @var string
     */
    protected $baseUrl = 'http://xmusic.me/';

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
            $audios[] = array(
                'artist' => [
                    'name' => ucwords($this->clearstr(html_entity_decode(trim($item->find('b', 0)->innertext()))))
                ],
                'title' => ucwords($this->clearstr(html_entity_decode(trim($item->find('i', 0)->innertext())))),
                'duration' => $item->find('em', 1)->innertext(),
                'url' => $item->find('a.playlist-down', 0)->href
            );
        }

        return $audios;
    }

    /**
     * @return \dHttp\Response
     */
    private function getSource()
    {
        return $this->getClient('http://eee.fm/s/' . urlencode($this->_params['query'] . '/'))->get();
    }
}