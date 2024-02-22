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
                <li class="breadcrumb-item active">ประวัติการเบิกวัสดุสิ้นเปลือง</li>
            </ol>
        </div><!-- /.col -->
        <div >
            <br>
            {{-- <a class="btn ogn-stock-yellow " href="{{route('requsition.supply.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a> --}}
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
                <div class="position-absolute m-2 text-md">ค้นหาจาก หมายเลขเอกสาร ชื่อวัสดุสิ้นเปลือง รายละเอียดการเบิก</div>
                <table id="requsition_supply_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr>

                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่รับเข้า</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">แก้ไขครั้งที่</th>
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

        let requsition_supply_table =$('#requsition_supply_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.requsition.supply.list.history'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id' , class: 'text-center', render : function(data, type, row, meta){
                            return meta.row +1;
                            }
                    },
                    { data: 'date' },
                    { data: 'paper_no' },
                    { data: 'edit_times' , class: 'text-center'},
                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt " ></a></div>`;
                        }
                    },
                    { data: 'id',render : function(data,type,row,meta){
                            ref = "{{url('/report/requsition/supply/pdf/')}}";
                            return ' <div style="text-align:center;"><a class=" "  href=" ' + ref +'/'+ data +' " ><i class="fas fa-download p-1 "></i></a></div>';
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
            function format ( requsition ) {
                var requsitionSupplies = requsition.supply_cut;
                var lot;
                var name_supply;
                var total_weight;
                var coa;
                var exp;
                var mfg;
                var detail = requsition.detail

                var loop_table;
                var table_body = "";
                var table;

                requsitionSupplies.forEach(requsition_item => {
                    lot = requsition_item.supply_lot.lot;
                    name_supply = requsition_item.supply_lot.supply.name;
                    total = requsition_item.qty
                    exp = requsition_item.supply_lot.exp;
                    mfg = requsition_item.supply_lot.mfg;
                    action = requsition_item.supply_lot.action;

                    //loop table

                    loop_table =    '<tr>'+
                                        '<td>'+lot+'</td>'+
                                        '<td>'+name_supply+'</td>'+
                                        '<td style="text-align:center;">'+total+' ชิ้น'+'</td>'+
                                    '</tr>';
                    table_body += loop_table;
                });
                var inner_table = `<table class="w-100">
                    <tr>
                        <th >LOT</th>
                        <th >ชื่อวัสดุสิ้นเปลือง</th>
                        <th class="text-center">จำนวน</th>
                    </tr>
                    ${table_body}
                </table>`;

                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"> <caption class="text-center text-dark text-bold pt-0">รายละเอียดการเบิกวัสดุสิ้นเปลือง<br><p class="text-secondary"> รายละเอียดการเบิก : '+detail+'</p></caption>'+inner_table+'</table>';

                return table;
            }

            $('#requsition_supply_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = requsition_supply_table.row( tr );
                console.log(requsition_supply_table)
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
