<?php

namespace App\Rules;

use App\Models\Article;
use Illuminate\Contracts\Validation\Rule;

class UniqueCategoryName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $category_id;

    public function __construct($category_id)
    {
        $this->category_id = $category_id;
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
        $articles = Article::where([
            ['category_id', $this->category_id],
            ['title', $value]
        ])->get();

        if ($articles->count()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Article name is already taken for this category.';
    }
}
