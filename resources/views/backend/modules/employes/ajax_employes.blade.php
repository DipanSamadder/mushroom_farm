

<table class="table table-bordered table-striped table-hover dataTable">

    <thead>

            <tr class="text-center">

                <th>Sr</th>

                <th>photo</th>

                <th>Name</th>

                <th>Parent</th>
                <th>Contact</th>


                <th>Date</th>

                @if(dsld_check_permission(['edit-employee']))

                <th>Status</th>

                @endif

                @if(dsld_check_permission(['edit-employee','delete-employee']))

                <th>Action</th>

                @endif

            </tr>

        </thead>

        <tfoot>

            <tr class="text-center">

                <th>Sr</th>

                <th>photo</th>

                <th>Name</th>
                <th>Parent</th>

                <th>Contact</th>


                <th>Date</th>

                @if(dsld_check_permission(['edit-employee']))

                <th>Status</th>

                @endif

                @if(dsld_check_permission(['edit-employee','delete-employee']))

                <th>Action</th>

                @endif

            </tr>

        </tfoot>

    <tbody>

        @if(is_array($data) || count($data) > 0 )

            @foreach($data as $key => $value)

            @php $key++; @endphp

                <tr @if($value->user_type == 'admin') style="background:#ffe9e9;" @endif>

                    <th scope="row">{{ $key }}</th>

                    <td>

                        @if($value->avatar_original > 0)<img src="{{ dsld_uploaded_file_path($value->avatar_original) }}" alt="{{ dsld_upload_file_title($value->avatar_original) }}" class="page_banner_icon">

                        @else

                            <img src="{{ dsld_static_asset('backend/assets/images/xs/avatar1.jpg') }}" alt="Dummy Image" class="page_banner_icon">

                        

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('employes.edit', [$value->id]) }}">{{ $value->name }}</a><br>

                    </td>
                    <td><small>{{ @$value->employe->father  }}</small></td>

                    <td><small>{{ $value->email  }}<br>{{ $value->phone  }}</small></td>

                    <!-- <td><small>{{ $value->address }}, {{ $value->city }}, {{ $value->country }} - {{ $value->postal_code}}</small></td> -->

                    <td><small>U: {{ date('h:i:s d M, Y', strtotime($value->updated_at)) }}<br>C: {{ date('h:i:s d M, Y', strtotime($value->created_at)) }}</small></td>



                    @if(dsld_check_permission(['edit-employee']))

                    <td>



                        <div class="custom-control custom-switch">

                            <input type="checkbox" class="custom-control-input" id="{{$value->id }}" onchange="DSLDStatusUpdate('{{ $value->id }}','{{ $value->banned == 0 ? 1 : 0  }}', '{{ route('employes.status') }}','{{ csrf_token() }}')" @if($value->banned == 0) checked @endif >

                            <label class="custom-control-label" for="{{$value->id }}"></label>

                        </div> 

                        

                    </td>

                    @endif

                    

                    @if(dsld_check_permission(['edit-employee','delete-employee']))



                    <td>

                        <p class="text-center mb-0 action_items">

                            @if($value->user_type == 'admin')

                            @if(dsld_check_permission(['edit-employee']))

                            <a href="{{ route('employes.edit', [$value->id]) }}" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">

                                    <i class="zmdi zmdi-edit"></i>

                                </a>

                            @endif

                            @endif

                            @if(dsld_check_permission(['delete-employee']))

                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('employes.destory') }}','{{ csrf_token() }}')">

                                    <i class="zmdi zmdi-delete"></i>

                            </a>

                            @endif

                        </p>

                    </td>



                    @endif

                </tr>

            @endforeach

        @else

            <tr>

                <td colspan="8" class="text-center">Nothing Found</td>

            </tr>

        @endif

    </tbody>

</table>



{{  $data->links('backend.pagination.custom') }}

