<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Notifications\ProductCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('dashboard.products', compact('products'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'article' => 'required|unique:products',
            'name' => 'required|min:10',
        ]);

        $product = new Product();

        $article = $request->post('article');
        $name = $request->post('name');
        $status = $request->post('status');

        $attrNames = $request->post('attr_name');
        $attrValue = $request->post('attr_value');

        $data = [];

        if ($attrNames) {
            foreach ($attrNames as $key => $item) {
                $data[] = [
                    'name' => $item,
                    'value' => $attrValue[$key],
                ];
            }
        }

        if ("admin" === config('products.role')) {
            $product->article = $article;
        }

        $product->name = $name;
        $product->status = $status;
        $product->data = json_encode($data);
        $product->save();

        Notification::send(Auth::user(), new ProductCreated(Auth::user()));

        return redirect()->back();
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'article' => 'required|unique:products,article,' . $id,
            'name' => 'required|min:10',
        ]);

        $product = Product::find($id);
        $article = $request->post('article');
        $name = $request->post('name');
        $status = $request->post('status');

        $attrNames = $request->post('attr_name');
        $attrValue = $request->post('attr_value');

        $data = [];

        if ($attrNames) {
            foreach ($attrNames as $key => $item) {
                $data[] = [
                    'name' => $item,
                    'value' => $attrValue[$key],
                ];
            }
        }

        // dd($data);

        $product->article = $article;
        $product->name = $name;
        $product->status = $status;
        $product->data = json_encode($data);
        $product->save();

        return redirect()->back();
    }

    public function remove($id)
    {
        Product::destroy($id);

        return redirect()->back();
    }

    public function getById($id)
    {
        $product = Product::find($id);

        return response()->json([
            'success' => 'ok',
            'product' => $product,
        ]);
    }
}
