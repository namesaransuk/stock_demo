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

                <li class="breadcrumb-item active">รายงานการรับเข้าบรรจุภัณฑ์</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-gdp">

            <form action="{{route('report.receive.packaging.pdf')}}" method="POST">
                @csrf
                <input type="hidden" name="company_id" value="{{session('company')}}">
                <div class="row mt-3">
                    <div class="col-2">
                        <button type="submit"  style="margin-left: 9%;margin-top: 26px;" class="btn btn-success">PDF</button>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="item_search">บรรจุภัณฑ์</label>
                            <select class="form-control form-control-sm select2" id="item_search">
                                <option data-id="-1" value="-1">แสดงทั้งหมด</option>
                                @foreach ($pac as $pac_one)
                                    <option data-id="{{$pac_one->id}}" value="{{$pac_one->id}}">{{$pac_one->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="month_search">เดือน</label>
                            <select class="form-control form-control-sm" id="month_search" name="month_search">
                                <option data-id="-1" value="-1">แสดงทั้งหมด</option>
                                @foreach ($monthAll as $monthAll_one)
                                    <option data-id="{{$monthAll_one}}" value="{{$monthAll_one}}">{{$monthAll_one}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="year_search">ปี</label>
                            <select class="form-control form-control-sm" id="year_search" name="year_search">
                                @foreach ($yearFive as $yearFive_one)
                                    <option data-id="{{$yearFive_one}}" value="{{$yearFive_one}}">{{$yearFive_one}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-1 mt-4">
                        <button type="button" class="btn btn-success btn-sm" onclick="showTable()">ค้นหา</button>
                    </div>
                </div>
            </form>


            <div class="card-body p-0" id="mat_table">
                <table id="requsition_supply_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr class='text-nowrap text-center'>
                            <th scope="col" >สถานะ</th>
                            <th scope="col" >วันที่</th>
                            <th scope="col" >ชื่อบรรจุภัณฑ์</th>
                            <th scope="col" >Lot</th>
                            <th scope="col" >LotNo. PM.</th>
                            <th scope="col" >MFG.</th>
                            <th scope="col" >EXP.</th>
                            <th scope="col" >แบรนด์</th>
                            <th scope="col" >บริษัทขนส่ง</th>
                            <th scope="col" >จำนวน</th>
                            <th scope="col" >COA</th>
                            <th scope="col" >ผู้รับเข้า</th>
                            <th scope="col" >ผู้ตรวจสอบ</th>
                        </tr>
                    </thead>
                    <tbody class="text-nowrap">
                </tbody>
                </table>
            </div>
        </div>

    </div>
</div>



@endsection

@section('js')
<script>

    function showTable() {

        let item_search = $('#item_search').find(':selected').data('id')
        let month_search = $('#month_search').find(':selected').data('id')
        let year_search = $('#year_search').find(':selected').data('id')


        $('#mat_table').html('');
        $('#mat_table').html(`
                <table id="requsition_supply_table" class="table w-100" style="margin-top: 0!important; margin-bottom: 0!important; overflow-x:auto;">
                        <caption style="display: none"></caption>
                        <thead class="ogn-stock-yellow" >
                            <tr class='text-nowrap text-center'>
                                <th scope="col" >สถานะ</th>
                                <th scope="col" >วันที่</th>
                                <th scope="col" >Lot</th>
                                <th scope="col" >LotNo. PM.</th>
                                <th scope="col" >รายการ</th>
                                <th scope="col" >จำนวน</th>
                                <th scope="col" >แบรนด์</th>
                                <th scope="col" >บริษัทขนส่ง</th>
                                <th scope="col" >MFG.</th>
                                <th scope="col" >EXP.</th>
                                <th scope="col" >COA</th>
                                <th scope="col" >ผู้รับเข้า</th>
                                <th scope="col" >ผู้ตรวจสอบ</th>
                            </tr>
                        </thead>
                        <tbody class='text-nowrap'>
                    </tbody>
                </table>
        `);

        $('#requsition_supply_table').DataTable({
                "pageLength": 10,
                "responsive": true,
                "order": [1, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'scrollX': true,
                'ajax': {
                    'url':'{{route(('api.v1.report.receive.packaging.list'))}}',
                    'data':{
                        item_search: item_search,
                        company_id: {{session('company')}},
                        month_search: month_search,
                        year_search: year_search,
                    }
                },
                'columns': [
                    { data: 'id', render : function(data, type, row, meta){
                            text = '<span class="badge bg-warning text-dark">กำลังดำเนินการ</span>';
                        if(row.receive_packaging.paper_status == 4){
                            text = '<span class="badge bg-success text-dark">รับเข้าสำเร็จ</span>';
                        }
                        if(row.receive_packaging.reject_status == 1){
                            text = '<span class="badge bg-danger text-dark">ปฏิเสธการรับเข้า</span>';
                        }
                        return text;
                    } },
                    { data: 'created_at' , class: 'text-center', render : function(data, type, row, meta){
                        var d = new Date(data);
                        return d.getDate().toString().padStart(2, '0') + '/' + (d.getMonth()+1) + '/' + d.getFullYear();
                    } },
                    { data: 'lot'},
                    { data: 'id', render : function(data, type, row, meta){
                        if (row.lot_no_pm) {
                            return row.lot_no_pm;
                        }else{
                            return 'ไม่มีข้อมูล'
                        }
                    } },
                    { data: 'id', render : function(data, type, row, meta){
                        if (row.packaging.name) {
                            return row.packaging.name;
                        }else{
                            return 'ไม่มีข้อมูล'
                        }
                    } },
                    { data: 'id', render : function(data, type, row, meta){
                        total_qty = parseFloat(row.qty) ;
                        let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                        let total = formatter.format(total_qty);
                        return total+' ชิ้น';
                    } },
                    { data: 'id', render : function(data, type, row, meta){
                        if (row.receive_packaging.brand_vendor.brand) {
                            return row.receive_packaging.brand_vendor.brand;
                        }
                    } },
                    { data: 'id', render : function(data, type, row, meta){
                        if (row.receive_packaging.logistic_vendor.brand) {
                            return row.receive_packaging.logistic_vendor.brand;
                        }
                    } },
                    { data: 'mfg', class: 'text-center', render : function(data, type, row, meta){
                        var d = new Date(data);
                        return d.getDate().toString().padStart(2, '0') + '/' + (d.getMonth()+1) + '/' + d.getFullYear();
                    } },
                    { data: 'exp', class: 'text-center', render : function(data, type, row, meta){
                        var d = new Date(data);
                        return d.getDate().toString().padStart(2, '0') + '/' + (d.getMonth()+1) + '/' + d.getFullYear();
                    } },
                    {
                        "data":    null,  class: 'text-center',
                        render : function(data, type, row, meta){
                            ref = "{{asset('uploads/coa_packaging/')}}";
                            if (row.coa) {
                                return ' <a class=" "  href=" ' + ref +'/'+ row.coa +' " download><i class="fas fa-download p-1 "></i></a>';
                            }else{
                                return '<i class="text-danger fas fa-times-circle"></i>';
                            }
                        }
                    },

                    { data: 'id', render : function(data, type, row, meta){
                        if (row.receive_packaging.stock_user.employee.fname) {
                            return row.receive_packaging.stock_user.employee.fname;
                        }
                    } },
                    { data: 'id', render : function(data, type, row, meta){
                        if (row.receive_packaging.audit_user.employee.fname) {
                            return row.receive_packaging.audit_user.employee.fname;
                        }
                    } },
                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    // { responsivePriority: 1, targets: [0,1,2] }
                    {
                        searchable: false,
                        orderable: false,
                        targets: [10]
                    }
                ],

                "dom": '<"top"i>rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"><"clear">'
        })
    }

    $(function() {
        $('.select2').select2();

        var seturl = "{{ url('/') }}";

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@endsection
