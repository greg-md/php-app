<?php

namespace App\Components;

use App\Strategies\TranslatorStrategy;
use Greg\Application;
use Greg\Event\ListenerInterface;
use Greg\Event\SubscriberInterface;
use Greg\Translation\Translator;

class TranslatorComponent implements SubscriberInterface
{
    protected $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function initTranslator()
    {
        $this->app->inject(Translator::class, function () {
            $class = new Translator();

            $translates = require $this->app->basePath() . '/resources/translates/general.php';

            $class->setTranslates($translates);

            return $class;
        });
    }

    public function subscribe(ListenerInterface $listener)
    {
        $listener->register([
            Application::EVENT_RUN,
            Application::EVENT_FINISHED,
        ], $this);

        return $this;
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
