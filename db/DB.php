<?php
/**
 * Author: york
 * Email: yorkshp@gmail.com
 * Date: 01.04.2020
 */

namespace App;

require ('PdoDB.php');

class DB extends PdoDB
{
    /**
     * DB constructor.
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     * TODO подгружать конкретный драйвер БД
     */
    public function __construct($host, $user, $password, $database)
    {
        parent::__construct($host, $user, $password, $database);
    }
}
