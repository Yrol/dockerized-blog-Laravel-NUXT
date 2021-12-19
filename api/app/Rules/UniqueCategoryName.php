<?php

namespace App\Rules;

use App\Models\Article;
use App\Models\Category;
use ErrorException;
use Illuminate\Contracts\Validation\Rule;

class UniqueCategoryName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $category_slug;
    protected $category;

    public function __construct($category_slug)
    {
        $this->category_slug = $category_slug;
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
        $this->category =  Category::where('slug', $this->category_slug)->first();

        if ($this->category && $this->category->id) {
            $articles = Article::where([
                ['category_id',$this->category->id],
                ['title', $value]
            ])->get();

            if ($articles->count() <= 0) {
                return true;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute is already taken for this category or the category does not exist.';
    }
}
