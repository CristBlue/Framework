<?php

/* error/404.twig */
class __TwigTemplate_d656c245f90db5041284df7a099acfd4d4b5a327783bb5a8bb7391301d53b8f6 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'appBody' => array($this, 'block_appBody'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('appBody', $context, $blocks);
    }

    public function block_appBody($context, array $blocks = array())
    {
        // line 2
        echo "    <div class=\"box-Divisis\">
        <h1>ERROR 404</h1>
        <p>¡La página solicitada no ha sido encontrada!</p>
    </div>
";
    }

    public function getTemplateName()
    {
        return "error/404.twig";
    }

    public function getDebugInfo()
    {
        return array (  30 => 2,  24 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% block appBody %}
    <div class=\"box-Divisis\">
        <h1>ERROR 404</h1>
        <p>¡La página solicitada no ha sido encontrada!</p>
    </div>
{% endblock %}
", "error/404.twig", "/var/www/html/interno/app/views/error/404.twig");
    }
}
