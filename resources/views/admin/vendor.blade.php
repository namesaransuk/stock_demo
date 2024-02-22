@extends('adminlte::page')

@section('css')
@endsection

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">บริษัทคู่ค้า</li>
                </ol>
            </div><!-- /.col -->
            <div>
                <br>
                <button type="button" class="btn bg-gradient-green border btn-modal" data-toggle="modal"
                    data-target="#myModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</button>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-gdp">
                <div class="card-header ogn-stock-yellow text-left">
                    <h6 class="m-0">บริษัทคู่ค้า</h6>
                </div>
                <div class="p-2">
                    <div class="float-right">
                        <input type="search" id="custom-search-input" class="form-control form-control-sm"
                            placeholder="ค้นหา">
                    </div>

                    <div class="card-title mb-0"></div>
                </div>
                <div class="card-body p-0">

                    <table id="vendor_table" class="table w-100"
                        style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="text-center">
                            <tr>
                                <th scope="col" class="w-auto">#</th>
                                <th scope="col" class="w-auto">ชื่อแบรนด์</th>
                                <th scope="col" class="w-auto">ตัวย่อแบรนด์</th>
                                <th scope="col" class="w-auto">ที่อยู่</th>
                                <th scope="col" class="w-auto">ชื่อผู้ติดต่อ</th>
                                <th scope="col" class="w-auto">เบอร์โทรผู้ติดต่อ</th>
                                <th scope="col" class="w-auto">ประเภท</th>
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


    <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #9BC56D;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">เพิ่มรายการบริษัทคู่ค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="" class="form-label">ชื่อแบรนด์</label>
                                <input type="text" id="brand" class="form-control">
                                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                                <input type="hidden" name="id" id="id" value="">
                                <small id="checkbrand"></small>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="" class="form-label">ตัวย่อชื่อแบรนด์</label>
                                <input type="text" id="abbreviation" class="form-control" oninput="this.value = this.value.toUpperCase()" maxlength="3">
                                <small id="checkabbreviation"></small>
                            </div>
                            <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 ">
                                <label for="" class="form-label">ที่อยู่</label>
                                <textarea type="text" id="address" row="3" class="form-control"></textarea>
                                <small id="checkaddress"></small>
                            </div>
                            {{-- <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 ">
                                <label for="" class="form-label">ที่อยู่</label>
                                <input type="text" id="address" class="form-control">
                                <small id="checkaddress"></small>
                            </div> --}}
                            <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 ">
                                <label for="" class="form-label">ชื่อผู้ติดต่อ</label>
                                <input type="text" id="contact_name" class="form-control">
                                <small id="checkcontact_name"></small>
                            </div>
                            <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 ">
                                <label for="" class="form-label">เบอร์โทรผู้ติดต่อ</label>
                                <input type="text" id="contact_number" class="form-control">
                                <small id="checkcontact_number"></small>
                            </div>
                            <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 ">
                                <label for="" class="form-label">ประเภท</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="1">เจ้าของแบรนด์</option>
                                    <option value="2">บริษัทขนส่ง</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn ogn-stock-grey " style="color:black;" data-dismiss="modal"><em
                            class="fas fa-close"></em> ยกเลิก</button>
                    <button type="button" class="btn ogn-stock-green text-white btn-save " style=" color:black;"><em
                            class="fas fa-save "></em> บันทึก</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            let vendor_table = $('#vendor_table').DataTable({
                "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': "{{ route('api.v1.vendor.list') }}"
                },
                'columns': [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'brand'
                    }, //กำหนดข้อมูลที่นำมาแสดง
                    {
                        data: 'abbreviation'
                    }, //กำหนดข้อมูลที่นำมาแสดง
                    {
                        data: 'address'
                    },
                    {
                        data: 'contact_name'
                    },
                    {
                        data: 'contact_number'
                    },
                    {
                        data: 'type',
                        render: function(data, type, row, meta) {
                            if (row.type === 1) {
                                data = `เจ้าของแบรนด์`;
                            } else {
                                data = `บริษัทขนส่ง`;
                            }
                            return data;
                        }
                    },

                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return `<div class="dropdown show">
                                    <a class="btn btn-sm text-secondary rounded border ml-1" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit"></i> จัดการ</a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a type="button" style=""  data-id="${row.id}" id="myModal-edit"  class="dropdown-item reset-me btn-modal "><i class="fas fa-edit"></i> แก้ไข</a>
                                        <a type="button" style="" data-id="${row.id}" class="buttom_delete dropdown-item delete-me btn-delete"><em class="fas fa-trash-alt"></em> ลบ</a>
                                    </div>
                                </div>`;
                        }
                    },

                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    {
                        responsivePriority: 1,
                        targets: [0, 1, 5, 6]
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

            $('#custom-search-input').keyup(function() {
                vendor_table.search($(this).val()).draw();
            })

            $(document).on('click', '.btn-modal', function() {
                $('#myModal').modal('show');
                let id = $(this).data('id');
                $('#id').val(id);

                if (!id) {
                    $('#brand').val('');
                    $('#abbreviation').val('');
                    $('#address').val('');
                    $('#contact_name').val('');
                    $('#contact_number').val('');
                    $('.modal-title').text('เพิ่มรายการบริษัทคู่ค้า');
                } else {
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.vendor.view.edit') }}",
                        data: {
                            'id': id
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#brand').val(response.brand);
                            $('#abbreviation').val(response.abbreviation);
                            $('#address').val(response.address);
                            $('#contact_name').val(response.contact_name);
                            $('#contact_number').val(response.contact_number);
                            $('#type').val(response.type);
                            $('.modal-title').text('เพิ่มรายการบริษัทคู่ค้า');
                        }
                    });
                }
            });

            $('.btn-save').on('click', function() {

                var formData = {
                    brand: $('#brand').val(),
                    abbreviation: $('#abbreviation').val(),
                    address: $('#address').val(),
                    contact_name: $('#contact_name').val(),
                    contact_number: $('#contact_number').val(),
                    type: $('#type').val(),

                    token: $("#_token").val(),
                    id: $('#id').val()
                }

                if (!formData.id) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.vendor.validate') }}",
                        data: formData,
                        dataType: "json",
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({
                                    title: 'ยืนยันการเพิ่มบริษัทคู่ค้า?',
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
                                            url: "{{ route('api.v1.vendor.create') }}",
                                            data: formData,
                                            dataType: "json",
                                            success: function(response) {

                                                if (response) {
                                                    Swal.fire({
                                                        position: 'center-center',
                                                        icon: 'success',
                                                        title: 'เพิ่มรายการสำเร็จ',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    })
                                                    window.location
                                                        .reload();
                                                } else {
                                                    Swal.fire({
                                                        position: 'center-center',
                                                        icon: 'error',
                                                        title: 'เพิ่มรายการไม่สำเร็จ',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    })
                                                }
                                            }
                                        });
                                    }
                                });
                            } else {
                                if ($('#brand').val() === '') {

                                    $('#checkbrand').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkbrand').hide()
                                }

                                if ($('#abbreviation').val() === '') {

                                    $('#checkabbreviation').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkabbreviation').hide()
                                }

                                if ($('#address').val() === '') {

                                    $('#checkaddress').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkaddress').hide()
                                }

                                if ($('#contact_name').val() === '') {

                                    $('#checkcontact_name').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkcontact_name').hide()
                                }

                                if ($('#contact_number').val() === '') {

                                    $('#checkcontact_number').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkcontact_number').hide()
                                }
                            }
                        }
                    });
                } else {
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.vendor.validate') }}",
                        data: formData,
                        dataType: "json",
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({
                                    title: 'ยืนยันการแก้ไขบริษัทคู่ค้า?',
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
                                            url: "{{ route('api.v1.vendor.edit') }}",
                                            data: formData,
                                            dataType: "json",
                                            success: function(response) {

                                                if (response) {
                                                    Swal.fire({
                                                        position: 'center-center',
                                                        icon: 'success',
                                                        title: 'แก้ไขรายการสำเร็จ',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    })
                                                    window.location
                                                        .reload();
                                                } else {
                                                    Swal.fire({
                                                        position: 'center-center',
                                                        icon: 'error',
                                                        title: 'แก้ไขรายการไม่สำเร็จ',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    })
                                                }
                                            }
                                        });
                                    }
                                });
                            } else {
                                if ($('#brand').val() === '') {

                                    $('#checkbrand').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkbrand').hide()
                                }

                                if ($('#abbreviation').val() === '') {

                                    $('#checkabbreviation').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkabbreviation').hide()
                                }

                                if ($('#address').val() === '') {

                                    $('#checkaddress').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkaddress').hide()
                                }

                                if ($('#contact_name').val() === '') {

                                    $('#checkcontact_name').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkcontact_name').hide()
                                }

                                if ($('#contact_number').val() === '') {

                                    $('#checkcontact_number').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkcontact_number').hide()
                                }
                            }
                        }
                    });

                }

            });


        });
    </script>
@endsection
