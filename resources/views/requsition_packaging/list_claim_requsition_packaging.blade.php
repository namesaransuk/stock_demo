@extends('adminlte::page')

@section('css')
<style>
    .modal-full {
        min-width: 85%;
        margin-left: 80;
    }

    .template_row:first-child {
        display: none;
        margin: 0 auto;
    }
</style>
@endsection

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>

                <li class="breadcrumb-item active">เคลมบรรจุภัณฑ์</li>
            </ol>
        </div><!-- /.col -->
        <div >
            <br>
            <!-- <a class="btn ogn-stock-yellow " href="{{route('requsition.packaging.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a> -->
            <!-- <button type="button"  data-toggle="modal" data-target="#myModal"></button> -->
        </div>
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-gdp">
            <!-- <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                    <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รับเข้าวัตถุดิบ และ บรรจุภัณฑ์</h6>
                </div> -->
            <!-- <div class="p-2">
                    <div class="float-right">
                        <input type="search" id="custom-search-input" class="form-control form-control-sm"
                               placeholder="ค้นหา">
                    </div>
                    <a href="" type="button" style=""
                       class="btn rounded ml-2"><em class="fas fa-plus-circle text-success"></em>
                        เพิ่มรายการ</a>
                    <div class="card-title mb-0"></div>
                </div> -->
            <div class="card-body p-0">
            <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">

                <table id="requsition_packaging_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">ล็อตสินค้า</th>
                            <th scope="col" class="w-auto">ชื่อวัตถุดิบ</th>
                            <th scope="col" class="w-auto">จำนวนที่เคลม</th>
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
    $(function() {
        $('.dropify').dropify();

        let requsition_packaging_table =$('#requsition_packaging_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.requsition.packaging.claim.list'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id' },
                    { data: 'requsition_packaging.paper_no' },
                    { data: 'packaging_lot.lot_no_pm' },
                    { data: 'packaging_lot.packaging.name' },
                    { data: 'qty' },
                    { data: 'id',
                        render : function(data,type,row,meta){
                            let url2 = "{{ route('requsition.packaging.return.create', "__id") }}".replaceAll("__id",row.id);

                            return `
                                <a type="button"  style="color: red;"  id="cancel_claim" data-id="${row.id}"  class= "btn-modal btn-update-inspect_ready " ><i class="fas fa-arrow-circle-right p-1 text-danger"></i> ยกเลิก </a>
                                <a type="button"  style=""  id="return_claim" data-id="${row.id}"  class= "btn-modal btn-update-inspect_ready " ><i class="fas fa-arrow-circle-right p-1 text-success"></i> คืนสต็อก </a>
                                `;
                        }
                    },

                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    { responsivePriority: 1, targets: [0,1,2] }
                ],

                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
        })




            $(document).on('click','#cancel_claim',function(){
                let id = $(this).data('id');

                Swal.fire({
                        title: 'ยกเลิกการเคลม?',
                        text: "ต้องยกเลิกการเคลมใช่หรือไม่!",
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
                                url: "{{route('api.v1.requsition.packaging.cancel.claim')}}",
                                data: {'id':id},
                                dataType: "json",
                                success: function (response) {
                                    if (response) {
                                        Swal.fire({
                                            position: 'center-center',
                                            icon: 'success',
                                            title: 'ยกเลิกสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500,

                                        })
                                        requsition_packaging_table.ajax.reload();
                                    } else {
                                        Swal.fire({
                                            position: 'center-center',
                                            icon: 'warning',
                                            title: 'ยกเลิกไม่สำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    }
                                }
                            });
                        }
                    });
            });

            $(document).on('click','#return_claim',function(){
                let id = $(this).data('id');

                Swal.fire({
                        title: 'ยืนยันการส่งคืนสต็อก?',
                        text: "ต้องการยืนยันการส่งคืนสต็อกใช่หรือไม่!",
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
                                url: "{{route('api.v1.requsition.packaging.return.claim')}}",
                                data: {'id':id},
                                dataType: "json",
                                success: function (response) {
                                    if (response) {
                                        Swal.fire({
                                            position: 'center-center',
                                            icon: 'success',
                                            title: 'ยืนยันสำเร็จ',
                                            showConfirmButton: false,
                                            timer: 1500,

                                        })
                                        requsition_packaging_table.ajax.reload();
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

            });

    });
</script>
@endsection
