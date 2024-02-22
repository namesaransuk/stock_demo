@extends('adminlte::page')

@section('css')
@endsection

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">วัตถุดิบ</li>
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
                    <h6 class="m-0"> วัตถุดิบ</h6>
                    <input type="hidden" name="company_id" id="company_id" value="{{ session('company') }}">
                </div>
                <div class="p-2">
                    <div class="float-left mb-2">
                        {{-- <select class="form-control form-control-sm" name="" id="custom-filter-input">
                            <option value="" selected disabled>เลือกประเภทวัตถุดิบ</option>
                            <option value="1" selected>สำหรับเครื่องสำอาง</option>
                            <option value="2" selected>สำหรับอาหารเสริม</option>
                        </select> --}}
                        <select name="" id="custom-filter-input" class="form-control form-control-sm w-100">
                            <option value="-1">แสดงทั้งหมด</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">สำหรับ{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="float-right mb-2">
                        <input type="search" id="custom-search-input" class="form-control form-control-sm"
                            placeholder="ค้นหา">
                    </div>

                </div>
                <div class="card-body p-0">

                    <table id="material_table" class="table w-100"
                        style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="text-center">
                            <tr>
                                <th scope="col" class="w-auto">#</th>

                                <th scope="col" class="w-auto">ชื่อวัตถุดิบ</th>
                                <th scope="col" class="w-auto">รหัสวัตถุดิบ</th>
                                <th scope="col" class="w-auto">ประเภทวัตถุดิบ</th>
                                <th scope="col" class="w-auto">แบรนด์</th>
                                <th scope="col" class="w-auto">สถานะ</th>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header ogn-stock-green">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">เพิ่มรายการวัตถุดิบ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                <label for="" class="form-label">ชื่อวัตถุดิบ</label>
                                <input type="text" id="name" class="form-control">
                                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                                <input type="hidden" name="id" id="id" value="">
                                <small id="checkname"></small>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                <label for="" class="form-label">ประเภทวัตถุดิบ</label>
                                <select name="" id="category_id" class="form-control">
                                    <option selected disabled>เลือกประเภทวัตถุดิบ</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">สำหรับ{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                <label for="" class="form-label">ประเภทการใช้งาน</label>
                                <select name="" id="sub_category_id" class="form-control">
                                </select>
                            </div>

                        </div>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <label for="" class="form-label">แบรนด์</label><br>
                                <select name="" id="supplier_id" style="min-width: 20%"
                                    class="form-control select2 ">
                                    @foreach ($brands as $brand_one)
                                        <option value="{{ $brand_one->id }}">{{ $brand_one->brand }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                <label for="" class="form-label">รหัสวัตถุดิบ</label>
                                <input type="text" id="trade_name" class="form-control">
                                <small id="checktradename"></small>
                            </div> --}}
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                <label for="" class="form-label">สถานะ</label>
                                <select name="" id="is_active" class="form-control">
                                    <option value="1">มีสต็อก</option>
                                    <option value="2">รอสต็อก</option>
                                    <option value="3">หมดสต็อก</option>
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

            // $("#myModal").modal('show');

            $('#category_id').change(function() {
                var selectedOption = $('#category_id').val();
                switch (selectedOption) {
                    case "1":
                        var typeRoute = "{{ route('api.v1.cosmetics.select') }}";
                        break;
                    case "2":
                        var typeRoute = "{{ route('api.v1.supplement.select') }}";
                        break;
                }

                $.ajax({
                    type: "post",
                    url: typeRoute,
                    success: function(response) {
                        // console.log(response.id)
                        var select = $('#sub_category_id');
                        select.empty();

                        $.each(response, function(key, value) {
                            select.append('<option value="' + value.id +
                                '">' +
                                value.name + (value.name_en ? ' (' + value.name_en +
                                    ')</option>' : ''));
                        });
                    }
                });
            });

            $('.select2').select2({
                width: "100%",
                dropdownParent: $("#myModal")
            });

            var company_id = $('#company_id').val();
            var categoryFilter = $('#custom-filter-input').val();


            $(document).on("change", '#custom-filter-input', function() {
                console.log($('#custom-filter-input').val());
                var selectedCategory = $(this).val();
                material_table.column(0).search(selectedCategory).draw();
            });

            // $('#custom-filter-input').change(function() {
            var material_table = $('#material_table').DataTable({
                "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '{{ route('api.v1.material.list') }}',
                    'data' : function(d){
                        d.company_id = company_id;
                        d.categoryFilter = $('#custom-filter-input').val();
                    },
                },
                'columns': [
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'itemcode',
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return "สำหรับ" + row.category.name;
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            if (row.brand_vendor) {
                                data = row.brand_vendor.brand;
                            } else {
                                data = '';
                            }

                            return data;
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            if (row.is_active === 1) {
                                data =
                                    '<span class="badge badge-pill badge-success" style="text-align : center;">มีวัตถุดิบ</span>'
                            } else if (row.is_active === 2) {
                                data =
                                    '<span class="badge badge-pill badge-warning" style="text-align : center;">รอวัตถุดิบ</span>'
                            } else {
                                data =
                                    '<span class="badge badge-pill badge-danger" style="text-align : center;">วัตถุดิบหมด</span>'
                            }
                            return data;
                        }
                    },
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
                        targets: [0, 1, 2],
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
                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">',
            })
            // })

            $('#custom-search-input').keyup(function() {
                material_table.search($(this).val()).draw();
            })

            $(document).on('click', '.btn-modal', function() {
                let id = $(this).data('id');
                $('#id').val(id);

                $('#myModal').modal('show');

                if (!id) {
                    $('#id').val('');
                    $('#name').val('');
                    $('#category_id').val('');
                    $('#sub_category_id').val('');
                    // $('#supplier_id').val('').change();
                    $('.modal-title').text('เพิ่มรายการวัตถุดิบ');
                } else {
                    $('.modal-title').text('แก้ไขรายการวัตถุดิบ');

                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.material.view.edit') }}",
                        data: {
                            'id': id
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#name').val(response.name);
                            $('#id').val(response.id);
                            $('#record_status').val(response.record_status);
                            $('#is_active').val(response.is_active);
                            $('#category_id').val(response.category_id).change().prop(
                                "disabled", true);
                            setTimeout(function() {
                                $('#sub_category_id').val(response.sub_category_id)
                                    .change().prop("disabled", true);
                            }, 1000);
                            $('#supplier_id').val(response.supplier_id).change();
                            // $('#abbreviation').val(response.supplier_id);
                            // $('#trade_name').val(response.trade_name);
                        }
                    });
                }
            });

            $(document).on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'ยืนยันการลบวัตถุดิบ?',
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
                            url: "{{ route('api.v1.material.delete') }}",
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

            $('.btn-save').on('click', function() {

                var formData = {
                    name: $('#name').val(),
                    category_id: $('#category_id').val(),
                    company_id: $('#company_id').val(),
                    supplier_id: $('#supplier_id').val(),
                    sub_category_id: $('#sub_category_id').val(),
                    id: $('#id').val(),
                    trade_name: $('#trade_name').val(),
                    record_status: $('#record_status').val(),
                    token: $("#_token").val(),
                    is_active: $('#is_active').val()
                }

                if (!formData.id) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.material.validate') }}",
                        data: formData,
                        dataType: "json",
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({
                                    title: 'ยืนยันการเพิ่มวัตถุดิบ?',
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
                                            url: "{{ route('api.v1.material.create') }}",
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
                                if ($('#name').val() === '') {

                                    $('#checkname').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkname').hide()
                                }
                                // if ($('#trade_name').val() === '') {

                                //     $('#checktradename').addClass('text-danger').text(
                                //         'กรุณากรอกข้อมูล');
                                // } else {
                                //     $('#checktradename').hide()
                                // }
                            }
                        }
                    });
                } else {
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.material.validate') }}",
                        data: formData,
                        dataType: "json",
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({
                                    title: 'ยืนยันการแก้ไขข้อมูลวัตถุดิบ?',
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
                                            url: "{{ route('api.v1.material.edit') }}",
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
                                if ($('#name').val() === '') {

                                    $('#checkname').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkname').hide()
                                }
                                // if ($('#trade_name').val() === '') {

                                //     $('#checktradename').addClass('text-danger').text(
                                //         'กรุณากรอกข้อมูล');
                                // } else {
                                //     $('#checktradename').hide()
                                // }
                            }
                        }
                    });
                }
            });

        });
    </script>
@endsection
