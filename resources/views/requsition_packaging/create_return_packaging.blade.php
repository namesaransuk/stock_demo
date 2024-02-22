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
                <li class="breadcrumb-item active"><a href="{{ route('check.requsition.packaging.stock') }}">คืนบรรจุภัณฑ์</a></li>
                <li class="breadcrumb-item active">เพิ่มการคืนบรรจุภัณฑ์</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')

<div class="card">
    <div class="card-header bg-white text-left ">
     ใบเบิกบรรจุภัณฑ์
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
                            <th scope="col" class="w-auto">จำนวนที่เบิก</th>
                            <th scope="col" class="w-auto">จำนวนที่ใช้จริง</th>
                            <th scope="col" class="w-auto">จำนวนที่คืน</th>

                        </tr>
                    </thead>
                    <tbody id="rowbody">
                    </tbody>
                </table>

            </div>

        </div>
        <div style="text-align: right;">
            <button class="btn ogn-stock-grey text-black btn-back"><em class="fas fa-arrow-left"></em> ย้อนกลับ</button>
            <button class="btn ogn-stock-green text-white" id="create_receive_material2"><em class="fas fa-save"></em> คืนบรรจุภัณฑ์</button>
        </div>
    </div>
</div>

    </div> {{-- cardbody --}}
</div>




@endsection

@section('js')
<script>
    $(function() {

        // alert(555);

        let id = $('#id').val()
        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.packaging.cut.lot')}}",
            data: {"id":id},
            dataType: "json",
            success: function (response) {
                var row = '';
                dataOld = response;
                var numrow = 0;
                response.forEach(element => {
                    console.log(element)
                    numrow++
                    var qty = parseFloat(element.qty)  ;
                    row +=
                `<tr class="packagingrowold">
                <td>${numrow}</td>
                <td><span class="pack_lot_id mat_hide ">${element.packaging_lot.id}</span>${element.packaging_lot.lot}</span></td>
                <td><span class="pack_id mat_hide ">${element.packaging_lot.packaging.id}</span>${element.packaging_lot.packaging.name}</td>
                <td><input type="number"   class="form-control pack_qty" value="${qty}" readonly></td>
                <td><input type="number"   class="form-control use_qty check_lot_${element.packaging_lot.id}" data-id="${element.packaging_lot.id}" value="${qty}" min="0" max="${qty}" required></td>
                <td>
                    <div class="card">
                        <div class="card-body">

                            <input type="hidden" class="id_pack_return" value="${element.id}">
                            <input type="hidden" class="all_return_${element.packaging_lot.id}" value="0" readonly required >
                            <input type="hidden" class="total_waste_${element.packaging_lot.id}" value="0" readonly required >

                            <div class="form-group">
                                <small id="good" class="form-text text-muted change_return">ของดี</small>
                                <input type="number" class="form-control met_good good_${element.packaging_lot.id} clear_${element.packaging_lot.id}" data-id="${element.packaging_lot.id}" aria-describedby="good" min="0" value="0" required>
                            </div>
                            <div class="form-group">
                                <small id="waste" class="form-text text-muted change_return">ของเสีย</small>
                                <input type="number" class="form-control met_waste waste_${element.packaging_lot.id} met_waste_${element.packaging_lot.id} clear_${element.packaging_lot.id}" data-id="${element.packaging_lot.id}" aria-describedby="waste" min="0" readonly value="0" required>
                            </div>

                            <div class="card clear_child_${element.packaging_lot.id} waste_child_${element.packaging_lot.id}" id="waste_child" hidden>
                                <div class="card-body">
                                    <div class="form-group">
                                        <small id="claim" class="form-text text-muted">เคลม</small>
                                        <input type="number" class="form-control met_claim claim_${element.packaging_lot.id} met_claim_${element.packaging_lot.id} clear_${element.packaging_lot.id}" data-id="${element.packaging_lot.id}" aria-describedby="claim" min="0" value="0" required>
                                    </div>
                                    <div class="form-group">
                                        <small id="destroy" class="form-text text-muted">ทำลาย</small>
                                        <input type="number" class="form-control met_destroy met_destroy_${element.packaging_lot.id} clear_${element.packaging_lot.id}" data-id="${element.packaging_lot.id}" aria-describedby="destroy" min="0" readonly value="0" required>
                                        <input type="hidden"   class="form-control return_qty" value="0" readonly required >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
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

        var qty = 0;

        $(document).on('keyup, change','.use_qty', function(){
            let obj = $(this);
            let tr = obj.closest('tr');
            let tt_w = tr.find('.pack_qty').val();
            tr.find('.return_qty').val(parseFloat(tt_w)-parseFloat(obj.val()));

            let get_lot = $(this).data('id');
            console.log(get_lot);
            $('.all_return_'+get_lot).val(parseFloat(tt_w)-parseFloat(obj.val()));
            clearReturn(get_lot);
            $('.good_'+get_lot).val(parseFloat(tt_w)-parseFloat(obj.val()));
        })

        function clearReturn(get_lot) {

            $('.clear_'+get_lot).val(0);

            // $('#met_good').val(0);
            // $('#met_waste').val(0);
            $('.clear_child_'+get_lot).attr("hidden",true);

        }

        function clearDestroy(get_lot) {
            $('.met_claim'+get_lot).val(0);
            $('.met_destroy'+get_lot).val(0);
        }
//         met_good
// met_waste

        $(document).on('keyup keypress change','.met_good', function(){

            let get_lot = $(this).data('id');
            let waste = $('.all_return_'+get_lot).val() - $(this).val();
            $('.met_destroy_'+get_lot).val(0);

            if (waste < 0) {
                clearReturn(get_lot);
                Swal.fire({
                        position: 'center-center',
                        icon: 'error',
                        title: 'จำนวนไม่ถูกต้อง',
                        showConfirmButton: true,
                        // timer: 1500,


                    })

                    $('.use_qty').trigger('change')
            }else{
                $('.met_waste_'+get_lot).val(waste);
                $('.total_waste_'+get_lot).val(waste);
                let claim_value = $('.total_waste_'+get_lot).val();
                if (waste > 0) {
                    $('.waste_child_'+get_lot).attr("hidden",false);
                    $('.claim_'+get_lot).val(claim_value);
                }else{
                    $('.waste_child_'+get_lot).attr("hidden",true);
                }
            }
        })

        $(document).on('keyup keypress blur change','.met_claim', function(){

            let get_lot = $(this).data('id');
            let destroy = $('.total_waste_'+get_lot).val() - $(this).val();
            if (destroy < 0) {
                clearDestroy(get_lot);
                Swal.fire({
                        position: 'center-center',
                        icon: 'error',
                        title: 'จำนวนไม่ถูกต้อง',
                        showConfirmButton: true,
                        // timer: 1500,
                    })
                    $('.met_good').trigger('change')
            }else{
                $('.met_destroy_'+get_lot).val(destroy);
            }
        })

        $(document).bind('mouseup','.use_qty',function() {
            $(".use_qty").trigger('blur');
        })


    var material = []

        $('.dropify').dropify();


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
            var formdata_return_packaging = new FormData();
            // formdata_return_packaging.append('username', 'Chris');
            formdata_return_packaging.append('paper_no', $('#paper_no').val());
            formdata_return_packaging.append('product_name', $('#product_name').val());
            formdata_return_packaging.append('edit_times', $('#edit_times').val());
            formdata_return_packaging.append('date', $('#date').val());
            formdata_return_packaging.append('_token', $('#_token').val());
            formdata_return_packaging.append('id', $('#id').val());
            formdata_return_packaging.append('paper_status', $('#paper_status').val());
            formdata_return_packaging.append('created_by', $('#created_by').val());
            formdata_return_packaging.append('updated_by', $('#updated_by').val());
            formdata_return_packaging.append('production_user_id', $('#production_user_id').val());
            formdata_return_packaging.append('procurement_user_id', $('#procurement_user_id').val());
            formdata_return_packaging.append('stock_user_id', $('#stock_user_id').val());
            formdata_return_packaging.append('recap_old', $('#recap_old').val());
            formdata_return_packaging.append('recap', $('#recap').val());
            formdata_return_packaging.append('user_id', $('#user_id').val());
            formdata_return_packaging.append('company_id', {{session('company')}});



            $('.packagingrowold').each(function(index,value){
                var total_qty = $(value).find('.return_qty').val();
                formdata_return_packaging.append('packagingold['+index+'][packaging_lot_id]',$(value).find('.pack_lot_id').text())
                formdata_return_packaging.append('packagingold['+index+'][packaging_id]',$(value).find('.pack_id').text())
                formdata_return_packaging.append('packagingold['+index+'][qty]',$(value).find('.pack_qty').val())
                formdata_return_packaging.append('packagingold['+index+'][use_qty]',$(value).find('.use_qty').val())
                formdata_return_packaging.append('packagingold['+index+'][date]',$(value).find('.pack_date').text())
                formdata_return_packaging.append('packagingold['+index+'][total_return]',total_qty)


                // new_return
                formdata_return_packaging.append('packagingold['+index+'][id_pack_return]',$(value).find('.id_pack_return').val())
                formdata_return_packaging.append('packagingold['+index+'][met_good]',$(value).find('.met_good').val())
                formdata_return_packaging.append('packagingold['+index+'][met_waste]',$(value).find('.met_waste').val())
                formdata_return_packaging.append('packagingold['+index+'][met_claim]',$(value).find('.met_claim').val())
                formdata_return_packaging.append('packagingold['+index+'][met_destroy]',$(value).find('.met_destroy').val())

                numrowold++
            })


            formdata_return_packaging.append('lengthpackaging',numrow)

            var rows_material = requsition_packaging_table.rows().count();

                    Swal.fire({
                                title: 'ยืนยันการคืนบรรจุภัณฑ์?',
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
                                        url: "{{route('api.v1.requsition.packaging.return.create')}}",
                                        data: formdata_return_packaging,
                                        contentType: false,
                                        processData: false,
                                        cache: false,
                                        // dataType: "dataType",
                                        success: function (response) {
                                            if (response) {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'success',
                                                    title: 'เพิ่มรายการคืนบรรจุภัณฑ์สำเร็จ',
                                                    showConfirmButton: false,
                                                    timer: 1500,

                                                })
                                                window.location.assign("{{ route('check.requsition.packaging.stock') }}")
                                            } else {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'warning',
                                                    title: 'เพิ่มรายการคืนบรรจุภัณฑ์ไม่สำเร็จ',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                })
                                            }
                                        }
                                    });
                                }
                            });


            }

        })
        $('.btn-back').on('click',function(){
            window.history.back();
        });

    });


</script>
@endsection
