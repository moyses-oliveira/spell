<?php

namespace Spell\MVC;

use Spell\Flash\Path;
use Spell\Flash\Server;
use Spell\MVC\Flash\Route;
use Spell\MVC\Flash\App;
use Spell\MVC\Flash\Theme;
use Spell\UI\Layout\View;
use Spell\Server\URS;

class Bootstrap {

    /**
     *
     * @var \Spell\MVC\AbstractController 
     */
    private $ctrl = null;

    /**
     *
     * @var string 
     */
    private $ctrlClass = null;

    /**
     *
     * @var \Spell\MVC\Router\Route 
     */
    private $route = null;

    /**
     * 
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->route = Route::bootstrap($path);
        App::configure($this->getRoute(), Route::getPath());
        $this->loadMethod();
    }

    /**
     * 
     * @return boolean
     */
    private function loadMethod()
    {
        $this->ctrlClass = App::getNamespace() . 'Controller\\' . Route::getController();

        $this->ctrl = $this->loadController($this->ctrlClass);

        if(!$this->ctrl)
            return false;

        $this->ctrl->setTheme(Theme::get($this->getRoute()->getTheme()));
        $this->authenticate();
        $action = strtolower(Route::getAction());
        $methodUcwords = ucwords(str_replace(['-', '_'], ' ', $action));
        $methodUcwords[0] = strtolower($methodUcwords[0]);
        $method = str_replace(' ', '', $methodUcwords);

        if(!method_exists($this->ctrl, $method))
            return $this->exception(404, "Method '$this->ctrlClass::$method' cannot be found.");

        $params = $this->getMethodParams($method);
        if($params === false)
            return false;

        call_user_func_array([$this->ctrl, $method], $params ?? []);
    }

    private function authenticate()
    {
        if(method_exists($this->ctrlClass, '__settings'))
            call_user_func_array([$this->ctrl, '__settings'], []);
        
        if(method_exists($this->ctrlClass, 'authenticate'))
            call_user_func_array([$this->ctrl, 'authenticate'], []);
    }

    /**
     * 
     * @return \Spell\MVC\AbstractController
     */
    private function loadController()
    {

        $this->ctrlFile = Path::combine($this->ctrlClass) . '.php';
        if(!file_exists($this->ctrlFile))
            return $this->exception(404, "'$this->ctrlFile' cannot be found.");

        if(!class_exists($this->ctrlClass))
            return $this->exception(404, "Controller '$this->ctrlClass' cannot be found.");

        return (new $this->ctrlClass());
    }

    private function getMethodParams($method)
    {
        $reflection = new \ReflectionMethod($this->ctrlClass, $method);
        $params = Route::getParams();
        $methodParameters = $reflection->getNumberOfParameters();
        $methodRequiredParameters = $reflection->getNumberOfRequiredParameters();
        array_splice($params, 0, 2);

        if(!$reflection->isPublic())
            return $this->exception(404, "Method '$this->ctrlClass::$method' cannot be found.");

        $totalParams = count($params);
        if($totalParams < $methodRequiredParameters || $totalParams > $methodParameters)
            return $this->exception(404, "Method '$this->ctrlClass::$method' must have $totalParams.");

        return $params;
    }

    private function exception($code, $message)
    {
        $theme = Theme::get($this->getRoute()->getTheme())->setFile('clean.php');
        $theme->addView('content', new View($theme->getPath(), 'error.php'));
        $theme->getView('content')->setData(compact('message', 'code'));
        echo $theme->render();
    }

    public function getRoute(): Router\Route
    {
        return $this->route;
    }

    public function setRoute(Router\Route $route): Bootstrap
    {
        $this->route = $route;
        return $this;
    }

}
