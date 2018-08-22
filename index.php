<?php

use Divisis\Kernel\Router\Router;

#definición de path
define('_ROOT_', '');

#importar configuración
require _ROOT_ . 'framework/kernel/config/config.php';
# Ejecutar controlador solicitado

(new Router)->executeController();
