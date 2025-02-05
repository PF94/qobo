<?php
/*
 * SPDX-License-Identifier: AGPL-3.0-only
 */

namespace OpenSB2\Framework;

use OpenSB2\App;
use OpenSB2\Framework\Controller;

class Router {
    private $routes = [];

    private function addRoute($method, $uri, $controller) {
        $this->routes[] = [
            "uri" => $uri,
            "controller" => $controller,
            "method" => $method,
            "middlewares" => []
        ];

        return $this;
    }

    public function GET(string $uri, $controller) {
        return $this->addRoute("GET", $uri, $controller);
    }

    public function POST(string $uri, $controller) {
        return $this->addRoute("POST", $uri, $controller);
    }

    public function PUT(string $uri, $controller) {
        return $this->addRoute("PUT", $uri, $controller);
    }

    public function PATCH(string $uri, $controller) {
        return $this->addRoute("PATCH", $uri, $controller);
    }

    public function DELETE(string $uri, $controller) {
        return $this->addRoute("DELETE", $uri, $controller);
    }

    public function run($uri, $method) {
        foreach ($this->routes as $route) {
            if ($route["uri"] == $uri && $route["method"] == strtoupper($method)) {
                foreach ($route["middlewares"] as $middleware) {
                    App::resolveMiddleware($middleware, $uri, $method);
                }

                if (is_callable($route["controller"])) {
                    return call_user_func_array($route["controller"], []);
                } else {
                    list($controller, $method) = $route["controller"];

                    try {
                        $reflectedMethod = new \ReflectionMethod($controller, $method);

                        if ($reflectedMethod->isPublic() && (!$reflectedMethod->isAbstract())) {
                            $controller = new $controller();

                            if (!($controller instanceof Controller)) {
                                throw new \Exception("This controller doesn't extend the Qobo\Framework\Controller class.");
                            }

                            return call_user_func_array([$controller, $method], []);
                        }
                    } catch (\ReflectionException $reflectionException) {
                        throw new \Exception("Invalid controller.");
                    }
                }
            }
        }

        $this->abort();
    }

    public function useMiddleware($key) {
        $this->routes[array_key_last($this->routes)]["middlewares"][] = $key;
    }

    private function abort($code = 404) {
        http_response_code($code);
        // TODO: make this less shit
        echo("Not found");
        die();
    }
}
