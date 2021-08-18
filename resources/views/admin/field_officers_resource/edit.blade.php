@extends('layouts.webBase')

@section('css')

@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        <div class="row center">
            <div class="col-lg-8 ">
                <div class="card">
                    <div class="card-header">
                        Edit Field Officer

                    </div>
                    <div class="card-body ">
                        <form method="POST" action="/field_officers/{{$user->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input class="form-control " value="{{ $user->name }}" required
                                            autocomplete="name" id="name" name="name" type="text">
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input class="form-control" value="{{ $user->email }}" required
                                            autocomplete="email" id="email" name="email" type="email">
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="contact_no">Contact Number</label>
                                        @foreach($user->user_contacts as $contact)
                                        <input class="form-control" value="{{ $contact->contact_no }}" required
                                            autocomplete="contact_no" id="contact_no" name="contact_no" type="number">

                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="officer_type">Officer Type</label>
                                    <select name="officer_type" class="form-control" id="officer_type"
                                        onChange="update()">
                                        <option value="barangay_captain">Barangay Captain</option>
                                        <option value="camp_manager">Camp Manager</option>
                                        <option value="courier">Courier</option>

                                    </select>

                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row" id='barangay'>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="barangay">Barangay</label>
                                        <input class="form-control" value="{{ $user->barangay }}"
                                            autocomplete="barangay" id="barangay" name="barangay" type="text">
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row" id='designation' style="display: none;">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="designation">Designation</label>
                                        <input class="form-control" value="{{ $user->designation }}"
                                            autocomplete="designation" id="designation" name="designation" type="text">
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="photo">Upload your Profile Picture</label>
                                        <div class="center">
                                            <svg class=" mr-2 image-icon ">
                                                <use xlink:href="{{ url('/icons/sprites/free.svg#cil-image1') }}"></use>
                                            </svg>

                                        </div>

                                        <input class="form-control" type="file" name="photo">
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input class="form-control" required autocomplete="password" id="password"
                                                name="password" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Confirm Password</label>
                                            <input class="form-control" required autocomplete="password" id="password"
                                                name="password" type="text">
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="row mt-5 center">
                                <div class="col-4 ">
                                    <button class="btn btn-primary px-4 " type="submit">{{ __('Update') }}</button>
                                </div>
                                <div class="col-4 ">
                                    <a href="{{url()->previous()}}"
                                        class="btn btn-outline-primary px-4 ">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
    </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
function update() {
    var select = document.getElementById('officer_type');
    if (select.value == 'barangay_captain') {
        document.getElementById('barangay').style.display = "block";
        document.getElementById('designation').style.display = "none";
    } else {
        document.getElementById('barangay').style.display = "none";
        document.getElementById('designation').style.display = "block";
    }
}
</script>
@endsection