<?php

namespace Veloxia\Data\Graph;

use Veloxia\Data\Client;
use Veloxia\Data\Types\Undefined;
use Veloxia\Data\Types\GenericType;
use Veloxia\Data\Contracts\GraphContract;

abstract class Graph implements GraphContract
{

    /**
     * The attributes of this graph model.
     *
     * @var array
     */
    protected array $attributes = [];

    /**
     * Find a model within this graph.
     *
     * @param string $slug  The slug URL associated with the wanted model.
     *
     * @return \Veloxia\Data\Contracts\GraphContract
     */
    public static function find(string $slug): GraphContract
    {
        $data = Client::find(static::$graphName, $slug);
        $obj = new static($data);
        return $obj;
    }

    /**
     * Create a new model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $val) {
            $this->attributes[$key] = $val !== null ? new GenericType($val) : new Undefined();
        }
    }

    /**
     * Get the value of an attribute.
     *
     * @param string $attribute
     *
     * @return void
     */
    public function get(string $attribute)
    {
        return $this->attributes[$attribute];
    }

    /**
     * Set the value of an attribute. This won't affect the API, only the data that is saved locally.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return self
     */
    public function set(string $attribute, $value)
    {
        $this->attributes[$attribute] = $value;
        return $this;
    }

    /**
     * Get all attributes as an associative array.
     *
     * @return  array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Get all attributes as JSON.
     *
     * @return  string 
     */
    public function toJson(): string
    {
        return json_encode(
            $this->toArray(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
