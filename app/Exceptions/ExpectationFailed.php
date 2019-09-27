<?php

namespace App\Exceptions;

use Exception;


/**
 * Class ExpectationFailed
 * @package App\Exceptions
 * @author samark chaisanguan <samarkchsngn@gmail.com>
 */
class ExpectationFailed extends Exception
{
    /**
     * set http standard code
     */
    const code = '417';

    /**
     * set http standard message
     */
    const message = 'Expectation Failed';
}