@extends('adminlte::page')

@section('css')

@endsection

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">ตรวจสอบรายการนำเข้าวัตถุดิบ</li>
                    {{-- <li class="breadcrumb-item active">รับเข้าวัตถุดิบ</li> --}}
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-12">
                <br>
                <!-- <button type="button" class="btn" style="background-color: #D7FFB3;" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</button> -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
            <div class="card card-outline card-gdp">
                <div class="card-body p-0">

                    <table id="check_receive_table" class="table w-100"
                        style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="ogn-stock-yellow">
                            <tr>
                                <th scope="col" class="w-auto">#</th>
                                <th scope="col" class="w-auto text-left">วันที่รับเข้า</th>
                                <th scope="col" class="w-auto text-left">หมายเลขเอกสาร</th>
                                <th scope="col" class="w-auto">แก้ไขครั้งที่</th>
                                <th scope="col" class="w-auto text-left">Supplier</th>
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



@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();

            let check_receive_table = $('#check_receive_table').DataTable({

                "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '{{ route('api.v1.receive.material.check.list') }}',
                    'data': {
                        company_id: {{ session('company') }}
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
                        "data": null,
                        render: function(data, type, row, meta) {
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt " ></a></div>`;
                        }
                    },
                    {
                        "data": 'id',
                        class: 'd-flex',
                        render: function(data, type, row, meta) {
                            let check_confirm = "";
                            $.each(row.material_lots, function(key, lot) {
                                if (lot.quality_check === 0 || lot.transport_check === 0) {
                                    check_confirm = "disabled";
                                }
                            })
                            return `
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-danger reject-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-times-circle"></i> ปฏิเสธการรับเข้า</a>
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-warning return-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-left"></i> ส่งกลับไปแก้ไข</a>
                                        <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-outline-success ${check_confirm} confirm-btn btn-xs rounded-pill  border ml-1"><i class="fas fa-arrow-circle-right"></i> ยืนยันตรวจสอบ</a>
                                    `
                            // <a type="button" style="font-size:14px;" data-id="${row.id}" class="btn btn-danger cancel-btn btn-sm rounded-pill w-75  border ml-1"><i class="fas fa-times"></i> ตีกลับ </a>
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

                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
            });

            //ส่วนแสดงตารางรายละเอียด
            function format(receive) {

                var receiveMaterials = receive.material_lots;
                var lot;
                var name_material;
                var total_weight;
                var coa;
                var exp;
                var mfg;
                var id;
                var loop_table;
                var table;

                var table_body = "";

                receiveMaterials.forEach(receive_item => {
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
                    quality_check = receive_item.quality_check;
                    transport_check = receive_item.transport_check;
                    id = receive_item.id
                    let url = "{{ route('receive.material.view.check.material', '__id') }}".replaceAll(
                        "__id", id);
                    let url2 = "{{ route('receive.material.view.check.vehicle', '__id') }}".replaceAll(
                        "__id", id);
                    if (quality_check == 0) {
                        quality_check =
                            "<span class='badge badge-pill w-75' style='text-align : center;font-size:15px;'>รอการตรวจสอบคุณภาพ</span>"
                        actionBtn2 =
                            `<a type="button" style="font-size:14px;" href="${url}" data-id="${id}" class="btn btn-sm ogn-stock-green rounded-pill ml-1"><em class="fas fa-check-double"></em> คุณภาพ</a>`
                    }
                    if (quality_check == 1) {
                        quality_check =
                            "<span class='badge badge-pill btn-sm text-success w-75' style='text-align : center;font-size:15px;'>ตรวจสอบคุณภาพแล้ว</span>"
                        actionBtn2 =
                            `<a type="button" style="font-size:14px;" href="${url}" data-id="${id}" class="btn btn-sm bg-warning rounded-pill ml-1" ><em class="fas fa-edit"></em> แก้ไขตรวจสอบคุณภาพ</a>`
                    }

                    if (transport_check == 0) {
                        transport_check =
                            "<span class='badge badge-pill w-75' style='text-align : center;font-size:15px;'>รอการตรวจสอบสภาพขนส่ง</span> "
                        actionBtn1 =
                            `<a type="button" style="font-size:14px;" href="${url2}" data-id="${id}" class="btn btn-sm ogn-stock-green rounded-pill ml-1"><em class="fas fa-truck"></em> สภาพขนส่ง</a>`
                    }
                    if (transport_check == 1) {
                        transport_check =
                            "<span class='badge badge-pill text-success w-75' style='text-align : center;font-size:15px;'>ตรวจสอบสภาพขนส่งแล้ว</span> "
                        actionBtn1 =
                            `<a type="button" style="font-size:14px;" href="${url2}" data-id="${id}" class="btn btn-sm bg-warning rounded-pill  ml-1" ><em class="fas fa-edit"></em> แก้ไขตรวจสอบสภาพขนส่ง</a>`
                    }

                    //loop table

                    loop_table = '<tr>' +
                        '<td>' + lot + '</td>' +
                        '<td>' + name_material + '</td>' +
                        '<td>' + total + ' ' + wunit + '</td>' +
                        '<td>' + mfg + '</td>' +
                        '<td>' + exp + '</td>' +
                        // '<td class="text-center">' + transport_check + quality_check + '</td>' +
                        '<td class="text-center">' + quality_check + '</td>' +
                        // '<td class="text-center">' + actionBtn1 + actionBtn2 + '</td>' +
                        '<td class="text-center">' + actionBtn2 + '</td>' +
                        '</tr>';
                    table_body += loop_table;
                });

                var inner_table = `<table class="w-100">
                    <tr>
                        <th style='width:15%'>ล็อต</th>
                        <th style='width:15%'>ชื่อวัตถุดิบ</th>
                        <th style='width:15%'>น้ำหนัก</th>
                        <th style='width:10%'>mfg</th>
                        <th style='width:10%'>exp</th>
                        <th style='width:20%' class="text-center">สถานะ</th>
                        <th style='width:30%' class="text-center">ตรวจสอบ</th>
                    </tr>
                    ${table_body}
                </table>`;

                table =
                    '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"> <caption class="text-center text-dark text-bold pt-0">รายละเอียดวัตถุดิบนำเข้า</caption> ' +
                    inner_table + '</table>';

                return table;
            }

            $('#check_receive_table tbody').on('click', '.details-control', function() {
                var tr = $(this).closest('tr');
                var row = check_receive_table.row(tr);


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

            $(document).on('click', '.btn-modal', function() {
                let id = $(this).data('id');

                $.ajax({
                    type: "post",
                    url: "{{ route('api.v1.receive.material.check.view') }}",
                    data: {
                        "id": id
                    },
                    dataType: "json",
                    success: function(response) {}
                });

            });


            $(document).on('click', '.confirm-btn', function() {
                var formData = new FormData();
                formData.append('id', $(this).data('id'));
                formData.append('user_id', $('#user_id').val());

                const id = $(this).data('id');
                Swal.fire({
                    title: 'ยืนยันการส่งต่อเพื่อทำการกรอก Lot.No RM?',
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
                            url: "{{ route('api.v1.receive.material.step.lotnopm') }}",
                            data: formData,
                            contentType: false,
                            processData: false,
                            cache: false,
                            success: function(response) {
                                if (response) {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'success',
                                        title: 'ยืนยันสำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500,

                                    })
                                    check_receive_table.ajax.reload();
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

            $(document).on('click', '.return-btn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'ยืนยันการตีกลับไปหน้ารับเข้า?',
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
                            url: "{{ route('api.v1.receive.material.step.back.to.receive') }}",
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
                                    check_receive_table.ajax.reload();
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
                var formData = new FormData();
                let in_html = `   <form name="validForm">
                                        <input type="hidden" name="id" id="id" value="${id}" required>
                                        <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}" >
                                        <div class="row mb-2 center mt-2" >
                                            <h6 >เหตุผลที่ตีกลับ</h6><br>
                                            <input class="form-control" type="text" name="reject_detail" id="reject_detail" value="" required>
                                        </div>
                                    </form>
                                `

                Swal.fire({
                    title: "ปฏิเสธการรับเข้า",
                    html: in_html,
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ปิด',
                    confirmButtonColor: '#649514',
                    cancelButtonColor: '#a97551',
                }).then((result) => {
                    if (result.value) {
                        formData.append("id", id);
                        formData.append("reject_detail", $('#reject_detail').val());
                        formData.append("_token", $('#_token').val());

                        $.ajax({
                            type: "post",
                            url: "{{ route('api.v1.receive.material.reject') }}",
                            data: formData,
                            contentType: false,
                            processData: false,
                            cache: false,
                            success: function(response) {
                                if (response == "true") {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'success',
                                        title: 'ทำรายการสำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500,
                                    })
                                    check_receive_table.ajax.reload();

                                } else {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'warning',
                                        title: 'กรุณากรอกหมายเหตุ',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    check_receive_table.ajax.reload();

                                }
                            }
                        });
                    }
                });
            })
        }); //close ready function
    </script>
@endsection
