@extends('admin.layouts.master')

@section('title')
    Data Rekam Medis by Tap RFID Card
@endsection

@push('page-styles')
    <style>
        .section-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: top;
            height: 100vh;
            text-align: center;
        }
        .title {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .subtitle {
            font-size: 30px;
            color: #17a2b8; /* Bootstrap info color */
        }
        .header {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 10px;
        }
        .user-info {
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        .user-info i {
            margin-right: 5px;
        }
    </style>
@endpush

@section('content')
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible show text-center fade" style="font-weight: bold">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>x</span>
                </button>
                <div class="container">
                    <div class="col-12">
                        {{ session('error') }}
                    </div>
                </div>
            </div>  
        </div>
    @endif

    <div class="header">
        <div class="title">Data Rekam Medis by Tap RFID Card</div>
    </div>
    <div class="section-body">
        <div class="subtitle">Menunggu Tap Kartu RFID</div>
    </div>
@endsection


@push('page-scripts')
<script>
    $(document).ready(function(){
        //realtime get data from file rfid.blade.php
        @if ($tipe == 'detail')
            setInterval(function() {
                $.ajax({
                async: false,
                cache: false,
                url: `create/rfid/get_rfid`, 
                type: "GET",
                dataType:"text",
                success: function(data) { 
                    location.href = "detail/rfid";
                }
            });

            }, 2000);
        @else
            setInterval(function() {
                $.ajax({
                async: false,
                cache: false,
                url: `create/rfid/get_rfid`, 
                type: "GET",
                dataType:"text",
                success: function(data) { 
                    location.href = "create/rfid";
                }
            });
            }, 2000);
        @endif
    });
</script>
@endpush





