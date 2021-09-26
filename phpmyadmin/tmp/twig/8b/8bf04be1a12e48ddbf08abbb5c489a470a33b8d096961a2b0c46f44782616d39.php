<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* server/plugins/index.twig */
class __TwigTemplate_b69df6614aa580e8e468e3a1d6757a1ea558b5cd10ecd51d43b71613baa8ee41 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<h2>
  ";
        // line 2
        echo PhpMyAdmin\Util::getImage("b_plugin");
        echo "
  ";
        // line 3
        echo _gettext("Plugins");
        // line 4
        echo "</h2>

<div id=\"plugins_plugins\">
  <div id=\"sectionlinks\">
    ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_array_keys_filter(($context["plugins"] ?? null)));
        foreach ($context['_seq'] as $context["_key"] => $context["type"]) {
            // line 9
            echo "      <a class=\"btn btn-primary\" href=\"#plugins-";
            echo twig_escape_filter($this->env, (($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 = ($context["clean_types"] ?? null)) && is_array($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4) || $__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 instanceof ArrayAccess ? ($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4[$context["type"]] ?? null) : null), "html", null, true);
            echo "\">
          ";
            // line 10
            echo twig_escape_filter($this->env, $context["type"], "html", null, true);
            echo "
      </a>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['type'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "  </div>
  ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["plugins"] ?? null));
        foreach ($context['_seq'] as $context["type"] => $context["list"]) {
            // line 15
            echo "    <div class=\"responsivetable\">
      <table class=\"data_full_width\" id=\"plugins-";
            // line 16
            echo twig_escape_filter($this->env, (($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144 = ($context["clean_types"] ?? null)) && is_array($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144) || $__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144 instanceof ArrayAccess ? ($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144[$context["type"]] ?? null) : null), "html", null, true);
            echo "\">
        <caption class=\"tblHeaders\">
          ";
            // line 18
            echo twig_escape_filter($this->env, $context["type"], "html", null, true);
            echo "
        </caption>
        <thead>
          <tr>
            <th>";
            // line 22
            echo _gettext("Plugin");
            echo "</th>
            <th>";
            // line 23
            echo _gettext("Description");
            echo "</th>
            <th>";
            // line 24
            echo _gettext("Version");
            echo "</th>
            <th>";
            // line 25
            echo _gettext("Author");
            echo "</th>
            <th>";
            // line 26
            echo _gettext("License");
            echo "</th>
          </tr>
        </thead>
        <tbody>
          ";
            // line 30
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["list"]);
            foreach ($context['_seq'] as $context["_key"] => $context["plugin"]) {
                // line 31
                echo "            <tr class=\"noclick\">
              <th>
                ";
                // line 33
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["plugin"], "name", [], "any", false, false, false, 33), "html", null, true);
                echo "
                ";
                // line 34
                if ((twig_get_attribute($this->env, $this->source, $context["plugin"], "status", [], "any", false, false, false, 34) != "ACTIVE")) {
                    // line 35
                    echo "                  <small class=\"attention\">
                    ";
                    // line 36
                    if ((twig_get_attribute($this->env, $this->source, $context["plugin"], "status", [], "any", false, false, false, 36) == "INACTIVE")) {
                        // line 37
                        echo "                      ";
                        echo _gettext("inactive");
                        // line 38
                        echo "                    ";
                    } elseif ((twig_get_attribute($this->env, $this->source, $context["plugin"], "status", [], "any", false, false, false, 38) == "DISABLED")) {
                        // line 39
                        echo "                      ";
                        echo _gettext("disabled");
                        // line 40
                        echo "                    ";
                    } elseif ((twig_get_attribute($this->env, $this->source, $context["plugin"], "status", [], "any", false, false, false, 40) == "DELETING")) {
                        // line 41
                        echo "                      ";
                        echo _gettext("deleting");
                        // line 42
                        echo "                    ";
                    } elseif ((twig_get_attribute($this->env, $this->source, $context["plugin"], "status", [], "any", false, false, false, 42) == "DELETED")) {
                        // line 43
                        echo "                      ";
                        echo _gettext("deleted");
                        // line 44
                        echo "                    ";
                    }
                    // line 45
                    echo "                  </small>
                ";
                }
                // line 47
                echo "              </th>
              <td>";
                // line 48
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["plugin"], "description", [], "any", false, false, false, 48), "html", null, true);
                echo "</td>
              <td>";
                // line 49
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["plugin"], "version", [], "any", false, false, false, 49), "html", null, true);
                echo "</td>
              <td>";
                // line 50
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["plugin"], "author", [], "any", false, false, false, 50), "html", null, true);
                echo "</td>
              <td>";
                // line 51
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["plugin"], "license", [], "any", false, false, false, 51), "html", null, true);
                echo "</td>
            </tr>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['plugin'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 54
            echo "        </tbody>
      </table>
    </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['type'], $context['list'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 58
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "server/plugins/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  195 => 58,  186 => 54,  177 => 51,  173 => 50,  169 => 49,  165 => 48,  162 => 47,  158 => 45,  155 => 44,  152 => 43,  149 => 42,  146 => 41,  143 => 40,  140 => 39,  137 => 38,  134 => 37,  132 => 36,  129 => 35,  127 => 34,  123 => 33,  119 => 31,  115 => 30,  108 => 26,  104 => 25,  100 => 24,  96 => 23,  92 => 22,  85 => 18,  80 => 16,  77 => 15,  73 => 14,  70 => 13,  61 => 10,  56 => 9,  52 => 8,  46 => 4,  44 => 3,  40 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "server/plugins/index.twig", "/var/www/yii2zif/test.loc/phpmyadmin/templates/server/plugins/index.twig");
    }
}
