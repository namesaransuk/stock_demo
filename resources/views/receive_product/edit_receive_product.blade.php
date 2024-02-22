@extends('adminlte::page')

@section('css')
<style>
    .modal-full {
        min-width: 70%;
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
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('receive.product') }}">รับเข้าสินค้า</a></li>
                <li class="breadcrumb-item active">แก้ไขรายการนำเข้า</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="card">
    <div class="card-header ogn-stock-green ">
        แก้ไขรายการนำเข้าสินค้า
    </div>
    <div class="card-body">
    <form action="" id="receive_valid">
    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">หมายเลขเอกสาร</label>
            <input type="text" id="paper_no" class="form-control" value="{{$receiveproduct->paper_no}}" required readonly>
            <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
            <input type="hidden" name="id" id="id" value="{{$product_lot_id}}">
            <input type="hidden" name="edit_times" id="edit_times" value="{{$receiveproduct->edit_times}}">
            <input type="hidden" name="history_flag" id="history_flag" value="{{$receiveproduct->history_flag}}">
            <input type="hidden" name="recapold" id="recapold" value="{{$receiveproduct->recap}}">
            <input type="hidden" name="production_user_id" id="production_user_id" value="{{$receiveproduct->production_user_id}}">
            <input type="hidden" name="created_at" id="created_at" value="{{$receiveproduct->created_at}}">
            <input type="hidden" name="created_by" id="created_by" value="{{$receiveproduct->created_by}}">
            <input type="hidden" name="stock_user_id" id="stock_user_id" value="{{$receiveproduct->stock_user_id}}">
            <input type="hidden" name="updated_at" id="updated_at" value="{{$receiveproduct->updated_at}}">
            <input type="hidden" name="updated_by" id="updated_by" value="{{$receiveproduct->updated_by}}">
            <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
            <small id="checkpaper_no"></small>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">วันที่นำเข้า (ค.ศ.)</label>
            <input type="text" id="date" value="{{$receiveproduct->date}}" class="form-control" readonly>
            <small id="checkdate"></small>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">หมายเหตุ</label>
            <input type="text" id="recap" class="form-control" required>
            <small id="checkdate"></small>
        </div>
    </div>
</form>
<hr class="my-4">

<div class="row">

    <div class="col-12">

        <div class="card card-outline card-gdp">
            <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                    <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> แก้ไขรายการรับเข้าสินค้า </h6>
                </div>
            <div class="p-2">
                    <div class="float-right">
                        <input type="search" id="custom-search-input" class="form-control form-control-sm"
                               placeholder="ค้นหา">
                    </div>
                    <a href="" type="button" style="" data-toggle="modal" data-target="#myModal"
                       class="btn rounded ml-2"><em class="fas fa-plus-circle text-success"></em>
                        เพิ่มรายการ</a>
                    <div class="card-title mb-0"></div>
                </div>
            <div class="card-body p-0">

                <table id="receive_product_table" class="table w-100 receive_product_table " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="">
                        <tr>
                        <th scope="col" class="w-auto">#</th>
                        <th scope="col" class="w-auto">หมายเลขล็อต</th>
                        <th scope="col" class="w-auto">บริษัท</th>
                        <th scope="col" class="w-auto">ชื่อสินค้า</th>
                        <th scope="col" class="w-auto">หน่วยนับ</th>
                        <th scope="col" class="w-auto">จำนวน</th>
                        <th scope="col" class="w-auto">MFG.</th>
                        <th scope="col" class="w-auto">EXP.</th>
                        <th scope="col" class="w-auto">หมายเหตุ</th>

                        </tr>
                    </thead>
                    <tbody id="rowbody">

                    </tbody>
                </table>

            </div>

        </div>
        <div style="text-align: right;">
            <button class="btn ogn-stock-grey text-black btn-back"><em class="fas fa-arrow-left"></em> ย้อนกลับ</button>
            <button class="btn ogn-stock-green text-white" id="create_receive_packaging"><em class="fas fa-save"></em> บันทึก</button>
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
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3 ">
                            <label for="" class="form-label">ชื่อสินค้า</label>
                            <select name="" id="product_id" class="form-control select2">
                                @foreach ( $products as $product )
                                    @if ($product->record_status == 1)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3 ">
                            <label for="" class="form-label">หมายเลขล็อตสินค้า</label>
                            <input type="text" id="lot" name="lot" class="form-control" required>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3 ">
                            <label for="" class="form-label">บริษัท</label>
                            @php
                                $current_company = session('company')?:'';
                            @endphp
                            <select name="" id="company_id" class="form-control select2" disabled>
                                @foreach ( $companys as $company )
                                    <option {{$current_company==$company->id?'selected':''}} value="{{$company->id}}">{{$company->name_th}}</option>
                                @endforeach
                            </select>
                            <small id="checkexp"></small>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 ">
                                    <label for="" class="form-label">จำนวนสินค้า</label>
                                    <input type="number" id="qty" name="qty" class="form-control" required>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 ">
                            <label for="" class="form-label">หน่วยนับ</label>
                                <select name="" id="unit_id" class="form-control select2">
                                    @foreach ( $units as $unit )
                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 ">
                            <label for="" class="form-label">หมายเหตุ</label>
                                <input type="text" id="notation" name="notation" class="form-control" required>
                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3 ">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label">MFG.</label>
                                    <input type="date" id="mfg" name="mfg" class="form-control" required>
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label">EXP.</label>
                                    <input type="date" id="exp" name="exp" class="form-control" required>

                                </div>
                            </div>
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
        $('.select2').select2();
        var id = $('#id').val()
        var dataOld = {};

        let receive_product_table = "";
        $.ajax({
            type: "post",
            url: "{{route('api.v1.receive.product.list.product.lot')}}",
            data: {"id":id},
            dataType: "json",
            success: function (response) {
                var row = '';
                dataOld = response.aaData;
                // console.log(dataOld)
                response.aaData.forEach( (element,index)=> {
                    console.log(element)


                    row +=

                `<tr class="productrowold">
                    <td><a class="list_cancel"><i class="fas fa-times text-red"></i></a></td>
                    <td><span class="pro_lot "> ${element.lot} </span></td>
                    <td><span class="pro_com_id mat_hide "> ${element.company_id} </span>${element.company.name_th}</td>
                    <td><span class="pro_name mat_hide">${element.product.id}</span>${element.product.name}</td>
                    <td><span class="pro_unit_id mat_hide ">${element.unit_id}</span>${element.unit.name}</td>
                    <td><span class="pro_qty ">${element.qty}</span></td>
                    <td><span class="pro_mfg ">${element.mfg}</span></td>
                    <td><span class="pro_exp ">${element.exp}</span></td>
                    <td><span class="pro_notation ">${element.notation}</span></td>
                </tr>`

                });

                $('#rowbody').html(row);

                receive_product_table = $('#receive_product_table').DataTable({
                    "paging": false,
                    "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">',
                    "info": false,
                    "pageLength": 100,
                });
            }
        });


    var material = []

        $('.dropify').dropify();

        function check_duplicate_numberlot(){
            status = true;
            var lot= $('#lot').val();
            if (lot != "" || null) {
                $('.productrow').each(function(index,value){
                        if ( lot === $(value).find('.pro_lot').text()) {
                            status = false
                        }
                    })

                    $('.productrowold').each(function(index,value){
                        if ( lot === $(value).find('.pro_lot').text()) {
                            status = false
                        }
                    })
            }
            return status;
        }

        $('.add-to-table2').on('click', function() {

            if ($('#form_valid').valid()) {
                var unit_id = $('#unit_id').val();
                var unit_name = $('#unit_id option:selected').text();
                var product_unit_id = $('#product_unit_id').val();
                var product_unit_name = $('#product_unit_id option:selected').text();
                var company_name = $('#company_id option:selected').text();
                var company_id = $('#company_id').val();
                var product_name = $('#product_id option:selected').text();
                var product_id = $('#product_id').val()
                var lot = $('#lot').val();
                var qty = $('#qty').val();
                var exp = $('#exp').val();
                var mfg = $('#mfg').val();
                var coa = $('#coa').val();
                var notation = $('#notation').val();

                // var index = receive_material_table.row($(this).parents('tr'));
                // var rowindex = index.index();
                // // receive_material_table
                check_duplicate_numberlot()
                status = check_duplicate_numberlot();
                if(status === "true"){
                var index = receive_product_table.rows().count();
                var row = receive_product_table.row.add([
                        '<td><a class="list_cancel"><i class="fas fa-times text-red"></i></a></td>',
                        '<td><span class="pro_lot ">' + lot + '</span></td>',
                        '<td><span class="pro_com_id mat_hide ">' + company_id + '</span>' + company_name + '</td>',
                        '<td><span class="pro_name mat_hide">' + product_id + '</span>' + product_name + '</td>',
                        '<td><span class="pro_unit_id mat_hide ">' + unit_id + '</span>' + unit_name + '</span></td>',
                        '<td><span class="pro_qty ">' + qty + '</span></td>',
                        '<td><span class="pro_mfg ">' + mfg + '</span></td>',
                        '<td><span class="pro_exp ">' + exp + '</span></td>',
                        '<td><span class="pro_notation ">' + notation + '</span></td>',
                    ]).draw(false).nodes()
                    .to$()
                    .addClass('productrow')
                    $(".clear-modal").click();
                } else {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: 'หมายเลข ล็อตวัตถุดิบซ้ำกัน',
                        text: "กรุณาลบรายการเดิมออกเพื่อทำการเพิ่มใหม่!",
                        showConfirmButton: false,
                        timer: 1500,

                    })
                }
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

        $('#receive_product_table tbody').on('click', '.list_cancel', function() {
            var index = receive_product_table.row($(this).parents('tr'));
            var rowindex = index.index();
            receive_product_table
                .row($(this).parents('tr'))
                .remove()
                .draw();
            material.splice(rowindex, 1);

        });
        $('#create_receive_packaging').on('click', function() {
            var numrow = 0;
            var numrowold = 0;
            if ($('#receive_valid').valid()) {

            var formdata_receive = new FormData();
            // formdata_receive.append('username', 'Chris');
            formdata_receive.append('paper_no', $('#paper_no').val());
            formdata_receive.append('edit_times', $('#edit_times').val());
            formdata_receive.append('date', $('#date').val());
            formdata_receive.append('_token', $('#_token').val());
            formdata_receive.append('id', $('#id').val());
            formdata_receive.append('production_user_id', $('#production_user_id').val());
            formdata_receive.append('created_at', $('#created_at').val());
            formdata_receive.append('created_by', $('#created_by').val());
            formdata_receive.append('stock_user_id', $('#stock_user_id').val());
            formdata_receive.append('updated_at', $('#updated_at').val());
            formdata_receive.append('updated_by', $('#updated_by').val());
            formdata_receive.append('history_flag', $('#history_flag').val());
            formdata_receive.append('recap', $('#recap').val());
            formdata_receive.append('recapold', $('#recapold').val());
            formdata_receive.append('user_id', $('#user_id').val());
            formdata_receive.append('company_id', {{session('company')}});

            $('.productrow').each(function(index,value){

                formdata_receive.append('product[' + index + '][company_id]', $(value).find('.pro_com_id').text())
                formdata_receive.append('product[' + index + '][product_id]', $(value).find('.pro_name').text())
                formdata_receive.append('product[' + index + '][unit_id]', $(value).find('.pro_unit_id').text())
                formdata_receive.append('product[' + index + '][lot]', $(value).find('.pro_lot').text())
                formdata_receive.append('product[' + index + '][qty]', $(value).find('.pro_qty').text())
                formdata_receive.append('product[' + index + '][mfg]', $(value).find('.pro_mfg').text())
                formdata_receive.append('product[' + index + '][exp]', $(value).find('.pro_exp').text())
                formdata_receive.append('product[' + index + '][notation]', $(value).find('.pro_notation').text())
                numrow++
            })

            $('.productrowold').each(function(index,value){
                formdata_receive.append('productold[' + index + '][lot]', $(value).find('.pro_lot').text())
                formdata_receive.append('productold[' + index + '][qty]', $(value).find('.pro_qty').text())
                formdata_receive.append('productold[' + index + '][mfg]', $(value).find('.pro_mfg').text())
                formdata_receive.append('productold[' + index + '][exp]', $(value).find('.pro_exp').text())
                formdata_receive.append('productold[' + index + '][company_id]', $(value).find('.pro_com_id').text())
                formdata_receive.append('productold[' + index + '][product_id]', $(value).find('.pro_name').text())
                formdata_receive.append('productold[' + index + '][unit_id]', $(value).find('.pro_unit_id').text())
                formdata_receive.append('productold[' + index + '][notation]', $(value).find('.pro_notation').text())
                numrowold++
            })
            console.log('numrow :',numrow,'numrowold :',numrowold)
            formdata_receive.append('lengthproduct',numrow)
            formdata_receive.append('lengthproductOld',numrowold)
            formdata_receive.append('productOld',JSON.stringify(dataOld))
        //    console.log('olddata'+ JSON.stringify(dataOld))
            var rows_material = receive_product_table.rows().count();
            // console.log(index)
                if (rows_material > 0) {
                    Swal.fire({
                                title: 'ยืนยันการนำเข้าสินค้า?',
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
                                        url: "{{route('api.v1.receive.product.edit')}}",
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
                                                window.location.assign("{{ route('receive.product') }}")
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
                                title: 'กรุณาเพิ่มรายการสินค้า',
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
</script>
@endsection
