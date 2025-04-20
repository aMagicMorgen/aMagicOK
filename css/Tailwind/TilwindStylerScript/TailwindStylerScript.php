<?php

class TailwindStylerScript
{
    private $stylesMap = [];

    public function __construct(string $styleString)
    {
        $this->stylesMap = $this->parseStyleString($styleString);
    }

    private function parseStyleString(string $styleString): array
    {
        $lines = preg_split('/\r?\n/', trim($styleString));
        $map = [];
        $currentSelector = null;
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;

            if (preg_match('/^[\w\.\#\-]+$/', $line)) {
                $currentSelector = $line;
                $map[$currentSelector] = '';
            } elseif ($currentSelector !== null) {
                $map[$currentSelector] .= ' ' . $line;
                $map[$currentSelector] = trim($map[$currentSelector]);
            }
        }
        return $map;
    }

    public function generateScript(): string
    {
        $js = "document.addEventListener('DOMContentLoaded', function() {\n";
        foreach ($this->stylesMap as $selector => $classes) {
            // Преобразуем селектор для JS: если это тег (например, h1), то querySelectorAll('h1')
            // Если класс (.card), то querySelectorAll('.card')
            // Если id (#id), то querySelectorAll('#id')
            $jsSelector = $selector;
            if (strpos($selector, '.') === 0 || strpos($selector, '#') === 0) {
                // класс или id — оставляем как есть
            } else {
                // предполагаем тег — оставляем как есть
            }
            $classesArray = explode(' ', $classes);
            $classesJsArray = json_encode($classesArray);

            $js .= "  document.querySelectorAll('{$jsSelector}').forEach(el => {\n";
            $js .= "    el.classList.add(...{$classesJsArray});\n";
            $js .= "  });\n";
        }
        $js .= "});\n";
        return $js;
    }
}
