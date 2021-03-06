<?php


namespace App\Orders;


use App\DataHolder;

class Order extends DataHolder
{
    protected $properties = [
        'drink_id', 'timestamp', 'status'
    ];

    public function setDrinkId(int $drink_id)
    {
        $this->data['drink_id'] = $drink_id;
    }

    public function getDrinkId()
    {
        return $this->data['drink_id'] ?? null;
    }

    public function setTimestamp(int $timestamp)
    {
        $this->data['timestamp'] = $timestamp;
    }

    public function getTimestamp()
    {
        return $this->data['timestamp'] ?? null;
    }

    public function setStatus(string $status)
    {
        $this->data['status'] = $status;
    }

    public function getStatus()
    {
        return $this->data['status'] ?? null;
    }

}