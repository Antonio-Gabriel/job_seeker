<?php

namespace SpeackWithUs\Config;

require_once "./src/Utils/SplitName.php";
require_once "./src/Utils/FormatDate.php";
require_once "./src/Utils/GetBasePath.php";
require_once "./src/Utils/FormatNumber.php";
require_once "./src/Utils/BreakingText.php";
require_once "./src/Utils/SplitArgsByComma.php";
require_once "./src/Utils/CalculateTotalHours.php";

use Twig\Environment;
use Twig\TwigFunction;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class Template
{
    private FilesystemLoader $loader;
    private Environment $twig;

    private string $path;
    private array $directories = [];

    public function __construct()
    {
        $this->path = getBasePath("Views/");

        array_push(
            $this->directories,
            [
                "views" => $this->path,
                "cache" => $this->path . "cache/",
                "shared" => $this->path . "shared/",
                "admin" => $this->path . "admin/"
            ]
        );

        $this->initTemplateEngineBase();
    }

    private function initTemplateEngineBase()
    {
        $this->loader = new FilesystemLoader($this->directories[0]["views"]);
        $this->loader->addPath($this->directories[0]["shared"], "shared");
        $this->loader->addPath($this->directories[0]["admin"], "admin");

        $this->twig = new Environment($this->loader, [
            "debug" => true,
            "auto_reload" => true,
            "charset" => "utf-8"
        ]);

        $this->twig->addExtension(new DebugExtension);
        $this->twig->addFunction(new TwigFunction("route", function ($url) {
            return $_ENV["URL_BASE"] . $url;
        }));

        $this->twig->addFunction(new TwigFunction("formateDate", function (string $date) {
            return formatDate($date);
        }));

        $this->twig->addFunction(new TwigFunction("calculateTotalHours", function (string $startDate, string $endDate) {
            return calculateTotalHours($startDate, $endDate);
        }));

        $this->twig->addFunction(new TwigFunction("formatNumber", function (string $amount) {
            return formatNumber($amount);
        }));

        $this->twig->addFunction(new TwigFunction("splitName", function (string $name) {
            return splitName($name);
        }));

        $this->twig->addFunction(new TwigFunction("breakingText", function (string $text, int $limit) {
            return breakingText($text, $limit);
        }));

        $this->twig->addFunction(new TwigFunction("splitArgsByComma", function (string $args) {
            return splitArgsByComma($args);
        }));
    }

    public function render($renderPage, $data = [])
    {
        echo $this->twig->render($renderPage, $data);
    }

    public function display($page)
    {
        $this->twig->display($page);
    }
}
