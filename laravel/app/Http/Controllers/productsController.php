<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Status;

class productsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products')->join('users', 'users.id', '=', 'products.users_id')
        ->join('status', 'status.id', '=', 'products.status_id')
        ->select('products.*', 'users.name as author', 'status.name as status', 'status.class as status_class')
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'             => 'required|min:1|max:64',
            'description'           => 'required|max:1024',
            'product_type'         => 'required|max:64'
        ]);
        $user = auth()->userOrFail();
        DB::table('products')->insert([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status_id' => intval($request->input('status_id')),
            'product_type' => $request->input('product_type'),
            'users_id' => $user->id,
            'applies_to_date' => date('d-m-y'),
            'image' => $request->input('image')
        ]);
        
        /* Comente este codigo porque de esta forma produce un error 500
         $product = new Product();
        $product->title= $request->input('title');
        $product->description   = $request->input('description');
        $product->status_id = intval($request->input('status_id'));
        $product->product_type = $request->input('product_type');
        $product->applies_to_date = date('d-m-y');
        $product->users_id = $user->id;
        $product->save();*/
        return response()->json( ['status' => 'success'] );
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

        $product= DB::table('products')->find($id);

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
            'applies_to_date'   => 'required|date_format:Y-m-d',
            'product_type'         => 'required|max:64'
        ]);

        $product = Product::find($id);
        $product->title           = $request->input('title');
        $product->description     = $request->input('description');
        $product->status_id       = $request->input('status_id');
        $product->product_type    = $request->input('product_type');
        $product->applies_to_date = $request->input('applies_to_date');
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
