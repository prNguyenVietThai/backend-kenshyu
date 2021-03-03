<?php
    class Route {
        private $__routes;

        public function __construct()
        {
            $this->__routes = [];
        }


        public function get(string $url, $action)
        {
            $this->__request($url, "GET", $action);
        }

        public function post(string $url, $action)
        {
            $this->__request($url, "POST", $action);
        }

        public function __request(string $url, string $method, $action)
        {
            if (preg_match_all('/({([a-zA-Z]+)})/', $url, $params)) {
                $url = preg_replace('/({([a-zA-Z]+)})/', '(.+)', $url);
            }

            $url = str_replace('/', '\/', $url);

            $route = [
                'url' => $url,
                'method' => $method,
                'action' => $action,
                'params' => $params[2]
            ];
            array_push($this->__routes, $route);
        }

        public function map(string $url, string $method)
        {
            foreach ($this->__routes as $route) {
                if ($route['method'] == $method) {
                    $reg = '/^' . $route['url'] . '$/';
                    if (preg_match($reg, $url, $params)) {
                        array_shift($params);
                        $this->__call_action_route($route['action'], $params);
                        return;
                    }
                }
            }

            echo '404 - Not Found';
            return;
        }

        private function __call_action_route($action, $params)
        {
            if (is_callable($action)) {
                call_user_func_array($action, $params);
                return;
            }

            if (is_string($action)) {
                $action = explode('@', $action);
                $controller_name = $action[0];
                $controller = new $controller_name();
                call_user_func_array([$controller, $action[1]], $params);

                return;
            }
        }
    }