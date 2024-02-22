@extends('adminlte::page')

@section('css')
<style>
    .modal-full {
        min-width: 50%;
        margin-left: 80;
    }

    .template_row:first-child {
        display: none;
        margin: 0 auto;
    }
    .supply_hide {
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
                <li class="breadcrumb-item active"><a href="{{ route('list.receive.supply') }}">รับเข้าวัสดุสิ้นเปลือง</a></li>
                <li class="breadcrumb-item active">เพิ่มรายการนำเข้า</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="card">
    <div class="card-header ogn-stock-green ">
        แก้ไขรายการนำเข้าวัสดุสิ้นเปลือง
    </div>
    <div class="card-body">
        <form action="" id="receive_valid">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 ">
                <label for="" class="form-label">หมายเลขเอกสาร</label>
                <input type="text" id="paper_no" class="form-control" value="{{$receivesupply->paper_no}}" required readonly>
                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                <input type="hidden" name="id" id="id" value="{{$receivesupply->id}}">
                <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
                <input type="hidden" name="paper_no" id="paper_no" value="{{$receivesupply->paper_no}}">
                <input type="hidden" name="paper_status" id="paper_status" value="{{$receivesupply->paper_status}}">
                <input type="hidden" name="edit_times" id="edit_times" value="{{$receivesupply->edit_times}}">
                <input type="hidden" name="created_by" id="created_by" value="{{$receivesupply->created_by}}">
                <input type="hidden" name="updated_by" id="updated_by" value="{{$receivesupply->updated_by}}">
                <input type="hidden" name="stock_user_id" id="stock_user_id" value="{{$receivesupply->stock_user_id}}">
                <input type="hidden" name="recapold" id="recapold" value="{{$receivesupply->recap}}">
                <input type="hidden" name="created_at" id="created_at" value="{{$receivesupply->created_at}}">
                <input type="hidden" name="updated_at" id="updated_at" value="{{$receivesupply->updated_at}}">
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                <label for="" class="form-label">วันที่นำเข้า (ค.ศ.)</label>
                <input type="text" id="date" value="{{$receivesupply->date}}" class="form-control" readonly>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 ">
                <label for="" class="form-label">แบรนด์สินค้า</label>
                <select name="" id="brand_vendor_id" class="form-control" readonly disabled>
                    @foreach ( $vendors as $brand )
                    @if ($brand->type == 1)
                    <option value="{{$brand->id}}">{{$brand->brand}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label for="" class="form-label">หมายเหตุ</label>
                <input type="text" id="recap" name="recap" class="form-control" required >
            </div>
        </div>
        </form>
        <hr class="my-4">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-gdp">
                    <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                        <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รับเข้าวัสดุสิ้นเปลือง </h6>
                    </div>
                    <div class="p-2">
                        <div class="float-right">
                            <input type="search" id="custom-search-input" class="form-control form-control-sm" placeholder="ค้นหา">
                        </div>
                        <a href="" type="button" style="" data-toggle="modal" data-target="#myModal" class="btn rounded ml-2"><em class="fas fa-plus-circle text-success"></em> เพิ่มรายการ</a>
                    </div>
                    <div class="card-body p-0">
                        <table id="receive_supply_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                            <caption style="display: none"></caption>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="w-auto">#</th>
                                    <th scope="col" class="w-auto">รายการ</th>
                                    <th scope="col" class="w-auto">บริษัท</th>
                                    <th scope="col" class="w-auto">Lot</th>
                                    <th scope="col" class="w-auto">จำนวนชิ้น</th>
                                    {{-- <th scope="col" class="w-auto">MFG.</th>
                                    <th scope="col" class="w-auto">EXP.</th> --}}
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
    </div>
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
                    <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3 d-flex flex-column">
                                <label for="" class="form-label">ชื่อวัสดุสิ้นเปลือง</label>

                                <select name="" id="supply_id" class="form-control select2">
                                    @foreach ( $supplies as $supply )
                                    <option value="{{$supply->id}}">{{$supply->name}}</option>
                                    @endforeach
                                </select>

                                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                                <input type="hidden" name="id" id="id" value="">
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3 ">
                                <label for="" class="form-label">บริษัท</label>
                                @php
                                    $current_company = session('company')?:'';
                                @endphp
                                <select name="" id="company_id" class="form-control" disabled >
                                    @foreach ( $companies as $company )

                                    <option {{$current_company==$company->id?'selected':''}} value="{{$company->id}}">{{$company->name_th}}</option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3 ">
                                <label for="" class="form-label">หมายเลข ล็อต</label>
                                <input type="text" id="lot" name="lot" class="form-control" required>
                                <small id="checklot"></small>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                <label for="" class="form-label">จำนวนชิ้น</label>
                                <input type="number" min="0" id="qty" name="qty" class="form-control" value="0" required>
                                <small id="checkqty"></small>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                {{-- <label for="" class="form-label">MFG.</label> --}}
                                <input type="hidden" id="mfg" name="mfg" class="form-control" required>
                                <small id="checkmfg"></small>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                {{-- <label for="" class="form-label">EXP.</label> --}}
                                <input type="hidden" id="exp" name="exp" class="form-control" required>
                                <small id="checkexp"></small>
                            </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="margin-top: 10px;;">
                <button type="button" class="btn clear-modal ogn-stock-grey " style="color:black;" data-dismiss="modal"><em class="fas fa-close"></em> ยกเลิก</button>
                <button  class="btn btn-save ogn-stock-green text-white add-to-table" style=" color:black;"><em class="fas fa-save"></em> เพิ่ม</button>
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

        $.ajax({
            type: "post",
            url: "{{route(('api.v1.receive.supply.view.edit'))}}",
            data: {'id':id},
            dataType: "json",
            success: function (response) {
                $('#brand_vendor_id').val(response.brand_vendor_id)
            }
        });

        let receive_supply_table = "";
        $.ajax({
            type: "post",
            url: "{{route('api.v1.receive.supply.list.supply.lot')}}",
            data: {"id":id},
            dataType: "json",
            success: function (response) {
                var row = '';
                dataOld = response.aaData;
                dataOld.forEach( (element,index)=> {
                    row +=

                `<tr class="supplyrowold">
                    '<td><a class="list_cancel"><i class="fas fa-times text-red"></i></a></td>',
                    '<td><span class="supply_id supply_hide ">${element.supply_id}</span>${element.supply.name}</span></td>',
                    '<td><span class="supply_com_id supply_hide ">${element.company_id}</span>${element.company.name_th}</td>',
                    '<td><span class="supply_lot ">${element.lot}</span></td>',
                    '<td><span class="supply_qty ">${new Intl.NumberFormat("th-TH").format(element.qty)}</span></td>',
                </tr>`
                    // '<td><span class="supply_mfg ">${element.mfg}</span></td>',
                    // '<td><span class="supply_exp ">${element.exp}</span></td>',
                });

                $('#rowbody').html(row);

                receive_supply_table = $('#receive_supply_table').DataTable({
                    "paging": false,
                    "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">',
                    "info": false,
                    "pageLength": 100,
                    "ordering": false
                });
            }
        });

        var supply = []
        $('.dropify').dropify();

        function check_duplicate_numberlot(){
            status = true;
            var lot= $('#lot').val();
            if (lot != "" || null) {
                $('.supplyrow').each(function(index,value){
                    if ( lot === $(value).find('.supply_lot').text()) {
                        status = false
                    }
                })

                $('.supplyrowold').each(function(index,value){
                    if ( lot === $(value).find('.supply_lot').text()) {
                        status = false
                    }
                })
            }
            return status;
        }

        $('.add-to-table').on('click', function(){
            if ($('#form_valid').valid()) {
                var supply_id = $('#supply_id').val();
                var supply_name = $('#supply_id option:selected').text();
                var company_id= $('#company_id').val();
                var company_name= $('#company_id option:selected').text();
                var lot= $('#lot').val();
                var qty= $('#qty').val();
                var mfg= $('#mfg').val();
                var exp= $('#exp').val();
                var index = receive_supply_table.rows().count();
                check_duplicate_numberlot()
                status = check_duplicate_numberlot();
                if(status === "true"){
                    var index = receive_supply_table.rows().count();
                    var row = receive_supply_table.row.add([
                        '<td><a class="list_cancel"><i class="fas fa-times text-red"></i></a></td>',
                        '<td><span class="supply_id supply_hide ">'+supply_id +'</span>'+supply_name+'</span></td>',
                        '<td><span class="supply_com_id supply_hide ">'+company_id  +'</span>'+company_name+'</td>',
                        '<td><span class="supply_lot ">'+lot +'</span></td>',
                        '<td><span class="supply_qty ">'+new Intl.NumberFormat("th-TH").format(qty) +'</span></td>',
                        // '<td><span class="supply_mfg ">'+mfg +'</span></td>',
                        // '<td><span class="supply_exp ">'+exp +'</span></td>',
                    ]).draw(false).nodes()
                    .to$()
                    .addClass( 'supplyrow' )
                    $(".clear-modal").click();
                } else {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'warning',
                        title: 'หมายเลขล็อตซ้ำกัน',
                        text: "กรุณาลบรายการเดิมออกเพื่อทำการเพิ่มใหม่!",
                        showConfirmButton: false,
                        timer: 1500,
                    })
                }
            }
        })



        $(".clear-modal").on('click', function() {
                $('#lot').val(""),
                $('#qty').val("0"),
                $('#mfg').val(""),
                $('#exp').val(""),
                $("#myModal").modal("hide");
        });

        $('.btn-back').on('click',function(){
            window.history.back();
        });

        $('#receive_supply_table tbody').on('click', '.list_cancel', function() {
            var index = receive_supply_table.row($(this).parents('tr'));
            var rowindex = index.index();
            receive_supply_table
                .row($(this).parents('tr'))
                .remove()
                .draw();
            supply.splice(rowindex, 1);
        });

        $('#create_receive_supply').on('click', function() {
            var numrow = 0;
            var numrowold = 0;
            if ($('#receive_valid').valid()) {
            var formdata_receive = new FormData();
                formdata_receive.append('paper_no', $('#paper_no').val());
                formdata_receive.append('paper_status', $('#paper_status').val());
                formdata_receive.append('edit_times', $('#edit_times').val());
                formdata_receive.append('date', $('#date').val());
                formdata_receive.append('brand_vendor_id', $('#brand_vendor_id').val());
                formdata_receive.append('_token', $('#_token').val());
                formdata_receive.append('id', $('#id').val());
                formdata_receive.append('created_at', $('#created_at').val());
                formdata_receive.append('updated_at', $('#updated_at').val());
                formdata_receive.append('created_by', $('#created_by').val());
                formdata_receive.append('updated_by', $('#updated_by').val());
                formdata_receive.append('stock_user_id', $('#stock_user_id').val());
                formdata_receive.append('recap', $('#recap').val());
                formdata_receive.append('recapold', $('#recapold').val());
                formdata_receive.append('user_id', $('#user_id').val());
                formdata_receive.append('company_id', {{session('company')}});

            $('.supplyrow').each(function(index,value){
                formdata_receive.append('supply['+index+'][supply_id]',$(value).find('.supply_id').text())
                formdata_receive.append('supply['+index+'][company_id]',$(value).find('.supply_com_id').text())
                formdata_receive.append('supply['+index+'][lot]',$(value).find('.supply_lot').text())
                formdata_receive.append('supply['+index+'][qty]',$(value).find('.supply_qty').text().replaceAll(',',''))
                formdata_receive.append('supply['+index+'][mfg]',$(value).find('.supply_mfg').text())
                formdata_receive.append('supply['+index+'][exp]',$(value).find('.supply_exp').text())
                numrow++
            })

            $('.supplyrowold').each(function(index,value){
                formdata_receive.append('supplyold['+index+'][supply_id]',$(value).find('.supply_id').text())
                formdata_receive.append('supplyold['+index+'][company_id]',$(value).find('.supply_com_id').text())
                formdata_receive.append('supplyold['+index+'][lot]',$(value).find('.supply_lot').text())
                formdata_receive.append('supplyold['+index+'][qty]',$(value).find('.supply_qty').text().replaceAll(',',''))
                formdata_receive.append('supplyold['+index+'][mfg]',$(value).find('.supply_mfg').text())
                formdata_receive.append('supplyold['+index+'][exp]',$(value).find('.supply_exp').text())
                numrowold++
            })

            console.log('numrow :',numrow,'numrowold :',numrowold)
            formdata_receive.append('lengthsupply',numrow)
            formdata_receive.append('lengthsupplyOld',numrowold)
            formdata_receive.append('supplyOld',JSON.stringify(dataOld))
            var rows_supply = receive_supply_table.rows().count();
                if (rows_supply > 0) {
                    Swal.fire({
                                title: 'ยืนยันการแก้ไขนำเข้าวัสดุสิ้นเปลือง?',
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
                                        url: "{{route('api.v1.receive.supply.edit')}}",
                                        data: formdata_receive,
                                        contentType: false,
                                        processData: false,
                                        cache: false,
                                        success: function (response) {
                                            if (response) {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'success',
                                                    title: 'เพิ่มรายการนำเข้าสำเร็จ',
                                                    showConfirmButton: false,
                                                    timer: 1500,

                                                })
                                                window.location.assign("{{ route('list.receive.supply') }}")
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
                                title: 'กรุณาเพิ่มรายการนำเข้าวัสดุสิ้นเปลือง',
                                showConfirmButton: false,
                                timer: 1500
                            })
                }
            }
        })
    });
</script>
@endsection
