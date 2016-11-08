<?php

namespace App\Components;

use App\Strategies\TranslatorStrategy;
use Greg\Application;
use Greg\ApplicationStrategy;
use Greg\Translation\Translator;

class TranslatorComponent
{
    protected $app = null;

    public function __construct(ApplicationStrategy $app)
    {
        $this->app = $app;

        $this->app->on([
            Application::EVENT_RUN,
            Application::EVENT_FINISHED,
        ], $this);
    }

    public function initTranslator()
    {
        $this->app->ioc()->inject(Translator::class, function () {
            $class = new Translator();

            $translates = require $this->app->basePath() . '/resources/translates/general.php';

            $class->setTranslates($translates);

            return $class;
        });
    }

    public function appRun(TranslatorStrategy $service)
    {
        $service->setDefaults();

        return $this;
    }

    public function appFinished(TranslatorStrategy $service)
    {
        $service->saveNewTranslates();

        return $this;
    }
}
