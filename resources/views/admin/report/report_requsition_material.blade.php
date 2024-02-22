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
                <li class="breadcrumb-item active">รายงานการเบิกวัตถุดิบ</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-gdp">

            <form action="{{route('report.requsition.material.pdf')}}" method="POST">
                @csrf
                <input type="hidden" name="company_id" value="{{session('company')}}">
                <div class="row mt-3">
                    <div class="col-2">
                        <button type="submit"  style="margin-left: 9%;margin-top: 26px;" class="btn btn-success">PDF</button>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="item_search">วัตถุดิบ</label>
                            <select class="form-control form-control-sm select2" id="item_search" name="item_search">
                                <option data-id="-1" value="-1">แสดงทั้งหมด</option>
                                @foreach ($mat as $mat_one)
                                    <option data-id="{{$mat_one->id}}" value="{{$mat_one->id}}">{{$mat_one->name}}</option>
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
                            <th scope="col" >ประเภท</th>
                            <th scope="col" >วันที่</th>
                            <th scope="col" >รายการ</th>
                            <th scope="col" >Lot</th>
                            <th scope="col" >จำนวน</th>
                            <th scope="col" >ผู้เบิก (ฝ่ายผลิต)</th>
                            <th scope="col" >ผู้ให้เบิก (ฝ่ายจัดซื้อ)</th>
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
        $('.select2').select2();

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
                                <th scope="col" >ประเภท</th>
                                <th scope="col" >วันที่</th>
                                <th scope="col" >รายการ</th>
                                <th scope="col" >Lot</th>
                                <th scope="col" >จำนวน</th>
                                <th scope="col" >ผู้เบิก (ฝ่ายผลิต)</th>
                                <th scope="col" >ผู้ให้เบิก (ฝ่ายจัดซื้อ)</th>
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
                    'url':'{{route(('api.v1.report.requsition.material.list'))}}',
                    'data':{
                        month_search: month_search,
                        year_search: year_search,
                        item_search: item_search,
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id', render : function(data, type, row, meta){
                            text = '<span class="badge bg-warning text-dark w-100">เบิก</span>';
                        if(row.action == 2){
                            text = '<span class="badge bg-success text-dark w-100">คืน</span>';
                        }
                        return text;
                    } },
                    { data: 'created_at' , class: 'text-center', render : function(data, type, row, meta){
                        var d = new Date(data);
                        return d.getDate().toString().padStart(2, '0') + '/' + (d.getMonth()+1) + '/' + d.getFullYear();
                    } },
                    { data: 'id', render : function(data, type, row, meta){
                        if (row.material_lot.material.name) {
                            return row.material_lot.material.name;
                        }else{
                            return 'ไม่มีข้อมูล'
                        }
                    } },
                    { data: 'id', render : function(data, type, row, meta){
                        if (row.material_lot.lot) {
                            return row.material_lot.lot;
                        }else{
                            return 'ไม่มีข้อมูล'
                        }
                    } },
                    { data: 'id', render : function(data, type, row, meta){
                        total_weight = parseFloat(row.weight) ;
                        let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                        let wunit = "กรัม";
                        if (row.weight >= 1000000) {
                            total_weight = parseFloat(row.weight/1000000) ;
                            wunit = "ตัน";
                        } else if (row.weight >= 1000) {
                            total_weight = parseFloat(row.weight/1000) ;
                            wunit = "กิโลกรัม";
                        }
                        let total = formatter.format(total_weight);
                        return total+' '+wunit;
                    } },

                    { data: 'id', render : function(data, type, row, meta){
                        if (row.requsition_material.production_user) {
                            return row.requsition_material.production_user.employee.fname;
                        }else{
                            return 'ไม่มีข้อมูล'
                        }
                    } },
                    { data: 'id', render : function(data, type, row, meta){
                        if (row.requsition_material.procurement_user) {
                            return row.requsition_material.procurement_user.employee.fname;
                        }else{
                            return 'ไม่มีข้อมูล'
                        }
                    } },
                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    // { responsivePriority: 1, targets: [0,1,2] }
                ],

                "dom": '<"top"i>rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"><"clear">'
        })
    }

    $(function() {

        var seturl = "{{ url('/') }}";

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@endsection
