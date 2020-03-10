<?php

namespace Veloxia\Data\Graph;

use Veloxia\Data\Contracts\GraphContract;

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
     * @param string $slug The slug URL associated with the wanted model
     */
    public static function find(string $slug): self
    {
        // Bind this graph model in the container.
        app()->singleton(static::$graphName.'.'.$slug, function () use ($slug) {
            return new static(app('data')->find(static::$graphName, $slug));
        });

        return app(static::$graphName.'.'.$slug);
    }

    /**
     * Create a new model instance.
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
     * @return mixed
     */
    public function get(string $attribute)
    {
        return $this->attributes[$attribute]
                    ?? $this->$attribute()
                    ?? null;
    }

    /**
     * Set the value of an attribute.
     *
     * @param string $attribute Attribute label
     * @param \Veloxia\Data\Casts\TypeContract
     *
     * @return mixed
     */
    public function set(string $attribute, $type)
    {
        return $this->attributes[$attribute] = $type;
    }

    /**
     * Magic method to steer direct referencing to the correct "pseudo variable".
     *
     * @return mixed
     */
    public function __get(string $attribute)
    {
        if (!isset($this->$attribute) && array_key_exists($attribute, $this->attributes)) {
            return $this->attributes[$attribute]->get();
        }
    }

    /**
     * Turn this graph model into an array of serialized type objects.
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
     */
    public static function import(array $values): GraphContract
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
     */
    public function toArray(): array
    {
        return array_map(function ($val) {
            return @$val->get() ?: null;
        }, $this->attributes);
    }

    /**
     * Get all attributes as JSON.
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
     * @return string JSON
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
