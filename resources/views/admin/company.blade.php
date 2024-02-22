@extends('adminlte::page')

@section('css')
<style>
    .error {
        color: red !important;
    }

</style>
@endsection

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>
                <li class="breadcrumb-item active">บริษัทในเครือ</li>
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
            <div class="card-header ogn-stock-yellow " >
                <h6 class="m-0 text-left"> บริษัทในเครือ </h6>
            </div>
            <div class="card-body p-0">
                <div class="p-2">
                    <div class="float-right mb-2">
                        <input type="search" id="custom-search-input" class="form-control form-control-sm"
                               placeholder="ค้นหา">
                    </div>

                </div>
                <table id="company_table" class="table w-100" style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="">
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">โลโก้</th>
                            <th scope="col" class="w-auto">รายการบริษัท</th>
                            <th scope="col" class="w-auto">อีเมล</th>
                            <th scope="col" class="w-auto">เบอร์โทร</th>
                            <th scope="col" class="w-auto">เว็บไซต์</th>
                            <th scope="col" class="w-auto">ที่อยู่</th>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #9BC56D;">
                <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">เพิ่มรายการวัตถุดิบ</h5>
                <button type="button" class="close clear-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form action="" id="formData" method="post">
                <div class="container">
                    <div class="row">

                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                                <div class="col-12">
                                <label for="" class="form-label">ชื่อบริษัทภาษาไทย</label>
                                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                                <input type="hidden" name="id" id="id" value="">
                                <input type="text" id="name_th" class="form-control" required>
                                <small id="checkname_th"></small>
                                </div>
                                <div class="col-12">
                                <label for="" class="form-label">ชื่อบริษัทภาษาอังกฤษ</label>
                                <input type="text" id="name_en" class="form-control" required>
                                <small id="checkname_en"></small>
                                </div>
                                <div class="col-12">
                                <label for="" class="form-label">ที่อยู่บริษัทภาษาไทย</label>
                                <textarea name="" id="address_th" class="form-control" required cols="10" rows="3"></textarea>

                                <small id="checkaddress_th"></small>
                                </div>
                                <div class="col-12">
                                <label for="" class="form-label">ที่อยู่บริษัทภาษาอังกฤษ</label>
                                <textarea name="" id="address_en" class="form-control" required cols="10" rows="3"></textarea>

                                <small id="checkaddress_en"></small>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                            <label for="" class="form-label">ภาพโลโก้</label>
                                <input type="file" class="dropify" data-height="330" id="logo_file" class="form-control" data-default-file = "" required>
                                <input type="hidden" name="logo" id="logo" value="">
                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                <label for="" class="form-label">อีเมล</label>
                                <input type="text" id="email" class="form-control" required>
                                <small id="checkemail"></small>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                <label for="" class="form-label">เว็บไซด์</label>
                                <input type="text" id="website" class="form-control" required>
                                <small id="checkwebsite"></small>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                <label for="" class="form-label">เบอร์โทร</label>
                                <input type="text" id="contact_number" class="form-control" required>
                                <small id="checkcontact_number"></small>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">

                            </div>

                    </div>

                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ogn-stock-grey clear-modal" style="color:black;" data-dismiss="modal"><em class="fas fa-close"></em> ยกเลิก</button>
                <button type="button" class="btn ogn-stock-green text-white btn-save " style=" color:black;"><em class="fas fa-save "></em> บันทึก</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('.dropify').dropify({
            tpl: {
                message: '<div class="dropify-message"><span class="file-icon"/><p><h5>กรุณาเลือกไฟล์ PNG หรือ JPG</h5></p></div>',
                preview: '<div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-infos-message"></p></div></div></div>',
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        document.getElementById('logo_file').onchange = function() {
            $('#logo').val(this.files.item(0).name);
        };


        let company_table = $('#company_table').DataTable({
            "pageLength": 10,
            "responsive": true,
            // "order": [4, "desc"],
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '{{route(('api.v1.company.list'))}}'
            },
            'columns': [{
                    data: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'logo',
                    render: function(data, type, row, meta) {
                        let ref = "{{asset('uploads/company_logo/')}}"
                        return `
                            <img src="${ref+'/'+row.logo}" width='100px' height='100px'">
                            `
                    }
                },
                {
                    data: 'name_th',
                    render: function(data, type, row, meta) {
                        return row.name_th + "<br>" + row.name_en;
                    }
                },
                {
                    data: 'email'
                },
                {
                    data: 'contact_number'
                },
                {
                    data: 'website'
                },
                {
                    data: 'address_th',
                    render: function(data, type, row, meta) {
                        return "ที่อยู่ : " + row.address_th + "<br>" + "Address : " + row.address_en;
                    }
                },

                {
                    data: 'id',
                    render: function(data, type, row, meta) {
                        return `<div class="dropdown show">
                                    <a class="btn btn-sm text-secondary rounded border ml-1" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit"></i> จัดการ</a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a type="button" style=""  data-id="${row.id}" id="myModal-edit"  class="dropdown-item reset-me btn-modal "><i class="fas fa-edit"></i> แก้ไข</a>
                                        <a type="button" style="" data-id="${row.id}" class="dropdown-item delete-me btn-delete"><em class="fas fa-trash-alt"></em> ลบ</a>
                                    </div>
                                </div>`;
                    }
                },

            ],
            columnDefs: [{
                    responsivePriority: 1,
                    targets: [0, 1, 4, 5, 6]
                },
                {
                    responsivePriority: 7,
                    targets: [2, 3]
                }
            ],

            "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
        })

        $('#custom-search-input').keyup(function(){
            company_table.search($(this).val()).draw() ;
        })

        $(document).on('click', '.btn-modal', function() {

            let id = $(this).data('id');
            $('#id').val(id);

            $(".dropify-clear").trigger("click");
            $("#logo_file").prop('required',true);

            $('#myModal').modal('show');
            if (!id) {

                $('.modal-title').text('เพิ่มรายการบริษัทในเครือ');
                $('#name_th').val('');
                $('#name_en').val('');
                $('#email').val('');
                $('#address_th').val('');
                $('#address_en').val('');
                $('#website').val('');
                $('#contact_number').val('');
                $('#logo').val('');
                $('#id').val('');

            } else {

                $('.modal-title').text('แก้ไขรายการบริษัทในเครือ');
                $.ajax({
                    type: "post",
                    url: "{{route(('api.v1.company.view.edit'))}}",
                    data: {
                        'id': id
                    },
                    dataType: "json",
                    success: function(response) {
                        let img_url = "{{asset('uploads/company_logo')}}"

                        $('#name_th').val(response.name_th);
                        $('#name_en').val(response.name_en);
                        $('#email').val(response.email);
                        $('#address_th').val(response.address_th);
                        $('#address_en').val(response.address_en);
                        $('#website').val(response.website);
                        $('#contact_number').val(response.contact_number);

                        $('#logo').val(response.logo); //name
                        $("#logo_file").attr("data-default-file", img_url + "/" + response.logo); //dropify

                        $('#logo_file').removeAttr('required');
                        $('.dropify-render').html('<img src="" />');
                        $('.dropify-render img').attr('src',img_url + "/" + response.logo);
                        $('.dropify-preview').css('display','block');
                        $('.dropify-filename-inner').text(response.logo);

                        $('#id').val(response.id);
                    }
                });
            }



        });
        $('.btn-save').on('click', function() {

            if ($('#formData').valid()) {
                var files = $('#logo_file').prop('files')[0]

                var formData = new FormData();

                formData.append('logo',$('#logo_file').prop('files')[0]);
                formData.append('logo_name',$('#logo').val());
                formData.append('name_th',$('#name_th').val());
                formData.append('name_en',$('#name_en').val());
                formData.append('email',$('#email').val());
                formData.append('address_th',$('#address_th').val());
                formData.append('address_en',$('#address_en').val());
                formData.append('website',$('#website').val());
                formData.append('contact_number',$('#contact_number').val());
                formData.append('token',$("#_token").val());
                formData.append('id',$('#id').val());

                console.log(formData.get('id'));

                if (!formData.get('id')) {
                    // console.log(JSON.stringify(formData));
                    Swal.fire({
                                title: 'ยืนยันการเพิ่มบริษัท?',
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
                                        url: "{{route('api.v1.company.create')}}",
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        success: function(response) {
                                            if (response) {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'success',
                                                    title: 'เพิ่มรายการสำเร็จ',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                })
                                                $(".clear-modal").click();
                                                company_table.ajax.reload();
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
                                title: 'ยืนยันการแก้ไขบริษัท?',
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
                                        url: "{{route(('api.v1.company.edit'))}}",
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        success: function(response) {

                                            if (response) {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'success',
                                                    title: 'แก้ไขรายการสำเร็จ',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                })
                                                $(".clear-modal").click();
                                                company_table.ajax.reload();
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
                }
            }
        });

        $(".clear-modal").on('click',function(){
            $(".dropify-clear").click();
                $('.dropify-filename-inner').text('');
                $('#name_th').val('');
                $('#name_en').val('');
                $('#email').val('');
                $('#address_th').val('');
                $('#address_en').val('');
                $('#website').val('');
                $('#contact_number').val('');
                $('#logo').val('');
                $('#id').val('');
            $("#myModal").modal("hide");
        });

        $(document).on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'ยืนยันการลบบริษัทในเครือ?',
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
                        url: "{{route('api.v1.company.delete')}}",
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

                {{-- drawCallback: function( settings ) {

                    @cannot('admin')
                        $('.buttom_delete').remove();
                    @endcan

                }, --}}
