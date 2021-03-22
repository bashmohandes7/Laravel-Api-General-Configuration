<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use GeneralTrait;
    public function index(){
        $categories = Category::Selection();
        return response()->json($categories);
    }
    public function getCategoryById(Request $request){
        $category = Category::Selection()->find($request->id);
        if(!$category)
        return $this->returnError('2001', 'هذا المتج غير موجود');
        return $this->returnData('category', $category, 'تم جلب البيانات بنجاح');
    }
    public function changeCategoryStatus(Request $request){
        $category = Category::where('id', '=', $request->id);
        if(!$category)
        return $this->returnError('2001', 'هذا المتج غير موجود');
        $category->update(['active'=> $request->active]);
        return $this->returnSuccessMessage('','تم تحديث حالة المنتج بنجاح');
    }
}
