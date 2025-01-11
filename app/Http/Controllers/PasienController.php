<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use PDF;
use App\Exports\PasienExport;

use Maatwebsite\Excel\Facades\Excel;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pasien = Pasien::get();
        return view('admin.pasien', ['pasien' => $pasien]);
    }

    public function pasien_pdf()
    {
        $pasien = Pasien::all();
        $pdf = PDF::loadView('admin.pasien-pdf', compact('pasien'));
        return $pdf->download('data-pasien.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pasien-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private function _validation(Request $request){
        // validasi inputan dari form
        $validated = $request->validate([
            'nama' => 'required',
            'usia' => 'required',
            'bidang' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'tgl_daftar' =>'required|date',
        ],

        [
            'nama.required' => 'Form ini harus diisi !',
            'usia.required' => 'Form ini harus diisi !',
            'bidang.required' => 'Form ini harus diisi !',
            'no_hp.required' => 'Form ini harus diisi !',
            'alamat.required' => 'Form ini harus diisi !',
            'tgl_daftar.required' => 'Form ini harus diisi !',
            
        ]);
    }

    private function _validation_update(Request $request){
        // validasi inputan dari form
        $validated = $request->validate([
            'nama' => 'required',
            'usia' => 'required',
            'bidang' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'tgl_daftar' =>'required|date',
        ],

        [
            'nama.required' => 'Form ini harus diisi !',
            'usia.required' => 'Form ini harus diisi !',
            'bidang.required' => 'Form ini harus diisi !',
            'no_hp.required' => 'Form ini harus diisi !',
            'alamat.required' => 'Form ini harus diisi !',
            'tgl_daftar.required' => 'Form ini harus diisi !',
        ]);
    }

    public function store(Request $request)
    {
        $this->_validation($request);
        $current_date_time = Carbon::today()->toDateString();

        $pasien = new Pasien;
        $pasien->nama = $request->nama;
        $pasien->usia = $request->usia;
        $pasien->bidang = $request->bidang;
        $pasien->no_hp = $request->no_hp;
        $pasien->alamat = $request->alamat;
        $pasien->tgl_daftar = $request->tgl_daftar;
        $pasien->created_at = $current_date_time;
        $pasien->updated_at = $current_date_time;
        $pasien->save();

        return redirect()->route('pasien.index');
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
        $pasien = Pasien::find($id);
        return view('admin.pasien-edit', ['pasien' => $pasien]);
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
        $this->_validation_update($request);
        Pasien::where('id', $id)->update(['nama' => $request->nama, 'usia' => $request->usia, 'bidang' => $request->bidang, 'no_hp' => $request->no_hp, 'alamat' => $request->alamat, 'tgl_daftar' => $request->tgl_daftar]);
        return redirect()->route('pasien.index')->with('update_berhasil', 'Update Data Berhasil'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pasien::destroy($id);
        return redirect()->route('pasien.index');
    }
    

    public function export_excel()
    {
        return Excel::download(new PasienExport, 'pasien.xlsx');
    }
}
