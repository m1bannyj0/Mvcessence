<?php
namespace EssenceList\Controllers;

abstract class BaseController
{
    protected $requestType;
    protected $action;

    abstract public function run();
}
