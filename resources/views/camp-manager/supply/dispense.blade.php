@extends('layouts.mobileBase')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!--  Title  -->
            <div class="col-md-12  p-0">
                <div class="col-md-6 mx-auto">
                    <h4 class="font-weight-bold">Dispense Supply</h4>
                </div>

            </div>
            <form method="POST" action="/camp-manager/dispense" onsubmit="return validateForm()">
                @csrf
                <!-- Select Disaster Response -->
                <div class="form-group col-sm-6 mx-auto">
                    <label for="disaster_response">Disaster Response</label>
                    <select name="disaster_response_id" class="form-control" id="disaster_response_id" required>
                        <option value="">Select</option>
                        @foreach($disaster_responses as $disaster_response)
                        <option value="{{ $disaster_response->id }}">Disaster Response
                            {{ $disaster_response->disaster_type }}
                        </option>
                        @endforeach
                    </select>

                </div>
                <!-- Select Relief Recipient -->
                <div class="form-group col-sm-6 mx-auto">
                    <label for="relief_recipient">Relief Recipient</label>
                    <select name="relief_recipient_family_code" class="form-control" id="relief_recipient">
                        <option value="">Select</option>
                        @foreach($evacuees as $evacuee)
                        <option value="{{$evacuee->rr_fc}}">{{$evacuee->name}}</option>
                        @endforeach

                    </select>
                </div>

                <!-- Supply Info Form -->
                <div class="supply-info mt-5 col-md-6 mx-auto">
                    <!-- title -->
                    <div class="row title px-3 font-weight-bold ">
                        <div class="col-7">
                            Supply Type
                        </div>
                        <div class="col-5 text-center">
                            Quantity
                        </div>
                    </div>

                    <!-- food packs input -->
                    <div class="form-group row px-3 mt-3">
                        <label class="col-7 col-form-label" for="food-qty">Food Packs</label>
                        <div class="col-5 text-right">
                            <div class="input-group">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-default btn-number p-1" disabled="disabled"
                                        data-type="minus" data-field="food_packs">
                                        <span class="iconify" data-icon="eva:minus-circle-outline"
                                            data-width="24"></span>
                                    </button>
                                </span>
                                <input type="text" id="food_packs" name="food_packs" class="form-control input-number"
                                    value="0" min="0" max="{{$stock_level->food_packs}}">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-default btn-number p-1 " data-type="plus"
                                        data-field="food_packs">
                                        <span class="iconify text-accent" data-icon="eva:plus-circle-outline"
                                            data-width="24"></span>

                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Water input -->
                    <div class="form-group row px-3 mt-3">
                        <label class="col-7 col-form-label" for="food-qty">Water</label>
                        <div class="col-5 text-right">
                            <div class="input-group">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-default btn-number p-1" disabled="disabled"
                                        data-type="minus" data-field="water">
                                        <span class="iconify" data-icon="eva:minus-circle-outline"
                                            data-width="24"></span>
                                    </button>
                                </span>
                                <input type="text" id="water" name="water" class="form-control input-number" value="0"
                                    min="0" max="{{$stock_level->water}}">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-default btn-number p-1 " data-type="plus"
                                        data-field="water">
                                        <span class="iconify text-accent" data-icon="eva:plus-circle-outline"
                                            data-width="24"></span>

                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Clothes input -->
                    <div class="form-group row px-3 mt-3">
                        <label class="col-7 col-form-label" for="food-qty">Clothes</label>
                        <div class="col-5 text-right">
                            <div class="input-group">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-default btn-number p-1" disabled="disabled"
                                        data-type="minus" data-field="clothes">
                                        <span class="iconify" data-icon="eva:minus-circle-outline"
                                            data-width="24"></span>
                                    </button>
                                </span>
                                <input type="text" id="clothes" name="clothes" class="form-control input-number"
                                    value="0" min="0" max="{{$stock_level->clothes}}">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-default btn-number p-1 " data-type="plus"
                                        data-field="clothes">
                                        <span class="iconify text-accent" data-icon="eva:plus-circle-outline"
                                            data-width="24"></span>

                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Hygiene Kit input -->
                    <div class="form-group row px-3 mt-3">
                        <label class="col-7 col-form-label" for="food-qty">Hygiene Kit</label>
                        <div class="col-5 text-right">
                            <div class="input-group">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-default btn-number p-1" disabled="disabled"
                                        data-type="minus" data-field="hygiene_kit">
                                        <span class="iconify" data-icon="eva:minus-circle-outline"
                                            data-width="24"></span>
                                    </button>
                                </span>
                                <input type="text" id="hygiene_kit" name="hygiene_kit" class="form-control input-number"
                                    value="0" min="0" max="{{$stock_level->hygiene_kit}}">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-default btn-number p-1 " data-type="plus"
                                        data-field="hygiene_kit">
                                        <span class="iconify text-accent" data-icon="eva:plus-circle-outline"
                                            data-width="24"></span>

                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Medicine input -->
                    <div class="form-group row px-3 mt-3">
                        <label class="col-7 col-form-label" for="food-qty">Medicine</label>
                        <div class="col-5 text-right">
                            <div class="input-group">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-default btn-number p-1" disabled="disabled"
                                        data-type="minus" data-field="medicine">
                                        <span class="iconify" data-icon="eva:minus-circle-outline"
                                            data-width="24"></span>
                                    </button>
                                </span>
                                <input type="text" id="medicine" name="medicine" class="form-control input-number"
                                    value="0" min="0" max="{{$stock_level->medicine}}">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-default btn-number p-1 " data-type="plus"
                                        data-field="medicine">
                                        <span class="iconify text-accent" data-icon="eva:plus-circle-outline"
                                            data-width="24"></span>

                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Shelter Assistance input -->
                    <div class="form-group row px-3 mt-3">
                        <label class="col-7 col-form-label" for="food-qty">Emergency Shelter Assistance</label>
                        <div class="col-5 text-right">
                            <div class="input-group">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-default btn-number p-1" disabled="disabled"
                                        data-type="minus" data-field="emergency_shelter_assistance">
                                        <span class="iconify" data-icon="eva:minus-circle-outline"
                                            data-width="24"></span>
                                    </button>
                                </span>
                                <input type="text" id="emergency_shelter_assistance" name="emergency_shelter_assistance"
                                    class="form-control input-number" value="0" min="0"
                                    max="{{$stock_level->emergency_shelter_assistance}}">
                                <span class="input-group-btn ">
                                    <button type="button" class="btn btn-default btn-number p-1 " data-type="plus"
                                        data-field="emergency_shelter_assistance">
                                        <span class="iconify text-accent" data-icon="eva:plus-circle-outline"
                                            data-width="24"></span>

                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Buttons -->
                <div class="col-12 center mt-5 ">
                    <div class="col-md-6 p-0 ">
                        <button class="btn  btn-accent  px-4" type="submit">{{ __('Dispense') }}</button>
                    </div>
                </div>
                <div class="col-12 center mt-4">
                    <div class="col-md-6 mb-4 p-0">
                        <a href="/camp-manager/supply-view" class="btn btn-accent-outline  px-4">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
        </div>
    </div>
    </form>
</div>
</div>
@endsection
@section('javascript')
<script src="https://code.iconify.design/2/2.0.3/iconify.min.js"></script>

<script>
$('.btn-number').click(function(e) {
    e.preventDefault();

    fieldName = $(this).attr('data-field');
    type = $(this).attr('data-type');
    var input = $("input[name='" + fieldName + "']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if (type == 'minus') {

            if (currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            }
            if (parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if (type == 'plus') {

            if (currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if (parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function() {
    $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {

    minValue = parseInt($(this).attr('min'));
    maxValue = parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());

    name = $(this).attr('name');
    if (valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if (valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }


});
$(".input-number").keydown(function(e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
        // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
        // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
</script>
@endsection