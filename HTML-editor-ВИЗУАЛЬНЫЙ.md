Да, такой редактор существует, и его можно реализовать с использованием HTML, JavaScript и дополнительных технологий. Вот основные подходы и примеры:

---

### 1. **Редактирование через атрибут `contenteditable`** 
Этот метод позволяет сделать любой HTML-элемент редактируемым прямо на странице. Для сохранения изменений используются:
- **Локальное сохранение** (через `localStorage`):  
  ```html
  <div id="editor" contenteditable="true">Редактируемый текст</div>
  <button onclick="saveContent()">Сохранить</button>

  <script>
    function saveContent() {
      const text = document.getElementById('editor').innerHTML;
      localStorage.setItem('savedText', text);
    }
  </script>
  ```
  При загрузке страницы данные извлекаются из `localStorage` и вставляются обратно в элемент.

- **Серверное сохранение** (через AJAX):  
  Пример с отправкой данных на сервер при потере фокуса или клике на кнопку:
  ```javascript
  document.getElementById('editor').addEventListener('blur', function() {
    const content = this.innerHTML;
    fetch('/save', { method: 'POST', body: content });
  });
  ```

---

### 2. **Готовые библиотеки и плагины**
- **WysiBB**(https://wysibb.com):  
  Редактор с кнопками "Редактировать" и "Сохранить". Для сохранения используется AJAX-запрос к серверу:
  ```javascript
  function exampleClickToSave() {
    const html = $('#editor').getCode();
    $.ajax({ url: 'save.php', data: { content: html } });
  }
  ```

- **jQuery-скрипты** :  
  Редактируемые блоки с автоматическим сохранением при потере фокуса:
  ```html
  <div id="item1_content" contenteditable="true">Текст</div>
  <script>
    $('[contenteditable]').blur(function() {
      const content = $(this).html();
      $.post('save.php', { content: content });
    });
  </script>
  ```

---

### 3. **Визуальные редакторы с режимом «Источник»**
Например, встроенный редактор AdvantShop  позволяет переключаться между визуальным и HTML-режимом. Для сохранения используется комбинация клиентских и серверных методов.

---

### 4. **Пример полной реализации**
```html
<!DOCTYPE html>
<html>
<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div id="editable-area" contenteditable="false">Нажмите «Редактировать», чтобы изменить текст</div>
  <button id="edit-btn">Редактировать</button>
  <button id="save-btn" style="display: none;">Сохранить</button>

  <script>
    $('#edit-btn').click(function() {
      $('#editable-area').attr('contenteditable', 'true').focus();
      $('#save-btn').show();
    });

    $('#save-btn').click(function() {
      const content = $('#editable-area').html();
      localStorage.setItem('content', content); // или отправка на сервер
      $('#editable-area').attr('contenteditable', 'false');
      $('#save-btn').hide();
    });
  </script>
</body>
</html>
```

---

### 5. **Ключевые технологии**
- **HTML5**: Атрибут `contenteditable` для включения редактирования .
- **JavaScript/jQuery**: Обработка событий (клик, потеря фокуса) и сохранение данных .
- **LocalStorage/Сервер**: Для хранения изменений (локально или через PHP/Python) .

---

### Итог
Такой редактор реализуем как «с нуля» через `contenteditable`, так и с использованием готовых библиотек. Для сохранения данных можно выбрать:
- **Локальное хранение** — подходит для персональных заметок.
- **Серверное хранение** — необходимо для многопользовательских систем. 

Примеры из поиска подтверждают, что это распространённая практика в веб-разработке .
