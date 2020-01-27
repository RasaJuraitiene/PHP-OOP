<?php


namespace App;


class DataHolder extends \Core\Abstracts\DataHolder
{

    public function setData(Array $data)
    {
        // TODO: Implement setData() method.
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
    }

        public function getData()
        {
            // TODO: Implement getData() method.
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