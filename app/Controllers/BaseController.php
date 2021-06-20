<?php
namespace EssenceList\Controllers;

abstract class BaseController
{
    protected $requestType;

    abstract public function run();
}
