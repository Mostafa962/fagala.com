<?php

/* error/permission.twig */
class __TwigTemplate_f6006af16edbe9a452fee5773c4e7548f1aed022cbbcf48cfbbd1e85b11efbf5 extends Twig_Template
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
        // line 1
        echo ($context["header"] ?? null);
        echo ($context["column_left"] ?? null);
        echo "
<div id=\"content\">
  <div class=\"page-header\">
    <div class=\"container-fluid\">
      <h1>";
        // line 5
        echo ($context["heading_title"] ?? null);
        echo "</h1>
      <ol class=\"breadcrumb\">
        ";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 8
            echo "          <li class=\"breadcrumb-item\"><a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "href", array());
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "text", array());
            echo "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 10
        echo "      </ol>
    </div>
  </div>
  <div class=\"container-fluid\">
    <div class=\"card\">
      <div class=\"card-header\"><i class=\"fas fa-exclamation-triangle\"></i> ";
        // line 15
        echo ($context["heading_title"] ?? null);
        echo "</div>
      <div class=\"card-body\">
        <p class=\"text-center\">";
        // line 17
        echo ($context["text_permission"] ?? null);
        echo "</p>
      </div>
    </div>
  </div>
";
        // line 21
        echo ($context["footer"] ?? null);
    }

    public function getTemplateName()
    {
        return "error/permission.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 21,  63 => 17,  58 => 15,  51 => 10,  40 => 8,  36 => 7,  31 => 5,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "error/permission.twig", "C:\\xampp\\htdocs\\fagala.com\\admin\\view\\template\\error\\permission.twig");
    }
}
