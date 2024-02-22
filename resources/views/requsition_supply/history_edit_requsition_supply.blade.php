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
                <li class="breadcrumb-item active"><a href="{{ route('list.requsition.supply') }}">รายการเบิกวัสดุสิ้นเปลือง</a></li>
                <li class="breadcrumb-item active">ประวัติการแก้ไข</li>
            </ol>
        </div><!-- /.col -->

    </div><!-- /.row -->
</div><!-- /.container-fluid -->

@stop

@section('content')
    <input type="hidden" name="id" id="id" value="{{$requsition_supply_id}}">
    <div id="history">
    </div>

@endsection

@section('js')
<script>
    $(function() {
        let id = $('#id').val()
        $.ajax({
            type: "post",
            url: "{{route('api.v1.requsition.supply.history')}}",
            data: {
                'id': id
            },
            dataType: "json",
            success: function(response) {
                var row = '';
                var row2 = '';
                // var rowbody = '#rowbody';
                let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',timeStyle: 'long' };
                options.timeZone = 'UTC';
                options.timeZoneName = 'short';
                response.aaData.forEach((element, index) => {
                    date = new Date(element.updated_at)
                    row +=

                        `
                    <div class="card " id="card-history">
                        <div class="card-header border-transparent ogn-stock-green">
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
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="" class="form-label">หมายเลขเอกสาร</label>
                                    <input type="text" id="paper_no" class="form-control" value="${element.paper_no}" required readonly>
                                    <small id="checkpaper_no"></small>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="" class="form-label">วันที่นำเข้า</label>
                                    <input type="text" id="text" value="${element.date}" class="form-control" readonly>
                                    <small id="checktext"></small>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label">รายละเอียดการเบิก</label>
                                    <input type="text" id="text" value="${element.detail}" class="form-control" readonly>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="" class="form-label">หมายเหตุ</label>
                                    <input type="text" id="text" value="${element.recap}" class="form-control" readonly>
                                </div>
                                <div class="col-6 mb-2">
                                    <label for="" class="form-label">สร้างโดย</label>
                                    <input type="text" id="text" value="${element.create_user.employee.prefix.name}${element.create_user.employee.fname} ${element.create_user.employee.lname}" class="form-control" readonly>
                                </div>
                                <div class="col-6 mb-2">
                                    <label for="" class="form-label">แก้ไขโดย</label>
                                    <input type="text" id="text" value="${element.update_user.employee.prefix.name}${element.update_user.employee.fname} ${element.update_user.employee.lname}" class="form-control" readonly>
                                </div>

                            </div>

                            <hr class="my-4">

                            <div class="row">

                                <div class="col-12">

                                    <div class="card card-outline card-gdp">
                                        <div class="card-header ogn-stock-yellow text-left ">
                                            <h6 class="m-0"><em class="fas fa-fw fa-users-cog"></em> รายการวัสดุสิ้นเปลือง </h6>
                                        </div>

                                        <div class="card-body p-0">

                                            <table id="requsition_supply_table" class="table w-100 " style="margin-top: 0!important; margin-bottom: 0!important;">
                                                <caption style="display: none"></caption>
                                                <thead class="">
                                                    <tr>
                                                        <th scope="col" class="w-auto">#</th>
                                                        <th scope="col" class="w-auto">รายการ</th>
                                                        <th scope="col" class="w-auto">บริษัท</th>
                                                        <th scope="col" class="w-auto">Lot</th>
                                                        <th scope="col" class="w-auto">จำนวนชิ้น</th>
                                                        <th scope="col" class="w-auto">MFG.</th>
                                                        <th scope="col" class="w-auto">EXP.</th>
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
                    element.historysupplycut.forEach((value,index2)=>{
                        console.log(value)
                        // var id = element.id
                        if (element.id === value.history_requsition_supply_id) {
                            row2+=
                            `
                            <tr>
                                <td>${++index2}</td>
                                <td>${value.supply_lot.supply.name}</td>
                                <td>${value.supply_lot.company.name_th}</td>
                                <td>${value.supply_lot.lot}</td>
                                <td class="text-right">${value.qty}</td>
                                <td>${value.supply_lot.mfg}</td>
                                <td>${value.supply_lot.exp}</td>
                            </tr>
                            `

                        } else {

                        }

                        console.log(row2)

                        $('#rowbody'+index).html(row2)

                    })
                })

            }
        });

        var supply = []

        $('.dropify').dropify();
        let requsition_supply_table = $('#requsition_supply_table').DataTable({
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
