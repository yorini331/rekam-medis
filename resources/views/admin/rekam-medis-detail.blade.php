@extends('admin.layouts.master')

@section('title')
    Dashboard | Admin
@endsection

@push('page-styles')
    <style>
        .row {
            display: flex;
            align-items: flex-start; /* Changed from center to flex-start */
        }
        .label-col {
            text-align: right;
        }
    </style>
@endpush

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @if (session('update_berhasil'))
                <div class="alert alert-warning alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>x</span>
                        </button>
                        <div class="container">
                            <div class="col-12">
                            {{ session('update_berhasil')}}
                            </div>
                        </div>
                    </div>  
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h3>Detail Rekam Medis</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <hr>
                <div class="card">
                    <div class="card-header">
                        <h4>Data Pasien</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-4 font-weight-bold label-col">Id Pasien :</div>
                            <div class="col-8">{{$kartu_pasien->pasien->id}}</div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-4 font-weight-bold label-col">Nama Pasien :</div>
                            <div class="col-8">{{$kartu_pasien->pasien->nama}}</div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-4 font-weight-bold label-col">Usia :</div>
                            <div class="col-8">{{$kartu_pasien->pasien->usia}}</div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-4 font-weight-bold label-col">No Hp :</div>
                            <div class="col-8">{{$kartu_pasien->pasien->no_hp}}</div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-4 font-weight-bold label-col">Alamat :</div>
                            <div class="col-8">{{$kartu_pasien->pasien->alamat}}</div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-4 font-weight-bold label-col">Bidang :</div>
                            <div class="col-8">{{$kartu_pasien->pasien->bidang}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <hr>
                <div class="card">
                    <div class="card-header">
                        <h4>Data Rekam Medis</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <a class="btn btn-primary" href="{{ route('rekam_medis.create') }}">+ Tambah Data Rekam Medis</a>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table id="table_id" class="text-center table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Id Rekam Medis</th>
                                                <th>Keluhan</th>
                                                <th>Diagnosa</th>
                                                <th>Obat</th>
                                                <th>Nama Dokter</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rekam as $no => $data)
                                            <tr>
                                                <td>{{ $no+1 }}</td>
                                                <td></td>
                                                <td>{{$data->keluhan}}</td>
                                                <td>{{$data->diagnosa}}</td>
                                                <td>  
                                                    @foreach (json_decode($data->obat_id) as $value)
                                                        {{ $value }},
                                                    @endforeach
                                                </td>
                                                <td>{{$data->dokter->nama}}</td>
                                                <td>{{$data->tgl_periksa}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('page-scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush

@push('after-scripts')
    <script>
        $(document).ready( function () {
            $('#table_id').DataTable();
        } );
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/ju/dt-1.10.24/datatables.min.js"></script>
@endpush
