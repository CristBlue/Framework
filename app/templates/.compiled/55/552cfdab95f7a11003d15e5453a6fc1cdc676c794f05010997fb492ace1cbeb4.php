<?php

/* home.twig */
class __TwigTemplate_6aa98c72072bc970935bc1fb613a597eacac52b5ca612fa68f484d6c645d6ada extends Twig_Template
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
        echo "esto es una prueba";
    }

    public function getTemplateName()
    {
        return "home.twig";
    }

    public function getDebugInfo()
    {
        return array (  23 => 2,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{# empty Twig template #}
esto es una prueba", "home.twig", "/var/www/html/interno/app/views/home.twig");
    }
}
