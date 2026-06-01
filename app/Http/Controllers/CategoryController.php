<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Services\CategoryService;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index(){

        $categories = $this->categoryService->index();

        return response()->json([
            "success"=>true,
            "data"=> CategoryResource::collection($categories)
        ]);

    }

    public function show($id){
        $category = $this->categoryService->oneCategory($id);

        if(!$category){
            return response()->json([
                "success"=>false,
                "message"=>"Category not found"
            ],404);
        }

        return response()->json([
            "success"=>true,
            "data"=> new CategoryResource($category)
        ]);

    }

    public function store(Request $request){

        $data = $request->validate([
            "title" => "required|string|max:255"
        ]);

        $category = $this->categoryService->createCategory($data);
        return response()->json([
            "success"=>true,
            "data"=> new CategoryResource($category)
        ],201);

    }

    public function update(Request $request, $id){
        $category = $this->categoryService->oneCategory($id);

        if(!$category){
            return response()->json([
                "success"=>false,
                "message"=>"Category not found"
            ],404);
        }
        
        $data = $request->validate([
            "title" => "required|string|max:255"
        ]);

        $category = $this->categoryService->updateCategory($category, $data);

        return response()->json([
            "success"=>true,
            "data"=> new CategoryResource($category)
        ]);
    }

    public function destroy($id){
        $category = $this->categoryService->oneCategory($id);

        if(!$category){
            return response()->json([
                "success"=>false,
                "message"=>"Category not found"
            ],404);
        }
        
        $this->categoryService->deleteCategory($category);

        return response()->json([
            "success"=>true,
            "message"=>"Category deleted successfully"
        ]);
    }   
}
