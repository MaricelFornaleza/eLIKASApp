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
                            <div class="clearfix">
                                <div class="float-right"><strong>{{$data['sectors']['children']}}</strong> <small
                                        class="text-muted">({{($data['sectors']['children'] / $data['affected_residents']) *100}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{($data['sectors']['children']/$data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['sectors']['children']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Lactating</span>
                        </div>
                        <div class="progress-group-bars">
                            <div class="clearfix">
                                <div class="float-right"><strong>{{$data['sectors']['lactating']}}</strong> <small
                                        class="text-muted">({{($data['sectors']['lactating'] / $data['affected_residents']) *100}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{($data['sectors']['lactating']/$data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['sectors']['lactating']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">PWD</span></div>
                        <div class="progress-group-bars">
                            <div class="clearfix">
                                <div class="float-right"><strong>{{$data['sectors']['PWD']}}</strong> <small
                                        class="text-muted">({{($data['sectors']['PWD'] / $data['affected_residents']) *100}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{($data['sectors']['PWD']/$data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['sectors']['PWD']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Pregnant</span></div>
                        <div class="progress-group-bars">
                            <div class="clearfix">
                                <div class="float-right"><strong>{{$data['sectors']['pregnant']}}</strong> <small
                                        class="text-muted">({{($data['sectors']['pregnant'] / $data['affected_residents']) *100}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{($data['sectors']['pregnant']/$data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['sectors']['pregnant']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Senior Citizen</span>
                        </div>
                        <div class="progress-group-bars">
                            <div class="clearfix">
                                <div class="float-right"><strong>{{$data['sectors']['senior']}}</strong> <small
                                        class="text-muted">({{($data['sectors']['senior'] / $data['affected_residents']) *100}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{($data['sectors']['senior']/$data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['sectors']['senior']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Solo Parent</span>
                        </div>
                        <div class="progress-group-bars">
                            <div class="clearfix">
                                <div class="float-right"><strong>{{$data['sectors']['solo']}}</strong> <small
                                        class="text-muted">({{($data['sectors']['solo'] / $data['affected_residents']) *100}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{($data['sectors']['solo']/$data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['sectors']['solo']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>