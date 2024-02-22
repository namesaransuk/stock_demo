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
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">ผลิตภัณฑ์สำเร็จรูป</li>
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
                    <h6 class="m-0"> ผลิตภัณฑ์สำเร็จรูป</h6>
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

                    <table id="product_table" class="table w-100"
                        style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="text-center">
                            <tr>
                                <th scope="col" class="w-auto">#</th>
                                <th scope="col" class="w-auto">ชื่อผลิตภัณฑ์สำเร็จรูป</th>
                                <th scope="col" class="w-auto">ประเภทผลิตภัณฑ์สำเร็จรูป</th>
                                <!-- <th scope="col" class="w-auto">สถานะ</th> -->
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
                <div class="modal-header ogn-stock-green">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">เพิ่มรายการผลิตภัณฑ์สำเร็จรูป
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="" class="form-label">ประเภทผลิตภัณฑ์สำเร็จรูป</label>
                                <select name="" id="category_id" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">สำหรับ{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="" class="form-label">ชื่อผลิตภัณฑ์สำเร็จรูป</label>
                                <input type="text" id="name" class="form-control">
                                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                                <input type="hidden" name="id" id="id" value="">
                                <small id="checkname"></small>
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
                                    class="form-control select2 brand_id">
                                    <option selected>เลือกแบรนด์</option>
                                    @foreach ($brands as $brand_one)
                                        <option value="{{ $brand_one->id }}">{{ $brand_one->name }}</option>
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
                    <div class="modal-footer">
                        <button type="button" class="btn ogn-stock-grey " style="color:black;" data-dismiss="modal"><em
                                class="fas fa-close"></em> ยกเลิก</button>
                        <button type="button" class="btn ogn-stock-green text-white btn-save save-brand"
                            style=" color:black;"><em class="fas fa-save "></em> บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script>
            $(document).ready(function() {

                // $("#myModal").modal('show');

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
                let product_table = $('#product_table').DataTable({
                    "pageLength": 10,
                    "responsive": true,
                    // "order": [4, "desc"],
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    'ajax': {
                        'url': '{{ route('api.v1.product.list') }}',
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
                        }, //กำหนดข้อมูลที่นำมาแสดง
                        {
                            data: 'id',
                            render: function(data, type, row, meta) {

                                return "สำหรับ" + row.category.name;
                            }
                        },
                        // { data: 'id', render : function(data,type,row,meta){
                        //     if(row.is_active === 1){
                        //         data = '<span class="badge badge-pill badge-success" style="text-align : center;">มีวัตถุดิบ</span>'
                        //     }
                        //     else if(row.is_active === 2){
                        //         data = '<span class="badge badge-pill badge-warning" style="text-align : center;">รอวัตถุดิบ</span>'
                        //     }
                        //     else{
                        //         data = '<span class="badge badge-pill badge-danger" style="text-align : center;">วัตถุดิบหมด</span>'
                        //     }
                        //     return data;
                        // }},
                        {
                            data: 'name',
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

                $('.select2').select2({
                    width: "350px",
                    dropdownParent: $("#myModal")
                });

                $('#custom-search-input').keyup(function() {
                    product_table.search($(this).val()).draw();
                })

                $(document).on('click', '.btn-modal', function() {
                    let id = $(this).data('id');
                    $('#id').val(id);

                    $('#myModal').modal('show');

                    if (!id) {
                        $('.brand-panel').show();
                        $('#id').val('');
                        $('#name').val('');
                        $('#trade_name').val('');
                        $('.modal-title').text('เพิ่มรายการผลิตภัณฑ์สำเร็จรูป');
                    } else {
                        $('.brand-panel').hide();
                        $('.modal-title').text('แก้ไขรายการผลิตภัณฑ์สำเร็จรูป');

                        $.ajax({
                            type: "post",
                            url: "{{ route('api.v1.product.view.edit') }}",
                            data: {
                                'id': id
                            },
                            dataType: "json",
                            success: function(response) {
                                console.log(response.id)
                                $('#name').val(response.name);
                                $('#brand_id').val(response.brand_id).change();
                                $('#id').val(response.id);
                                $('#record_status').val(response.record_status);
                                $('#is_active').val(response.is_active);
                                $('#category_id').val(response.category_id);
                                $('#trade_name').val(response.trade_name);
                            }
                        });
                    }
                });

                $(document).on('click', '.btn-delete', function() {
                    let id = $(this).data('id');
                    Swal.fire({
                        title: 'ยืนยันการลบผลิตภัณฑ์สำเร็จรูป?',
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
                                url: "{{ route('api.v1.product.delete') }}",
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

                // $(document).on('click', '.save-brand', function() {

                // });

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
                        // mode: mode,
                        brand_id: brand_id,
                        category_id: $('#category_id').val(),
                        company_id: $('#company_id').val(),
                        id: $('#id').val(),
                        trade_name: $('#trade_name').val(),
                        record_status: $('#record_status').val(),
                        token: $("#_token").val(),
                        is_active: $('#is_active').val()
                    }

                    if (!formData.id) {
                        $.ajax({
                            type: "post",
                            url: "{{ route('api.v1.product.validate') }}",
                            data: formData,
                            dataType: "json",
                            success: function(data) {
                                if ($.isEmptyObject(data.error)) {
                                    Swal.fire({
                                        title: 'ยืนยันการเพิ่มผลิตภัณฑ์สำเร็จรูป?',
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
                                                url: "{{ route('api.v1.product.create') }}",
                                                data: formData,
                                                dataType: "json",
                                                success: function(
                                                    response
                                                ) {
                                                    if (
                                                        response) {
                                                        Swal.fire({
                                                            position: 'center-center',
                                                            icon: 'success',
                                                            title: 'เพิ่มรายการสำเร็จ',
                                                            showConfirmButton: false,
                                                            timer: 1500
                                                        })
                                                        // window.location
                                                        //     .reload();
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
                                    if ($('#name').val() === '') {

                                        $('#checkname').addClass(
                                            'text-danger').text(
                                            'กรุณากรอกข้อมูล');
                                    } else {
                                        $('#checkname').hide()
                                    }
                                    if ($('#trade_name').val() === '') {

                                        $('#checktradename').addClass(
                                            'text-danger').text(
                                            'กรุณากรอกข้อมูล');
                                    } else {
                                        $('#checktradename').hide()
                                    }
                                }
                            }
                        });
                    } else {
                        $.ajax({
                            type: "post",
                            url: "{{ route('api.v1.product.validate') }}",
                            data: formData,
                            dataType: "json",
                            success: function(data) {
                                if ($.isEmptyObject(data.error)) {
                                    Swal.fire({
                                        title: 'ยืนยันการแก้ไขข้อมูลผลิตภัณฑ์สำเร็จรูป?',
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
                                                url: "{{ route('api.v1.product.edit') }}",
                                                data: formData,
                                                dataType: "json",
                                                success: function(
                                                    response
                                                ) {
                                                    if (
                                                        response) {
                                                        Swal.fire({
                                                            position: 'center-center',
                                                            icon: 'success',
                                                            title: 'แก้ไขรายการสำเร็จ',
                                                            showConfirmButton: false,
                                                            timer: 1500
                                                        })
                                                        window
                                                            .location
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
                                    if ($('#name').val() === '') {

                                        $('#checkname').addClass(
                                            'text-danger').text(
                                            'กรุณากรอกข้อมูล');
                                    } else {
                                        $('#checkname').hide()
                                    }
                                    if ($('#trade_name').val() === '') {

                                        $('#checktradename').addClass(
                                            'text-danger').text(
                                            'กรุณากรอกข้อมูล');
                                    } else {
                                        $('#checktradename').hide()
                                    }
                                }
                            }
                        });
                    }
                });

            });
        </script>
    @endsection
