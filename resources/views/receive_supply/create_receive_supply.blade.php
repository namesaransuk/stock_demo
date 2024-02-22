@extends('adminlte::page')

@section('css')
<style>
    .modal-full {
        min-width: 50%;
        margin-left: 80;
    }

    .template_row:first-child {
        display: none;
        margin: 0 auto;
    }
    .supply_hide {
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
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('list.receive.supply') }}">รับเข้าวัสดุสิ้นเปลือง</a></li>
                <li class="breadcrumb-item active">เพิ่มรายการนำเข้า</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<div class="card">
    <div class="card-header ogn-stock-green ">
        เพิ่มรายการนำเข้าวัสดุสิ้นเปลือง
    </div>
    <div class="card-body">
        <form action="" id="receive_valid">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 ">
                <label for="" class="form-label">หมายเลขเอกสาร</label>
                <input type="text" id="paper_no" class="form-control" required>
                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                <input type="hidden" name="id" id="id" value="">
                <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
                <small id="checkpaper_no"></small>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                <label for="" class="form-label">วันที่นำเข้า (ค.ศ.)</label>
                <input type="datetime-local" id="date" name="date" class="form-control" required>
                <small id="checkdate"></small>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 ">
                <label for="" class="form-label">แบรนด์สินค้า</label>
                <select name="" id="brand_vendor_id" class="form-control">
                    @foreach ( $vendors as $brand )
                    @if ($brand->type == 1)
                    <option value="{{$brand->id}}">{{$brand->brand}}</option>
                    @endif

                    @endforeach
                </select>
            </div>
        </div>
        </form>
        <hr class="my-4">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-gdp">
                    <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                        <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รับเข้าวัสดุสิ้นเปลือง </h6>
                    </div>
                    <div class="p-2">
                        <div class="float-right">
                            <input type="search" id="custom-search-input" class="form-control form-control-sm" placeholder="ค้นหา">
                        </div>
                        <a href="" type="button" style="" data-toggle="modal" data-target="#myModal" class="btn rounded ml-2"><em class="fas fa-plus-circle text-success"></em> เพิ่มรายการ</a>
                    </div>
                    <div class="card-body p-0">
                        <table id="receive_supply_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                            <caption style="display: none"></caption>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="w-auto">#</th>
                                    <th scope="col" class="w-auto">รายการ</th>
                                    <th scope="col" class="w-auto">บริษัท</th>
                                    <th scope="col" class="w-auto">Lot</th>
                                    <th scope="col" class="w-auto">จำนวนชิ้น</th>
                                    {{-- <th scope="col" class="w-auto">MFG.</th>
                                    <th scope="col" class="w-auto">EXP.</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div style="text-align: right;">
                    <button class="btn ogn-stock-grey text-black btn-back"><em class="fas fa-arrow-left"></em> ย้อนกลับ</button>
                    <button class="btn ogn-stock-green text-white" id="create_receive_supply"><em class="fas fa-save"></em> บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-full">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #9BC56D;">
                <h5 class="modal-title list_add" id="staticBackdropLabel" style="color: white;">เพิ่มรายการนำเข้า</h5>
                <button type="button" class="close clear-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_valid">
                    <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3 d-flex flex-column">
                                <label for="" class="form-label">ชื่อวัสดุสิ้นเปลือง</label>

                                <select name="" id="supply_id" class="form-control select2">
                                    @foreach ( $supplies as $supply )
                                    <option value="{{$supply->id}}">{{$supply->name}}</option>
                                    @endforeach
                                </select>

                                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                                <input type="hidden" name="id" id="id" value="">
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3 ">
                                <label for="" class="form-label">บริษัท</label>
                                @php
                                    $current_company = session('company')?:'';
                                @endphp
                                <select name="" id="company_id" class="form-control" disabled >
                                    @foreach ( $companies as $company )

                                    <option {{$current_company==$company->id?'selected':''}} value="{{$company->id}}">{{$company->name_th}}</option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3 ">
                                <label for="" class="form-label">หมายเลข ล็อต</label>
                                <input type="text" id="lot" name="lot" class="form-control" required>
                                <small id="checklot"></small>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                <label for="" class="form-label">จำนวนชิ้น</label>
                                <input type="number" min="0" id="qty" name="qty" class="form-control" value="0" required>
                                <small id="checkqty"></small>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                {{-- <label for="" class="form-label">MFG.</label> --}}
                                <input type="hidden" id="mfg" name="mfg" class="form-control" required>
                                <small id="checkmfg"></small>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                {{-- <label for="" class="form-label">EXP.</label> --}}
                                <input type="hidden" id="exp" name="exp" class="form-control" required>
                                <small id="checkexp"></small>
                            </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="margin-top: 10px;;">
                <button type="button" class="btn clear-modal ogn-stock-grey " style="color:black;" data-dismiss="modal"><em class="fas fa-close"></em> ยกเลิก</button>
                <button  class="btn btn-save ogn-stock-green text-white add-to-table" style=" color:black;"><em class="fas fa-save"></em> เพิ่ม</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(function() {
        $('.select2').select2();

    var supply = []

        $('.dropify').dropify();
        let receive_supply_table = $('#receive_supply_table').DataTable({
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
                    // targets: [4, 5, 6]

                }
            ],
            "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">'
        });

        $('.add-to-table').on('click', function(){
            if ($('#form_valid').valid() && check_duplicate_numberlot()) {
                var supply_id = $('#supply_id').val();
                var supply_name = $('#supply_id option:selected').text();
                var company_id= $('#company_id').val();
                var company_name= $('#company_id option:selected').text();
                var lot= $('#lot').val();
                var qty= $('#qty').val();
                var mfg= $('#mfg').val();
                var exp= $('#exp').val();
                var index = receive_supply_table.rows().count();
                var row = receive_supply_table.row.add([
                    '<td><a class="list_cancel"><i class="fas fa-times text-red"></i></a></td>',
                    '<td><span class="supply_id supply_hide ">'+supply_id +'</span>'+supply_name+'</span></td>',
                    '<td><span class="supply_com_id supply_hide ">'+company_id  +'</span>'+company_name+'</td>',
                    '<td><span class="supply_lot ">'+lot +'</span></td>',
                    '<td><span class="supply_qty ">'+new Intl.NumberFormat("th-TH").format(qty) +'</span></td>',
                    // '<td><span class="supply_mfg ">'+mfg +'</span></td>',
                    // '<td><span class="supply_exp ">'+exp +'</span></td>',
                ]).draw(false).nodes()
                .to$()
                .addClass( 'supplyrow' )
                $(".clear-modal").click();
            }
        })

        function check_duplicate_numberlot(){
            var lot= $('#lot').val();
            var status = true;
            if (lot != "" || null) {
                $('.supply_lot').each(function(index,value){
                        if ( lot == $(value).text()) {
                            Swal.fire({
                                icon: 'error',
                                title: 'ล็อตซ้ำ',
                                text: 'กรุณากรอกล็อตใหม่!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            status = false;
                        }
                })
            }
            return status;
        }

        $(".clear-modal").on('click', function() {
                $('#lot').val(""),
                $('#qty').val("0"),
                $('#mfg').val(""),
                $('#exp').val(""),
                $("#myModal").modal("hide");
        });

        $('.btn-back').on('click',function(){
            window.history.back();
        });

        $('#receive_supply_table tbody').on('click', '.list_cancel', function() {
            var index = receive_supply_table.row($(this).parents('tr'));
            var rowindex = index.index();
            receive_supply_table
                .row($(this).parents('tr'))
                .remove()
                .draw();
            supply.splice(rowindex, 1);
        });

        $('#create_receive_supply').on('click', function() {
            if ($('#receive_valid').valid()) {
            var formdata_receive = new FormData();
                formdata_receive.append('paper_no', $('#paper_no').val());
                formdata_receive.append('date', $('#date').val());
                formdata_receive.append('brand_vendor_id', $('#brand_vendor_id').val());
                formdata_receive.append('_token', $('#_token').val());
                formdata_receive.append('id', $('#id').val());
                formdata_receive.append('user_id', $('#user_id').val());
                formdata_receive.append('company_id', {{session('company')}});

            $('.supplyrow').each(function(index,value){
                formdata_receive.append('supply['+index+'][supply_id]',$(value).find('.supply_id').text())
                formdata_receive.append('supply['+index+'][company_id]',$(value).find('.supply_com_id').text())
                formdata_receive.append('supply['+index+'][lot]',$(value).find('.supply_lot').text())
                formdata_receive.append('supply['+index+'][qty]',$(value).find('.supply_qty').text().replaceAll(',',''))
                formdata_receive.append('supply['+index+'][mfg]',$(value).find('.supply_mfg').text())
                formdata_receive.append('supply['+index+'][exp]',$(value).find('.supply_exp').text())
            })
            var rows_supply = receive_supply_table.rows().count();
                if (rows_supply > 0) {
                    Swal.fire({
                                title: 'ยืนยันการนำเข้าวัสดุสิ้นเปลือง?',
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
                                        url: "{{route('api.v1.receive.supply.create')}}",
                                        data: formdata_receive,
                                        contentType: false,
                                        processData: false,
                                        cache: false,
                                        // dataType: "dataType",
                                        success: function (response) {
                                            if (response != null) {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'success',
                                                    title: 'เพิ่มรายการนำเข้าสำเร็จ',
                                                    showConfirmButton: false,
                                                    timer: 1500,

                                                })
                                                window.location.assign("{{ route('list.receive.supply') }}")
                                            } else {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'warning',
                                                    title: 'เพิ่มรายการนำเข้าไม่สำเร็จ',
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
                                title: 'กรุณาเพิ่มรายการนำเข้าวัสดุสิ้นเปลือง',
                                showConfirmButton: false,
                                timer: 1500
                            })
                }

            }

        })


    });
</script>
@endsection
