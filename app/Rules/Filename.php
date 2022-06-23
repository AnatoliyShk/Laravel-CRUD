<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Filename implements Rule
{
    protected $regex;

    public function __construct(string $regex)
    {
        $this->regex = $regex;
    }

    public function passes($attribute, $value)
    {
        return $value->getClientOriginalName();
    }

    public function message()
    {
        return 'The :attribute name is invalid.';
    }
}
