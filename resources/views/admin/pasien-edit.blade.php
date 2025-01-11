@extends('admin.layouts.master')

@section('title')
    Dashboard | Admin
@endsection

@section('header')
    Edit Pasien
@endsection 

@section('content')
<div class="section-body">
    <div class="card">
    <div class="card-body">
    <form action="{{ route('pasien.update', $pasien->id )}}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <div class="row">
        <div class="col-md-12"> 
          <input type="hidden" name="id" value="{{ $pasien->id}}" id="id_update">
          <div class="form-group">
            <label>Nama Pasien 
              @error('nama') <b @error('nama') class="text-danger" @enderror> {{ "(".$message.")" }} </b> @enderror
            </label>
            <input type="text" name="nama" value="{{ $pasien->nama}}" class="form-control">
          </div> 
          <div class="form-group">
            <label>Usia
                @error('usia') <b @error('usia') class="text-danger" @enderror> {{ "(".$message.")" }} </b> @enderror
            </label>
            <input type="text" name="usia" value="{{$pasien->usia}}" class="form-control">
          </div> 
          <div class="form-group">
              <label>No. Handphone 
                @error('no_hp') <b @error('no_hp') class="text-danger" @enderror> {{ "(".$message.")" }} </b> @enderror
              </label>
              <input type="number" name="no_hp" value="{{ $pasien->no_hp}}" class="form-control">
          </div> 
          <div class="form-group">
            <label>Alamat 
              @error('alamat') <b @error('alamat') class="text-danger" @enderror> {{ "(".$message.")" }} </b> @enderror
            </label>
            <input type="text" name="alamat" value="{{ $pasien->alamat}}" class="form-control">
          </div>
          <div class="form-group">
            <label>bidang 
              @error('bidang') <b @error('bidang') class="text-danger" @enderror> {{ "(".$message.")" }} </b> @enderror
            </label>
            <input type="text" name="bidang" value="{{ $pasien->bidang}}" class="form-control">
          </div> 
          <div class="form-group">
            <label>Tanggal Daftar 
              @error('bidang') <b @error('bidang') class="text-danger" @enderror> {{ "(".$message.")" }} </b> @enderror
            </label>
            <input type="date" name="tgl_daftar" value="{{ $pasien->tgl_daftar}}" class="form-control">
          </div> 
            <button type="button" class="btn btn-warning"><a class="text-white" style="text-decoration: none" href="{{ route('pasien.index')}}">Kembali</a></button>
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection



