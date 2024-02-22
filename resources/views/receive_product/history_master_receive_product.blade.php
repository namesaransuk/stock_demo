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
                <li class="breadcrumb-item active">ประวัติการนำเข้าสินค้า</li>
            </ol>
        </div><!-- /.col -->
        <div >
            <br>
            {{-- <a class="btn ogn-stock-yellow " href="{{route('receive.product.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a> --}}
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
                <div class="position-absolute m-2 text-md">ค้นหาจาก หมายเลขเอกสาร</div>

                <table id="receive_product_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่รับเข้า</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">แก้ไขครั้งที่</th>
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

        let receive_product_table =$('#receive_product_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.receive.product.list.history.master'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id'},
                    { data: 'date' },
                    { data: 'paper_no' },
                    { data: 'edit_times' , class: 'text-center'},
                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                                status = `<span class='badge badge-pill w-75 text-success' style='font-size:15px;'>นำเข้าสต็อก</span>`
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
                            ref = "{{url('/report/receive/product/pdf/')}}";
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
                console.log(receive.product_lots)
                var receiveProducts = receive.product_lots;
                var lot;
                var name_product;
                var total_weight;
                var coa;
                var exp;
                var mfg;

                var loop_table;
                var table_body = "";
                var table;

                receiveProducts.forEach(receive_item => {
                    console.log(receive_item)
                    lot = receive_item.lot;
                    name_product = receive_item.product.name;
                    total = receive_item.qty
                    exp = receive_item.exp;
                    mfg = receive_item.mfg;
                    action = receive_item.action;
                    ref = "{{asset('uploads/coa_product/')}}";

                    //loop table

                    loop_table =    '<tr>'+

                                        '<td>'+lot+'</td>'+
                                        '<td>'+name_product+'</td>'+
                                        '<td style="text-align:center;">'+total+' ชิ้น'+'</td>'+
                                        '<td style="text-align:center;">'+mfg+'</td>'+
                                        '<td style="text-align:center;">'+exp+'</td>'+
                                    '</tr>';
                    table_body += loop_table;
                });
                var inner_table = `<table class="w-100">
                    <tr>
                        <th >LOT</th>
                        <th >ชื่อสินค้า</th>
                        <th class="text-center">จำนวน</th>
                        <th class="text-center">MFG.</th>
                        <th class="text-center">EXP.</th>
                        <th class="text-center">ACTION</th>
                    </tr>
                    ${table_body}
                </table>`;

                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"> <caption class="text-center text-dark text-bold pt-0">รายละเอียดสินค้านำเข้า</caption>'+inner_table+'</table>';

                return table;
            }

            $('#receive_product_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = receive_product_table.row( tr );
                console.log(receive_product_table)
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
