> const CACHE_LIFETIME = 300;  
> Это обозначает, что кеш каждые пять минут будет обновляться?
> А если мне не нужно так часто сканировать директорию, а чтобы этот файл json был постоянным и например пересканировать принудительно было бы по GET ?r=1
>
Да, вы правильно поняли. В текущей реализации кэш автоматически обновляется каждые 5 минут (300 секунд). Давайте модифицируем код, чтобы:

1. Сделать кэш постоянным (без автоматического обновления по времени)
2. Добавить принудительное обновление по параметру `?r=1`
3. Сохранить все остальные функции

Вот улучшенный код:

```php
<?php
class DirectoryScanner {
    const CACHE_FILE = 'directory_cache.json';
    
    /**
     * Сканирует директорию с использованием кэша
     */
    public static function scanDirectoryWithCache($path, $filters = [], $forceRefresh = false) {
        $cacheKey = md5($path . serialize($filters));
        
        // Если не принудительное обновление, пробуем получить из кэша
        if (!$forceRefresh) {
            $cachedData = self::getFromCache($cacheKey);
            if ($cachedData !== null) {
                return $cachedData;
            }
        }

        // Сканируем директорию и сохраняем в кэш
        $result = self::scanDirectory($path, $filters);
        self::saveToCache($cacheKey, $result);
        
        return $result;
    }

    private static function getFromCache($key) {
        if (!file_exists(self::CACHE_FILE)) {
            return null;
        }

        $data = json_decode(file_get_contents(self::CACHE_FILE), true);
        if (!isset($data[$key])) {
            return null;
        }

        // Проверяем, изменилась ли директория
        $dirModificationTime = @filemtime($data[$key]['data']['path']);
        if ($dirModificationTime === false || $dirModificationTime > $data[$key]['timestamp']) {
            return null;
        }

        return $data[$key]['data'];
    }

    private static function saveToCache($key, $data) {
        $cacheData = [];
        if (file_exists(self::CACHE_FILE)) {
            $cacheData = json_decode(file_get_contents(self::CACHE_FILE), true);
        }

        $cacheData[$key] = [
            'timestamp' => time(),
            'data' => $data
        ];

        file_put_contents(self::CACHE_FILE, json_encode($cacheData));
    }

    // ... (остальные методы класса остаются без изменений)
}

// Устанавливаем корневую директорию
$rootDir = realpath('./files');

// Проверяем параметр принудительного обновления
$forceRefresh = isset($_GET['r']) && $_GET['r'] == '1';

// Получаем текущий путь
$currentDir = isset($_GET['dir']) ? realpath($rootDir . DIRECTORY_SEPARATOR . $_GET['dir']) : $rootDir;

// Проверяем безопасность пути
if ($currentDir === false || strpos($currentDir, $rootDir) !== 0) {
    $currentDir = $rootDir;
}

// Параметры фильтрации
$filters = [];
if (isset($_GET['extension'])) {
    $filters['extension'] = $_GET['extension'];
}
if (isset($_GET['startWithNumbers']) && is_numeric($_GET['startWithNumbers'])) {
    $filters['startWithNumbers'] = (int)$_GET['startWithNumbers'];
}

// Сканируем директорию (с кэшированием)
$directoryContent = DirectoryScanner::scanDirectoryWithCache($currentDir, $filters, $forceRefresh);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Browser</title>
    <style>
        /* ... (стили остаются без изменений) ... */
        .refresh-btn {
            display: inline-block;
            margin-left: 10px;
            padding: 2px 8px;
            background: #ffd0d0;
            text-decoration: none;
            border-radius: 3px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <h1>File Browser 
        <a href="?dir=<?php echo isset($_GET['dir']) ? urlencode($_GET['dir']) : ''; ?>&r=1" 
           class="refresh-btn" 
           title="Force refresh cache">⟳ Refresh</a>
    </h1>
    
    <!-- ... (остальная часть HTML остается без изменений) ... -->
</body>
</html>
```

### Ключевые изменения:

1. **Удалена константа `CACHE_LIFETIME`** - теперь кэш не устаревает по времени
2. **Добавлен параметр `$forceRefresh`** в метод `scanDirectoryWithCache()`
3. **Кэш обновляется только в двух случаях**:
   - При явном запросе (`?r=1`)
   - Если изменилось содержимое директории (проверка по времени модификации)
4. **Добавлена кнопка "Refresh"** в интерфейсе для принудительного обновления

### Как это работает:

1. По умолчанию система использует кэшированные данные
2. Кэш сохраняется до тех пор, пока не изменится содержимое директории
3. Для принудительного обновления нужно:
   - Добавить `?r=1` к URL
   - Или нажать кнопку "Refresh" в интерфейсе

### Преимущества этой реализации:

1. **Максимальная производительность** - минимум операций сканирования директории
2. **Актуальность данных** - кэш автоматически обновляется при изменениях
3. **Контроль со стороны пользователя** - возможность принудительного обновления
4. **Экономия ресурсов** - особенно важно для больших директорий

Вы можете дополнительно настроить поведение, например:
- Добавить кнопку "Refresh" рядом с каждой папкой
- Реализовать автоматическое обновление кэша через cron
- Добавить индикатор "данные из кэша" / "данные обновлены"
