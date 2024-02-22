@extends('adminlte::page')

@section('css')

@endsection

@section('content_header')
<div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">จัดการผู้ใช้</li>
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
                <div class="card-header ogn-stock-yellow text-left" >
                    <h6 class="m-0">จัดการผู้ใช้</h6>
                </div>
                <div class="p-2">
                    <div class="float-right">
                        <input type="search" id="custom-search-input" class="form-control form-control-sm"
                               placeholder="ค้นหา">
                    </div>

                    <div class="card-title mb-0"></div>
                </div>
                <div class="card-body p-0">

                    <table id="user_table" class="table w-100" style="margin-top: 0!important; margin-bottom: 0!important;">
                        <caption style="display: none"></caption>
                        <thead class="text-center">
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">Email</th>
                            <th scope="col" class="w-auto">บริษัท</th>
                            <th scope="col" class="w-auto">ตำแหน่ง</th>
                            <th scope="col" class="w-auto">สถานะ</th>
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


    <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false"  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #9BC56D;">
        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">เพิ่มรายการจัดการผู้ใช้</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <form id="validcheck">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                        <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                        <input type="hidden" name="id" id="id" value="">
                        <label for="email" class="form-label">อีเมล</label>
                        <input type="email" id="email" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                        <label for="password" class="form-label">รหัสผ่าน</label>
                        <input type="password" id="password" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                        <label for="emp_id" class="form-label">พนักงาน</label><br>
                        <select name="" id="emp_id" class="form-control select2" >
                            @foreach ( $employees as $employee )
                                <option value="{{$employee->id}}">{{$employee->emp_no}} | {{$employee->fname}} {{$employee->lname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                        <label for="user_id" class="form-label">ตำแหน่งผู้ใช้</label><br>
                        <select name="role_id" id="role_id" class="form-control select2" >
                            @foreach ( $roles as $role )
                                <option value="{{$role->id}}">{{$role->code}} | {{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
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
        $('.select2').select2();

        $(document).ready(function() {

        let user_table = $('#user_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.user.list'))}}'
                },
                'columns': [
                    { data: 'id', render : function(data, type, row, meta){
                        return meta.row +1;
                    } },
                    { data: 'id' , render: function(data, type, row, meta){
                        return row.email;
                    } },
                    { data: 'id' , render: function(data, type, row, meta){
                        return row.employee.company.name_th;
                    } },
                    { data: 'id' , render: function(data, type, row, meta){
                        return row.user_roles[0].role.name;
                    } },
                    { data: 'id' , render: function(data, type, row, meta){
                        if (row.record_status == 1) {
                            text = '<span class="badge badge-pill badge-success" style="text-align : center;">เปิดใช้งาน</span>'
                        }else{
                            text = '<span class="badge badge-pill badge-danger" style="text-align : center;">ปิดใช้งาน</span>'
                        }
                        return text;
                    } },
                    { data: 'id',
                    render : function(data,type,row,meta){
                        return `<div class="dropdown show">
                                    <a class="btn btn-sm text-secondary rounded border ml-1" href="#" user="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit"></i> จัดการ</a>
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
            user_table.search($(this).val()).draw() ;
            })

        $(document).on('click','.btn-modal',function(){

            let id = $(this).data('id');
            $('#id').val(id);


            $('#myModal').modal('show');
            if(!id){

                $('.modal-title').text('เพิ่มรายการผู้ใช้');
                $('#email').val('');
                $('#password').val('');

            } else {

                $('.modal-title').text('แก้ไขรายการผู้ใช้');
                $.ajax({
                    type: "post",
                    url: "{{route(('api.v1.user.view.edit'))}}",
                    data: {'id':id},
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        $('#email').val(response[0].email);
                        $('#emp_id').val(response[0].emp_id).change();
                        $('#role_id').val(response[0].role_id).change();
                    }
                });
            }



        });
        $('.btn-save').on('click', function() {
            if($('#validcheck').valid()){
                var formData = {
                    email: $('#email').val(),
                    password: $('#password').val(),
                    emp_id: $('#emp_id').val(),
                    role_id: $('#role_id').val(),

                    token: $("#_token").val(),
                    id:$('#id').val()
                }

                if (!formData.id) {
                    $.ajax({
                    type: "post",
                    url: "{{route(('api.v1.user.validate'))}}",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            Swal.fire({
                                title: 'ยืนยันการเพิ่มผู้ใช้?',
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
                                        url: "{{route(('api.v1.user.create'))}}",
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
                            if ($('#name').val() === '') {

                                $('#checkname').addClass('text-danger').text('กรุณากรอกข้อมูล');
                            } else {
                                $('#checkname').hide()
                            }
                        }
                    }
                });
                } else {
                    $.ajax({
                        type: "post",
                    url: "{{route(('api.v1.user.validate'))}}",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            Swal.fire({
                                title: 'ยืนยันการแก้ไขผู้ใช้?',
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
                                        url: "{{route(('api.v1.user.edit'))}}",
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
                            if ($('#name').val() === '') {

                                $('#checkname').addClass('text-danger').text('กรุณากรอกข้อมูล');
                            } else {
                                $('#checkname').hide()
                            }
                        }
                    }
                    });
                }
            }
        });

        $(document).on('click','.btn-delete',function(){
            let id = $(this).data('id');
            Swal.fire({
                title: 'ยืนยันการลบผู้ใช้?',
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
                                url: "{{route('api.v1.user.delete')}}",
                                data: {'id':id},
                                dataType: "json",
                                success: function (response) {
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
