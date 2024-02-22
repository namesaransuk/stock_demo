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
</style>
@endsection

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>
                <li class="breadcrumb-item active">รับเข้าบรรจุภัณฑ์</li>
            </ol>
        </div><!-- /.col -->
        <div >
            <br>

        </div>
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-gdp">
            <!-- <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                    <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รับเข้าวัตถุดิบ และ บรรจุภัณฑ์</h6>
                </div> -->
            <!-- <div class="p-2">
                    <div class="float-right">
                        <input type="search" id="custom-search-input" class="form-control form-control-sm"
                               placeholder="ค้นหา">
                    </div>
                    <a href="" type="button" style=""
                       class="btn rounded ml-2"><em class="fas fa-plus-circle text-success"></em>
                        เพิ่มรายการ</a>
                    <div class="card-title mb-0"></div>
                </div> -->
            <div class="card-body p-0">

                <table id="receive_packaging_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow">
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่รับเข้า</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">แก้ไขครั้งที่</th>
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



@endsection

@section('js')
<script>
    $(function() {
        $('.dropify').dropify();

        let receive_packaging_table =$('#receive_packaging_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.receive.packaging.inspect.list'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id' },
                    { data: 'date' },
                    { data: 'paper_no' },
                    { data: 'edit_times' },
                    { data: 'id',render : function(data,type,row,meta){
                            return row.logistic_vendor.brand;
                    } },
                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt " ></a></div>`;
                        }
                    },
                    {
                        "data": 'id', class: 'd-flex',
                        render : function(data, type, row, meta){
                                    let check_confirm = "";
                                    $.each(row.packaging_lots,function(key,lot){
                                        console.log("lot-id" + lot.id + " " + lot.quality_check + " " + lot.transport_check);
                                        if ( lot.quality_check === 0 ){
                                            check_confirm = "disabled";
                                        }
                                    })
                            return  `
                            <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-danger reject-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-times-circle"></i> ปฏิเสธการรับเข้า</a>
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-warning return-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-left"></i> ส่งกลับไปแก้ไข</a>
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-success ${check_confirm} confirm-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-right"></i> ยืนยันตรวจสอบ</a>
                                    `
                                        // <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-danger cancel-btn btn-sm rounded-pill w-75  border ml-1"><i class="fas fa-times"></i> ตีกลับ </a>
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
                var receivepackagings = receive.packaging_lots;
                var lot;
                var name_packaging;
                var total_weight;
                var coa;
                var exp;
                var mfg;

                var loop_table;
                var table_body = "";
                var table;

                receivepackagings.forEach(receive_item => {
                    console.log(receive_item)

                    lot = receive_item.lot;
                    name_packaging = receive_item.packaging.name;
                    coa = receive_item.coa;

                    exp = receive_item.exp;
                    mfg = receive_item.mfg;
                    action = receive_item.action;
                    id = receive_item.id
                    ref = "{{asset('uploads/coa_packaging/')}}";
                    qty = receive_item.qty
                    quality_check = receive_item.quality_check;
                    transport_check = receive_item.transport_check;
                    let url = "{{ route('receive.packaging.view.check.packaging', "__id") }}".replaceAll("__id",id);
                    let url2 = "{{ route('receive.packaging.view.check.vehicle', "__id") }}".replaceAll("__id",id);
                    if (quality_check == 0) {
                       quality_check = "<span class='badge badge-pill w-75' style='text-align : center;font-size:15px;'>รอการตรวจสอบคุณภาพ</span>"
                       actionBtn2 = `<a type="button" style="font-size:14px;" href="${url}" data-id="${id}" class="btn btn-sm ogn-stock-green rounded-pill ml-1"><em class="fas fa-check-double"></em> คุณภาพ</a>`
                    }
                    if (quality_check == 1) {
                       quality_check = "<span class='badge badge-pill btn-sm text-success w-75' style='text-align : center;font-size:15px;'>ตรวจสอบคุณภาพแล้ว</span>"
                       actionBtn2 = `<a type="button" style="font-size:14px;" href="${url}" data-id="${id}" class="btn btn-sm bg-warning rounded-pill ml-1" ><em class="fas fa-edit"></em> แก้ไขตรวจสอบคุณภาพ</a>`
                    }

                    if (transport_check == 0) {
                       transport_check = "<span class='badge badge-pill w-75' style='text-align : center;font-size:15px;'>รอการตรวจสอบสภาพขนส่ง</span> "
                       actionBtn1 = `<a type="button" style="font-size:14px;" href="${url2}" data-id="${id}" class="btn btn-sm ogn-stock-green rounded-pill ml-1"><em class="fas fa-truck"></em> สภาพขนส่ง</a>`
                    }
                    if (transport_check == 1) {
                       transport_check = "<span class='badge badge-pill text-success w-75' style='text-align : center;font-size:15px;'>ตรวจสอบสภาพขนส่งแล้ว</span> "
                       actionBtn1 = `<a type="button" style="font-size:14px;" href="${url2}" data-id="${id}" class="btn btn-sm bg-warning rounded-pill  ml-1" ><em class="fas fa-edit"></em> แก้ไขตรวจสอบสภาพขนส่ง</a>`
                    }
                    //loop table

                    loop_table =    '<tr>'+
                                        '<td>'+lot+'</td>'+
                                        '<td>'+name_packaging+'</td>'+
                                        '<td>'+qty+' ชิ้น'+'</td>'+
                                        '<td>'+mfg+'</td>'+
                                        '<td>'+exp+'</td>'+
                                        '<td class="text-center">'+quality_check+'</td>'+
                                        '<td class="text-center">'+actionBtn2+'</td>'+
                                    '</tr>';
                    table_body += loop_table;
                });
                var inner_table = `<table class="w-100">
                    <tr>
                        <th style='width:15%'>ล็อต</th>
                        <th style='width:15%'>ชื่อบรรจุภัณฑ์</th>
                        <th style='width:15%'>จำนวน</th>
                        <th style='width:10%'>mfg</th>
                        <th style='width:10%'>exp</th>
                        <th style='width:20%' class="text-center">สถานะ</th>
                        <th style='width:30%' class="text-center">ตรวจสอบ</th>
                    </tr>
                    ${table_body}
                </table>`;

                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"><caption class="text-center text-dark text-bold pt-0">รายละเอียดบรรจุภัณฑ์นำเข้า</caption> '+inner_table+'</table>';

                return table;
            }

            $('#receive_packaging_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = receive_packaging_table.row( tr );
                console.log(receive_packaging_table)
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

            $(document).on('click','.confirm-btn',function(){
                const id = $(this).data('id');
                Swal.fire({
                        title: 'ยืนยันการส่งต่อเพื่อทำการกรอก Lot.No PM?',
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
                                url: "{{route('api.v1.receive.packaging.step.lotnopm')}}",
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

            $(document).on('click','.return-btn',function(){
                const id = $(this).data('id');
                Swal.fire({
                        title: 'ยืนยันการตีกลับไปหน้ารับเข้า?',
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
                                url: "{{route('api.v1.receive.packaging.step.back.to.receive')}}",
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
                        title: 'ยืนยันปฏิเสธการรับเข้า?',
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
                                url: "{{route('api.v1.receive.packaging.reject')}}",
                                data: {'id':id},
                                dataType: "json",
                                success: function (response) {
                                    if (response) {
                                        Swal.fire({
                                            position: 'center-center',
                                            icon: 'success',
                                            title: 'ทำรายการสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500,

                                        })
                                        receive_packaging_table.ajax.reload();
                                    } else {
                                        Swal.fire({
                                            position: 'center-center',
                                            icon: 'warning',
                                            title: 'ทำรายการไม่สำเร็จ',
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
