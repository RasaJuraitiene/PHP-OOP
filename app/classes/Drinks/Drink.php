<?php


namespace App\Drinks;


class Drink
{
    private $data;
    private $properties = [
        'name', 'amount', 'abarot', 'image', 'id'
    ];

    public function setName(string $name)
    {
        $this->data['name'] = $name;
    }

    public function getName()
    {
        return $this->data['name'] ?? null;
    }

    public function setAmount(int $amount_ml)
    {
        $this->data['amount'] = $amount_ml;
    }

    public function getAmount()
    {
        return $this->data['amount'];
    }

    public function setAbarot(float $abarot)
    {
        $this->data['abarot'] = $abarot;
    }

    public function getAbarot()
    {
        return $this->data['abarot'];
    }

    public function setImage(string $url)
    {
        $this->data['image'] = $url;
    }

    public function getImage()
    {
        return $this->data['image'];
    }

    public function setId(int $id)
    {
        $this->data['id'] = $id;
    }

    public function getId()
    {
        return $this->data['id'];
    }

    public function setData(array $data)
    {
        foreach ($this->properties as $property) {
            if (isset($data[$property])) {

                $value = $data[$property];
                /* amount_ml */
                $setter = str_replace('_', '', 'set' . $property);
                /* setamountml */

                /* setAmountMl(...) */
                // $this->setAmountMl(...);

                $this->{$setter}($value);
            }
        }
//        Antras budas apsirasymui
//        if(isset($data['name'])) $this->setName($data['name']);
//        if(isset($data['amount'])) $this->setName($data['amount']);
//        if(isset($data['abarot'])) $this->setName($data['abarot']);
//        if(isset($data['image'])) $this->setName($data['image']);
    }

    public function getData()
    {
        $data = [];

        foreach ($this->properties as $property) {
            $getter = str_replace('_', '', 'get' . $property);

            $data[$property] = $this->{$getter}();
        }
        return $data;
    }

    public function __construct(array $data = null)
    {
        if ($data) {
            $this->setData($data);
        }
    }
}