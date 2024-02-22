@extends('adminlte::page')

@section('css')
    <style>
        .hide,
        .name_brand,
        .abbreviation_brand {
            display: none
        }
    </style>
@endsection

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">บรรจุภัณฑ์</li>
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
                    <h6 class="m-0">บรรจุภัณฑ์</h6>
                    <input type="hidden" name="company_id" id="company_id" value="{{ session('company') }}">
                </div>
                <div class="p-2">
                    <div class="float-right">
                        <input type="search" id="custom-search-input" class="form-control form-control-sm"
                            placeholder="ค้นหา">
                    </div>

                    <div class="card-title mb-0"></div>
                </div>
                <div class="card-body p-0">

                    <table id="package_table" class="table w-100"
                        style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="text-center">
                            <tr>
                                <th scope="col" class="w-auto">#</th>
                                <th scope="col" class="w-auto">รายการบรรจุภัณฑ์</th>
                                <th scope="col" class="w-auto">เลขบรรจุภัณฑ์</th>
                                <th scope="col" class="w-auto">ปริมาณบรรจุต่อหน่วย</th>
                                <th scope="col" class="w-auto">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header ogn-stock-green" style="">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">เพิ่มรายการบรรจุภัณฑ์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 ">
                                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                                <input type="hidden" name="id" id="id" value="">
                                <label for="name" class="form-label">ชื่อบรรจุภัณฑ์</label>
                                <input type="text" id="name" class="form-control">
                                <small id="checkname"></small>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 ">
                                <label for="" class="form-label">ประเภทวัสดุ</label>
                                <select name="" id="type" class="form-control">
                                    <option selected disabled>เลือกประเภทวัสดุ</option>
                                    @foreach ($packagingUnits as $packagingUnit)
                                        <option value="{{ $packagingUnit->id }}">{{ $packagingUnit->name }}</option>
                                    @endforeach
                                </select>
                                <small id="checktype"></small>
                            </div>
                            <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 ">
                                <label for="weight_per_qty" class="form-label">ปริมาณบรรจุต่อหน่วย</label>
                                <input type="number" id="weight_per_qty" class="form-control">
                                <small id="checkweight_per_qty"></small>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 ">
                                <label for="volumetric_unit" class="form-label">หน่วยนับ</label>
                                <input type="text" id="volumetric_unit" class="form-control">
                                <small id="checkvolumetric_unit"></small>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="row mb-3 brand-panel">
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="" class="form-label">แบรนด์</label>
                                <input type="hidden" name="" id="mode" value="1">
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                                <small id="checkbrand"><button type="button" class="btn btn-link p-0 add-brand">
                                        <p class="text_add_brand">เพิ่มแบรนด์ใหม่</p>
                                    </button></small>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                <select name="" id="brand_id" style="min-width: 20%"
                                    class="form-control select2 brand_id select2">
                                    <option selected>เลือกแบรนด์</option>
                                    @foreach ($brands as $brand_one)
                                        <option value="{{ $brand_one->id }}">{{ $brand_one->brand }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                {{-- <label for="" class="form-labe name_brand">ชื่อแบรนด์</label> --}}
                                <input type="text" name="" id="name_brand" class="form-control name_brand"
                                    placeholder="ชื่อแบรนด์">
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                {{-- <label for="" class="form-label abbreviation_brand">ตัวย่อแบรนด์</label> --}}
                                <input type="text" name="" id="abbreviation_brand"
                                    class="form-control abbreviation_brand" placeholder="ตัวย่อแบรนด์ 3 หลัก"
                                    oninput="this.value = this.value.toUpperCase()" maxlength="3">
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

            $('.select2').select2({
                width: "350px",
                dropdownParent: $("#myModal")
            });

            $(document).on('click', '.add-brand', function() {
                $('#mode').val(2);
                $('.name_brand').show();
                $('.abbreviation_brand').show();
                $('.text_add_brand').addClass('text-danger').text('ยกเลิก');
                $('.brand_id').parent().hide();
                $('.add-brand').removeClass('add-brand').addClass('cancle-add-brand');
            });

            $(document).on('click', '.cancle-add-brand', function() {
                $('#mode').val(1);
                $('.name_brand').hide();
                $('.abbreviation_brand').hide();
                $('.text_add_brand').removeClass('text-danger').text('เพิ่มแบรนด์ใหม่');
                $('.brand_id').parent().show();
                $('.cancle-add-brand').removeClass('cancle-add-brand').addClass('add-brand');
            });

            let company_id = $('#company_id').val();
            let package_table = $('#package_table').DataTable({
                "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '{{ route('api.v1.packaging.list') }}',
                    'data': {
                        'company_id': company_id
                    }
                },
                'columns': [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'itemcode'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return row.weight_per_qty + " " + row.volumetric_unit + " / pc.";
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

            $('#custom-search-input').keyup(function() {
                package_table.search($(this).val()).draw();
            })


            $(document).on('click', '.btn-delete', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'ยืนยันการลบบรรจุภัณฑ์?',
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
                            url: "{{ route('api.v1.packaging.delete') }}",
                            data: {
                                'id': id
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response) {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'success',
                                        title: 'ลบรายการสำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    window.location.reload();
                                } else {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'error',
                                        title: 'ลบรายการไม่สำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                }
                            }
                        });
                    }
                })
            });


            $(document).on('click', '.btn-modal', function() {
                let id = $(this).data('id');
                $('#id').val(id);

                $('#myModal').modal('show');

                if (!id) {
                    $('.brand-panel').show();
                    $('#id').val('');
                    $('#name').val('');
                    $('#type').val('');
                    $('#weight_per_qty').val('');
                    $('#volumetric_unit').val('');

                    $('.modal-title').text('เพิ่มรายการบรรจุภัณฑ์');
                } else {
                    $('.brand-panel').hide();
                    $('.modal-title').text('แก้ไขรายการบรรจุภัณฑ์');
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.packaging.view.edit') }}",
                        data: {
                            "id": id
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#id').val(response.id);
                            $('#type').val(response.packaging_type_id);
                            $('#brand_id').val(response.brand_id).change();
                            $('#name').val(response.name);
                            $('#weight_per_qty').val(response.weight_per_qty);
                            $('#volumetric_unit').val(response.volumetric_unit);
                            $('#is_active').val(response.is_active);
                        }
                    });
                }

            });

            $('.btn-save').on('click', function() {
                var mode = $('#mode').val();
                var brand_id;
                if (mode == 1) {
                    brand_id = $('#brand_id').val();
                } else if (mode == 2) {
                    var brandData = {
                        brand: $('#name_brand').val(),
                        abbreviation: $('#abbreviation_brand').val()
                    }
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.brand.create') }}",
                        data: brandData,
                        dataType: "json",
                        async: false,
                        success: function(response) {
                            brand_id = response.id;
                        }
                    });
                }
                // console.log("Brand ID outside Ajax:" + brand_id);

                var formData = {
                    name: $('#name').val(),
                    brand_id: brand_id,
                    packaging_type_id: $('#type').val(),
                    company_id: $('#company_id').val(),
                    weight_per_qty: $('#weight_per_qty').val(),
                    volumetric_unit: $('#volumetric_unit').val(),
                    is_active: $('#is_active').val(),
                    token: $("#_token").val(),
                    id: $("#id").val(),
                }
                if (!formData.id) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.packaging.validate') }}",
                        data: formData,
                        dataType: "json",
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({
                                    title: 'ยืนยันการเพิ่มบรรจุภัณฑ์?',
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
                                            url: "{{ route('api.v1.packaging.create') }}",
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
                                })
                            } else {
                                if ($('#name').val() === '') {

                                    $('#checkname').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkname').hide()
                                }
                                if ($('#type').val() === '') {

                                    $('#checktype').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checktype').hide()
                                }
                                if ($('#weight_per_qty').val() === '') {

                                    $('#checkweight_per_qty').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkweight_per_qty').hide()
                                }
                                if ($('#volumetric_unit').val() === '') {

                                    $('#checkvolumetric_unit').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkvolumetric_unit').hide()
                                }
                            }
                        }
                    });
                } else {
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.packaging.validate') }}",
                        data: formData,
                        dataType: "json",
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({
                                    title: 'ยืนยันการแก้ไขบรรจุภัณฑ์?',
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
                                            url: "{{ route('api.v1.packaging.edit') }}",
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
                                })
                            } else {
                                if ($('#name').val() === '') {

                                    $('#checkname').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkname').hide()
                                }
                                if ($('#type').val() === '') {

                                    $('#checktype').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checktype').hide()
                                }
                            }
                        }
                    });
                }
            })
        });
    </script>
@endsection
