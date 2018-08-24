<?php

/* -----------------------------------------------------------------------------
 * █▀▀▄░▀█▀░█░█░▀█▀░█▀▀░▀█▀░█▀▀░    * @name  divisis_framework
 * █░ █░ █░ █▄█░ █░ ▀▀█░ █░ ▀▀█░    * @autor Brayan Narváez
 * ▀▀▀░ ▀▀▀░ ▀░ ▀▀▀░▀▀▀░▀▀▀ ▀▀▀░    * @email <prinick@ocrend.com>
 * -----------------------------------------------------------------------------
 * Estructura elemental para el correcto funcionamiento de cualquier controlador en el sistema.
 * -------------------------------------------------------------------------- */

namespace framework\kernel\Controllers;

use framework\kernel\Router\IRouter;

/**
 * Estructura elemental para el correcto funcionamiento de cualquier controlador en el sistema.
 *
 * @author Brayan Narváez <prinick@Divisis.com>
 */
interface IControllers {

    public function __construct(IRouter $router);
}
