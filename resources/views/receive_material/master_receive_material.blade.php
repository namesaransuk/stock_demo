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
                <li class="breadcrumb-item active">ประวัติการนำเข้าวัตถุดิบ</li>
            </ol>
        </div><!-- /.col -->
        <div >
            <br>
            {{-- <a class="btn ogn-stock-yellow " href="{{route('receive.material.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a> --}}
            <!-- <button type="button"  data-toggle="modal" data-target="#myModal"></button> -->
        </div>
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-gdp">
            <div class="card-body p-0">
                <div class="position-absolute m-2 text-md">ค้นหาจาก หมายเลขเอกสาร แบรนด์ บริษัทขนส่ง</div>

                <table id="receive_material_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่รับเข้า</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">แก้ไขครั้งที่</th>
                            <th scope="col" class="w-auto">แบรนด์</th>
                            <th scope="col" class="w-auto">บริษัทขนส่ง</th>
                            <th scope="col" class="w-auto">สถานะ</th>
                            <th scope="col" class="w-auto">รายละเอียด</th>
                            <th scope="col" class="w-auto">PDF</th>
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

        let receive_material_table =$('#receive_material_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.receive.material.list.history.master'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id'},
                    { data: 'date' },
                    { data: 'paper_no' },
                    { data: 'edit_times' , class: 'text-center'},
                    { data: 'id',render : function(data,type,row,meta){
                            return row.brand_vendor.brand;
                    } },
                    { data: 'id',render : function(data,type,row,meta){
                            return row.logistic_vendor.brand;
                    } },
                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            var status = "";
                            if (row.reject_status == 0) {
                                status = `<span class='badge badge-pill w-75 text-success' style='font-size:15px;'>นำเข้าสต็อก</span>`

                            }else{
                                status = `<span class='badge badge-pill w-75 text-danger' style='font-size:15px;'>ตีกลับทั้งหมด</span>`
                            }
                            return status;
                        }
                    },
                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt " ></a></div>`;
                        }
                    },
                    { data: 'id',render : function(data,type,row,meta){
                            ref = "{{url('/report/receive/material/pdf/')}}";
                            return ' <a class=" "  href=" ' + ref +'/'+ data +' " ><i class="fas fa-download p-1 "></i></a>';
                    } },

                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    { responsivePriority: 1, targets: [0,1,2] }
                ],
                // language: {
                //     "url": "{{ asset('/vendor/datatables/th.json') }}"
                // },
                "dom": '<"top my-1 mr-1"f>rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
        })

                    //ส่วนแสดงตารางรายละเอียด
            function format ( receive ) {
                // console.log(receive.material_lots)
                var receiveMaterials = receive.material_lots;
                var lot;
                var name_material;
                var total_weight;
                var coa;
                var exp;
                var mfg;

                var loop_table;
                var table_body = "";
                var table;

                receiveMaterials.forEach(receive_item => {
                    console.log(receive_item)
                    lot = receive_item.lot;
                    name_material = receive_item.receive_mat_name;
                    total_weight = parseFloat(receive_item.weight_total / 1000);
                     let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                     let total = formatter.format(total_weight);
                    coa =  receive_item.coa;
                    exp = receive_item.exp;
                    mfg = receive_item.mfg;
                    action = receive_item.action;
                    ref = "{{asset('uploads/coa_material/')}}";

                    //loop table

                    loop_table =    '<tr>'+
                                        '<td>'+lot+'</td>'+
                                        '<td>'+name_material+'</td>'+
                                        '<td style="text-align:center;">'+total+' กิโลกรัม'+'</td>'+
                                        '<td style="text-align:center;">'+mfg+'</td>'+
                                        '<td style="text-align:center;">'+exp+'</td>'+
                                        '<td style="text-align:center;"> <a class=" "  href=" ' + ref +'/'+ coa +' " download><i class="fas fa-download p-1 "></i></a>'+'</td>'+
                                    '</tr>';
                    table_body += loop_table;
                });
                var inner_table = `<table class="w-100">
                    <tr>
                        <th >LOT</th>
                        <th >ชื่อวัตถุดิบ</th>
                        <th class="text-center">น้ำหนัก</th>
                        <th class="text-center">MFG.</th>
                        <th class="text-center">EXP.</th>
                        <th class="text-center">COA.</th>
                    </tr>
                    ${table_body}
                </table>`;

                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"> <caption class="text-center text-dark text-bold pt-0">รายละเอียดวัตถุดิบนำเข้า</caption>'+inner_table+'</table>';

                return table;
            }

            $('#receive_material_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = receive_material_table.row( tr );
                console.log(receive_material_table)
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

    });
</script>
@endsection
