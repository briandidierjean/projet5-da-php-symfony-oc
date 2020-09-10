<?php
namespace Core;

abstract class Application
{
    protected $httpRequest;
    protected $httpResponse;
    protected $name;

    public function __construct()
    {
        $this->httpRequest = new HTTPRequest($this);
        $this->httpResponse = new HTTPResponse($this);
        $this->name = '';
    }

    abstract public function run();

    /**
     * This methods take a URL and returns the matched controller.
     * 
     * @return BackController
     */
    public function getController()
    {
        $router = new Router;
        $routes = yaml_parse_file(
            __DIR__.'/../../App/'.$this->name.'/config/routes.yaml'
        );

        foreach ($routes as $route) {
            $vars = [];

            if (isset($route['vars'])) {
                $vars = $route['vars'];
            }

            $router->addRoute(
                new Route(
                    $route['url'],
                    $route['module'],
                    $route['action'],
                    $route['vars']
                )
            );
        }

        try {
            $matchedRoute = $router->getRoute($this->httpRequest->getURL());
        } catch (\Exception $e) {
            $this->httpResponse->redirect404();
        }

        $_GET = array_merge($_GET, $matchedRoute->vars());

        $controllerClass = 'App\\'.
                            $this->name.'\\
                            Modules\\
                            '.ucfirst($matchedRoute->module()).'\\
                            '.ucfirst($matchedRoute->module()).'Controller';

        return new $controllerClass(
            $this,
            $matchedRoute->module(),
            $matchedRoute->action()
        );
    }


    /**
     * This method returns the httpRequest attribute.
     *
     * @return HTTPRequest
     */
    public function getHttpRequest()
    {
        return $this->httpRequest;
    }

    /**
     * This method returns the httpResponse attribute.
     *
     * @return HTTPResponse
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    /**
     * This method returns the name attribute.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
