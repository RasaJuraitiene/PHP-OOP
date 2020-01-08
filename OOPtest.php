<?php

class Car {

    private $gamintojas;
    private $modelis;

    public function __construct($gamintojas, $modelis)
    {
        $this->gamintojas = $gamintojas;
        $this->modelis = $modelis;
    }

    public function getName()
    {
        return $this->gamintojas . ' - ' . $this->modelis;

    }

}

$fiat = New Car('Fiat', 'Punto');
var_dump($fiat->getName());

$lancia = New Car('Lancia', 's');
var_dump($lancia->getName());

//$fiat->gamintojas = 'Audi';
//(Pakeisti esama iskviesta gamintoja)