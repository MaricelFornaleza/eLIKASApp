<table id="requestTable"
    class="table table-borderless table-hover table-light table-striped" 
    style="width: 100%;">
    <thead>
        <tr>
            <th>TIME RECEIVED</th>
            <th>REQUEST ID</th>
            <th>CAMP MANAGER NAME</th>
            <th>EVACUATION CENTER</th>
            <th>FOOD PACKS</th>
            <th>WATER</th>
            <th>HYGIENE KIT</th>
            <th>CLOTHES</th>
            <th>MEDICINE</th>
            <th>EMERGENCY SHELTER ASSISTANCE</th>
            <th>NOTE</th>
            <th>STATUS</th>
            
            <th>ACTIONS</th>
            
        </tr>
    </thead>
    <tbody id="request-tbody">
        <div id="request-wrapper">
            @foreach($delivery_requests as $delivery_request)
            <tr>
                <td>{{date('g:i a m/d/Y', strtotime($delivery_request->updated_at)) }}</td>
                <td>{{ $delivery_request->id }}</td>
                <td>{{ $delivery_request->camp_manager_name }}</td>
                <td>{{ $delivery_request->evacuation_center_name }}</td>
                <td>{{ $delivery_request->food_packs }}</td>
                <td>{{ $delivery_request->water }}</td>
                <td>{{ $delivery_request->hygiene_kit }}</td>
                <td>{{ $delivery_request->clothes }}</td>
                <td>{{ $delivery_request->medicine }}</td>
                <td>{{ $delivery_request->emergency_shelter_assistance }}</td>
                <td>{{ $delivery_request->note }}</td>
                @if( $delivery_request->status == 'pending' )
                <td>
                    <div class="badge badge-pill bg-secondary-accent text-white">
                        {{ strtoupper($delivery_request->status) }}
                    </div>
                </td>
                <td>
                    <div class="row">
                        <div class="col-6 ">
                            <a href="{{ route('request.approve', ['id' => $delivery_request->id] ) }}" onclick="return confirm('Are you sure to approve the request?')">
                                {{-- <img class="c-icon" src="{{ url('icons/sprites/accept-request.svg') }}" /> --}}
                                <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg">
                                    <image href="{{ url('icons/sprites/approve-request.svg') }}" height="25" width="25"/>
                                </svg>
                            </a>
                        </div>
                        <div class="col-6">
                            {{-- <form action="" method="post">
                                @csrf
                                @method("DELETE")
                                <button type="submit" value="Delete" name="submit" class="btn-borderless" onclick="return confirm('Are you sure to delete?')">
                                    <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg">
                                        <image href="{{ url('icons/sprites/decline-request.svg') }}" height="25" width="25"/>
                                    </svg>
                                </button>
                            </form> --}}
                            <a href="{{ route('request.admin_decline', ['id' => $delivery_request->id] ) }}" onclick="return confirm('Are you sure to decline the request?')">
                                <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg">
                                    <image href="{{ url('icons/sprites/decline-request.svg') }}" height="25" width="25"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </td>
                @elseif( $delivery_request->status == 'preparing' && empty($delivery_request->courier_id))
                <td>
                    <span class="badge badge-pill bg-accent text-white">
                        {{ strtoupper($delivery_request->status) }}
                    </span>
                </td>
                <td>
                    <div class="row">
                        <div class="col-6 ">
                            <a href="" data-toggle="modal" data-target="#assignModal" data-evac-id="{{ $delivery_request->evacuation_center_id }}">
                                {{-- <img class="c-icon" src="{{ url('icons/sprites/accept-request.svg') }}" /> --}}
                                <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg">
                                    <image href="{{ url('icons/sprites/assign-courier.svg') }}" height="25" width="25"/>
                                </svg>
                            </a>
                            <!-- Button trigger modal -->
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Launch demo modal
                            </button> --}}
                            
                            <!-- Modal -->
                            <div class="modal" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        {{-- <h5 class="modal-title" id="exampleModalLabel">Assign Courier</h5> --}}
                                        <form method="POST" action="{{ route('request.assign_courier', ['id' => $delivery_request->id] ) }}">
                                            @csrf
                                            <label for="courier_id" class="mr-3 lead modal-title" id="exampleModalLabel">Assign Courier</label>
                                            <select name="courier_id" id='courier_id' class="w-100 form-control" required>
                                                {{-- <option value=''>Select User</option> --}}
                                                {{-- @foreach($couriers as $courier)
                                                <option value='{{ $courier->id }}'>
                                                    {{ $courier->name }}
                                                </option>
                                                @endforeach --}}
                                            </select>

                                            <input type="submit" id="submit-form" class="hidden d-none" />
                                        </form>

                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>   
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="w-100" id="mapid"></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        {{-- <button type="button" class="btn btn-warning">Assign</button> --}}
                                        <label for="submit-form" class="btn btn-warning" tabindex="0">Assign</label>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('request.cancel', ['id' => $delivery_request->id] ) }}" onclick="return confirm('Are you sure to cancel the request?')">
                                <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg">
                                    <image href="{{ url('icons/sprites/decline-request.svg') }}" height="25" width="25"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </td>
                @elseif( $delivery_request->status == 'preparing' && !empty($delivery_request->courier_id) )
                <td>
                    <span class="badge badge-pill bg-accent text-white">
                        {{-- {{ strtoupper($delivery_request->status) }} --}}
                        PREPARING
                    </span>
                </td>
                <td>
                    <div class="row">
                        <div class="col-6 ">
                        </div>
                        <div class="col-6">
                            <a href="{{ route('request.cancel', ['id' => $delivery_request->id] ) }}" onclick="return confirm('Are you sure to cancel the request?')">
                                <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg">
                                    <image href="{{ url('icons/sprites/decline-request.svg') }}" height="25" width="25"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </td>
                @elseif( $delivery_request->status == 'in-transit' )
                <td>
                    <span class="badge badge-pill bg-secondary text-white">
                        {{ strtoupper($delivery_request->status) }}
                    </span>
                </td>
                <td>
                </td>
                @elseif( $delivery_request->status == 'delivered' )
                <td>
                    <span class="badge badge-pill badge-primary text-white">
                        {{ strtoupper($delivery_request->status) }}
                    </span>
                </td>
                <td>
                </td>
                @elseif( $delivery_request->status == 'declined' || $delivery_request->status == 'cancelled')
                <td>
                    <span class="badge badge-pill badge-danger text-white">
                        {{ strtoupper($delivery_request->status) }}
                    </span>
                </td>
                <td>
                </td>
                @endif
            </tr>
            @endforeach
        </div>
    </tbody>
</table>