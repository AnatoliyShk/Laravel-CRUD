<?php


namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Log;

class UpdateEntityException extends \Exception
{
    public function __construct($message = "Something went wrong while updating", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report()
    {
        Log::error('Something went wrong while creating');
    }
}
