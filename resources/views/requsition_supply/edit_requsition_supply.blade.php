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
    .sup_hide {
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
                <li class="breadcrumb-item active"><a href="{{ route('list.requsition.supply') }}">รายการเบิกวัสดุสิ้นเปลือง</a></li>
                <li class="breadcrumb-item active">แก้ไขรายการเบิกวัสดุสิ้นเปลือง</li>
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
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                    <label for="" class="form-label text-md">รายการวัสดุสิ้นเปลือง</label>
                    <select name="" id="supply_id" class="form-control select2">
                        @foreach ( $supplies as $supply )
                            @if ($supply->record_status === 1)
                                <option value="{{$supply->id}}">{{$supply->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                </div>
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 ">
                    <label for="" class="form-label">ล็อตวัสดุสิ้นเปลือง : จำนวนคงเหลือ</label>
                    <select name="" id="supply_lot_id" class="form-control select2">
                    </select>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 ">
                    <label for="" class="form-label">จำนวน</label>
                    <input type="number" id="qty" name="qty" class="form-control" required>
                </div>
                <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 ">
                        <button type="button" class="btn btn-save ogn-stock-green text-white add-to-table position-absolute" style=" bottom: 0; right: 8px;"><em class="fas fa-plus-circle"></em>  เพิ่มเข้ารายการเบิก</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header ogn-stock-green ">
        แก้ไขรายการเบิกวัสดุสิ้นเปลือง
    </div>
    <div class="card-body">
        <form action="" id="receive_valid">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                <label for="" class="form-label">หมายเลขเอกสาร</label>
                <input type="text" id="paper_no" class="form-control" value="{{$requsition_supply->paper_no}}" required readonly>
                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                <input type="hidden" name="id" id="id" value="{{$requsition_supply_id}}">
                <input type="hidden" name="edit_times" id="edit_times" value="{{$requsition_supply->edit_times}}">
                <input type="hidden" name="history_flag" id="history_flag" value="{{$requsition_supply->history_flag}}">
                <input type="hidden" name="created_by" id="created_by" value="{{$requsition_supply->created_by}}">
                <input type="hidden" name="updated_by" id="updated_by" value="{{$requsition_supply->updated_by}}">
                <input type="hidden" name="production_user_id" id="production_user_id" value="{{$requsition_supply->production_user_id}}">
                <input type="hidden" name="procurement_user_id" id="procurement_user_id" value="{{$requsition_supply->procurement_user_id}}">
                <input type="hidden" name="stock_user_id" id="stock_user_id" value="{{$requsition_supply->stock_user_id}}">
                <input type="hidden" name="recap_old" id="recap_old" value="{{$requsition_supply->recap}}">
                <input type="hidden" name="detail" id="detail" value="{{$requsition_supply->detail}}">
                <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                <label for="" class="form-label">วันที่เบิก</label>
                <input type="text" id="date" name="date" value="{{$requsition_supply->date}}" class="form-control" required readonly>
                <small id="checkdate"></small>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                <label for="" class="form-label">รายละเอียดการเบิก</label>
                <input type="text" name="detail" id="detail" class="form-control" value="{{$requsition_supply->detail}}" required readonly>
            </div>
            <div class="col-12 mt-2">
                <label for="" class="form-label">หมายเหตุ</label>
                <input type="text" name="recap" id="recap" class="form-control" value="" required >
            </div>
        </div>
        </form>
        <hr class="my-4">

        <div class="row">

            <div class="col-12">

                <div class="card card-outline card-gdp">
                    <div class="card-header ">
                            <h6 class="m-0"> รายการวัสดุสิ้นเปลือง </h6>
                        </div>

                    <div class="card-body p-0">

                        <table id="requsition_supply" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                            <caption style="display: none"></caption>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="w-auto">#</th>
                                    <th scope="col" class="w-auto">ล็อต</th>
                                    <th scope="col" class="w-auto">รายการวัสดุสิ้นเปลือง</th>
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
                    <button class="btn ogn-stock-green text-white" id="create_receive_supply"><em class="fas fa-save"></em> บันทึก</button>
                </div>
            </div>
        </div>
    </div> {{-- cardbody --}}
</div>

@endsection

@section('js')
<script>
    $(function() {
        $('.select2').select2()

        let id = $('#id').val()
        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.supply.cut.lot')}}",
            data: {"id":id},
            dataType: "json",
            success: function (response) {
                var row = '';
                dataOld = response;
                response.forEach(element => {
                    row +=
                `<tr class="supplyrowold">
                    <td><a class="list_cancel"><i class="fas fa-times text-danger"></i></a></td>
                    <td><span class="sup_lot_id sup_hide ">${element.supply_lot.id}</span>${element.supply_lot.lot}</span></td>
                    <td><span class="sup_id sup_hide ">${element.supply_lot.supply.id}</span>${element.supply_lot.supply.name}</td>
                    <td><span class="sup_qty">${element.qty}</span> ชิ้น</td>
                </tr>`

                });

                $('#rowbody').html(row);

                requsition_supply = $('#requsition_supply').DataTable({
                    "paging": false,
                    "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">',
                    "info": false,
                    "pageLength": 100,
                });

            }
        });

        $('#supply_id').on('change',function () {

            var supply_id = $('#supply_id').val()


            $.ajax({
                type: "post",
                url: "{{route('api.v1.requsition.list.supply.lot')}}",
                data: {'supply_id': supply_id },
                dataType: "json",
                success: function (response) {
                    var qtytotal;
                        response.supply_lots.forEach(element => {

                            $('#supply_lot_id').append('<option value=' + element
                                .id + '>' + element.lot + ' : จำนวน ' + '<span class="total">'+element.qty+'</span>' + ' ชิ้น' + '</option>');

                                $('.supplyrow').each(function(index,value){
                                    if($(value).find('.sup_lot_id').text() == element.id){
                                        $('#supply_lot_id option:selected').remove()
                                    }
                                });
                                $('.supplyrowold').each(function(index,value){
                                    if($(value).find('.sup_lot_id').text() == element.id){
                                        $('#supply_lot_id option:selected').remove()
                                    }
                                });
                        });
                }
            });

         });
    var supply = []

        $('.dropify').dropify();

        $('.add-to-table').on('click', function(){

            if ($('#form_valid').valid()) {
                qty_stock = $('#supply_lot_id option:selected').find('.total').text()
                qty_stock = qty_stock.replace(/\,/g,'');
                var supply_id= $('#supply_id').val();
                var supply_name= $('#supply_id option:selected').text();
                var supply_lot_name= $('#supply_lot_id option:selected').text();
                    supply_lot_name = supply_lot_name.substring(0, supply_lot_name.indexOf(':'))
                var supply_lot_id= $('#supply_lot_id').val();
                var qty= $('#qty').val();


                if (parseFloat(qty) > parseFloat(qty_stock)) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: 'เบิกเกินจำนวนที่มีอยู่ในคลัง!',
                        text: "กรุณากรอกจำนวนใหม่อีกครั้ง!",
                        showConfirmButton: false,
                        timer: 3000
                    })
                } else {
                    $('#supply_lot_id option:selected').remove()

                    var index = requsition_supply.rows().count();

                    var row = requsition_supply.row.add([
                        '<td><a class="list_cancel"><i class="fas fa-times text-red"></i></a></td>',
                        '<td><span class="sup_lot_id sup_hide ">'+supply_lot_id +'</span>'+supply_lot_name+'</span></td>',
                        '<td><span class="sup_id sup_hide ">'+supply_id  +'</span>'+supply_name+'</td>',
                        '<td><span class="sup_qty ">'+qty+'</span> ชิ้น </td>',

                    ]).draw(false).nodes()
                    .to$()
                    .addClass( 'supplyrow' )
                }
            }
        })



        $('#requsition_supply tbody').on('click', '.list_cancel', function() {
            var index = requsition_supply.row($(this).parents('tr'));
            var rowindex = index.index();
            requsition_supply
                .row($(this).parents('tr'))
                .remove()
                .draw();
            supply.splice(rowindex, 1);

        });
        $('#create_receive_supply').on('click', function() {

            if ($('#receive_valid').valid()) {
            var numrow = 0;
            var numrowold = 0;
            var formdata_receive = new FormData();
            formdata_receive.append('paper_no', $('#paper_no').val());
            formdata_receive.append('edit_times', $('#edit_times').val());
            formdata_receive.append('date', $('#date').val());
            formdata_receive.append('_token', $('#_token').val());
            formdata_receive.append('id', $('#id').val());
            formdata_receive.append('history_flag', $('#history_flag').val());
            formdata_receive.append('created_by', $('#created_by').val());
            formdata_receive.append('updated_by', $('#updated_by').val());
            formdata_receive.append('stock_user_id', $('#stock_user_id').val());
            formdata_receive.append('recap', $('#recap').val());
            formdata_receive.append('recap_old', $('#recap_old').val());
            formdata_receive.append('detail', $('#detail').val());
            formdata_receive.append('user_id', $('#user_id').val());
            formdata_receive.append('company_id', {{session('company')}});

            $('.supplyrowold').each(function(index,value){
                formdata_receive.append('supplyold['+index+'][supply_lot_id]',$(value).find('.sup_lot_id').text())
                formdata_receive.append('supplyold['+index+'][supply_id]',$(value).find('.sup_id').text())
                formdata_receive.append('supplyold['+index+'][qty]',$(value).find('.sup_qty').text())
                numrowold++
            })
            $('.supplyrow').each(function(index,value){
                formdata_receive.append('supply['+index+'][supply_lot_id]',$(value).find('.sup_lot_id').text())
                formdata_receive.append('supply['+index+'][supply_id]',$(value).find('.sup_id').text())
                formdata_receive.append('supply['+index+'][qty]',$(value).find('.sup_qty').text())
                numrow++
            })

            formdata_receive.append('lengthsupply',numrow)
            formdata_receive.append('lengthsupplyOld',numrowold)
            formdata_receive.append('supplyOld',JSON.stringify(dataOld))
            var rows_supply = requsition_supply.rows().count();
            // console.log(index)
                if (rows_supply > 0) {
                    Swal.fire({
                                title: 'ยืนยันการเบิกวัสดุสิ้นเปลือง?',
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
                                        url: "{{route('api.v1.requsition.supply.edit')}}",
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
                                                window.location.assign("{{ route('list.history.requsition.supply') }}")
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
                                title: 'กรุณาเพิ่มรายการเบิกวัสดุสิ้นเปลือง',
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
        var supply_id = $('#supply_id').val()

        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.list.supply.lot')}}",
            data: {'supply_id': supply_id },
            dataType: "json",
            success: function (response) {
                console.log(response)
                var qtytotal;
                    response.supply_lots.forEach(element => {
                        $('#supply_lot_id').append('<option value=' + element
                            .id + '>' + element.lot + ' : จำนวน ' + '<span class="total">'+element.qty+'</span>' + ' ชิ้น' + '</option>');

                        $('.supplyrow').each(function(index,value){
                            if($(value).find('.sup_lot_id').text() == element.id){
                                $('#supply_lot_id option:selected').remove()
                            }
                        });
                        $('.supplyrowold').each(function(index,value){
                            if($(value).find('.sup_lot_id').text() == element.id){
                                $('#supply_lot_id option:selected').remove()
                            }
                        });

                    });
            }
        });


    })
</script>
@endsection
