<?php

namespace Core;

class FileDB
{

    private $file_name;
    private $data;

    /**
     * FileDB constructor.
     * @param $file_name
     */
    public function __construct($file_name)
    {
        $this->file_name = $file_name;
        $this->load();
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function save()
    {
        $encoded_array = json_encode($this->data);
        $bytes_written = file_put_contents($this->file_name, $encoded_array);
        if ($bytes_written !== false) {
            return true;
        }
        return false;
    }

    public function load()
    {
        if (file_exists($this->file_name)) {
            $this->data = json_decode(file_get_contents($this->file_name), true);
        } else {
            $this->data = [];
        }
    }

    /** F-ja kuri iraso tuscia masyva i Data file
     * @param $table_name
     * @return bool
     */
    public function createTable($table_name)
    {
        if (!$this->tableExists($table_name)) {
            $this->data[$table_name] = [];
            return true;
        }

        return false;
    }

    /**F-ja tikrina ar lentele(Table_name indexas) duomenu bazeje egzistuoja
     *
     * @param $table_name
     * @return bool
     *
     */
    public function tableExists($table_name)
    {
        if (isset($this->data[$table_name])) {
            return true;
        }
        return false;
    }

    /** Istrina indeksa is Data DB
     *
     * @param $table_name
     * @return bool
     */
    public function dropTable($table_name)
    {
        if ($this->tableExists($table_name)) {
            unset($this->data[$table_name]);
            return true;
        }
        return false;
    }

    /**Tikrina ar toks table indexas egzistuojas, jei egzistuoja isvalo lentele, bet jos neistrina
     *
     * @param $table_name
     * @return bool
     */
    public function truncateTable($table_name)
    {
        if ($this->tableExists($table_name)) {
            $this->data[$table_name] = [];
            return true;
        }
        return false;
    }

    public function insertRow($table_name, $row, $row_id = null)
    {
        if ($row_id) {
            if (!$this->rowExists($table_name, $row_id)) {
                $this->data[$table_name][$row_id] = $row;
                return $row_id;
            } else {
                return false;
            }
        } else {
            $this->data[$table_name][] = $row;
            return array_key_last($this->data[$table_name]);
        }
    }

    public function rowExists($table_name, $row_id)
    {
        if (isset($this->data[$table_name][$row_id])) {
            return true;
        }
        return false;
    }

    public function updateRow($table_name, $row_id, $row)
    {
        if ($this->rowExists($table_name, $row_id)) {
            $this->data[$table_name][$row_id] = $row;
            return true;
        }
        return false;
    }

    /**
     *
     * @param $table_name
     * @param $row_id
     * @return bool
     */
    public function deleteRow($table_name, $row_id)
    {
        if ($this->rowExists($table_name, $row_id)) {
            unset($this->data[$table_name][$row_id]);
            return true;
        }
        return false;
    }

    public function getRow($table_name, $row_id)
    {
        if ($this->rowExists($table_name, $row_id)) {
            return $this->data[$table_name][$row_id];
        }
        return false;

    }

    public function getRowsWhere($table_name, array $conditions)
    {
        $results = [];

        foreach ($this->data[$table_name] as $row_id => $row) {

            /* ['username' => 'Alius', ...] */
            $found = true;
            foreach ($conditions as $condition_index => $condition_value) {
                /* $condition_index = 'username', $condition_value = 'Alius' */
                $row_value = $row[$condition_index];
                if ($row_value !== $condition_value) {
                    $found = false;
                    break;
                }
            }

            if ($found) $results[$row_id] = $row;
            
        }

        return $results;
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->save();
    }
}

