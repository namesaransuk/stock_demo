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
                <li class="breadcrumb-item active"><a href="{{ route('requsition.packaging') }}">รายการเบิกบรรจุภัณฑ์</a></li>
                <li class="breadcrumb-item active">แก้ไขรายการเบิกบรรจุภัณฑ์</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form id="form_valid">
                    <!-- <div class="container"> -->
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                            <label for="" class="form-label text-md">รายการบรรจุภัณฑ์</label>
                            <select name="" id="packaging_id" class="form-control">
                                @foreach ( $packagings as $packaging )
                                    @if ($packaging->record_status === 1)
                                        <option value="{{$packaging->id}}" data-name="{{$packaging->name}}">{{$packaging->name}} : จำนวน {{ number_format($packaging->stockremain) }} ชิ้น</option>
                                    @endif
                                @endforeach
                            </select>

                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                            <label for="" class="form-label">ล็อตบรรจุภัณฑ์ : จำนวนคงเหลือ</label>
                            <select name="" id="packaging_lot_id" class="form-control">

                            </select>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                    <label for="" class="form-label">จำนวนชิ้น</label>
                                    <input type="number" id="qty" name="qty" class="form-control" required>
                        </div>
                    </div>
        </form>
        </div>
    <div class="card-footer text-right">
        <button class="btn ogn-stock-green text-white add-to-table2" id="add-to-table2"><em class="fas fa-plus-circle"></em> เพิ่มรายการเบิก</button>

    </div>
</div>
<div class="card">
    <div class="card-header ogn-stock-yellow text-left ">
    <em class="fas fa-file-alt text-gray"></em> ใบเบิกบรรจุภัณฑ์
    </div>
    <div class="card-body">
    <form action="" id="receive_valid">
    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">หมายเลขเอกสาร</label>
            <input type="text" id="paper_no" class="form-control" value="{{$requsition_packaging->paper_no}}" required readonly>
            <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
            <input type="hidden" name="id" id="id" value="{{$requsition_packaging_id}}">
            <input type="hidden" name="edit_times" id="edit_times" value="{{$requsition_packaging->edit_times}}">
            <input type="hidden" name="paper_status" id="paper_status" value="{{$requsition_packaging->paper_status}}">
            <input type="hidden" name="created_by" id="created_by" value="{{$requsition_packaging->created_by}}">
            <input type="hidden" name="updated_by" id="updated_by" value="{{$requsition_packaging->updated_by}}">
            <input type="hidden" name="production_user_id" id="production_user_id" value="{{$requsition_packaging->production_user_id}}">
            <input type="hidden" name="procurement_user_id" id="procurement_user_id" value="{{$requsition_packaging->procurement_user_id}}">
            <input type="hidden" name="stock_user_id" id="stock_user_id" value="{{$requsition_packaging->stock_user_id}}">
            <input type="hidden" name="recap_old" id="recap_old" value="{{$requsition_packaging->recap}}">
            <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">

            <small id="checkpaper_no"></small>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">ชื่อสินค้าที่ผลิต</label>
            <input type="text" name="product_name" id="product_name" class="form-control" value="{{$requsition_packaging->product_name}}" required readonly>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">วันที่เบิก</label>
            <input type="text" id="date" name="date" value="{{$requsition_packaging->date}}" class="form-control" required readonly>
            <small id="checkdate"></small>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">หมายเหตุ</label>
            <input type="text" id="recap" name="recap"  class="form-control" required >
            <small id="checkdate"></small>
        </div>

    </div>
</form>
<hr class="my-4">

<div class="row">

    <div class="col-12">

        <div class="card card-outline card-gdp">
            <div class="card-header  " >
                    <h6 class="m-0"> รายการบรรจุภัณฑ์ </h6>
                </div>

            <div class="card-body p-0">

                <table id="requsition_packaging_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="">
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">หมายเลขล็อตบรรจุภัณฑ์</th>
                            <th scope="col" class="w-auto">บรรจุภัณฑ์</th>
                            <th scope="col" class="w-auto">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody id="rowbody">
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




@endsection

@section('js')
<script>
    $(function() {
        let id = $('#id').val()
        //loadData
        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.packaging.cut.lot')}}",
            data: {"id":id},
            dataType: "json",
            success: function (response) {
                var row = '';
                dataOld = response;
                response.forEach(element => {
                    var qty = parseFloat(element.qty)  ;
                    row +=
                `<tr class="packagingrowold list_packaging">
                    <td><a class="list_cancel"><i class="fas fa-times text-red"></i></a></td>
                    <td><span class="pack_lot_id mat_hide ">${element.packaging_lot.id}</span>${element.packaging_lot.lot_no_pm}</span></td>
                    <td><span class="pack_id mat_hide ">${element.packaging_lot.packaging.id}</span>${element.packaging_lot.packaging.name}</td>
                    <td><span class="pack_qty  ">${qty}</span> ชิ้น</td>
                </tr>`

                });

                $('#rowbody').html(row);

                requsition_packaging_table = $('#requsition_packaging_table').DataTable({
                    "paging": false,
                    "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">',
                    "info": false,
                    "pageLength": 100,
                });

            }
        });


        $('#packaging_id').on('change',function () {
        var packaging_id = $('#packaging_id').val()
            $.ajax({
                type: "post",
                url: "{{route('api.v1.requsition.list.packaging.lot')}}",
                data: {'packaging_id': packaging_id },
                dataType: "json",
                success: function (response) {
                    console.log(response)
                    $('#packaging_lot_id').find('option').remove().end()
                        response.packaging_lots.forEach(element => {
                            total_qty = parseFloat(element.lotremain);
                            let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                            let total = formatter.format(total_qty);
                            $('#packaging_lot_id').append(`<option value="${element.id}" data-name="${element.lot_no_pm}">
                                ${element.lot_no_pm} : EXP ${element.exp} : จำนวน <span class="total">${total}</span> ชิ้น</option>`);
                        });
                }
            });

        });
    var material = []

        $('.dropify').dropify();

        function check_duplicate_numberlot(){
            var lot= $('#packaging_lot_id').val();
            var status = true;
            if (lot != "" || null) {
                $('.list_packaging').each(function(index,value){
                    if ( lot == $(value).find('.pack_lot_id').text()) {
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
                qty_stock = $('#packaging_lot_id option:selected').find('.total').text().replace(/\,/g,'');
            var    packaging_id= $('#packaging_id').val();
            var    packaging_name= $('#packaging_id option:selected').data('name');
            var    packaging_lot_name= $('#packaging_lot_id option:selected').data('name');
            var    packaging_lot_id= $('#packaging_lot_id').val();
            var    qty= $('#qty').val();
            var    type_qty = $('#type_qty').val()

            if (parseFloat(qty) > parseFloat(qty_stock)) {
                Swal.fire({
                    position: 'center-center',
                    icon: 'warning',
                    title: 'เบิกเกินจำนวนที่มีอยู่ในคลัง!',
                    text: "กรุณากรอกจำนวนใหม่อีกครั้ง!",
                    showConfirmButton: false,
                    timer: 3000
                })
            }else{
                var index = requsition_packaging_table.rows().count();
                var row = requsition_packaging_table.row.add([
                '<td><a class="list_cancel"><i class="fas fa-times text-red"></i></a></td>',
                '<td><span class="pack_lot_id mat_hide ">'+packaging_lot_id +'</span>'+packaging_lot_name+'</span></td>',
                '<td><span class="pack_id mat_hide ">'+packaging_id  +'</span>'+packaging_name+'</td>',
                '<td><span class="pack_qty  ">'+qty +'</span> </td>',
                ]).draw(false).nodes()
                .to$()
                .addClass( 'packagingrow list_packaging' )
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

        $('#requsition_packaging_table tbody').on('click', '.list_cancel', function() {
            var index = requsition_packaging_table.row($(this).parents('tr'));
            var rowindex = index.index();
            requsition_packaging_table
                .row($(this).parents('tr'))
                .remove()
                .draw();
            material.splice(rowindex, 1);

        });
        $('#create_receive_material2').on('click', function() {

            if ($('#receive_valid').valid()) {
            var numrow = 0;
            var numrowold = 0;
            var formdata_receive = new FormData();
            // formdata_receive.append('username', 'Chris');
            formdata_receive.append('paper_no', $('#paper_no').val());
            formdata_receive.append('product_name', $('#product_name').val());
            formdata_receive.append('edit_times', $('#edit_times').val());
            formdata_receive.append('date', $('#date').val());
            formdata_receive.append('_token', $('#_token').val());
            formdata_receive.append('id', $('#id').val());
            formdata_receive.append('paper_status', $('#paper_status').val());
            formdata_receive.append('created_by', $('#created_by').val());
            formdata_receive.append('updated_by', $('#updated_by').val());
            formdata_receive.append('production_user_id', $('#production_user_id').val());
            formdata_receive.append('procurement_user_id', $('#procurement_user_id').val());
            formdata_receive.append('stock_user_id', $('#stock_user_id').val());
            formdata_receive.append('recap_old', $('#recap_old').val());
            formdata_receive.append('recap', $('#recap').val());
            formdata_receive.append('user_id', $('#user_id').val());
            formdata_receive.append('company_id', {{session('company')}});


            $('.packagingrowold').each(function(index,value){
                formdata_receive.append('packagingold['+index+'][packaging_lot_id]',$(value).find('.pack_lot_id').text())
                formdata_receive.append('packagingold['+index+'][packaging_id]',$(value).find('.pack_id').text())
                formdata_receive.append('packagingold['+index+'][qty]',$(value).find('.pack_qty').text())
                formdata_receive.append('packagingold['+index+'][date]',$(value).find('.pack_date').text())
                numrowold++
            })
            $('.packagingrow').each(function(index,value){
                formdata_receive.append('packaging['+index+'][packaging_lot_id]',$(value).find('.pack_lot_id').text())
                formdata_receive.append('packaging['+index+'][packaging_id]',$(value).find('.pack_id').text())
                formdata_receive.append('packaging['+index+'][qty]',$(value).find('.pack_qty').text())
                formdata_receive.append('packaging['+index+'][date]',$(value).find('.pack_date').text())
                numrow++
            })

            formdata_receive.append('lengthpackaging',numrow)
            formdata_receive.append('lengthpackagingOld',numrowold)
            formdata_receive.append('packagingOld',JSON.stringify(dataOld))
            var rows_material = requsition_packaging_table.rows().count();
            // console.log(index)
                if (rows_material > 0) {
                    Swal.fire({
                                title: 'ยืนยันการเบิกบรรจุภัณฑ์?',
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
                                        url: "{{route('api.v1.requsition.packaging.edit')}}",
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
                                                window.location.assign("{{ route('requsition.packaging') }}")
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
                                title: 'กรุณาเพิ่มรายการเบิกบรรจุภัณฑ์',
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
        var packaging_id = $('#packaging_id').val()

        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.list.packaging.lot')}}",
            data: {'packaging_id': packaging_id },
            dataType: "json",
            success: function (response) {
                console.log(response)
                $('#packaging_lot_id').find('option').remove().end()
                    response.packaging_lots.forEach(element => {
                        total_qty = parseFloat(element.lotremain);
                        let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                        let total = formatter.format(total_qty);
                        $('#packaging_lot_id').append(`<option value="${element.id}" data-name="${element.lot_no_pm}">
                                ${element.lot_no_pm} : EXP ${element.exp} : จำนวน <span class="total">${total}</span> ชิ้น</option>`);
                    });
            }
        });
    })
</script>
@endsection
