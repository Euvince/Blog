<?php 

namespace App;

use AltoRouter;

class Router 
{

    private $viewPath;
    private $router;

    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new AltoRouter();
    }

    public function get (string $url, string $view, string $name ): self
    {
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    public function post (string $url, string $view, string $name ): self
    {
        $this->router->map('POST', $url, $view, $name);
        return $this;
    }

    public function match (string $url, string $view, string $name ): self
    {
        $this->router->map('GET|POST', $url, $view, $name);
        return $this;
    }

    public function url (string $name, array $params = [])
    {
        return $this->router->generate($name, $params);
    }

    public function run (): self
    {
        $match = $this->router->match();
        $view = $match['target'];
        $params = $match['params'];
        $router = $this;
        $isAdmin = strpos($view,'Admin/') !== false;
        $layouts = $isAdmin ? 'Admin/Layouts/default' : 'Layouts/default';
        ob_start();
        require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        $content = ob_get_clean();
        require $this->viewPath. DIRECTORY_SEPARATOR . $layouts .'.php';

        return $this;
    }

}