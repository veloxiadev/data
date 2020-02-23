<?php

namespace Veloxia\Data\Tests;

use Orchestra\Testbench\TestCase;
use Veloxia\Data\DataServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [DataServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
