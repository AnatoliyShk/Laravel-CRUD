<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class ArraySize implements Rule
{
    /** @var the maximum size of the array */
    private int $size;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($size)
    {
        $this->size = $size;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $total = 0;

        if (!is_array($value)) {
            // not an array, fail it
            return false;
        }

        foreach ($value as $file) {
            if (!$file instanceof UploadedFile) {
                // not a file, fail it
                return false;
            }
            $total += $file->getSize();
        }

        return ($total / 1024) > $this->size;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return sprintf('The size of all images must be less than %d kB', $this->size);
    }
}
