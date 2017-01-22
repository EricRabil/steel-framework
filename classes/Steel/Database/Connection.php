<?php
namespace Steel\Database;

use \Steel\Database\IConnection;
use \PDO;

/**
 * Default database-object for Steel applications.
 * 
 * Comes with built-in prepared statements (uses PDO,) advanced query-builders
 * 
 * @since   1.0
 * @author  Eric Rabil <ericjrabil@gmail.com>
 */
class Connection implements IConnection {

    private $conn;

    public function __construct($database = []) {
        if(empty($database)){
            return null;
        }
        if ($database['enabled']) {
            try {
                $this->conn = new PDO('mysql:dbname=' . $database['dbname'] . ';host=' . $database['ip'] . ';port=' . $database['port'], $database['username'], $database['password'], array(PDO::ATTR_PERSISTENT => TRUE));
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->conn->exec("SET NAMES utf8");
            } catch (\PDOException $e) {
                die($e);
            }
        }
    }

    public function delete($table, $conditions = []) {
        if (empty($table) || empty($conditions)) {
            return 999;
        }
        $statement = sprintf("DELETE FROM `%s` WHERE", (string)$table);
        $preparedValues = [];
        if (empty($conditions)) {
            $statement .= " 1";
        }else {
            $lastcolumn = \Steel\ArrayMethods::lastKey($conditions);
            foreach ($conditions as $column => $value) {
                if ($column === $lastcolumn) {
                    $statement .= " " . $column . " = ?";
                }else {
                    $statement .= " " . $column . " = ? AND";
                }
                array_push($preparedValues, $value);
            }
        }
        $stmt = $this->conn->prepare($statement);
        $stmt->execute($preparedValues);
        return $stmt->errorCode();
    }

    public function truncate($table) {
            if (empty($table)) {
                return 999;
            }
            $statement = sprintf("DELETE FROM `%s` WHERE 1", (string)$table);
            $stmt = $this->conn->prepare($statement);
            $stmt->execute();
            return $stmt->errorCode();
    }

    public function insert($table, $values = []) {
        $statement = sprintf("INSERT INTO %s (", $table);
        if (empty($values) || empty($table)) {
            return 999;
        }
        foreach ($values as $key => $val) {
            if ($key === \Steel\ArrayMethods::lastKey($values)) {
                $statement .= sprintf("`%s`)", (string)$key);
            }else {
                $statement .= sprintf("`%s`, ", (string)$key);
            }
        }
        $statement .= " VALUES (";
        $size = count($values) - 1;
        if ($size === 1) {
            $statement .= "?);";
        }else {
            for ($k = 0; $k < $size && $k != $size; $k ++) {
                $statement .= "?, ";
            }
            $statement .= "?);";
        }
        $stmt = $this->conn->prepare($statement);
        echo $stmt->queryString;
        $stmt->execute(array_values($values));
        return $stmt->errorCode();
    }

    public function prepared($statement, $values = [], $giveresults = false) {
        if (empty($statement)) {
            return 999;
        }
        $stmt = $this->conn->prepare($statement);
        $stmt->execute($values);
        if ($giveresults) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function query($query) {
        if (empty($query)) {
            return 999;
        }
        return $this->conn->query($query);
    }

    public function select($table, $conditions = [], $columns = []) {
        if (empty($table)) {
            return 999;
        }
        $statement = "SELECT ";
        if (empty($columns)) {
            $statement .= "* ";
        }else {
            $sanitized = array_values($columns);
            if (count($columns) === 1) {
                $statement .= sprintf("%s ", (string)$sanitized[0]);
            }else {
                foreach ($columns as $column) {
                    if ($column !== \Steel\ArrayMethods::lastValue($columns)) {
                        $statement .= sprintf("%s, ", (string)$column);
                    }else {
                        $statement .= sprintf("%s ", (string)$column);
                    }
                }
            }
        }
        $statement .= sprintf("FROM `%s` WHERE ", $table) . $this->process_condition_sel_upd($conditions);
        $stmt = $this->conn->prepare($statement);
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($table, $updates = [], $conditions = []) {
        if (empty($table) || empty($updates) || empty($conditions)) {
            return 999;
        }
        $statement = sprintf("UPDATE `%s` SET ", $table) . $this->process_updates($updates) . " WHERE " . $this->process_condition_sel_upd($conditions);
        $stmt = $this->conn->prepare($statement);
        $updateValues = array_values($updates);
        $conditionValues = array_values($conditions);
        $stmt->execute(array_merge($updateValues, $conditionValues));
        return $stmt->errorCode();
    }

    public function update_all($table, $updates = []) {
        if (empty($table) || empty($updates)) {
            return 999;
        }
        $statement = sprintf("UPDATE `%s` SET ", $table) . $this->process_updates($updates) . " WHERE 1";
        $stmt = $this->conn->prepare($statement);
        $updateValues = array_values($updates);
        $stmt->execute(array_merge($updateValues));
        return $stmt->errorCode();
    }

    public function get_pdo() {
        return $this->conn;
    }
    
    private function process_condition_sel_upd($conditions) {
        $statement = "";
        if (empty($conditions)) {
            $statement .= "1";
        }else {
            foreach ($conditions as $column => $row) {
                if ($column !== \Steel\ArrayMethods::lastKey($conditions)) {
                    $statement .= sprintf("`%s` = ? AND ", (string)$column);
                }else {
                    $statement .= sprintf("`%s` = ?;", (string)$column);
                }
            }
        }
        return $statement;
    }
    
    private function process_updates($updates) {
        $statement = "";
            if (count($updates === 1)) {
                $statement .= sprintf("`%s` = ? ", key($updates));
            }else {
                foreach ($updates as $column => $newcolumn) {
                    if ($column !== \Steel\ArrayMethods::lastKey($updates)) {
                        $statement .= sprintf("`%s` = ?, ", $column);
                    }else {
                        $statement .= sprintf("`%s` = ?;", $column);
                    }
                }
            }
        return $statement;
    }

}
