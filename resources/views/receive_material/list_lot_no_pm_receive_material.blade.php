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

        /* tooltip */
    </style>
@endsection

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>

                    <li class="breadcrumb-item active">LOT NO PM วัตถุดิบ</li>
                </ol>
            </div><!-- /.col -->
            <div>
                <br>
                <button class="btn btn-success" onclick="window.location.href='{{ route('print.lot.no.pm.material') }}'"><i
                        class="fa fa-print" aria-hidden="true"></i>
                    พิมพ์ใบกักกัน</button>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

@stop

@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card card-outline card-gdp">
                <div class="card-body p-0">
                    <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">

                    <table id="receive_material_table" class="table w-100 "
                        style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="ogn-stock-yellow">
                            <tr>
                                <th scope="col" class="w-auto">#</th>
                                <th scope="col" class="w-auto">วันที่รับเข้า</th>
                                <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                                <th scope="col" class="w-auto">Supplier</th>
                                <th scope="col" class="w-auto">รายละเอียด</th>
                                <th scope="col" class="w-auto">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- hovercard --}}



@endsection

@section('js')
    <script>
        $(function() {
            $('.dropify').dropify();

            var receive_material_table = $('#receive_material_table').DataTable({
                "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '{{ route('api.v1.receive.material.check.list.lot.no.pm') }}',
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
                            return row.brand_vendor.brand;
                        }
                    },
                    {
                        "data": null,
                        render: function(data, type, row, meta) {
                            return `<div style="text-align:center;"><a href="#"  class="details-control fas fa-list-alt text-lg text-ogn-green " ></a></div>`;
                        }
                    },
                    {
                        "data": 'id',
                        class: 'd-flex',
                        render: function(data, type, row, meta) {
                            let confirm_check = true;
                            $.each(row.material_lots, function(key, lot) {
                                if (lot.lot_no_pm == null || lot.lot_no_pm ==
                                    "ยังไม่ระบุ") {
                                    confirm_check = false;
                                }
                            })
                            if (confirm_check) {
                                $("#confirm_lot_" + row.id).removeClass('disabled')
                            } else {
                                $("#confirm_lot_" + row.id).addClass('disabled')
                            }

                            return `
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-danger reject-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-left"></i> ตีกลับไปตรวจสอบ</a>
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" id="confirm_lot_${row.id}" class="btn btn-outline-success confirm-btn btn-xs rounded-pill disabled confirm_lot_${row.id}  border ml-1"><i class="fas fa-arrow-circle-right"></i> เสร็จสิ้นการรับเข้า</a>
                                    `
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
                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
            })

            //ส่วนแสดงตารางรายละเอียด
            function format(receive) {
                // console.log(receive.material_lots)
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

                receiveMaterials.forEach(receive_item => {
                    id = receive_item.id;
                    lot = receive_item.lot;
                    name_material = receive_item.receive_mat_name;
                    total_weight = parseFloat(receive_item.weight_total / 1000);
                    let formatter = new Intl.NumberFormat('th-TH', {
                        currency: 'THB'
                    });
                    let total = formatter.format(total_weight);
                    // console.log(total)
                    coa = receive_item.coa;
                    exp = receive_item.exp;
                    mfg = receive_item.mfg;
                    lot_no_pm = receive_item.lot_no_pm;
                    mat_code = (receive_item.material && receive_item.material.trade_name !=
                            '' || receive_item.material && receive_item.material
                            .trade_name != null) ? receive_item.material && receive_item.material
                        .trade_name : receive_item.material && receive_item.material.itemcode;

                    // console.log(receive_item);
                    ref = "{{ asset('uploads/coa_material/') }}";

                    if (lot_no_pm != null) {
                        field_lot_no_pm =
                            `<span class='badge badge-pill btn-sm lot_span' style='text-align : center;font-size:15px;'>${lot_no_pm}</span>`;
                        field_action =
                            `<span class='badge badge-pill text-success w-75' style='text-align : center;font-size:15px;'>สร้างเลข Lot แล้ว</span>`;
                    } else {
                        field_lot_no_pm =
                            `<span class='badge badge-pill btn-sm lot_span' style='text-align : center;font-size:15px;'>ยังไม่ระบุ</span>`;
                        field_action =
                            `<a data-toggle="tooltip" data-placement="top" title="เพิ่มหมายเลข Lot.No. PM" type="button" style="" data-row-id="${receive_item.receive_material_id}" data-id="${id}" class="add-lot-pm"><i class="fas fa-edit text-warning"></i></a>`
                    }

                    if (mat_code != null) {
                        field_mat_code =
                            `<span class='badge badge-pill btn-sm mat_code_span' style='text-align : center;font-size:15px;'>${mat_code}</span>`;
                    } else {
                        field_mat_code =
                            `<span class='badge badge-pill btn-sm mat_code_span' style='text-align : center;font-size:15px;'>ยังไม่ระบุ</span>`;
                    }
                    //loop table

                    loop_table = '<tr>' +
                        '<td>' + lot + '</td>' +
                        '<td>' + name_material + '</td>' +
                        '<td>' + total + ' กิโลกรัม </td>' +
                        '<td>' + mfg + '</td>' +
                        '<td>' + exp + '</td>' +
                        '<td class="text-center"> ' + field_mat_code + '</td>' +
                        '<td class="text-center"> ' + field_lot_no_pm + '</td>' +
                        '<td class="text-center"> ' + field_action + '</td>' +
                        '</tr>';
                    table_body += loop_table;
                });


                var inner_table = `<table class="w-100 lot_table">
                    <tr>
                        <th style='width:15%'>ล็อต</th>
                        <th style='width:20%'>ชื่อวัตถุดิบ</th>
                        <th style=''>จำนวน</th>
                        <th style=''>mfg</th>
                        <th style=''>exp</th>
                        <th style='' class="text-center">รหัสวัตถุดิบ</th>
                        <th style='' class="text-center">Lot.No RM</th>
                        <th style='width:22%' class="text-center">จัดการ</th>
                    </tr>
                    ${table_body}
                </table>`;

                table =
                    '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"> รายละเอียด : ' +
                    inner_table + '</table>';

                return table;
            }

            $('#receive_material_table tbody').on('click', '.details-control', function() {
                var tr = $(this).closest('tr');
                var row = receive_material_table.row(tr);
                // console.log(receive_material_table)
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
            $('.select2').select2();

            $(document).on("click", ".add-lot-pm", function(e) {
                let obj = $(this);
                const id = obj.data('id');
                const row_id = obj.data('row-id');
                var formData = new FormData();

                formData.append("id", id);
                formData.append("lot_no_pm", $('#lotnopm').val());
                // formData.append("material_id", $('#mat_detail').val());
                formData.append("_token", $('#_token').val());

                $.ajax({
                    type: "post",
                    url: "{{ route('api.v1.receive.material.lot.no.pm.change') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            Swal.fire({
                                position: 'center-center',
                                icon: 'success',
                                title: 'เพิ่ม Lot No PM สำเร็จ',
                                showConfirmButton: false,
                                timer: 1500,
                            })

                            // obj.closest('tr').find('.lot_span').text(
                            //     getLotNoPM);
                            // obj.closest('tr').find('.mat_code_span').text(
                            //     getMatCode);
                            let confirm_check = true;
                            obj.closest('table').find('.lot_span').each(
                                function(key, lot) {
                                    if ($(lot).text() === "ยังไม่ระบุ") {
                                        confirm_check = false;
                                    }
                                });
                            obj.closest('table').find('.mat_code_span').each(
                                function(key, lot) {
                                    if ($(lot).text() === "ยังไม่ระบุ") {
                                        confirm_check = false;
                                    }
                                });
                            if (confirm_check) {
                                $(".confirm_lot_" + row_id).removeClass(
                                    'disabled')
                            } else {
                                $(".confiurm_lot_" + row_id).addClass('disabled')
                            }

                            receive_material_table.ajax.reload();
                            // window.location.assign(
                            //     "{{ route('receive.material.lot.no.pm') }}"
                            // );
                        } else {
                            Swal.fire({
                                position: 'center-center',
                                icon: 'warning',
                                title: 'เพิ่ม Lot No PM ไม่สำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }
                });

                // let in_html = `   <form name="validForm">
            //                     <input type="hidden" name="id" id="id" value="${id}" required>
            //                     <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}" >
            //                     <div class="row mb-2">
            //                         <h6>รหัสวัตถุดิบ</h6><br>
            //                         <select name="mat_detail" id="mat_detail" class="select2 form-control mb-2" required>
            //                             @foreach ($mat_details as $mat_detail)
            //                                 <option value="{{ $mat_detail->id }}">{{ $mat_detail->name }}</option>
            //                             @endforeach
            //                         </select>
            //                         {{-- <h6>กรอก Lot.No RM</h6><br>
                //                             <input class="form-control" type="text" name="lotnopm" id="lotnopm" value="" required> --}}
            //                     </div>
            //                 </form>
            //             `

                // Swal.fire({
                //     title: "กรุณาเลือกรหัสวัตถุดิบ",
                //     html: in_html,
                //     showCancelButton: true,
                //     confirmButtonText: 'ยืนยัน',
                //     cancelButtonText: 'ปิด',
                //     confirmButtonColor: '#649514',
                //     cancelButtonColor: '#a97551',
                // }).then((result) => {
                //     if (result.value) {
                //         getLotNoPM = $('#lotnopm').val();
                //         getMatCode = $('#mat_detail  option:selected').text();
                //         formData.append("id", id);
                //         formData.append("lot_no_pm", $('#lotnopm').val());
                //         formData.append("material_id", $('#mat_detail').val());
                //         formData.append("_token", $('#_token').val());

                //         $.ajax({
                //             type: "post",
                //             url: "{{ route('api.v1.receive.material.lot.no.pm.change') }}",
                //             data: formData,
                //             contentType: false,
                //             processData: false,
                //             cache: false,
                //             success: function(response) {
                //                 console.log(response);
                //                 if (response) {
                //                     Swal.fire({
                //                         position: 'center-center',
                //                         icon: 'success',
                //                         title: 'เพิ่ม Lot No PM สำเร็จ',
                //                         showConfirmButton: false,
                //                         timer: 1500,
                //                     })

                //                     obj.closest('tr').find('.lot_span').text(
                //                         getLotNoPM);
                //                     obj.closest('tr').find('.mat_code_span').text(
                //                         getMatCode);
                //                     let confirm_check = true;
                //                     obj.closest('table').find('.lot_span').each(
                //                         function(key, lot) {
                //                             if ($(lot).text() === "ยังไม่ระบุ") {
                //                                 confirm_check = false;
                //                             }
                //                         });
                //                     obj.closest('table').find('.mat_code_span').each(
                //                         function(key, lot) {
                //                             if ($(lot).text() === "ยังไม่ระบุ") {
                //                                 confirm_check = false;
                //                             }
                //                         });
                //                     if (confirm_check) {
                //                         $(".confirm_lot_" + row_id).removeClass(
                //                             'disabled')
                //                     } else {
                //                         $(".confiurm_lot_" + row_id).addClass('disabled')
                //                     }

                //                     // window.location.assign("{{ route('receive.material.lot.no.pm') }}");
                //                     // receive_material_table.ajax.reload();

                //                 } else {
                //                     Swal.fire({
                //                         position: 'center-center',
                //                         icon: 'warning',
                //                         title: 'เพิ่ม Lot No PM ไม่สำเร็จ',
                //                         showConfirmButton: false,
                //                         timer: 1500
                //                     })
                //                 }
                //             }
                //         });
                //     }
                // });
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
                            url: "{{ route('api.v1.receive.material.step.pending') }}",
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
                                    window.location.assign(
                                        "{{ route('receive.material.lot.no.pm') }}"
                                    );
                                    // receive_material_table.ajax.reload();
                                    // window.setTimeout(update, 1000);
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

            $(document).on('click', '.reject-btn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'ยืนยันการตีกลับไปหน้าตรวจสอบ?',
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
                            url: "{{ route('api.v1.receive.material.step.back.to.inspect') }}",
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



        });
    </script>
@endsection
