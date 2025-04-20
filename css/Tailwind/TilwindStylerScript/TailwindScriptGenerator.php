<?php

class TailwindScriptGenerator
{
    private array $stylesMap = [];
    private array $specialSelectors = [];

    /**
     * @param string $styleString Строка с правилами, например:
     * h1
     *   text-4xl font-bold mb-6
     * button.cta
     *   bg-secondary hover:bg-secondary/90 text-white px-8 py-4 text-xl
     * .card
     *   bg-white rounded-xl shadow-md overflow-hidden p-6
     */
    public function __construct(string $styleString)
    {
        $this->parseStyleString($styleString);
    }

    /**
     * Парсим строку в два массива:
     * - $stylesMap — селекторы тегов и простые селекторы (например, h1, p, section)
     * - $specialSelectors — селекторы с точками, классами, комбинированные (например, button.cta, .card)
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

            // Добавляем классы к текущему селектору
            if (strpos($currentSelector, '.') === 0 || strpos($currentSelector, '#') === 0 || strpos($currentSelector, '.') !== false) {
                // Селектор с классом или id или комбинированный — в specialSelectors
                if (!isset($this->specialSelectors[$currentSelector])) {
                    $this->specialSelectors[$currentSelector] = '';
                }
                $this->specialSelectors[$currentSelector] .= ' ' . $line;
                $this->specialSelectors[$currentSelector] = trim($this->specialSelectors[$currentSelector]);
            } else {
                // Тег — в stylesMap
                if (!isset($this->stylesMap[$currentSelector])) {
                    $this->stylesMap[$currentSelector] = '';
                }
                $this->stylesMap[$currentSelector] .= ' ' . $line;
                $this->stylesMap[$currentSelector] = trim($this->stylesMap[$currentSelector]);
            }
        }
    }

    /**
     * Генерирует JS-скрипт с объектом elements и отдельными селекторами
     * @return string
     */
    public function generateScript(): string
    {
        $js = "document.addEventListener('DOMContentLoaded', function() {\n";

        // Генерируем объект elements для тегов и простых селекторов
        $js .= "  const elements = {\n";
        foreach ($this->stylesMap as $selector => $classes) {
            $escapedClasses = addslashes($classes);
            $js .= "    '{$selector}': '{$escapedClasses}',\n";
        }
        $js .= "  };\n\n";

        $js .= "  Object.entries(elements).forEach(([selector, classes]) => {\n";
        $js .= "    document.querySelectorAll(selector).forEach(el => {\n";
        $js .= "      el.classList.add(...classes.split(' '));\n";
        $js .= "    });\n";
        $js .= "  });\n\n";

        // Генерируем отдельные селекторы (классы, комбинированные)
        foreach ($this->specialSelectors as $selector => $classes) {
            $escapedClasses = addslashes($classes);
            $js .= "  document.querySelectorAll('{$selector}').forEach(el => {\n";
            $js .= "    el.classList.add(...'{$escapedClasses}'.split(' '));\n";
            $js .= "  });\n\n";
        }

        $js .= "});\n";

        return $js;
    }
}
