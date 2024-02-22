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
                <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>
                <li class="breadcrumb-item active">รับเข้าบรรจุภัณฑ์</li>
            </ol>
        </div><!-- /.col -->
        <div >
            <br>
            <a class="btn ogn-stock-yellow " href="{{route('receive.packaging.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a>
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
                            <th scope="col" class="w-auto">แก้ไขครั้งที่เท่าไร</th>
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
                    'url':'{{route(('api.v1.receive.packaging.list'))}}',
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
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt" ></a></div>`;
                        }
                    },

                    { data: 'id', class: 'd-flex',
                    render : function(data,type,row,meta){
                        confirm_check = "btn-update-inspect_ready"
                        text_color = "text-success"
                        $.each(row.packaging_lots,function(key,lot){
                            if ( lot.transport_check === 0 ){
                                confirm_check = ""
                                text_color = "text-gray"
                            }
                        })

                        apply_next = `<a type="button"  style="" id="myModal-edit" data-id="${row.id}"  class= "reset-me btn-modal ${confirm_check}" data-toggle="tooltip" data-placement="top" title="ส่งต่อเพื่อตรวจสอบ" ><i class="fas fa-arrow-circle-right p-1 ${text_color}"></i> </a>`;

                        let url2 = "{{ route('receive.packaging.edit', "__id") }}".replaceAll("__id",row.id);
                        let url3 = "{{ route('receive.packaging.history', "__id") }}".replaceAll("__id",row.id);
                        if (row.edit_times != 0) {

                        action = `<a data-toggle="tooltip" data-placement="top" title="ประวัติการแก้ไข" type="" style="" href="${url3}"  data-id="${row.id}" id="myModal-edit"  class=" reset-me btn-modal "  ><i class="fas fa-history p-1 text-indigo"></i> </a>`;
                        } else {
                        action = '<a type="" style=""  id="myModal-edit"  class= "reset-me btn-modal " ><i class="fas fa-history p-1 text-muted"></i> </a>';
                        }


                        return `<div class=" w-100 m-auto" style="text-align:center;">
                                <a data-toggle="tooltip" data-placement="top" title="แก้ไข" type="" style="" href="${url2}"  data-id="${row.id}" id="myModal-edit"  class=" reset-me btn-modal  " ><i class="fas fa-edit text-warning p-1"></i> </a>
                                ${action}
                                <a type="" style="cursor: pointer;" data-id="${row.id}" id="myModal-edit"  class="buttom_delete reset-me btn-modal  "><i class="fas fa-trash p-1 text-danger "></i> </a>
                                ${apply_next}
                        </div>`;
                    }
                    },

                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    { responsivePriority: 1, targets: [0,1,2] }
                ],
                drawCallback: function( settings ) {

                    @cannot('admin')
                        $('.buttom_delete').remove();
                    @endcan

                },
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
                    lot = receive_item.lot;
                    name_packaging = receive_item.packaging.name;

                    coa = receive_item.coa;
                    exp = receive_item.exp;
                    mfg = receive_item.mfg;
                    action = receive_item.action;
                    ref = "{{asset('uploads/coa_packaging/')}}";
                    qty = receive_item.qty
                    transport_check = receive_item.transport_check;
                    id = receive_item.id

                    let url3 = "{{ route('receive.packaging.view.check.vehicle', "__id") }}".replaceAll("__id",id);
                    if (action == 1) {
                       action = "<td><span class='badge badge-pill ogn-stock-grey' style='text-align : center;'>รออนุมัติ</span> </td>"
                    } else {
                        action = "<td><span class='badge badge-pill ogn-stock-green' style='text-align : center;'>อนุมัติแล้ว</span> </td>"
                    }

                    if (transport_check == 0) {
                       transport_check = "<span class='badge badge-pill w-75' style='text-align : center;font-size:15px;'>รอการตรวจสอบสภาพขนส่ง</span> "
                       actionBtn1 = `<a type="button" style="font-size:14px;" href="${url3}" data-id="${id}" class="btn btn-sm ogn-stock-grey rounded-pill ml-1"><em class="fas fa-truck"></em> ตรวจ</a>`
                    }
                    if (transport_check == 1) {
                       transport_check = "<span class='badge badge-pill text-success w-75' style='text-align : center;font-size:15px;'>ตรวจสอบสภาพขนส่งแล้ว</span> "
                       actionBtn1 = `<a type="button" style="font-size:14px;" href="${url3}" data-id="${id}" class="btn btn-sm ogn-stock-yellow rounded-pill  ml-1" ><em class="fas fa-truck"></em> แก้ไข</a>`
                    }
                    //loop table

                    if (coa == "0" || coa == null){
                        action2 = '<td style="text-align:center;"> <span class="badge bg-warning text-dark">ยังไม่เพิ่มเอกสาร</span>'+'</td>'
                    } else {
                        action2 = '<td style="text-align:center;"> <a class=" "  href=" ' + ref +'/'+ coa +' " download><i class="fas fa-download p-1 "></i></a>'+'</td>'

                    }

                    loop_table =    '<tr>'+

                                        '<td>'+lot+'</td>'+

                                        '<td>'+name_packaging+'</td>'+
                                        '<td class="text-center">'+actionBtn1+'</td>'+
                                        '<td style="text-align:center;">'+qty+' ชิ้น'+'</td>'+
                                        '<td style="text-align:center;">'+mfg+'</td>'+
                                        '<td style="text-align:center;">'+exp+'</td>'+

                                        action2+
                                        action +

                                    '</tr>';
                    table_body += loop_table;
                });
                var inner_table = `<table class="w-100">
                    <tr>
                        <th style='width:30%'>ล็อตสินค้า</th>
                        <th style='width:18%'>ชื่อบรรจุภัณฑ์</th>
                        <th style='width:20%' class="text-center">ตรวจสภาพขนส่ง</th>
                        <th style='width:20%' class="text-center">จำนวน</th>
                        <th style='width:20%' class="text-center">MFG.</th>
                        <th style='width:20%' class="text-center">EXP.</th>
                        <th style='width:27%' class="text-center">ใบ COA</th>
                        <th style='width:35%' class="text-center">สถานะ</th>
                    </tr>
                    ${table_body}
                </table>`;

                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"> <caption class="text-center text-dark text-bold pt-0">รายละเอียดบรรจุภัณฑ์นำเข้า</caption>'+inner_table+'</table>';

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

            $(document).on('click','.btn-update-inspect_ready',function(){
            const id = $(this).data('id');
            Swal.fire({
                    title: 'ยืนยันการส่งต่อเพื่อทำการตรวจสอบ?',
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
                            url: "{{route('api.v1.receive.packaging.edit.inspect.ready')}}",
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

            $(document).on('click','.buttom_delete',function(){
            const id = $(this).data('id');
            Swal.fire({
                    title: 'ยืนยันการลบ?',
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
                            url: "{{route('api.v1.receive.packaging.delete')}}",
                            data: {'id':id},
                            dataType: "json",
                            success: function (response) {
                                if (response) {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'success',
                                        title: 'ลบสำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500,

                                    })
                                    receive_packaging_table.ajax.reload();
                                } else {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'warning',
                                        title: 'ลบไม่สำเร็จ',
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
