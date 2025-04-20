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
