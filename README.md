# Класс для досупа к БД

### Подключение
```PHP
$db = new \App\DB('localhost', 'root', '', 'sample');
```

### Выбрать данные
```PHP
$data = $db->select('name')
     ->from('cat')
     ->where('id < 10')
     ->limit(3)
     ->offset(1)
     ->groupBy('name')
     ->all();
 ```

### Выбрать одну запись
```PHP
$db->select()->from('cat')->where('id = 1')->one();
```

### Выбрать одну запись по PK
```PHP
$db->select()->from('cat')->byPk(1);
or
$db->select()->from('cat')->byPk(1, 'ID');
```

### Вставить запись
```PHP
$id = $db->insert('cat', [
    'name' => 'Процессор'
]);
```
### Редактировать запись
```PHP
$db->update('cat', [
    'name' => 'Оперативная память'
], 4);
```

### Удалить запись
```PHP
$db->delete('cat', [
   ['id' => 4],
   ['name' => 'Оперативная память']
]);
```
### Условия при редактировании / удалении
```PHP
$db->update('cat', ['name' => 'Оперативная память'], 4); // id = 4

$db->update('cat', ['name' => 'Оперативная память'], 'id = 4'); // id = 4

$db->update('cat', ['name' => 'Оперативная память'], ['id' => 4]); // id = 4

$db->update('cat', ['name' => 'Оперативная память'], [
    'id' => 4, 
    'name' => ['Проц%', 'LIKE', 'OR']
]); // id = 4 OR name LIKE 'Проц%'
```


### Changelog
#### 1.0 (02.04.2020) 
* Инициализация
* Добавлена работа с PDO


### TODO
1. Реализовать парсинг условий при выборке
2. Добавить другие базы данных
