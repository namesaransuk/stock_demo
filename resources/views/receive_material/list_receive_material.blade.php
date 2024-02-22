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

        .disabled-link {
            pointer-events: none;
        }
    </style>
@endsection

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">รับเข้าวัตถุดิบ</li>
                </ol>
            </div>
            <div>
                <br>
                <a class="btn ogn-stock-yellow " href="{{ route('receive.material.create') }}"><i class="fa fa-plus-circle"
                        aria-hidden="true"></i> เพิ่มรายการ</a>
                {{-- <button type="button"  data-toggle="modal" data-target="#myModal"></button> --}}
                <button class="btn btn-warning" onclick="window.location.href='{{ route('print.receive.material') }}'"><i class="fa fa-print" aria-hidden="true"></i>
                    พิมพ์ใบกักกัน</button>
            </div>
        </div>
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-gdp">
                {{-- <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                    <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รับเข้าวัตถุดิบ และ บรรจุภัณฑ์</h6>
                </div>
                <div class="p-2">
                    <div class="float-right">
                        <input type="search" id="custom-search-input" class="form-control form-control-sm"
                                placeholder="ค้นหา">
                    </div>
                    <a href="" type="button" style=""
                        class="btn rounded ml-2"><em class="fas fa-plus-circle text-success"></em>
                        เพิ่มรายการ</a>
                    <div class="card-title mb-0"></div>
                </div> --}}
                <div class="card-body p-0">

                    <table id="receive_material_table" class="table w-100 "
                        style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="ogn-stock-yellow">
                            <tr>
                                <th scope="col" class="w-auto">#</th>
                                <th scope="col" class="w-auto">วันที่รับเข้า</th>
                                <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                                <th scope="col" class="w-auto">หมายเลขเอกสารบิลส่งของ</th>
                                <th scope="col" class="w-auto">แก้ไขครั้งที่</th>
                                <th scope="col" class="w-auto">Supplier</th>
                                <th scope="col" class="w-auto">หมายเลข PO</th>
                                <th scope="col" class="w-auto">เอกสาร PO</th>
                                <th scope="col" class="w-auto">รายละเอียด</th>

                                <th scope="col" class="w-auto " style="text-align: center !important;">จัดการ</th>
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

            let receive_material_table = $('#receive_material_table').DataTable({
                "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '{{ route('api.v1.receive.material.list') }}',
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
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return `${(row.bill_no == '') ? 'ไม่มีหมายเลขเอกสารบิลส่งของ' : row.bill_no}`;
                        }
                    },
                    {
                        data: 'edit_times',
                        class: 'text-center'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return row.brand_vendor.brand;
                        }
                    },
                    {
                        data: 'po_no'
                    },
                    {
                        "data": null,
                        render: function(data, type, row, meta) {
                            ref = "{{ asset('uploads/po_material/') }}";

                            return ' <a class=" "  href=" ' + ref + '/' + row.po_file_name +
                                ' " download><i class="fas fa-download p-1 "></i></a>';
                        }
                    },
                    {
                        "data": null,
                        render: function(data, type, row, meta) {
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt " ></a></div>`;
                        }
                    },

                    {
                        data: 'id',
                        class: 'd-flex',
                        render: function(data, type, row, meta) {
                            let url2 = "{{ route('receive.material.edit', '__id') }}".replaceAll(
                                "__id", row.id);
                            let url3 = "{{ route('receive.material.history', '__id') }}".replaceAll(
                                "__id", row.id)

                            if (row.edit_times != 0) {
                                action =
                                    `<a data-toggle="tooltip" data-placement="top" title="ประวัติการแก้ไข" type="" style="" href="${url3}"  data-id="${row.id}" id="myModal-edit"  class=" reset-me btn-modal "  ><i class="fas fa-history p-1 text-indigo"></i> </a>`;
                            } else {
                                action =
                                    '<a type="" style=""  id="myModal-edit"  class= "reset-me btn-modal " ><i class="fas fa-history p-1 text-muted"></i> </a>';
                            }

                            // if (transport_check == 0) {
                            //     transport_check =
                            //         "<span class='badge badge-pill w-75' style='text-align : center;font-size:15px;'>รอการตรวจสอบสภาพขนส่ง</span> "
                            //     actionBtn1 =
                            //         `<a type="button" style="font-size:14px;" href="${url2}" data-id="${id}" class="btn btn-sm ogn-stock-green rounded-pill ml-1"><em class="fas fa-truck"></em> สภาพขนส่ง</a>`
                            // }

                            let check_confirm = "";
                            $.each(row.material_lots, function(key, lot) {
                                // console.log(lot.transport_check);
                                if (lot.transport_check === 0) {
                                    check_confirm = "disabled-link";
                                    button_color = "text-muted";
                                } else {
                                    button_color = "text-success";
                                }
                            })

                            apply_next =
                                `<a type="button"  style="" data-id="${row.id}"  class="btn-update-inspect_ready reset-me btn-modal ${check_confirm}" data-toggle="tooltip" data-placement="top" title="ส่งต่อเพื่อตรวจสอบ"><i class="fas fa-arrow-circle-right p-1 ${button_color}"></i> </a>`;
                            // console.log(check_confirm);

                            return `<div class=" w-100 m-auto" style="text-align:center;">
                                    <a data-toggle="tooltip" data-placement="top" title="แก้ไข" type="" style="" href="${url2}"  data-id="${row.id}" id="myModal-edit"  class="reset-me btn-modal" ><i class="fas fa-edit text-warning p-1"></i> </a>
                                    ${action}
                                    <a type="" style="cursor: pointer;"  data-id="${row.id}" id="myModal-edit"  class="buttom_delete btn-modal"><i class="fas fa-trash p-1 text-danger "></i> </a>
                                    ${apply_next}
                                    </div>`;
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

                drawCallback: function(settings) {

                    @cannot('admin')
                        $('.buttom_delete').remove();
                    @endcan

                },

                // language: {
                //     "url": "{{ asset('/vendor/datatables/th.json') }}"
                // },
                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'


            })

            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })

            //ส่วนแสดงตารางรายละเอียด
            function format(receive) {
                var receiveMaterials = receive.material_lots;
                var id;
                var lot;
                var name_material;
                var total_weight;
                var coa;
                var exp;
                var mfg;

                var loop_table;
                var table_body = "";
                var table;
                var truck;
                let url2;

                receiveMaterials.forEach(receive_item => {
                    id = receive_item.id;
                    lot = receive_item.lot;
                    name_material = receive_item.receive_mat_name;
                    total_weight = parseFloat(receive_item.weight_total);
                    let formatter = new Intl.NumberFormat('th-TH', {
                        currency: 'THB'
                    });
                    let wunit = "กรัม";
                    if (receive_item.weight_total >= 1000000) {
                        total_weight = parseFloat(receive_item.weight_total / 1000000);
                        wunit = "ตัน";
                    } else if (receive_item.weight_total >= 1000) {
                        total_weight = parseFloat(receive_item.weight_total / 1000);
                        wunit = "กิโลกรัม";
                    }
                    let total = formatter.format(total_weight);

                    coa = receive_item.coa;
                    exp = receive_item.exp;
                    mfg = receive_item.mfg;
                    action = receive_item.action;
                    ref = "{{ asset('uploads/coa_material/') }}";

                    // quality_check = receive_item.quality_check;
                    transport_check = receive_item.transport_check;
                    id = receive_item.id

                    if (coa == "0" || coa == null) {
                        action2 =
                            '<td style="text-align:center;"> <span class="badge bg-warning text-dark">ยังไม่เพิ่มเอกสาร</span>' +
                            '</td>'
                    } else {
                        action2 = '<td style="text-align:center;"> <a class=" "  href=" ' + ref + '/' +
                            coa + ' " download><i class="fas fa-download p-1 "></i></a>' + '</td>'
                    }

                    // url2 = "{{ route('receive.material.view.check.vehicle', '__id') }}"
                    //     .replaceAll(
                    //         "__id", id);

                    // truck =
                    //     `<a data-toggle="tooltip" title="ตรวจสอบสภาพขนส่ง" type="" style="" href="${url2}" data-id="${id}" class="ogn-stock-green rounded-circle p-2 mt-3"><i class="fas fa-truck text-white"></i></a>`
                    // // `<a type="button" style="font-size:14px;" href="${url2}" data-id="${id}" class="btn btn-sm ogn-stock-green rounded-pill ml-1"><em class="fas fa-truck"></em> สภาพขนส่ง</a>`

                    // if (transport_check == 0) {
                    //     transport_check =
                    //         "<span class='badge badge-pill w-75' style='text-align : center;font-size:15px;'>รอการตรวจสอบสภาพขนส่ง</span> "
                    //     actionBtn1 =
                    //         // `<a data-toggle="tooltip" title="ตรวจสอบสภาพขนส่ง" type="" style="font-size:14px;" href="${url2}" data-id="${id}" class="ogn-stock-green rounded-circle mt-1 pt-2 pb-2 pl-2 pr-2"><i class="fas fa-truck text-white"></i></a>`
                    //         `<a type="button" style="font-size:14px;" href="${url2}" data-id="${id}" class="btn btn-sm ogn-stock-green rounded-pill ml-1"><em class="fas fa-truck"></em> สภาพขนส่ง</a>`
                    // }
                    // if (transport_check == 1) {
                    //     transport_check =
                    //         "<span class='badge badge-pill text-success w-75' style='text-align : center;font-size:15px;'>ตรวจสอบสภาพขนส่งแล้ว</span> "
                    //     actionBtn1 =
                    //         // `<a data-toggle="tooltip" title="แก้ไขตรวจสอบสภาพขนส่ง" type="" style="font-size:14px;" href="${url2}" data-id="${id}" class="bg-warning rounded-circle mt-1 pt-2 pb-2 pl-2 pr-2"><i class="fas fa-edit text-white"></i></a>`
                    //         `<a type="button" style="font-size:14px;" href="${url2}" data-id="${id}" class="btn btn-sm bg-warning rounded-pill  ml-1" ><em class="fas fa-edit"></em> แก้ไขตรวจสอบสภาพขนส่ง</a>`
                    // }

                    //loop table

                    loop_table = '<tr>' +
                        '<td>' + lot + '</td>' +
                        '<td>' + name_material + '</td>' +
                        '<td style="text-align:center;">' + total + ' ' + wunit + '</td>' +
                        '<td style="text-align:center;">' + mfg + '' + '</td>' +
                        '<td style="text-align:center;">' + exp + '' + '</td>' +
                        action2 +
                        // '<td style="text-align:center;">' + truck + '' + '</td>' +
                        // '<td class="text-center">' + actionBtn1 + '</td>' +
                        '</tr>';
                    table_body += loop_table;
                });
                var inner_table =
                    `<table class="w-100">
                        <tr>
                            <th style='width:15%'>ล็อตสินค้า</th>
                            <th style='width:15%'>ชื่อวัตถุดิบ</th>
                            <th style='width:15%' class="text-center">น้ำหนัก</th>
                            <th style='width:10%' class="text-center">MFG</th>
                            <th style='width:10%' class="text-center">EXP</th>
                            <th style='width:15%' class="text-center">ใบ COA</th>
                        </tr>
                        ${table_body}
                    </table>`;

                table =
                    '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"> <caption class="text-center text-dark text-bold pt-0">รายละเอียดวัตถุดิบนำเข้า</caption>' +
                    inner_table + '</table>';

                return table;
            }

            $('#receive_material_table tbody').on('click', '.details-control', function() {
                var tr = $(this).closest('tr');
                var row = receive_material_table.row(tr);
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

            $(document).on('click', '.btn-update-inspect_ready', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'ยืนยันการส่งต่อเพื่อทำการตรวจสอบ?',
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
                            url: "{{ route('api.v1.receive.material.edit.inspect.ready') }}",
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
                                    receive_material_table.ajax.reload();
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

            $(document).on('click', '.buttom_delete', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'ยืนยันการลบ?',
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
                            url: "{{ route('api.v1.receive.material.delete') }}",
                            data: {
                                'id': id
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response) {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'success',
                                        title: 'ลบสำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500,

                                    })
                                    receive_material_table.ajax.reload();
                                } else {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'warning',
                                        title: 'ลบไม่สำเร็จ',
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
