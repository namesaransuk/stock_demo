@extends('adminlte::page')

@section('css')
<style>
    .modal-full {
        min-width: 85%;
        margin-left: 80;
    }

    .template_row:first-child {
        display: none;
        margin: 0 auto;
    }

    /* tooltip */


</style>
@endsection

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>

                <li class="breadcrumb-item active">LOT NO PM บรรจุภัณฑ์</li>
            </ol>
        </div><!-- /.col -->
        <div >
            <br>
            <!-- <a class="btn ogn-stock-yellow " href="{{route('receive.packaging.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a> -->
            <!-- <button type="button"  data-toggle="modal" data-target="#myModal"></button> -->
        </div>
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-gdp">
            <div class="card-body p-0">
                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">

                <table id="receive_packaging_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่รับเข้า</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">บริษัทขนส่ง</th>
                            <th scope="col" class="w-auto">รายละเอียด</th>
                            <th scope="col" class="w-auto">จัดการ</th>

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- hovercard --}}



@endsection

@section('js')
<script>
    $(function() {
        $('.dropify').dropify();
        $('.select2').select2()

        let receive_packaging_table =$('#receive_packaging_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.receive.packaging.lot.no.pm.list'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id' },
                    { data: 'date' },
                    { data: 'paper_no' },
                    { data: 'id',render : function(data,type,row,meta){
                            return row.logistic_vendor.brand;
                    } },
                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            return `<div style="text-align:center;"><a href="#"  class="details-control fas fa-list-alt text-lg text-ogn-green" ></a></div>`;
                        }
                    },
                    {
                        "data": 'id', class: 'd-flex',
                        render : function(data, type, row, meta){
                            let confirm_check = true;
                            $.each(row.packaging_lots,function(key,lot){
                                if ( lot.lot_no_pm == null || lot.lot_no_pm == "ยังไม่ระบุ"){
                                    confirm_check = false;
                                }
                            })
                            if (confirm_check){
                                $(".confirm_lot_"+row.id).removeClass('disabled')
                            } else {
                                $(".confirm_lot_"+row.id).addClass('disabled')
                            }

                            return  `
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-danger reject-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-left"></i> ตีกลับไปตรวจสอบ</a>
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-success confirm-btn btn-xs rounded-pill disabled confirm_lot_${row.id}  border ml-1"><i class="fas fa-arrow-circle-right"></i> เสร็จสิ้นการรับเข้า</a>
                                    `
                        }
                    },

                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    { responsivePriority: 1, targets: [0,1,2] }
                ],
                // language: {
                //     "url": "{{ asset('/vendor/datatables/th.json') }}"
                // },
                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
        })

                    //ส่วนแสดงตารางรายละเอียด
            function format ( receive ) {
                // console.log(receive.packaging_lots)
                var receivePackagings = receive.packaging_lots;
                var id;
                var lot;
                var name_packaging;
                var total_weight;
                var coa;
                var exp;
                var mfg;

                var loop_table;
                var table_body = "";
                var table;

                receivePackagings.forEach(receive_item => {
                    console.log(receive_item);
                    id = receive_item.id;
                    lot = receive_item.lot;
                    name_packaging = receive_item.packaging.name;
                    qty = parseFloat(receive_item.qty);
                     let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                     let total = formatter.format(qty);
                    // console.log(total)
                    coa =  receive_item.coa;
                    exp = receive_item.exp;
                    mfg = receive_item.mfg;
                    lot_no_pm = receive_item.lot_no_pm;
                    ref = "{{asset('uploads/coa_packaging/')}}";



                    if (lot_no_pm != null) {
                        field_lot_no_pm = `<span class='badge badge-pill btn-sm lot_span' style='text-align : center;font-size:15px;'>${lot_no_pm}</span>` ;
                    } else {
                        field_lot_no_pm = `<span class='badge badge-pill btn-sm lot_span' style='text-align : center;font-size:15px;'>ยังไม่ระบุ</span>`;
                    }

                    //loop table

                    loop_table =    '<tr>'+
                                        '<td>'+lot+'</td>' +
                                        '<td>'+name_packaging+'</td>'+
                                        '<td>'+qty+' ชิ้น </td>'+
                                        '<td>'+mfg+'</td>'+
                                        '<td>'+exp+'</td>'+
                                        '<td class="text-center">'+field_lot_no_pm+'</td>'+
                                        '<td class="text-center"><a data-toggle="tooltip" data-placement="top" title="เพิ่มหมายเลข Lot.No. PM" type="button" style="" data-row-id="'+receive_item.receive_packaging_id+'" data-id="'+id+'" class="add-lot-pm"><i class="fas fa-edit text-warning"></i></a></td>'+
                                    '</tr>';
                    table_body += loop_table;
                });

                var inner_table = `<table class="w-100">
                    <tr>
                        <th style='width:15%'>ล็อต</th>
                        <th style='width:20%'>ชื่อบรรจุภัณฑ์</th>
                        <th style=''>จำนวน</th>
                        <th style=''>mfg</th>
                        <th style=''>exp</th>
                        <th style='' class="text-center">Lot. No. PM</th>
                        <th style='width:22%' class="text-center">จัดการ</th>
                    </tr>
                    ${table_body}
                </table>`;

                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"><caption class="text-center text-dark text-bold pt-0">รายละเอียด</caption>'+inner_table+'</table>';

                return table;
            }

            $('#receive_packaging_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = receive_packaging_table.row( tr );
                // console.log(receive_packaging_table)
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    row.child().addClass('bg-gradient-light')
                    tr.addClass('shown');
                }
            } );

            $(document).on("click",".add-lot-pm",function(e) {

                let obj = $(this);
                const id = obj.data('id');
                const row_id = obj.data('row-id');
                var formData = new FormData();

                Swal.fire({
                    title: "กรุณากรอก Lot No PM",
                    input: 'text',
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ปิด',
                    confirmButtonColor: '#649514',
                    cancelButtonColor: '#a97551',
                }).then((result) => {
                    if (result.value) {
                        formData.append("id", id);
                        formData.append("lot_no_pm", result.value);
                        formData.append("_token", $('#_token').val());

                        $.ajax({
                            type: "post",
                            url: "{{route(('api.v1.receive.packaging.lot.no.pm.change'))}}",
                            data: formData,
                            contentType: false,
                            processData: false,
                            cache: false,
                            success: function (response) {
                                if (response) {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'success',
                                        title: 'เพิ่ม Lot No PM สำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500,

                                    })
                                    obj.closest('tr').find('.lot_span').text(result.value);
                                    let confirm_check = true;
                                    obj.closest('table').find('.lot_span').each(function(key,lot){
                                        if ($(lot).text() === "ยังไม่ระบุ" ){
                                            confirm_check = false;
                                        }
                                    });
                                    if (confirm_check){
                                        $(".confirm_lot_"+row_id).removeClass('disabled')
                                    } else {
                                        $(".confirm_lot_"+row_id).addClass('disabled')
                                    }
                                } else {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'warning',
                                        title: 'เพิ่ม Lot No PM ไม่สำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click','.confirm-btn',function(){
                const id = $(this).data('id');
                Swal.fire({
                        title: 'เสร็จสิ้นการรับเข้า?',
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
                                url: "{{route('api.v1.receive.packaging.step.pending')}}",
                                data: {'id':id},
                                dataType: "json",
                                success: function (response) {
                                    if (response) {
                                        Swal.fire({
                                            position: 'center-center',
                                            icon: 'success',
                                            title: 'ยืนยันสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500,

                                        })
                                        receive_packaging_table.ajax.reload();
                                    } else {
                                        Swal.fire({
                                            position: 'center-center',
                                            icon: 'warning',
                                            title: 'ยืนยันไม่สำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    }
                                }
                            });
                        }
                    });
            })

            $(document).on('click','.reject-btn',function(){
                const id = $(this).data('id');
                Swal.fire({
                        title: 'ยืนยันการตีกลับไปหน้าตรวจสอบ?',
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
                                url: "{{route('api.v1.receive.packaging.step.back.to.inspect')}}",
                                data: {'id':id},
                                dataType: "json",
                                success: function (response) {
                                    if (response) {
                                        Swal.fire({
                                            position: 'center-center',
                                            icon: 'success',
                                            title: 'ยืนยันสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500,

                                        })
                                        receive_packaging_table.ajax.reload();
                                    } else {
                                        Swal.fire({
                                            position: 'center-center',
                                            icon: 'warning',
                                            title: 'ยืนยันไม่สำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    }
                                }
                            });
                        }
                    });
            })



    });
</script>
@endsection
