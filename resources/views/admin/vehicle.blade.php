@extends('adminlte::page')

@section('css')

@endsection

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>
                <li class="breadcrumb-item active">รถขนส่ง</li>
            </ol>
        </div><!-- /.col -->
        <div>
            <br>
            <button type="button" class="btn bg-gradient-green border btn-modal" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</button>
        </div>
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-gdp">
            <div class="card-body p-0">
            <div class="card-header ogn-stock-yellow text-left" >
                    <h6 class="m-0"> รถขนส่ง</h6>
                    <input type="hidden" name="company_id" id="company_id" value="{{session('company')}}">
                </div>
                <div class="p-2">
                    <div class="float-right">
                        <input type="search" id="custom-search-input" class="form-control form-control-sm"
                               placeholder="ค้นหา">
                    </div>

                    <div class="card-title mb-0"></div>
                </div>
                <table id="vehicle_table" class="table w-100" style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="text-center">
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">ยี่ห้อ</th>
                            <th scope="col" class="w-auto">รุ่น</th>
                            <th scope="col" class="w-auto">ทะเบียนรถ</th>
                            <th scope="col" class="w-auto">บริษัท</th>
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


<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #9BC56D;">
                <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">เพิ่มรายการรถขนส่ง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                            <label for="" class="form-label">ยี่ห้อ</label>
                            <input type="text" id="brand" class="form-control">
                            <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                            <input type="hidden" name="id" id="id" value="">
                            <small id="checkbrand"></small>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                            <label for="" class="form-label">รุ่น</label>
                            <input type="text" id="model" class="form-control">
                            <small id="checkmodel"></small>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                            <label for="" class="form-label">หมายเลขทะเบียน</label>
                            <input type="text" id="plate" class="form-control">
                            <small id="checkplate"></small>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ogn-stock-grey " style="color:black;" data-dismiss="modal"><em class="fas fa-close"></em> ยกเลิก</button>
                <button type="button" class="btn ogn-stock-green text-white btn-save " style=" color:black;"><em class="fas fa-save "></em> บันทึก</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        let company_id = $('#company_id').val();
        let vehicle_table = $('#vehicle_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': "{{route(('api.v1.vehicle.list'))}}",
                    'data': {'company_id':company_id}
                },
                'columns': [
                    { data: 'id', render : function(data, type, row, meta){
                            return meta.row +1;
                        } },
                    { data: 'brand' }, //กำหนดข้อมูลที่นำมาแสดง
                    { data: 'model' },
                    { data: 'plate' },

                    { data: 'id', render : function(data,type,row,meta){

                        return row.company.name_th + "<br>" + row.company.name_en;
                    }},

                    { data: 'id',
                    render : function(data,type,row,meta){
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
                    { responsivePriority: 1, targets: [0,1,2] }
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


        $('#custom-search-input').keyup(function(){
            vehicle_table.search($(this).val()).draw() ;
            })

        $(document).on('click', '.btn-modal', function() {
            $('#myModal').modal('show');
            let id = $(this).data('id');
            $('#id').val(id);

            if (!id) {
                $('#brand').val('');
                $('#model').val('');
                $('#plate').val('');
                $('.modal-title').text('เพิ่มรายการรถขนส่ง');
            } else {
                $.ajax({
                    type: "post",
                    url: "{{route(('api.v1.vehicle.view.edit'))}}",
                    data: {'id':id},
                    dataType: "json",
                    success: function (response) {
                        $('#brand').val(response.brand);
                        $('#model').val(response.model);
                        $('#plate').val(response.plate);
                        $('#company_id').val(response.company_id);
                        $('.modal-title').text('เพิ่มรายการรถขนส่ง');
                    }
                });
            }
        });

        $('.btn-save').on('click', function() {

            var formData = {
                id: $('#id').val(),
                brand: $('#brand').val(),
                model: $('#model').val(),
                token: $("#_token").val(),
                plate: $('#plate').val(),
                company_id: $('#company_id').val()
            }

            if (!formData.id) {
                $.ajax({
                    type: "post",
                    url: "{{route('api.v1.vehicle.validate')}}",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            Swal.fire({
                                title: 'ยืนยันการเพิ่มรถขนส่ง?',
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
                                        url: "{{route('api.v1.vehicle.create')}}",
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
                            if ($('#brand').val() === '') {

                                $('#checkbrand').addClass('text-danger').text('กรุณากรอกข้อมูล');
                            } else {
                                $('#checkbrand').hide()
                            }
                            if ($('#model').val() === '') {

                                $('#checkmodel').addClass('text-danger').text('กรุณากรอกข้อมูล');
                            } else {
                                $('#checkmodel').hide()
                            }
                            if ($('#plate').val() === '') {

                                $('#checkplate').addClass('text-danger').text('กรุณากรอกข้อมูล');
                            } else {
                                $('#checkplate').hide()
                            }
                        }
                    }
                });
            } else {
                $.ajax({
                    type: "post",
                    url: "{{route('api.v1.vehicle.validate')}}",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            Swal.fire({
                                title: 'ยืนยันการแก้ไขรถขนส่ง?',
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
                                        url: "{{route('api.v1.vehicle.edit')}}",
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
                                                window.location.reload();
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

                                $('#checkbrand').addClass('text-danger').text('กรุณากรอกข้อมูล');
                            } else {
                                $('#checkbrand').hide()
                            }
                            if ($('#model').val() === '') {

                                $('#checkmodel').addClass('text-danger').text('กรุณากรอกข้อมูล');
                            } else {
                                $('#checkmodel').hide()
                            }
                            if ($('#plate').val() === '') {

                                $('#checkplate').addClass('text-danger').text('กรุณากรอกข้อมูล');
                            } else {
                                $('#checkplate').hide()
                            }
                        }
                    }
                });
            }
        });

    });
</script>
@endsection
