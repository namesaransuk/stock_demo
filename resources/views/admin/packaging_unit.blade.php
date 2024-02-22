@extends('adminlte::page')

@section('css')
@endsection

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">หน่วยของบรรจุภัณฑ์</li>
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
                    <h6 class="m-0">หน่วยของบรรจุภัณฑ์</h6>
                </div>
                <div class="p-2">
                    <div class="float-right">
                        <input type="search" id="custom-search-input" class="form-control form-control-sm"
                            placeholder="ค้นหา">
                    </div>

                    <div class="card-title mb-0"></div>
                </div>
                <div class="card-body p-0">

                    <table id="packaging_unit_table" class="table w-100"
                        style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="text-center">
                            <tr>
                                <th scope="col" class="w-auto">#</th>
                                <th scope="col" class="w-auto">ชื่อภาษไทย</th>
                                <th scope="col" class="w-auto">ชื่อภาษาอังกฤษ</th>
                                <th scope="col" class="w-auto">ตัวย่อ</th>
                                <th scope="col" class="w-auto">คำนิยาม</th>
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
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header ogn-stock-green">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">เพิ่มรายการหน่วยของบรรจุภัณฑ์
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                                <input type="hidden" name="id" id="id" value="">
                                <label for="name" class="form-label">ชื่อรายการ</label>
                                <input type="text" id="name" class="form-control">
                                <small id="checkname"></small>
                            </div>
                            <div class="col-sm-12 col-md-10 col-lg-10 col-xl-10 mt-2">
                                <label for="name_en" class="form-label">ชื่อภาษาอังกฤษ</label>
                                <input type="text" id="name_en" class="form-control">
                                {{-- <small id="checkname_en"></small> --}}
                            </div>
                            <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 mt-2">
                                <label for="abbreviation" class="form-label">ตัวย่อ</label>
                                <input type="text" id="abbreviation" class="form-control"
                                    oninput="this.value = this.value.toUpperCase()" maxlength="2">
                                <small id="checkabbreviation"></small>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                                <label for="definition" class="form-label">คำนิยาม</label>
                                <textarea type="text" id="definition" row="3" class="form-control"></textarea>
                                {{-- <small id="checkmultiply"></small> --}}
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

            let packaging_unit_table = $('#packaging_unit_table').DataTable({
                "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '{{ route('api.v1.packaging.unit.list') }}'
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
                        data: 'name_en'
                    },
                    {
                        data: 'abbreviation'
                    },
                    {
                        data: 'definition'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return `<div class="dropdown show">
                                    <a class="btn btn-sm text-secondary rounded border ml-1" href="#" inspect_topic_type="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit"></i> จัดการ</a>
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
                packaging_unit_table.search($(this).val()).draw();
            })

            $(document).on('click', '.btn-modal', function() {

                let id = $(this).data('id');
                $('#id').val(id);


                $('#myModal').modal('show');
                if (!id) {

                    $('.modal-title').text('เพิ่มรายการหน่วยของบรรจุภัณฑ์');
                    $('#name').val('');
                    $('#name_en').val('');
                    $('#abbreviation').val('');
                    $('#definition').val('');
                    $('#id').val('');

                } else {

                    $('.modal-title').text('แก้ไขรายการหน่วยของบรรจุภัณฑ์');
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.packaging.unit.view.edit') }}",
                        data: {
                            'id': id
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(response.id)
                            $('#name').val(response.name);
                            $('#name_en').val(response.name_en);
                            $('#abbreviation').val(response.abbreviation);
                            $('#definition').val(response.definition);
                            $('#id').val(response.id);

                        }
                    });
                }
            });

            $(document).on('click', '.btn-save', function() {

                var formData = {
                    id: $('#id').val(),
                    name: $('#name').val(),
                    abbreviation: $('#abbreviation').val(),
                    definition: $('#definition').val(),
                    token: $("#_token").val(),
                    name_en: $('#name_en').val()
                }

                if (!formData.id) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.packaging.unit.validate') }}",
                        data: formData,
                        dataType: "json",
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({
                                    title: 'ยืนยันการเพิ่มหน่วยของบรรจุภัณฑ์?',
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
                                            url: "{{ route('api.v1.packaging.unit.create') }}",
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
                                if ($('#abbreviation').val() === '') {

                                    $('#checkabbreviation').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkabbreviation').hide()
                                }
                            }
                        }
                    });
                } else {
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.packaging.unit.validate') }}",
                        data: formData,
                        dataType: "json",
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({
                                    title: 'ยืนยันการแก้ไขหน่วยของบรรจุภัณฑ์?',
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
                                            url: "{{ route('api.v1.packaging.unit.edit') }}",
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
                                if ($('#abbreviation').val() === '') {

                                    $('#checkabbreviation').addClass('text-danger').text(
                                        'กรุณากรอกข้อมูล');
                                } else {
                                    $('#checkabbreviation').hide()
                                }
                            }
                        }
                    });
                }
            });

            $(document).on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'ยืนยันการลบหน่วยของบรรจุภัณฑ์?',
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
                            url: "{{ route('api.v1.packaging.unit.delete') }}",
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
        });
    </script>
@endsection
