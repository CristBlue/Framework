<?php

namespace Divisis\Kernel\Router;

interface IRouter {

    public function setRoute(string $index, string $rule);

    public function getRoute(string $index);

    public function getController();

    public function getMethod();

    public function getId(bool $with_rules);

    public function executeController();
}
