<?php

/* login.twig */
class __TwigTemplate_54870346773416ad9476655b3fc15b176c949bfbe64edcb4934cebb901e8b43a extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        echo "<html>
    <head>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"assets/vendors/materialize/css/materialize.min.css\" />
        <link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/autenticacion/autenticacion.css\" />

    </head>
    <body>
        <div class='row'>
            <div class='cuerpo card col l4 m6 s12'>
                <div class=\"input-field  s6\">
                    <input placeholder=\"Usuario\" id=\"usuario\" type=\"text\" class=\"validate\">
                    <label for=\"usuario\">Usuario</label>
                </div>
                <div class=\"input-field s6\">
                    <input placeholder=\"Contraseña\" id=\"password\" type=\"password\" class=\"validate\">
                    <label for=\"password\">Contraseña</label>
                </div>
                <div>
                    <button class='btn btn-large '>Ingresar</button>
                </div>
            </div>
        </div>
        <footer>
            <script src=\"assets/vendors/materialize/js/materialize.min.js\"></script>
        </footer>
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "login.twig";
    }

    public function getDebugInfo()
    {
        return array (  23 => 2,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{# empty Twig template #}
<html>
    <head>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"assets/vendors/materialize/css/materialize.min.css\" />
        <link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/autenticacion/autenticacion.css\" />

    </head>
    <body>
        <div class='row'>
            <div class='cuerpo card col l4 m6 s12'>
                <div class=\"input-field  s6\">
                    <input placeholder=\"Usuario\" id=\"usuario\" type=\"text\" class=\"validate\">
                    <label for=\"usuario\">Usuario</label>
                </div>
                <div class=\"input-field s6\">
                    <input placeholder=\"Contraseña\" id=\"password\" type=\"password\" class=\"validate\">
                    <label for=\"password\">Contraseña</label>
                </div>
                <div>
                    <button class='btn btn-large '>Ingresar</button>
                </div>
            </div>
        </div>
        <footer>
            <script src=\"assets/vendors/materialize/js/materialize.min.js\"></script>
        </footer>
    </body>
</html>", "login.twig", "/var/www/html/interno/app/views/login.twig");
    }
}
