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
                        <h5>Import Excel to add Evacuation Centers</h5>

                    </div>
                    <div class="card-body ">
                        <h6>To add more than one evacuation center, you can upload an excel file.</h6>
                        <div class="row">
                            @if(count($errors) > 0)
                            <div class="alert alert-danger col-12">
                                <h6>
                                    Upload Validation error
                                </h6>
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mx-4">
                                <code>Important note: The file must contain the following format.</code>
                            </div>
                            @endif

                        </div>
                        
                        <form action="{{ route('evacuation-center.file.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mx-1 mt-5 mb-5">
                                <input type="file" name="import_file" id="">
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <button class="btn btn-primary" type="submit">{{ __('Import') }}</button>
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
    if (select.value == 'Barangay Captain') {
        document.getElementById('barangay').style.display = "block";
        document.getElementById('designation').style.display = "none";
    } else {
        document.getElementById('barangay').style.display = "none";
        document.getElementById('designation').style.display = "block";
    }
}



$(document).ready(function(e) {
    $('#photo').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
});
</script>
@endsection