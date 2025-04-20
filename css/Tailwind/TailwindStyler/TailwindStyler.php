<?php

class TailwindStyler
{
    /**
     * @var array<string, string> Массив тег → классы Tailwind
     */
    private array $stylesMap = [];

    /**
     * Конструктор принимает строку с правилами и парсит её в массив
     * @param string $styleString
     */
    public function __construct(string $styleString)
    {
        $this->stylesMap = $this->parseStyleString($styleString);
    }

    /**
     * Парсит строку с правилами в массив [тег => классы]
     * @param string $styleString
     * @return array<string, string>
     */
    private function parseStyleString(string $styleString): array
    {
        $lines = preg_split('/\r?\n/', trim($styleString));
        $map = [];
        $currentTag = null;

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;

            // Если строка — тег (без пробелов)
            if (preg_match('/^[a-zA-Z0-9_-]+$/', $line)) {
                $currentTag = $line;
                $map[$currentTag] = '';
            } elseif ($currentTag !== null) {
                // Добавляем классы к текущему тегу, объединяя через пробел
                $map[$currentTag] = trim($map[$currentTag] . ' ' . $line);
            }
        }

        return $map;
    }

    /**
     * Добавляет Tailwind классы к тегам в HTML
     * @param string $html
     * @return string
     */
    public function applyStyles(string $html): string
    {
        // Используем DOMDocument для корректного парсинга HTML
        $dom = new \DOMDocument();

        // Чтобы избежать предупреждений от некорректного HTML
        libxml_use_internal_errors(true);

        // Загружаем HTML, оборачивая в контейнер, если нужно
        $htmlWrapped = $html;
        if (stripos($html, '<html') === false) {
            $htmlWrapped = "<!DOCTYPE html><html><body>$html</body></html>";
        }

        $dom->loadHTML(mb_convert_encoding($htmlWrapped, 'HTML-ENTITIES', 'UTF-8'));

        libxml_clear_errors();

        // Применяем стили к каждому тегу из карты
        foreach ($this->stylesMap as $tag => $classes) {
            $elements = $dom->getElementsByTagName($tag);
            /** @var \DOMElement $el */
            foreach ($elements as $el) {
                $this->addClassesToElement($el, $classes);
            }
        }

        // Получаем изменённый HTML без обёртки
        if (stripos($html, '<html') === false) {
            $body = $dom->getElementsByTagName('body')->item(0);
            $innerHTML = '';
            foreach ($body->childNodes as $child) {
                $innerHTML .= $dom->saveHTML($child);
            }
            return $innerHTML;
        }

        // Если был полноценный HTML, возвращаем весь документ
        return $dom->saveHTML();
    }

    /**
     * Добавляет классы к DOM-элементу, аккуратно дописывая к существующим
     * @param \DOMElement $el
     * @param string $classes
     * @return void
     */
    private function addClassesToElement(\DOMElement $el, string $classes): void
    {
        $existingClass = $el->getAttribute('class');
        $existingClasses = preg_split('/\s+/', $existingClass, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $newClasses = preg_split('/\s+/', $classes, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        // Объединяем и убираем дубликаты
        $allClasses = array_unique(array_merge($existingClasses, $newClasses));

        $el->setAttribute('class', implode(' ', $allClasses));
    }
}
