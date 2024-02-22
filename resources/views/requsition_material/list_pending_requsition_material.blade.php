@extends('adminlte::page')

@section('css')

@endsection

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">รายการรอดำเนินการเบิกวัตถุดิบ</li>
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-12">
                <br>
               <!-- <button type="button" class="btn" style="background-color: #D7FFB3;" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</button> -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

@stop

@section('content')
<div class="row">
        <div class="col-12">
            <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
            <div class="card card-outline card-gdp">
                <div class="card-body p-0">
                    <table id="check_requsition_table" class="table w-100" style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="ogn-stock-yellow">
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่เบิก</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">ชื่อสินค้า</th>
                            <th scope="col" class="w-auto">แก้ไขครั้งที่</th>
                            <th scope="col" class="w-auto">รายละเอียด</th>
                            <th scope="col" class="w-auto">สถานะ</th>
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
      $(function(){
        $('.dropify').dropify();

        let check_requsition_table = $('#check_requsition_table').DataTable({

                "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.requsition.material.pending.list'))}}',
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
                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            var status = "";
                                status = `<span class='badge badge-pill w-75 text-success' style='font-size:15px;'>กำลังเตรียมของ</span>`
                            return status;
                        }
                    },
                    {
                        "data": 'id', class: 'd-flex',
                        render : function(data, type, row, meta){
                            return  `
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-success confirm-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-right"></i> เสร็จสิ้น</a>
                                    `
                                        //<a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-danger reject-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-left"></i> อะไรสักอย่าง</a>
                        }
                    },


                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    { responsivePriority: 1, targets: [0,1,2] }
                ],

                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
        });

            //ส่วนแสดงตารางรายละเอียด
            function format ( requsition ) {
                var requsitionMaterials = requsition.material_cut_returns;
                var lot;
                var name_material;
                var total_weight;
                var coa;
                var exp;
                var mfg;
                var id;
                var loop_table;
                var table;
                var table_body = "";

                requsitionMaterials.forEach(requsition_item => {
                    console.log(requsition_item)
                    lot = requsition_item.material_lot.lot;
                    name_material = requsition_item.material_lot.lot_no_pm;

                    total_weight = parseFloat(requsition_item.weight) ;
                    let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                    let wunit = "กรัม";
                    if (requsition_item.weight >= 1000000) {
                        total_weight = parseFloat(requsition_item.weight/1000000) ;
                        wunit = "ตัน";
                    } else if (requsition_item.weight >= 1000) {
                        total_weight = parseFloat(requsition_item.weight/1000) ;
                        wunit = "กิโลกรัม";
                    }
                    let total = formatter.format(total_weight);

                    coa = requsition_item.material_lot.coa;
                    exp = requsition_item.material_lot.exp;
                    mfg = requsition_item.material_lot.mfg;
                    id = requsition_item.id

                    loop_table =    '<tr>'+
                                        '<td>'+lot+'</td>' +
                                        '<td>'+name_material+'</td>'+
                                        '<td class="text-right">'+total+' '+wunit+'</td>'+
                                        '<td>'+mfg+'</td>'+
                                        '<td>'+exp+'</td>'+
                                    '</tr>';
                    table_body += loop_table;
                });

                var inner_table = `<table class="w-100">
                    <tr>
                        <th style='width:15%'>ล็อต</th>
                        <th style='width:15%'>ชื่อวัตถุดิบ</th>
                        <th style='width:15%'>น้ำหนัก</th>
                        <th style='width:10%'>วันที่ผลิต</th>
                        <th style='width:10%'>วันหมดอายุ</th>
                    </tr>
                    ${table_body}
                </table>`;

                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"> <caption class="text-center text-dark text-bold pt-0">รายละเอียดการเบิก</caption> '+inner_table+'</table>';

                return table;
            }

            $('#check_requsition_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = check_requsition_table.row( tr );


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
            });

            $(document).on('click','.btn-modal',function(){
                let id = $(this).data('id');

                $.ajax({
                    type: "post",
                    url: "",
                    data: {"id":id},
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                    }
                });

            });


        $(document).on('click','.confirm-btn',function(){
                const id = $(this).data('id');
                Swal.fire({
                        title: 'เสร็จสิ้นการเบิก?',
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
                                url: "{{route('api.v1.requsition.material.step.to.return')}}",
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
                                        check_requsition_table.ajax.reload();
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
