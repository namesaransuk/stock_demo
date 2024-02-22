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

        .mat_hide,
        .ton_hide {
            display: none;
        }

        .error {
            color: red;
        }

        .autocomplete-suggestions {
            border: 1px solid #999;
            background: #FFF;
            overflow: auto;
        }

        .autocomplete-suggestion {
            padding: 7px
        }

        .autocomplete-selected {
            background-color: #007bff;
            color: rgb(255, 255, 255);
            padding: 7px
        }

        .autocomplete-group {
            padding: 7px;
        }

        .autocomplete-group strong {
            display: block;
            border-bottom: 1px solid #000;
        }
    </style>
@endsection

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('stock') }}">รับเข้าวัตถุดิบ</a></li>
                    <li class="breadcrumb-item active">เพิ่มรายการนำเข้า</li>
                </ol>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

@stop

@section('content')
    <div class="card">
        <div class="card-header ogn-stock-green ">
            เพิ่มรายการนำเข้าวัตถุดิบ
        </div>
        <div class="card-body">
            <form action="" id="receive_valid">
                <div class="row">
                    <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                    {{-- <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 ">
                        <label for="" class="form-label">หมายเลขเอกสาร</label>
                        <input type="text" id="paper_no" class="form-control" required>
                        <small id="checkpaper_no"></small>
                    </div> --}}
                    <!-- <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                                                                                                             </div> -->
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 ">
                        <label for="" class="form-label">Supplier</label>
                        <select name="" id="brand_vendor_id" class="form-control select2">
                            @foreach ($vendors as $brand)
                                @if ($brand->type == 1)
                                    <option value="{{ $brand->id }}">{{ $brand->brand }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 mb-3">
                        <label for="" class="form-label">วันที่นำเข้า (ค.ศ.)</label>
                        <input type="datetime-local" id="date" name="date" class="form-control" required>
                        <small id="checkdate"></small>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                        <label for="" class="form-label">หมายเลขเอกสารบิลส่งของ</label>
                        <input type="text" id="bill_no" name="bill_no" class="form-control" required>
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 mb-3 ">
                        <label for="" class="form-label">บริษัทขนส่ง</label>
                        <select name="" id="logistic_vendor_id" class="form-control select2">
                            @foreach ($vendors as $brand)
                                @if ($brand->type == 2)
                                    <option value="{{ $brand->id }}">{{ $brand->brand }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                        <label for="" class="form-label">หมายเลข PO บริษัท</label>
                        <input type="text" id="po_no" name="po_no" class="form-control" required>
                        <small id="checkdate"></small>
                    </div>
                    {{-- <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                        <label for="" class="form-label">เอกสาร PO <span class="text-danger">(*เฉพาะไฟล์นามสกุล
                                jpg,png เท่านั้น)</span></label>
                        <input type="file" id="po_file" name="po_file" class="form-control" required>
                        <small id="checkdate"></small>
                    </div> --}}
                    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 mb-3">
                        <label for="" class="form-label">เอกสาร PO <span class="text-danger">(*เฉพาะไฟล์นามสกุล
                                jpg,png เท่านั้น)</span></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <label class="custom-file-label" id="custom-file-label" for="po_file">Choose file</label>
                                <input type="file" class="custom-file-input" id="po_file">
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card card-outline card-gdp">
                            <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                                <h6 class="m-0"> ตรวจสอบรถขนส่ง </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                        <label for="" class="form-label">ทะเบียนรถ</label>
                                        <input type="text" class="form-control" name="sender_vehicle_plate"
                                            id="sender_vehicle_plate" value="">
                                    </div>
                                    <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                        <input type="hidden" class="form-control" name="transport_old"
                                            id="transport_old">
                                        <label for="" class="form-label">รูปภาพ</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <label class="custom-file-label" id="custom-file-label-transport"
                                                    for="TransportPic_name">Choose
                                                    file</label>
                                                <input type="file" class="custom-file-input" name="TransportPic_name"
                                                    id="TransportPic_name" class="multifile" multiple>
                                            </div>
                                        </div>
                                        <p id="file_detail"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <hr class="my-4">

            <div class="row">

                <div class="col-12">

                    <div class="card card-outline card-gdp">
                        <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                            <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รับเข้าวัตถุดิบ </h6>
                        </div>
                        <div class="p-2">
                            <div class="float-right">
                                <input type="search" id="custom-search-input" class="form-control form-control-sm"
                                    placeholder="ค้นหา">
                            </div>
                            <a href="" type="button" style="" data-toggle="modal" data-target="#myModal"
                                class="btn rounded ml-2"><em class="fas fa-plus-circle text-success"></em>
                                เพิ่มรายการ</a>
                            <div class="card-title mb-0"></div>
                        </div>
                        <div class="card-body p-0">

                            <table id="receive_material_table" class="table w-100 "
                                style="margin-top: 0!important; margin-bottom: 0!important;">
                                <caption style="display: none"></caption>
                                <thead class="">
                                    <tr>
                                        <th scope="col" class="w-auto">#</th>
                                        <th scope="col" class="w-auto">รายการวัตถุดิบ</th>
                                        <th scope="col" class="w-auto">บริษัท</th>
                                        <th scope="col" class="w-auto">หมายเลข Lot</th>
                                        <th scope="col" class="w-auto">จำนวน ตัน</th>
                                        <th scope="col" class="w-auto">จำนวน กิโลกรัม</th>
                                        <th scope="col" class="w-auto">จำนวน กรัม</th>
                                        <th scope="col" class="w-auto">MFG.</th>
                                        <th scope="col" class="w-auto">EXP.</th>
                                        <th scope="col" class="w-auto">ใบ COA</th>
                                        <th scope="col" class="w-auto">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>

                    </div>
                    <div style="text-align: right;">
                        <button class="btn ogn-stock-grey text-black btn-back"><em class="fas fa-arrow-left"></em>
                            ย้อนกลับ</button>
                        <button class="btn ogn-stock-green text-white" id="create_receive_material2"><em
                                class="fas fa-save"></em> บันทึก</button>
                    </div>
                </div>
            </div>

        </div> {{-- cardbody --}}
    </div>


    <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-full">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #9BC56D;">
                    <h5 class="modal-title list_add" id="staticBackdropLabel" style="color: white;">เพิ่มรายการนำเข้า
                    </h5>
                    <button type="button" class="close clear-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_valid">
                        <!-- <div class="container"> -->
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 d-flex flex-column">
                                <label for="" class="form-label">ชื่อวัตถุดิบนำเข้า</label>

                                <select name="" id="receive_mat_name" class="form-control select2">
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->id }}">{{ $material->name }}</option>
                                    @endforeach
                                </select>

                                {{-- <input type="text" name="receive_mat_name" class="form-control receive_mat_name"
                                    id="receive_mat_name" required> --}}

                                <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                                <input type="hidden" name="id" id="id" value="">
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 ">
                                <label for="" class="form-label">บริษัท</label>
                                @php
                                    $current_company = session('company') ?: '';
                                @endphp
                                <select name="" id="company_id" class="form-control" disabled>
                                    @foreach ($companies as $company)
                                        <option {{ $current_company == $company->id ? 'selected' : '' }}
                                            value="{{ $company->company_id }}">{{ $company->company->name_th }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 ">
                                <label for="" class="form-label">หมายเลข ล็อต</label>
                                <input type="text" id="lot" name="lot" class="form-control" required>
                                <small id="checklot"></small>
                            </div>
                            {{-- <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                                <label for="" class="form-label">กำหนดหน่วยนับ</label>
                                <select name="" id="material_unit_id" class="form-control">
                                    @foreach ($materialUnit as $unit)
                                        <option value="{{ $unit->multiple }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                                <hr>
                            </div>

                            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
                                <label for="" class="form-label">จำนวน วัตถุดิบ</label>
                                <input type="number" id="weight_mat_unit" name="weight_mat_unit" class="form-control"
                                    value="0" required>
                            </div>
                            <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 mb-3 p-2 border">
                                <label for="" class="form-label">จำนวน หน่วย</label>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                        <select name="mat_unit_name" id="mat_unit_name" class="form-control">
                                            <option value="" selected disabled>เลือกหน่วย</option>
                                            @foreach ($materialUnit as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                        <input type="number" id="mat_unit_multiply" name="mat_unit_multiply"
                                            class="form-control" value="0" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                        <input type="text" id="mat_unit_unit" name="mat_unit_unit"
                                            class="form-control" value="" disabled required>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 ton_hide">
                                <label for="" class="form-label">จำนวน ตัน</label>
                                <input type="number" id="tons" name="tons" class="form-control" value="0"
                                    required>
                                <small id="checktons"></small>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                <label for="" class="form-label">จำนวน กิโลกรัม</label>
                                <input type="number" id="kg" name="kg" class="form-control" value="0"
                                    required>
                                <small id="checkkg"></small>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                                <label for="" class="form-label">จำนวน กรัม</label>
                                <input type="number" id="grams" class="form-control" value="0" required>
                                <small id="checkgrams"></small>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                                <hr>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="" class="form-label">MFG.</label>
                                        <input type="date" id="mfg" name="mfg" class="form-control"
                                            required>
                                        <small id="checkmfg"></small>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="" class="form-label">EXP.</label>
                                        <input type="date" id="exp" name="exp" class="form-control"
                                            required>
                                        <!-- <input type="datetime" name="" id=""> -->
                                        <small id="checkexp"></small>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 mb-3">
                                <label for="" class="form-label">ไฟล์ COA <span
                                        class="text-danger">(*เฉพาะไฟล์นามสกุล jpg,png เท่านั้น)</span></label>
                                <input type="file" id="coa" name="coa" class="dropify" data-height="100">

                                <small id="checkcoa"></small>
                            </div>




                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="margin-top: 10px;">
                    <button type="button" class="btn clear-modal ogn-stock-grey " style="color:black;"
                        data-dismiss="modal"><em class="fas fa-close"></em> ยกเลิก</button>
                    <button class="btn btn-save ogn-stock-green text-white add-to-table2" style=" color:black;"><em
                            class="fas fa-save"></em> เพิ่ม</button>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(function() {
            // $('#myModal').modal('show');

            $('#mat_unit_name').change(function() {
                let mat_unit_name = $('#mat_unit_name').val();

                $.ajax({
                    type: "post",
                    url: "{{ route('api.v1.material.unit.list.id') }}",
                    data: {
                        'mat_unit_id': mat_unit_name
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#mat_unit_multiply').val(response.multiply);
                        $('#mat_unit_unit').val(response.unit);

                        let weight_mat_unit = parseFloat($('#weight_mat_unit')
                            .val()); // แปลงเป็น float
                        let mat_unit_multiply = parseFloat($('#mat_unit_multiply')
                            .val()); // แปลงเป็น float
                        let mat_unit_unit = $('#mat_unit_unit').val();

                        if (!isNaN(weight_mat_unit) && !isNaN(
                                mat_unit_multiply)) { // ตรวจสอบว่าเป็นตัวเลขที่ถูกต้อง
                            let total = weight_mat_unit * mat_unit_multiply;

                            if (mat_unit_unit == 'กิโลกรัม') {
                                $('#kg').val(total);
                                $('#grams').val('0');
                            } else if (mat_unit_unit == 'กรัม') {
                                $('#kg').val('0');
                                $('#grams').val(total);
                            }
                        } else {
                            $('#kg').val('0');
                            $('#grams').val('0');
                        }
                    }
                });
            })

            $('#weight_mat_unit, #mat_unit_multiply').on('input', function() {
                let weight_mat_unit = parseFloat($('#weight_mat_unit').val());
                let mat_unit_multiply = parseFloat($('#mat_unit_multiply').val());
                let mat_unit_unit = $('#mat_unit_unit').val();

                if (!isNaN(weight_mat_unit) && !isNaN(
                        mat_unit_multiply)) {
                    let total = weight_mat_unit * mat_unit_multiply;

                    if (mat_unit_unit == 'กิโลกรัม') {
                        $('#kg').val(total);
                        $('#grams').val('0');
                    } else if (mat_unit_unit == 'กรัม') {
                        $('#kg').val('0');
                        $('#grams').val(total);
                    }
                } else {
                    $('#kg').val('0');
                    $('#grams').val('0');
                }
            });

            var options = {
                serviceUrl: "{{ route('api.v1.material.list.lot') }}",
                onSelect: function(suggestion) {},
                transformResult: function(response) {
                    return {
                        suggestions: $.map(JSON.parse(response), function(dataItem) {
                            return {
                                value: dataItem.lot,
                                data: dataItem.id
                            };
                        })
                    };
                }
            };
            $('#lot').autocomplete(options);


            $('#po_file').change(function(e) {
                let fileName = e.target.files[0].name;
                $('#custom-file-label').html(fileName);
            });

            $('#TransportPic_name').change(function(e) {
                let fileName = e.target.files[0].name;
                $('#custom-file-label-transport').html(fileName);
            });

            $('.select2').select2({
                width: "100%",
                // dropdownParent: $("#myModal")
            });

            var material = []

            $('.dropify').dropify();
            let receive_material_table = $('#receive_material_table').DataTable({
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
                        targets: [4, 5, 6]

                    }
                ],
                "dom": '<"top d-none">rt<"bottom d-flex position-absolute w-100 justify-content-between "ip><"clear">'
            });

            $('.add-to-table2').on('click', function() {

                if ($('#form_valid').valid()) {

                    var receive_mat_name = $('#receive_mat_name').val();
                    var receive_mat_name_detail = $('#receive_mat_name option:selected').text();
                    var company_name = $('#company_id option:selected').text();
                    var company_id = $('#company_id').val();
                    var lot = $('#lot').val();
                    var tons = $('#tons').val();
                    var kg = $('#kg').val();
                    var grams = $('#grams').val();
                    var exp = $('#exp').val();
                    var mfg = $('#mfg').val();
                    var coa = $('#coa').val();
                    var index = receive_material_table.rows().count();
                    var file_row = '<td><span class=" mat_coa mat_hide " data-check="0" id="field2_area' +
                        index +
                        '"></span><span class="badge bg-warning text-dark ">ยังไม่เพิ่มเอกสาร</span></td>';
                    if ($('#coa').val() != "") {
                        file_name = $('#coa').prop('files')[0].name;
                        file_row = '<td>' +
                            '<span class=" mat_coa mat_hide" data-check="1" id="field2_area' + index +
                            '"></span>' +
                            '<span class="badge badge-success  "><em class="fas fa-paperclip p-1"></em>' +
                            file_name + '</span></td>';
                    }

                    // check_duplicate_numberlot()
                    // status = check_duplicate_numberlot();
                    // status = true;
                    // if (status === "true") {
                    var coa_copy = $('#coa').clone();
                    coa_copy.attr('id', 'field' + index);
                    coa_copy.addClass('mat_coa mat_hide');
                    var row = receive_material_table.row.add([
                            '<td><a class="list_cancel" style="cursor: pointer;"><i class="fas fa-times text-red"></i></a></td>',
                            '<td><span class="mat_id mat_hide ">' + receive_mat_name + '</span>' +
                            receive_mat_name_detail + '</span></td>',
                            '<td><span class="mat_com_id mat_hide ">' + company_id + '</span>' +
                            company_name + '</td>',
                            '<td><span class="mat_lot ">' + lot + '</span></td>',
                            '<td><span class="mat_tons ">' + tons + '</span></td>',
                            '<td><span class="mat_kg ">' + kg + '</span></td>',
                            '<td><span class="mat_grams ">' + grams + '</span></td>',
                            '<td><span class="mat_mfg ">' + mfg + '</span></td>',
                            '<td><span class="mat_exp ">' + exp + '</span></td>',
                            file_row,
                            '<td><a data-toggle="tooltip" data-placement="top" title="แก้ไข" type="" style="cursor: pointer;"  id="open-edit-modal"  class="  open-edit-modal  " ><i class="fas fa-edit text-success p-1"></i> </a></td>'
                        ]).draw(false).nodes()
                        .to$()
                        .addClass('materialrow')
                    coa_copy.insertAfter($('#field2_area' + index))
                    $(".clear-modal").click();
                    // }
                    //  else {
                    //     Swal.fire({
                    //         position: 'center-center',
                    //         icon: 'warning',
                    //         title: 'หมายเลขล็อตซ้ำกัน',
                    //         text: "กรุณาลบรายการเดิมออกเพื่อทำการเพิ่มใหม่!",
                    //         showConfirmButton: false,
                    //         timer: 1500,
                    //     })
                    // }
                }
            })

            // function check_duplicate_numberlot() {
            //     status = true;
            //     var lot = $('#lot').val();
            //     if (lot != "" || null) {
            //         $('.materialrow').each(function(index, value) {
            //             if (lot === $(value).find('.mat_lot').text()) {
            //                 status = false
            //             }
            //         })

            //         $('.materialrowold').each(function(index, value) {
            //             if (lot === $(value).find('.mat_lot').text()) {
            //                 status = false
            //             }
            //         })
            //     }
            //     return status;
            // }

            $(".clear-modal").on('click', function() {
                $(this).closest('.modal').find(".dropify-clear").click();
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

            $('#receive_material_table tbody').on('click', '.list_cancel', function() {
                var index = receive_material_table.row($(this).parents('tr'));
                var rowindex = index.index();
                receive_material_table
                    .row($(this).parents('tr'))
                    .remove()
                    .draw();
                material.splice(rowindex, 1);
            });
            $('#create_receive_material2').on('click', function() {

                if ($('#receive_valid').valid()) {

                    var formdata_receive = new FormData();
                    // formdata_receive.append('username', 'Chris');
                    // formdata_receive.append('paper_no', $('#paper_no').val());
                    formdata_receive.append('edit_times', $('#edit_times').val());
                    formdata_receive.append('date', $('#date').val());
                    formdata_receive.append('brand_vendor_id', $('#brand_vendor_id').val());
                    formdata_receive.append('logistic_vendor_id', $('#logistic_vendor_id').val());
                    formdata_receive.append('_token', $('#_token').val());
                    formdata_receive.append('id', $('#id').val());
                    formdata_receive.append('user_id', $('#user_id').val());
                    formdata_receive.append('po_no', $('#po_no').val());
                    formdata_receive.append('bill_no', $('#bill_no').val());
                    formdata_receive.append('po_file', $('#po_file').prop('files')[0]);
                    formdata_receive.append('company_id', {{ session('company') }});

                    formdata_receive.append('sender_vehicle_plate', $('#sender_vehicle_plate').val());
                    var multifile = document.getElementById('TransportPic_name').files

                    for (var i = 0, f; f = multifile[i]; i++) {
                        formdata_receive.append('file_name[]', multifile[i]);
                    }

                    $('.materialrow').each(function(index, value) {

                        if ($(value).find('.mat_coa').data("check") == 1) {
                            formdata_receive.append('material[' + index + '][coa]', $(value).find(
                                'input.mat_coa').prop('files')[0])
                        }
                        formdata_receive.append('material[' + index + '][receive_mat_name]', $(
                            value).find('.mat_id').text())
                        formdata_receive.append('material[' + index + '][company_id]', $(value)
                            .find('.mat_com_id').text())
                        formdata_receive.append('material[' + index + '][lot]', $(value).find(
                            '.mat_lot').text())
                        formdata_receive.append('material[' + index + '][weight_grams]', $(value)
                            .find('.mat_grams').text())
                        formdata_receive.append('material[' + index + '][weight_kg]', $(value).find(
                            '.mat_kg').text())
                        formdata_receive.append('material[' + index + '][weight_ton]', $(value)
                            .find('.mat_tons').text())
                        formdata_receive.append('material[' + index + '][mfg]', $(value).find(
                            '.mat_mfg').text())
                        formdata_receive.append('material[' + index + '][exp]', $(value).find(
                            '.mat_exp').text())
                    })
                    var rows_material = receive_material_table.rows().count();
                    if (rows_material > 0) {
                        Swal.fire({
                            title: 'ยืนยันการนำเข้าวัตถุดิบ?',
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
                                    url: "{{ route('api.v1.receive.material.create') }}",
                                    data: formdata_receive,
                                    contentType: false,
                                    processData: false,
                                    cache: false,
                                    // dataType: "dataType",
                                    success: function(response) {
                                        if (response != null) {
                                            Swal.fire({
                                                position: 'center-center',
                                                icon: 'success',
                                                title: 'เพิ่มรายการนำเข้าสำเร็จ',
                                                showConfirmButton: false,
                                                timer: 1500,

                                            })
                                            window.location.assign(
                                                "{{ route('stock') }}")
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
                            title: 'กรุณาเพิ่มรายการนำเข้าวัตถุดิบ',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }

            })
            $('.btn-back').on('click', function() {
                window.history.back();
            });

            $(document).on('click', '.open-edit-modal', function() {
                var data = receive_material_table.row($(this).parents('tr'))
                var receive = data.data()
                var currentPage = receive_material_table.page();
                // var index = receive_material_table.row($(this));
                var index = data.index(),
                    rowCount = receive_material_table.data().length - 1,
                    insertedRow = receive_material_table.row(rowCount).data(),
                    tempRow;

                let in_html = `   <form name="validForm">
                                    <div class="row mb-2">
                                        <input class="form-control dropify coa_update" type="file" name="coa_update" id="coa_update"  required>
                                    </div>
                                </form>
                            `
                Swal.fire({
                    title: "กรุณาเพิ่มไฟล์เอกสาร COA",
                    html: in_html,
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ปิด',
                    confirmButtonColor: '#649514',
                    cancelButtonColor: '#a97551',
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleterow(index)
                        var receive_mat_name = $(receive[1]).find('.mat_id').text();
                        var company_id = $(receive[2]).find('.mat_com_id').text();
                        var lot = $(receive[3]).text();
                        var ton = $(receive[4]).text();
                        var kg = $(receive[5]).text();
                        var grams = $(receive[6]).text();
                        var mfg = $(receive[7]).text();
                        var exp = $(receive[8]).text();
                        var coa = $(receive[9]).text();
                        // var indexrow = receive_material_table.row($(this).parents('tr')).index();
                        var file = $('#coa_update').val()

                        var coa_copy = $('#coa_update').clone();
                        var file_name = $('#coa_update').prop('files')[0].name;
                        coa_copy.attr('id', 'field' + index);
                        coa_copy.addClass('mat_coa mat_hide');
                        receive_material_table.row.add([
                                `<td><a class="list_cancel" style="cursor: pointer;"><i class="fas fa-times text-red"></i></a></td>`,
                                `<td><span class="mat_id mat_hide ">${receive_mat_name}</span>${receive_mat_name}</span></td>`,
                                '<td><span class="mat_com_id mat_hide ">' + company_id +
                                '</span>' + $('#company_id option:selected').text() + '</td>',
                                '<td><span class="mat_lot ">' + lot + '</span></td>',
                                '<td><span class="mat_tons ">' + ton + '</span></td>',
                                '<td><span class="mat_kg ">' + kg + '</span></td>',
                                '<td><span class="mat_grams ">' + grams + '</span></td>',
                                '<td><span class="mat_mfg ">' + mfg + '</span></td>',
                                '<td><span class="mat_exp ">' + exp + '</span></td>',
                                '<td>' +
                                '<span class=" mat_coa mat_hide" data-check="1" id="field2_area' +
                                index + '"></span>' +
                                '<span class="badge badge-success  "><em class="fas fa-paperclip p-1"></em>' +
                                file_name + '</span></td>',
                                '<td><a data-toggle="tooltip" data-placement="top" title="แก้ไข" type="" style="cursor: pointer;"  id="open-edit-modal"  class="  open-edit-modal  " ><i class="fas fa-edit text-success p-1"></i> </a></td>'
                            ]).draw(false).nodes()
                            .to$()
                            .addClass('materialrow')
                        coa_copy.insertAfter($('#field2_area' + index))
                    }
                });
            })

            function deleterow(row) {
                receive_material_table
                    .row(row)
                    .remove()
                    .draw();
            }

        });
    </script>
@endsection
