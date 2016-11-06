<?php

namespace App;

use App\Services\TranslatorService;
use Greg\Router\Route;
use Greg\Router\Router;
use Greg\Translation\Translator;

class Routes
{
    protected $translator = null;

    protected $router = null;

    public function __construct(Router $router, Translator $translator)
    {
        $this->router = $router;

        $this->translator = $translator;
    }

    public function load()
    {
        $this->router->group($this->getLangFormat(), function (Route $router) {
            $this->loadLangRoutes($router);
        })->onMatch(function (Route $route, TranslatorService $service) {
            $service->setLanguage($route['language']);
        });
    }

    protected function loadLangRoutes(Route $router)
    {
        $router->get('/', 'HomeController@index');
    }

    protected function getLangFormat()
    {
        $language = $this->translator->getDefaultLanguage();

        $defaults = implode('|', $this->translator->getLanguages());

        return '[/{language:' . $language . '|' . $defaults . '}]?';
    }
}
