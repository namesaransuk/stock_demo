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

                <li class="breadcrumb-item active">คืนบรรจุภัณฑ์</li>
            </ol>
        </div><!-- /.col -->
        <div >
            <br>
            <!-- <a class="btn ogn-stock-yellow " href="{{route('requsition.packaging.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a> -->
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
            <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">

                <table id="requsition_packaging_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่เบิก</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">ชื่อสินค้า</th>
                            <!-- <th scope="col" class="w-auto">แก้ไขครั้งที่เท่าไร</th> -->
                            <th scope="col" class="w-auto">รายละเอียด</th>
                            <th scope="col" class="w-auto">จัดการ</th>

                            <!-- <th scope="col" class="w-auto " style="text-align: center !important;">จัดการ</th> -->
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
                    'url':'{{route(('api.v1.requsition.packaging.return.list'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id' },
                    { data: 'date' },
                    { data: 'paper_no' },
                    { data: 'product_name' },
                    // { data: 'edit_times' , class: 'text-center'},

                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt " ></a></div>`;
                        }
                    },

                    { data: 'id', class: 'p-1',
                    render : function(data,type,row,meta){
                        let url2 = "{{ route('requsition.packaging.return.create', "__id") }}".replaceAll("__id",row.id);

                        action = `<a type="" style="" href="${url2}"  data-id="${row.id}" id="myModal-edit"  class=" reset-me btn " data-toggle="tooltip" data-placement="top" title="เพิ่มการคืนบรรจุภัณฑ์" ><i class="fas fa-share text-warning p-1"></i> คืนบรรจุภัณฑ์ </a>`;
                        action2 = `<a type="button"  style=""  id="myModal-edit" data-id="${row.id}"  class= "btn btn-nextstep disabled btn-modal btn-update-inspect_ready " ><i class="fas fa-arrow-circle-right p-1 text-success"></i> ส่งไปตรวจสอบ </a>`;
                            row.packaging_cut_returns.forEach(element => {
                                if(element.action != 1){
                                    action = `<a type="" style=""  data-id="${row.id}" id="myModal-edit"  class=" reset-me  disabled btn " data-toggle="tooltip" data-placement="top" title="เพิ่มการคืนบรรจุภัณฑ์" disabled ><i class="fas fa-share text-gray p-1"></i> คืนบรรจุภัณฑ์ </a>`;
                                    action2 = `<a type="button"  style=""  id="myModal-edit" data-id="${row.id}"  class= "btn-nextstep btn-modal btn-update-inspect_ready " ><i class="fas fa-arrow-circle-right p-1 text-success"></i> ส่งไปตรวจสอบ </a>`;
                                }
                            });
                        return `
                        ${action}
                        ${action2}
                        `
                    }
                    },

                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    { responsivePriority: 1, targets: [0,1,2] }
                ],

                "dom": '<"top my-1 mr-1"f>rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
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

                    console.log(receive_item);

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
                        <th style='width:20%' class="text-center">ใช้จริง</th>
                        <th style='width:20%' class="text-center">จำนวนคืน</th>

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
                                url: "{{route('api.v1.requsition.packaging.step.to.inspect.return')}}",
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
