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
