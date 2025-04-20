<?php

class TailwindScriptGenerator
{
    private array $stylesMap = [];
    private array $replaceSelectors = [];

    /**
     * Конструктор принимает строку с правилами и парсит её
     * @param string $styleString
     */
    public function __construct(string $styleString)
    {
        $this->parseStyleString($styleString);
    }

    /**
     * Парсит строку с правилами в два массива:
     * - $stylesMap для селекторов-тегов (например, h1, p)
     * - $replaceSelectors для селекторов с классами (например, .card, button.cta)
     * @param string $styleString
     * @return void
     */
    private function parseStyleString(string $styleString): void
    {
        $lines = preg_split('/\r?\n/', trim($styleString));
        $currentSelector = null;

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;

            // Если строка — селектор
            if (preg_match('/^[\w\.\#][\w\.\-\:\[\]\/]*$/', $line)) {
                $currentSelector = $line;
                continue;
            }

            if ($currentSelector === null) continue;

            // Если селектор начинается с точки — это класс или комбинированный селектор — в replaceSelectors
            if (strpos($currentSelector, '.') === 0 || strpos($currentSelector, '.') !== false) {
                if (!isset($this->replaceSelectors[$currentSelector])) {
                    $this->replaceSelectors[$currentSelector] = '';
                }
                $this->replaceSelectors[$currentSelector] .= ' ' . $line;
                $this->replaceSelectors[$currentSelector] = trim($this->replaceSelectors[$currentSelector]);
            } else {
                // Иначе — тег — в stylesMap
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
     * - для селекторов с классами заменяет только указанный класс, сохраняя остальные
     * @return string
     */
    public function generateScript(): string
    {
        $js = "document.addEventListener('DOMContentLoaded', function() {\n";

        // Добавление классов к тегам
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

        // Замена только указанного класса у элементов с классом (оставляя остальные)
        foreach ($this->replaceSelectors as $selector => $classes) {
            $escapedClasses = addslashes($classes);
            // Убираем точку в селекторе для имени класса
            $className = substr($selector, 1);
            $js .= "  document.querySelectorAll('{$selector}').forEach(el => {\n";
            $js .= "    if (el.classList.contains('{$className}')) {\n";
            $js .= "      el.classList.remove('{$className}');\n";
            $js .= "      el.classList.add(...'{$escapedClasses}'.split(' '));\n";
            $js .= "    }\n";
            $js .= "  });\n\n";
        }

        $js .= "});\n";

        return $js;
    }
}
