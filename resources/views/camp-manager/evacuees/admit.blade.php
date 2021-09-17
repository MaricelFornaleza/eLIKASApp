@extends('layouts.mobileBase')
@section('css')
<link href="{{ asset('css/sectoral-class.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <form method="POST" action="/camp-manager/admit" onsubmit="return validateForm()">
                @csrf
                <!-- Barangay Information  -->
                <div class="col-md-12 justify-content-center d-flex align-items-baseline p-0">
                    <div class="col-md-6 p-0 m-0">
                        <h5 class="font-weight-bold">List of Residents </h5>

                    </div>

                    <!-- <div class="col-5 text-right ">
                        <a href="">
                            <button class="btn btn-secondary secondary-button px-4 ">Add new</button>
                        </a>
                    </div> -->
                </div>


                <div class="col-md-12 center p-0">
                    <div class="input-group mt-4 col-md-6 p-0 m-0">
                        <!-- <span class="input-group-addon">Search</span> -->
                        <input type="text" name="search-text" id="search-text" placeholder="Search"
                            class="form-control ">
                    </div>
                </div>
                <div>
                    <div class="col-md-6 px-0 pt-4 mx-auto">
                        <ul id="result" class="list-group list-group-hover list-group-striped">
                            @foreach($family_members as $family_member)
                            <li class="list-group-item list-group-item-action ">
                                <div class="form-check">
                                    <input onchange="selected('{{$family_member->family_code}}',this);"
                                        class="form-check-input  @error('name') is-invalid @enderror checkbox {{$family_member->family_code}}"
                                        type="checkbox" value='{{$family_member->family_code}}'
                                        id="{{$family_member->family_code}}" name="checkedResidents[]">
                                    <label class="form-check-label" for="name0">
                                        {{$family_member->name}}
                                    </label>
                                    <span class="float-right my-2">
                                        @if($family_member->sectoral_classification == 'Children')
                                        <div class="rounded-circle children" style="height: 10px; width:10px;"></div>
                                        @elseif($family_member->sectoral_classification == 'Lactating')
                                        <div class="rounded-circle lactating" style="height: 10px; width:10px;"></div>
                                        @elseif($family_member->sectoral_classification == 'Person with Disability')
                                        <div class="rounded-circle pwd" style="height: 10px; width:10px;"></div>
                                        @elseif($family_member->sectoral_classification == 'Pregnant')
                                        <div class="rounded-circle pregnant" style="height: 10px; width:10px;"></div>
                                        @elseif($family_member->sectoral_classification == 'Senior Citizen')
                                        <div class="rounded-circle senior" style="height: 10px; width:10px;"></div>
                                        @elseif($family_member->sectoral_classification == 'Solo Parent')
                                        <div class="rounded-circle solo_parent" style="height: 10px; width:10px;"></div>
                                        @else
                                        <div class="rounded-circle none" style="height: 10px; width:10px;"></div>
                                        @endif
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="col-12 center mt-5 ">
                        <div class="col-md-6 p-0 ">
                            <button class="btn  btn-accent  px-4" type="submit">{{ __('Admit') }}</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 center mt-4">
                    <div class="col-md-6 mb-4 p-0">
                        <a href="/camp-manager/evacuees" class="btn btn-accent-outline  px-4">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
@endsection


@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>
$(document).ready(function() {
    $('#search-text').keyup(function() {
        var text = $(this).val();
        $.ajax({
            url: "search/evacuees",
            data: {
                text: text
            },
            dataType: 'json',
            beforeSend: function() {
                $('#result').html(
                    '<li class="list-group-item">Loading...</li>')
            },
            success: function(res) {
                console.log(res);
                var _html = '';
                $.each(res, function(index, data) {
                    _html +=
                        '<li class="list-group-item list-group-item-action ">' +
                        '<div class="form-check">' +
                        ' <input onchange="selected(\'' + data.family_code +
                        '\', this);"' +
                        'class="form-check-input checkbox ' + data.family_code +
                        ' "type = "checkbox" value = \'' + data.family_code +
                        '\' id="' + data.family_code +
                        '" name="checkedResidents[]">' +
                        '<label class="form-check-label" for="name0">' +
                        data.name +
                        '</label>' +
                        '<span class="float-right my-2"> <div class="rounded-circle bg-secondary" style="height: 10px; width:10px;"> </div>  </span>' +
                        '</div> </li>';
                });
                $('#result').html(_html);
            }

        })
    })
})

function selected(family_code, t) {
    $('input.' + family_code).prop('checked', t.checked);

}
</script>
@endsection