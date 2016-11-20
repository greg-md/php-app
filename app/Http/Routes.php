<?php

namespace App\Http;

use App\Strategies\TranslatesStrategy;
use Greg\ApplicationContract;
use Greg\Router\Route;
use Greg\Router\Router;
use Greg\Translation\TranslatorContract;

class Routes
{
    protected $app = null;

    protected $router = null;

    public function __construct(ApplicationContract $app, Router $router)
    {
        $this->app = $app;

        $this->router = $router;
    }

    /**
     * @return TranslatorContract
     * @throws \Exception
     */
    protected function translator()
    {
        return $this->app->ioc()->expect(TranslatorContract::class);
    }

    /**
     * @return TranslatesStrategy
     * @throws \Exception
     */
    protected function translates()
    {
        return $this->app->ioc()->expect(TranslatesStrategy::class);
    }

    public function load()
    {
        $this->routes();

        //$this->loadLangRoutes();
    }

    public function loadLangRoutes()
    {
        $this->router->group($this->getLangFormat(), function (Route $router) {
            $this->langRoutes($router);
        })->onMatch(function (Route $route) {
            $this->translator()->setCurrentLanguage($route['language']);

            $language = $this->translator()->getLanguage($route['language']);

            if ($language['Locale']) {
                setlocale(LC_ALL, $language['Locale']);
            }

            $this->translator()->addTranslates($this->translates()->getTranslates($route['language']));
        });
    }

    protected function routes()
    {
        $this->router->get('/', 'HomeController@index');
    }

    protected function langRoutes(Route $router)
    {
        $router->get('/', 'HomeController@index');
    }

    protected function getLangFormat()
    {
        $language = $this->translator()->getDefaultLanguage();

        $defaults = implode('|', $this->translator()->getLanguagesKeys());

        return '[/{language:' . $language . '|' . $defaults . '}]?';
    }
}
