<?php


namespace App\Drinks;


use App\App;
use Core\FileDB;

class Model
{
    private $table_name = 'drinks';
    private $db;
    private $conditions;

    public function __construct()
    {
        App::$db->createTable($this->table_name);
    }

    public function insert(Drink $drink)
    {
        return App::$db->insertRow($this->table_name, $drink->getData());
    }

    /**Grazina prafiltruota objektu masyva(masyva is objektu)
     *
     * @param $conditions
     * @return array
     *
     */
    public function get($conditions)
    {
        $drinks_objects = [];
        $drinks_array = App::$db->getRowsWhere($this->table_name, $conditions);

        foreach ($drinks_array as $row_id => $drink_array) {
            $drink = new Drink($drink_array);
            $drink->setId($row_id);

            $drinks_objects[] = $drink;
        }

        return $drinks_objects;
    }

    public function getById($row_id) {
        $drink_array = App::$db->getRow($this->table_name, $row_id);

        if ($drink_array) {
            $drink = new Drink($drink_array);
            $drink->setId($row_id);

            return $drink;
        }

        return null;
    }

    public function update(Drink $drink)
    {
        return App::$db->updateRow($this->table_name, $drink->getID(), $drink->getData());
    }

    public function delete(Drink $drink)
    {
        return App::$db->deleteRow($this->table_name, $drink->getID());
    }
}