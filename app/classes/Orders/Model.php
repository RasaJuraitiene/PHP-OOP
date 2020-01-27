<?php


namespace App\Orders;


use App\App;
use App\Drinks\Drink;
use App\orders\order;

class Model
{
    private $table_name = 'orders';
    private $db;
    private $conditions;

    public function __construct()
    {
        App::$db->createTable($this->table_name);
    }

    public function insert(Order $order)
    {
        return App::$db->insertRow($this->table_name, $order->getData());
    }

    /**Grazina prafiltruota objektu masyva(masyva is objektu)
     *
     * @param $conditions
     * @return array
     *
     */
    public function get($conditions)
    {
        $orders_objects = [];
        $orders_array = App::$db->getRowsWhere($this->table_name, $conditions);

        foreach ($orders_array as $row_id => $order_array) {
            $order = new Order($order_array);
            $order->setId($row_id);

            $orders_objects[] = $order;
        }

        return $orders_objects;
    }

    public function getById($row_id) {
        $order_array = App::$db->getRow($this->table_name, $row_id);

        if ($order_array) {
            $order = new \App\Orders\Order($order_array);
            $order->setId($row_id);

            return $order;
        }

        return null;
    }

    public function update(order $order)
    {
        return App::$db->updateRow($this->table_name, $order->getId(), $order->getData());
    }

    public function delete(order $order)
    {
        if ($order->getId() !== null) {
            return App::$db->deleteRow($this->table_name, $order->getId());
        }

        return false;
    }

}