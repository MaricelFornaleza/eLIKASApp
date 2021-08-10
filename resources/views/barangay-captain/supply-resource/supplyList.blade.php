@extends('layouts.webBase')
@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-end"> 
                        <a href="{{ route('supplies.create') }}" class="btn btn-info m-2">{{ __('Add Supply') }}</a>
                        </div>
                        <br>
                        <table class="table table-responsive table-striped ">
                        <thead>
                          <tr>
                            <th>DATE</th>
                            <th>SUPPLY_TYPE</th>
                            <th>QUANTITY</th>
                            <th>SOURCE</th>
                            <th></th>
                            <th>ACTIONS</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($supplies as $supply)
                            <tr>
                              <td>{{ $supply->created_at }}</td>
                              <td>{{ $supply->supply_type }}</td>
                              <td>{{ $supply->quantity }}</td>
                              <td>{{ $supply->source }}</td>
                              <td></td>
                              <td>
                                <a  href="{{ url('/supplies/' . $supply->id . '/edit') }}" class="btn btn-light"> <i class="cil-pencil"></i></a>
                              </td>
                              <td>
                                <form action="{{ route('supplies.destroy', $supply->id ) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-light" ><i class="cil-trash"></i></button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $supplies->links() }}
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection


@section('javascript')

@endsection