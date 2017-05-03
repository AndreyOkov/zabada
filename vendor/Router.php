<?php

namespace vendor;

class Router
{

        public static $routes = [];
    
        public static $route = [];

        public static $params = [];
            
        public static function add($pattern, $route = []){
            self::$routes[$pattern] = $route;
        }
        public static function matchRoute($url){
            foreach (self::$routes as $pattern => $route){
                if(preg_match("#$pattern#i", $url, $matches)){
                    foreach ($matches as $k => $v){
                        if(is_string($k)){
                            $route[$k] = $v;
                        } 
                    }
                    if(!isset($route['action'])){
                        $route['action'] = 'index';
                    }
                    $route['controller'] = self::upperCamelCase($route['controller']);
                    self::$route = $route;
                    return true;
                } 
            }
            return false;
        }
        
        public static function dispatch($url){
            $params = self::extractParams($url);
            $url = array_shift($params);
            $params = $params[0];

            if(self::matchRoute($url)){
                $controller = 'app\controllers\\' . self::$route['controller'] . 'Controller';
                if(class_exists($controller)){
                    $cObj = new $controller(self::$route);
                    $action = self::lowerCamelCase(self::$route['action']).'Action';
                    if(method_exists($cObj, $action)){
                        $reflectionMethod = new \ReflectionMethod($controller,$action);
                        $reflectionMethod->invokeArgs($cObj, $params);
//                        $cObj->$action($params);
                        $cObj->getView();
                    } else {
                        echo "Метод {$action} не найден";
                    }
                } else {
                    echo "Класс {$controller} не найден";
                }
            }
        }

        protected static function upperCamelCase($name){
            $name = ucwords($name);
            $name = str_replace('-','', $name);
            return $name;
        }
    protected static function lowerCamelCase($name){
        $name = self::upperCamelCase($name);
        return lcfirst($name);
    }
    protected static function extractParams($url){
        $res = [];
        $params = explode('&',$url);
        $url = array_shift($params);
        foreach ($params as $param){
            $param = explode('=',$param);
            $res[$param[0]] = $param[1];
        }
        return [$url,$res];

    }
}