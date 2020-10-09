<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colleague;
use DataTables;
use Validator, Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

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
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editColleague">Edit</a>';
                        //    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="btn btn-warning btn-sm viewColleague">View</a>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteColleague">Delete</a>';
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
                    'appointment_letter' => $this->imageUpload($request->appointment_letter),
                    'colleague_name' => $request->colleague_name,
                    'colleague_address' => $request->colleague_address,
                    'colleague_mobile' => $request->colleague_mobile,
                    'photo' => $this->imageUpload($request->photo),
                ]);        
        return response()->json(['success'=>'Colleague saved successfully.']);

    }

    public function imageUpload($image){
        $imageName = microtime(true) . '.' . 'png';
        $path = '/imports/documents/' . $imageName;
        Storage::disk('local')->put($path, $image);
        return $imageName;
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Colleague  $colleague

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $colleague = Colleague::find($id);
        return response()->json($colleague);

    }


    public function view($id)

    {

        $colleague = Colleague::find($id);
        return response()->json($colleague);

    }


    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Colleague  $colleague

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        Colleague::find($id)->delete();
        return response()->json(['success'=>'Colleague deleted successfully.']);

    }

}
