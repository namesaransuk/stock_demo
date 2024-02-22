@extends('adminlte::page')

@section('css')
<style>
    .modal-full {
        min-width: 65%;
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
                <li class="breadcrumb-item active"><a href="{{ route('requsition.material.return') }}">คืนวัตถุดิบ</a></li>
                <li class="breadcrumb-item active">เพิ่มการคืนวัตถุดิบ</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')

<div class="card">
    <div class="card-header bg-white ">
        รายการวัตถุดิบ
    </div>
    <div class="card-body">
    <form action="" id="requsition_valid">
    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
            <label for="" class="form-label">หมายเลขเอกสาร</label>
            <input type="text" id="paper_no" class="form-control" value="{{$requsition_material->paper_no}}" required readonly>
            <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
            <input type="hidden" name="id" id="id" value="{{$requsition_material_id}}">
            <input type="hidden" name="edit_times" id="edit_times" value="{{$requsition_material->edit_times}}">
            <input type="hidden" name="history_flag" id="history_flag" value="{{$requsition_material->history_flag}}">
            <input type="hidden" name="created_by" id="created_by" value="{{$requsition_material->created_by}}">
            <input type="hidden" name="updated_by" id="updated_by" value="{{$requsition_material->updated_by}}">
            <input type="hidden" name="production_user_id" id="production_user_id" value="{{$requsition_material->production_user_id}}">
            <input type="hidden" name="procurement_user_id" id="procurement_user_id" value="{{$requsition_material->procurement_user_id}}">
            <input type="hidden" name="stock_user_id" id="stock_user_id" value="{{$requsition_material->stock_user_id}}">
            <input type="hidden" name="recap_old" id="recap_old" value="{{$requsition_material->recap}}">
            <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">


            <small id="checkpaper_no"></small>
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

    </div>
</form>
<hr class="my-4">

<div class="row">

    <div class="col-12">

        <div class="card card-outline card-gdp">
            <div class="card-header ">
                    <h6 class="m-0"> รายการวัตถุดิบ </h6>
                </div>

            <div class="card-body p-0">

                <table id="requsition_material" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="">
                        <tr>
                            <th scope="col" class="w-auto text-center">#</th>
                            <th scope="col" class="w-25">หมายเลขล็อต</th>
                            <th scope="col" class="w-25">วัตถุดิบ</th>
                            <th scope="col" class="w-auto">เบิก</th>
                            <th scope="col" class="w-auto">ใช้จริง</th>
                            <th scope="col" class="w-auto">คืน</th>

                        </tr>
                    </thead>
                    <tbody id="rowbody">
                    </tbody>
                </table>

            </div>

        </div>
        <div style="text-align: right;">
            <button class="btn ogn-stock-grey text-black btn-back"><em class="fas fa-arrow-left"></em> ย้อนกลับ</button>
            <button class="btn ogn-stock-green text-white" id="create_requsition_material2"><em class="fas fa-save"></em> คืนวัตถุดิบ</button>
        </div>
    </div>
</div>

    </div> {{-- cardbody --}}
</div>




@endsection

@section('js')
<script>
    $(function() {
        let id = $('#id').val()
        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.material.cut.lot')}}",
            data: {"id":id},
            dataType: "json",
            success: function (response) {
                console.log(response)
                var row = '';
                var numrow = 0;
                dataOld = response;
                response.forEach(element => {

                    numrow++
                    var total_weight = parseFloat(element.weight);
                    let wunit = "กรัม";
                    if (element.weight >= 1000000) {
                        total_weight = parseFloat(element.weight/1000000) ;
                        wunit = "ตัน";
                    } else if (element.weight >= 1000) {
                        total_weight = parseFloat(element.weight/1000) ;
                        wunit = "กิโลกรัม";
                    }

                    row +=
                `<tr class="materialrowold">
                <td class="text-center">${numrow}</td>
                <td><span class="mat_lot_id mat_hide ">${element.material_lot.id}</span>${element.material_lot.lot_no_pm}</span></td>
                <td><span class="mat_id mat_hide ">${element.material_lot.material.id}</span>${element.material_lot.material.name}</td>
                <td class="text-center"><input type="hidden" class="form-control total_weight" readonly value="${element.weight}"> ${total_weight} ${wunit}</td>
                <td>
                    <input type="text" id="total_weight" name="total_weight" class="form-control use_weight" value="${total_weight}" min="0" max="${total_weight}" required>
                    <select class="return_unit">
                        <option value="1">กรัม</option>
                        <option value="1000">กิโลกรัม</option>
                        <option value="1000000">ตัน</option>
                    </select>
                </td>
                <td>
                    <input type="hidden" readonly class="form-control return_weight" value="0" >
                    <span class="return_string">0</span>
                </td>
                </tr>`

                });

                $('#rowbody').html(row);

                requsition_material = $('#requsition_material').DataTable({
                    "paging": false,
                    "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">',
                    "info": false,
                    "pageLength": 100,
                });

            }
        });



        $('#material_id').on('change',function () {

            var material_id = $('#material_id').val()

            $.ajax({
                type: "post",
                url: "{{route('api.v1.requsition.list.material.lot')}}",
                data: {'material_id': material_id },
                dataType: "json",
                success: function (response) {
                    console.log(response)
                    var weighttotal;
                    $('#material_lot_id').find('option').remove().end()
                        response.material_lots.forEach(element => {


                            total_weight = parseFloat(element.weight_total / 1000);
                            let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });
                            let total = formatter.format(total_weight);

                            $('#material_lot_id').append('<option value=' + element
                                .id + '>' + element.lot + ' : จำนวน ' + total + ' kg.' + '</option>');
                        });
                }
            });

         });
    var material = []

        $('.dropify').dropify();

        $('.add-to-table2').on('click', function(){

            if ($('#form_valid').valid()) {

            var    material_id= $('#material_id').val();
            var    material_name= $('#material_id option:selected').text();
            var    material_lot_name= $('#material_lot_id option:selected').text();
            var    material_lot_id= $('#material_lot_id').val();
            var    weight= $('#weight').val();
            var    type_weight = $('#type_weight').val()
            console.log(type_weight)
            var    date= $('#date_requsition').val();
            var total_weight = 0 ;
            var text_weight = "";
                if (type_weight === "1") {
                    total_weight = weight
                    text_weight = "กรัม";
                } else if (type_weight === "2"){
                    total_weight = weight * 1000 ;
                    text_weight = "กิโลกรัม";
                } else {
                    total_weight = weight * 1000000 ;
                    text_weight = "ตัน";
                }


            var index = requsition_material.rows().count();

            var row = requsition_material.row.add([
                '<td><a class="list_cancel"><i class="fas fa-times text-red"></i></a></td>',
                '<td><span class="mat_lot_id mat_hide ">'+material_lot_id +'</span>'+material_lot_name+'</span></td>',
                '<td><span class="mat_id mat_hide ">'+material_id  +'</span>'+material_name+'</td>',
                '<td><span class="mat_weight mat_hide ">'+total_weight +'</span>'+weight+' '+text_weight+' </td>',
                '<td><span class="mat_date ">'+date +'</span></td>',

            ]).draw(false).nodes()
            .to$()
            .addClass( 'materialrow' )
            $(".clear-modal").click();
            }

        })

        $(document).on('keyup, change, blur','.use_weight', function(){
            let obj = $(this);
            let tr = obj.closest('tr');
            let tt_w = tr.find('.total_weight').val();
            let multiply = parseFloat(tr.find('.return_unit').val());
            let use_weight = parseFloat(obj.val());
            let return_val = parseFloat(tt_w)-(use_weight*multiply)
            let return_obj = convert2Unit(return_val);
            tr.find('.return_weight').val(return_val);
            tr.find('.return_string').text(`${return_obj.weight} ${return_obj.unit}`);
        })

        $(document).on('change','.return_unit',function(){
            let obj = $(this)
            let multiply = parseFloat(obj.val());
            let tr_row = obj.closest('tr');
            let use_weight = parseFloat(tr_row.find('.use_weight').val());
            let total_weight = parseFloat(tr_row.find('.total_weight').val());
            let return_val = total_weight-(use_weight*multiply);
            let return_obj = convert2Unit(return_val);
            tr_row.find('.return_weight').val(return_val);
            tr_row.find('.return_string').text(`${return_obj.weight} ${return_obj.unit}`);
        });


        function convert2Unit(weight){
            var total_weight = parseFloat(weight);
            let wunit = "กรัม";
            if (weight >= 1000000) {
                total_weight = parseFloat(weight/1000000) ;
                wunit = "ตัน";
            } else if (weight >= 1000) {
                total_weight = parseFloat(weight/1000) ;
                wunit = "กิโลกรัม";
            }
            return {"weight":total_weight, "unit":wunit}
        }

        // $(document).bind('mouseup','.use_weight',function() {
        //     $(".use_weight").trigger('blur');
        // })

        $(".clear-modal").on('click', function() {
            $(".dropify-clear").click();

            $('#material_name').val(""),
                $('#company_name').val(""),

                $('#lot').val(""),
                $('#tons').val("0"),
                $('#kg').val("0"),
                $('#grams').val("0"),
                $('#exp').val(""),
                $('#mfg').val(""),


                $("#myModal").modal("hide");
        });

        $('#requsition_material tbody').on('click', '.list_cancel', function() {
            var index = requsition_material.row($(this).parents('tr'));
            var rowindex = index.index();
            requsition_material
                .row($(this).parents('tr'))
                .remove()
                .draw();
            material.splice(rowindex, 1);

        });
        $('#create_requsition_material2').on('click', function() {

            if ($('#requsition_valid').valid()) {
            var numrow = 0;
            var numrowold = 0;
            var formdata_requsition = new FormData();
            // formdata_requsition.append('username', 'Chris');
            formdata_requsition.append('paper_no', $('#paper_no').val());
            formdata_requsition.append('product_name', $('#product_name').val());
            formdata_requsition.append('edit_times', $('#edit_times').val());
            formdata_requsition.append('date', $('#date').val());
            formdata_requsition.append('_token', $('#_token').val());
            formdata_requsition.append('id', $('#id').val());
            formdata_requsition.append('history_flag', $('#history_flag').val());
            formdata_requsition.append('created_by', $('#created_by').val());
            formdata_requsition.append('updated_by', $('#updated_by').val());
            formdata_requsition.append('production_user_id', $('#production_user_id').val());
            formdata_requsition.append('procurement_user_id', $('#procurement_user_id').val());
            formdata_requsition.append('stock_user_id', $('#stock_user_id').val());
            formdata_requsition.append('recap', $('#recap').val());
            formdata_requsition.append('recap_old', $('#recap_old').val());
            formdata_requsition.append('user_id', $('#user_id').val());
            formdata_requsition.append('company_id', {{session('company')}});


            $('.materialrowold').each(function(index,value){
                var total_weight = $(value).find('.return_weight').val() ;
                console.log(total_weight)
                formdata_requsition.append('materialold['+index+'][material_lot_id]',$(value).find('.mat_lot_id').text())
                formdata_requsition.append('materialold['+index+'][material_id]',$(value).find('.mat_id').text())
                formdata_requsition.append('materialold['+index+'][weight]',$(value).find('.mat_weight').text())
                formdata_requsition.append('materialold['+index+'][date]',$(value).find('.mat_date').text())
                formdata_requsition.append('materialold['+index+'][date]',$(value).find('.mat_date').text())
                formdata_requsition.append('materialold['+index+'][total_weight]',total_weight)
                numrowold++
            })



            var rows_material = requsition_material.rows().count();
            // console.log(index)

                    Swal.fire({
                                title: 'ยืนยันการคืนวัตถุดิบ?',
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
                                        url: "{{route('api.v1.requsition.material.return.create')}}",
                                        data: formdata_requsition,
                                        contentType: false,
                                        processData: false,
                                        cache: false,
                                        // dataType: "dataType",
                                        success: function (response) {
                                            if (response) {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'success',
                                                    title: 'เพิ่มรายการคืนวัตถุดิบสำเร็จ',
                                                    showConfirmButton: false,
                                                    timer: 1500,

                                                })
                                                window.location.assign("{{ route('requsition.material.return') }}")
                                            } else {
                                                Swal.fire({
                                                    position: 'center-center',
                                                    icon: 'warning',
                                                    title: 'เพิ่มรายการคืนวัตถุดิบไม่สำเร็จ',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                })
                                            }
                                        }
                                    });
                                }
                            });


            }

        })
        $('.btn-back').on('click',function(){
            window.history.back();
        });

    });

    $(document).ready(function(){
        var material_id = $('#material_id').val()




    })
</script>
@endsection
