<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
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
        $products = Products::join('users', 'users.id', '=', 'products.users_id')
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
        $statuses = Status::select('status.name as label', 'status.id as value')->get();
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
            'status_id'         => 'required',
            'applies_to_date'   => 'required|date_format:Y-m-d',
            'product_type'         => 'required|max:64'
        ]);
        $user = auth()->userOrFail();
        $product = new Products();
        $product->title     = $request->input('title');
        $product->description   = $request->input('description');
        $product->status_id = $request->input('status_id');
        $product->product_type = $request->input('product_type');
        $product->applies_to_date = $request->input('applies_to_date');
        $product->users_id = $user->id;
        $product->save();
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
        $product=Products::join('users', 'users.id', '=', 'products.users_id')
        ->join('status', 'status.id', '=', 'products.status_id')
        ->select('products.*', 'users.name as author', 'status.name as status', 'status.class as status_class')
        ->where('products.id', '=', $id)
        ->first();
        return response()->json( $product );
    }

    public function showPerUser()
    {
        $user = auth()->userOrFail();
        $products = DB::table('products')->where('users_id',$user->id)->get();
        return response()->json( $products );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Products::where('id', '=', $id)->first();        
        $statuses = Status::select('status.name as label', 'status.id as value')->get();

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
        $product = Products::find($id);
        $product->title     = $request->input('title');
        $product->description   = $request->input('description');
        $product->status_id = $request->input('status_id');
        $product->product_type = $request->input('product_type');
        $product->applies_to_date = $request->input('applies_to_date');
        $product->users_id = $user->id;
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
        $product = Products::find($id);
        if($product){
            $product->delete();
        }
        return response()->json( ['status' => 'success'] );
    }
}
