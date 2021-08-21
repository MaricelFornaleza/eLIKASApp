@extends('layouts.webBase')
@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-end"> 
                        <a href="{{ route('relief-recipient.create') }}" class="btn btn-info m-2">{{ __('Add Resident') }}</a>
                        </div>
                        <br>
                        <table class="table table-responsive table-striped ">
                        <thead>
                          <tr>
                            <th>NAME</th>
                            <th>ADDRESS</th>
                            <th>BIRTHDATE</th>
                            <th>SECTORAL CLASSIFICATION</th>
                            <th>GENDER</th>
                            <th>FAMILY REPRESENTATIVE</th>
                            <th></th>
                            <th>ACTIONS</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($relief_recipients as $relief_recipient)
                            <tr>
                              <td>{{ $relief_recipient->name }}</td>
                              <td>{{ $relief_recipient->address }}</td>
                              <td>{{ $relief_recipient->birthdate }}</td>
                              <td>{{ $relief_recipient->sectoral_classification }}</td>
                              <td>{{ $relief_recipient->gender }}</td>
                              <td>{{ $relief_recipient->family_representative }}</td>
                              <td></td>
                              <td>
                                <a  href="{{ url('/relief-recipient/' . $relief_recipient->id . '/edit') }}" class="btn btn-light"> <i class="cil-pencil"></i></a>
                              </td>
                              <td>
                                <form action="{{ route('relief-recipient.destroy', $relief_recipient->id ) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-light" ><i class="cil-trash"></i></button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $relief_recipients->links() }}
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection


@section('javascript')

@endsection