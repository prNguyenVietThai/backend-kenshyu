<?php
    spl_autoload_register(function($className) {
        include './controllers/' . $className . '.php';
    });
    class Route {
        private static $__routes = Array();

        public static function get(string $url, $action)
        {
            self::__request($url, "GET", $action);
        }

        public static function post(string $url, $action)
        {
            self::__request($url, "POST", $action);
        }

        public static function patch(string $url, $action)
        {
            self::__request($url, "PATCH", $action);
        }

        public static function delete(string $url, $action)
        {
            self::__request($url, "DELETE", $action);
        }

        public static function __request(string $url, string $method, $action)
        {
            if (preg_match_all('/({([a-zA-Z]+)})/', $url, $params)) {
                $url = preg_replace('/({([a-zA-Z]+)})/', '(.+)', $url);
            }

            $url = str_replace('/', '\/', $url);
            $route = [
                'url' => $url,
                'method' => $method,
                'action' => $action,
                'params' => $params
            ];
            array_push(self::$__routes, $route);
        }

        public static function request(string $url, string $method)
        {
            foreach (self::$__routes as $route) {
                if ($route['method'] === $method) {
                    $reg = '/^' . $route['url'] . '$/';
                    if (preg_match($reg, $url, $params)) {
                        array_shift($params);
                        self::__call_action_route($route['action'], $params);
                        return;
                    }
                }
            }

            echo '404 - Not Found';
            return;
        }

        private static function __call_action_route($action, $params)
        {
            if (is_callable($action)) {
                call_user_func_array($action, $params);
                return;
            }
            if(is_string($action)) {
                $action = explode('@', $action);
                $controller_name = $action[0];
                $controller = new $controller_name();
                call_user_func_array([$controller, $action[1]], $params);
                return;
            }
        }

        public static function redirect($url)
        {
            header("Location:" . $url);
        }
    }