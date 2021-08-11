@extends('layouts.webBase')
@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-end"> 
                        <a href="{{ route('evac.create') }}" class="btn btn-info m-2">{{ __('Add Evacuation Center') }}</a>
                        </div>
                        <br>
                        <table class="table table-responsive table-striped ">
                        <thead>
                          <tr>
                            <th>NAME</th>
                            <th>ADDRESS</th>
                            <th>CHARACTERISTICS</th>
                            <th>MANAGER</th>
                            <th>TOTAL CAPACITY</th>
                            <th>EVACUEES</th>
                            <th>MALE</th>
                            <th>FEMALE</th>
                            <th>LACTATING</th>
                            <th>PWD</th>
                            <th>SENIOR CITIZEN</th>
                            <th>CHILDREN</th>
                            <th>PREGNANT</th>
                            <th>SOLO PARENT</th>
                            <th></th>
                            <th>ACTIONS</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($evacuation_centers as $evacuation_center)
                            <tr>
                              <td>{{ $evacuation_center->name }}</td>
                              <td>{{ $evacuation_center->address }}</td>
                              <td>{{ $evacuation_center->characteristics }}</td>
                              <td></td>
                              <td>{{ $evacuation_center->capacity }}</td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td>
                                <a  href="{{ evac.edit }}" class="btn btn-light"> <i class="cil-pencil"></i></a>
                              </td>
                              <td>
                                <form action="{{ evac.delete }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-light" ><i class="cil-trash"></i></button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $evacuation_centers->links() }}
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection


@section('javascript')

@endsection