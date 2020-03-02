<?php

namespace Veloxia\Data\Casts;

use Veloxia\Data\Contracts\TypeContract;

abstract class Type implements TypeContract
{

    /**
     * Instanciate the type, optionally with data.
     *
     * @param   mixed   $value 
     *
     * @return  void
     */
    public function __construct($value = null)
    {
        $this->value = method_exists($this, 'format')
            ? $this->format($value)
            : $value;
    }

    /**
     * Import a serialized chunk of data and turn it into a "type".
     *
     * @param string $serialized
     *
     * @return self
     */
    public static function import(string $serialized): TypeContract
    {
        return new static(unserialize($serialized));
    }

    /**
     * Convert this graph model value into a serialized string. By default, `serialize()` is called on the `$this->value` attribute.
     *
     * @return  string 
     */
    public function export(): string
    {
        return serialize($this->value);
    }

    /**
     * Turn this attribute into a printable string. If the the attribute has a `pretty()` method, it will be used.
     *
     * @return string
     */
    public function __toString()
    {
        return method_exists($this, 'pretty')
            ? $this->pretty()
            : (string) $this->value;
    }

    /**
     * Get the raw value of this attribute "as is". 
     *
     * @return mixed|null
     */
    public function get()
    {
        return @$this->value ?: null;
    }
}
