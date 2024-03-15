@extends('backend.layouts.app')



@section('content')

<div class="row clearfix">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Help </strong></h2>
            </div>
            <div class="body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#production_process">Production Process </a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#other">Other </a></li>
                        <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#footer"><i class="zmdi zmdi-hc-fw"></i> Footer </a></li> -->
                    </ul>
                    
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane in active p-2" id="production_process">
                            <ul class="list-unstyled activity">
                                <li class="a_birthday">
                                    <small>All Master/<a href="{{ route('rooms.index') }}" target="_blank"> Room</a></small>
                                    <h4>Create & View Room List</h4>
                                    <p>You can show all room list here. If you want to add new Room. </p>
                                </li>
                                <li class="a_code">
                                    <small>Room/<a href="{{ route('rooms.history.index') }}" target="_blank"> Room history</a></small>
                                    <h4>View Room History List</h4>
                                    <p>You can see all room History and also Occupied free room. After edit Production room will be empty and move data to production tab.</p>
                                    <ul class="list-unstyled activity">
                                        <li class="a_code">
                                            <h4>Room Start </h4>
                                            <p>When your room will be free. Then you can start Room cycles.</p>
                                            <img src="{{ dsld_static_asset('backend/assets/images/supports/add-new-room-occupied.png')}}" width="300px;"/>
                                            
                                        </li>
                                        <li class="a_code">
                                            <small>Room/<a href="{{ route('room_assign.index') }}" target="_blank"> Room Assign</a></small>
                                            <h4>Room Wise Employee Assign</h4>
                                            <p>Now need to assign employee for particular room. Type wise select single and multiple employee.</p>
                                            <img src="{{ dsld_static_asset('backend/assets/images/supports/employe-assign.png')}}" width="400px;"/>
                                        </li>
                                        <li class="a_code">
                                            <h4>Fully Setup Completed</h4>
                                            <p>Finaly completed your setup then follow bellow attached image.</p>
                                            <img src="{{ dsld_static_asset('backend/assets/images/supports/Room-History-productions-.jpg')}}"/>
                                        </li>
                                    </ul>
                                    
                                </li>
                                <li class="a_contact">
                                    <h4>Production Dashboad</h4>
                                    <ul class="list-unstyled activity">
                                        <li class="a_contact">
                                            <h4>Edit Qty of Production </h4>
                                            <p>If you have put mistake for qty when move prduction data then you can edit here.</p>
                                        </li>
                                        <li class="a_contact">
                                            <h4>Bluk Grade wise Sale </h4>
                                            <p>If you want to sale bluk then you can change here.</p>
                                        </li>
                                        <li class="a_contact">
                                            <h4>Single Grade wise Sale </h4>
                                            <p>If you also want to change single sale data from here.</p>
                                        </li>
                                        <li class="a_contact">
                                            <h4>Production Completed</h4>
                                            <p>If you see the attached.</p>
                                            <img src="{{ dsld_static_asset('backend/assets/images/supports/productions.jpg')}}"/>
                                        </li>
                                    </ul>
                                </li>
                                <li class="a_email">
                                    <h4>Sale Dashboad</h4>
                                    <p>You can see all sale information here. If you want to some modification then you can change.</p>
                                    <img src="{{ dsld_static_asset('backend/assets/images/supports/sale-dashboard.png')}}"/>
                                </li>
                            </ul>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="other">
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection