<?php
namespace EssenceList\Controllers;

abstract class BaseController
{
    protected $requestMethod;
    protected $action;

    abstract public function run();
}
