<?php
/**
 * Author: yorks
 * Date: 01.04.2020
 */

namespace App;
use mysql_xdevapi\Exception;

require ('QueryBuilder.php');

/**
 * Class Database
 * @package App
 */
abstract class Database
{

    /**
     * @var null|QueryBuilder
     */
    public $builder = null;

    /**
     * Database constructor.
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     */
    public function __construct($host, $user, $password, $database)
    {
        $this->connect($host, $user, $password, $database);
    }

    /** Connect to database
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     * @return mixed
     */
    abstract protected function connect(string $host, string $user, string $password, string $database);

    /** Select data from database
     * @param string $fields
     * @return mixed
     */
    abstract public function select(string $fields = '*');

    /** Select one row from database
     * @param string $query
     * @return mixed
     */
    abstract public function one(string $query);

    /** Select row by primary key
     * @param string $query
     * @return mixed
     */
    abstract public function byPk(string $query);

    /** Select all data
     * @param string $query
     * @return mixed
     */
    abstract public function all(string $query);

    /** Get count of query
     * @param string $query
     * @return mixed
     */
    abstract public function count(string $query);

    /** Insert data into database
     * @param string $table
     * @param array $array
     * @return mixed
     */
    abstract public function insert(string $table, array $array);

    /** Update data
     * @param string $table
     * @param array $array
     * @param $where
     * @return bool
     */
    abstract public function update(string $table, array $array, $where): bool;

    /** Remove data from DB
     * @param string $table
     * @param $where
     * @return bool
     */
    abstract public function delete(string $table, $where): bool;

    /** Generate inset query string from data
     * @param array $values
     * @return string
     */
    protected function prepareInsertQuery(array $values): string
    {
        $keys = [];
        $vals = [];
        foreach ($values as $key => $value) {
            $val = htmlspecialchars($value);
            $keys[] = $key;
            $vals[] = $val;
        }
        $key_string = implode(',', $keys);
        $value_string = implode(',', $vals);
        return "({$key_string}) VALUES ($value_string)";
    }

    /** Generate update query string from data
     * @param array $values
     * @return string
     */
    protected function prepareUpdateQuery(array $values): string
    {
        $return = [];
        foreach ($values as $key => $value) {
            $val = htmlspecialchars($value);
            $return[] = "`$key` = '$val'";
        }

        return implode(',', $return);
    }

    /** Execute where condition it can be int, string or array
     * @param $where
     * @return mixed
     */
    protected function executeWhere($where)
    {
        if (is_int($where)) {
            $where = "id = {$where}";
        } elseif (is_array($where)) {
            $where = $this->prepareWhereQueryArray($where);
        } elseif (!is_string($where)) {
            throw new Exception("Incorrect where clause");
        }

        return $where;
    }

    /** Execute where condition from array
     * @param array $where
     * @return mixed
     */
    protected function prepareWhereQueryArray(array $where)
    {
        $return = [];
        $i = 0;
        foreach ($where as $key => $value) {
            if (is_array($value)) {
                $condition = $value[1] ?? '=';
                $or_and = $i > 0 ? ($value[2] ?? 'AND') : '';
                $return[] = "{$or_and} {$key} {$condition} {$value[0]}";
            } else {
                $return[] = "{$key} = {$value}";
            }
            $i++;
        }

        return implode(',', $return);
    }
}
