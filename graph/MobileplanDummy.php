<?php

namespace Veloxia\Data\Graph;

use Veloxia\Data\Graph\Graph;
use Veloxia\Data\Contracts\GraphContract;

class MobileplanDummy extends Graph implements GraphContract
{
    /**
     * Graph accessor when making requests to the API. 
     * 
     * @var string
     */
    protected static $graphName = 'mobileplans';

    /**
     * Get the value of contract_time_months (integer).
     * 
     * @return \Veloxia\Data\Casts\Basic\IntegerType
     */
    public function contractTimeMonths()
    {
        return $this->get('contract_time_months');
    }

    /**
     * Get the value of created_at (datetime).
     * 
     * @return \Veloxia\Data\Casts\Basic\DateTimeType
     */
    public function createdAt()
    {
        return $this->get('created_at');
    }

    /**
     * Get the value of data_amount_gb (float).
     * 
     * @return \Veloxia\Data\Casts\Basic\FloatType
     */
    public function dataAmountGb()
    {
        return $this->get('data_amount_gb');
    }

    /**
     * Get the value of deleted_at (datetime).
     * 
     * @return \Veloxia\Data\Casts\Basic\DateTimeType
     */
    public function deletedAt()
    {
        return $this->get('deleted_at');
    }

    /**
     * Get the value of discount_price (float).
     * 
     * @return \Veloxia\Data\Casts\Basic\FloatType
     */
    public function discountPrice()
    {
        return $this->get('discount_price');
    }

    /**
     * Get the value of discount_price_months (integer).
     * 
     * @return \Veloxia\Data\Casts\Basic\IntegerType
     */
    public function discountPriceMonths()
    {
        return $this->get('discount_price_months');
    }

    /**
     * Get the value of free_calls (integer).
     * 
     * @return \Veloxia\Data\Casts\Basic\IntegerType
     */
    public function freeCalls()
    {
        return $this->get('free_calls');
    }

    /**
     * Get the value of free_minutes (integer).
     * 
     * @return \Veloxia\Data\Casts\Basic\IntegerType
     */
    public function freeMinutes()
    {
        return $this->get('free_minutes');
    }

    /**
     * Get the value of free_sms (integer).
     * 
     * @return \Veloxia\Data\Casts\Basic\IntegerType
     */
    public function freeSms()
    {
        return $this->get('free_sms');
    }

    /**
     * Get the value of id (integer).
     * 
     * @return \Veloxia\Data\Casts\Basic\IntegerType
     */
    public function id()
    {
        return $this->get('id');
    }

    /**
     * Get the value of locale (string).
     * 
     * @return \Veloxia\Data\Casts\Basic\StringType
     */
    public function locale()
    {
        return $this->get('locale');
    }

    /**
     * Get the value of name (string).
     * 
     * @return \Veloxia\Data\Casts\Basic\StringType
     */
    public function name()
    {
        return $this->get('name');
    }

    /**
     * Get the value of number_of_jobs (integer).
     * 
     * @return \Veloxia\Data\Casts\Basic\IntegerType
     */
    public function numberOfJobs()
    {
        return $this->get('number_of_jobs');
    }

    /**
     * Get the value of price (float).
     * 
     * @return \Veloxia\Data\Casts\Basic\FloatType
     */
    public function price()
    {
        return $this->get('price');
    }

    /**
     * Get the value of rating (float).
     * 
     * @return \Veloxia\Data\Casts\Basic\FloatType
     */
    public function rating()
    {
        return $this->get('rating');
    }

    /**
     * Get the value of slug (string).
     * 
     * @return \Veloxia\Data\Casts\Basic\StringType
     */
    public function slug()
    {
        return $this->get('slug');
    }

    /**
     * Get the value of type (string).
     * 
     * @return \Veloxia\Data\Casts\Basic\StringType
     */
    public function type()
    {
        return $this->get('type');
    }

    /**
     * Get the value of updated_at (datetime).
     * 
     * @return \Veloxia\Data\Casts\Basic\DateTimeType
     */
    public function updatedAt()
    {
        return $this->get('updated_at');
    }

    /**
     * Get the value of url (text).
     * 
     * @return \Veloxia\Data\Casts\Basic\TextType
     */
    public function url()
    {
        return $this->get('url');
    }

    /**
     * Attribute map used internally by the package in order to do map the accessor methods to the VD graph. Do not make any changes!
     *
     * @var array
     */
    protected static $graphAttributeMap = [
        'contract_time_months' => ['contractTimeMonths', \Veloxia\Data\Casts\Basic\IntegerType::class],
        'created_at' => ['createdAt', \Veloxia\Data\Casts\Basic\DateTimeType::class],
        'data_amount_gb' => ['dataAmountGb', \Veloxia\Data\Casts\Basic\FloatType::class],
        'deleted_at' => ['deletedAt', \Veloxia\Data\Casts\Basic\DateTimeType::class],
        'discount_price' => ['discountPrice', \Veloxia\Data\Casts\Basic\FloatType::class],
        'discount_price_months' => ['discountPriceMonths', \Veloxia\Data\Casts\Basic\IntegerType::class],
        'free_calls' => ['freeCalls', \Veloxia\Data\Casts\Basic\IntegerType::class],
        'free_minutes' => ['freeMinutes', \Veloxia\Data\Casts\Basic\IntegerType::class],
        'free_sms' => ['freeSms', \Veloxia\Data\Casts\Basic\IntegerType::class],
        'id' => ['id', \Veloxia\Data\Casts\Basic\IntegerType::class],
        'locale' => ['locale', \Veloxia\Data\Casts\Basic\StringType::class],
        'name' => ['name', \Veloxia\Data\Casts\Basic\StringType::class],
        'number_of_jobs' => ['numberOfJobs', \Veloxia\Data\Casts\Basic\IntegerType::class],
        'price' => ['price', \Veloxia\Data\Casts\Basic\FloatType::class],
        'rating' => ['rating', \Veloxia\Data\Casts\Basic\FloatType::class],
        'slug' => ['slug', \Veloxia\Data\Casts\Basic\StringType::class],
        'type' => ['type', \Veloxia\Data\Casts\Basic\StringType::class],
        'updated_at' => ['updatedAt', \Veloxia\Data\Casts\Basic\DateTimeType::class],
        'url' => ['url', \Veloxia\Data\Casts\Basic\TextType::class],
    ];
}
