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

                <li class="breadcrumb-item active">เบิกวัตถุดิบ</li>
            </ol>
        </div><!-- /.col -->
        <div >
            <br>
            <a class="btn ogn-stock-yellow " href="{{route('requsition.material.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a>
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

                <table id="requsition_material_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่เบิก</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">ชื่อสินค้า</th>
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

        let requsition_material_table =$('#requsition_material_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.requsition.material.list'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id' },
                    { data: 'date' },
                    { data: 'paper_no' },
                    { data: 'product_name' },
                    { data: 'edit_times' , class: 'text-center'},
                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt " ></a></div>`;
                        }
                    },
                    { data: 'id', class: 'd-flex',
                    render : function(data,type,row,meta){
                        let url2 = "{{ route('requsition.material.edit', "__id") }}".replaceAll("__id",row.id);
                        let url3 = "{{ route('requsition.material.history', "__id") }}".replaceAll("__id",row.id);
                        if (row.edit_times != 0) {

                          action = `<a type="" style="" href="${url3}"  data-id="${row.id}" id="myModal-edit"  class=" reset-me btn-modal " ><i class="fas fa-history p-1 text-indigo"></i> </a>`;
                        } else {
                            action = '<a type="" style=""  id="myModal-edit"  class= "reset-me btn-modal " ><i class="fas fa-history p-1 text-muted"></i> </a>';
                        }
                        apply_next = `<a type="button"  style=""  id="myModal-edit" data-id="${row.id}"  class= "btn-nextstep btn-modal btn-update-inspect_ready " ><i class="fas fa-arrow-circle-right p-1 text-success"></i> </a>`;
                        return `<div class=" w-100 m-auto" style="text-align:center;">
                                        <a type="" style="" href="${url2}"  data-id="${row.id}" id="myModal-edit"  class=" reset-me btn-modal  "><i class="fas fa-edit text-warning p-1"></i> </a>
                                        ${action}
                                        <a type="" style="cursor: pointer;"   data-id="${row.id}" id="myModal-edit"  class="buttom_delete reset-me btn-modal  "><i class="fas fa-trash p-1 text-danger "></i> </a>
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
                var receiveMaterials = receive.material_cut_returns;
                var lot;
                var name_material;
                var total_weight;
                var coa;
                var exp;
                var mfg;
                var action;
                var loop_table;
                var table_body = "";
                var table;

                receiveMaterials.forEach(receive_item => {

                    lot = receive_item.material_lot.lot_no_pm;
                    name_material = receive_item.material_lot.material.name;


                    total_weight = parseFloat(receive_item.weight) ;
                    let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                    let wunit = "กรัม";
                    if (receive_item.weight >= 1000000) {
                        total_weight = parseFloat(receive_item.weight/1000000) ;
                        wunit = "ตัน";
                    } else if (receive_item.weight >= 1000) {
                        total_weight = parseFloat(receive_item.weight/1000) ;
                        wunit = "กิโลกรัม";
                    }
                    let total = formatter.format(total_weight);


                    ref = "{{asset('uploads/coa_material/')}}";
                    action = receive_item.action
                    //loop table

                    loop_table =    '<tr>'+
                                        '<td>'+lot+'</td>'+
                                        '<td>'+name_material+'</td>'+
                                        '<td class="text-right">'+total+' '+wunit+'</td>'+
                                    '</tr>';
                    table_body += loop_table;
                });

                var inner_table = `<table class="w-100">
                    <tr>
                        <th style='width:30%'>ล็อตสินค้า</th>
                        <th style='width:18%'>ชื่อวัตถุดิบ</th>
                        <th style='width:30%' class="text-center">น้ำหนัก</th>
                    </tr>
                    ${table_body}
                </table>`;
                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"><caption class="text-center text-dark text-bold pt-0">รายละเอียดเบิกวัตถุดิบ</caption>'+inner_table+'</table>';

                return table;
            }

            $('#requsition_material_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = requsition_material_table.row( tr );

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

            $(document).on('click','.btn-nextstep',function(){
                const id = $(this).data('id');
                Swal.fire({
                        title: 'ยืนยันการส่งไปตรวจสอบ?',
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
                                url: "{{route('api.v1.requsition.material.step.to.inspect.cut')}}",
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
                                        requsition_material_table.ajax.reload();
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
                            url: "{{route('api.v1.requsition.material.delete')}}",
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
                                    requsition_material_table.ajax.reload();
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
