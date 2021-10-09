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
                        <h5>Import Excel to add Evacuation Centers</h5>

                    </div>
                    <div class="card-body ">
                        <div class="row">
                            @if(count($errors) > 0)
                            <div class="alert alert-danger col-12">
                                <h6>
                                    Upload error
                                </h6>
                            </div>
                            @endif

                        </div>
                        <form action="{{ route('evacuation-center.file.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row  center mt-3">
                                <div class="col-md-6 fileUpload">
                                    <input type="file" name="import_file" id="">

                                </div>
                            </div>
                            <div class="row mt-3 mb-5  center">
                                <div class="col-4 ">
                                    <button class="btn btn-primary  " type="submit">{{ __('Import') }}</button>
                                </div>
                            </div>
                        </form>
                        <h6><strong>Important note:</strong> The file must contain the following column name.</h6>
                        <table class="table">
                            <thead>
                                <tr class="font-weight-bold">
                                    <td>Column name</td>
                                    <td>Required?</td>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">evacuation_center_name</td>
                                    <td>Yes</td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">address</td>
                                    <td>Yes</td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">latitude</td>
                                    <td>Yes</td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">longitude</td>
                                    <td>Yes</td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">capacity</td>
                                    <td>Yes</td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">characteristics</td>
                                    <td>No</td>

                                </tr>
                            </tbody>
                        </table>

                        <h6><strong>Sample Import:</strong></h6>
                        <img class="" src="/assets/import-sample/evacuation center.png" style="width: 100%; ">



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