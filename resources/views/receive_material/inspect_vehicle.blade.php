@extends('adminlte::page')

@section('css')
<style>
    .error{
        color: red;
        font-size: 10pt;
    }
</style>
@endsection
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>
                    {{-- <li class="breadcrumb-item active"> <a href="{{url('/receive/check/material')}}">ตรวจสอบรายการนำเข้าวัตถุดิบ</a> </li> --}}
                    <li class="breadcrumb-item"> <a href="{{url('/material/receive')}}">รับเข้าวัตถุดิบ</a> </li>
                    <li class="breadcrumb-item active">ตรวจสอบรถขนส่ง</li>
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-12">
                <br>
               <!-- <button type="button" class="btn" style="background-color: #D7FFB3;" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</button> -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

@stop
<?php
    $weight = $mat_lot_detail->weight_total;
    $weight_grams = $mat_lot_detail->weight_grams;
    $weight_kg = $mat_lot_detail->weight_kg;
    $weight_ton = $mat_lot_detail->weight_ton;
    $weight_text = "";
    if ($weight >= 1000000) {
        $weight_text = $weight_ton." ตัน ".$weight_kg." กิโลกรัม ".$weight_grams." กรัม ";
    }
    elseif ($weight >= 1000) {
        $weight_text = $weight_kg." กิโลกรัม ".$weight_grams." กรัม ";
    }
    elseif ($weight >= 100) {
        $weight_text = $weight_grams." กรัม ";
    }
?>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header ogn-stock-green">
                <h5 class="card-title">ตรวจสอบรถขนส่ง</h5>
                </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 mb-2">
                                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                                <input type="hidden" name="id" id="id" value="{{$material_lot_id}}">
                                <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
                                <label class="label-control" for="">หมายเลขล็อต</label>
                                <input class="form-control" type="text" name="" id="" value="{{$mat_lot_detail->lot}}" readonly>
                            </div>
                            <div class="col-sm-4 mb-2">
                                <label class="label-control" for="">ชื่อวัตถุดิบ</label>
                                <input class="form-control" type="text" name="" id="" value="{{$mat_lot_detail->receive_mat_name}}" readonly>
                            </div>
                            <div class="col-sm-4 mb-2">
                                <label class="label-control" for="">ปริมาณวัตถุดิบที่รับเข้า</label>
                                <input class="form-control" type="text" name="" id="" value="{{$weight_text}}" readonly>
                            </div>

                        </div>
                        <form id='formcheck'>
                        <div class="row mb-2">
                                <div class="col-12  col-sm-6 mb-2">
                                    <label for="" class="form-label">ทะเบียนรถ</label>
                                    <input type="text" class="form-control" name="sender_vehicle_plate" id="sender_vehicle_plate" value="{{$mat_lot_detail->sender_vehicle_plate}}" required>
                                </div>
                                <div class="col-12  col-sm-6 mb-2 text-center">
                                    <label class="text-center text-dark text-bold pt-0">รายการตรวจสอบ</label>
                                    <table border="0" style="margin: 0 auto;">
                                        <tr>
                                            <th class="text-center" style="width: 30%">ไม่มีสิ่งแปลกปลอม</th>
                                            <th class="text-center" style="width: 30%">ความสะอาด (ผ่าน)</th>
                                            <th class="text-center" style="width: 30%">ไม่มีกลิ่น</th>
                                        </tr>
                                        <tr>
                                            <td class="text-center" style="width: 30%"><input type="checkbox"  name="transport_check_1" id="transport_check_1" value="0" {{$mat_lot_detail->transport_check_1==0?'':'checked'}}></td>
                                            <td class="text-center" style="width: 30%"><input type="checkbox"  name="transport_check_2" id="transport_check_2" value="0" {{$mat_lot_detail->transport_check_2==0?'':'checked'}}></td>
                                            <td class="text-center" style="width: 30%"><input type="checkbox"  name="transport_check_3" id="transport_check_3" value="0" {{$mat_lot_detail->transport_check_3==0?'':'checked'}}></td>
                                        </tr>
                                    </table>
                                </div>
                                {{-- <div class="col-12 mb-2">
                                    <label for="" class="form-label">รายละเอียดเพิ่มเติม</label>
                                    <textarea  class="form-control" name="transport_check_detail" id="transport_check_detail" required>{{$mat_lot_detail->transport_check_detail}}</textarea>
                                </div> --}}
                                <div class="col-12">
                                    <label for="" class="form-label">รูปภาพ</label>
                                    <input type="file" name="TransportPic_name" id="TransportPic_name" class="multifile" multiple>
                                    <p id="file_detail"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="row">
                            <div class="col-12">
                                    <div style="text-align: right;">
                                        <button class="btn-back btn ogn-stock-grey text-black"><em class="fas fa-arrow-left"></em> ย้อนกลับ</button>
                                        <button class="btn-save btn ogn-stock-green text-white"><em class="fas fa-save"></em> บันทึก</button>
                                    </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>


    </div>
</div>
@endsection

@section('js')
   <script>
      $(function(){
        $('.dropify').dropify();
        $('.btn-back').on('click', function() {
            window.history.back();
        });

        $('.btn-save').on('click', function() {
            if($('#transport_check_1').is(':checked')){
                val_transport_check_1 = 1
            }else{
                val_transport_check_1 = 0
            }

            if($('#transport_check_2').is(':checked')){
                val_transport_check_2 = 1
            }
            else{
                val_transport_check_2 = 0
            }

            if($('#transport_check_3').is(':checked')){
                val_transport_check_3 = 1
            }
            else{
                val_transport_check_3 = 0
            }
            if($('#formcheck').valid()){

                var formData = new FormData();
                formData.append('token', $('#_token').val());
                formData.append('id', $('#id').val());
                formData.append('user_id', $('#user_id').val());
                formData.append('sender_vehicle_plate', $('#sender_vehicle_plate').val());
                // formData.append('transport_check_detail', $('#transport_check_detail').val());
                formData.append('transport_check_detail', null);
                formData.append('transport_check_1', val_transport_check_1);
                formData.append('transport_check_2', val_transport_check_2);
                formData.append('transport_check_3', val_transport_check_3);
                var multifile = document.getElementById('TransportPic_name').files

                for (var i = 0, f; f = multifile[i]; i++) {
                    formData.append('file_name[]', multifile[i]);
                }

                Swal.fire({
                    title: 'ยืนยันการตรวจสอบ?',
                    text: "ต้องการดำเนินการใช่หรือไม่!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#649514',
                    cancelButtonColor: '#a97551',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ปิด'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // console.log('aasdasdasd');
                        $.ajax({
                            type: "POST",
                            url: "{{route('api.v1.receive.material.transport.confirm.check')}}",
                            data: formData,
                            contentType: false,
                            processData: false,
                            cache: false,
                            // dataType: "JSON",
                            success: function (response) {
                                if (response) {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'success',
                                        title: 'ตรวจสอบสำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    window.location.assign("{{ route('stock')}}");
                                } else {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'error',
                                        title: 'ตรวจสอบไม่สำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                }
                            }
                        });
                    }
                });
            }
        });

    // function show name of file
        function FileDetails() {
            var fi = $('#TransportPic_name');
            if (fi.files.length > 0) {
                $('#file_detail').innerHTML =
                    'Total Files: <b>' + fi.files.length + '</b></br >';
                for (var i = 0; i <= fi.files.length - 1; i++) {
                    var fname = fi.files.item(i).name;      // THE NAME OF THE FILE.
                    var fsize = fi.files.item(i).size;      // THE SIZE OF THE FILE.
                    $('#file_detail').innerHTML =
                    $('#file_detail').innerHTML + '<br /> ' +
                            fname + ' (<b>' + fsize + '</b> bytes)';
                }
            }
            else {
                alert('Please select a file.')
            }
        }
    });
   </script>
@endsection
