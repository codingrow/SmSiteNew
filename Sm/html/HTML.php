<?php
/**
 * User: Samuel
 * Date: 1/25/2015
 * Time: 2:00 PM
 */

namespace Sm\html;


use Sm\Core\Abstraction\IoC;
use Sm\Core\URI;

class HTML {

    static function css($src){
        return static::link($src, 'css');
    }

    static function link($src, $type = "css", $url = false) {
        $src = $url ?: RESOURCE_URL."{$type}/{$src}.{$type}";
        $relation = "stylesheet";
        switch ($type) {
            case 'waffle':
                $type = 'waffle';
                $relation = "waffle";

                break;
            case 'css':
                $type = 'text/css';
                $relation = "stylesheet";
                break;
        }
        $link = "<link href='{$src}' type='{$type}' rel='{$relation}'/>";
        return $link;
    }

    static function inc_js($file, $real_path = false){
        $url = $real_path ? $file : URI::url($file.'.js', 'js');
        return  "<script src=\"".$url."\"></script>";
    }

    static function anchor($href, $text = null, $title = null){
        $href = IoC::$uri->url($href);
        $title = $title != null ? $title :$text;
        return '<a href="'.$href.'/" title="'.$title.'">'.$text.'</a>';
    }

    static function icon($sr, $name = 'image', $amenities = [], $url = false){
        return static::img('icons/'.$sr, $name, $amenities, $url);
    }

    static function img($file, $alt='img', $amenities = [], $url = false){
        $insides = NULL;
        foreach($amenities as $k=>$v){
            if(is_array($v)){
                $v = implode(" ", $v);
            }
            $insides.= " {$k}=\"{$v}\"";
        }
        $src = $url ? $file : RESOURCE_URL . 'img/' . $file;
        $link = "<img src='{$src}' alt='{$alt}' {$insides}/>";
        return $link;
    }
}