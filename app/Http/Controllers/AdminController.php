<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

use App\Models\Product;

class AdminController extends Controller
{
    public function view_category(){
        $data=category::all();

        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request){

        $data=new category;

        $data->category_name=$request->category;

        $data->save();

        return redirect()->back()->with('message','Category Added Successfully.');

    }

    public function delete_category($id){

        $data=category::find($id);

        $data->delete();

        return redirect()->back()->with('message','Deleted Successfully!');

    }

    public function view_product(){

        $category=category::all();
        return view('admin.product',compact('category') );
    }

    public function add_product(Request $request){

        // create new product
        $product=new product;

        // get info of product
        $product->title=$request->title;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->quantity=$request->quantity;
        $product->discount_price=$request->discount_price;
        $product->category=$request->category;

        // get image into data
        $image=$request->image;
        $imagename=time().'.'.$image->getClientOriginalExtension();
        $request->image->move('product', $imagename);

        $product->image=$imagename;


        // save new product
        $product->save();

        return redirect()->back()->with('message','New product is added successfully!');

    }

    public function show_product(){
        
        $product=product::all();

        return view('admin.show_product',compact('product'));
    }

    public function delete_product($id){

        $product=product::find($id);

        $product->delete();

        return redirect()->back()->with('message','Deleted Successfully!');
    }

    public function update_product($id){

        $product=product::find($id);

        $category=category::all();

        return view('admin.update_product',compact('product','category'));
    }

    public function update_product_confirm(Request $request, $id) {
        
        $product=product::find($id);

        $product->title=$request->title;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->quantity=$request->quantity;
        $product->discount_price=$request->discount_price;
        $product->category=$request->category;


    
        $image=$request->image;

        if($image){

            $imagename=time().'.'.$image->getClientOriginalExtension();

            $request->image->move('product', $imagename);

            $product->image=$imagename;
            
        }

        $product->save();

        return redirect()->back()->with('message','Product Updated Successfully!');
    }
}
