@extends('adminlte::page')

@section('css')
<style>
    .error {
        color: red;
        font-size: 10pt;
    }

    th, td { white-sproe: nowrap; }
    div.dataTables_wrapper {
    width: 300px;
    margin: 0 auto;
    }

    .DTFC_LeftBodyLiner{overflow-y:unset !important}
    .DTFC_RightBodyLiner{overflow-y:unset !important}
    /* .DTFC_LeftBodyWrapper td { overflow: hidden; display: inline } */
    table.dataTable td {
        background: #ffff;
    }

    th,
    td {
        background-color: white;
        white-sproe: nowrap;
        overflow: hidden;
    }


    .card-header {
        padding: .45rem !important;
    }

    /* custom fix left column*/
    .sproe-nowrap {
        white-sproe: nowrap !important;
    }

    .kpi>.card-body {
        padding: 0 !important;
    }

    .table thead th {
        border-bottom: 1px solid #dee2e6;
    }

    .card-header {
        padding: .5rem;
    }

    .table-objective {
        margin-bottom: .5rem;

    }

    table.table-fixed {
        table-layout: fixed;
        width: 100%;
        margin-left: -100px;
    }

    th.hard_left.table-fixed.first,
    td.hard_left.table-fixed.first {
        width: 15% !important;
    }
    th.hard_left.table-fixed.topic,
    td.hard_left.table-fixed.topic {
        min-height: 130px;
    }

    th.hard_left.table-fixed.second,
    td.hard_left.table-fixed.second {
        width: 15% !important;
        margin-left: 15% !important;
        transition: width .2s ease-out;
    }
    td.hard_left.table-fixed.second:hover {
        width: 34% !important;
        text-align: center !important;
        background-color: #ddd;
        z-index: 1 !important;
    }
    td.hard_left.table-fixed.second.rowspan:hover {
        height: 2rem !important;
    }

    th.hard_left.table-fixed.thirt,
    td.hard_left.table-fixed.thirt {
        margin-left: 40% !important;
    }

    td.table-fixed,
    th.table-fixed {
        vertical-align: top;
        border-top: 1px solid #ccc;
        padding: 4px;
    }

    .header-title {
        height: 130px;
        border-top: 1px solid lightgray !important;
        padding-top: 40px !important;
    }
    .next_left {
        min-width: 200px;
    }

    @media all and (max-width: 767px) {
        .hard_left {
            position: absolute;
            left: 0;
            width: 24%;
            overflow: hidden;
        }

        .inner {
            overflow-x: scroll;
            overflow-y: visible;
            width: 70%;
            margin-left: 30%;
        }
    }

    @media all and (min-width: 768px) {
        .hard_left {
            position: absolute;
            left: 0;
            width: 24%;
            overflow: hidden;
        }

        .inner {
            overflow-x: scroll;
            overflow-y: visible;
            width: 70%;
            margin-left: 30%;
        }
    }
    .table-bordered thead th, .table-bordered thead td {
         border-bottom-width: 1px;
    }
    .card-body.p-0 .table tbody > tr > td:first-of-type {
        padding-left: 0.8rem;
    }
    .card-body.p-0 .table thead>tr>th:first-of-type {
        padding-left: 0.5rem;
    }

    .card-body.p-0 .table tbody>tr>th:first-of-type {
        padding-left: 0.8rem;
    }

    .division-modal-table>td {
        height: 39px !important;
    }

    .input-invalid::placeholder {
        color: #ea6662 !important;
    }
</style>
@endsection
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active"> <a href="{{url('/receive/check/product')}}">ตรวจสอบรายการนำเข้าสินค้า</a> </li>
                    <li class="breadcrumb-item active">ตรวจสอบสินค้า</li>
                </ol>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

@stop

@section('content')

    <div class="card">
        <div class="card-header ogn-stock-green">
            ตรวจสอบสินค้า
        </div>
        <form id="formInspect" action="{{route('receive.product.check.save')}}" method="POST">
            @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <input type="hidden" name="id" id="id" value="{{$pro_lot_detail->id}}">
                    <input type="hidden" name="statusEdit" id="statusEdit" value="0">
                    <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                    <input type="hidden" name="loadTime" id="loadTime" value="0">
                    <input class="form-control" type="hidden" name="status" id="status"  readonly>
                    <label class="label-control" for="">หมายเลขล็อต</label>
                    <input class="form-control" type="text" name="" id="" value="{{$pro_lot_detail->lot}}" readonly>

                </div>
                <div class="col-sm-8">
                    <label class="label-control" for="">ชื่อสินค้า</label>
                    <input class="form-control" type="text" name="" id="" value="{{$pro_detail->name}}" readonly>
                </div>
                <div class="col-sm-4 pt-2">
                    <label class="label-control" for="">ปริมาณสินค้าที่รับเข้า</label>
                    <input class="form-control" type="text" name="" id="" value="{{$pro_lot_detail->qty}} ชิ้น" readonly>
                </div>
                <div class="col-sm-4 pt-2">
                    <label class="label-control" for="">MFG.</label>
                    <input class="form-control" type="text" name="" id="" value="{{$pro_lot_detail->mfg}}" readonly>
                </div>
                <div class="col-sm-4 pt-2">
                    <label class="label-control" for="">EXP.</label>
                    <input class="form-control" type="text" name="" id="" value="{{$pro_lot_detail->exp}}" readonly>
                </div>
                <div class="col-sm-4 py-2"  style="margin-top: 10px;">
                    <label for=""class="label-control">เลือกหัวข้อการตรวจสอบ</label>
                    <select name="inspect_template_id" id="inspect_template_id" class="form-control">
                        <option class="defualt_select" id='defualt_select' disabled selected value > - กรุณาเลือกหัวข้อการตรวจสอบ - </option>
                        @foreach ( $inspect_templates as $inspect_template )
                            <option value="{{$inspect_template->id}}">{{$inspect_template->name}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="selected_name" id="selected_name" value="">
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-12">

                    <div class="card shadow-none" id="table_check">

                        <div class="card-body p-0 inner">
                            <table id="inspect_table" class="table w-100 table-bordered table-responsive border-left-0 mb-3 table-sm" style="">
                                <caption style="display: none"></caption>
                                <thead>
                                    <tr class="inspect-th-header">
                                        <th scope="col" class="w-auto text-center align-middle table-fixed hard_left first header-title" rowspan="1">หัวข้อการตรวจสอบ</th>
                                        <th scope="col" class="w-auto text-center align-middle table-fixed hard_left second header-title" rowspan="1">วิธีการตรวจสอบ</th>

                                    </tr>
                                    <tr class="inspect-th-time">
                                        <td class="table-fixed hard_left first" style="border: none; z-index: -10;"></td>
                                        <td class="table-fixed hard_left second" style="border: none; z-index: -10;"></td>
                                    </tr>
                                    <tr class="inspect-th-qty">
                                        <td class="table-fixed hard_left first" style="border: none; z-index: -10;"></td>
                                        <td class="table-fixed hard_left second" style="border: none; z-index: -10;"></td>
                                    </tr>
                                </thead>
                                <tbody class="inspect_topic_body">

                                </tbody>
                                <tfoot>
                                    <tr class="inspect_topic_result">
                                        <td class="table-fixed hard_left first" style="width: 30% !important;">ผลการประเมิน</td>
                                        <td class="table-fixed hard_left second" style="z-index: -10;"></td>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div style="text-align: right;">
                        <a class="btn ogn-stock-grey text-black btn-back"><em class="fas fa-arrow-left"></em> ย้อนกลับ</a>
                        <a class="btn-save btn ogn-stock-green text-white" ><em class="fas fa-save"></em> บันทึก</a>
                    </div>
                </div>
            </div>
        </div> {{-- cardbody --}}
        </form>
    </div>







@endsection

@section('js')
   <script>

      $(function(){

        $('.btn-back').on('click', function() {
            window.history.back();
        });

        var product_lot_id = $('#id').val();
        $.ajax({
            type: "post",
            url: "{{route('api.v1.receive.product.quality.check.detail')}}",
            data: {"id" : product_lot_id},
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if(response[0] != null){
                    $('#statusEdit').val('1');
                    $('#selected_name').val(response[0].ins_template_name);
                }
                loadEvalutionTopic(response);
            }
        });


        $('.dropify').dropify();

        let check_receive_table = $('#receive_product_table_check').DataTable({
            fixedColumns: {
                leftColumns: 2
            },
            scrollY:        300,
            scrollX:        true,
            fixedColumns:   true,
        });

        $('#receive_product_table_check tbody').on('click', '.list_cancel', function() {
            var index = check_receive_table.row($(this).parents('tr'));
            var rowindex = index.index();
            check_receive_table
                .row($(this).parents('tr'))
                .remove()
                .draw();
            product.splice(rowindex, 1);

        });


        $('#inspect_template_id').on('change',function(){
            var inspect_template_id = $('#inspect_template_id').val();
            var inspect_template_name = $('#inspect_template_id option:selected').text();
            let in_html = `<div class="row mb-2"><div class="col-12 text-left text-black-50">หัวข้อการตรวจสอบ</div></div>`

            $.ajax({
                type: "post",
                url: "{{route('api.v1.receive.product.get.template.detail')}}",
                data: {"id" : inspect_template_id},
                dataType: "JSON",
                success: function (response) {
                    $.each(response,function(key, topic){
                        in_html += `<div class="row mb-1">
                            <div class="col-2 text-left">${key+1}</div>
                            <div class="col-5 text-left">${topic.name}</div>
                            <div class="col-5 text-left">${topic.method}</div>
                        </div>`
                    })
                    in_html += `<span class="text-danger">*** หากทำการยืนยัน ***<br> ระบบจะทำการลบรายการตรวจสอบเดิม!!</span>`

                    Swal.fire({
                        title: `<h4>${inspect_template_name}</h4>`,
                        icon: 'question',
                        html: in_html,
                        showCancelButton: true,
                        confirmButtonColor: '#a97551',
                        cancelButtonColor: '#649514',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            constructTopic(response);
                            $('#selected_name').val(inspect_template_name);
                            $('#loadTime').val(1);
                        } else {

                        }
                    })
                }
            });

        });

      });

      function loadEvalutionTopic(response) {
          $('#inspect_template_id').val(response[0].inspect_template_id)
        //   console.log("Eval")
        //   console.log(response)
          $(".append_next").remove();
          let header_panel_head = $(".inspect-th-header");
          let header_panel_time = $(".inspect-th-time");
          let header_panel_qty = $(".inspect-th-qty");
          let topic_panel = $(".inspect_topic_body");
          let result_panel = $(".inspect_topic_result");
          //insert topic to table
          let detail_result = null;
          $.each(response, function(key, topic){
              if ( topic.ins_type==="1") {
                  let tds = ``;
                  // console.log(topic.)
                  let _detail_len = topic.product_inspect_details.length-1;
                  $.each(topic.product_inspect_details, function (key2, dtl) {

                      if ( key === 0) {//load header once
                          let detail_td_header = ``;
                          console.log("key2 "+key2)
                          $('#loadTime').val(key2+1);
                          if ( key2 === 0) { //check first evaluation times
                              detail_td_header = `
                                <div class="float-left">ผลการตรวจสอบ</div>
                                <div class="btn btn-sm btn-group float-right ml-1 append_time"><em class="fas fa-plus-circle text-success"> เพิ่ม</em></div>
                                `;
                          }
                          if ( key2 === _detail_len) { //check last evaluation times
                            //   detail_td_header = `
                            //     <div class="btn btn-sm btn-group float-right ml-1 remove_time"><em class="fas fa-times-circle text-danger"> ลบ</em></div>
                            // `;
                          }
                          let td_header = ` <th scope="col" class="w-auto text-center inspect-th table-fixed next_left append_next">${detail_td_header}</th>`;
                          header_panel_head.append(td_header);
                          let td_header_time = ` <td class="table-fixed append_next">ครั้งที่ ${key2+1}</td>`;
                          header_panel_time.append(td_header_time);
                          let td_header_qty = ` <td class="table-fixed append_next">จำนวน <input type="number" width="10" class="w-50 text-right" name="topic[1][qty][${key2+1}]" value="${dtl.ins_qty}" required readonly> ชิ้น</td>`;
                          header_panel_qty.append(td_header_qty);
                      }

                      //load details
                      tds += `<td class="table-fixed detail_next"><textarea rows="4" class="form-control" name="topic[${key+1}][detail][${key2+1}]" readonly>${dtl.detail}</textarea></td>`;
                  });
                  let tr = `<tr class="append_next">
                    <td class="table-fixed hard_left first topic">
                        <p>
                        ${topic.ins_topic}
                        <input type="hidden" name="topic[${key+1}][topic]" value="${topic.ins_topic}" required>
                        </p>
                    </td>
                    <td class="table-fixed hard_left second topic">
                        <p>
                        ${topic.ins_method}
                        <input type="hidden" name="topic[${key+1}][method]" value="${topic.ins_method}" required>
                        </p>
                    </td>
                    ${tds}
              </tr>`
                  topic_panel.append(tr)
              } else {
                  detail_result = topic;
              }
          });

          //insert result to footer
          let td_result = ``;
          $.each(detail_result.product_inspect_details, function (key3, dtlrs) {
              td_result += ` <td class="append_next">
                                <input type="radio" name="times_result[1][detail][${dtlrs.ins_times}]" value='1' ${dtlrs.detail==="1"?'checked':''} ${dtlrs.detail==="1"?'checked':'disabled'} id="" required> ผ่าน
                                <input type="radio" name="times_result[1][detail][${dtlrs.ins_times}]" value='0' ${dtlrs.detail==="0"?'checked':''} ${dtlrs.detail==="0"?'checked':'disabled'} id="" required> ไม่ผ่าน
                            </td>`;
          });
          result_panel.append(td_result);

      }


      function constructTopic(response) {
          console.log(" const ");
          console.log(response)
          $(".append_next").remove();
          let header_panel_head = $(".inspect-th-header");
          let header_panel_time = $(".inspect-th-time");
          let header_panel_qty = $(".inspect-th-qty");
          let topic_panel = $(".inspect_topic_body");
          let result_panel = $(".inspect_topic_result");

          //insert times to header
          let td_header = ` <th scope="col" class="w-auto text-center inspect-th table-fixed next_left append_next">
                                <div class="float-left">ผลการตรวจสอบ</div>
                                <div class="btn btn-sm btn-group float-right ml-1 append_time"><em class="fas fa-plus-circle text-success"> เพิ่ม</em></div>
                            </th>`;
          header_panel_head.append(td_header);
          let td_header_time = ` <td class="table-fixed append_next text-center">ครั้งที่ 1</td>`;
          header_panel_time.append(td_header_time);
          let td_header_qty = ` <td class="table-fixed append_next text-center">จำนวน <input type="number" class="w-50 text-right" name="topic[1][qty][1]" width="10" required> ชิ้น</td>`;
          header_panel_qty.append(td_header_qty);

          //insert topic to table
          $.each(response, function(key, topic){
              let tds = `<td class="table-fixed"><textarea rows="4" name="topic[${key+1}][detail][1]" class="form-control">detail ของ หัวข้อ 1 ครั้งที่ 1</textarea></td>`;
              let tr =  `<tr class="append_next">
                    <td class="table-fixed hard_left first topic">
                        <p>
                        ${topic.name}
                        <input type="hidden" name="topic[${key+1}][topic]" value="${topic.name}" required>
                        </p>
                    </td>
                    <td class="table-fixed hard_left second topic">
                        <p>
                        ${topic.method}
                        <input type="hidden" name="topic[${key+1}][method]" value="${topic.method}" required>
                        </p>
                    </td>
                    ${tds}
              </tr>`
              topic_panel.append(tr)
          });

          //insert result to footer
          let td_result = ` <td class="append_next">
                                <input type="radio" name="times_result[1][detail][1]" id="" value="1" required> ผ่าน
                                <input type="radio" name="times_result[1][detail][1]" id="" value="0" required> ไม่ผ่าน
                            </td>`;
          result_panel.append(td_result);

      }

      $(document).on('click','.append_time', function(){
          appendTime();
      })

      $(document).on('click','.remove_time', function(){
          removeTime();
      })

      function appendTime(){
          let header_panel_head = $(".inspect-th-header");
          let header_panel_time = $(".inspect-th-time");
          let header_panel_qty = $(".inspect-th-qty");
          let topic_panel = $(".inspect_topic_body");
          let result_panel = $(".inspect_topic_result");

          let _time = header_panel_head.find(".append_next").length;
          //insert times to header
          header_panel_head.find('.remove_time').last().remove();
          let td_header = ` <th scope="col" class="w-auto text-center inspect-th table-fixed next_left append_next">
                                <div class="btn btn-sm btn-group float-right ml-1 remove_time"><em class="fas fa-times-circle text-danger"> ลบ</em></div>
                            </th>`;

          header_panel_head.append(td_header);
          let td_header_time = ` <td class="table-fixed append_next text-center">ครั้งที่ ${_time+1}</td>`;
          header_panel_time.append(td_header_time);
          let td_header_qty = ` <td class="table-fixed append_next text-center">จำนวน <input type="number" class="w-50 text-right" name="topic[1][qty][${_time+1}]" width="10" required> ชิ้น</td>`;
          header_panel_qty.append(td_header_qty);
          //insert result to footer
          let td_result = ` <td class="append_next">
                                <input type="radio" name="times_result[1][detail][${_time+1}]" id="" value="1" required> ผ่าน
                                <input type="radio" name="times_result[1][detail][${_time+1}]" id="" value="0" required> ไม่ผ่าน
                            </td>`;
          result_panel.append(td_result);

          //insert body detail

          $.each(topic_panel.find('.append_next'),function (key, detail_row){
                let tds = `<td class="table-fixed detail_next"><textarea rows="4" name="topic[${key+1}][detail][${_time+1}]" class="form-control">insert result here</textarea></td>`;
                $(detail_row).append(tds);
          })

      }



      function removeTime(){
          let header_panel_head = $(".inspect-th-header");
          let header_panel_time = $(".inspect-th-time");
          let header_panel_qty = $(".inspect-th-qty");
          let topic_panel = $(".inspect_topic_body");
          let result_panel = $(".inspect_topic_result");

          //remove times from header
          header_panel_head.find('.append_next').last().remove();
          let _time = header_panel_head.find(".append_next").length;
          let remove_btn = `<div class="btn btn-sm btn-group float-right ml-1 remove_time"><em class="fas fa-times-circle text-danger"> ลบ</em></div>`;

          let loadTime = $('#loadTime').val();
          let currentTime = header_panel_head.find('.append_next').length;

          if (_time > 1 && currentTime > loadTime) {
                header_panel_head.find('.append_next').last().append(remove_btn);
          }
          header_panel_time.find('.append_next').last().remove();
          header_panel_qty.find('.append_next').last().remove();
          //remove result from footer
          result_panel.find('.append_next').last().remove();

          //remove body detail
          $.each(topic_panel.find('.append_next'),function (key, detail_row){
              $(detail_row).find('.detail_next').last().remove();
          })

      }

        $(document).ready(function() {
            var table = $('#example').DataTable( {
                scrollY:        "300px",
                scrollX:        true,
                scrollCollapse: true,
                paging:         false,

                fixedColumns:   {
                    leftColumns: 2
                }
            } );

            $('.btn-save').on('click', function(){
                Swal.fire({
                    title: 'ยืนยันการตรวจสอบ?',
                    text: "ต้องการดำเนินการใช่หรือไม่!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#649514',
                    cancelButtonColor: '#a97551',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ปิด'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if($('#formInspect').valid()){
                            $('#formInspect').submit();
                        }
                    }
                    });
            });

        } );


   </script>
@endsection
