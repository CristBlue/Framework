<?php
/* -----------------------------------------------------------------------------
 * █▀▀▄░▀█▀░█░█░▀█▀░█▀▀░▀█▀░█▀▀░    * @name  divisis_framework
 * █░ █░ █░ █▄█░ █░ ▀▀█░ █░ ▀▀█░    * @autor Brayan Narváez
 * ▀▀▀░ ▀▀▀░ ▀░ ▀▀▀░▀▀▀░▀▀▀ ▀▀▀░    * @email <prinick@ocrend.com>
 * -----------------------------------------------------------------------------
 * Mínimos requisitos para que un Router funcione adentro del framework.
 * -------------------------------------------------------------------------- */

namespace Divisis\Kernel\Router;

/**
 * Mínimos requisitos para que un Router funcione adentro del framework.
 *
 * @author Brayan Narváez <prinick@Divisis.com>
*/
interface IRouter {
    public function setRoute(string $index, string $rule);
    public function getRoute(string $index);
    public function getController();
    public function getMethod();
    public function getId(bool $with_rules);
    public function executeController();
}