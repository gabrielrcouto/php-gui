<?php

namespace Example;

class Rss
{
    public static $cache = [];

    public static function getLastest()
    {
        $authors = [];
        $links = [];
        $titles = [];

        $rssContent = file_get_contents('http://news.php.net/group.php?group=php.internals&format=rss');

        $re = "/<link>([^<]*)<\\/link>/";
        preg_match_all($re, $rssContent, $matches);

        if (count($matches[1]) > 0) {
            array_shift($matches[1]);
            $links = $matches[1];
        }

        $re = "/<title>([^<]*)<\\/title>/";
        preg_match_all($re, $rssContent, $matches);

        if (count($matches[1]) > 0) {
            array_shift($matches[1]);
            $titles = $matches[1];
        }

        $re = "/<description>([^<]*)<\\/description>/";
        preg_match_all($re, $rssContent, $matches);

        if (count($matches[1]) > 0) {
            array_shift($matches[1]);
            $authors = $matches[1];

            foreach ($authors as $key => $author) {
                $authorHtml = html_entity_decode($author);
                $re = "/>([^<]*)<\\//";
                preg_match_all($re, $authorHtml, $authorName);

                if (count($authorName[1]) > 0) {
                    $authors[$key] = html_entity_decode($authorName[1][0]);
                } else {
                    $authors[$key] = html_entity_decode($author);
                }
            }
        }

        return [
            'authors' => $authors,
            'links' => $links,
            'titles' => $titles
        ];
    }

    public static function getSingle($link)
    {
        if (isset(self::$cache[$link])) {
            return self::$cache[$link];
        }

        $html = file_get_contents($link);
        $blocks = explode('</blockquote>', $html);

        if (count($blocks) > 1) {
            $content = html_entity_decode(strip_tags($blocks[1]));
            self::$cache[$link] = $content;
            return $content;
        }

        return '';
    }
}
