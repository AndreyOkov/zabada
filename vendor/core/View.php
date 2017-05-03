<?php

namespace vendor\core;


class View
{
    public $route = [];

    public $view;

    public $layout;
    
    public function __construct($route, $layout ='', $view ='')
    {
        $this->route = $route;
        if($layout!== false){
            $this->layout = $layout?:LAYOUT;
        } else {
            $this->layout = false;
        }
        $this->view = $view;
    }
    public function render($vars){
        if(is_array($vars)){
            extract($vars);
        }
        $file_view = APP."/views/{$this->route['controller']}/{$this->view}.php";
        ob_start();
        if(is_file($file_view)){
            require_once $file_view;
        } else {
            echo "<p> Не найден вид <b> {$file_view}</b></p>";
        }
        $content = ob_get_clean();
        if( $this->layout !== false){
            $file_layout = APP."/views/layouts/{$this->layout}.php";
            if(is_file($file_layout)){
                require $file_layout;
            } else {
                echo "Не найден шаблон $file_layout";
            }
        }
    }
}