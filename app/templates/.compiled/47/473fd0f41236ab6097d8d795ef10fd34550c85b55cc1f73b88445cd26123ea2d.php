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
        <div class='row cuerpo'>
            <div class=' card col s4'>
                <div class=\"input-field col s6\">
                    <input placeholder=\"Placeholder\" id=\"first_name\" type=\"text\" class=\"validate\">
                    <label for=\"first_name\">First Name</label>
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
        <div class='row cuerpo'>
            <div class=' card col s4'>
                <div class=\"input-field col s6\">
                    <input placeholder=\"Placeholder\" id=\"first_name\" type=\"text\" class=\"validate\">
                    <label for=\"first_name\">First Name</label>
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
