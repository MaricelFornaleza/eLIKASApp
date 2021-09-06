<template>
    <table id="requestList"
        class="table table-borderless table-hover table-light table-striped" 
        style="width: 100%;">
        <thead>
            <tr>
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
            <tbody id="request-body">
                
                @foreach($delivery_requests as $delivery_request)
                <tr v-for="request in requests" :key="request.id">
                    <td>{{ request.id }}</td>
                    <td>{{ request.camp_manager_name }}</td>
                    <td>{{ request.evacuation_center_name }}</td>
                    <td>{{ request.food_packs }}</td>
                    <td>{{ request.water }}</td>
                    <td>{{ request.hygiene_kit }}</td>
                    <td>{{ request.clothes }}</td>
                    <td>{{ request.medicine }}</td>
                    <td>{{ request.emergency_shelter_assistance }}</td>
                    <td>{{ request.note }}</td>
                    <!-- @if( request.status == 'pending' ) -->
                    <template v-if="request.status == 'pending'">
                        <td>
                            <div class="badge badge-pill bg-secondary-accent text-white">
                                {{ strtoupper(request.status) }}
                            </div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-6 ">
                                    <a v-on:click="goto_route(request.id, 'approve')">
                                        <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg">
                                            <image src="icons/sprites/approve-request.svg" height="25" width="25"/>
                                        </svg>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a v-on:click="goto_route(request.id, 'decline')">
                                        <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg">
                                            <image src="url('icons/sprites/decline-request.svg')" height="25" width="25"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </template>
                    
                    <template v-else-if="request.status == 'preparing' && empty(request.courier_id)">
                        <!-- @elseif( request.status == 'preparing' && empty(request.courier_id)) -->
                        <td>
                            <span class="badge badge-pill bg-accent text-white">
                                {{ strtoupper(request.status) }}
                            </span>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-6 ">
                                    <a href="" data-toggle="modal" data-target="#assignModal" data-evac-id="{{ request.evacuation_center_id }}">
                                        <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg">
                                            <image src="icons/sprites/assign-courier.svg" height="25" width="25"/>
                                        </svg>
                                    </a>
        
                                    <!-- Modal -->
                                    <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <form method="POST" v-on:click="submit_form(request.id)">
                                                    <!-- @csrf -->
                                                    <label for="courier_id" class="mr-3 lead modal-title" id="exampleModalLabel">Assign Courier</label>
                                                    <select name="courier_id" id='courier_id' class="w-100 form-control" required>
                                                        
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
                                                
                                                <label for="submit-form" class="btn btn-warning" tabindex="0">Assign</label>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <a v-on:click="goto_route(request.id, 'cancel')" onclick="return confirm('Are you sure to cancel the request?')">
                                        <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg">
                                            <image href="{{ url('icons/sprites/decline-request.svg') }}" height="25" width="25"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </template>
                    
                    <!-- @elseif( request.status == 'preparing' && !empty(request.courier_id) )
                    <td>
                        <span class="badge badge-pill bg-accent text-white">
                            {{-- {{ strtoupper(request.status) }} --}}
                            PREPARING
                        </span>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-6 ">
                            </div>
                            <div class="col-6">
                                <a href="{{ route('request.cancel', ['id' => request.id] ) }}" onclick="return confirm('Are you sure to cancel the request?')">
                                    <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg">
                                        <image href="{{ url('icons/sprites/decline-request.svg') }}" height="25" width="25"/>
                                    </svg>
                                </a>
                            </div>
                            </form>
                        </div>
                    </td>
                    @elseif( request.status == 'in-transit' )
                    <td>
                        <span class="badge badge-pill bg-secondary text-white">
                            {{ strtoupper(request.status) }}
                        </span>
                    </td>
                    <td>
                    </td>
                    @elseif( request.status == 'delivered' )
                    <td>
                        <span class="badge badge-pill badge-primary text-white">
                            {{ strtoupper(request.status) }}
                        </span>
                    </td>
                    <td>
                    </td>
                    @elseif( request.status == 'declined' || request.status == 'cancelled')
                    <td>
                        <span class="badge badge-pill badge-danger text-white">
                            {{ strtoupper(request.status) }}
                        </span>
                    </td>
                    <td>
                    </td>
                    @endif -->
                </tr>
            </tbody>
        </table>                    
</template>

<script>
export default {
    data() {
        return {
            requests: []
        }
    },
    mounted() {
        console.log("Component mounted.");
    },
    created() {
        this.fetchRequests();
        this.listenForChanges();
        this.dataTable();
    },
    methods: {
        dataTable() {
            $('#requestList').DataTable({
                "scrollX": true,
                "order": [],
            });  
        },
        fetchRequests() {
            axios.get('/requests/get_requests').then((response) => {
                this.requests = response.data;
            })
        },
        listenForChanges() {
            Pusher.logToConsole = true;

            var pusher = new Pusher('ab82b7896a919c5e39dd', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('requests-channel');
            channel.bind('deliver-event', function(data) {
                console.log(data);
            });
        },
        goto_route: function (param1, param2) {
            confirm('Are you sure to ' + param2 + ' the request?')
            if(param2 == 'approve') {
                route = '{{ route("request.approve", ["id" => "request_id"]) }}'
                location.href = route.replace('request_id', param1)
            } 
            else if(param2 == 'decline'){
                route = '{{ route("request.admin_decline", ["id" => "request_id"]) }}'
                location.href = route.replace('request_id', param1)
            }
            else if(param2 == 'cancel'){
                route = '{{ route("request.cancel", ["id" => "request_id"]) }}'
                location.href = route.replace('request_id', param1)
            }
            
        },
        submit_form: function (param1) {
            //confirm('Are you sure to ' + param2 + ' the request?')
            route = '{{ route("request.assign_courier", ["id" => "request_id"]) }}'
            location.href = route.replace('request_id', param1)
        }
    },
    computed: {
        sortedRequests() {
            return this.requests.sort()
        }
    }
};
</script>
