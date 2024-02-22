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
            $date_requsition=date_format($date,"d/m/Y")
        @endphp

        <table class="border_table">
            <thead>
                <tr>
                    <th class="border_table" style="width:150px;" rowspan="4">
                        <img class="img-logo" src="{{public_path("uploads/company_logo/$com_logo")}}" alt="{{$com_logo}}">
                    </th>
                    <th class="border_table" style="width:750px;" rowspan="4"><h1>บันทึกการเบิกวัสดุสิ้นเปลือง</h1>  </th>
                    <th class="border_table" style="width:150px;text-align:left;"> &nbsp;&nbsp;รหัสเอกสาร : {{$data_requsition->paper_no}}</th>
                </tr>
                <tr>
                    <th class="border_table" style="width:150px;text-align:left;"> &nbsp;&nbsp;ครั้งที่แก้ไข : {{$data_requsition->edit_times}}</th>
                </tr>
                <tr>
                    <th class="border_table" style="width:150px;text-align:left;"> &nbsp;&nbsp;วันที่ประกาศใช้ : {{$date_requsition}}</th>
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

        <div style="text-align: center;font-weight: bold;"> วันที่รับสินค้า : {{$date_requsition}}</div>


        <table class="border_table">
            <tbody style="text-align: center">
                <tr>
                    <td class="border_table" style="width:30px" rowspan="1">ลำดับ</td>
                    <td class="border_table" style="width:300px" rowspan="1">รายการ</td>
                    <td class="border_table" style="width:200px" rowspan="1">วันที่</td>
                    <td class="border_table" style="width:100px" rowspan="1">Lot</td>
                    <td class="border_table" style="width:100px" rowspan="1">จำนวน</td>
                    <td class="border_table" style="width:100px" rowspan="1">ผู้เบิก</td>
                    <td class="border_table" style="width:100px" rowspan="1">สถานะ</td>
                    <td class="border_table" style="width:100px" rowspan="1">หมายเหตุ</td>
                </tr>

                @php
                    $count = 1;
                @endphp
                @foreach ($data as $data_one)

                    <tr>
                        <td class="border_table">{{$count}}</td>
                        <td class="border_table">{{$data_one->supplyLot->supply->name}}</td>
                        <td class="border_table">{{date_format($data_one->created_at,"d/m/Y");}}</td>
                        <td class="border_table">{{$data_one->supplyLot->lot}}</td>
                        <td class="border_table">{{number_format($data_one->qty)}} ชิ้น</td>

                        @if ($data_one->requsitionSupply->stockUser)
                            <td class="border_table">{{$data_one->requsitionSupply->stockUser->employee->fname}}</td>
                        @else
                            <td class="border_table">ไม่มีข้อมูล</td>
                        @endif
                        @if ($data_one->action == 1)
                            <td class="border_table">เบิกสำเร็จ</td>
                        @else
                            <td class="border_table">กำลังดำเนินการ</td>
                        @endif
                        <td class="border_table">{{$data_one->requsitionSupply->recap}}</td>

                    </tr>
                    @php
                        $count += 1;
                    @endphp
                @endforeach

            </tbody>
        </table>



</body>
</html>
