<?php

/* -----------------------------------------------------------------------------
 * █▀▀▄░▀█▀░█░█░▀█▀░█▀▀░▀█▀░█▀▀░    * @name  divisis_framework
 * █░ █░ █░ █▄█░ █░ ▀▀█░ █░ ▀▀█░    * @autor Brayan Narváez
 * ▀▀▀░ ▀▀▀░ ▀░ ▀▀▀░▀▀▀░▀▀▀ ▀▀▀░    * @email <prinick@ocrend.com>
 * -----------------------------------------------------------------------------
 * Encargado de controlar las URL Amigables en cada controlador del sistema, es independiente al Routing de Silex.
 * Define por defecto 3 rutas escenciales, controlador, método e id.
 * -------------------------------------------------------------------------- */

namespace Divisis\Kernel\Router;

use Divisis\Kernel\Router\IRouter;
use Divisis\Kernel\Router\Rules;
use Divisis\Kernel\Token\Token;
use Divisis\Kernel\Helpers as Helper;
use Exception;

final class Router implements IRouter {

    /**
     * Reglas definidas en Rules.php
     *
     * @var array CONSTANTE con las reglas permitidas
     */
    const RULES = [
        'none', # Sin ninguna regla
        'letters', # Solamente letras
        'alphanumeric', # Letras y números
        'url', # Con forma para URL (letras,números y el carácter -)
        'integer', # Solamente números enteros
        'integer_positive', # Solamente números enteros positivos
        'float', # Solamente números flotantes
        'float_positive' # Solamente números flotantes positivos
    ];

    /**
     * Colección de rutas existentes
     *
     * @var array
     */
    private $routerCollection = array(
        '/controller' => 'home', # controlador por defecto
        '/method' => null, # método por defecto
        '/id' => null # id por defecto
    );

    /**
     * Colección de reglas para cada ruta existente
     *
     * @var array
     */
    private $routerCollectionRules = array(
        '/controller' => 'letters',
        '/method' => 'none',
        '/id' => 'none'
    );

    /**
     * Petición real estructurada
     *
     * @var array
     */
    private $real_request = array();

    /**
     * Uri requerida por el cliente final
     *
     * @var string
     */
    private $requestUri;

    /**
     * __construct()
     */
    public function __construct() {
        global $http;

        # Obtener las peticiones
        $this->requestUri = $http->query->get('routing');
        # Verificar las peticiones
        $this->checkRequests();
    }

    /**
     * Coloca una regla destinada a una ruta, siempre y cuando esta regla exista.
     *
     * @param string $index : Índice de la ruta
     * @param string $rule : Nombre de la regla
     *
     * @throws \RuntimeException si la regla no existe
     * @return void
     */
    final private function setCollectionRule(string $index, string $rule) {
        # Verificar si la regla existe
        if (!in_array($rule, self::RULES)) {
            throw new \RuntimeException('La regla ' . $rule . ' no existe.');
        }
        # Definir la regla para la ruta
        $this->routerCollectionRules[$index] = $rule;
    }

    /**
     * Verifica las peticiones por defecto
     */
    final private function checkRequests() {
        global $config;
        # Verificar si existe peticiones
        if (null !== $this->requestUri) {
            $this->real_request = explode('/', $this->requestUri);
            $this->routerCollection['/controller'] = $this->real_request[0];
        } else {
            $this->routerCollection['/controller'] = $config['build']['controller_ini'];
        }

        # Setear las siguientes rutas
        $this->routerCollection['/method'] = array_key_exists(1, $this->real_request) ? $this->real_request[1] : null;
        $this->routerCollection['/id'] = array_key_exists(2, $this->real_request) ? $this->real_request[2] : null;
    }

    /**
     * Crea una nueva ruta.
     *
     * @param string $index : Índice de la ruta
     * @param string $rule : Nombre de la regla, por defecto es ninguna "none"
     *
     * @throws \RuntimeException si no puede definirse la ruta
     */
    final public function setRoute(string $index, string $rule = 'none') {
        # Nombres de rutas no permitidos
        if (in_array($index, ['/controller', '/method', '/id'])) {
            throw new \RuntimeException('No puede definirse ' . $index . ' como índice en la ruta.');
        }

        # Sobreescribir
        unset($this->routerCollection[$index], $this->routerCollectionRules[$index]);

        # Definir la ruta y regla
        $lastRoute = sizeof($this->routerCollection);
        $this->routerCollection[$index] = array_key_exists($lastRoute, $this->real_request) ? $this->real_request[$lastRoute] : null;
        $this->setCollectionRule($index, $rule);
    }

    /**
     * Obtiene el valor de una ruta según la regla que ha sido definida y si ésta existe.
     *
     * @param string $index : Índice de la ruta
     *
     * @throws \RuntimeException si la ruta no existe o si no está implementada la regla
     * @return mixed : Valor de la ruta solicitada
     */
    final public function getRoute(string $index) {
        # Verificar existencia de ruta
        if (!array_key_exists($index, $this->routerCollection)) {
            throw new \RuntimeException('La ruta ' . $index . ' no está definida en el controlador.');
        }

        # Obtener la ruta nativa sin reglas
        $ruta = $this->routerCollection[$index];
        $rules = new Rules;

        # Retornar ruta con la regla definida aplicada
        if (method_exists($rules, $this->routerCollectionRules[$index])) {
            return $rules->{$this->routerCollectionRules[$index]}($ruta);
        }

        # No existe la regla solicitada
        throw new \RuntimeException('La regla ' . $this->routerCollectionRules[$index] . ' existe en RULES pero no está implementada.');
    }

    /**
     * Obtiene el nombre del controlador.
     *
     * @return string controlador.
     */
    final public function getController() {
        return $this->routerCollection['/controller'];
    }

    /**
     * Obtiene el método
     *
     * @return string con el método.
     *           null si no está definido.
     */
    final public function getMethod() {
        return $this->routerCollection['/method'];
    }

    /**
     * Obtiene el id
     *
     * @param bool $with_rules : true para obtener el id con reglas definidas para números mayores a 0
     *                           false para obtener el id sin reglas definidas
     *
     * @return int|null con el id
     *           int con el id si usa reglas.
     *           null si no está definido.
     */
    final public function getId(bool $with_rules = false) {
        $id = $this->routerCollection['/id'];
        if ($with_rules && (!is_numeric($id) || $id <= 0)) {
            return null;
        }

        return $id;
    }

    /**
     * Encargado de cargar un controlador
     * Si este no existe, ejecutará errorController.
     * Si no se solicita ningún controlador, ejecutará homeController.
     *
     * @return void
     */
    final private function loadController() {
        # Definir controlador
        $controller = $this->isReadable($this->getController() . 'Controller');
        $controller = 'app\\controllers\\' . str_replace("/", "\\", $controller);
        new $controller($this);
    }

    /**
     * Examina si el controlador suministrado existe, verificando sesión.
     * Sí existe crea la ruta
     * Sino existe envía errorController
     * Sí esta deslogueado envía a HomeController
     *
     * @param string $controller : Controlador enviado
     * @return string : Retorna el controlador a mostrar
     */
    private function isReadable(string $controller): string {
        try {
            global $cookie, $config;

            $u = new Token();
            $id_user = $u->validateToken($cookie->get('SIDCC'));
            $controlleranexo = $controller;
            # Verifica si existe sesión

            if ($id_user['success']) {

                # Obtiene el Rol de las Cookies
                $id_aplication = $u->validateToken($cookie->get('APISID'));

                # Arma la ruta de acuerdo al Rol
                $controller = strtolower($id_aplication['data']['rol']) . '/' . $controller;

                # Sí no se le suministra un controlador el va al inicial
                if ($this->getController() === $config['build']['controller_ini']) {
                    if (!is_readable('app/controllers/' . $controller . '.php')) {
                        Helper\Functions::redir($id_aplication['data']['rol']);
                    }
                }

                # Sí no tiene sesión, verificamos que la ruta que este accediendo exista, para mandarlo al inicial
            } elseif ($this->searchController('app/controllers/', $controller) && $this->getController() !== 'home') {
                Helper\Functions::redir($config['build']['controller_ini']);
            }

            # Sí no existe el controlador, el envía a errorController
            if (!is_readable('app/controllers/' . $controller . '.php')) {
                if (is_readable('app/controllers/' . $this->getController() . 'Controller' . '.php')) {
                    $controller = $this->getController() . 'Controller';
                } else {
                    if ($id_user['success']) {
                        $controller = $this->searchControllerDirection('app/controllers/public/', $controlleranexo);
                    }
                    if (!$controller) {
                        $controller = 'errorController';
                    }
                }
            }

            return $controller;
        } catch (Exception $ex) {
            return 'errorController';
        }
    }

    /**
     * Error a mostrar en producción
     *
     * @return void
     */
    final private function productionError() {
        global $http;

        header($http->server->get('SERVER_PROTOCOL') . ' 500 Internal Server Error', true, 500);
        header('Content-Type: text/html; charset=utf-8');
        header('Content-language: es');

        $output = file_get_contents('assets/error/catch.html', FILE_USE_INCLUDE_PATH);
        echo $output;
    }

    /**
     * Ejecuta el controlador solicitado por la URL.
     *
     * @return void
     */
    final public function executeController() {
        global $config;

        if ($config['build']['production']) {
            try {
                $this->loadController();
            } catch (\Throwable $e) {
                $this->productionError();
            } catch (\Exception $e) {
                $this->productionError();
            }
        } else {
            $this->loadController();
        }
    }

    /**
     * Verifica que, en la ruta y el archivo suministrado exista un folder
     *
     * @param $ruta
     * @param $controller
     * @return bool
     */
    private function searchController($ruta, $controller) {
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {
                while (($file = readdir($dh)) !== false) {
                    if (is_dir($ruta . $file) && $file != "." && $file != "..") {
                        if (is_readable($ruta . $file . '/' . $controller . '.php')) {
                            return true;
                        }
                    }
                }
                closedir($dh);
            }
        }
        return false;
    }

    private function searchControllerDirection($ruta, $controller) {
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {
                while (($file = readdir($dh)) !== false) {
                    if (is_readable($ruta . $file . '/' . $controller . '.php')) {
                        return $controller;
                    }
                }
                closedir($dh);
            }
        }
        return false;
    }

}
