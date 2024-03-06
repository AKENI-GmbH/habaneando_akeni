<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class StructuredCategory extends Model
{
    use Sushi;

    protected $rows = [];

    public function __construct($categories = [])
    {
        foreach ($categories as $category) {
            $catArray = $this->formatCategory($category);
    
            $this->rows[] = $catArray;
    
            foreach ($category->subcategories as $subcategory) {
                $subcatArray = $this->formatSubcategory($subcategory, $category->id);
                dd($subcatArray); // Check the formatted subcategory array
    
                $this->rows[] = $subcatArray;
            }
        }
    }
    

    private function formatCategory($category)
    {
        // Here, transform the category object into an array
        return [
            'id' => $category->id,
            'type' => 'category',
            'name' => $category->name,
            // other category fields...
        ];
    }

    private function formatSubcategory($subcategory, $categoryId)
    {
        return [
            'id' => $subcategory->id,
            'type' => 'subcategory',
            'name' => $subcategory->name,
            'category_id' => $categoryId,
        ];
    }
}
