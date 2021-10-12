<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::all();

        return view('pages.bagian.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       try {
        //    $validator = $request->validate([
        //        'name'=>'required|unique:divisions'
        //    ]);
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:divisions',
                'leader' => 'required'
            ]);
            // dd($validator);
           if ($validator->fails()) {
               $concatenatedMessage = '';
               $messages = $validator->messages()->get('*');
               foreach ($messages as $key => $value) {
                    $concatenatedMessage = $concatenatedMessage .$value[0]. "\r\n";
               }
              alert("Error", $concatenatedMessage, 'error');
              return back();
           }
           Division::create($request->all());
            alert('Success','Data berhasil ditambahkan', 'success' );
            return back();
       } catch (\Throwable $th) {
           alert('Error', $th->getMessage(), 'error');
        return back();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try {
            $division = Division::find($id);
            $division->update($request->all());
            alert('Success', 'Data berhasil diupdate', 'success');
            return back();
        } catch (\Throwable $th) {
            alert('Gagal', 'Oops', 'error');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $division = Division::find($id);
            $division->delete();
            alert('Success', 'Data berhasil dihapus', 'success');
            return back();
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            alert('Gagal', 'Oops', 'error');
            return back();
        }
    }
}
