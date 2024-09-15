<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * 
     */
    public function indexs(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sortBy')) {
            $query->orderBy($request->sortBy, $request->sortDirection ?? 'asc');
        }

        $products = $query->paginate(10);  // Adjust the per-page limit if necessary

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
        ]);
        return Product::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function index(Request $request){
        // $passOwner = $request->owner;
        // $isAll = $passOwner=="ALL RECORDS" ? true : false;
        // $office = auth()->user()->office;
        // $data = PwrdProfile::select(
        //     'eccappprofile.uid',
        //     DB::raw("CONCAT(eccappprofile.surname, ', ', eccappprofile.firstname, ' ', IFNULL(eccappprofile.middlename,'')) as name"),
        //     'eccappprofile.psaddress',
        //     DB::raw("CONCAT(eccappprofile.telno, '; ', eccappprofile.mobileno, '; ', eccappprofile.email) as contactdetails"),
        //     'eccappprofile.owner',
        //     DB::raw("(SELECT COUNT(uid) FROM eccmedservices WHERE uid=eccappprofile.uid and deleted='1') AS ems"),
        //     DB::raw("(SELECT COUNT(uid) FROM ecctrainingservices WHERE uid=eccappprofile.uid and deleted='1') AS ets"),
        //     DB::raw("(SELECT COUNT(uid) FROM ecctma WHERE uid=eccappprofile.uid and deleted='1') AS tma"),
        //     DB::raw("(SELECT COUNT(uid) FROM eccstarterkits WHERE uid=eccappprofile.uid and deleted='1') AS stk")
        // )
        // ->where('eccappprofile.deleted', '1');
        // //add kondisyon na co lng pwede magchange
        // if($office == "CO" && !$isAll){
        //     $data->where('eccappprofile.owner', $passOwner);
        // }

        // if($office != "CO"){
        //     $data->where('eccappprofile.owner', $office);
        // }

        // if($isAll) $data->orderBy("owner", "ASC");

        // $data = $data->orderByDesc('eccappprofile.uid')
        // ->get();

        return Datatables::of(Product::all())->make(true);
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
        $validated = $request->validate([
            'title' => 'required',
        ]);
        return Product::update($validated);
        // return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::delete();
        return response()->json(['message' => 'Post deleted']);
    }
}
