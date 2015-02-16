<?php
/**
 * User: Samuel
 * Date: 1/24/2015
 * Time: 8:10 PM
 */

namespace Sm\Core;


class View {
    public $content;
    public $variables;
    /** @var View[]  */
    static $views = [];
    static $index = 'home';
    static $view_data = [];
    public $name;
    static function &getViewData(){
        return static::$view_data;
    }
    static function view_exists($name){
        return isset(static::$views[$name]);
    }
    static function &create($path = 'home', $data = [], $name = false, $shallow = false){
        $v = new View();$v->setName($path);
        $name = $name ?:$path;
        static::$views[$name] = &$v;
        $filepath = VIEW_PATH.$path.'.php';
        ob_start();
            extract(static::return_include_with_vars($filepath, $data));
            static::$views[$name]->set_content(ob_get_clean());
        return static::$views[$name];
    }
    static function replace(&$replace, $keys, $values){
        $replace = str_replace($keys, $values, $replace);
    }
    static function merge_content(View &$receiving_view){
        $content = '';
        $args = func_get_args();
        foreach ($args as $value) {
            if($value instanceof View){
                $content .= $value->content;
            }
        }
        $receiving_view->content .= $content;
    }
    static function get_named_vars($name){
        return static::$views[$name]->variables;
    }
    static function set($name){
        static::$index = $name;
    }
    function setName($name = null){
        $this->name = $name;
    }
    function set_content($content){
        $this->content = $content;
    }
    static function setViewData($data){
        $data = is_array($data) ? $data : [$data];
        $new = [];
        foreach ($data as $key => $val) {
            $new['{{'.$key.'}}'] = $val;
        }
        static::$view_data = array_merge($new, static::$view_data);
    }
    static function get_content(){
        return static::$views[static::$index]->content;
    }
    static function &get_named($name){
        return static::$views[$name];
    }
    static function &create_template($name = 'std', $alias ='template'){
        return static::create('template/'.$name, [], $alias);
    }
    static function nest_named($view_receive, $view_2, $name = ''){
        static::nest_view(static::get_named($view_receive), $view_2, $name);
    }
    static function save_view($name, View &$view){
        static::$views[$name] = &$view;
    }
    static function nest_view_named($view_name_1, $view_name_2, $name = ''){
        static::nest_view(static::get_named($view_name_1), static::get_named($view_name_2), $name);
    }
    static function nest_view(View &$view_1, $view_2, $name=''){
        if(($view_2 instanceof View)){
            $content = $view_2->content;
            $name = isset($name) ? $name : $view_2->name;
        }else{
            $content = $view_2;
        }
        $view_1->set_content(str_replace("{{nest_". $name . "}}", $content, $view_1->content));
    }
    static function return_include_with_vars($files, array $vars = []){
        if(!empty($vars))   extract($vars, EXTR_SKIP);
        if(is_array($files) && !empty($files)){
            foreach ($files as $file) {
                include($file);
            }
        }elseif(is_string($files)){
            $include_file =  "{$files}";
            include($include_file);
        }
        unset($the_file, $vars);
        return get_defined_vars();
    }
}