<?php

namespace Core\Abstracts;

abstract class DataHolder
{
    protected $data;
    protected $properties;

    abstract protected function setData(Array $data);

    abstract protected function getData();

}