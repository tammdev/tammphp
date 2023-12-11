<?php

namespace Tamm\Framework\Core;

/**
 * Class Template
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skeleton
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
