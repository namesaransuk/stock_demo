<!DOCTYPE html>
<html lang="en">
    <style>
        @font-face{
        font-family:  'THSarabunNew';
        font-style: normal;
        font-weight: normal;
        src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face{
        font-family:  'THSarabunNew';
        font-style: normal;
        font-weight: bold;
        src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face{
        font-family:  'THSarabunNew';
        font-style: italic;
        font-weight: normal;
        src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face{
            font-family:  'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
        .img-logo {
            {{--content : url("{{asset('uploads/company_logo/'.$com_logo)}}");--}}
            max-width : 150px;
        }
        body{
            font-family: "THSarabunNew";
            font-size: 16px;
        }
        @page {
            /* size: A4;
            padding: 0px; */
            margin-top:20px;
            margin-left:30px;
            margin-right:30px;
        }
        @media print {
            html, body {
            width: 210mm;
            height: 297mm;
            /*font-size : 16px;*/
            }
        }

        .border_table{
            border: 1px solid black;
            border-collapse: collapse;

        }

        .score{
            width: 300px;
            /* background-color: gray; */
            position: absolute ;
            top: 100px;
            left: 850px;
            text-align: center !important;
            vertical-align: middle !important;
            /* border: 3px solid gray; */
            padding: 0px;
            font-size: 20px;
        }

        .addimage{
            position: fixed;
            width: 57px;
        }

        .pagenum:before {
            content: counter(page) " of " counter(pages );
        }
    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
        {{-- <img src="{{public_path('/img/logo/f-plus-logo.png')}}" class="addimage">
        <h2 style="text-align:center;">แบบประเมินผลการปฏิบัติงาน {{$item['data_employee']->Titlename}} {{$item['data_employee']->first_name}} {{$item['data_employee']->last_name}}</h2> --}}
        @php
            $date=date_create($data_requsition->date);
            $date_receive=date_format($date,"d/m/Y")
        @endphp

        <table class="border_table">
            <thead>
                <tr>
                    <th class="border_table" style="width:150px;" rowspan="4">
                        <img class="img-logo" src="{{public_path("uploads/company_logo/$com_logo")}}" alt="{{$com_logo}}">
                    </th>
                    <th class="border_table" style="width:750px;" rowspan="4"><h1>บันทึกการเบิก/คืนวัตถุดิบ</h1>  </th>
                    <th class="border_table" style="width:150px;text-align:left;"> &nbsp;&nbsp;รหัสเอกสาร : {{$data_requsition->paper_no}}</th>
                </tr>
                <tr>
                    <th class="border_table" style="width:150px;text-align:left;"> &nbsp;&nbsp;ครั้งที่แก้ไข : {{$data_requsition->edit_times}}</th>
                </tr>
                <tr>
                    <th class="border_table" style="width:150px;text-align:left;"> &nbsp;&nbsp;วันที่ประกาศใช้ : {{$date_receive}}</th>
                </tr>
                <tr>
                    <th class="border_table" style="width:150px;text-align:left;"> &nbsp;&nbsp;หน้า </th>
                </tr>
            </thead>
        </table>

        <script type="text/php">
            if ( isset($pdf) ) {

                $x = 730;
                $y = 87;
                $text = "{PAGE_NUM} จาก {PAGE_COUNT}";
                $font = $fontMetrics->get_font("THSarabunNew", "bold");
                $size = 12;
                $color = array(0,0,0);
                $word_space = 0.0;  //  default
                $char_space = 0.0;  //  default
                $angle = 0.0;   //  default
                $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            }
        </script>



        <div style="text-align: center;font-weight: bold;"> วันที่ : {{$date_receive}}</div>

        <table class="border_table">
            <tbody style="text-align: center">
                <tr>
                    <td class="border_table" style="width:30px" rowspan="2">ลำดับ</td>
                    <td class="border_table" style="width:120px" rowspan="2">รายการ</td>
                    <td class="border_table" style="width:150px" rowspan="2">Lot.</td>
                    <td class="border_table" style="width:350px" colspan="4">การเบิกวัตถุดิบ</td>
                    <td class="border_table" style="width:350px" colspan="4">การคืนวัตถุดิบ</td>
                    <td class="border_table" style="width:100px" rowspan="2">จำนวนเบิกจริง</td>
                </tr>
                <tr>
                    <td class="border_table">วันที่เบิก</td>
                    <td class="border_table">จำนวน</td>
                    <td class="border_table">ผู้เบิก</td>
                    <td class="border_table">ผู้ให้เบิก</td>

                    <td class="border_table">วันที่คืน</td>
                    <td class="border_table">จำนวน</td>
                    <td class="border_table">ผู้คืน</td>
                    <td class="border_table">ผู้รับคืน</td>
                </tr>

                @php
                    $count = 1;
                    function convert2Unit($weight){
                        $total_weight = floatval($weight);
                            $wunit = "กรัม";
                        if ($weight >= 1000000) {
                            $total_weight = floatval($weight/1000000) ;
                            $wunit = "ตัน";
                        } else if ($weight >= 1000) {
                            $total_weight = floatval($weight/1000) ;
                            $wunit = "กิโลกรัม";
                        }
                        echo $total_weight.' '.$wunit;
                    }
                @endphp
                <tr>
                @foreach ($data[0]->materialCutReturns as $data_one)
                    @php
                        $req_date = date_format(date_create($data_one->datetime),"d/m/Y");
                        $ret_date = date_format(date_create($data_one->r_date),"d/m/Y");

                        $req_total = $data_one->weight;
                        $ret_total = $data_one->weight_r;
                        $sum_total = $req_total - $ret_total;
                    @endphp
                        <td class="border_table">{{$count}}</td>
                        <td class="border_table">{{$data_one->materialLot->lot_no_pm}}</td>
                        <td class="border_table">{{$data_one->materialLot->lot}}</td>

                        <td class="border_table">{{$req_date}}</td>
                        <td class="border_table req_total">{{convert2Unit($req_total)}}</td>
                        @if ($data_one->createBy)
                            <td class="border_table">{{$data_one->createBy->employee->fname}}</td>
                        @else
                            <td class="border_table"></td>
                        @endif

                        @if ($data_one->updateBy)
                            <td class="border_table">{{$data_one->updateBy->employee->fname}}</td>
                        @else
                            <td class="border_table"></td>
                        @endif

                        <td class="border_table">{{$ret_date}}</td>
                        <td class="border_table ret_total">{{convert2Unit($ret_total)}}</td>
                        @if ($data_one->createBy)
                            <td class="border_table">{{$data_one->r_createBy}}</td>
                        @else
                            <td class="border_table"></td>
                        @endif

                        @if ($data_one->updateBy)
                            <td class="border_table">{{$data_one->r_updateBy}}</td>
                        @else
                            <td class="border_table"></td>
                        @endif

                        <td class="border_table">{{convert2Unit($sum_total)}}</td>
                    </tr>
                    @php
                        $count += 1;
                    @endphp
                @endforeach
            </tr>

            </tbody>
        </table>



</body>

</html>
