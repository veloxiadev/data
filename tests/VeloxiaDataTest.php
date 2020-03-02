<?php

namespace Veloxia\Data\Tests;

use Veloxia\Data\Client;
use Veloxia\Data\Facades\VD;
use Orchestra\Testbench\TestCase;
use Veloxia\Data\DataServiceProvider;
use Veloxia\Data\Graph\MobileplanDummy as Mobileplan;
use Veloxia\Data\Contracts\GraphContract;
use Veloxia\Data\Exceptions\ItemNotFoundException;

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
        $vd = app('data');
        $this->assertInstanceOf(Client::class, $vd);
    }

    /** @test */
    public function test_if_it_is_possible_to_find_a_dummy_model()
    {
        $data = Mobileplan::find('halebop-2gb');
        $this->assertSame($data->slug, 'halebop-2gb');
        $this->assertSame($data->price, 99.0);
        $this->assertSame($data->rating, 3.0);
        $this->assertInstanceOf(GraphContract::class, $data);
    }

    public function test_if_exception_is_thrown_when_the_model_does_not_exist()
    {
        try {
            $plan = Mobileplan::find('aiowdnaawidjaiow');
        } catch (\Exception $e) {
            $this->assertInstanceOf(ItemNotFoundException::class, $e);
        }
    }

    public function test_if_attributes_are_casted_correctly()
    {
        $plan = Mobileplan::find('halebop-8gb');

        $this->assertInstanceOf(
            \Veloxia\Data\Casts\Basic\FloatType::class,
            $plan->price()
        );

        $this->assertInstanceOf(
            \Veloxia\Data\Casts\Basic\StringType::class,
            $plan->name()
        );

        $this->assertInstanceOf(
            \Veloxia\Data\Casts\Basic\StringType::class,
            $plan->name()
        );

        $this->assertInstanceOf(
            \Veloxia\Data\Casts\Basic\IntegerType::class,
            $plan->freeMinutes()
        );
    }

    public function test_if_attributes_are_tostringable()
    {
        $plan = Mobileplan::find('halebop-8gb');

        $this->assertSame(
            '269',
            $plan->price()->__toString()
        );
        $this->assertSame(
            '269',
            $plan->get('price')->__toString()
        );
    }

    public function test_if_attributes_are_accessible_by_name()
    {
        $plan = Mobileplan::find('halebop-8gb');

        $this->assertSame(
            269.0,
            $plan->price
        );
    }
}
