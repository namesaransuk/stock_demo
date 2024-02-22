@extends('adminlte::page')


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />

    <style>
        .fc-content{
            font-size: 15px;
            color: white;
        }
        .fc-toolbar{
            font-size: 12px !important;
        }
        .fc-toolbar .fc-left h2{
            font-size: 22px !important;
        }
        .fc-day-number {
            font-size: 15px;
            padding: 10px !important;
        }
    </style>

@endsection

@section('content')
<div class="">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-gdp mt-3">
                <div class="card-header ogn-stock-yellow text-left" >
                        <h6 class="m-0"> แผนการดำเนินงาน </h6>
                    </div>

                <div class="card-body p-0">
                    <div id="calendar" style="padding: 0px;">
                    </div>
                </div>
            </div>

        </div>

        <div class="col-12">
            <div class="card card-outline card-gdp mt-2">
                <div class="card-header ogn-stock-yellow text-left" >
                    <h6 class="m-0"> วัสดุสิ้นเปลือง </h6>
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

        </div>
    </div>
</div>
@endsection

@section('js')

    {{-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/th.min.js"></script>

<script>

    $(document).ready(function () {

        var seturl = "{{ url('/') }}";

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#calendar').fullCalendar({
            editable:false,
            events: seturl+'/set_plan/list',
            selectable:true,
            selectHelper: true,
            displayEventTime: true,
            height: 700,
            lang: 'th',
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },

        });

        addChart();

        let inventory_table = $('#inventory_table').DataTable({
            "pageLength": 10,
                'serverMethod': 'post',
                // 'order': [[1, 'asc']]
                'ajax': {
                    'url':"{{route('consumables.chart')}}"
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

    function addChart() {
        $.ajax({
                    url: "{{route('consumables.chart')}}",
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




</script>

@endsection
