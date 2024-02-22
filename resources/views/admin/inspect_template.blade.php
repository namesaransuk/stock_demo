@extends('adminlte::page')

@section('css')
    <style>
        .mat_hide {
            display: none;
        }

        .error {
            color: red;
        }

    </style>
@endsection

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">แบบฟอร์มการตรวจสอบ</li>
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
            <div class="card-header ogn-stock-yellow text-left" >
                    <h6 class="m-0"> แบบฟอร์มการตรวจสอบ</h6>
                </div>
                <div class="p-2">
                    <div class="float-right">
                        <input type="search" id="custom-search-input" class="form-control form-control-sm"
                               placeholder="ค้นหา">
                    </div>

                    <div class="card-title mb-0"></div>
                </div>
                <div class="card-body p-0">

                    <table id="inspect_template_table" class="table w-100"
                        style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="text-center">
                            <tr>
                                <th scope="col" class="w-auto">#</th>
                                <th scope="col" class="w-auto">แบบฟอร์มการตรวจสอบ</th>
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
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header ogn-stock-green">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">เพิ่มรายการแบบฟอร์มการตรวจสอบ
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form id="inspect_valid">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                                    <label for="" class="form-label">ชื่อแบบฟอร์มการตรวจสอบ</label>
                                    <input type="text" id="name" class="form-control" required>
                                    <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                                    <input type="hidden" name="id" id="id" value="">
                                    <small id="checkname"></small>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                                    <label for="" class="form-label">ประเภทหัวข้อการตรวจสอบ</label>
                                    <select name="" id="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">ตรวจสอบ{{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                                    <label for="" class="form-label">หัวข้อการตรวจสอบ : วิธีการตรวจสอบ</label>
                                    <div class="row">
                                        <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 ">
                                            <select name="" id="inspect_topics" class="form-control">
                                            </select>
                                        </div>
                                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 ">
                                            <button type="button" class="btn ogn-stock-green text-white add-to-table w-100 "
                                                style=" color:black;"><em class="fas fa-plus "></em> เพิ่ม</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-outline card-gdp">
                                    <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                                        <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รายการตรวจสอบ
                                        </h6>
                                    </div>

                                    <div class="card-body p-0">

                                        <table id="inspect_template_detail_table" class="table w-100 "
                                            style="margin-top: 0!important; margin-bottom: 0!important;">
                                            <caption style="display: none"></caption>
                                            <thead class="" style=" text-align: center;">
                                                <tr>
                                                    <th scope="col" class="w-auto">#</th>
                                                    <th scope="col" class="w-auto">ประเภทการตรวจสอบ</th>
                                                    <th scope="col" class="w-auto">หัวข้อการตรวจสอบ : วิธีการตรวจสอบ
                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn ogn-stock-grey clear-modal" style="color:black;"
                        data-dismiss="modal"><em class="fas fa-close"></em> ยกเลิก</button>
                    <button type="button" class="btn ogn-stock-green text-white btn-save " style=" color:black;"><em
                            class="fas fa-save "></em> บันทึก</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="myModal2" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header ogn-stock-green">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">เพิ่มรายการแบบฟอร์มการตรวจสอบ
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form id="inspect_valid">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                                    <label for="" class="form-label">ชื่อแบบฟอร์มการตรวจสอบ</label>
                                    <input type="text" id="name2" class="form-control" readonly>
                                </div>
                            </div>
                        </form>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-outline card-gdp">
                                    <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                                        <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รายการตรวจสอบ
                                        </h6>
                                    </div>

                                    <div class="card-body p-0">

                                        <table id="inspect_template_detail_table2" class="table w-100 "
                                            style="margin-top: 0!important; margin-bottom: 0!important;">
                                            <caption style="display: none"></caption>
                                            <thead class="" style=" text-align: center;">
                                                <tr>
                                                    <th scope="col" class="w-auto">#</th>
                                                    <th scope="col" class="w-auto">ประเภทการตรวจสอบ</th>
                                                    <th scope="col" class="w-auto">หัวข้อการตรวจสอบ : วิธีการตรวจสอบ</th>
                                                </tr>
                                            </thead>
                                            <tbody id="rowbody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn ogn-stock-grey clear-modal2" style="color:black;"
                        data-dismiss="modal"><em class="fas fa-close"></em> ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal3" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header ogn-stock-green">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">เพิ่มรายการแบบฟอร์มการตรวจสอบ
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form id="inspect_valid">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                                    <label for="" class="form-label">ชื่อแบบฟอร์มการตรวจสอบ</label>
                                    <input type="text" id="name3" class="form-control" required>
                                    <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                                    <input type="hidden" name="id3" id="id3" value="">
                                    <small id="checkname"></small>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                                    <label for="" class="form-label">ประเภทหัวข้อการตรวจสอบ</label>
                                    <select name="" id="category_id3" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">ตรวจสอบ{{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                                    <label for="" class="form-label">หัวข้อการตรวจสอบ : วิธีการตรวจสอบ</label>
                                    <div class="row">
                                        <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 ">
                                            <select name="" id="inspect_topics3" class="form-control">
                                            </select>
                                        </div>
                                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 ">
                                            <button type="button"
                                                class="btn ogn-stock-green text-white add-to-table3 w-100 "
                                                style=" color:black;"><em class="fas fa-plus "></em> เพิ่ม</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-outline card-gdp">
                                    <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                                        <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รายการตรวจสอบ
                                        </h6>
                                    </div>

                                    <div class="card-body p-0">

                                        <table id="inspect_template_detail_table3" class="table w-100 "
                                            style="margin-top: 0!important; margin-bottom: 0!important;">
                                            <caption style="display: none"></caption>
                                            <thead class="" style=" text-align: center;">
                                                <tr>
                                                    <th scope="col" class="w-auto">#</th>
                                                    <th scope="col" class="w-auto">ประเภทการตรวจสอบ</th>
                                                    <th scope="col" class="w-auto">หัวข้อการตรวจสอบ : วิธีการตรวจสอบ</th>
                                                </tr>
                                            </thead>
                                            <tbody id="rowbody3">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn ogn-stock-grey clear-modal3" style="color:black;"
                        data-dismiss="modal"><em class="fas fa-close"></em> ยกเลิก</button>
                    <button type="button" class="btn ogn-stock-green text-white btn-save3 " style=" color:black;"><em
                            class="fas fa-save "></em> บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            var select_count = 0;
            var select_count3 = 0;
            var id = $('#category_id').val()

            let inspect_template_detail_table = $('#inspect_template_detail_table').DataTable({
                "pageLength": 100,
                "responsive": true,
                "paging": false,
                "ordering": false,
                "info": false,
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    {
                        orderable: false,
                        responsivePriority: 7,
                        targets: [1, 2]

                    }
                ],
                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">'
            });


        $('#custom-search-input').keyup(function(){
            inspect_template_table.search($(this).val()).draw() ;
            })

            // console.log(id);
            $.ajax({
                type: "post",
                url: "{{ route('api.v1.inspect.template.find.inspect.topic') }}",
                data: {
                    "id": id
                },
                dataType: "json",
                success: function(response) {
                    $('#inspect_topics').find('option').remove().end()
                    response.forEach(element => {
                        $('#inspect_topics').append('<option value=' + element.id + '>' +
                            element.name + ' : ' + element.method + '</option>');
                    });
                }
            });
            $('#category_id').change(function() {
                if (select_count > 0) {
                    Swal.fire({
                        title: 'คุณต้องการเปลี่ยนประเภทการตรวจสอบใช่หรือไม่?',
                        text: "ต้องการดำเนินการใช่หรือไม่!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#649514',
                        cancelButtonColor: '#a97551',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ปิด'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            inspect_template_detail_table.rows().clear().draw();
                            select_count = 0;
                            $('#category_id').val();

                            var id2 = $('#category_id').val()
                            $.ajax({
                                type: "post",
                                url: "{{ route('api.v1.inspect.template.find.inspect.topic') }}",
                                data: {
                                    "id": id2
                                },
                                dataType: "json",
                                success: function(response) {
                                    $('#inspect_topics').find('option').remove().end()
                                    response.forEach(element => {
                                        $('#inspect_topics').append(
                                            '<option value=' + element.id +
                                            '>' + element.name + ' : ' +
                                            element.method + '</option>');
                                    });
                                }
                            });

                        } else {
                            $('#category_id').val(id);
                        }
                    });
                } else {
                    var id2 = $('#category_id').val()
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.inspect.template.find.inspect.topic') }}",
                        data: {
                            "id": id2
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#inspect_topics').find('option').remove().end()
                            response.forEach(element => {
                                $('#inspect_topics').append('<option value=' + element
                                    .id + '>' + element.name + ' : ' + element
                                    .method + '</option>');
                            });
                        }
                    });
                }

            })

            $('#category_id3').change(function() {
                    Swal.fire({
                        title: 'คุณต้องการเปลี่ยนประเภทการตรวจสอบใช่หรือไม่?',
                        text: "ต้องการดำเนินการใช่หรือไม่!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#649514',
                        cancelButtonColor: '#a97551',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ปิด'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            inspect_template_detail_table3.rows().clear().draw();
                            select_count3 = 0;
                            $('#category_id3').val();

                            var id3 = $('#category_id3').val()
                            $.ajax({
                                type: "post",
                                url: "{{ route('api.v1.inspect.template.find.inspect.topic') }}",
                                data: {
                                    "id": id3
                                },
                                dataType: "json",
                                success: function(response) {
                                    $('#inspect_topics3').find('option').remove().end()
                                    response.forEach(element => {
                                        $('#inspect_topics3').append(
                                            '<option value=' + element.id +
                                            '>' + element.name + ' : ' +
                                            element.method + '</option>');
                                    });
                                }
                            });

                        } else {
                            $('#category_id3').val(id);
                        }
                    });


            })



            let inspect_template_table = $('#inspect_template_table').DataTable({
                "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '{{ route('api.v1.inspect.template.list') }}'
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
                        data: 'id',
                        render: function(data, type, row, meta) {
                            let url = "{{ route('inspect.template.detail.id', '__id') }}"
                                .replaceAll("__id", row.id);
                            return `<div class="dropdown show">
                                    <a type="button" data-id="${row.id}" class="open-modal2 btn btn-sm text-secondary rounded border ml-1 " ><em class="fas fa-info"></em> รายละเอียด </a>
                                    <a class="btn btn-sm text-secondary rounded border ml-1" href="#" inspect_template="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit"></i> จัดการ</a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a type="button" data-id="${row.id}" class="open-modal3 dropdown-item" ><i class="fas fa-edit"></i> แก้ไข</a>
                                        <a type="button" data-id="${row.id}" class="buttom_delete dropdown-item delete-me btn-delete"><em class="fas fa-trash-alt"></em> ลบ</a>
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
                drawCallback: function( settings ) {

                    @cannot('admin')
                        $('.buttom_delete').remove();
                    @endcan

                },
                // language: {
                //     "url": "{{ asset('/vendor/datatables/th.json') }}"
                // },
                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
            })

            let inspect_template_detail_table2 = "";

            $(document).on('click', ".open-modal2", function() {
                $('#myModal2').modal('show');
                let id = $(this).data('id');
                $('#id').val(id);
                // console.log(id);


                $.ajax({
                    type: "post",
                    url: "{{ route('api.v1.inspect.template.get.template') }}",
                    data: {
                        'id': id
                    },
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        $('#name2').val(response[0].inspect_template.name);
                    }
                });

                $.ajax({
                    type: "post",
                    url: "{{ route('api.v1.inspect.template.get.template.detail') }}",
                    data: {
                        "id": id
                    },
                    dataType: "json",
                    success: function(response) {
                        var row = '';
                        // console.log(response)
                        response.forEach((element, index) => {
                            row +=

                                `
                        <tr class="materialrowold">
                            <td>${++index}</td>
                            <td>ตรวจสอบ${element.inspect_topic.category.name}</td>
                            <td>${element.inspect_topic.name} : ${element.inspect_topic.method}</td>
                        </tr>
                        `

                        });

                        $('#rowbody').html(row);

                        inspect_template_detail_table2 = $('#inspect_template_detail_table2')
                            .DataTable({
                                "paging": false,
                                "searching": false,
                                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">',
                                "info": false,
                                "pageLength": 100,
                            });
                    }
                });
            });

            let inspect_template_detail_table3 = "";

            $(document).on('click', ".open-modal3", function() {
                $('#myModal3').modal('show');
                let id = $(this).data('id');
                $('#id3').val(id);
                // console.log(id);

                // //get header
                $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.inspect.template.get.template') }}",
                        data: {'id':id},
                        dataType: "json",
                        success: function (response) {
                            // console.log(response);
                            $('#name3').val(response[0].inspect_template.name);
                            $('#category_id3').val(response[0].inspect_topic.category_id);
                        }
                });
                // //change category
                $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.inspect.template.find.inspect.topic') }}",
                        data: {"id":id},
                        dataType: "json",
                        success: function (response) {
                            $('#inspect_topics3').find('option').remove().end()
                            response.forEach(element => {
                                $('#inspect_topics3').append('<option value=' + element.id + '>' + element.name + ' : ' + element.method + '</option>');
                            });
                        }
                });

                //get detail
                $.ajax({
                    type: "post",
                    url: "{{ route('api.v1.inspect.template.get.template.detail') }}",
                    data: {
                        "id": id
                    },
                    dataType: "json",
                    success: function(response) {
                        var row3 = "";
                        // console.log(response)
                        response.forEach((element, index) => {
                            // console.log(element);
                            row3 +=
                                `
                                <tr class="inspect_topic_old">
                                    <td><a class="list_cancel3"><i class="fas fa-times text-red" style="cursor: pointer;"></i></a></td>
                                    <td><span class="category_id mat_hide ">${category_id}</span> ตรวจสอบ${element.inspect_topic.category.name}</td>
                                    <td><span class="inspect_topic_id mat_hide ">${element.inspect_topic.id}</span> ${element.inspect_topic.name} : ${element.inspect_topic.method}</td>
                                </tr>
                                `

                        });
                        // console.log(row3);

                        $('#rowbody3').html(row3);

                        inspect_template_detail_table3 = $('#inspect_template_detail_table3')
                            .DataTable({
                                "paging": false,
                                "searching": false,
                                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">',
                                "info": false,
                                "pageLength": 100,
                            });
                    }
                });




            });

            $(document).on('click', '.btn-modal', function() {
                let id = $(this).data('id');
                $('#id').val(id);


                $('#myModal').modal('show');
                if (!id) {

                    $('.modal-title').text('เพิ่มรายการประเภทหัวข้อการตรวจสอบ');
                    $('#name').val('');
                    $('#id').val('');

                } else {

                    $('.modal-title').text('แก้ไขรายการประเภทหัวข้อการตรวจสอบ');
                    $.ajax({
                        type: "post",
                        url: "{{ route('api.v1.inspect.template.view.edit') }}",
                        data: {
                            'id': id
                        },
                        dataType: "json",
                        success: function(response) {
                            // console.log(response.id)
                            $('#name').val(response.name);
                            $('#id').val(response.id);

                        }
                    });
                }



            });

            $(".clear-modal").on('click', function() {
                $('#name').val(""),
                inspect_template_detail_table.rows().clear().draw();
                // inspect_template_detail_table.destroy();
                $("#myModal").modal("hide");
            });

            $(".clear-modal2").on('click', function() {
                inspect_template_detail_table2.rows().clear().draw();
                inspect_template_detail_table2.destroy();
                $('#name2').val(""),
                    $("#myModal2").modal("hide");
            });

            $(".clear-modal3").on('click', function() {
                inspect_template_detail_table3.rows().clear().draw();
                inspect_template_detail_table3.destroy();
                $('#name3').val(""),
                $("#myModal3").modal("hide");
            });


            $('.btn-save').on('click', function() {

                var formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('token', $("#_token").val());
                formData.append('id', $('#id').val());
                formData.append('category_id', $('#category_id').val());
                $('.inspect_topic').each(function(index, value) {
                    formData.append('inspect[' + index + '][category_id]', $(value).find(
                        '.category_id').text())
                    formData.append('inspect[' + index + '][inspect_topic_id]', $(value).find(
                        '.inspect_topic_id').text())
                });

                    var inspect_template_rows = inspect_template_detail_table.rows().count();
                    if ($('#inspect_valid').valid()) {
                        if (inspect_template_rows > 0) {
                            Swal.fire({
                                title: 'ยืนยันการเพิ่มประเภทหัวข้อการตรวจสอบ?',
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
                                        url: "{{ route('api.v1.inspect.template.create') }}",
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        // dataType: "json",
                                        success: function(response) {

                                            if (response) {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'success',
                                                    title: 'เพิ่มรายการสำเร็จ',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                })
                                                window.location.reload();
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
                            Swal.fire({
                                position: 'center-center',
                                icon: 'warning',
                                title: 'กรุณาเพิ่มรายการนำเข้าวัตถุดิบ',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }

            });

            $('.btn-save3').on('click', function() {

                var formData = new FormData();
                formData.append('name', $('#name3').val());
                formData.append('token', $("#_token").val());
                formData.append('id', $('#id3').val());
                formData.append('category_id', $('#category_id3').val());
                var count = 0;
                var countOld = 0;

                $('.inspect_topic3').each(function(index, value) {
                    count++
                    formData.append('inspect[' + index + '][category_id]', $(value).find(
                        '.category_id').text())
                    formData.append('inspect[' + index + '][inspect_topic_id]', $(value).find(
                        '.inspect_topic_id').text())
                });

                $('.inspect_topic_old').each(function(index, value) {
                    countOld++
                    formData.append('inspectOld[' + index + '][category_id]', $(value).find(
                        '.category_id').text())
                    formData.append('inspectOld[' + index + '][inspect_topic_id]', $(value).find(
                        '.inspect_topic_id').text())
                });

                formData.append('count', count);
                formData.append('countOld', countOld);

                    var inspect_template_rows = inspect_template_detail_table3.rows().count();
                    if ($('#inspect_valid').valid()) {
                        if (inspect_template_rows > 0) {
                            Swal.fire({
                                title: 'ยืนยันการเพิ่มประเภทหัวข้อการตรวจสอบ?',
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
                                        url: "{{ route('api.v1.inspect.template.edit') }}",
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        // dataType: "json",
                                        success: function(response) {
                                            if (response) {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'success',
                                                    title: 'เพิ่มรายการสำเร็จ',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                })
                                                window.location.reload();
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
                            Swal.fire({
                                position: 'center-center',
                                icon: 'warning',
                                title: 'กรุณาเพิ่มรายการนำเข้าวัตถุดิบ',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }

            });

            $(document).on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'ยืนยันการลบแบบฟอร์มการตรวจสอบ?',
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
                            url: "{{ route('api.v1.inspect.template.delete') }}",
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

            $('.add-to-table').on('click', function() {
                var category_id = $('#category_id').val();
                id = category_id;
                var inspect_topic_type_name = $('#category_id option:selected').text();
                var inspect_topics_name = $('#inspect_topics option:selected').text();
                var inspect_topics_id = $('#inspect_topics').val();


                var status = true;
                $('.inspect_topic').each(function(index, value) {

                    if ($(value).find(".inspect_topic_id").text() === inspect_topics_id) {
                        status = false;
                        Swal.fire({
                            position: 'center-center',
                            icon: 'error',
                            title: 'ท่านได้เพิ่มรายการนี้แล้ว',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        status = true;
                    }
                });
                // console.log(test)

                if (status) {
                    inspect_template_detail_table.row.add([
                        '<td><a class="list_cancel"><i class="fas fa-times text-red" style="cursor: pointer;"></i></a></td>',
                        '<td><span class="category_id mat_hide ">' + category_id + '</span>' +
                        inspect_topic_type_name + '</span></td>',
                        '<td><span class="inspect_topic_id mat_hide ">' + inspect_topics_id +
                        '</span>' + inspect_topics_name + '</td>',
                    ]).draw(false).nodes().to$().addClass('inspect_topic')
                    select_count++;
                    // console.log("บวก : "+select_count);
                }


            });

            $('.add-to-table3').on('click', function() {
                var category_id3 = $('#category_id').val();
                id3 = category_id3;
                var inspect_topic_type_id3 = $('#category_id3 option:selected').val();
                var inspect_topic_type_name3 = $('#category_id3 option:selected').text();
                var inspect_topics_name3 = $('#inspect_topics3 option:selected').text();
                var inspect_topics_id3 = $('#inspect_topics3').val();
                var status = true;

                //count old row
                var countOld = 0;
                    $('.inspect_topic_old').each(function(index, value) {
                        countOld++ ;
                    });
                console.log(countOld);
                //validate old row
                    if(countOld > 0){
                        $('.inspect_topic_old').each(function(index, value) {
                                if ($(value).find(".inspect_topic_id").text() === inspect_topics_id3) {
                                    status = false;
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'error',
                                        title: 'ท่านได้เพิ่มรายการนี้แล้ว',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                } else {
                                    $('.inspect_topic3').each(function(index, value) {
                                    if ($(value).find(".inspect_topic_id").text() === inspect_topics_id3) {
                                        status = false;
                                        Swal.fire({
                                            position: 'center-center',
                                            icon: 'error',
                                            title: 'ท่านได้เพิ่มรายการนี้แล้ว',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    } else {
                                        status = true;
                                    }
                                });
                                }

                        });
                    }
                    else{
                        $('.inspect_topic3').each(function(index, value) {
                            if ($(value).find(".inspect_topic_id").text() === inspect_topics_id3) {
                                status = false;
                                Swal.fire({
                                    position: 'center-center',
                                    icon: 'error',
                                    title: 'ท่านได้เพิ่มรายการนี้แล้ว',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            } else {
                                status = true;
                            }
                        });
                    }





                // console.log(test)

                if (status) {
                    inspect_template_detail_table3.row.add([
                        '<td><a class="list_cancel3"><i class="fas fa-times text-red" style="cursor: pointer;"></i></a></td>',
                        '<td><span class="category_id mat_hide ">' + inspect_topic_type_id3 + '</span>' +
                        inspect_topic_type_name3 + '</span></td>',
                        '<td><span class="inspect_topic_id mat_hide ">' + inspect_topics_id3 +
                        '</span>' + inspect_topics_name3 + '</td>',
                    ]).draw(false).nodes().to$().addClass('inspect_topic3')
                    // console.log("บวก : "+select_count);
                }


            });

            $('#inspect_template_detail_table tbody').on('click', '.list_cancel', function() {
                var index = inspect_template_detail_table.row($(this).parents('tr'));
                var rowindex = index.index();
                inspect_template_detail_table
                    .row($(this).parents('tr'))
                    .remove()
                    .draw();
                select_count3--;
                // console.log("ลบ : "+select_count);
            });

            $('#inspect_template_detail_table3 tbody').on('click', '.list_cancel3', function() {
                var index = inspect_template_detail_table3.row($(this).parents('tr'));
                var rowindex = index.index();
                inspect_template_detail_table3
                    .row($(this).parents('tr'))
                    .remove()
                    .draw();
                select_count3--;
                // console.log("ลบ : "+select_count);
            });
        });
    </script>
@endsection
