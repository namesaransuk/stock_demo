@extends('adminlte::page')

@section('css')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" /> --}}

    <style>
        .fc-content{
            font-size: 15px;
            color: white;
        }

        .fc-toolbar{
            font-size: 12px !important;
        }
        .fc-toolbar .fc-left h2{
            font-size: 22px !important;
        }
        .fc-day-number {
            font-size: 15px;
            padding: 10px !important;
        }


    </style>

@endsection

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าแรก</a></li>
                <li class="breadcrumb-item active">กำหนดแผนงาน</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-gdp">
            <div class="card-header ogn-stock-yellow text-left" >
                    <h6 class="m-0"> กำหนดแผนงาน </h6>
                </div>

            <div class="card-body p-0">
                <div id="calendar" style="padding: 0px;">

                </div>
            </div>
        </div>

    </div>
</div>


@endsection

@section('js')

    {{-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/th.min.js"></script>
<script>

    $(document).ready(function () {

        var seturl = "{{ url('/') }}";

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#calendar').fullCalendar({
            editable:true,
            events: seturl+'/set_plan/list',
            selectable:true,
            selectHelper: true,
            displayEventTime: true,
            height: 700,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            select:function(start, end, allDay)
            {
                var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');

                var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

                console.log(start);
                Swal.fire({
                    title: 'กำหนดแผนงาน',
                    html: `
                        <input type="text" id="event" class="swal2-input" placeholder="กำหนดงาน">
                        <input type="color" id="event_color" class="swal2-input">

                        `,
                    confirmButtonText: 'ตกลง',
                    focusConfirm: false,
                    preConfirm: () => {
                        const event = Swal.getPopup().querySelector('#event').value;
                        const color = Swal.getPopup().querySelector('#event_color').value;
                        if (!event) {
                            Swal.showValidationMessage(`กรุณากรอกข้อมูล`)
                        }
                        return { event: event ,color: color}
                    }
                }).then((result) => {
                    $.ajax({
                        url: seturl+"/set_plan/crud",
                        type:"POST",
                        data:{
                            title: result.value.event,
                            color: result.value.color,
                            start: start,
                            end: end,
                            type: 'add'
                        },
                        success:function(data)
                        {
                            calendar.fullCalendar('refetchEvents');
                            Swal.fire({
                                icon: 'success',
                                title: 'กำหนดงานเรียบร้อย',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    })
                })
            },

            eventDrop: function (event, delta) {
                var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

                $.ajax({
                    url: seturl+"/set_plan/crud",
                    data: {
                        title: event.title,
                        start: event_start,
                        end: event_end,
                        id: event.id,
                        type: 'edit'
                    },
                    type: "POST",
                    success: function (response) {
                        calendar.fullCalendar('refetchEvents');
                    }
                });
            },
            eventClick: function (event) {
                Swal.fire({
                title: 'ต้องการลบงานนี้ออกใช่ไหม!!',
                text: event.title,
                showCancelButton: true,
                confirmButtonText: 'ลบ',
                confirmButtonColor: 'red',
                cancelButtonText: 'ปิด',
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: seturl+"/set_plan/crud",
                            data: {
                                id: event.id,
                                type: 'delete'
                            },
                            success: function (response) {
                                calendar.fullCalendar('removeEvents', event.id);

                            }
                        });
                    }
                })

            }

        });
    });


</script>

@endsection
