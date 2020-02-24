<?php

namespace Veloxia\Data\Tests;

use Orchestra\Testbench\TestCase;
use Veloxia\Data\Client;
use Veloxia\Data\DataServiceProvider;
use Veloxia\Data\Facades\VD;

class VeloxiaDataTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [
            DataServiceProvider::class
        ];
    }

    /** @test */
    public function check_if_provider_is_booted()
    {
        $vd = VD::getInstance();
        $this->assertInstanceOf(Client::class, $vd);
    }

    /** @test */
    public function test_if_data_looks_reasonable()
    {
        $loan = VD::loan('testing-more');
        $this->assertSame($loan['slug'], 'testing-more');
        $this->assertSame($loan['interest_from'], 2.9);
        $this->assertSame($loan['interest_to'], 29.9);
    }
}
