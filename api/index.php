<?php

# Definir el path
define('_ROOT_', '../');


# Cargadores principales
require _ROOT_ . 'framework/kernel/Config/Config.php';

function __load() {
    global $http;
    try {
        $obj = new anamnesis();
        if (!isset($_POST['rute'])) {
            throw new Exception('No se encuentra la ruta establecida');
        }
        $method = $_POST['rute'];
        $param = $_POST['data'];
        if (!method_exists($obj, $method)) {
            throw new Exception('No se encuentra la ruta establecida');
        }
        $a = $obj->$method($param);
        echo json_encode($a);
    } catch (Exception $ex) {
        echo json_encode(['success' => 0, 'msg' => $ex->getMessage()]);
    }
}

# Arrancar
if ($config['build']['production']) {
    try {
        __load();
    } catch (\Throwable $e) {
        ___catchApi();
    } catch (\Exception $e) {
        ___catchApi();
    }
} else {
    __load();
}
