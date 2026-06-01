<?php

namespace App\Http\Services;

use App\Models\Category;

class CategoryService
{
    public function index(){
        $categories = Category::get();
        return $categories;
    }

    public function oneCategory($id){
        $category = Category::where("id",$id)->first();
        return $category;
    }

    public function createCategory($data){
        $category = Category::create($data);
        return $category;
    }

    public function updateCategory($category, $data){
        $category->update($data);
        return $category;
    }

    public function deleteCategory($category){
        $category->delete();
        return true;
    }
}