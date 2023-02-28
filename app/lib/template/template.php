<?php

namespace PHPMVC\Lib\template;

class Template
{
    use TemplateHelper;

    private $_templateParts;
    private $_action_view;
    private $_data;
    private $_registry;

    public function __get($key)
    {
        return $this->_registry->$key;
    }

    public function __construct(array $parts)
    {
        $this->_templateParts = $parts;
    }

    public function setActionViewFile($actionViewPath)
    {
        $this->_action_view = $actionViewPath;
    }

    public function setAppData($data)
    {
        $this->_data = $data;
    }

    public function swapTemplate($template) //da 3ashan a3dl 3ala el template w ashel parts mnha w kda
    {
        $this->_templateParts['template']= $template;
    }

    public function setRegistry($registry)
    {
        $this->_registry = $registry;
    }


    private function renderTemplateHeaderStart()
    {
        extract($this->_data);
        require_once TEMPLATE_PATH . 'templateheaderstart.php';
    }

    private function renderTemplateHeaderEnd()
    {
        extract($this->_data);
        require_once TEMPLATE_PATH . DS . 'templateheaderend.php';
    }

    private function renderTemplateFooter()
    {
        extract($this->_data);
        require_once TEMPLATE_PATH . DS . 'templatefooter.php';
    }

    private function renderTemplateBlocks()
    {
        if (!array_key_exists('template', $this->_templateParts)) {
            trigger_error('sorry u have to define template blocks', E_USER_WARNING);
        } else {
            $parts = $this->_templateParts['template'];
            if (!empty($parts)) {
                extract($this->_data);
                foreach ($parts as $partKey => $file) {
                    if ($partKey === ':view') {
                        require_once $this->_action_view;
                    } else
                        require_once $file;
                }
            }
        }
    }

    private function renderHeaderResources()
    {
        $output = '';
        if (!array_key_exists('header_resources', $this->_templateParts)) {
            trigger_error('sorry u have to define header resources', E_USER_WARNING);
        } else {
            $resources = $this->_templateParts['header_resources'];

            //generate css links
            $css = $resources['css'];
            if (!empty($css)) {
                foreach ($css as $cssKey => $path) {
                    $output .= '<link type="text/css" rel="stylesheet" href="' . $path . '" />';
                }
            }
            //generate JS scripts
            $js = $resources['js'];
            if (!empty($js)) {
                foreach ($js as $jsKey => $path) {
                    $output .= '<script src="' . $path . '"></script>';
                }
            }
        }
        echo $output;
    }

    private function renderFooterResources()
    {
        $output = '';
        if (!array_key_exists('footer_resources', $this->_templateParts)) {
            trigger_error('sorry u have to define footer resources', E_USER_WARNING);
        } else {
            $resources = $this->_templateParts['footer_resources'];

            //generate JS scripts
            if (!empty($resources)) {
                foreach ($resources as $resourceKey => $path) {
                    $output .= '<script src="' . $path . '"></script>';
                }
            }
        }
        echo $output;
    }

    public function renderApp()
    {
        $this->renderTemplateHeaderStart();
        $this->renderHeaderResources();
        $this->renderTemplateHeaderEnd();
        $this->renderTemplateBlocks();
        $this->renderFooterResources();
        $this->renderTemplateFooter();
    }
}