@extends('admin.layouts.master')

@section('title')
    Dashboard | Admin
@endsection

@section('header')
    Edit Kartu Pasien
@endsection 

@section('content')
<div class="section-body">
    <div class="card">
    <div class="card-body">
    <form action="{{ route('kartu.update', $kartu->id )}}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <div class="row">
        <div class="col-md-12"> 
            <input type="hidden" name="id" value="{{ $kartu->id}}" id="id_update">
            <div class="form-group">
                <label>Pasien 
                    @error('pasien_id') <b @error('pasien_id') class="text-danger" @enderror> {{ "(".$message.")" }} </b> @enderror
                  </label>
                <select name="pasien_id" class="form-control">
                  <option value="" hidden>Pilih Pasien !</option>
                  @foreach ($pasien as $data_pasien)
                    <option value="{{ $data_pasien->id }}" {{ $kartu->pasien->id ==  $data_pasien->id ? 'selected' : '' }}>{{  $data_pasien->nama }}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Kode Kartu 
                    @error('kode_kartu') <b @error('kode_kartu') class="text-danger" @enderror> {{ "(".$message.")" }} </b> @enderror
                </label>
                <input type="text" id="getUID" value="{{$kartu->kode_kartu}}" name="kode_kartu"  class="form-control" readonly>
            </div> 
        
            <button type="button" class="btn btn-warning"><a class="text-white" style="text-decoration: none" href="{{ route('kartu.index')}}">Kembali</a></button>
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@push('page-scripts')
<script>
   $(document).ready(function(){
    setInterval(function() {
        $.ajax({
            url: 'rfid/get_rfid', 
            type: "GET",
            dataType: "json",
            success: function(response) {
                console.log('rfid', response.rfid);
                $("#getUID").val(response.rfid);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', status, error);
            }
        });
    }, 500);
});
</script>
@endpush



