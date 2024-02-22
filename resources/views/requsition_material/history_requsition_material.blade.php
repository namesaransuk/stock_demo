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
                <li class="breadcrumb-item active"><a href="{{ route('requsition.material') }}">รายการเบิกวัตถุดิบ</a></li>
                <li class="breadcrumb-item active">ประวัติการแก้ไข</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<input type="hidden" name="id" id="id" value="{{$requsition_material_id}}">
<div class="card">
    <div class="card-header ogn-stock-green ">
        <h3 class="card-title header-card">รายการปัจจุบัน</h3>
    </div>
    <div class="card-body">
        <form action="" id="receive_valid">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                    <label for="" class="form-label">หมายเลขเอกสาร</label>
                    <input type="text" id="paper_no" class="form-control" value="{{$requsition_material->paper_no}}" required readonly>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                    <label for="" class="form-label">ชื่อสินค้าที่ผลิต</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" value="{{$requsition_material->product_name}}" required readonly>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                    <label for="" class="form-label">วันที่เบิก</label>
                    <input type="text" id="date" name="date" value="{{$requsition_material->date}}" class="form-control" required readonly>
                    <small id="checkdate"></small>
                </div>
                <div class="col-12 mt-2 ">
                    <label for="" class="form-label">หมายเหตุ</label>
                    <input type="text" name="recap" id="recap" class="form-control" value="{{$requsition_material->recap}}" required readonly>
                </div>
            </div>
        </form>
        <hr class="my-4">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-gdp">
                    <div class="card-header ogn-stock-yellow text-left ">
                        <h6 class="m-0"> รายการเบิกวัตถุดิบ </h6>
                    </div>
                    <div class="card-body p-0">
                        <table id="requsition_material_current" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                            <caption style="display: none"></caption>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="w-auto">#</th>
                                    <th scope="col" class="w-auto">หมายเลขล็อตวัตถุดิบ</th>
                                    <th scope="col" class="w-auto">วัตถุดิบ</th>
                                    <th scope="col" class="w-auto">น้ำหนัก</th>
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
<div id="history">

</div>



@endsection

@section('js')
<script>
    $(function() {

        let id = $('#id').val()

        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.material.history')}}",
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
                                <div class="col-12 mt-2">
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
                                            <h6 class="m-0">รายการเบิกวัตถุดิบ </h6>
                                        </div>

                                        <div class="card-body p-0">

                                            <table id="receive_packaging_history_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                                                <caption style="display: none"></caption>
                                                <thead class="">
                                                    <tr>
                                                    <th scope="col" class="w-auto">#</th>
                                                    <th scope="col" class="w-auto">หมายเลขล็อตวัตถุดิบ</th>
                                                    <th scope="col" class="w-auto">วัตถุดิบ</th>
                                                    <th scope="col" class="w-auto">น้ำหนัก</th>
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
                    element.historymaterialcutreturn.forEach((value,index2)=>{
                        // var id = element.id
                        // console.log('id' , element.id,'lot',value.history_requsition_material_id)
                        if (element.id === value.history_requsition_material_id) {

                            var total_weight = value.weight / 1000 ;

                            row2+=
                            `
                            <tr>
                            <td>${++index2}</td>
                            <td>${value.material_lot.lot_no_pm}</td>
                            <td>${value.material_lot.material.name}</td>
                            <td>${total_weight} กิโลกรัม</td>
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

        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.material.cut.lot')}}",
            data: {"id":id},
            dataType: "json",
            success: function (response) {
                console.log(response)
                var row = '';
                dataOld = response;
                response.forEach((element,index) => {
                    console.log(element)
                    var total_weight = parseFloat(element.weight) / 1000 ;
                    row +=
                    `<tr class="materialrowold">
                        <td>${++index}</td>
                        <td><span class="mat_lot_id mat_hide ">${element.material_lot.id}</span>${element.material_lot.lot_no_pm}</span></td>
                        <td><span class="mat_id mat_hide ">${element.material_lot.material.id}</span>${element.material_lot.material.name}</td>
                        <td><span class="mat_weight mat_hide ">${element.weight}</span>${total_weight} กิโลกรัม</td>
                    </tr>`
                });

                $('#rowbody').html(row);

                requsition_material = $('#requsition_material_current').DataTable({
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
