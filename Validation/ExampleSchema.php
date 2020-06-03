<?php
use Dry\DryStruct;

class ExampleSchema extends DryStruct 
{
  public function __construct() {
    parent::__construct();
    self::required('name')->filled('string');
    self::optional('age')->filled('integer')->min(6);
  }
}