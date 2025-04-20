<?php

class TailwindScriptGenerator
{
    private $stylesMap = [];
    private $replaceSelectors = [];

    /**
     * @param string $styleString
     */
    public function __construct(string $styleString)
    {
        $this->parseStyleString($styleString);
    }

    /**
     * Парсим строку в два массива:
     * - $stylesMap — селекторы тегов (например, h1, p, section)
     * - $replaceSelectors — селекторы классов (например, .card, .btn)
     */
    private function parseStyleString(string $styleString): void
    {
        $lines = preg_split('/\r?\n/', trim($styleString));
        $currentSelector = null;

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;

            if (preg_match('/^[\w\.\#][\w\.\-\:\[\]\/]*$/', $line)) {
                $currentSelector = $line;
                continue;
            }

            if ($currentSelector === null) continue;

            if (strpos($currentSelector, '.') === 0) {
                // Класс — сюда попадут селекторы вида '.card'
                if (!isset($this->replaceSelectors[$currentSelector])) {
                    $this->replaceSelectors[$currentSelector] = '';
                }
                $this->replaceSelectors[$currentSelector] .= ' ' . $line;
                $this->replaceSelectors[$currentSelector] = trim($this->replaceSelectors[$currentSelector]);
            } else {
                // Тег — сюда попадут селекторы вида 'h1', 'p'
                if (!isset($this->stylesMap[$currentSelector])) {
                    $this->stylesMap[$currentSelector] = '';
                }
                $this->stylesMap[$currentSelector] .= ' ' . $line;
                $this->stylesMap[$currentSelector] = trim($this->stylesMap[$currentSelector]);
            }
        }
    }

    /**
     * Генерирует JS-скрипт, который:
     * - для тегов добавляет классы к существующим
     * - для классов заменяет class на новые классы
     * @return string
     */
    public function generateScript(): string
    {
        $js = "document.addEventListener('DOMContentLoaded', function() {\n";

        // Добавляем классы к тегам (добавление)
        $js .= "  const addClasses = {\n";
        foreach ($this->stylesMap as $selector => $classes) {
            $escapedClasses = addslashes($classes);
            $js .= "    '{$selector}': '{$escapedClasses}',\n";
        }
        $js .= "  };\n\n";

        $js .= "  Object.entries(addClasses).forEach(([selector, classes]) => {\n";
        $js .= "    document.querySelectorAll(selector).forEach(el => {\n";
        $js .= "      el.classList.add(...classes.split(' '));\n";
        $js .= "    });\n";
        $js .= "  });\n\n";

        // Заменяем классы у элементов с указанными классами (замена)
        foreach ($this->replaceSelectors as $selector => $classes) {
            $escapedClasses = addslashes($classes);
            // Убираем точку в селекторе для поиска className (например, '.card' -> 'card')
            $className = substr($selector, 1);
            $js .= "  document.querySelectorAll('{$selector}').forEach(el => {\n";
            $js .= "    el.className = '{$escapedClasses}';\n";
            $js .= "  });\n\n";
        }

        $js .= "});\n";

        return $js;
    }
}
