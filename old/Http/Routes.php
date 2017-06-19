<?php

namespace App\Http;

use Greg\Routing\Router;

class Routes
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;

        $this->boot();
    }

    private function boot()
    {
        $this->router->get('/', 'HomeController@index');

        //$this->loadLangRoutes();
    }

//    protected function langRoutes(Route $router)
//    {
//        $router->get('/', 'HomeController@index');
//    }
//
//    protected function loadLangRoutes()
//    {
//        $this->router->group($this->getLangFormat(), function (Route $router) {
//            $this->langRoutes($router);
//        })->onMatch(function (Route $route) {
//            $this->translator()->setCurrentLanguage($route['language']);
//
//            $language = $this->translator()->getLanguage($route['language']);
//
//            if ($language['Locale']) {
//                setlocale(LC_ALL, $language['Locale']);
//            }
//
//            $this->translator()->addTranslates($this->translates()->getTranslates($route['language']));
//        });
//    }
//
//    protected function getLangFormat()
//    {
//        $language = $this->translator()->getDefaultLanguage();
//
//        $defaults = implode('|', $this->translator()->getLanguagesKeys());
//
//        return '[/{language:' . $language . '|' . $defaults . '}]?';
//    }
//
//    /**
//     * @return TranslatorContract
//     * @throws \Exception
//     */
//    protected function translator()
//    {
//        return $this->app->ioc()->expect(TranslatorContract::class);
//    }
//
//    /**
//     * @return TranslatesStrategy
//     * @throws \Exception
//     */
//    protected function translates()
//    {
//        return $this->app->ioc()->expect(TranslatesStrategy::class);
//    }
}
