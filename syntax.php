<?php

use dokuwiki\Extension\SyntaxPlugin;

/**
 * DokuWiki Plugin iconify (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author Tokano <contact@tokano.fr>
 */
class syntax_plugin_iconify extends SyntaxPlugin
{
    /** @inheritDoc */
    public function getType()
    {
        return 'substition';
    }

    /** @inheritDoc */
    public function getPType()
    {
        return 'block';
    }

    /** @inheritDoc */
    public function getSort()
    {
        return 999; // Load late
    }

    /** @inheritDoc */
    public function connectTo($mode)
    {
        $this->Lexer->addSpecialPattern('<iconify [^>]+>', $mode, 'plugin_iconify');
    }

    /** @inheritDoc */
    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        $params = trim(substr($match, 8, -1));
        
        // Parse parameters
        $parts = preg_split('/\s+/', $params);
        $icon = $parts[0]; // First part is the icon name
        $color = null;
        $size = null;

        // Check for color and size parameters
        foreach ($parts as $part) {
            if (strpos($part, 'color=') === 0) {
                $color = substr($part, 6);
            } elseif (strpos($part, 'size=') === 0) {
                $size = substr($part, 5);
            }
        }

        return [
            "icon" => $icon,
            "color" => $color,
            "size" => $size
        ];
    }

    /** @inheritDoc */
    public function render($mode, Doku_Renderer $renderer, $data)
    {
        if ($mode !== 'xhtml') {
            return false;
        }

        $icon = htmlspecialchars($data['icon']);
        $style = "";

        // Add default size from configuration if size is not set
        $defaultSize = $this->getConf('default_size') ?: '24px'; // Default size is 24px
        $size = $data['size'] ?: $defaultSize;

        // Generate style for size and color
        if (!empty($size)) {
            $style .= "font-size: $size;";
        }
        if (!empty($data['color'])) {
            $color = htmlspecialchars($data['color']);
            $style .= "color: $color;";
        }

        $renderer->doc .= "<span class='iconify' data-icon='$icon' style='$style'></span>";
        
        return true;
    }
}
