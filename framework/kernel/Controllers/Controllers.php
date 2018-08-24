<?php

/* -----------------------------------------------------------------------------
 * █▀▀▄░▀█▀░█░█░▀█▀░█▀▀░▀█▀░█▀▀░    * @name  divisis_framework
 * █░ █░ █░ █▄█░ █░ ▀▀█░ █░ ▀▀█░    * @autor Brayan Narváez
 * ▀▀▀░ ▀▀▀░ ▀░ ▀▀▀░▀▀▀░▀▀▀ ▀▀▀░    * @email <prinick@ocrend.com>
 * -----------------------------------------------------------------------------
 * Clase para conectar todos los controladores del sistema y compartir la configuración.
 * Inicializa aspectos importantes de una página, como el sistema de plantillas twig.
 * -------------------------------------------------------------------------- */

namespace framework\kernel\Controllers;

use app\models as Model;
use framework\kernel\Helpers as Helper;
use framework\kernel\Router\IRouter;
use framework\kernel\Token\Token;

/**
 * Clase para conectar todos los controladores del sistema y compartir la configuración.
 * Inicializa aspectos importantes de una página, como el sistema de plantillas twig.
 *
 * @author Brayan Narváez <prinick@Divisis.com>
 */
abstract class Controllers {

    /**
     * Obtiene el objeto del template
     *
     * @var \Twig_Environment
     */
    protected $template;

    /**
     * Verifica si está definida la ruta /id como un integer >= 1
     *
     * @var bool
     */
    protected $isset_id = false;

    /**
     * Tiene el valor de la ruta /método
     *
     * @var string|null
     */
    protected $method;

    /**
     * Arreglo con la información del usuario conectado actualmente.
     *
     * @var array
     */
    protected $user = array();

    /**
     * Contiene información sobre el estado del usuario, si está o no conectado.
     *
     * @var bool
     */
    private $is_logged = false;

    /**
     * Parámetros de configuración para el controlador con la forma:
     * 'parmáetro' => (bool) valor
     *
     * @var array
     */
    private $controllerConfig;

    /**
     * Configuración inicial de cualquier controlador
     *
     * @param IRouter $router: Instancia de un Router
     * @param array $configController: Arreglo de configuración con la forma
     *     'users_logged' => bool, # Configura el controlador para solo ser visto por usuarios logeados
     *     'users_not_logged' => bool, # Configura el controlador para solo ser visto por !(usuarios logeados)
     *
     */
    protected function __construct(IRouter $router, $configController = []) {
        global $config, $http, $session, $session;

        $u = new Token();
        $id_user = false;

        # Verificar si está logueado el usuario
        $this->is_logged = $id_user['success'];


        # Twig Engine http://gitnacho.github.io/Twig/
        $this->template = new \Twig_Environment(new \Twig_Loader_Filesystem('./app/views/'), array(
            # ruta donde se guardan los archivos compilados
            'cache' => $config['twig']['compiled_dir'],
            # false para caché estricto, cero actualizaciones, recomendado para páginas 100% estáticas
            'auto_reload' => !$config['twig']['cache'],
            # en true, las plantillas generadas tienen un método __toString() para mostrar los nodos generados
            'debug' => !$config['build']['production'],
            # el charset utilizado por los templates
            'charset' => $config['twig']['charset'],
            # true para evitar ignorar las variables no definidas en el template
            'strict_variables' => $config['twig']['strict_variables'],
            # false para evitar el auto escape de html por defecto (no recomendado)
            'autoescape' => $config['twig']['autoescape']
        ));
        # Datos del usuario actual
        if ($this->is_logged) {
            $this->user = (new Model\Users)->getOwnerUser();
            $this->template->addGlobal('owner_user', $this->user);
        }

        # Establecer la configuración para el controlador
        $this->setControllerConfig($configController);

        # Request global
        $this->template->addGlobal('get', $http->query->all());
        $this->template->addGlobal('server', $http->server->all());
        $this->template->addGlobal('session', $session->all());
//        $this->template->addGlobal('cookie', $cookie->all());
        $this->template->addGlobal('config', $config);
        $this->template->addGlobal('is_logged', $this->is_logged);
        $this->template->addGlobal('menu', $router->getController());


        # Extensiones
//        $this->template->addExtension(new Helper\Functions);
        # Debug disponible en twig
        if (!$config['build']['production']) {
            $this->template->addExtension(new \Twig_Extension_Debug());
        }

        # Verificar para quién está permitido este controlador
//        $this->knowVisitorPermissions();
        # Auxiliares
        $this->method = $router->getMethod();
        $this->isset_id = $router->getID(true);
    }

    /**
     * Establece los parámetros de configuración de un controlador
     *
     * @param IRouter $router: Instancia de un Router
     * @param array|null $config: Arreglo de configuración
     *
     * @return void
     */
    private function setControllerConfig($config) {
        $this->controllerConfig = array_merge(array(
            'users_logged' => false,
            'users_not_logged' => false,
            'users_control' => false,
            'users_lider' => false,
                ), $config);
    }

    /**
     * Acción que regula quién entra o no al controlador según la configuración
     *
     * @return void
     */
    private function knowVisitorPermissions() {
        global $config;

        # Sólamente usuarios logeados
        if ($this->controllerConfig['users_logged'] && !$this->is_logged) {
            Helper\Functions::redir($config['build']['url'] . 'login');
        }

        # Sólamente usuarios no logeados
        if ($this->controllerConfig['users_not_logged'] && $this->is_logged) {
            Helper\Functions::redir();
        }
        #Si el usuario esta logeado, verifica el rol
        if ($this->is_logged) {
            $this->rolPermissions();
        }
    }

    /**
     * Redirecciona correspondiente al rol
     *
     * @return void
     */
    private function rolPermissions() {
        if ($this->user['ROL'] === 'Estudiante' && !$this->controllerConfig['users_estudiante']) {
            Helper\Functions::redir('home');
        }
        if ($this->user['ROL'] === 'Admin' && !$this->controllerConfig['users_admin']) {
            Helper\Functions::redir('home');
        }
        if ($this->user['ROL'] === 'Control' && !$this->controllerConfig['users_control']) {
            Helper\Functions::redir('home');
        }
        if ($this->user['ROL'] === 'Lider' && !$this->controllerConfig['users_lider']) {
            Helper\Functions::redir('home');
        }
    }

}
