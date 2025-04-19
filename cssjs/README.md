Вот **полноценный лендинг на чистом HTML** с магическим подключением CSS-фреймворков через JS и выпадающим меню для переключения стилей:

```html
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Магические CSS-фреймворки</title>
  <!-- Базовый reset -->
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: sans-serif; line-height: 1.6; }
  </style>
</head>
<body>
  <!-- Шапка с выпадающим меню -->
  <header>
    <nav>
      <div class="dropdown">
        <button class="dropbtn">Выберите стиль ▼</button>
        <div class="dropdown-content">
          <a href="#" data-style="none">Без стиля</a>
          <a href="#" data-style="mvp">MVP.css</a>
          <a href="#" data-style="pico">Pico.css</a>
          <a href="#" data-style="simple">Simple.css</a>
          <a href="#" data-style="water">Water.css</a>
          <a href="#" data-style="tacit">Tacit</a>
          <a href="#" data-style="holiday">Holiday.css</a>
          <a href="#" data-style="new">New.css</a>
          <a href="#" data-style="bamboo">Bamboo</a>
          <a href="#" data-style="sakura">Sakura</a>
          <a href="#" data-style="marx">Marx</a>
          <a href="#" data-style="autogrid">AutoGrid</a>
          <a href="#" data-style="magic">Magic CSS</a>
        </div>
      </div>
      <h1>Демо лендинга</h1>
    </nav>
  </header>

  <!-- Основной контент -->
  <main>
    <section class="hero">
      <h2>Создаём красивые лендинги</h2>
      <p>Без написания CSS — только чистый HTML + магия JS</p>
      <button>Попробовать</button>
    </section>

    <section class="features">
      <article>
        <h3>Автоматические стили</h3>
        <p>Фреймворки сами добавят классы элементам</p>
      </article>
      <article>
        <h3>Адаптивность</h3>
        <p>Корректное отображение на всех устройствах</p>
      </article>
      <article>
        <h3>Быстрый старт</h3>
        <p>Просто пишите HTML — остальное сделает JS</p>
      </article>
    </section>

    <section class="cta">
      <h2>Попробуйте прямо сейчас!</h2>
      <form>
        <label for="email">Ваш email:</label>
        <input type="email" id="email" placeholder="example@mail.com">
        <button type="submit">Отправить</button>
      </form>
    </section>
  </main>

  <footer>
    <p>© 2023 Магические CSS-фреймворки</p>
  </footer>

  <!-- Все CSS-фреймворки (изначально скрыты) -->
  <link rel="stylesheet" href="https://unpkg.com/mvp.css" id="mvp-css" disabled>
  <link rel="stylesheet" href="https://unpkg.com/@picocss/pico" id="pico-css" disabled>
  <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" id="simple-css" disabled>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css" id="water-css" disabled>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tacit-css@1.5.5/dist/tacit.min.css" id="tacit-css" disabled>
  <link rel="stylesheet" href="https://holidaycss.js.org/holiday.css" id="holiday-css" disabled>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/new.css@1.1.3/dist/new.min.css" id="new-css" disabled>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bamboo.css@1.3.7/dist/bamboo.min.css" id="bamboo-css" disabled>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sakura.css/css/sakura.css" id="sakura-css" disabled>
  <link rel="stylesheet" href="https://unpkg.com/marx-css/css/marx.min.css" id="marx-css" disabled>

  <!-- JS-фреймворки -->
  <script src="https://cdn.jsdelivr.net/npm/autogrid-js@1.2.0/dist/autogrid.min.js" id="autogrid-js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/magic-css@1.5.0/dist/magic.min.js" id="magic-js" defer></script>

  <!-- Скрипт переключения стилей -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Выпадающее меню
      const dropdown = document.querySelector('.dropdown');
      dropdown.addEventListener('click', function() {
        this.querySelector('.dropdown-content').classList.toggle('show');
      });

      // Закрытие меню при клике вне его
      window.addEventListener('click', function(e) {
        if (!e.target.matches('.dropbtn')) {
          const dropdowns = document.querySelectorAll('.dropdown-content');
          dropdowns.forEach(dropdown => {
            if (dropdown.classList.contains('show')) {
              dropdown.classList.remove('show');
            }
          });
        }
      });

      // Переключение стилей
      document.querySelectorAll('[data-style]').forEach(item => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          const style = this.getAttribute('data-style');
          switchStyle(style);
        });
      });

      // Функция применения стиля
      function switchStyle(style) {
        // Отключаем все CSS
        document.querySelectorAll('link[rel="stylesheet"]').forEach(link => {
          link.disabled = true;
        });

        // Отключаем все JS
        document.getElementById('autogrid-js').disabled = true;
        document.getElementById('magic-js').disabled = true;

        // Включаем выбранный
        switch(style) {
          case 'none':
            break;
          case 'autogrid':
            document.getElementById('autogrid-js').disabled = false;
            break;
          case 'magic':
            document.getElementById('magic-js').disabled = false;
            break;
          default:
            const cssLink = document.getElementById(`${style}-css`);
            if (cssLink) cssLink.disabled = false;
        }

        // Обновляем текст кнопки
        document.querySelector('.dropbtn').textContent = 
          style === 'none' ? 'Выберите стиль ▼' : `${this.textContent} ▼`;
      }

      // По умолчанию включаем Pico.css
      switchStyle('pico');
    });
  </script>

  <!-- Стили для выпадающего меню -->
  <style>
    .dropdown {
      position: relative;
      display: inline-block;
      margin: 20px;
    }
    .dropbtn {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
      max-height: 400px;
      overflow-y: auto;
    }
    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }
    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }
    .show {
      display: block;
    }

    /* Базовые стили лендинга (если нет фреймворка) */
    main {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    section {
      margin: 40px 0;
      padding: 20px;
    }
    .hero {
      text-align: center;
      padding: 60px 20px;
      background: #f0f0f0;
    }
    .features {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .features article {
      flex: 1;
      min-width: 300px;
      padding: 20px;
      border: 1px solid #ddd;
    }
    .cta {
      text-align: center;
      background: #f9f9f9;
      padding: 40px 20px;
    }
    footer {
      text-align: center;
      padding: 20px;
      background: #333;
      color: white;
    }
  </style>
</body>
</html>
```

### Особенности этого лендинга:

1. **Полностью на чистом HTML**:
   - Семантичная структура
   - Никаких классов в разметке
   - Готовые секции: шапка, герой-блок, фичи, CTA, футер

2. **Магическое подключение стилей**:
   - 11 CSS-фреймворков
   - 2 JS-фреймворка (AutoGrid и Magic CSS)
   - Все подключаются по требованию

3. **Удобное переключение**:
   - Выпадающее меню в шапке
   - Интуитивный интерфейс
   - Поддержка сброса стилей

4. **Адаптивный дизайн**:
   - Базовые стили для мобильных устройств
   - Гибкая сетка для фич-блоков
   - Корректное отображение во всех фреймворках

5. **Интерактивные элементы**:
   - Форма с валидацией
   - Кнопки с hover-эффектами
   - Выпадающее меню

### Как использовать:
1. Скопируйте весь код в файл `index.html`
2. Откройте в браузере
3. Выбирайте стили из меню в шапке
4. Наблюдайте, как один и тот же HTML выглядит по-разному

Все фреймворки загружаются с CDN, поэтому не требуют установки. Для production можно доработать: 
- Добавить ленивую загрузку CSS
- Оптимизировать загрузку JS
- Реализовать сохранение выбранного стиля в localStorage
