<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Article;

class ExistingArticleUpdate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $category_id;

    protected $id;

    protected $title_exist_another;

    public function __construct($category_id, $id)
    {
        $this->id = $id;
        $this->category_id = $category_id;
        $this->title_exist_another = false;
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
        $title_slug = str_slug($value);

        //checking in other categories
        $articles = Article::where([
            ['category_id', '!=', $this->category_id],
        ])->where('slug', $title_slug)->get();

        if ($articles->count()) {
            $this->title_exist_another = true;
            return false;
        }

        //existing article with different ID belongs to same category
        $existing_article = Article::where([
            ['id', '!=', $this->id],
            ['slug',  $title_slug]
        ])->first();

        if ($existing_article) {
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
        return $this->title_exist_another == true ? "Title has already been taken by an article in another category." : "Title already exists in a previously created article.";
    }
}
