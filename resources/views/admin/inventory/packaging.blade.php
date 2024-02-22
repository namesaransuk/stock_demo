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

                    <li class="breadcrumb-item active">บรรจุภัณฑ์คงคลัง</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

@stop

@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card card-outline card-gdp">
                <div class="card-header ogn-stock-yellow text-left">
                    <h6 class="m-0"> บรรจุภัณฑ์ </h6>
                    <input type="hidden" name="company_id" id="company_id" value="{{ session('company') }}">
                </div>

                {{-- <div class="card-body p-3">
                <canvas id="packagingBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div> --}}

                <div class="card-body p-3">
                    <table id="inventory_table" class="table w-100 "
                        style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="table-borderless">
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
                <a type="submit" href="{{ route('packaging.export') }}"
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
                                    <option data-id="{{ $mat_one->id }}">{{ $mat_one->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <select class="form-control form-control-sm" id="month_search">
                                <option data-id="all">ทั้งหมด</option>
                                @foreach ($monthAll as $monthAll_one)
                                    <option data-id="{{ $monthAll_one }}">{{ $monthAll_one }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <select class="form-control form-control-sm" id="year_search">
                                <option data-id="-1">ทั้งหมด</option>
                                @foreach ($yearFive as $yearFive_one)
                                    <option data-id="{{ $yearFive_one }}">{{ $yearFive_one }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-success btn-sm" onclick="showTable()">ค้นหา</button>
                    </div>
                </div>

                <div class="card-body p-0" id="mat_table">
                    <table id="requsition_supply_table" class="table w-100 "
                        style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="ogn-stock-yellow">
                            <tr>
                                <th scope="col" class="w-auto">วันที่ทำรายการ</th>
                                <th scope="col" class="w-auto">ประเภท</th>
                                <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                                <th scope="col" class="w-auto">จำนวน</th>
                                <th scope="col" class="w-auto">คงเหลือ</th>
                                <th scope="col" class="w-auto">lot</th>
                                <th scope="col" class="w-auto">mfg</th>
                                <th scope="col" class="w-auto">exp</th>
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
                url: "{{ route('inventory.packaging.chart') }}",
                type: "POST",
                data: {
                    year: 2021,
                },
                success: function(data) {
                    console.log(data);

                    // chart
                    var supplyChartCanvas = $('#packagingBarChart').get(0).getContext('2d')
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
                            callbacks: {
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
                                anchor: "end",
                                align: "top",
                            }
                        }

                    }

                    //Create pie or douhnut chart
                    packagingBarChart = new Chart(supplyChartCanvas, {
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
                                <th scope="col" class="w-auto">ประเภท</th>
                                <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                                <th scope="col" class="w-auto">จำนวน</th>
                                <th scope="col" class="w-auto">คงเหลือ</th>
                                <th scope="col" class="w-auto">lot</th>
                                <th scope="col" class="w-auto">mfg</th>
                                <th scope="col" class="w-auto">exp</th>
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
                    'url': '{{ route('api.v1.inventory.packaging.list') }}',
                    'data': {
                        mat_search: mat_search,
                        month_search: month_search,
                        year_search: year_search,
                        company_id: {{ session('company') }},
                    }
                },
                'columns': [{
                        data: 'created_at',
                        class: 'text-center',
                        render: function(data, type, row, meta) {
                            var d = new Date(data);
                            return d.getDate().toString().padStart(2, '0') + '/' + (d.getMonth() + 1) +
                                '/' + d.getFullYear();
                        }
                    },
                    {
                        data: 'type',
                        class: 'text-center',
                        render: function(data, type, row, meta) {
                            if (data == "lot") {
                                return `<span class="badge badge-success">รับ</span>`;
                            } else {
                                if (data == 1) {
                                    return `<span class="badge badge-danger">เบิก</span>`;
                                } else if (data == 2) {
                                    return `<span class="badge badge-primary">คืน</span>`;
                                } else if (data == 3) {
                                    return `<span class="badge badge-warning">รอเคลม</span>`;
                                } else if (data == 4) {
                                    return `<span class="badge badge-primary">เคลม</span>`;
                                }
                            }
                        }
                    },
                    {
                        data: 'paper_no'
                    },
                    {
                        data: 'weight',
                        class: 'text-right',
                        render: function(data, type, row, meta) {
                            let formatter = new Intl.NumberFormat('th-TH', {
                                currency: 'THB'
                            });
                            let total = formatter.format(data);
                            return total;
                        }
                    },
                    {
                        data: 'currentRemain',
                        class: 'text-right',
                        render: function(data, type, row, meta) {
                            let formatter = new Intl.NumberFormat('th-TH', {
                                currency: 'THB'
                            });
                            let total = formatter.format(data);
                            return total;
                        }
                    },
                    {
                        data: 'lot'
                    },
                    {
                        data: 'mfg'
                    },
                    {
                        data: 'exp'
                    },
                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    {
                        responsivePriority: 1,
                        targets: [0, 1, 2]
                    }
                ],

                "dom": '<"top d-none">rt<"bottom d-none position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
            })
        }

        $(function() {

            var seturl = "{{ url('/') }}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            addChart();

            $('.dropify').dropify();
            $('.select2').select2()



            //ส่วนแสดงตารางรายละเอียด
            function format(receive) {
                console.log(receive)
                var receive_supply = receive.supply_cut;
                var lot;
                var name_supply;
                var total_weight;
                var coa;
                var exp;
                var mfg;
                var action;
                var loop_table;
                var table_body = "";
                var table;

                receive_supply.forEach(receive_item => {
                    lot = receive_item.supply_lot.lot;
                    name_supply = receive_item.supply_lot.supply.name;
                    total_weight = parseFloat(receive_item.qty);
                    let formatter = new Intl.NumberFormat('th-TH', {
                        currency: 'THB'
                    });
                    let total = formatter.format(total_weight);

                    mfg = receive_item.supply_lot.mfg
                    exp = receive_item.supply_lot.exp

                    ref = "{{ asset('uploads/coa_supply/') }}";
                    action = receive_item.action


                    if (action == 1) {
                        action =
                            "<td style='text-align:center;'> <span class='badge badge-pill ogn-stock-grey' style='text-align : center;'>รออนุมัติ</span> </td>"
                    } else {
                        action =
                            "<td style='text-align:center;'> <span class='badge badge-pill ogn-stock-green' style='text-align : center;'>อนุมัติการเบิก</span> </td>"
                    }
                    //loop table

                    loop_table = '<tr>' +

                        '<td>' + lot + '</td>' +

                        '<td>' + name_supply + '</td>' +
                        '<td>' + total + ' ชิ้น' + '</td>' +
                        action +

                        '</tr>';
                    table_body += loop_table;
                });

                var inner_table = `<table class="w-100">
                    <tr>
                        <th style='width:25%'>ล็อต</th>
                        <th style='width:25%'>ชื่อวัสดุสิ้นเปลือง</th>
                        <th style='width:10%' class="text-center">จำนวน</th>
                        <th style='width:10%;text-align:center;' class="text-center">สถานะ</th>
                    </tr>
                    ${table_body}
                </table>`;
                table =
                    '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"><caption class="text-center text-dark text-bold pt-0">รายละเอียดการเบิกสินค้า</caption> ' +
                    inner_table + '</table>';

                return table;
            }

            $('#requsition_supply_table tbody').on('click', '.details-control', function() {
                var tr = $(this).closest('tr');
                var row = requsition_supply_table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    row.child().addClass('bg-gradient-light')
                    tr.addClass('shown');
                }
            });

            $(document).on('click', '.confirm-btn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'เสร็จสิ้นการรับเข้า?',
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
                            url: "{{ route('api.v1.requsition.supply.step.to.history') }}",
                            data: {
                                'id': id
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response) {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'success',
                                        title: 'ยืนยันสำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500,
                                    })
                                    requsition_supply_table.ajax.reload();
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

            let inventory_table = $('#inventory_table').DataTable({
                "pageLength": 10,
                'serverMethod': 'post',
                // 'order': [[1, 'asc']]
                'ajax': {
                    'url': "{{ route('inventory.packaging.chart') }}"
                },
                'columns': [{
                        data: 'name'
                    },
                    {
                        data: 'remain',
                        class: 'text-right',
                        render: function(data, type, row, meta) {
                            let formatter = new Intl.NumberFormat('th-TH', {
                                currency: 'THB'
                            });
                            let total = formatter.format(data);
                            return total
                        }
                    },
                    {
                        data: 'vol'
                    },
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
