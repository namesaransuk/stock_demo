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



        <table class="border_table">
            <thead>
                <tr>
                    <th class="border_table" style="width:150px">
                        <img class="img-logo" src="{{public_path("uploads/company_logo/$com_logo")}}" alt="{{$com_logo}}">
                    </th>
                    <th class="border_table" style="width:900px"><h1>บันทึกการเบิกสินค้า</h1>  </th>
                </tr>
            </thead>
        </table>

        <br><br>

        <table class="border_table">
            <tbody style="text-align: center">
                <tr>
                    <td class="border_table" style="width:30px" rowspan="1">ลำดับ</td>
                    <td class="border_table" style="width:200px" rowspan="1">รายการ</td>
                    <td class="border_table" style="width:100px" rowspan="1">วันที่</td>
                    <td class="border_table" style="width:100px" rowspan="1">Lot</td>
                    <td class="border_table" style="width:100px" rowspan="1">จำนวน</td>
                    <td class="border_table" style="width:100px" rowspan="1">เลขที่ PO.</td>
                    <td class="border_table" style="width:100px" rowspan="1">สถานะ</td>
                    <td class="border_table" style="width:100px" rowspan="1">หมายเหตุ</td>
                    <td class="border_table" style="width:100px" rowspan="1">ฝ่ายขนส่ง</td>
                    <td class="border_table" style="width:100px" rowspan="1">ฝ่าย store</td>
                </tr>

                @php
                    $count = 1;
                @endphp
                @foreach ($data as $data_one)

                    <tr>
                        <td class="border_table">{{$count}}</td>
                        <td class="border_table">{{$data_one->productLot->product->name}}</td>
                        <td class="border_table">{{date_format($data_one->created_at,"d/m/Y");}}</td>
                        <td class="border_table">{{$data_one->productLot->lot}}</td>
                        <td class="border_table">{{number_format($data_one->qty)}} ชิ้น</td>
                        <td class="border_table">{{$data_one->requsitionProduct->paper_no}}</td>
                        @if ($data_one->requsitionProduct->paper_status == 3)
                        <td class="border_table">เบิกสำเร็จ</td>
                        @else
                        <td class="border_table">กำลังดำเนินการ</td>
                        @endif
                        <td class="border_table">{{$data_one->productLot->notation}}</td>
                        @if ($data_one->requsitionProduct->stockUser)
                            <td class="border_table">{{$data_one->requsitionProduct->stockUser->employee->fname}}</td>
                        @else
                            <td class="border_table">ไม่มีข้อมูล</td>
                        @endif
                        @if ($data_one->requsitionProduct->auditUser)
                            <td class="border_table">{{$data_one->requsitionProduct->auditUser->employee->fname}}</td>
                        @else
                            <td class="border_table">ไม่มีข้อมูล</td>
                        @endif


                    </tr>
                    @php
                        $count += 1;
                    @endphp
                @endforeach

            </tbody>
        </table>



</body>
</html>
