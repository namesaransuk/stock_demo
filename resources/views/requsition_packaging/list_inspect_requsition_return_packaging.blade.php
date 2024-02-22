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

                <li class="breadcrumb-item active">ตรวจสอบและยืนยันการคืนบรรจุภัณฑ์</li>
            </ol>
        </div><!-- /.col -->
        {{-- <div >
            <br>
            <a class="btn ogn-stock-yellow " href="{{route('requsition.packaging.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a>
            <!-- <button type="button"  data-toggle="modal" data-target="#myModal"></button> -->
        </div> --}}
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="row">
    <div class="col-12">
            <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
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

                <table id="requsition_packaging_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่เบิก</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">ชื่อสินค้า</th>

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

        let requsition_packaging_table =$('#requsition_packaging_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.requsition.inspect.packaging.return.list'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id' },
                    { data: 'date' },
                    { data: 'paper_no' },
                    { data: 'product_name' },


                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            return `<div style="text-align:center;"><a href="#"  class="details-control fas fa-list-alt text-lg text-ogn-green " ></a></div>`;
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
                // console.log(receive.packaging_lots)
                var receiveMaterials = receive.packagingCutReturns;
                var lot;
                var name_packaging;
                var total_weight;
                var coa;
                var exp;
                var mfg;
                var action;
                var loop_table;
                var table_body = "";
                var table;

                receiveMaterials.forEach(receive_item => {

                    lot = receive_item.packaging_lot.lot_no_pm;
                    name_packaging = receive_item.packaging_lot.packaging.name;
                    total_qty = parseFloat(receive_item.qty);
                    total_qty_r = 0;
                    use_qty = 0;
                    let total_r = "-";
                    let use_r = "-";
                     let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                     if (receive_item.qty_r > 0) {

                        met_good_re = parseFloat(receive_item.met_good_re);
                        met_waste_re = parseFloat(receive_item.met_waste_re);
                        met_claim_re = parseFloat(receive_item.met_claim_re);
                        met_destroy_re = parseFloat(receive_item.met_destroy_re);

                        total_qty_r = parseFloat(receive_item.qty_r);
                        use_qty = parseFloat(receive_item.qty - met_good_re - met_claim_re - met_destroy_re)
                        total_r = formatter.format(total_qty_r)
                        use_r = formatter.format(use_qty)

                        use_met_good_re = formatter.format(met_good_re)
                        use_met_waste_re = formatter.format(met_waste_re)
                        use_met_claim_re = formatter.format(met_claim_re)
                        use_met_destroy_re = formatter.format(met_destroy_re)
                     }

                     let total = formatter.format(total_qty);


                    ref = "{{asset('uploads/coa_packaging/')}}";
                    action = receive_item.action



                    //loop table

                    loop_table =    '<tr>'+

                                        '<td>'+lot+'</td>'+

                                        '<td>'+name_packaging+'</td>'+

                                        '<td class="text-center">'+total+''+'</td>'+

                                        '<td class="text-center">'+use_r+''+'</td>';

                    if (receive_item.qty_r > 0) {
                        loop_table += `<td class="">
                            <div class="cards">
                                <div class="card-body p-1">
                                    <span class="badge badge-success p-2 text-sm mb-1">จำนวนของดีที่คืน : ${use_met_good_re}</span><br>`;

                                    if (use_met_waste_re > 0) {
                                        loop_table +=   `
                                            <span class="badge badge-warning p-2 text-sm mb-1">จำนวนของที่เคลม : ${use_met_claim_re}</span><br>
                                            <span class="badge badge-danger p-2 text-sm mb-1">จำนวนของที่ทำลาย : ${use_met_destroy_re}</span>
                                        `
                                    };
                                        loop_table += `
                                </div>
                            </div>
                        </td>
                    `
                    }else{
                        loop_table += `<td class="text-center"> -- </td>`;
                    }


                    loop_table += '</tr>';

                    table_body += loop_table;
                });

                var inner_table = `<table class="w-100">
                    <tr>
                        <th style='width:30%'>ล็อตสินค้า</th>
                        <th style='width:18%'>ชื่อวัตถุดิบ</th>
                        <th style='width:20%' class="text-center">จำนวนเบิก</th>
                        <th style='width:20%' class="text-center">จำนวนคืน</th>
                        <th style='width:20%' class="text-center">ใช้จริง</th>

                    </tr>
                    ${table_body}
                </table>`;
                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"><caption class="text-center text-dark text-bold pt-0">รายละเอียดการเบิกบรรจุภัณฑ์</caption> '+inner_table+'</table>';

                return table;
            }

            $('#requsition_packaging_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = requsition_packaging_table.row( tr );

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
                                url: "{{route('api.v1.requsition.packaging.step.to.pending.return')}}",
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
                                        requsition_packaging_table.ajax.reload();
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
                                url: "{{route('api.v1.requsition.packaging.step.back.to.return')}}",
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
                                        requsition_packaging_table.ajax.reload();
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
