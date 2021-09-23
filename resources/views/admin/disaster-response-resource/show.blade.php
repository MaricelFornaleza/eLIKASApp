@extends('layouts.webBase')
@section('css')
<link href="{{ asset('css/disaster-response.css') }}" rel="stylesheet">

@endsection

@section('content')
<div class="container" id="content">
    <div class="row justify-content-center">
        <div class="col-md-11 ">
            <div class="card ">
                <img class="card-img-top " src="{{url('/assets/dr-cover/'.$disaster_response -> photo)}}"
                    alt="{{$disaster_response->disaster_type}}"
                    style="height: 150px; object-fit: cover;  object-position: 0% 70%;">
                <div class="card-img-overlay">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-5 ">{{$disaster_response->disaster_type}}</h4>
                            <h6 class="card-text mb-0">{{$disaster_response->description}}</h6>
                            <small class="card-text ">
                                {{ date('F j, Y', strtotime($disaster_response->date_started)) }}
                                @empty($disaster_response->date_ended)
                                @else
                                - {{ date('F j, Y', strtotime($disaster_response->date_started)) }}
                                @endempty
                            </small>
                        </div>

                        <div class="ml-auto mr-2">

                            <button class="btn btn-danger " onclick="generatePDF()">
                                Export to PDF
                            </button>

                        </div>

                    </div>


                </div>
            </div>
        </div>

        <div class="col-md-11">
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}
            </div>
            @endif
        </div>

        <div class="col-md-11">
            <div class="row">

                <div class="col-md-12">

                    @include('admin.disaster-response-resource.details.section1')


                    <!-- Affected Residents Chart -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <h4 class="card-title mb-0">Affected Residents</h4>
                                    <div class="small text-muted">
                                        {{ date('F Y', strtotime($disaster_response->date_started)) }}
                                    </div>
                                </div>
                                <!-- /.col-->

                            </div>
                            <!-- /.row-->
                            <div class="c-chart-wrapper" style="height:300px; max-width: 930px; margin-top:40px;">
                                <canvas class="chart" id="canvas-2" height="300"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row text-center justify-content-center">
                                <div class="col-sm-12 col-md-4 mb-sm-2 mb-0">
                                    <div class="text-muted">Evacuees</div><strong>{{$data['evacuees']}}
                                        ({{round((($data['evacuees'] / $data['affected_residents']) *100), 2)}}%)</strong>

                                    <div class="progress progress-xs mt-2">

                                        <div class="progress-bar bg-accent" role="progressbar"
                                            style="width: {{($data['evacuees'] / $data['affected_residents']) *100}}%"
                                            aria-valuenow="{{$data['evacuees']}}"
                                            aria-valuemin="{{$data['affected_residents']}}" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-sm-2 mb-0">
                                    <div class="text-muted">Non-evacuees</div><strong>{{$data['non-evacuees']}}
                                        ({{round((($data['non-evacuees'] / $data['affected_residents']) *100),2)}}%)</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{($data['non-evacuees'] / $data['affected_residents']) *100}}%"
                                            aria-valuenow="{{$data['non-evacuees']}}" aria-valuemin="0"
                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end Affected Residents Chart -->
                    <!-- section 3 -->
                    <div class="row" id="row">
                        <!-- Dispense Relief Goods -->
                        @include('admin.disaster-response-resource.details.dispensed-relief-goods')

                        <!-- Sectoral Classification -->
                        @include('admin.disaster-response-resource.details.sectoral-breakdown')
                    </div>
                    <!-- end section 3 -->
                </div>

                <!-- affected Areas -->
                @include('admin.disaster-response-resource.details.affected-areas')



                <!-- end affected areas -->

            </div>

        </div>


    </div>
</div>
@endsection
@section('javascript')
<script src="{{ asset('js/Chart.min.js') }}"></script>
<script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
<script src="{{ asset('js/reports-js/barChart.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
var chartData = <?php echo $chartData; ?>;
var chartData2 = <?php echo $chartData2; ?>;
var dates = <?php echo $dates; ?>;


function generatePDF() {
    var opt = {
        margin: [.20, 0, .20, 0],
        filename: 'Disaster_Response.pdf',
        image: {
            type: 'jpeg',
            quality: 1
        },
        html2canvas: {
            scale: 2
        },
        jsPDF: {
            unit: 'in',
            format: 'letter',
            orientation: 'portrait'
        },
        pagebreak: {
            mode: 'css',
            before: '#row'
        }

    };
    document.getElementById('canvas-2').style.width = '100%';
    element = document.getElementById('content');
    html2pdf().set(opt).from(element).toPdf().get('pdf').then(function(pdf) {
        window.open(pdf.output('bloburl'), '_blank');
    });

}
</script>
@endsection