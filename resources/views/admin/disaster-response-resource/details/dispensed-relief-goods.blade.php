<div class="col-md-6">
    <div class="card">
        <div class="card-header">Relief Goods</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="c-callout c-callout-second"><small class="text-muted">Dispensed Relief
                                    Goods</small>
                                <div class="text-value-lg">{{$data['relief_goods']['count']}}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="c-callout c-callout-fourth"><small class="text-muted">Total Items</small>
                                <div class="text-value-lg">{{$data['total_items']}}</div>
                            </div>
                        </div>
                        <!-- /.col-->

                    </div>
                    <!-- /.row-->
                    <hr class="mt-0">
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Clothes</span></div>
                        <div class="progress-group-bars">
                            <div class="clearfix">
                                <div class="float-right"><strong>{{$data['relief_goods']['clothes']}}</strong> <small
                                        class="text-muted">({{round((($data['relief_goods']['clothes'] / $data['affected_residents']) *100),2)}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar"
                                    style="width: {{($data['relief_goods']['clothes'] / $data['affected_residents']) *100}}%"
                                    aria-valuenow="{{$data['relief_goods']['clothes']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>

                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">ESA</span>
                        </div>
                        <div class="progress-group-bars">
                            <div class="clearfix">
                                <div class="float-right">
                                    <strong>{{$data['relief_goods']['emergency_shelter_assistance']}}</strong> <small
                                        class="text-muted">({{round((($data['relief_goods']['emergency_shelter_assistance'] / $data['affected_residents']) *100),2)}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar"
                                    style="width: {{($data['relief_goods']['emergency_shelter_assistance'] / $data['affected_residents']) *100}}%"
                                    aria-valuenow="{{$data['relief_goods']['emergency_shelter_assistance']}}"
                                    aria-valuemin="0" aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Food Packs</span>
                        </div>
                        <div class="progress-group-bars">
                            <div class="clearfix">
                                <div class="float-right"><strong>{{$data['relief_goods']['food_packs']}}</strong> <small
                                        class="text-muted">({{round((($data['relief_goods']['food_packs'] / $data['affected_residents']) *100),2)}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar"
                                    style="width:{{($data['relief_goods']['food_packs'] / $data['affected_residents']) * 100}}%"
                                    aria-valuenow="{{$data['relief_goods']['food_packs']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Hygiene Kit</span></div>
                        <div class="progress-group-bars">
                            <div class="clearfix">
                                <div class="float-right"><strong>{{$data['relief_goods']['hygiene_kit']}}</strong>
                                    <small
                                        class="text-muted">({{round((($data['relief_goods']['hygiene_kit'] / $data['affected_residents']) *100),2)}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar"
                                    style="width: {{($data['relief_goods']['hygiene_kit'] / $data['affected_residents']) *100}}%"
                                    aria-valuenow="{{$data['relief_goods']['hygiene_kit']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Medicine</span></div>
                        <div class="progress-group-bars">
                            <div class="clearfix">
                                <div class="float-right"><strong>{{$data['relief_goods']['medicine']}}</strong> <small
                                        class="text-muted">({{round((($data['relief_goods']['medicine'] / $data['affected_residents']) *100),2)}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar"
                                    style="width: {{($data['relief_goods']['medicine'] / $data['affected_residents']) *100}}%"
                                    aria-valuenow="{{$data['relief_goods']['medicine']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-4">
                        <div class="progress-group-prepend"><span class="progress-group-text">Water</span>
                        </div>
                        <div class="progress-group-bars">
                            <div class="clearfix">
                                <div class="float-right"><strong>{{$data['relief_goods']['water']}}</strong> <small
                                        class="text-muted">({{round((($data['relief_goods']['water'] / $data['affected_residents']) *100),2)}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar"
                                    style="width: {{($data['relief_goods']['water'] / $data['affected_residents']) *100}}%"
                                    aria-valuenow="{{$data['relief_goods']['water']}}" aria-valuemin="0"
                                    aria-valuemax="{{$data['affected_residents']}}"></div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>