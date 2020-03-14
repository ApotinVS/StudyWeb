<?php

class Router
{
    private $routes;
    public function __construct()
    {
        // Получаем массив с роутами
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     *
     * Returns request uri
     */
    private function getUri()
    {
        if(!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
       $uri = $this -> getUri();
     
       foreach ($this->routes as $uriPattern => $path) {
           if (preg_match("~$uriPattern~", $uri)){
               $iternalRoute = preg_replace("~uriPattern~", $path, $uri);
               echo $iternalRoute;

               $segments = explode('/', $path);
               $controllerName = ucfirst(array_shift($segments).'Controller');
               $actionName = 'action'.ucfirst(array_shift($segments));

               $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
               if(file_exists($controllerFile)){
                   include_once ($controllerFile);
               }
               print_r($segments);

               $controllerObject = new $controllerName;
               $result = $controllerObject -> $actionName();
               if($result !=null){
                   break;
               }
           }
       }
    }
}