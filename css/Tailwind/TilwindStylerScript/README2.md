не получается, потому, что ты не сгенерировать скрипт такого типа

// Автоматически применяем классы к элементам
    document.addEventListener('DOMContentLoaded', function() {
      // Применяем базовые стили к элементам
      const elements = {
        'h1': 'text-4xl font-bold mb-6',
        'h2': 'text-3xl font-bold mb-5',
        'h3': 'text-2xl font-bold mb-4',
        'p': 'text-lg mb-4',
        'a': 'text-primary hover:underline',
        'button': 'bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 transition',
        'section': 'py-16',
        'header': 'bg-white shadow-sm',
        'footer': 'bg-dark text-white',
        'input': 'border rounded px-4 py-2 w-full',
        'textarea': 'border rounded px-4 py-2 w-full',
      }
      
      Object.entries(elements).forEach(([tag, classes]) => {
        document.querySelectorAll(tag).forEach(el => {
          el.classList.add(...classes.split(' '))
        })
      })
      
      // Специальные стили для конкретных элементов
      document.querySelectorAll('button.cta').forEach(btn => {
        btn.classList.add('bg-secondary', 'hover:bg-secondary/90', 'text-white', 'px-8', 'py-4', 'text-xl')
      })
      
      document.querySelectorAll('.card').forEach(card => {
        card.classList.add('bg-white', 'rounded-xl', 'shadow-md', 'overflow-hidden', 'p-6')
      })
    }

Понял задачу — нужно сгенерировать именно такой JS-скрипт, где:

- Есть объект `elements` с ключами — селекторами (теги, классы, комбинированные селекторы)
- Значениями — строки с классами
- Затем в `DOMContentLoaded` происходит перебор `elements` и добавление классов к элементам
- Дополнительно — отдельные селекторы с добавлением классов (например, `button.cta` и `.card`)

---

## Полный пример PHP-класса, который генерирует такой скрипт

```php
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
```

---

## Пример использования с вашим стилевым описанием

```php
<?php
require_once 'TailwindScriptGenerator.php';

$styleString = <<<EOT
h1
  text-4xl font-bold mb-6
h2
  text-3xl font-bold mb-5
h3
  text-2xl font-bold mb-4
p
  text-lg mb-4
a
  text-primary hover:underline
button
  bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 transition
section
  py-16
header
  bg-white shadow-sm sticky top-0 z-50
footer
  bg-dark text-white
input
  border rounded px-4 py-2 w-full
textarea
  border rounded px-4 py-2 w-full
button.cta
  bg-secondary hover:bg-secondary/90 text-white px-8 py-4 text-xl
.card
  bg-white rounded-xl shadow-md overflow-hidden p-6
EOT;

$scriptGen = new TailwindScriptGenerator($styleString);
$styleScript = $scriptGen->generateScript();

$html = <<<HTML
<header>
  <nav>
    <a href="#">Главная</a>
    <a href="#features">Возможности</a>
    <a href="#pricing">Цены</a>
    <a href="#contact">Контакты</a>
  </nav>
</header>

<main>
  <section>
    <h1>Магический Tailwind лендинг</h1>
    <p>Демонстрация автоматической стилизации через JS, сгенерированный на сервере.</p>
    <div>
      <button class="cta">Начать бесплатно</button>
      <button>Узнать больше</button>
    </div>
  </section>

  <section id="features">
    <h2>Возможности</h2>
    <div class="card">
      <h3>Быстрая разработка</h3>
      <p>Пишите семантический HTML — стили применятся автоматически.</p>
    </div>
  </section>
</main>

<footer>
  <p>© 2025 Магический Tailwind</p>
</footer>
HTML;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Магический Tailwind лендинг</title>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#3B82F6',
            secondary: '#10B981',
            dark: '#1F2937',
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
        }
      }
    }
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-50">
  <?php echo $html; ?>

  <script>
    <?php echo $styleScript; ?>
  </script>
</body>
</html>
```

---

## Итог

- Генерируем объект `elements` с тегами и простыми селекторами.
- В отдельном блоке добавляем сложные селекторы (например, `button.cta`, `.card`).
- JS добавляет классы к элементам после загрузки страницы.
- Tailwind CDN получает кастомный конфиг с цветами и шрифтами.
- HTML остаётся чистым, без классов.

---

Если нужно, могу помочь с доработкой или интеграцией!

