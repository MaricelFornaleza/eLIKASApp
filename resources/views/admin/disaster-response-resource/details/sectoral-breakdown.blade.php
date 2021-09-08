<div class="col-md-6">
    <div class="card">
        <div class="card-header">Sectoral Breakdown</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="c-callout c-callout-second"><small class="text-muted">Female</small>
                                <div class="text-value-lg">{{$data['female']}}</div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-6">
                            <div class="c-callout c-callout-fourth"><small class="text-muted">Male</small>
                                <div class="text-value-lg">{{$data['male']}}</div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                    <hr class="mt-0">
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Children</span></div>
                        <div class="progress-group-bars">

                            <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar"
                                    style="width: {{($data['children']/$data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['children']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Lactating</span>
                        </div>
                        <div class="progress-group-bars">

                            <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar"
                                    style="width: {{($data['lactating']/$data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['lactating']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">PWD</span></div>
                        <div class="progress-group-bars">

                            <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar"
                                    style="width: {{($data['PWD']/$data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['PWD']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Pregnant</span></div>
                        <div class="progress-group-bars">

                            <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar"
                                    style="width: {{($data['pregnant']/$data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['pregnant']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Senior Citizen</span>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar"
                                    style="width: {{($data['senior']/$data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['senior']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Solo Parent</span>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-danger" role="progressbar"
                                    style="width: {{($data['solo']/$data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['solo']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>