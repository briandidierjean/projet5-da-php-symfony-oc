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

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../src/views');
        $this->twig = new \Twig\Environment($loader);
        $this->twig->addGlobal('isSignedIn', $this->authentication->isSignedIn());
        $this->twig->addGlobal('isAdmin', $this->authentication->isAdmin());
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
            if ($matchedRoute->getVars() != null) {
                foreach ($matchedRoute->getVars() as $var) {
                    if ($var <= 0) {
                        throw new \Exception;
                    }
                }
            }
        } catch (\Exception $e) {
            $this->httpResponse->redirect404();
        }

        $_GET = array_merge($_GET, $matchedRoute->getVars());

        $controllerClass = '\\App\\Controller\\'.
                           ucfirst($matchedRoute->getController()).'Controller';

        return new $controllerClass(
            $this,
            $matchedRoute->getAction(),
            $this->twig
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
