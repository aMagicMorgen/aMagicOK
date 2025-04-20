<?php

class TailwindScriptGenerator
{
    private $stylesMap = [];
    private $replaceSelectors = [];
    private $idSelectors = [];

    public function __construct(string $styleString)
    {
        $this->parseStyleString($styleString);
    }

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

            if (strpos($currentSelector, '#') === 0) {
                // id селектор
                if (!isset($this->idSelectors[$currentSelector])) {
                    $this->idSelectors[$currentSelector] = [];
                }
                $this->idSelectors[$currentSelector][] = $line;
            } elseif (strpos($currentSelector, '.') === 0 || strpos($currentSelector, '.') !== false) {
                if (!isset($this->replaceSelectors[$currentSelector])) {
                    $this->replaceSelectors[$currentSelector] = '';
                }
                $this->replaceSelectors[$currentSelector] .= ' ' . $line;
                $this->replaceSelectors[$currentSelector] = trim($this->replaceSelectors[$currentSelector]);
            } else {
                if (!isset($this->stylesMap[$currentSelector])) {
                    $this->stylesMap[$currentSelector] = '';
                }
                $this->stylesMap[$currentSelector] .= ' ' . $line;
                $this->stylesMap[$currentSelector] = trim($this->stylesMap[$currentSelector]);
            }
        }
    }

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
            $className = substr($selector, 1);
            $js .= "  document.querySelectorAll('{$selector}').forEach(el => {\n";
            $js .= "    if (el.classList.contains('{$className}')) {\n";
            $js .= "      el.classList.remove('{$className}');\n";
            $js .= "      el.classList.add(...'{$escapedClasses}'.split(' '));\n";
            $js .= "    }\n";
            $js .= "  });\n\n";
        }

        // Обработка id селекторов с разделителем =>
        foreach ($this->idSelectors as $selector => $lines) {
            $id = substr($selector, 1);
            // Разбираем строки для этого id
            // Если строка содержит =>, то левое — классы для удаления, правое — для добавления
            // Иначе просто добавляем классы
            $js .= "  {\n";
            $js .= "    const el = document.getElementById('{$id}');\n";
            $js .= "    if (el) {\n";
            foreach ($lines as $line) {
                if (strpos($line, '=>') !== false) {
                    [$removePart, $addPart] = array_map('trim', explode('=>', $line, 2));
                    $removeClasses = json_encode(explode(' ', $removePart));
                    $addClasses = json_encode(explode(' ', $addPart));
                    $js .= "      {$removeClasses}.forEach(c => el.classList.remove(c));\n";
                    $js .= "      el.classList.add(...{$addClasses});\n";
                } else {
                    $addClasses = json_encode(explode(' ', $line));
                    $js .= "      el.classList.add(...{$addClasses});\n";
                }
            }
            $js .= "    }\n";
            $js .= "  }\n\n";
        }

        $js .= "});\n";

        return $js;
    }
}
