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

                <li class="breadcrumb-item active">วัตถุดิบคงคลัง</li>
            </ol>
        </div><!-- /.col -->
        <div >
            <br>
            <a class="btn ogn-stock-yellow " href="{{route('requsition.supply.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a>
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
                    <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รับเข้าวัสดุสิ้นเปลือง และ วัสดุสิ้นเปลือง</h6>
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

                <table id="requsition_supply_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่เบิก</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">แก้ไขครั้งที่</th>
                            <th scope="col" class="w-auto">รายละเอียด</th>
                            <th scope="col" class="w-auto " style="text-align: center !important;">จัดการ</th>
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

        let requsition_supply_table =$('#requsition_supply_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.requsition.supply.list'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id' },
                    { data: 'date' },
                    { data: 'paper_no' },
                    { data: 'edit_times' , class: 'text-center'},
                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt" ></a></div>`;
                        }
                    },

                    { data: 'id', class: 'd-flex',
                    render : function(data,type,row,meta){
                        let url2 = "{{ route('requsition.supply.edit', "__id") }}".replaceAll("__id",row.id);
                        let url3 = "{{ route('requsition.supply.history', "__id") }}".replaceAll("__id",row.id);
                        if (row.edit_times != 0) {

                        action = `<a type="" style="" href="${url3}"  data-id="${row.id}" id="myModal-edit"  class=" reset-me btn-modal " ><i class="fas fa-history p-1 text-indigo"></i> </a>`;
                        } else {
                        action = '<a type="" style=""  id="myModal-edit"  class= "reset-me btn-modal " ><i class="fas fa-history p-1 text-muted"></i> </a>';
                        }
                        apply_next = `<a type="button"  style=""  id="myModal-edit" data-id="${row.id}" title="เสร็จสิ้นการเบิก" class= "btn-modal confirm-btn " ><i class="fas fa-arrow-circle-right p-1 text-success"></i> </a>`;
                        return `<div class=" w-100 m-auto" style="text-align:center;">
                                    <a type="" style="" href="${url2}"  data-id="${row.id}" id="myModal-edit"  class=" reset-me btn-modal  "><i class="fas fa-edit text-warning p-1"></i> </a>
                                    ${action}
                                    <a type="" style="cursor: pointer;"  data-id="${row.id}" id="myModal-edit"  class="buttom_delete reset-me btn-modal  "><i class="fas fa-trash p-1 text-danger "></i> </a>
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

                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
        })

                    //ส่วนแสดงตารางรายละเอียด
            function format ( receive ) {
                console.log(receive)
                var receive_supply = receive.supply_cut;
                var lot;
                var name_supply;
                var total_weight;
                var coa;
                var exp;
                var mfg;
                var action;
                var loop_table;
                var table_body = "";
                var table;

                receive_supply.forEach(receive_item => {
                    lot = receive_item.supply_lot.lot;
                    name_supply = receive_item.supply_lot.supply.name;
                    total_weight = parseFloat(receive_item.qty);
                     let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                     let total = formatter.format(total_weight);

                    mfg = receive_item.supply_lot.mfg
                    exp = receive_item.supply_lot.exp

                    ref = "{{asset('uploads/coa_supply/')}}";
                    action = receive_item.action


                    if (action == 1) {
                       action = "<td style='text-align:center;'> <span class='badge badge-pill ogn-stock-grey' style='text-align : center;'>รออนุมัติ</span> </td>"
                    } else {
                        action = "<td style='text-align:center;'> <span class='badge badge-pill ogn-stock-green' style='text-align : center;'>อนุมัติการเบิก</span> </td>"
                    }
                    //loop table

                    loop_table =    '<tr>'+

                                        '<td>'+lot+'</td>'+

                                        '<td>'+name_supply+'</td>'+
                                        '<td>'+total+' ชิ้น'+'</td>'+
                                        action +

                                    '</tr>';
                    table_body += loop_table;
                });

                var inner_table = `<table class="w-100">
                    <tr>
                        <th style='width:25%'>ล็อต</th>
                        <th style='width:25%'>ชื่อวัสดุสิ้นเปลือง</th>
                        <th style='width:10%' class="text-center">จำนวน</th>
                        <th style='width:10%;text-align:center;' class="text-center">สถานะ</th>
                    </tr>
                    ${table_body}
                </table>`;
                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"><caption class="text-center text-dark text-bold pt-0">รายละเอียดการเบิกวัสดุสิ้นเปลือง</caption> '+inner_table+'</table>';

                return table;
            }

            $('#requsition_supply_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = requsition_supply_table.row( tr );

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
                                url: "{{route('api.v1.requsition.supply.step.to.history')}}",
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
                                        requsition_supply_table.ajax.reload();
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

            $(document).on('click','.buttom_delete',function() {
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
                            url: "{{route('api.v1.requsition.supply.delete')}}",
                            data: {'id': id},
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
                                    requsition_supply_table.ajax.reload();
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
            });

    });
</script>
@endsection
