<?php
namespace Core;

use Symfony\Component\Yaml\Yaml;

class Application
{
    protected $httpRequest;
    protected $httpResponse;
    protected $authentication;

    public function __construct()
    {
        $this->httpRequest = new HTTPRequest($this);
        $this->httpResponse = new HTTPResponse($this);
        $this->authentication = new Authentication($this);
    }

    /**
     * Get a controller a execute it
     *
     * @return void
     */
    public function run()
    {
        $controller = $this->getController();
        $controller->execute();
    }

    /**
     * Choose a controller matching the client route
     *
     * @return Controller
     */
    public function getController()
    {
        $router = new Router;

        $routes = Yaml::parseFile(
            __DIR__.'/../config/routes.yaml'
        );

        foreach ($routes as $route) {
            $vars = [];

            if (isset($route['vars'])) {
                $vars = explode(',', $route['vars']);
            }

            $router->addRoute(
                new Route(
                    $route['url'],
                    $route['controller'],
                    $route['action'],
                    $vars
                )
            );
        }

        try {
            $matchedRoute = $router->getRoute($this->httpRequest->getURL());
        } catch (\Exception $e) {
            $this->httpResponse->redirect404();
        }

        $_GET = array_merge($_GET, $matchedRoute->getVars());

        $controllerClass = '\\App\\Controller\\'.
                           ucfirst($matchedRoute->getController()).'Controller';

        return new $controllerClass(
            $this,
            $matchedRoute->getAction()
        );
    }

    // GETTERS
    public function getHttpRequest()
    {
        return $this->httpRequest;
    }

    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    public function getAuthentication()
    {
        return $this->authentication;
    }
}
