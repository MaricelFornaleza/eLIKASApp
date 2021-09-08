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
                        <h5>Import Excel to add Residents</h5>

                    </div>
                    <div class="card-body ">
                        <h6>To add more than one resident, you can upload an excel file.</h6>
                        <div class="row">
                            @if(count($errors) > 0)
                            <div class="alert alert-danger col-12">
                                <h6>
                                    Upload error
                                </h6>

                            </div>
                            @endif

                        </div>
                        <code>Important note: The file must contain the folowing format.</code>
                        <ul>

                            <li><strong>name</strong><code>*</code></li>
                            <li><strong>gender</strong><code>*</code></li>
                            <li><strong>birthdate</strong><code>*</code> - format: Y-m-d (1999-12-29)</li>
                            <li><strong>sectoral_classification</strong><code>*</code></li>
                            <li><strong>is_family_head</strong><code>*</code></li>
                            <li><strong>street</strong><code>*</code></li>
                            <li><strong>barangay</strong><code>*</code></li>


                        </ul>
                        <form action="{{ url('/import/residents/store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row  center mt-5">
                                <div class="col-md-6 fileUpload">
                                    <input type="file" name="import_file" id="">

                                </div>
                            </div>
                            <div class="row mt-5 center">
                                <div class="col-4 ">
                                    <button class="btn btn-primary  " type="submit">{{ __('Import') }}</button>
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

@endsection