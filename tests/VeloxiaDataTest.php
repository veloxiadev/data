<?php

namespace Veloxia\Data\Tests;

use Veloxia\Data\Client;
use Veloxia\Data\Facades\VD;
use Orchestra\Testbench\TestCase;
use Veloxia\Data\DataServiceProvider;
use Veloxia\Data\Contracts\DataContract;

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

    /** @test */
    public function test_access_using_contract()
    {
        $vd = app()->make(DataContract::class);
        $this->assertInstanceOf(Client::class, $vd);
        $loan = $vd->loan('testing-more');
        $this->assertSame($loan['slug'], 'testing-more');
        $this->assertSame($loan['interest_from'], 2.9);
        $this->assertSame($loan['interest_to'], 29.9);
    }
}
