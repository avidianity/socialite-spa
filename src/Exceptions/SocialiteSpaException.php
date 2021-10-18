<?php

namespace Avidianity\SocialiteSpa\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class SocialiteSpaException extends HttpException
{
    /**
     * @param string $message
     */
    public function __construct($message = '')
    {
        parent::__construct(403, $message, null, ['Content-Type' => 'application/json']);
    }
}
