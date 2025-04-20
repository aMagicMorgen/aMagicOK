Тебе творческая задача. Создай свой красивый лендинг с разными блоками, которые демонстрируют возможности tailwind. Но используй свой класс TailwindStyler.php и строку $styleString и подключение CDN

```php
<?php
// index.php

require_once __DIR__ . '/TailwindStyler.php';

$styleString = <<<EOT
body
  font-sans bg-gray-50 text-gray-900 antialiased
header
  bg-white shadow sticky top-0 z-50
nav
  container mx-auto flex justify-between items-center py-4 px-6
a
  text-primary hover:text-secondary transition font-semibold
h1
  text-5xl font-extrabold text-center my-12 text-gray-900
h2
  text-3xl font-bold mb-6 text-gray-800
h3
  text-xl font-semibold mb-3 text-gray-700
p
  text-gray-600 mb-6 max-w-prose mx-auto
button
  bg-primary text-white px-6 py-3 rounded-lg shadow hover:bg-secondary transition
section
  py-20 px-6
footer
  bg-gray-800 text-gray-300 py-12 text-center
.container
  max-w-6xl mx-auto
.grid-3
  grid grid-cols-1 md:grid-cols-3 gap-8
.card
  bg-white rounded-lg shadow p-6 text-center
input
  border border-gray-300 rounded px-4 py-2 w-full mb-4 focus:outline-none focus:ring-2 focus:ring-primary
textarea
  border border-gray-300 rounded px-4 py-2 w-full mb-4 resize-none focus:outline-none focus:ring-2 focus:ring-primary
.primary-btn
  bg-primary text-white px-8 py-3 rounded-lg shadow hover:bg-secondary transition inline-block
EOT;

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
  <section class="container">
    <h1>Добро пожаловать в Tailwind лендинг</h1>
    <p>Быстрая и красивая верстка с Tailwind CSS и PHP-стилизацией</p>
    <div class="text-center">
      <button>Начать сейчас</button>
    </div>
  </section>

  <section id="features" class="container">
    <h2>Возможности Tailwind</h2>
    <div class="grid-3">
      <div class="card">
        <h3>Утилитарный CSS</h3>
        <p>Используйте классы для быстрой стилизации без написания кастомного CSS.</p>
      </div>
      <div class="card">
        <h3>Адаптивность</h3>
        <p>Легко создавайте адаптивные интерфейсы с помощью встроенных медиазапросов.</p>
      </div>
      <div class="card">
        <h3>Тёмная тема</h3>
        <p>Поддержка темной темы через классы и конфигурацию.</p>
      </div>
    </div>
  </section>

  <section id="pricing" class="container">
    <h2>Тарифы</h2>
    <div class="grid-3">
      <div class="card">
        <h3>Базовый</h3>
        <p>Бесплатно</p>
        <button class="primary-btn">Выбрать</button>
      </div>
      <div class="card">
        <h3>Профессиональный</h3>
        <p>$29 / месяц</p>
        <button class="primary-btn">Выбрать</button>
      </div>
      <div class="card">
        <h3>Корпоративный</h3>
        <p>Индивидуально</p>
        <button class="primary-btn">Связаться с нами</button>
      </div>
    </div>
  </section>

  <section id="contact" class="container max-w-xl mx-auto">
    <h2>Связаться с нами</h2>
    <form>
      <input type="text" placeholder="Ваше имя" required />
      <input type="email" placeholder="Email" required />
      <textarea rows="4" placeholder="Сообщение" required></textarea>
      <button type="submit" class="primary-btn">Отправить</button>
    </form>
  </section>
</main>

<footer>
  <p>© 2025 TailwindStyler Demo. Все права защищены.</p>
</footer>
HTML;

$styler = new TailwindStyler($styleString);
echo '<!DOCTYPE html><html lang="ru"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<title>TailwindStyler Лендинг</title>';
echo '<script src="https://cdn.tailwindcss.com"></script>';
echo '</head><body>';
echo $styler->applyStyles($html);
echo '</body></html>';
```

---

**Объяснение:**  
- В `$styleString` описаны стили для тегов и часто используемых классов (например, `.container`, `.card`, `.primary-btn`).  
- HTML содержит несколько секций: шапка с навигацией, главный блок с заголовком и кнопкой, блок с возможностями, тарифами и формой контакта.  
- PHP-класс `TailwindStyler` добавит нужные классы к тегам и классам в HTML.  
- Tailwind подключён через CDN, стили применятся сразу.

Такой лендинг демонстрирует базовые возможности Tailwind — утилиты, адаптивность, компоненты — и показывает, как удобно управлять стилями централизованно через PHP.

Citations:
[1] Showcase - Tailwind CSS https://tailwindcss.com/showcase
[2] Tailwind CSS - быстро создавайте современные веб-сайты, не ... https://tailwindcss.ru
[3] Взгляд на Tailwind CSS - Habr https://habr.com/ru/companies/skillfactory/articles/558654/
[4] Tailwind CSS Tesla лендинг #1 - Главная секция - YouTube https://www.youtube.com/watch?v=tab8CC2FR1I
[5] Tailwind Шаблоны сайтов - Envato https://elements.envato.com/ru/web-templates/admin-templates+landing-page-templates/tailwind
[6] Tailwind Css Проекты - Behance https://www.behance.net/search/projects/tailwind%20css?locale=ru_RU
[7] Tailwind CSS Landing Pages - Official Tailwind UI Components https://tailwindcss.com/plus/ui-blocks/marketing/page-examples/landing-pages
[8] 1607+ Шаблонов Лендингов для сайта - BootstrapTema https://bootstraptema.ru/stuff/templates_bootstrap/landing_page/6


напиши красивый пример index.php c разноцветными блоками, формами,  заливкой ингридиентным цветом, карточкой, со сложной вложенностью div с разными классами, чтобы оценить эффективность и простоту использования

```php
<?php
// index.php

require_once __DIR__ . '/TailwindStyler.php';

$styleString = <<<EOT
body
  font-sans bg-gray-50 text-gray-900 antialiased

header
  bg-white shadow sticky top-0 z-50

nav
  container mx-auto flex justify-between items-center py-4 px-6

a
  text-primary hover:text-secondary transition font-semibold

h1
  text-5xl font-extrabold text-center my-12 text-gray-900

h2
  text-3xl font-bold mb-6 text-gray-800

h3
  text-xl font-semibold mb-3 text-gray-700

p
  text-gray-600 mb-6 max-w-prose mx-auto

button
  bg-primary text-white px-6 py-3 rounded-lg shadow hover:bg-secondary transition

section
  py-20 px-6

footer
  bg-gray-800 text-gray-300 py-12 text-center

.container
  max-w-6xl mx-auto

.grid-3
  grid grid-cols-1 md:grid-cols-3 gap-8

.card
  bg-white rounded-lg shadow p-6 text-center transition hover:shadow-lg

.input-group
  mb-4

input, textarea
  border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-primary resize-none

.primary-btn
  bg-primary text-white px-8 py-3 rounded-lg shadow hover:bg-secondary transition inline-block

.bg-gradient-ingredient
  bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white p-10 rounded-lg shadow-lg text-center

.text-gradient
  bg-clip-text text-transparent bg-gradient-to-r from-green-400 to-blue-500 font-extrabold

.flex-center
  flex justify-center items-center

.space-x-4
  space-x-4

.space-y-4
  space-y-4

.flex-col
  flex flex-col

.flex-row
  flex flex-row

.rounded-full
  rounded-full

.shadow-md
  shadow-md

.transition-all
  transition-all

.hover-scale
  hover:scale-105

.text-primary
  text-indigo-600

.text-secondary
  text-purple-600

.bg-primary
  bg-indigo-600

.bg-secondary
  bg-purple-600
EOT;

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
  <section class="container">
    <h1>Красочный Tailwind Лендинг</h1>
    <p>Демонстрация разноцветных блоков, форм, градиентов и карточек с помощью Tailwind и PHP-стилизации.</p>
    <div class="flex-center space-x-4">
      <button class="primary-btn">Начать</button>
      <button class="bg-secondary text-white px-6 py-3 rounded-lg shadow hover:bg-purple-700 transition">Подробнее</button>
    </div>
  </section>

  <section id="features" class="container">
    <h2>Возможности</h2>
    <div class="grid-3">
      <div class="card hover-scale">
        <div class="bg-gradient-ingredient mb-4 rounded-full w-20 h-20 flex-center mx-auto shadow-md transition-all">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <h3>Быстрая разработка</h3>
        <p>Используйте утилиты Tailwind для мгновенного создания адаптивных интерфейсов.</p>
      </div>
      <div class="card hover-scale">
        <div class="bg-gradient-ingredient mb-4 rounded-full w-20 h-20 flex-center mx-auto shadow-md transition-all">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h3>Градиенты и цвета</h3>
        <p>Легко создавайте красивые градиенты и насыщенные цвета с Tailwind.</p>
      </div>
      <div class="card hover-scale">
        <div class="bg-gradient-ingredient mb-4 rounded-full w-20 h-20 flex-center mx-auto shadow-md transition-all">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h11M9 21V3" />
          </svg>
        </div>
        <h3>Карточки и анимации</h3>
        <p>Создавайте интерактивные карточки с эффектами наведения и плавными переходами.</p>
      </div>
    </div>
  </section>

  <section id="gradient" class="container text-center">
    <h2 class="text-gradient mb-8">Градиентный текст и фон</h2>
    <div class="bg-gradient-ingredient max-w-3xl mx-auto">
      <p class="text-lg">Этот блок демонстрирует градиентную заливку с плавным переходом цветов и красивым текстом с градиентом.</p>
    </div>
  </section>

  <section id="pricing" class="container">
    <h2>Тарифы</h2>
    <div class="grid-3">
      <div class="card hover-scale">
        <h3>Базовый</h3>
        <p class="mb-6 text-2xl font-bold">$0</p>
        <ul class="mb-6 text-left list-disc list-inside text-gray-700">
          <li>Доступ к базовым функциям</li>
          <li>Ограниченная поддержка</li>
          <li>Обновления бесплатно</li>
        </ul>
        <button class="primary-btn w-full">Выбрать</button>
      </div>
      <div class="card hover-scale">
        <h3>Профессиональный</h3>
        <p class="mb-6 text-2xl font-bold">$29/мес</p>
        <ul class="mb-6 text-left list-disc list-inside text-gray-700">
          <li>Все базовые функции</li>
          <li>Приоритетная поддержка</li>
          <li>Доступ к бета-функциям</li>
        </ul>
        <button class="primary-btn w-full">Выбрать</button>
      </div>
      <div class="card hover-scale">
        <h3>Корпоративный</h3>
        <p class="mb-6 text-2xl font-bold">Индивидуально</p>
        <ul class="mb-6 text-left list-disc list-inside text-gray-700">
          <li>Персональный менеджер</li>
          <li>Настраиваемые решения</li>
          <li>Обучение и поддержка</li>
        </ul>
        <button class="primary-btn w-full">Связаться</button>
      </div>
    </div>
  </section>

  <section id="contact" class="container max-w-xl mx-auto">
    <h2>Свяжитесь с нами</h2>
    <form>
      <div class="input-group">
        <input type="text" placeholder="Ваше имя" required />
      </div>
      <div class="input-group">
        <input type="email" placeholder="Email" required />
      </div>
      <div class="input-group">
        <textarea rows="4" placeholder="Сообщение" required></textarea>
      </div>
      <button type="submit" class="primary-btn w-full">Отправить</button>
    </form>
  </section>
</main>

<footer>
  <p>© 2025 Красочный Tailwind Лендинг. Все права защищены.</p>
</footer>
HTML;

$styler = new TailwindStyler($styleString);
echo '<!DOCTYPE html><html lang="ru"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<title>Красочный Tailwind Лендинг</title>';
echo '<script src="https://cdn.tailwindcss.com"></script>';
echo '</head><body>';
echo $styler->applyStyles($html);
echo '</body></html>';
```
---

### Что здесь показано

- Разноцветные градиенты (`bg-gradient-ingredient`, `text-gradient`)
- Карточки с тенью, скейлом при наведении (`hover-scale`)
- Форма с полями и кнопкой, стилизованная Tailwind
- Сложная вложенность div с разными классами (`flex-center`, `space-x-4`, `grid-3`, `card`)
- Использование утилит Tailwind для отступов, цветов, шрифтов, теней, переходов

---

### Итог

Этот пример демонстрирует, как с помощью PHP-класса можно централизованно управлять стилями, писать чистый HTML без классов, и при этом получать мощный и красивый Tailwind-дизайн с минимальными усилиями.

<?php
require_once __DIR__ . '/TailwindStyler.php';

$styleString = <<<EOT
body
  font-sans bg-gray-50 text-gray-900 antialiased

section
  py-20 px-6 rounded-lg mb-12

.bg-gradient-ingredient
  bg-gradient-to-r from-pink-500 via-yellow-400 to-green-400 text-white shadow-lg

.bg-solid-blue
  bg-blue-600 text-white shadow-md

.text-gradient
  bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-pink-600 font-extrabold text-4xl text-center mb-8

.container
  max-w-4xl mx-auto text-center
EOT;

$html = <<<HTML
<main class="container">
  <section class="bg-gradient-ingredient">
    <h2>Градиентный фон (ингредиентный)</h2>
    <p>Плавный переход от розового через жёлтый к зелёному создаёт яркий и привлекательный фон.</p>
  </section>

  <section class="bg-solid-blue">
    <h2>Однотонная заливка</h2>
    <p>Простой и чистый синий фон с белым текстом для контрастного и читаемого блока.</p>
  </section>

  <section>
    <h2 class="text-gradient">Градиентный текст</h2>
    <p>Текст с плавным градиентом — эффектный способ выделить заголовки и важные элементы.</p>
  </section>
</main>
HTML;

$styler = new TailwindStyler($styleString);
echo '<!DOCTYPE html><html lang="ru"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<title>Пример градиентов и заливок</title>';
echo '<script src="https://cdn.tailwindcss.com"></script>';
echo '</head><body>';
echo $styler->applyStyles($html);
echo '</body></html>';
