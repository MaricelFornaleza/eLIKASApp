<div class="row">
    <div class="col-6 col-lg-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="c-callout c-callout-first my-0 py-2">
                    <small class="text-muted ">Affected Barangay</small>
                    <div class="text-value-lg ">
                        <h1 class="p-0 m-0"><strong>{{$barangays->count()}}</strong> </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="c-callout c-callout-second my-0 py-2">
                    <small class="text-muted ">Affected Individuals</small>
                    <div class="text-value-lg ">
                        <h1 class="p-0 m-0"><strong>{{$data['affected_residents']}}</strong> </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="c-callout c-callout-third my-0 py-2">
                    <small class="text-muted ">Affected Families</small>
                    <div class="text-value-lg ">
                        <h1 class="p-0 m-0"><strong>{{$data['families']}}</strong> </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="c-callout c-callout-fourth my-0 py-2">
                    <small class="text-muted ">Dispensed Relief Goods</small>
                    <div class="text-value-lg ">
                        <h1 class="p-0 m-0"><strong>{{$data['relief_goods']['count']}}</strong> </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>