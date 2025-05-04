Вот готовый PHP-код, который сканирует директорию, фильтрует файлы по заданным условиям (например, по расширению или по цифрам в начале имени) и реализует навигацию по папкам:

```php
<?php
class DirectoryScanner {
    /**
     * Сканирует директорию с возможностью фильтрации
     * 
     * @param string $path Путь к директории
     * @param array $filters Массив фильтров (например, ['extension' => 'txt', 'startWithNumbers' => 2])
     * @return array Массив с содержимым директории
     */
    public static function scanDirectory($path, $filters = []) {
        $result = [
            'path' => $path,
            'parent' => dirname($path),
            'directories' => [],
            'files' => []
        ];

        if (!is_dir($path)) {
            return $result;
        }

        $items = scandir($path);
        
        foreach ($items as $item) {
            if ($item == '.' || $item == '..') continue;
            
            $fullPath = $path . DIRECTORY_SEPARATOR . $item;
            
            if (is_dir($fullPath)) {
                $result['directories'][] = [
                    'name' => $item,
                    'path' => $fullPath
                ];
            } else {
                // Применяем фильтры к файлам
                $includeFile = true;
                
                if (!empty($filters)) {
                    if (isset($filters['extension'])) {
                        $fileExtension = pathinfo($item, PATHINFO_EXTENSION);
                        if (strtolower($fileExtension) != strtolower($filters['extension'])) {
                            $includeFile = false;
                        }
                    }
                    
                    if ($includeFile && isset($filters['startWithNumbers']) && $filters['startWithNumbers'] > 0) {
                        $pattern = '/^[0-9]{' . $filters['startWithNumbers'] . '}/';
                        if (!preg_match($pattern, $item)) {
                            $includeFile = false;
                        }
                    }
                }
                
                if ($includeFile) {
                    $result['files'][] = [
                        'name' => $item,
                        'path' => $fullPath,
                        'size' => filesize($fullPath),
                        'modified' => filemtime($fullPath)
                    ];
                }
            }
        }
        
        // Сортировка: сначала папки, потом файлы
        usort($result['directories'], function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        
        usort($result['files'], function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        
        return $result;
    }
}

// Пример использования

// Устанавливаем корневую директорию (для безопасности ограничиваем доступ только к ней)
$rootDir = realpath('./files'); // Измените на вашу директорию

// Получаем текущий путь из GET-параметра
$currentDir = isset($_GET['dir']) ? realpath($rootDir . DIRECTORY_SEPARATOR . $_GET['dir']) : $rootDir;

// Проверяем, что запрошенный путь находится внутри корневой директории
if ($currentDir === false || strpos($currentDir, $rootDir) !== 0) {
    $currentDir = $rootDir;
}

// Параметры фильтрации (можно получать из GET/POST)
$filters = [];
if (isset($_GET['extension'])) {
    $filters['extension'] = $_GET['extension'];
}
if (isset($_GET['startWithNumbers']) && is_numeric($_GET['startWithNumbers'])) {
    $filters['startWithNumbers'] = (int)$_GET['startWithNumbers'];
}

// Сканируем директорию
$directoryContent = DirectoryScanner::scanDirectory($currentDir, $filters);

// Выводим навигацию и содержимое
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Browser</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .path-navigation { margin-bottom: 20px; padding: 10px; background: #f0f0f0; }
        .directory-list, .file-list { list-style: none; padding: 0; }
        .directory-item, .file-item { padding: 5px; margin: 2px 0; }
        .directory-item { background: #e0e0ff; }
        .file-item { background: #e0ffe0; }
        .filters { margin: 20px 0; padding: 10px; background: #fff0e0; }
    </style>
</head>
<body>
    <h1>File Browser</h1>
    
    <div class="path-navigation">
        <strong>Current path:</strong> <?php echo htmlspecialchars($directoryContent['path']); ?>
        <?php if ($directoryContent['path'] != $rootDir): ?>
            <br><a href="?dir=<?php echo urlencode(substr($directoryContent['parent'], strlen($rootDir) + 1)); ?>">↑ Up one level</a>
        <?php endif; ?>
    </div>
    
    <div class="filters">
        <h3>Filters</h3>
        <form method="get">
            <input type="hidden" name="dir" value="<?php echo isset($_GET['dir']) ? htmlspecialchars($_GET['dir']) : ''; ?>">
            
            <label>
                Extension:
                <input type="text" name="extension" value="<?php echo isset($_GET['extension']) ? htmlspecialchars($_GET['extension']) : ''; ?>" placeholder="txt, jpg, etc">
            </label>
            
            <label>
                Start with numbers:
                <input type="number" name="startWithNumbers" value="<?php echo isset($_GET['startWithNumbers']) ? htmlspecialchars($_GET['startWithNumbers']) : ''; ?>" placeholder="2">
            </label>
            
            <button type="submit">Apply filters</button>
            <a href="?dir=<?php echo isset($_GET['dir']) ? urlencode($_GET['dir']) : ''; ?>">Clear filters</a>
        </form>
    </div>
    
    <h2>Directories</h2>
    <ul class="directory-list">
        <?php foreach ($directoryContent['directories'] as $dir): ?>
            <li class="directory-item">
                <a href="?dir=<?php echo urlencode(substr($dir['path'], strlen($rootDir) + 1)); ?>"><?php echo htmlspecialchars($dir['name']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <h2>Files</h2>
    <ul class="file-list">
        <?php foreach ($directoryContent['files'] as $file): ?>
            <li class="file-item">
                <?php echo htmlspecialchars($file['name']); ?>
                (<?php echo round($file['size'] / 1024, 2); ?> KB, modified: <?php echo date('Y-m-d H:i:s', $file['modified']); ?>)
            </li>
        <?php endforeach; ?>
        <?php if (empty($directoryContent['files'])): ?>
            <li>No files found</li>
        <?php endif; ?>
    </ul>
</body>
</html>
```

### Особенности этого кода:

1. **Класс DirectoryScanner**:
   - Сканирует директорию и возвращает структурированные данные
   - Поддерживает фильтрацию по расширению файла (`extension`)
   - Поддерживает фильтрацию по количеству цифр в начале имени файла (`startWithNumbers`)

2. **Безопасность**:
   - Используется `realpath()` для проверки путей
   - Ограничивает доступ только к файлам внутри корневой директории

3. **Навигация**:
   - Кнопка "Up one level" для перехода в родительскую директорию
   - Кликабельные папки для перехода внутрь них

4. **Фильтрация**:
   - Форма для установки параметров фильтрации
   - Возможность очистки фильтров

5. **Отображение**:
   - Четкое разделение папок и файлов
   - Отображение дополнительной информации о файлах (размер, дата изменения)

### Как использовать:

1. Сохраните код в файл `index.php`
2. Создайте папку `files` в той же директории (или измените `$rootDir` на нужный путь)
3. Откройте в браузере `index.php`

Вы можете легко расширить функционал, добавив дополнительные фильтры или информацию о файлах в классе `DirectoryScanner`.
