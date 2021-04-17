<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Status;

class productsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products')->join('users', 'users.id', '=', 'products.users_id')
        ->join('status', 'status.id', '=', 'products.status_id')
        ->select('products.*', 'users.name as author', 'status.name as status', 'status.class as status_class')
        ->where('exist','=',0)->where('status_id','=',1)
        ->limit(6)
        ->get();
        return response()->json( $products );
    }

    public function AllProducts()
    {
        $products = DB::table('products')->join('users', 'users.id', '=', 'products.users_id')
        ->join('status', 'status.id', '=', 'products.status_id')
        ->select('products.*', 'users.name as author', 'status.name as status', 'status.class as status_class')
        ->where('exist','=',0)
        ->get();
        return response()->json( $products );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $statuses = DB::table('status')->select('status.name as label', 'status.id as value')->get();
        return response()->json( $statuses );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function uploadImage(Request $request){
       $validate = request()->validate([
            'image'          => "required"
        ]);

        if($request->hasFile('image')){
            $image_path = $request->file('image');
            $image_path_name = time().$image_path->getClientOriginalName();
			Storage::disk('public')->put($image_path_name, File::get($image_path));
            return response()->json(['imagePath' => $image_path_name]); 
        }
        return response()->json(['path' => 'error']); 

    }

   
    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'title'             => 'required|min:1|max:64',
            'description'       => 'required|max:1024',
            'product_type'      => 'required|max:64',
            'price'             => 'required'
        ]);
        if($request->hasFile('image')){
            $image_path = $request->file('image');
            $image_path_name = time().$image_path->getClientOriginalName();
			//Storage::disk('products')->put($image_path_name, File::get($image_path));
        var_dump($request->input('title'));
        var_dump($request->input('description'));
        var_dump($request->input('product_type'));
        var_dump($image_path_name);
        var_dump($request->input('price'));
        $user = auth()->userOrFail();
        $query=DB::table('products')->insert([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status_id' => 1,
            'product_type' => $request->input('product_type'),
            'users_id' => $user->id,
            'applies_to_date' => date('Y/m/d'),
            'image' => $image_path_name,
            'exist' => 0,
            'price' => $request->input('price')
             ]);
             
        if($query){
            return response()->json( ['status' => 'success'] );
         }
         return response()->json(['status' => 'Error en la query.']);
         
    } else 
    {
        return response()->json(['message' => 'The given data was invalid.']); 
    }           
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product= DB::table('products')->join('users', 'users.id', '=', 'products.users_id')
        ->join('status', 'status.id', '=', 'products.status_id')
        ->select('products.*', 'users.name as author', 'status.name as status', 'status.class as status_class')
        ->where('products.id', '=', $id)
        ->first();
        return response()->json( $product );
    }

    public function showPerUser()
    {
        $user = auth()->userOrFail();
        $products = DB::table('products')->join('status','status.id','=','products.status_id')
        ->select('products.*','status.name as status', 'status.class as status_class')
        ->where('users_id',$user->id)->where('exist','=',0)->get();
        return response()->json( $products );
    }

    public function deleteProduct($id){

        $product = Product::find($id);

        if($product){
            $product->exist = 1;
            $product->save();
        }
        return response()->json( ['status' => 'success'] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=DB::table('products')->where('id', '=', $id)->first();        
        $statuses = DB::table('status')->select('status.name as label', 'status.id as value')->get();

        return response()->json( [ 'statuses' => $statuses, 'product' => $product ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title'             => 'required|min:1|max:64',
            'description'           => 'required|max:1024',
            'status_id'         => 'required',
            'product_type'         => 'required|max:64',
            'price'             => 'required'
        ]);
        $product = Product::find($id);
        if($request->hasFile('image')){
            $image_path = $request->file('image');
            $image_path_name = time().$image_path->getClientOriginalName();
			Storage::disk('public')->put('products/'.$image_path_name, File::get($image_path));
            $product->image = $image_path_name;
        }
    /*if($request->input('image')!=''){

            $product->image = $request->input('image');
    } */   
        
        $product->title           = $request->input('title');
        $product->description     = $request->input('description');
        $product->status_id       = $request->input('status_id');
        $product->product_type    = $request->input('product_type');
        $product->applies_to_date = date('Y/m/d');
        $product->price           = $request->input('price');        
        $product->save();
        return response()->json( ['status' => 'success'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = DB::table('products')->find($id);
        if($product){
            $product->delete();
        }
        return response()->json( ['status' => 'success'] );
    }
}
