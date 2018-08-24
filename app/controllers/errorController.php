<?php

/* -----------------------------------------------------------------------------
 * █▀▀▄░▀█▀░█░█░▀█▀░█▀▀░▀█▀░█▀▀░    * @name  divisis_framework
 * █░ █░ █░ █▄█░ █░ ▀▀█░ █░ ▀▀█░    * @autor Brayan Narváez
 * ▀▀▀░ ▀▀▀░ ▀░ ▀▀▀░▀▀▀░▀▀▀ ▀▀▀░    * @email <prinick@ocrend.com>
 * -----------------------------------------------------------------------------
 * Controlador error/
 * -------------------------------------------------------------------------- */

namespace app\controllers;

use app\models as Model;
use framework\kernel\Controllers\Controllers;
use framework\kernel\Controllers\IControllers;
use framework\kernel\Router\IRouter;

/**
 * Controlador error/
 *
 * @author Divisis Software C.A <bnarvaez@Divisis.com>
 */
class errorController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router, ['users_not_logged' => true,
            'users_logged' => true
        ]);
        $this->template->display('error/404.twig');
    }

}
