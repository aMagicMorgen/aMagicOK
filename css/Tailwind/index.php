<?php
// index.php

// Подключаем класс TailwindStyler (предполагается, что он в том же каталоге)
require_once __DIR__ . '/TailwindStyler.php';

// Строка с правилами: тег → классы Tailwind
$styleString = <<<EOT
body
  font-sans bg-gray-50 text-gray-800
h1
  text-4xl font-bold mb-6 text-center
h2
  text-3xl font-bold mb-8 text-center
p
  text-lg mb-4
a
  text-primary underline hover:brightness-125
button
  bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 transition
section
  py-16 px-4
header
  bg-white shadow-sm py-4 sticky top-0
footer
  bg-gray-800 text-white py-12
input
  border rounded px-4 py-2 w-full mb-4
textarea
  border rounded px-4 py-2 w-full mb-4
EOT;

// Пример голого HTML без классов
$html = <<<HTML
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tailwind + PHP Styler</title>
  <!-- Подключаем Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
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
      <h1>Магический Tailwind Лендинг</h1>
      <p>Чистый HTML без классов - стилизация через PHP</p>
      <div>
        <button>Попробовать</button>
        <button>Узнать больше</button>
      </div>
    </section>

    <section id="features">
      <h2>Наши возможности</h2>
      <div>
        <div>
          <h3>Автоматическая стилизация</h3>
          <p>Просто пишите HTML, а стили применятся автоматически</p>
        </div>
        <div>
          <h3>Адаптивный дизайн</h3>
          <p>Идеальное отображение на всех устройствах</p>
        </div>
        <div>
          <h3>Быстрая разработка</h3>
          <p>Создавайте страницы в разы быстрее</p>
        </div>
      </div>
    </section>

    <section id="pricing">
      <h2>Наши тарифы</h2>
      <div>
        <div>
          <h3>Базовый</h3>
          <p>Бесплатно</p>
          <button>Выбрать</button>
        </div>
        <div>
          <h3>Профессиональный</h3>
          <p>$29/месяц</p>
          <button>Выбрать</button>
        </div>
      </div>
    </section>

    <section id="contact">
      <h2>Свяжитесь с нами</h2>
      <form>
        <input type="text" placeholder="Ваше имя" />
        <input type="email" placeholder="Email" />
        <textarea placeholder="Сообщение"></textarea>
        <button type="submit">Отправить</button>
      </form>
    </section>
  </main>

  <footer>
    <p>© 2025 Магический Tailwind. Все права защищены.</p>
  </footer>
</body>
</html>
HTML;

// Создаём объект и применяем стили к HTML
$styler = new TailwindStyler($styleString);
$styledHtml = $styler->applyStyles($html);

// Выводим итоговый HTML с классами Tailwind
echo $styledHtml;
