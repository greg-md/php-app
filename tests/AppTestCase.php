<?php

namespace App;

use App\Console\ConsoleKernel;
use App\Http\HttpKernel;
use Greg\Support\Http\Request;
use Greg\Support\Http\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

require_once __DIR__ . '/../bootstrap/app.php';

class AppTestCase extends TestCase
{
    private $app;

    private $httpResponse;

    private $consoleOutput;

    private $lastOutput;

    protected function setUp(): void
    {
        $this->app = newApp();

        Response::mockHeaders();
    }

    protected function visit(string $uri, array $params = [])
    {
        $_SERVER['REQUEST_URI'] = $uri;

        $_GET = $_REQUEST = $params;

        $response = $this->httpKernel()->run($uri, Request::TYPE_GET);

        $this->setHttpResponse($response);

        return $this;
    }

    protected function submit(string $uri, array $params = [])
    {
        $_SERVER['REQUEST_URI'] = $uri;

        $_POST = $_REQUEST = $params;

        $response = $this->httpKernel()->run($uri, Request::TYPE_POST);

        $this->setHttpResponse($response);

        return $this;
    }

    protected function runCommand(string $name, array $params = [])
    {
        $input = new ArrayInput(['command' => $name] + $params);

        $output = new BufferedOutput();

        $this->consoleKernel()->run($input, $output);

        $this->setConsoleOutput($output);

        return $this;
    }

    protected function see(string $text)
    {
        $this->assertStringContainsString($text, $this->lastOutput());

        return $this;
    }

    protected function seeExactly(string $text)
    {
        $this->assertEquals($text, $this->lastOutput());

        return $this;
    }

    protected function seeJson(array $params)
    {
        return $this->seeExactly(json_encode($params));
    }

    protected function redirectTo(string $uri)
    {
        $this->assertEquals($uri, $this->httpResponse()->getLocation());

        return $this;
    }

    protected function app(): Application
    {
        if (!$this->app) {
            throw new \Exception('Application is not initialised.');
        }

        return $this->app;
    }

    protected function httpResponse(): Response
    {
        if (!$this->httpResponse) {
            throw new \Exception('To get the response, you should make a request first.');
        }

        return $this->httpResponse;
    }

    protected function consoleOutput(): BufferedOutput
    {
        if (!$this->consoleOutput) {
            throw new \Exception('To get the output, you should run a command first.');
        }

        return $this->consoleOutput;
    }

    protected function lastOutput(): string
    {
        return $this->lastOutput;
    }

    protected function setHttpResponse(Response $response)
    {
        $this->httpResponse = $response;

        $this->lastOutput = $response->getContent();

        return $this;
    }

    protected function setConsoleOutput(BufferedOutput $output)
    {
        $this->consoleOutput = $output;

        $this->lastOutput = $output->fetch();

        return $this;
    }

    protected function httpKernel(): HttpKernel
    {
        return $this->app()->get(HttpKernel::class);
    }

    protected function consoleKernel(): ConsoleKernel
    {
        return $this->app()->get(ConsoleKernel::class);
    }
}
