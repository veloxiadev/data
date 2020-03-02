<?php

namespace Veloxia\Data\Contracts;

interface GraphContract
{
    /**
     * Turn the whole graph model into an array of serialized values, by calling the `$this->export()` method on each value.
     *
     * @return array
     */
    public function export(): array;

    /**
     * Parse previously exported values to populate a graph model with attributes.
     *
     * @param array $values
     *
     * @return GraphContract
     */
    public static function import(array $values): self;
}
