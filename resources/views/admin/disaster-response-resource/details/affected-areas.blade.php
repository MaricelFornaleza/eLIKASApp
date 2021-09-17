<div class="col-md-12">
    <div class="card">
        <div class="card-header">Affected Areas</div>
        <div class="card-body">
            <table class="table table-responsive-sm table-hover table-outline mb-0">
                <thead class="thead-light">
                    <tr>

                        <th>Barangay</th>
                        <th>Total Residents</th>
                        <th>Evacuees</th>
                        <th>Non-evacuees</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['barangayData'] as $barangay)
                    <tr>
                        <td>
                            <div>{{$barangay['barangay']}}</div>
                            <div class="small text-muted">Naga City
                            </div>
                        </td>
                        <td>{{$barangay['total_residents']}}</td>
                        <td>
                            <div class="clearfix">
                                <div class="float-left"><strong>{{$barangay['evacuees']}}</strong></div>
                                <div class="float-right"><small
                                        class="text-muted">({{round((($barangay['evacuees'] / $barangay['total_residents']) *100), 2)}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar"
                                    style="width: {{round((($barangay['evacuees'] / $barangay['total_residents']) *100), 2)}}%"
                                    aria-valuenow="{{$barangay['evacuees']}}" aria-valuemin="0"
                                    aria-valuemax="{{$barangay['total_residents']}}"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="clearfix">
                                <div class="float-left"><strong>{{$barangay['non_evacuees']}}</strong></div>
                                <div class="float-right"><small
                                        class="text-muted">({{round((($barangay['non_evacuees'] / $barangay['total_residents']) *100), 2)}}%)</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{round((($barangay['non_evacuees'] / $barangay['total_residents']) *100), 2)}}%"
                                    aria-valuenow="{{$barangay['non_evacuees']}}" aria-valuemin="0"
                                    aria-valuemax="{{$barangay['total_residents']}}"></div>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>