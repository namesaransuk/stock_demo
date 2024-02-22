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
    .pro_hide {
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
                <li class="breadcrumb-item active"><a href="{{ route('list.requsition.product') }}">รายการเบิกสินค้า</a></li>
                <li class="breadcrumb-item active">เพิ่มรายการเบิกสินค้า</li>
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
                    <label for="" class="form-label text-md">รายการสินค้า</label>
                    <select name="" id="product_id" class="form-control select2 " style="height: 40px;">
                        @foreach ( $products as $product )
                            @if ($product->record_status === 1)
                                <option value="{{$product->id}}" data-name="{{$product->name}}">{{$product->name}} : จำนวน {{ number_format($product->stockremain) }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 ">
                    <label for="" class="form-label">ล็อตสินค้า : จำนวนคงเหลือ</label>
                    <select name="" id="product_lot_id" class="form-control select2">
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
    <div class="card-header ogn-stock-yellow text-left ">
        <em class="fas fa-file-alt text-gray"></em> แก้ไขรายการส่งออกสินค้า
    </div>
    <div class="card-body">
        <form action="" id="receive_valid">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                <label for="" class="form-label">หมายเลขเอกสาร</label>
                <input type="text" id="paper_no" class="form-control"  value="{{$requsition_product->paper_no}}"  readonly>
                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                <input type="hidden" name="id" id="id" value="{{$requsition_product_id}}">
                <input type="hidden" name="edit_times" id="edit_times" value="{{$requsition_product->edit_times}}">
                <input type="hidden" name="created_by" id="created_by" value="{{$requsition_product->created_by}}">
                <input type="hidden" name="updated_by" id="updated_by" value="{{$requsition_product->updated_by}}">
                <input type="hidden" name="transport_user_id" id="transport_user_id" value="{{$requsition_product->transport_user_id}}">
                <input type="hidden" name="audit_user_id" id="audit_user_id" value="{{$requsition_product->audit_user_id}}">
                <input type="hidden" name="qc_user_id" id="qc_user_id" value="{{$requsition_product->qc_user_id}}">
                <input type="hidden" name="stock_user_id" id="stock_user_id" value="{{$requsition_product->stock_user_id}}">
                <input type="hidden" name="recap_old" id="recap_old" value="{{$requsition_product->recap}}">
                <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                <label for="" class="form-label">วันที่ส่งออก</label>
                <input type="text" id="date" name="date" value="{{$requsition_product->date}}" class="form-control" readonly>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                <label for="" class="form-label">ประเภทการส่ง</label> <br>
                <select name="transport_type" id="transport_type" class="select2 w-100" disabled>
                    <option value="1" {{$requsition_product->transport_type==1?'selected':''}}>บริษัทเป็นผู้ส่ง</option>
                    <option value="2" {{$requsition_product->transport_type==2?'selected':''}}>ลูกค้ามารับเอง</option>
                    <option value="3" {{$requsition_product->transport_type==3?'selected':''}}>ส่งผ่านบริษัทขนส่ง</option>
                </select>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                <label for="" class="form-label">หมายเหตุการแก้ไข</label>
                <input type="text" id="recap" name="recap" class="form-control" required>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h6>รายละเอียดการจัดส่ง</h6>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">ชื่อ-นามสกุล</label>
                        <input type="text" id="cus_name" name="cus_name" class="form-control" value="{{$requsition_product->receive_name}}" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">เบอร์โทร</label>
                        <input type="text" id="tel" name="tel" class="form-control" value="{{$requsition_product->receive_tel}}" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">ทะเบียนรถ</label>
                        <input type="text" id="vehicle" name="vehicle" class="form-control" value="{{$requsition_product->receive_vehicle}}" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">รายละเอียดที่อยู่</label>
                        <input type="text" id="house_no" name="house_no" class="form-control" value="{{$requsition_product->receive_house_no}}" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">ตำบล</label>
                        <input type="text" id="tumbol" name="tumbol" class="form-control" value="{{$requsition_product->receive_tumbol}}" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">อำเภอ</label>
                        <input type="text" id="aumphur" name="aumphur" class="form-control" value="{{$requsition_product->receive_aumphur}}" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">จังหวัด</label>
                        <input type="text" id="province" name="province" class="form-control" value="{{$requsition_product->receive_province}}" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">รหัสไปรษณีย์</label>
                        <input type="text" id="postcode" name="postcode" class="form-control" value="{{$requsition_product->receive_postcode}}" required>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <hr class="my-4">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-gdp">
                    <div class="card-header" >
                        <h6 class="m-0"> รายการสินค้า </h6>
                    </div>
                    <div class="card-body p-0">
                        <table id="requsition_product" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                            <caption style="display: none"></caption>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="w-auto">#</th>
                                    <th scope="col" class="w-auto">ล็อต</th>
                                    <th scope="col" class="w-auto">รายการสินค้า</th>
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
                    <button class="btn ogn-stock-green text-white" id="create_receive_product2"><em class="fas fa-save"></em> บันทึก</button>
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
        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.product.cut.lot')}}",
            data: {"id":id},
            dataType: "json",
            success: function (response) {
                var row = '';
                dataOld = response;
                response.forEach(element => {
                    console.log(element);
                    row +=
                `<tr class="productrowold">
                    <td><a class="list_cancel"><i class="fas fa-times text-danger"></i></a></td>
                    <td><span class="pro_lot_id pro_hide ">${element.product_lot.id}</span>${element.product_lot.lot}</span></td>
                    <td><span class="pro_id pro_hide ">${element.product_lot.product.id}</span>${element.product_lot.product.name}</td>
                    <td><span class="pro_qty">${element.qty}</span> ชิ้น</td>
                </tr>`

                });

                $('#rowbody').html(row);

                requsition_product = $('#requsition_product').DataTable({
                    "paging": false,
                    "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">',
                    "info": false,
                    "pageLength": 100,
                });

            }
        });

        var product_id = $('#product_id').val()
        var product_lot = [];
        var product_cut = [];
        var product_in_stock = [];
        var total_product_instock = [];
        var product = [];
        var mfg ;
        var exp ;
        $('.select2').select2()

        $('#product_id').on('change',function () {
            var product_id = $('#product_id').val()
            $.ajax({
                type: "post",
                url: "{{route('api.v1.requsition.list.product.lot')}}",
                data: {'product_id': product_id },
                dataType: "json",
                success: function (response) {
                    console.log(response)
                    $('#product_lot_id').find('option').remove().end()
                        response.product_lots.forEach(element => {
                            total_qty = parseFloat(element.lotremain);
                            let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                            let total = formatter.format(total_qty);

                            $('#product_lot_id').append(`<option value="${element
                            .id}" data-name="${element.lot}">  ${element.lot} : จำนวน <span class="total">${total}</span> ชิ้น</option>`);

                        });
                }
            });
        });

        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.list.product.lot')}}",
            data: {'product_id': product_id },
            dataType: "json",
            success: function (response) {
                product_lot = response
                // check_stock_product()
                $('#product_lot_id').find('option').remove().end()
                    response.product_lots.forEach(element => {
                        total_qty = parseFloat(element.lotremain);
                        let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                        let total = formatter.format(total_qty);

                        $('#product_lot_id').append(`<option value="${element
                            .id}" data-name="${element.lot}">  ${element.lot} : จำนวน <span class="total">${total}</span> ชิ้น</option>`);
                    });
            }
        });

        $('.dropify').dropify();

        $('.add-to-table').on('click', function(){
            if ($('#form_valid').valid() && check_duplicate_numberlot()) {
                qty_stock = $('#product_lot_id option:selected').find('.total').text()
                qty_stock = qty_stock.replace(/\,/g,'');
            var    product_id= $('#product_id').val();
            var    product_name= $('#product_id option:selected').data('name');
            var    product_lot_name= $('#product_lot_id option:selected').data('name');
            var    product_lot_id= $('#product_lot_id').val();
            var    qty= $('#qty').val();
            var    date= $('#date_requsition').val();

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
                    var index = requsition_product.rows().count();
                    var row = requsition_product.row.add([
                    '<td><a class="list_cancel"><i class="fas fa-times text-red"></i></a></td>',
                    '<td><span class="pro_lot_id pro_hide ">'+product_lot_id +'</span>'+product_lot_name+'</span></td>',
                    '<td><span class="pro_id pro_hide ">'+product_id  +'</span>'+product_name+'</td>',
                    '<td><span class="pro_qty">'+qty+'</span> ชิ้น</td>',

                    ]).draw(false).nodes()
                    .to$()
                    .addClass( 'productrow' )

                }
            }

        })

        function check_duplicate_numberlot(){
            var lot= $('#product_lot_id').val();
            var status = true;
            if (lot != "" || null) {
                $('.pro_lot_id').each(function(index,value){
                        if ( lot == $(value).text()) {
                            Swal.fire({
                                icon: 'error',
                                title: 'ท่านได้เพิ่มรายการนี้แล้ว',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            status = false;
                        }
                })
            }
            return status;
        }



        $('#requsition_product tbody').on('click', '.list_cancel', function() {
            var index = requsition_product.row($(this).parents('tr'));
            var rowindex = index.index();
            requsition_product
                .row($(this).parents('tr'))
                .remove()
                .draw();
            product.splice(rowindex, 1);
        });
        $('#create_receive_product2').on('click', function() {

            if ($('#receive_valid').valid()) {
            var numrow = 0;
            var numrowold = 0;
            var formdata_receive = new FormData();
            // formdata_receive.append('username', 'Chris');
            formdata_receive.append('paper_no', $('#paper_no').val());
            formdata_receive.append('recap', $('#recap').val());
            formdata_receive.append('recap_old', $('#recap_old').val());
            formdata_receive.append('date', $('#date').val());
            formdata_receive.append('_token', $('#_token').val());
            formdata_receive.append('id', $('#id').val());
            formdata_receive.append('user_id', $('#user_id').val());

            formdata_receive.append('vehicle', $('#vehicle').val());
            formdata_receive.append('house_no', $('#house_no').val());
            formdata_receive.append('tumbol', $('#tumbol').val());
            formdata_receive.append('aumphur', $('#aumphur').val());
            formdata_receive.append('province', $('#province').val());
            formdata_receive.append('postcode', $('#postcode').val());
            formdata_receive.append('cus_name', $('#cus_name').val());
            formdata_receive.append('tel', $('#tel').val());
            formdata_receive.append('transport_type', $('#transport_type').val());

            formdata_receive.append('edit_times', $('#edit_times').val());
            formdata_receive.append('created_by', $('#created_by').val());
            formdata_receive.append('updated_by', $('#updated_by').val());
            formdata_receive.append('transport_user_id', $('#transport_user_id').val());
            formdata_receive.append('audit_user_id', $('#audit_user_id').val());
            formdata_receive.append('qc_user_id', $('#qc_user_id').val());
            formdata_receive.append('stock_user_id', $('#stock_user_id').val());
            formdata_receive.append('company_id', {{session('company')}});

            $('.productrowold').each(function(index,value){
                formdata_receive.append('productOld['+index+'][product_lot_id]',$(value).find('.pro_lot_id').text())
                formdata_receive.append('productOld['+index+'][product_id]',$(value).find('.pro_id').text())
                formdata_receive.append('productOld['+index+'][qty]',$(value).find('.pro_qty').text())
                formdata_receive.append('productOld['+index+'][date]',$(value).find('.pro_date').text())
                numrowold++
            })

            $('.productrow').each(function(index,value){
                formdata_receive.append('product['+index+'][product_lot_id]',$(value).find('.pro_lot_id').text())
                formdata_receive.append('product['+index+'][product_id]',$(value).find('.pro_id').text())
                formdata_receive.append('product['+index+'][qty]',$(value).find('.pro_qty').text())
                formdata_receive.append('product['+index+'][date]',$(value).find('.pro_date').text())
                numrow++
            })

            formdata_receive.append('lengthproduct',numrow)
            formdata_receive.append('lengthproductOld',numrowold)
            formdata_receive.append('productOld',JSON.stringify(dataOld))
            var rows_product = requsition_product.rows().count();
                if (rows_product > 0) {
                    Swal.fire({
                                title: 'ยืนยันการเบิกสินค้า?',
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
                                        url: "{{route('api.v1.requsition.product.edit')}}",
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
                                                window.location.assign("{{ route('list.requsition.product') }}")
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
                                title: 'กรุณาเพิ่มรายการเบิกสินค้า',
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
