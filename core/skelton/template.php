<?php

namespace Tamm\Core\Skelton;

/**
 * Class Template
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Core\Skelton
 */
class Template
{
    protected $theme;
    protected $regions = [];

    public function setTheme($theme)
    {
        $this->theme = $theme;
        $this->loadRegions();
    }

    public function renderRegion($region)
    {
        if (isset($this->regions[$region])) {
            foreach ($this->regions[$region] as $block) {
                echo $block;
            }
        }
    }

    public function addBlockToRegion($block, $region)
    {
        $this->regions[$region][] = $block;
    }

    protected function loadRegions()
    {
        $themePath = 'themes/' . $this->theme . '/template.html';
        $themeContent = file_get_contents($themePath);

        preg_match_all('/{{region:(.*?)}}/', $themeContent, $matches);

        foreach ($matches[1] as $region) {
            $this->regions[$region] = [];
        }
    }
}


/**
 * Class TemplateEngine
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Core\Skelton
 */
class TemplateEngine
{
    protected $template;
    protected $data;

    public function __construct($template, $data)
    {
        $this->template = $template;
        $this->data = $data;
    }

    public function render()
    {
        $output = file_get_contents($this->template);

        // Replace variables
        foreach ($this->data as $key => $value) {
            $output = str_replace("{{" . $key . "}}", $value, $output);
        }

        // Handle if statements
        $output = $this->parseIfStatements($output);

        // Handle loops
        $output = $this->parseLoops($output);

        return $output;
    }

    protected function parseIfStatements($output)
    {
        preg_match_all('/\{%\s*if\s*(.+?)\s*%\}(.*?)\{%\s*endif\s*%\}/s', $output, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $condition = $this->evaluateExpression($match[1]);
            $content = $match[2];

            if ($condition) {
                $output = str_replace($match[0], $content, $output);
            } else {
                $output = str_replace($match[0], '', $output);
            }
        }

        return $output;
    }

    protected function parseLoops($output)
    {
        preg_match_all('/\{%\s*foreach\s*(.+?)\s*as\s*(.+?)\s*%\}(.*?)\{%\s*endforeach\s*%\}/s', $output, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $arrayName = $match[1];
            $itemName = $match[2];
            $content = $match[3];

            $array = $this->evaluateExpression($arrayName);

            $result = '';

            foreach ($array as $item) {
                $result .= str_replace("{{" . $itemName . "}}", $item, $content);
            }

            $output = str_replace($match[0], $result, $output);
        }

        return $output;
    }

    protected function evaluateExpression($expression)
    {
        $expression = str_replace(['==', '!=', '>=', '<=', '>', '<'], ['===', '!==', '>=', '<=', '>', '<'], $expression);

        $expression = preg_replace_callback('/\{\{(.+?)\}\}/', function ($matches) {
            return '$this->data["' . $matches[1] . '"]';
        }, $expression);

        return eval("return $expression;");
    }
}

/*
// Example usage:
$template = new TemplateEngine('template.html', [
    'name' => 'John',
    'age' => 25,
    'users' => [
        ['name' => 'Jane', 'age' => 30],
        ['name' => 'Bob', 'age' => 18]
    ]
]);

echo $template->render();
*/