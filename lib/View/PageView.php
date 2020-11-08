<?php

namespace FMVC\View;

use BadMethodCallException;
use Serializable;
use Fmvc\Request;
use FMVC\Environment\ApplicationContext;

class PageView implements Serializable
{
    protected $request;
    protected $view_name;
    protected $view_style;
    protected $view_js;
    protected $viewTitle;
    protected $contentType = "text/html";
    protected $params;

    public function __construct($request, ...$params)
    {
        $this->request = $request;
        $this->params = $params;
        $actionIdentifier = strtolower(implode('/', explode('::', $request->action))); 
        $this->view_name = $actionIdentifier;
        $this->view_style = $actionIdentifier.".css";
        $this->view_js = $actionIdentifier.".js";
    }

    /**
     * Generates HTML from the given php files and stores it in a string.
     * 
     * This method represents a mapper around output buffer.
     * When called, it will render the file specified by $name
     * and wrap it within base.php.
     * Afterwards it stores the data from the buffer in a string and returns it.
     * 
     * @param string $name - Name of the template to include.
     * @param Request $request - Request object. Makes request metadata available
     *                           to the view, that should be rendered.
     * @param array $params - array with params, provided for the view.
     * 
     * @return string - rendered html in string format.
     */
    private function render(Request $request, array $params) 
    {
        $result = '';
        $name = strtolower(implode('/', explode('::', $request->action)));
        echo $name;

        // TODO: Make $params and $instance available to included view
        $instance = $this;

        \ob_start();
        require_once(ApplicationContext::getInstance()->requireView('base'));
        $result = \ob_get_clean();
        \ob_end_clean();

        return $result;
    }

    public function yieldTitle()
    {
        return $this->viewTitle ?? 'Title';
    }

    public function yieldCss()
    {
        return "<link rel=\"styleshet\" href=\"public/styles/".$this->view_style."\"/>";
    }

    public function yieldJs()
    {
        return "<script src=\"public/js/".$this->view_js."\"></script>";
    }

    public function yieldView()
    {
        require_once(ApplicationContext::getInstance()->requireView($this->view_name));
    }

    public function serialize()
    {
        return $this->render($this->request, $this->params);
    }

    public function unserialize($data)
    {
        throw new BadMethodCallException("Not Implemented");
    }
}