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
    .pack_hide {
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
                <li class="breadcrumb-item active"><a href="{{ route('packaging') }}">รับเข้าบรรจุภัณฑ์</a></li>
                <li class="breadcrumb-item active">เพิ่มรายการนำเข้า</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="card">
    <div class="card-header ogn-stock-green ">
        เพิ่มรายการนำเข้าบรรจุภัณฑ์
    </div>
    <div class="card-body">
    <form action="" id="receive_valid">
    <div class="row">
        <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
        <input type="hidden" name="id" id="id" value="">
        <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
        {{-- <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
            <label for="" class="form-label">หมายเลขเอกสาร</label>
            <input type="text" name="paper_no" id="paper_no" class="form-control" required>
            <small id="checkpaper_no"></small>
        </div> --}}
        <!-- <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">จำนวนครั้งที่แก้ไข</label>
            <input type="text" id="edit_times" class="form-control">
            <small id="checkedit_times"></small>
        </div> -->
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
            <label for="" class="form-label">วันที่นำเข้า (ค.ศ.)</label>
            <input type="date" name="date" id="date" class="form-control" required>
            <small id="checkdate"></small>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
            <label for="" class="form-label">แบรนด์สินค้า</label>
            <select name="" id="brand_vendor_id" class="form-control select2">
                @foreach ( $brands as $brand )
                {{-- @if ($brand->type == 1) --}}
                <option value="{{$brand->id}}">{{$brand->brand}}</option>
                {{-- @endif --}}

                @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
            <label for="" class="form-label">บริษัทขนส่ง</label>
            <select name="" id="logistic_vendor_id" class="form-control select2">
                @foreach ( $vendors as $brand )
                @if ($brand->type == 2)
                <option value="{{$brand->id}}">{{$brand->brand}}</option>
                @endif

                @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
            <label for="" class="form-label">หมายเลข PO</label>
            <input type="text" name="po_no" id="po_no" class="form-control" required>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
            <label for="" class="form-label">เอกสาร PO <span class="text-danger">(*เฉพาะไฟล์นามสกุล jpg,png เท่านั้น)</span></label>
            <input type="file" id="po_file" name="po_file" class="form-control" required>
            <small id="checkdate"></small>
        </div>
    </div>
</form>
<hr class="my-4">

<div class="row">

    <div class="col-12">

        <div class="card card-outline card-gdp">
            <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                    <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รับเข้าบรรจุภัณฑ์ </h6>
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

                <table id="receive_packaging_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="">
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">รายการวัตถุดิบ</th>
                            <th scope="col" class="w-auto">บริษัท</th>
                            <th scope="col" class="w-auto">หมายเลข Lot</th>
                            <th scope="col" class="w-auto">จำนวน ชิ้น.</th>
                            <th scope="col" class="w-auto">MFG.</th>
                            <th scope="col" class="w-auto">EXP.</th>
                            <th scope="col" class="w-auto">ใบ COA</th>
                            <th scope="col" class="w-auto">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>

        </div>
        <div style="text-align: right;">
            <button class="btn ogn-stock-grey text-black btn-back"><em class="fas fa-arrow-left"></em> ย้อนกลับ</button>
            <button class="btn ogn-stock-green text-white" id="create_receive_packaging2"><em class="fas fa-save"></em> บันทึก</button>
        </div>
    </div>
</div>

    </div> {{-- cardbody --}}
</div>


<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false"  aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        <label for="" class="form-label">รายการบรรจุภัณฑ์</label>
                        <br>
                        <select name="" id="packaging_id" class="form-control select2 w-100" style="width: 100%">
                            @foreach ( $packagings as $packaging )
                            @if ($packaging->is_active == 1)
                            <option value="{{$packaging->id}}">{{$packaging->name}}</option>
                            @endif

                            @endforeach
                        </select>

                        <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                        <input type="hidden" name="id" id="id" value="">
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                        <label for="" class="form-label">บริษัท</label>
                        @php
                            $current_company = session('company')?:'';
                        @endphp
                        <select name="" id="company_id" class="form-control" disabled >
                            @foreach ( $companies as $company )

                            <option {{$current_company==$company->id?'selected':''}} value="{{$company->company_id}}">{{$company->company->name_th}}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                        <label for="" class="form-label">หมายเลข ล็อต</label>
                        <input type="text" id="lot" name="lot" class="form-control" required>
                        <small id="checklot"></small>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 p-2 ">
                        <div class="row">
                            <div class="col-12">
                                <label for="" class="form-label">จำนวน ชิ้น</label>
                                <input type="number" id="qty" name="qty" class="form-control" required>
                                <!-- <input type="datetime" name="" id=""> -->
                                <small id="checkexp"></small>
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">MFG.</label>
                                <input type="date" id="mfg" name="mfg" class="form-control" required>
                                <small id="checkmfg"></small>
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">EXP.</label>
                                <input type="date" id="exp" name="exp" class="form-control" required>
                                <!-- <input type="datetime" name="" id=""> -->
                                <small id="checkexp"></small>
                            </div>

                        </div>

                    </div>

                    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 p-2 ">
                        <label for="" class="form-label">ไฟล์ COA <span class="text-danger">(*เฉพาะไฟล์นามสกุล jpg,png เท่านั้น)</span></label>
                        <input type="file" id="coa" name="coa" class="dropify" data-height="160" >

                        <small id="checkcoa"></small>
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

    var packaging = []

        $('.dropify').dropify();
        let receive_packaging_table = $('#receive_packaging_table').DataTable({
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
                    targets: [4, 5, 6]

                }
            ],
            "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">'
        });

        $('.add-to-table2').on('click', function(){

            if ($('#form_valid').valid()) {

            var    packaging_id= $('#packaging_id').val();
            var    packaging_name= $('#packaging_id option:selected').text();
            var    company_name= $('#company_id option:selected').text();
            var    company_id= $('#company_id').val();
            var    lot= $('#lot').val();
            var    qty= $('#qty').val();
            var    exp= $('#exp').val();
            var    mfg= $('#mfg').val();
            var    coa= $('#coa').val();
            var index = receive_packaging_table.rows().count();
            var file_row = '<td><span class=" pack_coa pack_hide " data-check="0" id="field2_area'+index+'"></span><span class="badge bg-warning text-dark ">ยังไม่เพิ่มเอกสาร</span></td>';
            if($('#coa').val() != ""){
              file_name = $('#coa').prop('files')[0].name;
              file_row = '<td>'+'<span class=" pack_coa pack_hide" data-check="1" id="field2_area'+index+'"></span>'+'<span class="badge badge-success  "><em class="fas fa-paperclip p-1"></em>'+file_name+'</span></td>';
            }

            check_duplicate_numberlot()
            status = check_duplicate_numberlot();
                if(status === "true"){
                    var coa_copy = $('#coa').clone();
                    coa_copy.attr('id', 'field'+index);
                    coa_copy.addClass('pack_coa pack_hide');

                    var row = receive_packaging_table.row.add([
                        '<td><a class="list_cancel" style="cursor: pointer;"><i class="fas fa-times text-red"></i></a></td>',
                        '<td><span class="pack_id pack_hide ">'+packaging_id +'</span><span class="pack_id_text">'+packaging_name+'</span></td>',
                        '<td><span class="pack_com_id pack_hide ">'+company_id  +'</span>'+company_name+'</td>',
                        '<td><span class="pack_lot ">'+lot +'</span></td>',
                        '<td><span class="pack_qty ">'+qty +'</span></td>',
                        '<td><span class="pack_mfg ">'+mfg +'</span></td>',
                        '<td><span class="pack_exp ">'+exp +'</span></td>',
                        file_row,
                        '<td><a data-toggle="tooltip" data-placement="top" title="แก้ไข" type="" style="cursor: pointer;"  id="open-edit-modal"  class="  open-edit-modal  " ><i class="fas fa-edit text-success p-1"></i> </a></td>'
                    ]).draw(false).nodes()
                    .to$()
                    .addClass( 'packagingrow' )
                    coa_copy.insertAfter($('#field2_area'+index))
                    $(".clear-modal").click();
                }else {
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

        function check_duplicate_numberlot(){
            status = true;
            var lot= $('#lot').val();
            if (lot != "" || null) {
                $('.packagingrow').each(function(index,value){
                        if ( lot === $(value).find('.pack_lot').text()) {
                            status = false
                        }
                    })

                    $('.packagingrowold').each(function(index,value){
                        if ( lot === $(value).find('.pack_lot').text()) {
                            status = false
                        }
                    })
            }
            return status;
        }

        $(".clear-modal").on('click', function() {
            $(this).closest('.modal').find(".dropify-clear").click();
            $('#packaging_name').val(""),
            $('#company_name').val(""),
            $('#lot').val(""),
            $('#qty').val("0"),
            $('#exp').val(""),
            $('#mfg').val(""),
            $("#myModal").modal("hide");
        });

        $('#receive_packaging_table tbody').on('click', '.list_cancel', function() {
            var index = receive_packaging_table.row($(this).parents('tr'));
            var rowindex = index.index();
            receive_packaging_table
                .row($(this).parents('tr'))
                .remove()
                .draw();
            packaging.splice(rowindex, 1);
        });

        $('#create_receive_packaging2').on('click', function() {

            if ($('#receive_valid').valid()) {

            var formdata_receive = new FormData();
            // formdata_receive.append('username', 'Chris');
            // formdata_receive.append('paper_no', $('#paper_no').val());
            formdata_receive.append('edit_times', $('#edit_times').val());
            formdata_receive.append('date', $('#date').val());
            formdata_receive.append('brand_vendor_id', $('#brand_vendor_id').val());
            formdata_receive.append('logistic_vendor_id', $('#logistic_vendor_id').val());
            formdata_receive.append('_token', $('#_token').val());
            formdata_receive.append('id', $('#id').val());
            formdata_receive.append('user_id', $('#user_id').val());
            formdata_receive.append('po_no', $('#po_no').val());
            formdata_receive.append('po_file', $('#po_file').prop('files')[0]);
            formdata_receive.append('company_id', {{session('company')}});
            $('.packagingrow').each(function(index,value){


                if($(value).find('.pack_coa').data("check") == 1){
                    formdata_receive.append('packaging['+index+'][coa]',$(value).find('input.pack_coa').prop('files')[0])
                }
                formdata_receive.append('packaging['+index+'][packaging_id]',$(value).find('.pack_id').text())
                formdata_receive.append('packaging['+index+'][company_id]',$(value).find('.pack_com_id').text())
                formdata_receive.append('packaging['+index+'][lot]',$(value).find('.pack_lot').text())
                formdata_receive.append('packaging['+index+'][qty]',$(value).find('.pack_qty').text())
                formdata_receive.append('packaging['+index+'][mfg]',$(value).find('.pack_mfg').text())
                formdata_receive.append('packaging['+index+'][exp]',$(value).find('.pack_exp').text())
            })
            var row_packaging = receive_packaging_table.rows().count();
                if (row_packaging > 0) {
                    Swal.fire({
                                title: 'ยืนยันการนำเข้าบรรจุภัณฑ์?',
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
                                        url: "{{route('api.v1.receive.packaging.create')}}",
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
                                                window.location.assign("{{ route('packaging') }}")
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
                                title: 'กรุณาเพิ่มรายการนำเข้าบรรจุภัณฑ์',
                                showConfirmButton: false,
                                timer: 1500
                            })
                }

            }

        })
        $('.btn-back').on('click',function(){
            window.history.back();
        });

        $(document).on('click','.open-edit-modal', function() {
            var data = receive_packaging_table.row($(this).parents('tr'))
            var receive = data.data()
            var currentPage = receive_packaging_table.page();
            // var index = receive_packaging_table.row($(this));
            var     index = data.index(),
                    rowCount = receive_packaging_table.data().length-1,
                    insertedRow = receive_packaging_table.row(rowCount).data(),
                    tempRow;

            let in_html =   `   <form name="validForm">
                                    <div class="row mb-2">
                                        <input class="form-control dropify coa_update" type="file" name="coa_update" id="coa_update"  required>
                                    </div>
                                </form>
                            `
                                Swal.fire({
                    title: "กรุณาเพิ่มไฟล์เอกสาร COA",
                    html: in_html,
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ปิด',
                    confirmButtonColor: '#649514',
                    cancelButtonColor: '#a97551',
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleterow(index)
                        console.log(receive);
                        var receive_packaging_id = $(receive[1]).find('.pack_id').text();
                        var receive_packaging_name = $(receive[1]).find('.pack_id_text').text();
                        var company_id = $(receive[2]).find('.pack_com_id').text();
                        var lot = $(receive[3]).text();
                        var qty = $(receive[4]).text();
                        var exp = $(receive[5]).text();
                        var mfg = $(receive[6]).text();
                        var coa = $(receive[7]).text();
                            var file = $('#coa_update').val()
                            var coa_copy = $('#coa_update').clone();
                            var file_name = $('#coa_update').prop('files')[0].name;
                            coa_copy.attr('id', 'field'+index);
                            coa_copy.addClass('pack_coa pack_hide');
                            receive_packaging_table.row.add([
                                `<td><a class="list_cancel" style="cursor: pointer;"><i class="fas fa-times text-red"></i></a></td>`,
                                `<td><span class="pack_id pack_hide ">${receive_packaging_id}</span><span class="pack_id_text">${receive_packaging_name}</span></td>`,
                                '<td><span class="pack_com_id pack_hide ">'+company_id  +'</span>'+$('#company_id option:selected').text()+'</td>',
                                '<td><span class="pack_lot ">'+lot +'</span></td>',
                                '<td><span class="pack_qty ">'+qty +'</span></td>',
                                '<td><span class="pack_exp ">'+exp +'</span></td>',
                                '<td><span class="pack_mfg ">'+mfg +'</span></td>',
                                '<td>'+'<span class=" pack_coa pack_hide" data-check="1" id="field2_area'+index+'"></span>'+'<span class="badge badge-success  "><em class="fas fa-paperclip p-1"></em>'+file_name+'</span></td>',
                                '<td><a data-toggle="tooltip" data-placement="top" title="แก้ไข" type="" style="cursor: pointer;"  id="open-edit-modal"  class="  open-edit-modal  " ><i class="fas fa-edit text-success p-1"></i> </a></td>'
                            ]).draw(false).nodes()
                            .to$()
                            .addClass( 'packagingrow' )
                            coa_copy.insertAfter($('#field2_area'+index))
                    }
                });
        })

        function deleterow (row){
                receive_packaging_table
                        .row(row)
                        .remove()
                        .draw();
        }

    });
</script>
@endsection
