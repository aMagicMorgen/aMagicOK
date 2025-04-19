### **PHP-код для экспорта SQLite в CSV**

Этот скрипт выгружает данные из таблицы SQLite в CSV-файл:

```php
<?php
// Настройки
$dbFile = 'db.sqlite';     // Путь к SQLite-базе
$tableName = 'users';      // Имя таблицы (измените на нужную)
$csvFile = 'export.csv';   // Файл для экспорта

try {
    // Подключаемся к SQLite
    $pdo = new PDO("sqlite:$dbFile");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получаем данные из таблицы
    $stmt = $pdo->query("SELECT * FROM $tableName");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($data)) {
        die("Таблица '$tableName' пуста или не существует.");
    }

    // Открываем CSV для записи
    $file = fopen($csvFile, 'w');

    // Записываем заголовки (названия колонок)
    fputcsv($file, array_keys($data[0]));

    // Записываем данные
    foreach ($data as $row) {
        fputcsv($file, $row);
    }

    fclose($file);
    echo "Данные успешно экспортированы в '$csvFile'!";

} catch (PDOException $e) {
    die("Ошибка: " . $e->getMessage());
}
?>
```

---

### **Как это работает?**
1. **Подключение к SQLite**: Используется PDO для доступа к базе.
2. **Чтение данных**: Запрос `SELECT * FROM table` получает все строки.
3. **Создание CSV**: 
   - Первая строка — заголовки (названия колонок).
   - Остальные строки — данные из таблицы.
4. **Сохранение**: Результат записывается в файл `export.csv`.

---

### **Запуск скрипта**
1. Сохраните код в файл `sqlite_to_csv.php`.
2. Убедитесь, что `db.sqlite` существует и доступен для чтения.
3. Выполните в браузере:  
   ```
   http://localhost/sqlite_to_csv.php
   ```
   Или через командную строку:  
   ```
   php sqlite_to_csv.php
   ```

---

### **Дополнительные настройки**
- **Кодировка CSV**: По умолчанию используется UTF-8. Если нужна другая кодировка, добавьте:  
  ```php
  fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM для UTF-8
  ```
- **Выбор столбцов**: Если нужны не все колонки, измените SQL-запрос:  
  ```php
  $stmt = $pdo->query("SELECT id, name FROM $tableName");
  ```

---

### **Проверка результата**
Откройте `export.csv` в Excel или текстовом редакторе. Данные должны отображаться корректно. Если вместо кириллицы «кракозябры», проверьте кодировку файла.
