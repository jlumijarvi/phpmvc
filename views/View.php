<?php

namespace Views;

class View
{
    private $basePath;
    private $layout;
    private $template;
    private $vm;
    private $scripts = [];
    private $tidy = true;

    public function __construct($path = '')
    {
        $this->vm = new ViewModel();
        $this->layout = 'default';
        $this->basePath = BASE_PATH . '/templates' . ($path ? "/$path" : '');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        try {
            ob_start();
            $vm = clone $this->vm;
            $vars = [
                'vm' => $vm,
                'scripts' => $this->scripts
            ];
            extract($vars);
            $path = "{$this->basePath}/{$this->template}.phtml";
            include $path;
            $tpl = ob_get_clean();
            if ($this->layout) {
                $vm->main = $tpl;
                $vars = [
                    'vm' => $vm,
                    'scripts' => $this->scripts
                ];
                ob_start();
                extract($vars);
                $path = BASE_PATH . "/templates/{$this->layout}.phtml";
                include $path;
                $tpl = ob_get_clean();
                if ($this->tidy) {
                    $options = ['indent' => true, 'wrap' => 1000, 'new-blocklevel-tags' => 'main,nav'];
                    $tidy = new \tidy();
                    $tidy->parseString($tpl, $options);
                    $tidy->cleanRepair();
                    $tpl = "$tidy";
                }
            }
            return $tpl;
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        }
    }

    public function setVar($name, $data)
    {
        $this->vm->$name = $data;
        return $this;
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

    /**
     * @param Script $script
     */
    public function addScript($script)
    {
        $this->scripts = $this->scripts ?: [];
        $this->scripts[] = $script;
    }
}