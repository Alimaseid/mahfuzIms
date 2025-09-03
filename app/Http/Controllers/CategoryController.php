<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

     $categorys =  Category::all();

       return view('pages.items.category',compact('categorys'));
    }

    public function addCategory(Request $request){

       Category::create([
            'name'=>$request->category_name,
            'description'=>$request->description,
        ]);
        return back()->with('success','Category Added Successfully.');
    }

    public function editCategory(Request $request,$id){
        Category::where('id',$id)->update([
            'name'=>$request->category_name,
        ]);
        return back()->with('success','Update Successfully.');
    }

     public function deleteCategory($id){
        Category::where('id',$id)->delete();
        return back()->with('success',' Category Deleted Successfully.');

    }
}
