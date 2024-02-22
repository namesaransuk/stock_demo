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
                <li class="breadcrumb-item active">ตรวจสอบส่งออกสินค้า</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="row">
    <div class="col-12">
            <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
            <div class="card card-outline card-gdp">
            <div class="card-body p-0">
                <table id="requsition_product_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่เบิก</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">แก้ไขครั้งที่</th>
                            <th scope="col" class="w-auto">สถานะ</th>
                            <th scope="col" class="w-auto">ประเภทการจัดส่ง</th>
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

        let requsition_product_table =$('#requsition_product_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.requsition.product.inspect.list'))}}',
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
                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            if(row.transport_type==1){
                                status = `<span class='badge badge-pill w-75 ' style='font-size:15px;'>บริษัทเป็นผู้ส่ง</span>`
                            }else if(row.transport_type==2){
                                status = `<span class='badge badge-pill w-75 ' style='font-size:15px;'>ลูกค้ามารับเอง</span>`
                            }else{
                                status = `<span class='badge badge-pill w-75 ' style='font-size:15px;'>ส่งผ่านบริษัทขนส่ง</span>`
                            }
                            return status;
                        }
                    },
                    { data: 'id', class: 'd-flex',
                    render : function(data,type,row,meta){
                        return  `
                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-danger cancel-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-left"></i> ตีกลับ </a>
                                    <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-success confirm-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-right"></i> ยืนยันการตรวจสอบ</a>
                                `
                    }
                    },

                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    { responsivePriority: 1, targets: [0,1,2] }
                ],

                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
        })

                    //ส่วนแสดงตารางรายละเอียด
            function format ( receive ) {
                var receive_product = receive.product_cuts;
                var lot;
                var name_product;
                var total_weight;
                var coa;
                var exp;
                var mfg;
                var action;
                var loop_table;
                var table_body = "";
                var table;
                var cus_name = receive.receive_name;
                var cus_tel = receive.receive_tel;
                var cus_addr = receive.receive_full_addr;
                var transport_type = receive.transport_type;

                receive_product.forEach(receive_item => {
                    lot = receive_item.product_lot.lot;
                    name_product = receive_item.product_lot.product.name;
                    total_weight = parseFloat(receive_item.qty);
                     let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                     let total = formatter.format(total_weight);

                    mfg = receive_item.product_lot.mfg
                    exp = receive_item.product_lot.exp

                    ref = "{{asset('uploads/coa_product/')}}";
                    action = receive_item.action


                    if (action == 1) {
                       action = "<td style='text-align:center;'> <span class='badge badge-pill ogn-stock-grey' style='text-align : center;'>รออนุมัติ</span> </td>"
                    } else {
                        action = "<td style='text-align:center;'> <span class='badge badge-pill ogn-stock-green' style='text-align : center;'>อนุมัติการเบิก</span> </td>"
                    }
                    //loop table

                    loop_table =    '<tr>'+
                                        '<td>'+lot+'</td>'+
                                        '<td>'+name_product+'</td>'+
                                        '<td>'+total+' ชิ้น'+'</td>'+
                                    '</tr>';
                    table_body += loop_table;
                });

                var inner_table = `
                <table class="w-100">
                <div class="text-center">
                    <label class="text-secondary" style="text-size=10px;">ชื่อลูกค้า : ${cus_name} เบอร์โทร : ${cus_tel}</label><br>
                    <label class="text-secondary" style="text-size=10px;">ที่อยู่จัดส่ง : ${cus_addr}</label>
                </div>


                    <tr>
                        <th style='width:25%'>ล็อต</th>
                        <th style='width:25%'>ชื่อวัสดุสิ้นเปลือง</th>
                        <th style='width:10%'>จำนวน</th>
                    </tr>
                    ${table_body}
                </table>`;
                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"><caption class="text-center text-dark text-bold pt-0">รายละเอียดการเบิกสินค้า</caption> '+inner_table+'</table>';

                return table;
            }

            $('#requsition_product_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = requsition_product_table.row( tr );

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
                var formData = new FormData();
                    formData.append('id', $(this).data('id'));
                    formData.append('user_id', $('#user_id').val());
                const id = $(this).data('id');
                Swal.fire({
                        title: 'ยืนยันการตรวจสอบ?',
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
                                url: "{{route('api.v1.requsition.product.step.to.pending')}}",
                                data: formData,
                                contentType: false,
                                processData: false,
                                cache: false,
                                success: function (response) {
                                    if (response) {
                                        Swal.fire({
                                            position: 'center-center',
                                            icon: 'success',
                                            title: 'ยืนยันสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500,
                                        })
                                        requsition_product_table.ajax.reload();
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

            $(document).on('click','.cancel-btn',function(){
                const id = $(this).data('id');
                Swal.fire({
                        title: 'ยืนยันการตีกลับ?',
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
                                url: "{{route('api.v1.requsition.product.step.reject')}}",
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
                                        requsition_product_table.ajax.reload();
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
