@extends('layouts.webBase')

@section('css')

@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        <div class="row center">
            <div class="col-lg-10 ">
                <div class="card">
                    <div class="card-header">
                        <h5>Import Excel to add Residents</h5>

                    </div>
                    <div class="card-body ">
                        <div class="row">
                            @if(count($errors) > 0)
                            <div class="alert alert-danger col-12">
                                <h6>
                                    Upload error
                                </h6>
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>

                            </div>
                            @endif

                        </div>
                        <div>
                            <form action="{{ url('/import/residents/store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row  center mt-3">
                                    <div class="col-md-6 fileUpload">
                                        <input type="file" name="import_file" id="">

                                    </div>
                                </div>
                                <div class="row mt-3 mb-5 center">
                                    <div class="col-4 ">
                                        <button class="btn btn-primary  " type="submit">{{ __('Import') }}</button>
                                    </div>
                                </div>



                            </form>
                        </div>
                        <h6><strong>Important note:</strong> The file must contain the following column name.</h6>

                        <table class="table">
                            <thead>
                                <tr class="font-weight-bold">
                                    <td>Column name</td>
                                    <td>Required?</td>
                                    <td>Format</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">name</td>
                                    <td>Yes</td>
                                    <td>First name MI. Last name</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">gender</td>
                                    <td>Yes</td>
                                    <td>Male or Female</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">birthdate</td>
                                    <td>Yes</td>
                                    <td>Y-m-d</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">sectoral_classification</td>
                                    <td>Yes</td>
                                    <td>Children, Lactating, Pregnant, Person with Disability, <br> Senior Citizen, Solo
                                        Parent, or None</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">is_family_head</td>
                                    <td>Yes</td>
                                    <td>Yes or No</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">street</td>
                                    <td>Yes</td>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">barangay</td>
                                    <td>Yes</td>
                                    <td>N/A</td>
                                </tr>
                            </tbody>
                        </table>
                        <h6><strong>Sample Import:</strong></h6>
                        <img class="" src="/assets/import-sample/residents.png" style="width: 100%; ">


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

@endsection