<?php

/* modules/contrib/better_messages/templates/better-messages-wrapper.html.twig */
class __TwigTemplate_c0337dcd3b4f14f6aba50b9a06868170787cfeaa1f88abd1edbe449d5ad4ff0f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'children' => array($this, 'block_children'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $tags = array("block" => 15);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('block'),
                array(),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 13
        echo "<div";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["attributes"] ?? null), "setAttribute", array(0 => "id", 1 => "better-messages-default"), "method"), "html", null, true));
        echo ">
  <div id=\"better-messages-inner\">
    ";
        // line 15
        $this->displayBlock('children', $context, $blocks);
        // line 21
        echo "  </div>
</div>
";
    }

    // line 15
    public function block_children($context, array $blocks = array())
    {
        // line 16
        echo "      <div class=\"better-messages-content\">
        ";
        // line 17
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["children"] ?? null), "html", null, true));
        echo "
      </div>
      <div class=\"better-messages-footer\"><span class=\"better-messages-timer\"></span><a class=\"better-messages-close\" href=\"#\"></a></div>
    ";
    }

    public function getTemplateName()
    {
        return "modules/contrib/better_messages/templates/better-messages-wrapper.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  64 => 17,  61 => 16,  58 => 15,  52 => 21,  50 => 15,  44 => 13,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "modules/contrib/better_messages/templates/better-messages-wrapper.html.twig", "/var/www/drupal8.dev/web/modules/contrib/better_messages/templates/better-messages-wrapper.html.twig");
    }
}
