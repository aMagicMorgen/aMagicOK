для эксперимента реализуй наш класс с такой функциональностью

# продвинутый

позволяет через id селектор # заменять классы списками из .class1 .classX

```php
<?php

class TailwindScriptGenerator
{
    private array $stylesMap = [];
    private array $replaceSelectors = [];
    private array $idSelectors = [];

    /**
     * Конструктор принимает строку с правилами и парсит её
     * @param string $styleString
     */
    public function __construct(string $styleString)
    {
        $this->parseStyleString($styleString);
    }

    /**
     * Парсит строку с правилами в три массива:
     * - $stylesMap для селекторов-тегов (например, h1, p)
     * - $replaceSelectors для селекторов с классами (например, .card, button.cta)
     * - $idSelectors для селекторов с id (например, #id1)
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

    /**
     * Разрешает селектор в список классов из replaceSelectors или stylesMap
     * @param string $selector (например, '.class1')
     * @return string классы через пробел или пустая строка, если не найден
     */
    private function resolveSelectorClasses(string $selector): string
    {
        // Если селектор с точкой — ищем в replaceSelectors
        if (strpos($selector, '.') === 0) {
            return $this->replaceSelectors[$selector] ?? '';
        }
        // Если селектор — тег
        if (isset($this->stylesMap[$selector])) {
            return $this->stylesMap[$selector];
        }
        return '';
    }

    /**
     * Парсит левую часть id-правила с возможными селекторами и возвращает список классов для удаления
     * Например: ".class1 .class3" => объединённый список классов из replaceSelectors и stylesMap
     * @param string $removePart
     * @return array массив классов для удаления
     */
    private function parseRemoveClasses(string $removePart): array
    {
        $parts = preg_split('/\s+/', trim($removePart));
        $classes = [];
        foreach ($parts as $part) {
            if ($part === '') continue;
            $resolved = $this->resolveSelectorClasses($part);
            if ($resolved !== '') {
                $classes = array_merge($classes, preg_split('/\s+/', $resolved));
            } else {
                // Если селектор не найден, считаем, что это просто класс
                $classes[] = $part;
            }
        }
        // Уникальные классы
        return array_unique($classes);
    }

    /**
     * Генерирует JS-скрипт, который:
     * - для тегов добавляет классы к существующим
     * - для селекторов с классами заменяет только указанный класс, сохраняя остальные
     * - для id селекторов добавляет или заменяет классы с поддержкой ссылки на селекторы
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
            $js .= "  {\n";
            $js .= "    const el = document.getElementById('{$id}');\n";
            $js .= "    if (el) {\n";

            foreach ($lines as $line) {
                if (strpos($line, '=>') !== false) {
                    [$removePart, $addPart] = array_map('trim', explode('=>', $line, 2));
                    $removeClasses = $this->parseRemoveClasses($removePart);
                    $removeClassesJson = json_encode($removeClasses);
                    $addClasses = json_encode(explode(' ', $addPart));
                    $js .= "      {$removeClassesJson}.forEach(c => el.classList.remove(c));\n";
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
```
---

### Краткое описание:

- В `parseRemoveClasses()` разрешаем селекторы `.class1` и теги в левом блоке `=>` для id-селекторов.
- Если селектор найден в `replaceSelectors` или `stylesMap`, берём его классы, иначе считаем это обычным классом.
- В JS генерируем код, который удаляет все эти классы и добавляет новые.
- Остальная логика осталась прежней.

---

Если хотите, могу помочь с примером использования для теста.

