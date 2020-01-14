<?php


namespace App\Drinks;


use Core\FileDB;

class Model
{
    private $table_name = 'drinks';
    private $db;
    private $conditions;

    public function __construct()
    {
        $this->db = New FileDB(DB_FILE);
        $this->db->load();
        $this->db->createTable($this->table_name);
    }

    public function insert(Drink $drink)
    {
        return $this->db->insertRow($this->table_name, $drink->getData());
    }

    public function get($conditions)
    {
        $drinks_objects = [];
        $drinks_array = $this->db->getRowsWhere($this->table_name, $conditions);

        foreach ($drinks_array as $row_id => $drink_array) {
            $drink = new Drink($drinks_array);
            $drink->setId($row_id);

            $drinks_objects[] = $drink;
        }

    return $drinks_objects;
}

}