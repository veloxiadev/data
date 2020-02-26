<?php

namespace Veloxia\Data\Contracts;

interface TypeContract
{
    /**
     * This method is used to convert the value of an attribute into a string that is suitable for saving on disk or in a database.
     *
     * @return string
     */
    public function export(): string;

    /**
     * Unserialize a value that has been exported using the export() method and turn it into a `graph type`.
     *
     * @param string $serialized
     *
     * @return TypeContract
     */
    public static function import(string $serialized): TypeContract;
}
