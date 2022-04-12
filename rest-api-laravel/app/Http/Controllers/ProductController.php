<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'nama'=>'required|max:255',
            'type'=>'required|in:handphone,tablet,laptop',
            'stok'=>'required|numeric',
            'harga'=>'required|numeric', 
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(404);
        }

        $validated = $validator->validated();
        Product::create([
            'nama'=>$validated['nama'],
            'type'=>$validated['type'],
            'stok'=>$validated['stok'],
            'harga'=>$validated['harga']
        ]);
        return response()->json('Data Produk Berhasil Di Tambahkan')->setStatusCode(201);
    }
    public function show(){
        $products = Product::all();
        return response()->json($products)->setStatusCode(200);
    }
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'nama'=>'required|max:255',
            'type'=>'required|in:handphone,tablet,laptop',
            'stok'=>'required|numeric',
            'harga'=>'required|numeric', 
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(404);
        }
        $validated = $validator->validated();
        $checkData = Product::find($id);
        if($checkData){
            Product::where('id',$id)->update([
                'nama'=>$validated['nama'],
                'type'=>$validated['type'],
                'stok'=>$validated['stok'],
                'harga'=>$validated['harga']
            ]);
            return response()->json('Data Produk Berhasil di Update')->setStatusCode(201);
        }
        return response()->json('Data Produk Tidak Ada')->setStatusCode(404);
    }
    public function destroy($id){
        $checkData = Product::find($id);
        if($checkData){
            Product::destroy($id);
            return response()->json('Data Produk Berhasil di Hapus')->setStatusCode(201);
        }
        return response()->json('Data Produk Tidak Ada')->setStatusCode(404);
    }
}
