<?php
/**
 * Author: york
 * Email: yorkshp@gmail.com
 * Date: 01.04.2020
 */
require ('./db/DB.php');


// Инициализация
$db = new \App\DB('localhost', 'root', '', 'sample');

// Выбрать данные
$all = $db->select('name')
    ->from('cat')
    ->where('id < 10')
    ->limit(3)
    ->offset(1)
    ->groupBy('id')
    ->all();

// Выбрать одну строку
$one = $db->select()->from('cat')->where('id = 1')->one();

// Выбрать одну по первичному ключу
$bypk = $db->select()->from('cat')->byPk(1);

// Вставить запись
$id = $db->insert('cat', [
    'name' => 'Процессор'
]);

// Редактировать запись
$db->update('cat', [
    'name' => 'Оперативная память'
], 4);

// Удалить
$db->delete('cat', [
    ['id' => 4],
    ['name' => 'Оперативная память']
]);

