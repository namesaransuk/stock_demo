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

                    <li class="breadcrumb-item active">ประวัติการเบิกวัตถุดิบ</li>
                </ol>
            </div><!-- /.col -->
            <div>
                <br>
                {{-- <a class="btn ogn-stock-yellow " href="{{route('requisition.material.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a> --}}
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

                    <table id="requisition_material_table" class="table w-100 "
                        style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="ogn-stock-yellow">
                            <tr>
                                <th scope="col" class="w-auto">#</th>
                                <th scope="col" class="w-auto">วันที่รับเข้า</th>
                                <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                                <th scope="col" class="w-auto">ชื่อสินค้า</th>
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

            let requisition_material_table = $('#requisition_material_table').DataTable({
                "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '{{ route('api.v1.requsition.material.history.list') }}',
                    'data': {
                        company_id: {{ session('company') }},
                    }
                },
                'columns': [{
                        data: 'id'
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'paper_no'
                    },
                    {
                        data: 'product_name'
                    },
                    {
                        data: 'edit_times',
                        class: 'text-center'
                    },
                    {
                        "data": null,
                        render: function(data, type, row, meta) {
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt " ></a></div>`;
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            ref = "{{ url('/report/requsition/material/pdf/') }}";
                            return ' <a class=" "  href=" ' + ref + '/' + data +
                                ' " ><i class="fas fa-download p-1 "></i></a>';
                        }
                    },

                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    {
                        responsivePriority: 1,
                        targets: [0, 1, 2]
                    }
                ],
                // language: {
                //     "url": "{{ asset('/vendor/datatables/th.json') }}"
                // },
                "dom": '<"top my-1 mr-1"f>rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
            })

            function convert2Unit(weight) {
                var total_weight = parseFloat(weight);
                let wunit = "กรัม";
                if (weight >= 1000000) {
                    total_weight = parseFloat(weight / 1000000);
                    wunit = "ตัน";
                } else if (weight >= 1000) {
                    total_weight = parseFloat(weight / 1000);
                    wunit = "กิโลกรัม";
                }
                return {
                    "weight": total_weight,
                    "unit": wunit
                }
            }

            //ส่วนแสดงตารางรายละเอียด
            function format(requisition) {
                console.log(requisition)
                var requisitionMaterials = requisition.materialCutReturns;
                var lot;
                var name_material;
                var total_weight;
                var coa;
                var exp;
                var mfg;

                var loop_table;
                var table_body = "";
                var table;

                requisitionMaterials.forEach(requisition_item => {
                    // console.log(requisition_item)
                    lot = requisition_item.material_lot.lot_no_pm;
                    name_material = requisition_item.material_lot.material.name;
                    let formatter = new Intl.NumberFormat('th-TH', {
                        currency: 'THB'
                    });

                    total_weight_obj = convert2Unit(requisition_item.weight)

                    total_weight_r = 0;
                    use_weight = 0;
                    let total_r = "-";
                    let use_r = "-";
                    if (requisition_item.weight_r >= 0) {
                        total_weight_r_obj = convert2Unit(requisition_item.weight_r);
                        use_weight_obj = convert2Unit(requisition_item.weight - requisition_item.weight_r);
                    }


                    coa = requisition_item.material_lot.coa;
                    exp = requisition_item.material_lot.exp;
                    mfg = requisition_item.material_lot.mfg;
                    action = requisition_item.material_lot.action;
                    ref = "{{ asset('uploads/coa_material/') }}";

                    //loop table

                    loop_table = '<tr>' +

                        '<td>' + lot + '</td>' +
                        '<td>' + name_material + '</td>' +
                        '<td style="text-align:center;">' + mfg + '</td>' +
                        '<td style="text-align:center;">' + exp + '</td>' +
                        '<td class="text-right">' + formatter.format(total_weight_obj.weight) + ' ' +
                        total_weight_obj.unit + '</td>' +
                        '<td class="text-right">' + formatter.format(use_weight_obj.weight) + ' ' +
                        use_weight_obj.unit + '</td>' +
                        '<td class="text-right">' + formatter.format(total_weight_r_obj.weight) + ' ' +
                        total_weight_r_obj.unit + '</td>' +
                        '<td style="text-align:center;"> <a class=" "  href=" ' + ref + '/' + coa +
                        ' " download><i class="fas fa-download p-1 "></i></a>' + '</td>' +

                        '</tr>';
                    table_body += loop_table;
                });
                var inner_table = `<table class="w-100">
                    <tr>
                        <th >Lot</th>
                        <th >ชื่อวัตถุดิบ</th>
                        <th class="text-center">MFG.</th>
                        <th class="text-center">EXP.</th>
                        <th class="text-center">เบิก kg.</th>
                        <th class="text-center">ใช้จริง kg.</th>
                        <th class="text-center">คืน kg.</th>
                        <th class="text-center">COA.</th>
<!--                        <th class="text-center">ACTION</th>-->
                    </tr>
                    ${table_body}
                </table>`;

                table =
                    '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"> <caption class="text-center text-dark text-bold pt-0">รายละเอียดการเบิก/คืนวัตถุดิบ</caption>' +
                    inner_table + '</table>';

                return table;
            }

            $('#requisition_material_table tbody').on('click', '.details-control', function() {
                var tr = $(this).closest('tr');
                var row = requisition_material_table.row(tr);
                console.log(requisition_material_table)
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

        });
    </script>
@endsection
