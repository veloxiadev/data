<?php

namespace Veloxia\Data\Graph;

use Veloxia\Data\Client;
use Veloxia\Data\Contracts\GraphContract;
use Veloxia\Data\Contracts\TypeContract;

abstract class Graph implements GraphContract
{

    /**
     * The attributes of this graph model.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Find a model within this graph.
     *
     * @param string $slug  The slug URL associated with the wanted model.
     *
     * @return \Veloxia\Data\Contracts\GraphContract
     */
    public static function find(string $slug): GraphContract
    {

        # Bind this graph model in the container. 
        app()->singleton(static::$graphName . '.' . $slug, function () use ($slug) {
            return new static(app('data')->find(static::$graphName, $slug));
        });

        return app(static::$graphName . '.' . $slug);
    }

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $val) {
            $this->attributes[$key] = new static::$graphAttributeMap[$key][1]($val);
        }
    }

    /**
     * Get the value of an attribute.
     *
     * @param string $attribute
     *
     * @return mixed
     */
    public function get(string $attribute)
    {
        return $this->attributes[$attribute];
    }

    /**
     * Set the value of an attribute.
     *
     * @param string $attribute
     * @param \Veloxia\Data\Casts\TypeContract
     *
     * @return mixed
     */
    public function set(string $attribute, TypeContract $type)
    {
        return $this->attributes[$attribute] = $type;
    }

    /**
     * Magic method to steer direct referencing to the correct "pseudo variable".
     *
     * @param   string  $attribute
     *
     * @return  mixed
     */
    public function __get(string $attribute)
    {
        if (!isset($this->$attribute)) {
            return $this->attributes[$attribute]->get();
        }
    }

    /**
     * Turn this graph model into an array of serialized type objects.
     *
     * @return  array
     */
    public function export(): array
    {
        array_walk($this->attributes, function (&$item) {
            $item = json_encode([get_class($item), $item->export()]);
        });
        return $this->attributes;
    }

    /**
     * Import an array of attributes and turn it into a graph model.
     *
     * @param array   $values
     *
     * @return self
     */
    public static function import(array $values): self
    {
        $graph = new static();
        foreach ($values as $attribute => $value) {
            $value = json_decode($value);
            $graph->set($attribute, $value[0]::import($value[1]));
        }
        return $graph;
    }

    /**
     * Get all attributes as an associative array.
     *
     * @return  array
     */
    public function toArray(): array
    {
        return array_map(function ($val) {
            return @$val->get() ?: null;
        }, $this->attributes);
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

    /**
     * Convert the entire graph model to JSON.
     *
     * @return  string  JSON
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
