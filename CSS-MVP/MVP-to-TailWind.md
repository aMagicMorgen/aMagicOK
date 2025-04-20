Вот как можно адаптировать MVP.css под Tailwind, используя `@layer base` и кастомизацию конфига. Создайте два файла:

### 1. `tailwind.config.js`
```javascript
module.exports = {
  darkMode: 'class',
  content: ['./**/*.html'],
  theme: {
    extend: {
      colors: {
        primary: '#118bee',
        secondary: '#920de9',
        accent: '#118bee15',
        'accent-dark': '#0097fc4f'
      },
      borderRadius: {
        DEFAULT: '5px'
      },
      boxShadow: {
        DEFAULT: '2px 2px 10px'
      },
      maxWidth: {
        card: '285px',
        'card-medium': '460px',
        'card-wide': '800px',
        content: '1080px'
      },
      fontFamily: {
        sans: [
          '-apple-system', 
          'BlinkMacSystemFont',
          '"Segoe UI"',
          'Roboto',
          'Oxygen-Sans',
          'Ubuntu',
          'Cantarell',
          '"Helvetica Neue"',
          'sans-serif'
        ]
      }
    }
  },
  plugins: []
}
```

### 2. `src/styles/globals.css`
```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
  :root {
    --active-brightness: 0.85;
    --hover-brightness: 1.2;
  }

  html {
    @apply scroll-smooth;
  }

  body {
    @apply bg-white text-black dark:bg-gray-800 dark:text-gray-100;
    line-height: 1.5;
  }

  /* Typography */
  h1, h2, h3, h4, h5, h6 {
    @apply font-bold;
    text-wrap: balance;
  }

  h1 { @apply text-4xl my-6 text-center; }
  h2 { @apply text-3xl my-8 text-center; }
  
  p { @apply my-4; }
  a { @apply text-primary underline hover:brightness-125; }
  code { @apply bg-accent dark:bg-accent-dark px-2 rounded; }

  /* Components */
  button, input[type="submit"] {
    @apply bg-primary text-white px-8 py-3 rounded transition-colors
           hover:brightness-125 active:brightness-90;
  }

  /* Layout */
  section {
    @apply flex flex-wrap justify-center;
  }

  footer, header, main {
    @apply max-w-content mx-auto py-12 px-4;
  }

  /* Forms */
  input, textarea, select {
    @apply border border-gray-200 dark:border-gray-600 rounded px-4 py-2
           w-full mb-4 bg-transparent;
  }

  /* Tables */
  table {
    @apply border border-gray-200 dark:border-gray-600 rounded-lg 
           inline-block max-w-full overflow-auto;
  }

  th { @apply bg-primary text-white; }
  td, th { @apply px-4 py-2; }

  /* Dark mode */
  .dark {
    --color-accent: #0097fc4f;
    --color-secondary: #e20de9;
  }
}

@layer utilities {
  .scrollbar-thin {
    scrollbar-width: thin;
    scrollbar-color: theme('colors.gray.400') transparent;
  }

  .scrollbar-thin::-webkit-scrollbar {
    @apply w-1.5 h-1.5;
  }

  .scrollbar-thin::-webkit-scrollbar-thumb {
    @apply bg-gray-400 rounded-full;
  }
}

@layer components {
  .card {
    @apply border border-gray-200 dark:border-gray-600 rounded-lg 
           shadow-md p-5 m-4 hover:shadow-lg transition-shadow
           max-w-card;
  }
  
  .dropdown {
    @apply absolute left-0 top-full bg-white dark:bg-gray-700 
           border rounded shadow-lg py-2 min-w-[200px] z-10;
  }
}
```

### Основные изменения:
1. **Кастомизация через конфиг**  
   - Цвета, радиусы, тени адаптированы под оригинальные значения MVP.css
   - Шрифты перенесены в настройки темы

2. **Базовая стилизация тегов**  
   Все стили MVP.css переписаны через `@layer base`

3. **Темная тема**  
   Используется класс `.dark` вместо медиа-запроса

4. **Компоненты**  
   Сложные элементы (карточки, выпадающие меню) вынесены в `@layer components`

5. **Адаптивность**  
   Готова к использованию Tailwind-модификаторов (`md:`, `lg:`)

### Использование:
```html
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MVP Tailwind</title>
  <link href="/dist/output.css" rel="stylesheet">
</head>
<body>
  <header>
    <h1>Hello MVP Tailwind!</h1>
    <button>Click me</button>
  </header>
</body>
</html>
```

Такой подход сохраняет философию MVP.css (минимальные стили для голых тегов), но использует все преимущества Tailwind:
- Кастомизация через конфиг
- Оптимизация CSS
- Темная тема "из коробки"
- Адаптивный дизайн
- Современные CSS-свойства
