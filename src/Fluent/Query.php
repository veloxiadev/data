<?php

namespace Veloxia\Data;

use Veloxia\Data\Fluent\Fluent;

class Query implements Fluent
{
    protected $sequence = [];
    protected $reference;
    protected $graph;

    /**
     * Create a new query.
     *
     * @param string $reference
     * @param object $graph
     */
    public function __construct($reference, $graph)
    {
        $this->reference = $reference;
        $this->graph = $graph;
    }

    /**
     * Capture all calls.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return self
     */
    public function __call($name, $arguments)
    {
        // Direct attribute name accessor, class->get('name')
        if (method_exists($this->graph, $name)) {
            $this->sequence[] = $this->graph->get($name);
        }
        // Indirect attribute accessor, class->name()
        elseif (method_exists($this, $name)) {
            $this->sequence[] = call_user_func([$this, $name], ...$arguments);
        }
        // None was found, most likely the attribute does not exist
        else {
            throw new \LogicException('Could not call accessor method "'.$name.'"; it does not seem to exist');
        }

        return $this;
    }

    /**
     * All direct requests for attributes will be passed to the corresponding graph accessor method.
     *
     * @param string $attribute
     *
     * @return self
     */
    public function __get($attribute)
    {
        $this->$attribute();

        return $this;
    }

    /**
     * Check if the previously referenced attribute conforms to some specified logic.
     *
     * @param \Closure|>=|<=|>|<|=|!= $operator  The operator to use, i.e. =, <, <= etc
     * @param string|null             $compareTo The attribute to apply comparison against
     */
    public function is($operator, $compareTo = null): Fluent
    {
        $pass = null;
        $reference = $this->graph->get($this->reference);

        // If first parameter is a function, we'll use the response directly
        if (is_callable($operator)) {
            $this->sequence[] = $operator($reference->get());

            return $this;
        }

        // If the method was called like so: $class->attribute->`is(x)`
        if ($compareTo === null) {
            $comparison = $operator;
            $operator = '=';
        }

        // Limit to a few operators
        switch ($operator) {
                    case '<':
                        $pass = $reference < $comparison;
                        break;
                    case '=':
                        $pass = $reference == $comparison;
                        break;
                    case '!=':
                        $pass = $reference != $comparison;
                        break;
                    case '>':
                        $pass = $reference > $comparison;
                        break;
                    case '>=':
                        $pass = $reference >= $comparison;
                        break;
                    case '<=':
                        $pass = $reference <= $comparison;
                        break;
                }

        // Add the truth value to the sequence
        $this->sequence[] = $pass;

        return $this;
    }

    public function then()
    {
        dd($this->sequence);
    }
}
