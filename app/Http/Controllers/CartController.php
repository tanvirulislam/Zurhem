<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\Product;
use App\Category;
use App\Subcategory;
use Brian2694\Toastr\Facades\Toastr;

class CartController extends Controller
{
    public function cart(){
        $category = Category::all();
        $subcategory_first = Subcategory::latest()->limit(1)->first();
        $subcategory_second = Subcategory::latest()->skip(1)->take(1)->first();
        $subcategory_third = Subcategory::latest()->skip(2)->take(1)->first();
        $product = Product::latest()->limit(6)->get();
		$image = Photo::all();

        $cartCollection = \Cart::getContent();
// dd($cartCollection);
        return view('front.cart', compact('cartCollection','category', 'subcategory_first', 'product', 'subcategory_second',
		 'subcategory_third', 'image'));
    }

    public function add(Request $request){
		// dd($request);
		\Cart::add(array(
			'id' => $request->id,
			'name' => $request->name,
			'price' => $request->price,
			'quantity' => $request->quantity,
			
			'attributes' => array(
				'image' => $request->img,
				'size' => $request->size,
			)
		));
        Toastr::success('Item Add 🙂' ,'Success');
		return redirect()->route('cart.index')->with('success_msg', 'Item is Added to Cart!');
	}

    public function update(Request $request){
		\Cart::update($request->id,
			array(
				'quantity' => array(
					'relative' => false,
					'value' => $request->quantity
				),
			));
        Toastr::success('Successully Updated 🙂' ,'Success');
		return redirect()->route('cart.index')->with('success_msg', 'Cart is Updated!');
	}

    public function remove(Request $request){

		\Cart::remove($request->id);
        Toastr::warning('Successully Deleted 🙂' ,'Success');
		return redirect()->route('cart.index')->with('success_msg', 'Item is removed!');
	}

    public function clear(){
        
		\Cart::clear();
        Toastr::warning('Successully Deleted 🙂' ,'Success');
		return redirect()->route('cart.index')->with('success_msg', 'Car is cleared!');
	}
}
