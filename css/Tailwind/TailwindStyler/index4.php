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
