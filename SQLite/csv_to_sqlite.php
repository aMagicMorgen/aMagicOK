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
