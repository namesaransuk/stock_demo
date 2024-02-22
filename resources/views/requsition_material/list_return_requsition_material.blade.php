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
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>

                <li class="breadcrumb-item active">คืนวัตถุดิบ</li>
            </ol>
        </div><!-- /.col -->
        <div >
            <br>
            <!-- <a class="btn ogn-stock-yellow " href="{{route('requsition.material.create')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มรายการ</a> -->
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

                <table id="requsition_material_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                    <caption style="display: none"></caption>
                    <thead class="ogn-stock-yellow" >
                        <tr>
                            <th scope="col" class="w-auto">#</th>
                            <th scope="col" class="w-auto">วันที่เบิก</th>
                            <th scope="col" class="w-auto">หมายเลขเอกสาร</th>
                            <th scope="col" class="w-auto">ชื่อสินค้า</th>
                            <!-- <th scope="col" class="w-auto">แก้ไขครั้งที่เท่าไร</th> -->
                            <th scope="col" class="w-auto">รายละเอียด</th>
                            <th scope="col" class="w-auto">จัดการ</th>

                            <!-- <th scope="col" class="w-auto " style="text-align: center !important;">จัดการ</th> -->
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

        let requsition_material_table =$('#requsition_material_table').DataTable({
            "pageLength": 10,
                "responsive": true,
                // "order": [4, "desc"],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'{{route(('api.v1.requsition.material.return.list'))}}',
                    'data':{
                        company_id: {{session('company')}},
                    }
                },
                'columns': [
                    { data: 'id' },
                    { data: 'date' },
                    { data: 'paper_no' },
                    { data: 'product_name' },
                    // { data: 'edit_times' , class: 'text-center'},

                    {
                        "data":           null,
                        render : function(data, type, row, meta){
                            return `<div style="text-align:center;"><a href="#"  class="details-control text-lg text-ogn-green fas fa-list-alt  " ></a></div>`;
                        }
                    },

                    { data: 'id', class: ' p-1',
                    render : function(data,type,row,meta){
                        let url2 = "{{ route('requsition.material.return.create', "__id") }}".replaceAll("__id",row.id);
                        // let url3 = "{{ route('requsition.material.history', "__id") }}".replaceAll("__id",row.id);
                            // console.log(row.material_cut_returns.action)
                            action = `<a type="" style="" href="${url2}"  data-id="${row.id}" id="myModal-edit"  class=" reset-me btn-modal btn " data-toggle="tooltip" data-placement="top" title="เพิ่มการคืนวัตถุดิบ" ><i class="fas fa-share text-warning p-1"></i> คืนวัตถุดิบ</a>`;
                            action2 = `<a style=""  id="myModal-edit" data-id="${row.id}"  class= "btn-nextstep disabled btn-update-inspect_ready btn" data-toggle="tooltip" data-placement="top" title="ส่งต่อเพื่อตรวจสอบ" disabled><i class="fas fa-arrow-circle-right p-1 text-success"></i> ส่งไปตรวจสอบ</a>`;
                            row.material_cut_returns.forEach(element => {
                                if(element.action != 1){
                                    action = `<a type="" style=""  data-id="${row.id}" id="myModal-edit"  class=" reset-me btn-modal disabled btn " data-toggle="tooltip" data-placement="top" title="เพิ่มการคืนวัตถุดิบ" disabled ><i class="fas fa-share text-gray p-1"></i> คืนวัตถุดิบ</a>`;
                                    action2 = `<a style=""  id="myModal-edit" data-id="${row.id}"  class= "btn-nextstep btn-update-inspect_ready btn" data-toggle="tooltip" data-placement="top" title="ส่งต่อเพื่อตรวจสอบ" ><i class="fas fa-arrow-circle-right p-1 text-success"></i> ส่งไปตรวจสอบ</a>`;
                                }
                            });


                        return `
                        ${action}
                        ${action2}
                        `
                    }
                    },

                ],
                columnDefs: [
                    // { responsivePriority: 1, targets: 4 },
                    { responsivePriority: 1, targets: [0,1,2] }
                ],

                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
        })


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
                    //ส่วนแสดงตารางรายละเอียด
            function format ( receive ) {
                // console.log(receive.material_lots)
                var receiveMaterials = receive.materialCutReturns;
                var lot;
                var name_material;
                var total_weight;
                var coa;
                var exp;
                var mfg;
                var action;
                var loop_table;
                var table_body = "";
                var table;

                receiveMaterials.forEach(receive_item => {

                    lot = receive_item.material_lot.lot_no_pm;
                    name_material = receive_item.material_lot.material.name;
                    let formatter = new Intl.NumberFormat('th-TH', {currency: 'THB' });


                    total_weight_obj = convert2Unit(receive_item.weight)

                    total_weight_r = 0;
                    use_weight = 0;
                    total_weight_r_obj = {"weight":0, "unit":""};
                    use_weight_obj = {"weight":0, "unit":""};;
                    let total_r = "-";
                    let use_r = "-";
                    if (receive_item.weight_r >= 0) {
                        total_weight_r_obj = convert2Unit(receive_item.weight_r);
                        use_weight_obj = convert2Unit(receive_item.weight - receive_item.weight_r);
                    }



                    ref = "{{asset('uploads/coa_material/')}}";
                    action = receive_item.action
                    return_material = receive.action

                    if (action == 1) {
                       action = "<td style='text-align:center;'> <span class='badge badge-pill ogn-stock-grey' style='text-align : center;'>รออนุมัติ</span> </td>"
                    } else {
                        action = "<td style='text-align:center;'> <span class='badge badge-pill ogn-stock-green' style='text-align : center;'>อนุมัติการเบิก</span> </td>"
                    }

                    if (return_material == 2) {
                       return_material = `<td style='text-align:center;'><a type="button" style="" data-id="${receive_item.id}" class="btn btn-secondary btn-sm add-lot-pm open-sweet"><i class="fas fa-edit"></i> </a> </td>`
                    } else {
                        return_material = `<td style='text-align:center;'><a type="button" style="" data-id="${receive_item.id}" class=" open-sweet" ><i class="fas fa-edit text-warning"></i> </a> </td>`
                    }


                    //loop table

                    loop_table =    '<tr>'+

                                        '<td>'+lot+'</td>'+
                                        '<td>'+name_material+'</td>'+
                                        '<td class="text-right">'+formatter.format(total_weight_obj.weight)+' '+total_weight_obj.unit+'</td>'+
                                        '<td class="text-right">'+formatter.format(use_weight_obj.weight)+' '+use_weight_obj.unit+'</td>'+
                                        '<td class="text-right">'+formatter.format(total_weight_r_obj.weight)+' '+total_weight_r_obj.unit+'</td>'+

                                    '</tr>';
                    table_body += loop_table;
                });

                var inner_table = `<table class="w-100">
                    <tr>
                        <th style='width:20%'>ล็อตสินค้า</th>
                        <th style='width:18%'>ชื่อวัตถุดิบ</th>
                        <th style='width:10%' class="text-right">เบิก</th>
                        <th style='width:10%' class="text-right">ใช้จริง</th>
                        <th style='width:10%' class="text-right">คืน</th>

                    </tr>
                    ${table_body}
                </table>`;
                table =  '<table cellpadding="5" class="w-100" cellspacing="0" border="0" style="padding-left:50px;"> <caption class="text-center text-dark text-bold pt-0">รายละเอียดเบิกวัตถุดิบ</caption>'+inner_table+'</table> ';

                return table;
            }

            $('#requsition_material_table tbody').on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = requsition_material_table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    row.child().addClass('bg-gradient-light')
                    tr.addClass('shown');
                }
            } );



            $(document).on('click','.open-sweet',function(){

                const id = $(this).data('id');
                var formData = new FormData();

                console.log(id);
                let in_html = `
                                <div class="row">
                                    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 mb-2">

                                    <input type="number" class="form-control" name="weight" id="weight" placeholder="จำนวน" >
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2" >

                                            <select name=""  id="type_weight" class="form-control">
                                                <option value="1">กรัม</option>
                                                <option value="2">กิโลกรัม</option>
                                                <option value="3">ตัน</option>
                                            </select>
                                    </div>
                                </div> `
                Swal.fire({
                    title: "จำนวนที่ต้องการคืน",
                    html : in_html,
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ปิด',
                    confirmButtonColor: '#649514',
                    cancelButtonColor: '#a97551',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var    weight= $('#weight').val();
                        var    type_weight = $('#type_weight').val()

                        var total_weight = 0 ;

                            if (type_weight === "1") {
                                total_weight = weight
                            } else if (type_weight === "2"){
                                total_weight = weight * 1000 ;
                            } else {
                                total_weight = weight * 1000000 ;
                            }
                        formData.append("id", id);
                        formData.append("weight", total_weight);
                        formData.append("_token", $('#_token').val());
                        console.log(JSON.stringify(formData))
                        $.ajax({
                            type: "post",
                            url: "{{route('api.v1.requsition.material.return.create')}}",
                            data: formData,
                            contentType: false,
                            processData: false,
                            cache: false,
                            success: function (response) {
                                if (response) {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'success',
                                        title: 'เพิ่มจำนวนที่ต้องการคืนสำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500,

                                    })
                                    receive_material_table.ajax.reload();
                                } else {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'warning',
                                        title: 'เพิ่มจำนวนที่ต้องการคืนไม่สำเร็จ',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click','.btn-nextstep',function(){
                const id = $(this).data('id');
                Swal.fire({
                        title: 'ยืนยันการส่งไปตรวจสอบ?',
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
                                url: "{{route('api.v1.requsition.material.step.to.inspect.return')}}",
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
                                        requsition_material_table.ajax.reload();
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
            })

    });
</script>
@endsection
