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
                <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('requsition.packaging') }}">รายการเบิกบรรจุภัณฑ์</a></li>
                <li class="breadcrumb-item active">ประวัติการแก้ไข</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<input type="hidden" name="id" id="id" value="{{$requsition_packaging_id}}">
<div class="card">
    <div class="card-header ogn-stock-yellow text-left ">
        <h3 class="card-title header-card">รายการปัจจุบัน</h3>
    </div>
    <div class="card-body">
    <form action="" id="receive_valid">
    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">หมายเลขเอกสาร</label>
            <input type="text" id="paper_no" class="form-control" value="{{$requsition_packaging->paper_no}}" required readonly>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">ชื่อสินค้าที่ผลิต</label>
            <input type="text" name="product_name" id="product_name" class="form-control" value="{{$requsition_packaging->product_name}}" required readonly>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">วันที่เบิก</label>
            <input type="text" id="date" name="date" value="{{$requsition_packaging->date}}" class="form-control" required readonly>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">หมายเหตุ</label>
            <input type="text" id="recap" name="recap"  class="form-control" value="{{$requsition_packaging->recap}}" required readonly >
        </div>

    </div>
</form>
<hr class="my-4">

<div class="row">

    <div class="col-12">

        <div class="card card-outline card-gdp">
            <div class="card-header  " >
                    <h6 class="m-0"> รายการบรรจุภัณฑ์ </h6>
                </div>

            <div class="card-body p-0">

                <table id="requsition_packaging_table_current" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="">
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">หมายเลขล็อตบรรจุภัณฑ์</th>
                            <th scope="col" class="w-auto">บรรจุภัณฑ์</th>
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
            url: "{{route('api.v1.requsition.packaging.cut.lot')}}",
            data: {"id":id},
            dataType: "json",
            success: function (response) {
                var row = '';
                dataOld = response;
                response.forEach((element, index) => {
                    var qty = parseFloat(element.qty)  ;
                    row +=
                `<tr class="packagingrowold list_packaging">
                    <td>${++index}</td>
                    <td><span class="pack_lot_id mat_hide ">${element.packaging_lot.id}</span>${element.packaging_lot.lot}</span></td>
                    <td><span class="pack_id mat_hide ">${element.packaging_lot.packaging.id}</span>${element.packaging_lot.packaging.name}</td>
                    <td><span class="pack_qty  ">${qty}</span> ชิ้น</td>
                </tr>`

                });

                $('#rowbody').html(row);

                requsition_packaging_table_current = $('#requsition_packaging_table_current').DataTable({
                    "paging": false,
                    "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">',
                    "info": false,
                    "pageLength": 100,
                });

            }
        });

        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.packaging.history')}}",
            data: {
                'id': id
            },
            dataType: "json",
            success: function(response) {
                // console.log(response.aaData)
                var row = '';
                var row2 = '';
                // var rowbody = '#rowbody';
                let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',timeStyle: 'long' };
                options.timeZone = 'UTC';
                options.timeZoneName = 'short';
                response.forEach((element, index) => {
                    date = new Date(element.created_at)
                    row +=

                        `
                    <div class="card " id="card-history">
                        <div class="card-header border-transparent bg-gradient-gray">
                            <h3 class="card-title header-card">รายการแก้ไขครั้งที่ ${element.edit_times}  ${new Intl.DateTimeFormat('th-TH', { dateStyle: 'full', timeStyle: 'short' }).format(date)}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: block;">

                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                    <label for="" class="form-label">หมายเลขเอกสาร</label>
                                    <input type="text" id="paper_no" class="form-control" value="${element.paper_no}" required readonly>


                                    <small id="checkpaper_no"></small>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                    <label for="" class="form-label">ชื่อสินค้าที่ผลิต</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" value="${element.product_name}" required readonly>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                    <label for="" class="form-label">วันที่เบิก</label>
                                    <input type="text" id="text" value="${new Date(element.date).toLocaleString('th-TH')}" class="form-control" readonly>
                                    <small id="checktext"></small>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                    <label for="" class="form-label">หมายเหตุ</label>
                                    <input type="text" id="text" value="${element.recap}" class="form-control" readonly>
                                    <small id="checktext"></small>
                                </div>

                            </div>

                            <hr class="my-4">

                            <div class="row">

                                <div class="col-12">

                                    <div class="card card-outline card-gdp">
                                        <div class="card-header ogn-stock-yellow text-left ">
                                            <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รายการเบิกบรรจุภัณฑ์ </h6>
                                        </div>

                                        <div class="card-body p-0">

                                            <table id="receive_packaging_history_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                                                <caption style="display: none"></caption>
                                                <thead class="">
                                                    <tr>
                                                    <th scope="col" class="w-auto">#</th>
                                                    <th scope="col" class="w-auto">หมายเลขล็อตบรรจุภัณฑ์</th>
                                                    <th scope="col" class="w-auto">บรรจุภัณฑ์</th>
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

                response.forEach((element,index)=>{
                    // console.log()
                    row2 = ''
                    element.historypackagingcutreturn.forEach((value,index2)=>{
                        // var id = element.id
                        // console.log('id' , element.id,'lot',value.history_requsition_material_id)
                        if (element.id === value.history_requsition_packaging_id) {


                            total_qty = parseFloat(value.qty);
                            let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                            let total = formatter.format(total_qty);
                            row2+=
                            `
                            <tr>
                            <td>${++index2}</td>
                            <td>${value.packaging_lot.lot}</td>
                            <td>${value.packaging_lot.packaging.name}</td>
                            <td>${total} ชิ้น</td>
                            </tr>
                            `

                        } else {

                        }

                        $('#rowbody'+index).html(row2)

                    })
                })

            }
        });

        var material = []

        $('.dropify').dropify();
        let receive_packaging_history_table = $('#receive_packaging_history_table').DataTable({
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



    });
</script>
@endsection
