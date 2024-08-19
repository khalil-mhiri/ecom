<?php
namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'brand' => 'required',
            'desc' => 'required',
            'image' => 'required|image',
            'price'=>'required',
        ]);
        if($validator->fails())
        {
            return response()->json(['error' => $validator->errors()->all()], 409);
        }

        $p = new Product();
        $p->name = $request->name;
        $p->category = $request->category;
        $p->brand = $request->brand;
        $p->desc = $request->desc;
        $p->price = $request->price;
        $p->save();

// Storing Image
        $url = "http://localhost:8000/storage/";
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $path = $request->file('image')->storeAs('proImages/', $p->id . '.' . $extension);
        $imagePath = $url . $path;
        $p->image = $imagePath;
        $p->save();

    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'brand' => 'required',
            'desc' => 'required',
            'id' => 'required',
            'price'=>'required',
        ]);
        if($validator->fails())
        {
            return response()->json(['error' => $validator->errors()->all()], 409);
        }

        $p = product::find($request->id);
        $p->name = $request->name;
        $p->category = $request->category;
        $p->brand = $request->brand;
        $p->desc = $request->desc;
        $p->price = $request->price;
        $p->save();
        return response()->json(['message' => " Product Successfully updated"]);
    }
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json(['error' => $validator->errors()->all()], 409);
        }

        $p = product::find($request->id)->delete();
        return response()->json(['message' => " Product Successfully Deleted"]);
    }
    public function show(Request $request)
    {
        session(['keys' => $request->keys]);
        $products = product::where(function ($q) {
            $q->where('products.id', 'LIKE', '%' . session('keys') . '%')
                ->orWhere('products.name', 'LIKE', '%' . session('keys') . '%')
                ->orWhere('products.price', 'LIKE', '%' . session('keys') . '%')
                ->orWhere('products.category', 'LIKE', '%' . session('keys') . '%')
                ->orWhere('products.brand', 'LIKE', '%' . session('keys') . '%');
        })->select('products.*')->get();

        return response()->json(['products' => $products]);
    }
}

