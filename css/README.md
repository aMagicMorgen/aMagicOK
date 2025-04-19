Вот **полноценный HTML-лендинг** с кнопками для переключения всех стилей, которые я перечислил. В `<header>` подключены все CSS-фреймворки, а в теле страницы — демонстрация возможностей каждого стиля:

```html
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Демо всех classless CSS-фреймворков</title>
  <!-- Подключаем ВСЕ стили -->
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
  
  <style>
    /* Базовые стили для панели переключения */
    .style-switcher {
      position: fixed;
      top: 10px;
      right: 10px;
      z-index: 1000;
      background: white;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .style-switcher button {
      margin: 3px;
      padding: 5px 10px;
      cursor: pointer;
    }
    /* Общие стили для демо-контента */
    section.demo-section {
      margin: 2rem 0;
      padding: 1rem;
      border-bottom: 1px dashed #ccc;
    }
  </style>
</head>
<body>
  <!-- Панель переключения стилей -->
  <div class="style-switcher">
    <strong>Стили:</strong>
    <button onclick="switchStyle('none')">Сброс</button>
    <button onclick="switchStyle('mvp')">MVP.css</button>
    <button onclick="switchStyle('pico')">Pico.css</button>
    <button onclick="switchStyle('simple')">Simple.css</button>
    <button onclick="switchStyle('water')">Water.css</button>
    <button onclick="switchStyle('tacit')">Tacit</button>
    <button onclick="switchStyle('holiday')">Holiday.css</button>
    <button onclick="switchStyle('new')">New.css</button>
    <button onclick="switchStyle('bamboo')">Bamboo</button>
    <button onclick="switchStyle('sakura')">Sakura</button>
    <button onclick="switchStyle('marx')">Marx</button>
  </div>

  <!-- Основной контент лендинга -->
  <header>
    <h1>Демонстрация classless CSS-фреймворков</h1>
    <p>Просто HTML — без классов! Выберите стиль выше.</p>
    <nav>
      <ul>
        <li><a href="#typography"><b>Типографика</b></a></li>
        <li><a href="#cards"><i>Карточки</i></a></li>
        <li><a href="#forms"><b>Формы</b></a></li>
      </ul>
    </nav>
  </header>

  <main>
    <!-- Раздел 1: Типографика -->
    <section id="typography" class="demo-section">
      <h2>Типографика</h2>
      <article>
        <h3>Заголовки</h3>
        <h1>H1 Заголовок</h1>
        <h2>H2 Подзаголовок</h2>
        <h3>H3 Меньший заголовок</h3>
        
        <h3>Текст</h3>
        <p>Обычный абзац с <mark>выделенным</mark> текстом и <a href="#">ссылкой</a>.</p>
        <blockquote>
          "Цитата выглядит по-разному в каждом фреймворке."
          <footer>— Автор</footer>
        </blockquote>
        
        <h3>Списки</h3>
        <ul>
          <li>Маркированный список</li>
          <li>Второй пункт</li>
        </ul>
        <ol>
          <li>Нумерованный список</li>
          <li>Второй пункт</li>
        </ol>
      </article>
    </section>

    <!-- Раздел 2: Карточки и медиа -->
    <section id="cards" class="demo-section">
      <h2>Карточки и медиа</h2>
      <aside>
        <h3>Карточка</h3>
        <p>Это элемент &lt;aside&gt;, который в некоторых фреймворках выглядит как карточка.</p>
        <button>Кнопка</button>
      </aside>
      
      <figure>
        <img src="https://placehold.co/600x400" alt="Пример изображения" width="100%">
        <figcaption>Подпись к изображению</figcaption>
      </figure>
      
      <details>
        <summary>Раскрывающийся блок</summary>
        <p>Скрытый контент, который можно показать/скрыть.</p>
      </details>
    </section>

    <!-- Раздел 3: Формы -->
    <section id="forms" class="demo-section">
      <h2>Формы</h2>
      <form>
        <label for="name">Имя:</label>
        <input type="text" id="name" placeholder="Ваше имя">
        
        <label for="email">Email:</label>
        <input type="email" id="email" placeholder="email@example.com">
        
        <label for="message">Сообщение:</label>
        <textarea id="message" rows="3"></textarea>
        
        <label>
          <input type="checkbox"> Согласен с условиями
        </label>
        
        <input type="submit" value="Отправить">
        <button type="button">Обычная кнопка</button>
      </form>
    </section>

    <!-- Раздел 4: Таблицы и код -->
    <section id="tables" class="demo-section">
      <h2>Таблицы и код</h2>
      <table>
        <thead>
          <tr>
            <th>Фреймворк</th>
            <th>Размер</th>
            <th>Тёмная тема</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>MVP.css</td>
            <td>8 КБ</td>
            <td>Да</td>
          </tr>
          <tr>
            <td>Pico.css</td>
            <td>10 КБ</td>
            <td>Да</td>
          </tr>
        </tbody>
      </table>
      
      <pre><code>// Пример кода
function hello() {
  console.log("Привет, CSS!");
}</code></pre>
    </section>
  </main>

  <footer>
    <p><small>© 2024 Демо classless CSS-фреймворков</small></p>
    <dialog id="modal">
      <h3>Модальное окно</h3>
      <p>Пример работы элемента &lt;dialog&gt;.</p>
      <button onclick="document.getElementById('modal').close()">Закрыть</button>
    </dialog>
    <button onclick="document.getElementById('modal').showModal()">Открыть модалку</button>
  </footer>

  <script>
    // Функция переключения стилей
    function switchStyle(style) {
      // Отключаем все стили
      document.querySelectorAll('link[rel="stylesheet"]').forEach(link => {
        link.disabled = true;
      });
      
      // Включаем выбранный
      if (style !== 'none') {
        const cssLink = document.getElementById(`${style}-css`);
        if (cssLink) cssLink.disabled = false;
      }
    }
    
    // По умолчанию включаем MVP.css
    window.onload = function() {
      switchStyle('mvp');
    };
  </script>
</body>
</html>
```

### Что включает этот лендинг:
1. **Все 10 CSS-фреймворков** подключены в `<head>` (но изначально отключены).
2. **Панель переключения стилей** в правом верхнем углу.
3. **Демо-разделы**:
   - Типографика (заголовки, списки, цитаты)
   - Карточки и медиа (изображения, `<aside>`, `<details>`)
   - Формы (инпуты, чекбоксы, кнопки)
   - Таблицы и код
4. **Интерактивные элементы**:
   - Раскрывающийся блок (`<details>`)
   - Модальное окно (`<dialog>`)
5. **Адаптивность** — корректно отображается на мобильных устройствах.

### Как использовать:
1. Скопируйте весь код в файл `index.html`.
2. Откройте его в браузере.
3. Нажимайте кнопки в правом верхнем углу, чтобы увидеть, как один и тот же HTML выглядит в разных стилях.

Все фреймворки работают **без классов** — только семантический HTML!
