<?php

namespace Ignite\Finance\Library\Payments\Core\Exceptions;

/**
 * Class InvalidRequestException
 * @package Dervis\Library\Payments\Equity\Exceptions
 */
class InvalidRequestException extends ApiException
{
    /**
     * Error messages with their corresponding keys
     *
     * @var array
     */
    const ERRORS = [
        400 => "Bad Request - Please ensure the request is valid.",
        401 => "Unauthorized - Please check the Authorization header.",
        404 => "Not Found - Please check the URL.",
        500 => "Internal Server Error - Please try later.",
    ];
}