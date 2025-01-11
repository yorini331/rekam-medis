<?php

namespace App\Http\Controllers;

use App\Models\Rfid;
use App\Models\Kartu_Pasien;
use App\Events\RfidDataReceived;
use Illuminate\Http\Request;

class RfidController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rfid' => ['required'],
        ]);
        
        $rfidData = new Rfid();
        $rfidData->rfid = $request->rfid;
        $rfidData->save();
        $kartu_pasien = Kartu_Pasien::with('pasien')->where('kode_kartu',  $request->rfid)->first();
        if($kartu_pasien == null) {
            event(new RfidDataReceived($rfidData->rfid));
            return response()->json(['message' => 'Data saved successfully',
                                     'nama' => 'Data Tidak Ditemukan']);
        } else {
            event(new RfidDataReceived($rfidData->rfid));
            return response()->json(['message' => 'Data saved successfully',
                                     'nama' => $kartu_pasien->pasien->nama]);
        }
    }
}
