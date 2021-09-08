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
                    @foreach($barangays as $barangay)
                    <tr>
                        <td>
                            <div>{{$barangay->barangay}}</div>
                            <div class="small text-muted">Naga City
                            </div>
                        </td>
                        <td>90</td>
                        <td>
                            <div class="clearfix">
                                <div class="float-left"><strong>60</strong></div>
                                <div class="float-right"><small class="text-muted">(67%)</small></div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 67%"
                                    aria-valuenow="60" aria-valuemin="0" aria-valuemax="90"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="clearfix">
                                <div class="float-left"><strong>30</strong></div>
                                <div class="float-right"><small class="text-muted">(33%)</small></div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 33%"
                                    aria-valuenow="30" aria-valuemin="0" aria-valuemax="90"></div>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>