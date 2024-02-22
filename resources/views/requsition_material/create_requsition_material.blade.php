@extends('adminlte::page')

@section('css')
<style>
    .modal-full {
        min-width: 65%;
        margin-left: 80;
    }

    .template_row:first-child {
        display: none;
        margin: 0 auto;
    }
    .mat_hide {
        display: none;
    }
    .error {
        color: red;
    }
</style>
@endsection

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('requsition.material') }}">รายการเบิกวัตถุดิบ</a></li>
                <li class="breadcrumb-item active">เพิ่มรายการเบิกวัตถุดิบ</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form id="form_valid">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3 ">
                    <label for="" class="form-label text-md">รายการวัตถุดิบ</label>
                    <select name="" id="material_id" class="form-control select2" style="height: 40px;">
                        @foreach ( $materials as $material )
                            @if ($material->record_status === 1)
                                <option value="{{$material->id}}" data-name="{{$material->name}}">{{$material->name}} : จำนวน {{ number_format(($material->stockremain / 1000),6) }} kg.</option>
                            @endif
                        @endforeach
                    </select>

                    <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                    <input type="hidden" name="id" id="id" value="">
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                    <label for="" class="form-label">ล็อตวัตถุดิบ : จำนวนคงเหลือ</label>
                    <select name="" id="material_lot_id" class="form-control">

                    </select>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="" class="form-label">จำนวน</label>
                            <input type="number" id="weight" name="weight" class="form-control" required>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label for="type_weight" class="form-label">หน่วยวัด</label>
                            <select name="" id="type_weight" class="form-control">
                                <option value="1">กรัม</option>
                                <option value="2">กิโลกรัม</option>
                                <option value="3">ตัน</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                        <button type="button" class="btn btn-save ogn-stock-green text-white add-to-table2 position-absolute" style=" bottom: 0; right: 8px;"><em class="fas fa-plus-circle"></em>  เพิ่มเข้ารายการเบิก</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header ogn-stock-yellow text-left ">
        <em class="fas fa-file-alt text-gray"></em> ใบเบิกวัตถุดิบ
    </div>
    <div class="card-body">
    <form action="" id="receive_valid">
    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">หมายเลขเอกสาร</label>
            <input type="text" id="paper_no" class="form-control" required>
            <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">

            <small id="checkpaper_no"></small>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">ชื่อสินค้าที่ผลิต</label>
            <input type="text" name="product_name" id="product_name" class="form-control" required>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">วันที่เบิก</label>
            <input type="datetime-local" id="date" name="date" class="form-control" required>
            <small id="checkdate"></small>
        </div>


    </div>
</form>
<hr class="my-4">

<div class="row">

    <div class="col-12">

        <div class="card card-outline card-gdp">
            <div class="card-header" >
                <h6 class="m-0"> รายการวัตถุดิบ </h6>
            </div>

            <div class="card-body p-0">

                <table id="requsition_material" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="">
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">หมายเลขล็อตวัตถุดิบ</th>
                            <th scope="col" class="w-auto">วัตถุดิบ</th>
                            <th scope="col" class="w-auto">น้ำหนัก</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>

        </div>
        <div style="text-align: right;">
            <button class="btn ogn-stock-grey text-black btn-back"><em class="fas fa-arrow-left"></em> ย้อนกลับ</button>
            <button class="btn ogn-stock-green text-white" id="create_receive_material2"><em class="fas fa-save"></em> บันทึก</button>
        </div>
    </div>
</div>

    </div> {{-- cardbody --}}
</div>


<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-full">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #9BC56D;">
                <h5 class="modal-title list_add" id="staticBackdropLabel" style="color: white;">เพิ่มรายการนำเข้า</h5>
                <button type="button" class="close clear-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_valid">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                        <label for="" class="form-label">รายการวัตถุดิบ</label>
                        <select name="" id="material_id" class="form-control">
                            @foreach ( $materials as $material )
                                @if ($material->record_status === 1)

                                <option value="{{$material->id}}">{{$material->name}}</option>

                                @endif
                            @endforeach
                        </select>

                        <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                        <input type="hidden" name="id" id="id" value="">
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                        <label for="" class="form-label">Lot.NO RM : วันหมดอายุ : จำนวนคงเหลือ</label>
                        <select name="" id="material_lot_id" class="form-control">

                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label for="" class="form-label">จำนวน</label>
                                <input type="number" id="weight" name="weight" class="form-control" required>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="" class="form-label">หน่วยวัด</label>
                                <select name=""  id="type_weight" class="form-control">
                                    <option value="1">กรัม</option>
                                    <option value="2">กิโลกรัม</option>
                                    <option value="3">ตัน</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                        <label for="" class="form-label">วันที่เบิก</label>
                        <input type="date" id="date_requsition" name="date_requsition" class="form-control" value="0" required>
                        <small id="checktons"></small>
                    </div>

                </div>
                </form>
            </div>
            <div class="modal-footer" style="margin-top: 10px;;">
                <button type="button" class="btn clear-modal ogn-stock-grey " style="color:black;" data-dismiss="modal"><em class="fas fa-close"></em> ยกเลิก</button>
                <button type="button" class="btn btn-save ogn-stock-green text-white add-to-table2" style=" color:black;"><em class="fas fa-save"></em> เพิ่ม</button>

            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(function() {

        $('.select2').select2()

        $('#material_id').on('change',function () {

            var material_id = $('#material_id').val()

            $.ajax({
                type: "post",
                url: "{{route('api.v1.requsition.list.material.lot')}}",
                data: {'material_id': material_id },
                dataType: "json",
                success: function (response) {
                    console.log(response)
                    $('#material_lot_id').find('option').remove().end()
                        response.material_lots.forEach(element => {
                            total_weight = parseFloat(element.lotremain / 1000);
                            let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB',minimumFractionDigits: 6  });
                            let total = formatter.format(total_weight);
                            $('#material_lot_id').append(`<option value="${element.id}" data-name="${element.lot_no_pm}">  ${element.lot_no_pm} : EXP ${element.exp} : จำนวน <span class="total">${total}</span> kg.</option>`);
                        });
                }
            });

         });
    var material = []

        $('.dropify').dropify();
        let requsition_material = $('#requsition_material').DataTable({
            "pageLength": 100,
            "responsive": true,
            "paging": false,
            "ordering": false,
            "info": false,
            columnDefs: [
                // { responsivePriority: 1, targets: 4 },
                {
                    orderable: false,
                    responsivePriority: 7,
                    targets: [2,3]

                }
            ],
            "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">'
        });


        function check_duplicate_numberlot(){
            var lot= $('#material_lot_id').val();
            var status = true;
            if (lot != "" || null) {
                $('.materialrow').each(function(index,value){
                    if ( lot == $(value).find('.mat_lot_id').text()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'ล็อตซ้ำ',
                            text: 'กรุณากรอกล็อตใหม่!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        status = false;
                    }
                })
            }
            return status;
        }

        $('.add-to-table2').on('click', function(){

            if ($('#form_valid').valid() && check_duplicate_numberlot()) {
                weight_stock = $('#material_lot_id option:selected').find('.total').text()
                weight_stock = weight_stock.replace(/\,/g,'');
            var    material_id= $('#material_id').val();
            var    material_name= $('#material_id option:selected').data('name');
            var    material_lot_name= $('#material_lot_id option:selected').data('name');

            var    material_lot_id= $('#material_lot_id').val();
            var    weight= $('#weight').val();
            var    type_weight = $('#type_weight').val()
            // console.log(type_weight)
            var    date= $('#date_requsition').val();
            var total_weight = 0 ;
            var text_weight = "";
                if (type_weight === "1") {
                    total_weight = weight
                    text_weight = "กรัม";
                } else if (type_weight === "2"){
                    total_weight = weight * 1000 ;
                    text_weight = "กิโลกรัม";
                } else {
                    total_weight = weight * 1000000 ;
                    text_weight = "ตัน";
                }
                console.log('stock:',parseFloat(weight_stock * 1000),'add:',parseFloat(total_weight))
                if (parseFloat(total_weight) > parseFloat(weight_stock * 1000)) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: 'เบิกเกินจำนวนที่มีอยู่ในคลัง!',
                        text: "กรุณากรอกจำนวนใหม่อีกครั้ง!",
                        showConfirmButton: false,
                        timer: 3000
                    })
                } else {
                    // $('#material_lot_id option:selected').remove()
                var index = requsition_material.rows().count();
                var row = requsition_material.row.add([
                    '<td><a class="list_cancel"><i class="fas fa-times text-red"></i></a></td>',
                    '<td><span class="mat_lot_id mat_hide ">'+material_lot_id +'</span>'+material_lot_name+'</span></td>',
                    '<td><span class="mat_id mat_hide ">'+material_id  +'</span>'+material_name+'</td>',
                    '<td><span class="mat_weight mat_hide ">'+total_weight +'</span>'+weight+' '+text_weight+' </td>',

                ]).draw(false).nodes()
                .to$()
                .addClass( 'materialrow' )

                }
            $(".clear-modal").click();
            }

        })

        $(".clear-modal").on('click', function() {
            $(".dropify-clear").click();

            $('#material_name').val(""),
                $('#company_name').val(""),

                $('#lot').val(""),
                $('#tons').val("0"),
                $('#kg').val("0"),
                $('#grams').val("0"),
                $('#exp').val(""),
                $('#mfg').val(""),


                $("#myModal").modal("hide");
        });

        $('#requsition_material tbody').on('click', '.list_cancel', function() {
            var index = requsition_material.row($(this).parents('tr'));
            var rowindex = index.index();
            requsition_material
                .row($(this).parents('tr'))
                .remove()
                .draw();
            material.splice(rowindex, 1);

        });
        $('#create_receive_material2').on('click', function() {

            if ($('#receive_valid').valid()) {

            var formdata_receive = new FormData();
            // formdata_receive.append('username', 'Chris');
            formdata_receive.append('paper_no', $('#paper_no').val());
            formdata_receive.append('product_name', $('#product_name').val());
            formdata_receive.append('edit_times', $('#edit_times').val());
            formdata_receive.append('date', $('#date').val());
            formdata_receive.append('_token', $('#_token').val());
            formdata_receive.append('id', $('#id').val());
            formdata_receive.append('user_id', $('#user_id').val());
            formdata_receive.append('company_id', {{session('company')}});

            $('.materialrow').each(function(index,value){
                formdata_receive.append('material['+index+'][material_lot_id]',$(value).find('.mat_lot_id').text())
                formdata_receive.append('material['+index+'][material_id]',$(value).find('.mat_id').text())
                formdata_receive.append('material['+index+'][weight]',$(value).find('.mat_weight').text())
                formdata_receive.append('material['+index+'][date]',$(value).find('.mat_date').text())
            })
            var rows_material = requsition_material.rows().count();
            // console.log(index)
                if (rows_material > 0) {
                    Swal.fire({
                                title: 'ยืนยันการเบิกวัตถุดิบ?',
                                text: "ต้องการดำเนินการใช่หรือไม่!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#649514',
                                cancelButtonColor: '#a97551',
                                confirmButtonText: 'ยืนยัน',
                                cancelButtonText: 'ปิด'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        type: "post",
                                        url: "{{route('api.v1.requsition.material.create')}}",
                                        data: formdata_receive,
                                        contentType: false,
                                        processData: false,
                                        cache: false,
                                        // dataType: "dataType",
                                        success: function (response) {
                                            if (response) {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'success',
                                                    title: 'เพิ่มรายการนำเข้าสำเร็จ',
                                                    showConfirmButton: false,
                                                    timer: 1500,

                                                })
                                                window.location.assign("{{ route('requsition.material') }}")
                                            } else {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'warning',
                                                    title: 'เพิ่มรายการนำเข้าไม่สำเร็จ',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                })
                                            }
                                        }
                                    });
                                }
                            });
                } else {
                    Swal.fire({
                                position: 'center-center',
                                icon: 'warning',
                                title: 'กรุณาเพิ่มรายการเบิกวัตถุดิบ',
                                showConfirmButton: false,
                                timer: 1500
                            })
                }

            }

        })
        $('.btn-back').on('click',function(){
            window.history.back();
        });

    });

    $(document).ready(function(){
        var material_id = $('#material_id').val()
        var material_lot = [];
        var material_cut = [];
        var material_in_stock = [];
        var total_material_instock = [];
        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.list.material.lot')}}",
            data: {'material_id': material_id },
            dataType: "json",
            success: function (response) {
                material_lot = response
                // check_stock_material()
                $('#material_lot_id').find('option').remove().end()
                    response.material_lots.forEach(element => {
                        total_weight = parseFloat(element.lotremain / 1000);
                        let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                        let total = formatter.format(total_weight);
                        $('#material_lot_id').append(`<option value="${element.id}" data-name="${element.lot_no_pm}">  ${element.lot_no_pm} : EXP ${element.exp} : จำนวน <span class="total">${total}</span> kg.</option>`);
                    });
            }
        });




    })
</script>
@endsection
