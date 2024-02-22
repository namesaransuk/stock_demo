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
                <li class="breadcrumb-item active">รับเข้าสินค้า</li>
            </ol>
        </div><!-- /.col -->
        <div >
            <br>
            <!-- <a class="btn ogn-stock-yellow " href="{{route('receive.product.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a> -->
            <!-- <button type="button"  data-toggle="modal" data-target="#myModal"></button> -->
        </div>
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-gdp">
            <!-- <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                    <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รับเข้าวัตถุดิบ และ สินค้า</h6>
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

                <table id="receive_product_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow">
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่รับเข้า</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">แก้ไขครั้งที่</th>
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

        let receive_product_table =$('#receive_product_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.receive.product.check.list'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id' },
                    { data: 'date' },
                    { data: 'paper_no' },
                    { data: 'edit_times', class: 'text-center' },

                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt" ></a></div>`;
                        }
                    },
                    {
                        "data": 'id', class: 'd-flex',
                        render : function(data, type, row, meta){
                                    let check_confirm = "";
                                    $.each(row.product_lots,function(key,lot){
                                        if ( lot.quality_check === 0){
                                            check_confirm = "disabled";
                                        }
                                    })
                            return  `
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-warning return-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-left"></i> ส่งกลับไปแก้ไข</a>
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-success ${check_confirm} confirm-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-right"></i> ยืนยันตรวจสอบ</a>
                                    `
                                        // <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-danger reject-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-times-circle"></i> ปฏิเสธการรับเข้า</a>
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
                console.log(receive)
                var receiveproducts = receive.product_lots;
                var lot;
                var name_product;
                var total_weight;
                var coa;
                var exp;
                var mfg;

                var loop_table;
                var table_body = "";
                var table;

                receiveproducts.forEach(receive_item => {
                    console.log(receive_item)
                    lot = receive_item.lot;
                    name_product = receive_item.product.name;

                    // console.log(total)
                    exp = receive_item.exp;
                    mfg = receive_item.mfg;
                    action = receive_item.action;
                    id = receive_item.id
                    ref = "{{asset('uploads/coa_product/')}}";
                    qty = receive_item.qty
                    quality_check = receive_item.quality_check;
                    transport_check = receive_item.transport_check;
                    if (action == 1) {
                       action = "<td>สถานะ : <span class='badge badge-pill ogn-stock-grey' style='text-align : center;'>รออนุมัติ</span> </td>"
                    } else {
                        action = "<td>สถานะ : <span class='badge badge-pill ogn-stock-green' style='text-align : center;'>รออนุมัติ</span> </td>"
                    }

                    let url = "{{ route('receive.product.view.check.product', "__id") }}".replaceAll("__id",id);
                    if (quality_check == 0) {
                       quality_check = "<span class='badge badge-pill w-75' style='text-align : center;font-size:15px;'>รอการตรวจสอบคุณภาพ</span>"
                       actionBtn2 = `<a type="button" style="font-size:14px;" href="${url}" data-id="${id}" class="btn btn-sm ogn-stock-green rounded-pill ml-1"><em class="fas fa-check-double"></em> คุณภาพ</a>`
                    }
                    if (quality_check == 1) {
                       quality_check = "<span class='badge badge-pill btn-sm text-success w-75' style='text-align : center;font-size:15px;'>ตรวจสอบคุณภาพแล้ว</span>"
                       actionBtn2 = `<a type="button" style="font-size:14px;" href="${url}" data-id="${id}" class="btn btn-sm bg-warning rounded-pill ml-1" ><em class="fas fa-edit"></em> แก้ไขตรวจสอบคุณภาพ</a>`
                    }

                    loop_table =    '<tr>'+
                                        '<td>'+lot+'</td>'+
                                        '<td>'+name_product+'</td>'+
                                        '<td class="text-center">'+qty+' ชิ้น'+'</td>'+
                                        '<td class="text-center">'+mfg+'</td>'+
                                        '<td class="text-center">'+exp+'</td>'+
                                        '<td class="text-center">'+quality_check+'</td>'+
                                        '<td class="text-center">'+actionBtn2+'</td>'+
                                    '</tr>';
                    table_body += loop_table;
                });

                var inner_table = `<table class="w-100">
                    <tr>
                        <th style='width:15%'>ล็อตสินค้า</th>
                        <th style='width:15%'>ชื่อสินค้า</th>
                        <th style='width:15%' class="text-center">จำนวน</th>
                        <th style='width:10%' class="text-center">MFG.</th>
                        <th style='width:10%' class="text-center">EXP.</th>
                        <th style='width:15%' class="text-center">สถานะ</th>
                        <th style='width:20%' class="text-center">จัดการ</th>
                    </tr>
                    ${table_body}
                </table>`;

                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"> <caption class="text-center text-dark text-bold pt-0">รายละเอียดการนำเข้าสินค้า</caption>'+inner_table+'</table>';


                return table;
            }

            $('#receive_product_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = receive_product_table.row( tr );
                console.log(receive_product_table)
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
                                url: "{{route('api.v1.receive.product.step.pending')}}",
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
                                        receive_product_table.ajax.reload();
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
                                url: "{{route('api.v1.receive.product.step.back.to.receive')}}",
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
                                        receive_product_table.ajax.reload();
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
