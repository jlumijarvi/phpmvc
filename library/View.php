<?php

class View
{
    /** @var \Mustache_Engine */
    protected $m;

    private $layout;

    private $template;

    private $vars;

    public function __construct()
    {
        $this->m = new Mustache_Engine([
            'loader' => new Mustache_Loader_FilesystemLoader(BASE_PATH . '/views', ['extension' => '.mst']),
            'cache' => BASE_PATH . '/cache/views'
        ]);

        $this->layout = 'default';
    }

    public function render()
    {
        $tpl = $this->m->render($this->template, $this->vars);
        if ($this->layout) {
            $tmpVars = $this->vars;
            $tmpVars['main'] = $tpl;
            return $this->m->render($this->layout, $tmpVars);
        } else {
            return $tpl;
        }
    }

    public function setVar($name, $data)
    {
        $this->vars[$name] = $data;
    }

    /**
     * @return mixed
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param mixed $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template)
    {
        $this->template = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $template));
    }
}