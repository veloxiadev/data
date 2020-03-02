<?php

namespace Veloxia\Data\Exceptions;

use Exception;
use Throwable;

abstract class VeloxiaException extends Exception
{
    /**
     * @param string            $message
     * @param \Throwable|null   $originalException      (optional)
     */
    public function __construct(string $message, ?Throwable $originalException = null)
    {
        parent::__construct($message, 0, $originalException);
    }
}
