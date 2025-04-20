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
