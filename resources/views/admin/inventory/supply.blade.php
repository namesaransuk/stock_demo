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

                <li class="breadcrumb-item active">วัสดุสิ้นเปลืองคงคลัง</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="row">

    <div class="col-12">
        <div class="card card-outline card-gdp mt-2">
            <div class="card-header ogn-stock-yellow text-left" >
                <h6 class="m-0"> วัสดุสิ้นเปลือง </h6>
                <input type="hidden" name="company_id" id="company_id" value="{{session('company')}}">
            </div>

            {{-- <div class="card-body p-3">
                <canvas id="supplyBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div> --}}

            <div class="card-body p-3">
                <table id="inventory_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="table-borderless" >
                        <tr>
                            <th scope="col" class="w-auto">รายการ</th>
                            <th scope="col" class="w-auto text-right">จำนวน</th>
                            <th scope="col" class="w-auto">หน่วยนับ</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="text-right float-right mb-3">
            <a type="submit" href="{{ route('supply.export') }}"
                class="btn-export btn btn-success btn-sm">Export</a>
        </div> --}}
    </div>


    <div class="col-12">
        <div class="card card-outline card-gdp">

            <div class="row mt-3">
                <div class="col-2">

                </div>



                <div class="col-3">
                    <div class="form-group">
                        <select class="form-control form-control-sm select2" id="mat_search">
                            @foreach ($mat as $mat_one)
                                <option data-id="{{$mat_one->id}}">{{$mat_one->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <select class="form-control form-control-sm" id="month_search">
                            <option data-id="all">ทั้งหมด</option>
                            @foreach ($monthAll as $monthAll_one)
                                <option data-id="{{$monthAll_one}}">{{$monthAll_one}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <select class="form-control form-control-sm" id="year_search">
                            <option data-id="-1">ทั้งหมด</option>
                            @foreach ($yearFive as $yearFive_one)
                                <option data-id="{{$yearFive_one}}">{{$yearFive_one}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-success btn-sm" onclick="showTable()">ค้นหา</button>
                </div>
            </div>

            <div class="card-body p-0" id="mat_table">
                <table id="requsition_supply_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr>
                            <th scope="col" class="w-auto">วันที่ทำรายการ</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">ประเภท</th>
                            <th scope="col" class="w-auto">จำนวน</th>
                            <th scope="col" class="w-auto">คงเหลือ</th>
                            <th scope="col" class="w-auto">lot</th>
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

    function addChart() {
        $.ajax({
                    url: "{{route('inventory.supply.chart')}}",
                    type:"POST",
                    data:{
                        year: 2021,
                    },
                    success:function(data)
                    {
                        console.log(data);

                        // chart
                        var supplyChartCanvas = $('#supplyBarChart').get(0).getContext('2d')
                        var supplyData = {
                            labels: data.lable,
                            datasets: [{
                                // label: '# of Votes',
                                data: data.data,
                                backgroundColor: data.backgroundColor,
                                borderWidth: 1
                            }]
                        };

                        var supplyOptions = {
                            tooltips: {
                                displayColors: true,
                                callbacks:{
                                    mode: 'x',
                                },
                            },
                            scales: {
                                xAxes: [{
                                    // stacked: true,
                                    gridLines: {
                                        display: false,
                                    }
                                }],
                                yAxes: [{
                                    // stacked: true,
                                    ticks: {
                                        beginAtZero: true,
                                    },
                                    type: 'linear',
                                }]
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: false,
                            plugins: {
                                datalabels: {
                                    // color: 'blue',
                                    anchor : "end",
                                    align : "top",
                                }
                            }

                        }

                        //Create pie or douhnut chart
                        supplyBarChart = new Chart(supplyChartCanvas, {
                            type: 'bar',
                            data: supplyData,
                            options: supplyOptions
                        })
                    }
                })
    }

    function showTable() {



        let mat_search = $('#mat_search').find(':selected').data('id')
        let month_search = $('#month_search').find(':selected').data('id')
        let year_search = $('#year_search').find(':selected').data('id')

        $('#mat_table').html('');
        $('#mat_table').html(`
                <table id="requsition_supply_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="ogn-stock-yellow" >
                            <tr>
                                <th scope="col" class="w-auto">วันที่ทำรายการ</th>
                                <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                                <th scope="col" class="w-auto">ประเภท</th>
                                <th scope="col" class="w-auto">จำนวน</th>
                                <th scope="col" class="w-auto">คงเหลือ</th>
                                <th scope="col" class="w-auto">lot</th>
                            </tr>
                        </thead>
                        <tbody>
                    </tbody>
                </table>
        `);

        $('#requsition_supply_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.inventory.supply.list'))}}',
                    'data':{
                        mat_search: mat_search,
                        month_search: month_search,
                        year_search: year_search,
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'created_at' , class: 'text-center', render : function(data, type, row, meta){
                        var d = new Date(data);
                        return d.getDate().toString().padStart(2, '0') + '/' + (d.getMonth()+1) + '/' + d.getFullYear();
                    } },
                    { data: 'paper_no', render : function(data, type, row, meta){
                        return data;
                    }},
                    { data: 'type' , class: 'text-center', render : function(data, type, row, meta){
                        if (data == "lot") {
                            return `<span class="badge badge-success">รับ</span>`;
                        }else{
                            return `<span class="badge badge-danger">เบิก</span>`;
                        }
                    } },
                    { data: 'weight' , class: 'text-right', render : function(data, type, row, meta){
                        let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                        let total = formatter.format(data);
                        return total;
                    }},
                    { data: 'currentRemain' , class: 'text-right', render : function(data, type, row, meta){
                        let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                        let total = formatter.format(data);
                        return total;
                    }},
                    { data: 'lot' },
                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    { responsivePriority: 1, targets: [0,1,2] }
                ],

                "dom": '<"top d-none">rt<"bottom d-none position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
        })
    }

    $(function() {

        var seturl = "{{ url('/') }}";

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });


        addChart();

        $('.dropify').dropify();
        $('.select2').select2()

        let inventory_table = $('#inventory_table').DataTable({
            "pageLength": 10,
                'serverMethod': 'post',
                // 'order': [[1, 'asc']]
                'ajax': {
                    'url':"{{route('inventory.supply.chart')}}"
                },
                'columns': [
                    { data: 'name'},
                    { data: 'remain', class: 'text-right', render : function(data, type, row, meta){
                        let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                        let total = formatter.format(data);
                        return total;
                    }},
                    { data: 'name', render : function(data, type, row, meta){
                        return "ชิ้น"
                    }},
                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    // { responsivePriority: 1, targets: [0,1,2] }
                ],

                // language: {
                //     "url": "{{ asset('/vendor/datatables/th.json') }}"
                // },
                // "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
        })
    });
</script>
@endsection
