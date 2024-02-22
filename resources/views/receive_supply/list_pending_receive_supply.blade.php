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
                <li class="breadcrumb-item active">รอการดำเนินการรับเข้าวัสดุสิ้นเปลือง</li>
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
            <div class="card-body p-0">
                <table id="receive_supply_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow">
                        <tr>
                            <th scope="col" class="w-auto text-left">วันที่รับเข้า</th>
                            <th scope="col" class="w-auto text-left">หมายเลขเอกสาร</th>
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

        let receive_supply_table =$('#receive_supply_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.receive.supply.pending.list'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'date' },
                    { data: 'paper_no' },
                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt " ></a></div>`;
                        }
                    },

                    {
                        "data": 'id', class: 'd-flex',
                        render : function(data, type, row, meta){
                            return  `
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-danger reject-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-times-circle"></i> ปฏิเสธการรับเข้า</a>
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-warning return-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-left"></i> ส่งกลับไปแก้ไข</a>
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-success confirm-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-right"></i> เสร็จสิ้นการรับเข้า</a>
                                    `
                                        //<a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-danger reject-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-left"></i> อะไรสักอย่าง</a>

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
                // console.log(receive.supply_lots)
                var receivesupplys = receive.supply_lots;
                var lot;
                var name_supply;
                var total_weight;
                var coa;
                var exp;
                var mfg;

                var loop_table;
                var table_body = "";
                var table;

                receivesupplys.forEach(receive_item => {
                    lot = receive_item.lot;
                    name_supply = receive_item.supply.name;

                    // console.log(total)
                    coa = receive_item.coa;
                    exp = receive_item.exp;
                    mfg = receive_item.mfg;
                    action = receive_item.action;
                    id = receive_item.id
                    ref = "{{asset('uploads/coa_supply/')}}";
                    qty = receive_item.qty
                    quality_check = receive_item.quality_check;
                    transport_check = receive_item.transport_check;

                    //loop table

                    loop_table =    '<tr>'+
                                        '<td>'+lot+'</td>'+
                                        '<td>'+name_supply+'</td>'+
                                        '<td>'+new Intl.NumberFormat("th-TH").format(qty)+' ชิ้น'+'</td>'+
                                    '</tr>';
                    table_body += loop_table;
                });
                var inner_table = `<table class="w-100">
                    <tr>
                        <th style='width:15%'>LOT</th>
                        <th style='width:15%'>ชื่อวัสดุสิ้นเปลือง</th>
                        <th style='width:15%'>จำนวน</th>
                    </tr>
                    ${table_body}
                </table>`;

                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"><caption class="text-center text-dark text-bold pt-0">รายละเอียด</caption> '+inner_table+'</table>';

                return table;
            }

            $('#receive_supply_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = receive_supply_table.row( tr );
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
                                url: "{{route('api.v1.receive.supply.step.history')}}",
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
                                        receive_supply_table.ajax.reload();
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
                                url: "{{route('api.v1.receive.supply.step.back.to.receive')}}",
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
                                        receive_supply_table.ajax.reload();
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
                var formData = new FormData();
                let in_html =   `   <form name="validForm">
                                        <input type="hidden" name="id" id="id" value="${id}" required>
                                        <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}" >
                                        <div class="row mb-2 center mt-2" >
                                            <h6 >เหตุผลที่ตีกลับ</h6><br>
                                            <input class="form-control" type="text" name="reject_detail" id="reject_detail" value="" required>
                                        </div>
                                    </form>
                                `

                Swal.fire({
                    title: "ปฏิเสธการรับเข้า",
                    html: in_html,
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ปิด',
                    confirmButtonColor: '#649514',
                    cancelButtonColor: '#a97551',
                }).then((result) => {
                    if (result.value) {
                        formData.append("id", id);
                        formData.append("reject_detail", $('#reject_detail').val());
                        formData.append("_token", $('#_token').val());

                        $.ajax({
                            type: "post",
                            url: "{{route('api.v1.receive.supply.reject')}}",
                            data: formData,
                            contentType: false,
                            processData: false,
                            cache: false,
                            success: function (response) {
                                if (response == "true") {
                                    Swal.fire({
                                            position: 'center-center',
                                            icon: 'success',
                                            title: 'ทำรายการสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500,
                                    })
                                    receive_supply_table.ajax.reload();

                                } else {
                                    Swal.fire({
                                            position: 'center-center',
                                            icon: 'warning',
                                            title: 'กรุณากรอกหมายเหตุ',
                                            showConfirmButton: false,
                                            timer: 1500
                                    })
                                    receive_supply_table.ajax.reload();

                                }
                            }
                        });
                    }
                });
            })

    });
</script>
@endsection
