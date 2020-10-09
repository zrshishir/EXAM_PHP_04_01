<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colleague;
use DataTables;

class ColleagueController extends Controller
{
        /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {

        if ($request->ajax()) {

            $data = Colleague::latest()->get();
            return Datatables::of($data)

                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

        }
        return view('colleague/index');

    }


    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {
        Colleague::updateOrCreate(['id' => $request->product_id],
                [
                    'office_name' => $request->office_name, 
                    'office_address' => $request->office_address,
                    'office_phone' => $request->office_phone,
                    'appointment_letter' => $request->appointment_letter,
                    'colleague_name' => $request->colleague_name,
                    'colleague_address' => $request->colleague_address,
                    'colleague_mobile' => $request->colleague_mobile,
                    'photo' => $request->photo,
                ]);        
        return response()->json(['success'=>'Colleague saved successfully.']);

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Colleague  $product

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $product = Colleague::find($id);
        return response()->json($product);

    }


    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Colleague  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        Colleague::find($id)->delete();
        return response()->json(['success'=>'Colleague deleted successfully.']);

    }

}
