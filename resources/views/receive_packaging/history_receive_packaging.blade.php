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
                <li class="breadcrumb-item active"><a href="{{ route('packaging') }}">รับเข้าบรรจุภัณฑ์</a></li>
                <li class="breadcrumb-item active">ประวัติการแก้ไข</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
<input type="hidden" name="id" id="id" value="{{$receive_packaging_id}}">

<div class="card">
    <div class="card-header ogn-stock-green ">
        <h3 class="card-title header-card">รายการปัจจุบัน</h3>
    </div>
    <div class="card-body">
        <form action="" id="receive_valid">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                    <label for="" class="form-label">หมายเลขเอกสาร</label>
                    <input type="text" id="paper_no" class="form-control" value="{{$receivepackaging->paper_no}}" required readonly>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                    <label for="" class="form-label">วันที่นำเข้า</label>
                    <input type="text" id="date" value="{{$receivepackaging->date}}" class="form-control" readonly>
                    <small id="checkdate"></small>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                    <label for="" class="form-label">แบรนด์สินค้า</label>
                    <select name="" id="brand_vendor_id" class="form-control" readonly disabled>
                        @foreach ( $vendors as $brand )
                            @if ($brand->type == 1)
                                <option value="{{$brand->id}}">{{$brand->brand}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                    <label for="" class="form-label">บริษัทขนส่ง</label>
                    <select name="" id="logistic_vendor_id" class="form-control" readonly disabled>
                        @foreach ( $vendors as $brand )
                            @if ($brand->type == 2)
                                <option value="{{$brand->id}}">{{$brand->brand}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3 mt-2">
                    <label for="" class="form-label">หมายเหตุ</label>
                    <input type="text" id="recap" name="recap" class="form-control" value="{{$receivepackaging->recap}}" required readonly>
                </div>
            </div>
        </form>
        <hr class="my-4">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-gdp">
                    <div class="card-header bg-disyellow" style="background-color: #E6FF99;">
                        <h6 class="m-0">รายการบรรจุภัณฑ์ </h6>
                    </div>
                    <div class="card-body p-0">
                        <table id="receive_packaging_table_current" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                            <caption style="display: none"></caption>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="w-auto">#</th>
                                    <th scope="col" class="w-auto">รายการบรรจุภัณฑ์</th>
                                    <th scope="col" class="w-auto">บริษัท</th>
                                    <th scope="col" class="w-auto">หมายเลข Lot</th>
                                    <th scope="col" class="w-auto">จำนวนทั้งหมด</th>
                                    <th scope="col" class="w-auto">MFG.</th>
                                    <th scope="col" class="w-auto">EXP.</th>
                                    <th scope="col" class="w-auto">ใบ COA</th>
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
            url: "{{route('api.v1.receive.packaging.history')}}",
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
                response.aaData.forEach((element, index) => {
                    date = new Date(element.created_at)
                    row +=

                        `
                    <div class="card " id="card-history">
                        <div class="card-header border-transparent  bg-gradient-gray">
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
                                <!-- <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                <label for="" class="form-label">จำนวนครั้งที่แก้ไข</label>
                                <input type="text" id="edit_times" class="form-control">
                                <small id="checkedit_times"></small>
                            </div> -->
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                    <label for="" class="form-label">วันที่นำเข้า</label>
                                    <input type="text" id="text" value="${new Date(element.date).toLocaleString('th-TH')}" class="form-control" readonly>
                                    <small id="checktext"></small>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 ">
                                    <label for="" class="form-label">แบรนด์สินค้า</label>
                                    <input type="text" id="text" value="${element.brand_vendor.brand}" class="form-control" readonly>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 p-2 ">
                                    <label for="" class="form-label">บริษัทขนส่ง</label>
                                    <input type="text" id="text" value="${element.logistic_vendor.brand}" class="form-control" readonly>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 p-2 ">
                                    <label for="" class="form-label">หมายเหตุ</label>
                                    <input type="text" id="text" value="${element.recap}" class="form-control" readonly>
                                </div>

                            </div>

                            <hr class="my-4">

                            <div class="row">

                                <div class="col-12">

                                    <div class="card card-outline card-gdp">
                                        <div class="card-header ogn-stock-yellow text-left ">
                                            <h6 class="m-0">รายการบรรจุภัณฑ์ </h6>
                                        </div>

                                        <div class="card-body p-0">

                                            <table id="receive_packaging_history_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                                                <caption style="display: none"></caption>
                                                <thead class="">
                                                    <tr>
                                                        <th scope="col" class="w-auto">#</th>
                                                        <th scope="col" class="w-auto">รายการบรรจุภัณฑ์</th>
                                                        <th scope="col" class="w-auto">บริษัท</th>
                                                        <th scope="col" class="w-auto">หมายเลข Lot</th>
                                                        <th scope="col" class="w-auto">จำนวน</th>
                                                        <th scope="col" class="w-auto">MFG.</th>
                                                        <th scope="col" class="w-auto">EXP.</th>
                                                        <th scope="col" class="w-auto">ใบ COA</th>
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
                    // console.log()
                    row2 = ''
                    element.historypackaging_lots.forEach((value,index2)=>{
                        // var id = element.id
                        if (element.id === value.history_receive_packaging_id) {
                            ref = "{{asset('uploads/coa_material/')}}";

                            row2+=
                            `
                            <tr>
                            <td>${++index2}</td>
                            <td>${value.packaging.name}</td>
                            <td>${value.company.name_th}</td>
                            <td>${value.lot}</td>
                            <td>${value.qty}</td>
                            <td>${value.mfg}</td>
                            <td>${value.exp}</td>
                            <td class="text-center"><a class=" "  href=" ${ref}/${value.coa}" download><i class="fas fa-download p-1 "></i></a></td>
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

        let receive_packaging_table_current = "";
        $.ajax({
            type: "post",
            url: "{{route('api.v1.receive.packaging.list.packaging.lot')}}",
            data: {"id":id},
            dataType: "json",
            success: function (response) {
                var row = '';
                dataOld = response.aaData;
                // console.log(dataOld)
                response.aaData.forEach( (element,index)=> {
                    console.log(element)
                    ref = "{{asset('uploads/coa_packaging/')}}";

                    coa_file = '<td><a class=" "  href="'+ref+'/'+element.coa+'" download><i class="fas fa-download p-1 "></i></a></td>'
                    if (element.coa == "0" || element.coa == null) {
                        coa_file = '<td><span class=" pac_coa pac_hide" id="field2_area'+index+'"></span><span class="badge bg-warning text-dark">ยังไม่เพิ่มเอกสาร</span></td>'
                    }
                    row +=
                `<tr class="packagingrowold">
                    <td>${++index}</td>
                    <td>${element.name}</span></td>
                    <td>${element.name_th}</td>
                    <td><span class=" pack_lot ">${element.lot}</span></td>
                    <td><span class=" pack_qty ">${element.qty}</span></td>
                    <td><span class=" pack_exp ">${element.exp} </span></td>
                    <td><span class=" pack_mfg ">${element.mfg} </span></td>
                    ${coa_file}
                </tr>`

                });

                $('#rowbody').html(row);

                receive_packaging_table_current = $('#receive_packaging_table_current').DataTable({
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
