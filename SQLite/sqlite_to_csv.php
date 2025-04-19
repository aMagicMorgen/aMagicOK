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
