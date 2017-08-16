<?php

namespace App;

class ApplicationTest extends TestCase
{
    public function testCanAccessHomePage()
    {
        $this->visit('/')
            ->see('Greg PHP Application');
    }

    public function testCanRunHelloCommand()
    {
        $this->runCommand('hello')
            ->see('Hello');
    }
}