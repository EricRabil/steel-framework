<?php
namespace Steel\Database;

interface IConnection{
    public function __construct( \Steel\Steel $steel );
    public function insert($table, $values = []);
    public function select($table, $conditions = [], $columns = []);
    public function update($table, $updates = [], $conditions = []);
    public function update_all($table, $updates = []);
    public function delete($table, $conditions = []);
    public function truncate($table);
    public function prepared($statement, $values);
    public function query($query);
    public function get_pdo();
}
