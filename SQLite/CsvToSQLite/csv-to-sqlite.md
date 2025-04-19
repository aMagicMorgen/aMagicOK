### **Конвертация CSV в SQLite на PHP**  

Для преобразования CSV-файла в базу данных SQLite с помощью PHP можно использовать **PDO** (PHP Data Objects). Вот пошаговый код:

---

### **1. Подготовка CSV-файла**
Допустим, у вас есть файл `data.csv` с таким содержимым:  
```
id,name,email
1,Иван,ivan@example.com
2,Мария,maria@example.com
```  
(Кодировка: **UTF-8**)

---

### **2. PHP-скрипт для конвертации**
```php
<?php
// Настройки
$csvFile = 'data.csv';      // Путь к CSV-файлу
$dbFile = 'database.db';    // Имя SQLite-базы
$tableName = 'users';       // Имя таблицы

// Создаем или открываем базу SQLite
try {
    $pdo = new PDO("sqlite:$dbFile");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Читаем CSV
    if (($handle = fopen($csvFile, "r")) !== false) {
        // Первая строка = заголовки (названия колонок)
        $headers = fgetcsv($handle, 1000, ",");

        // Создаем таблицу (если её нет)
        $columns = implode(" TEXT, ", $headers) . " TEXT";  // Все поля как TEXT
        $pdo->exec("CREATE TABLE IF NOT EXISTS $tableName ($columns)");

        // Вставляем данные
        $stmt = $pdo->prepare("INSERT INTO $tableName VALUES (?" . str_repeat(",?", count($headers) - 1) . ")");
        
        while (($row = fgetcsv($handle, 1000, ",")) !== false) {
            $stmt->execute($row);
        }

        fclose($handle);
        echo "Данные успешно импортированы в SQLite!";
    }
} catch (PDOException $e) {
    die("Ошибка: " . $e->getMessage());
}
?>
```

---

### **3. Как это работает?**
1. **Открываем CSV-файл** и читаем первую строку (заголовки столбцов).  
2. **Создаем таблицу** в SQLite с колонками из CSV.  
3. **Вставляем данные** построчно в базу.  

---

### **4. Запуск скрипта**
1. Сохраните код в файл `csv_to_sqlite.php`.  
2. Положите его в одну папку с `data.csv`.  
3. Запустите в браузере:  
   ```
   http://localhost/csv_to_sqlite.php
   ```
   Или через командную строку:  
   ```
   php csv_to_sqlite.php
   ```

---

### **5. Проверка результата**
Откройте базу `database.db` в **DB Browser for SQLite** или выполните запрос:  
```sql
SELECT * FROM users;
```

---

### **Дополнительные настрой
