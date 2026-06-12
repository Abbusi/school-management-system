<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Dashboard @endsection
<!-- End block -->
@section('extraStyle')
    <style>
        .notification li {
            font-size: 16px;
        }
        .notification li.info span.badge {
            background: #00c0ef;
        }
        .notification li.warning span.badge {
            background: #f39c12;
        }
        .notification li.success span.badge {
            background: #00a65a;
        }
        .notification li.error span.badge {
            background: #dd4b39;
        }
        .total_bal {
            margin-top: 5px;
            margin-right: 5%;
        }
    </style>
@endsection
<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Main content -->
    <section class="content">
        @if($userRoleId == AppHelper::USER_ADMIN)
            <div class="stat-grid">
                <!-- Students Card -->
                <x-kpi-card 
                    :link="URL::route('student.index')" 
                    :count="$students" 
                    label="Students" 
                    :delta="$studentDelta"
                />

                <!-- Teachers Card -->
                <x-kpi-card 
                    :link="URL::route('teacher.index')" 
                    :count="$teachers" 
                    label="Teachers" 
                    :delta="$teacherDelta"
                />

                <!-- Employees Card -->
                <x-kpi-card 
                    :link="URL::route('hrm.employee.index')" 
                    :count="$employee" 
                    label="Employees" 
                    :delta="$employeeDelta"
                />

                <!-- Subjects Card -->
                <x-kpi-card 
                    :link="URL::route('academic.subject')" 
                    :count="$subjects" 
                    label="Subjects" 
                    :delta="$subjectDelta"
                />
            </div>
        @endif

        @if($userRoleId != AppHelper::USER_STUDENT)
        <div class="row">
            {{--<div class="col-md-6">--}}
            {{--<div class="box box-primary">--}}
            {{--<div class="box-body">--}}
            {{--<!-- THE CALENDAR -->--}}
            {{--<div id="calendar"></div>--}}
            {{--</div>--}}
            {{--<!-- /.box-body -->--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border x_title">
                        <h3>Students Today's Attendance</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body" style="max-height: 342px;">
                        <canvas id="attendanceChart" style="width: 821px; height: 150px;"></canvas>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        @endif
        @if($userRoleId == AppHelper::USER_STUDENT)
            <div class="row">
                <div class="col-md-3 col-md-offset-4">
                <div class="callout callout-success text-center">
                    <h3>Welcome to CloudSchool</h3>
                    <p>Lot's of things are coming soon...</p>
                </div>
                </div>
            </div>
        @endif

    </section>
    <!-- /.content -->
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <script src="{{asset('js/dashboard.js')}}"></script>
    <script type="text/javascript">
        @if($userRoleId != AppHelper::USER_STUDENT)
            window.attendanceLabel = @php echo json_encode(array_keys($attendanceChartPresentData)) @endphp;
            window.presentData = @php echo json_encode(array_values($attendanceChartPresentData)) @endphp;
            window.absentData = @php echo json_encode(array_values($attendanceChartAbsentData)) @endphp;
        @endif

        $(document).ready(function () {
            Dashboard.init();

        });

    </script>
@endsection
<!-- END PAGE JS-->
