<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categorys =  Category::orderBy('id', 'desc')->paginate(200);
        $permission = Role::where('id', Auth::user()->role)->first();

        return view('pages.items.category', compact('categorys', 'permission'));
    }

    public function addCategory(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|unique:categories,name',
        ], [
            'name.unique' => 'This name already exists. Please choose another name.',
            'name.required' => 'This name already exists. Please choose another name.',
        ]);
        $category = Category::create([
            'name' => $request->category_name,
            'description' => $request->description,
        ]);
        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($category)
            ->withProperties(['data' => $category])
            ->log('Added new Category');
        return back()->with('success', 'Category Added Successfully.');
    }

    public function editCategory(Request $request, $id)
    {

        $category = Category::find($id);
        $category->update([
            'name' => $request->category_name,
        ]);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($category)
            ->withProperties(['data' => $category])
            ->log('Edited new Category');
        return back()->with('success', 'Update Successfully.');
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($category)
            ->withProperties(['data' => $category])
            ->log('Deleted new Category');
        return back()->with('success', ' Category Deleted Successfully.');
    }
}
