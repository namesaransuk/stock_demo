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
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('list.requsition.product') }}">รายการส่งออกสินค้า</a></li>
                <li class="breadcrumb-item active">ประวัติการแก้ไข</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
    <input type="hidden" name="id" id="id" value="{{$requsition_product_id}}">

    <div class="card">
        <div class="card-header ogn-stock-green text-left ">
            <h3 class="card-title header-card">รายการปัจจุบัน</h3>
        </div>
        <div class="card-body">
            <form action="" id="receive_valid">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                    <label for="" class="form-label">หมายเลขเอกสาร</label>
                    <input type="text" id="paper_no" class="form-control"  value="{{$requsition_product->paper_no}}"  readonly>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                    <label for="" class="form-label">วันที่ส่งออก</label>
                    <input type="text" id="date" name="date" value="{{$requsition_product->date}}" class="form-control" readonly>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                    <label for="" class="form-label">ประเภทการส่ง</label> <br>
                    <select name="transport_type" id="transport_type" class="select2 w-100" disabled>
                        <option value="1" {{$requsition_product->transport_type==1?'selected':''}}>บริษัทเป็นผู้ส่ง</option>
                        <option value="2" {{$requsition_product->transport_type==2?'selected':''}}>ลูกค้ามารับเอง</option>
                        <option value="3" {{$requsition_product->transport_type==3?'selected':''}}>ส่งผ่านบริษัทขนส่ง</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h6>รายละเอียดการจัดส่ง</h6>
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 mt-2">
                        <label for="" class="form-label">ชื่อ-นามสกุล</label>
                        <input type="text" id="cus_name" name="cus_name" class="form-control" value="{{$requsition_product->receive_name}}" readonly required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">เบอร์โทร</label>
                        <input type="text" id="tel" name="tel" class="form-control" value="{{$requsition_product->receive_tel}}" readonly required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">ทะเบียนรถ</label>
                        <input type="text" id="vehicle" name="vehicle" class="form-control" value="{{$requsition_product->receive_vehicle}}" readonly required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">รายละเอียดที่อยู่</label>
                        <input type="text" id="house_no" name="house_no" class="form-control" value="{{$requsition_product->receive_house_no}}" readonly required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">ตำบล</label>
                        <input type="text" id="tumbol" name="tumbol" class="form-control" value="{{$requsition_product->receive_tumbol}}" readonly required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">อำเภอ</label>
                        <input type="text" id="aumphur" name="aumphur" class="form-control" value="{{$requsition_product->receive_aumphur}}" readonly required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">จังหวัด</label>
                        <input type="text" id="province" name="province" class="form-control" value="{{$requsition_product->receive_province}}" readonly required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                        <label for="" class="form-label">รหัสไปรษณีย์</label>
                        <input type="text" id="postcode" name="postcode" class="form-control" value="{{$requsition_product->receive_postcode}}" readonly required>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                        <label for="" class="form-label">หมายเหตุ</label>
                        <input type="text" id="recap" name="recap" class="form-control" value="{{$requsition_product->recap}}" readonly required>
                    </div>
                </div>
            </div>
            </form>
            <hr class="my-4">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-gdp">
                        <div class="card-header ogn-stock-yellow  text-left" >
                            <h6 class="m-0"> รายการสินค้า </h6>
                        </div>
                        <div class="card-body p-0">
                            <table id="requsition_product_current" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                                <caption style="display: none"></caption>
                                <thead class="">
                                    <tr>
                                        <th scope="col" class="w-auto">#</th>
                                        <th scope="col" class="w-auto">ล็อต</th>
                                        <th scope="col" class="w-auto">รายการสินค้า</th>
                                        <th scope="col" class="w-auto">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody id="rowbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> {{-- cardbody --}}
    </div>

    <div id="history">
    </div>

@endsection

@section('js')
<script>
    $(function() {
        let id = $('#id').val()
        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.product.history')}}",
            data: {
                'id': id
            },
            dataType: "json",
            success: function(response) {
                var trans_type = '';
                var recaptext = '';
                var row = '';
                var row2 = '';
                // var rowbody = '#rowbody';
                let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',timeStyle: 'long' };
                options.timeZone = 'UTC';
                options.timeZoneName = 'short';
                response.aaData.forEach((element, index) => {
                    if (element.transport_type==1) {
                        trans_type = `<input type="text" id="transfer_type" class="form-control"  value="บริษัทเป็นผู้ส่ง"  readonly>`
                    }
                    if(element.transport_type==2){
                        trans_type = `<input type="text" id="transfer_type" class="form-control"  value="ลูกค้ามารับเอง"  readonly>`
                    }
                    if(element.transport_type==3){
                        trans_type = `<input type="text" id="transfer_type" class="form-control"  value="ส่งผ่านบริษัทขนส่ง"  readonly>`
                    }
                    if (!element.recap) {
                        recaptext = ``
                    }else{
                        recaptext = element.recap
                    }
                    date = new Date(element.updated_at)
                    row +=

                        `
                    <div class="card " id="card-history">
                        <div class="card-header border-transparent bg-gradient-gray">
                            <h3 class="card-title header-card">รายการแก้ไขครั้งที่ ${element.edit_times} | ${new Intl.DateTimeFormat('th-TH', { dateStyle: 'full', timeStyle: 'short' }).format(date)}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: block;">

                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                    <label for="" class="form-label">หมายเลขเอกสาร</label>
                                    <input type="text" id="paper_no" class="form-control"  value="${element.paper_no}"  readonly>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                    <label for="" class="form-label">วันที่ส่งออก</label>
                                    <input type="text" id="date" name="date" value="${new Date(element.date).toLocaleString('th-TH')}" class="form-control" readonly>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                    <label for="" class="form-label">ประเภทการส่ง</label> <br>
                                    ${trans_type}
                                </div>
                            </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6>รายละเอียดการจัดส่ง</h6>
                                        </div>
                                        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 mt-2">
                                            <label for="" class="form-label">ชื่อ-นามสกุล</label>
                                            <input type="text" id="cus_name" name="cus_name" class="form-control" value="${element.receive_name}" readonly required>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                            <label for="" class="form-label">เบอร์โทร</label>
                                            <input type="text" id="tel" name="tel" class="form-control" value="${element.receive_tel}" readonly required>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                            <label for="" class="form-label">ทะเบียนรถ</label>
                                            <input type="text" id="vehicle" name="vehicle" class="form-control" value="${element.receive_vehicle}" readonly required>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                            <label for="" class="form-label">รายละเอียดที่อยู่</label>
                                            <input type="text" id="house_no" name="house_no" class="form-control" value="${element.receive_house_no}" readonly required>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                            <label for="" class="form-label">ตำบล</label>
                                            <input type="text" id="tumbol" name="tumbol" class="form-control" value="${element.receive_tumbol}" readonly required>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                            <label for="" class="form-label">อำเภอ</label>
                                            <input type="text" id="aumphur" name="aumphur" class="form-control" value="${element.receive_aumphur}" readonly required>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                            <label for="" class="form-label">จังหวัด</label>
                                            <input type="text" id="province" name="province" class="form-control" value="${element.receive_province}" readonly required>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                                            <label for="" class="form-label">รหัสไปรษณีย์</label>
                                            <input type="text" id="postcode" name="postcode" class="form-control" value="${element.receive_postcode}" readonly required>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                                            <label for="" class="form-label">หมายเหตุ</label>
                                            <input type="text" id="recap" name="recap" class="form-control" value="${recaptext}" readonly required>
                                        </div>
                                    </div>
                                </div>

                            <hr class="my-4">

                            <div class="row">

                                <div class="col-12">

                                    <div class="card card-outline card-gdp">
                                        <div class="card-header ogn-stock-yellow text-left ">
                                            <h6 class="m-0"> รายการสินค้า </h6>
                                        </div>

                                        <div class="card-body p-0">

                                            <table id="requsition_product_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                                                <caption style="display: none"></caption>
                                                <thead class="">
                                                    <tr>
                                                        <th scope="col" class="w-auto">#</th>
                                                        <th scope="col" class="w-auto">Lot</th>
                                                        <th scope="col" class="w-auto">รายการ</th>
                                                        <th scope="col" class="w-auto">จำนวน</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="rowbody${index}">
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>


                                </div>
                            </div>

                        </div>



                    </div>
                `


                $('#history').html(row)

                });

                response.aaData.forEach((element,index)=>{
                    row2 = ''
                        console.log(element)
                    element.historyproductcut.forEach((value,index2)=>{
                        // var id = element.id
                        if (element.id === value.history_requsition_product_id) {
                            row2+=
                            `
                            <tr>
                                <td>${++index2}</td>
                                <td>${value.product_lot.lot}</td>
                                <td>${value.product_lot.product.name}</td>
                                <td class="">${value.qty} ${value.product_lot.unit.name}</td>
                            </tr>
                            `

                        } else {

                        }

                        $('#rowbody'+index).html(row2)

                    })
                })

            }
        });

        var product = []

        $('.dropify').dropify();
        let requsition_product_table = $('#requsition_product_table').DataTable({
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
                    targets: [4, 5]

                }
            ],
            "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">'
        });

        $('.select2').select2()

        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.product.cut.lot')}}",
            data: {"id":id},
            dataType: "json",
            success: function (response) {
                var row = '';
                dataOld = response;
                response.forEach((element,index) => {
                    row +=
                `<tr class="productrowold">
                    <td>${++index}</td>
                    <td>${element.product_lot.lot}</span></td>
                    <td>${element.product_lot.product.name}</td>
                    <td><span class="pro_qty">${element.qty}</span> ชิ้น</td>
                </tr>`

                });

                $('#rowbody').html(row);

                requsition_productcurrent = $('#requsition_productcurrent').DataTable({
                    "paging": false,
                    "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">',
                    "info": false,
                    "pageLength": 100,
                });

            }
        });
    });
</script>
@endsection
