@extends('adminlte::page')

@section('css')
    <style>
        .print-page {
            display: grid;
            grid-template-rows: repeat(2, 1fr);
            grid-template-columns: repeat(3, 1fr);
            /* gap: 10px; */
            padding: 10px;
        }

        .print-item {
            border: 1px solid #000;
            border-style: dashed;
            padding: 10px;
            text-align: center;
        }

        @media print {
            @page {
                size: landscape;
                margin: 0;
            }

            .print-page {
                display: grid;
                grid-template-rows: repeat(2, 1fr);
                grid-template-columns: repeat(3, 1fr);
                page-break-before: always;
                padding-top: 10px;
                /* gap: 10px; */
            }

            .print-item {
                border: 1px solid #000;
                border-style: dashed;
                padding: 0;
                text-align: center;
                page-break-inside: avoid;
            }
        }
    </style>
@endsection

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/material/update/lot-no-pm') }}">LOT NO PM วัตถุดิบ</a></li>
                    <li class="breadcrumb-item active">พิมพ์ใบกักกัน</li>
                </ol>
            </div>
            {{-- <div>
                <br>
                <a class="btn ogn-stock-yellow " href="{{ route('receive.material.create') }}"><i class="fa fa-plus-circle"
                        aria-hidden="true"></i> เพิ่มรายการ</a>
            </div> --}}
            <div class="ml-auto">
                <br>
                <button type="button" class="btn bg-warning" id="btn-print" onclick="javascript:window.print();"><i
                        class="fa fa-print" aria-hidden="true"></i>
                    พิมพ์ใบกักกัน</button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="print-page">
        @php
            $totalCount = 0;
        @endphp
        @foreach ($materials as $material)
            @foreach ($material->materialLots as $materialLot)
                @php
                    $totalCount++;

                    $total_weight = $materialLot->weight_total;
                    $wunit = 'กรัม';
                    if ($total_weight >= 1000000) {
                        $total_weight = $total_weight / 1000000;
                        $wunit = 'ตัน';
                    } elseif ($total_weight >= 1000) {
                        $total_weight = $total_weight / 1000;
                        $wunit = 'กิโลกรัม';
                    }
                @endphp

                <div class="text-center px-3 py-4 print-item">
                    <div class="col-12">
                        <div class="row justify-content-center align-items-center">
                            <img width="90" src="{{ asset('images/orgreencut-pv.png') }}" alt="">
                            <h5 class="pl-3 pt-2">ป้ายกักกันที่ {{ $materialLot->id }} / {{ $totalCount }}</h5>
                        </div>
                    </div>
                    <div class="col mt-3 text-left">
                        <p class="font-weight-bold text-center">ชื่อสินค้า :
                            ............................................................
                        </p>
                    </div>
                    <div class="mt-2">
                        <div class="row">
                            <div class="col-7 text-left">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                        id="checkMaterial{{ $materialLot->id }}">
                                    <label class="custom-control-label small pt-1"
                                        for="checkMaterial{{ $materialLot->id }}">วัตถุดิบ</label>
                                </div>
                            </div>
                            <div class="col-5 text-left">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                        id="checkPackaging{{ $materialLot->id }}">
                                    <label class="custom-control-label small pt-1"
                                        for="checkPackaging{{ $materialLot->id }}">วัสดุบรรจุ/บรรจุภัณฑ์</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7 text-left">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                        id="checkProduct{{ $materialLot->id }}">
                                    <label class="custom-control-label small pt-1"
                                        for="checkProduct{{ $materialLot->id }}">ผลิตภัณฑ์เสริมอาหารสำเร็จรูป</label>
                                </div>
                            </div>
                            <div class="col-5 text-left">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                        id="checkCosmetic{{ $materialLot->id }}">
                                    <label class="custom-control-label small pt-1"
                                        for="checkCosmetic{{ $materialLot->id }}">เครื่องสำอางสำเร็จรูป</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7 text-left">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                        id="checkSupplement{{ $materialLot->id }}">
                                    <label class="custom-control-label small pt-1"
                                        for="checkSupplement{{ $materialLot->id }}">วัสดุสิ้นเปลือง</label>
                                </div>
                            </div>
                            <div class="col-5 text-left">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                        id="checkOther{{ $materialLot->id }}">
                                    <label class="custom-control-label small pt-1"
                                        for="checkOther{{ $materialLot->id }}">อื่นๆ
                                        ระบุ
                                        .................</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 text-left mx-auto">
                        <div class="col-12">
                            <small>ชื่อ : {{ $materialLot->receive_mat_name }}</small>
                        </div>
                        <div class="col-12">
                            <small>Lot.No : {{ $materialLot->lot_no_pm }}</small>
                        </div>
                        <div class="col-12">
                            <small>จำนวน : {{ $total_weight }} {{ $wunit }}</small>
                        </div>
                        <div class="col-6">
                            <small>MFG : {{ $materialLot->mfg }}</small>
                        </div>
                        <div class="col-6">
                            <small>EXP : {{ $materialLot->exp }}</small>
                        </div>
                        <div class="col-12">
                            <small>หมายเหตุ : Lot ใหม่</small>
                        </div>
                        <div class="col-6">
                            <small>ผู้กักกัน : ....................................</small>
                        </div>
                        <div class="col-6">
                            <small>วันที่ : .........................................</small>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
@stop

@section('js')'
    <script>
        $(document).ready(function() {
            // $.ajax({
            //     type: "post",
            //     url: "{{ route('api.v1.receive.material.print') }}",
            //     data: {
            //         company_id: {{ session('company') }},
            //     },
            //     dataType: "json",
            //     success: function(response) {
            //         if (response && response.length > 0) {
            //             // วนลูปผ่านข้อมูลที่ได้รับ
            //             $.each(response, function(index, item) {
            //                 if (item.material_lots && item.material_lots.length > 0) {
            //                     $.each(item.material_lots, function(i, lot) {
            //                         var matNameElement = $("#mat_name");
            //                         var receiveMatName = lot.receive_mat_name;
            //                         matNameElement.append(receiveMatName);
            //                         console.log(receiveMatName);
            //                     });
            //                 }
            //             });
            //         }
            //     }
            // });
        })
    </script>
@endsection
