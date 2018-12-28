<?php

/* extension/dashboard/online_info.twig */
class __TwigTemplate_82203e132381a354fbf07f47eb31332991f51616b22912aa66679c90976fab57 extends Twig_Template
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
        echo "<div class=\"tile tile-primary\">
  <div class=\"tile-heading\">";
        // line 2
        echo ($context["heading_title"] ?? null);
        echo "</div>
  <div class=\"tile-body\"><i class=\"fas fa-users\"></i>
    <h2 class=\"float-right\">";
        // line 4
        echo ($context["total"] ?? null);
        echo "</h2>
  </div>
  <div class=\"tile-footer\"><a href=\"";
        // line 6
        echo ($context["online"] ?? null);
        echo "\">";
        echo ($context["text_view"] ?? null);
        echo "</a></div>
</div>
";
    }

    public function getTemplateName()
    {
        return "extension/dashboard/online_info.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  36 => 6,  31 => 4,  26 => 2,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "extension/dashboard/online_info.twig", "C:\\xampp\\htdocs\\fagala.com\\admin\\view\\template\\extension\\dashboard\\online_info.twig");
    }
}
