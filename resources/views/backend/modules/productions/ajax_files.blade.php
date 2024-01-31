
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Room Name</th>
                @php
                    $grades = App\Models\Grade::where('status', 1)->get();
                @endphp
                @if(!is_null($grades))
                @foreach($grades as $key => $value)
                <th>{{ @$value->name }}</th>
                @endforeach
                <th>Total</th>
                <th>Date</th>
                @endif
                @if(dsld_check_permission(['edit-production', 'delete-production']))
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Room Name</th>
                
                @php
                    $grades = App\Models\Grade::where('status', 1)->get();
                @endphp
                @if(!is_null($grades))
                @foreach($grades as $key => $value)
                <th>{{ @$value->name }}</th>
                @endforeach
                @endif
                <th>Total</th>
                <th>Date</th>
                @if(dsld_check_permission(['edit-production', 'delete-production']))
                <th>Action</th>
                @endif
            </tr>
        </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $rkey => $room)
                <tr>
                    <th scope="row">{{ $rkey+1 }}</th>
                    <td>{{ @$room->name }}</td>
                    @php
                    $grades = App\Models\Grade::where('status', 1)->get();
                    $total =0;
                    @endphp
                    @if(!is_null($grades))
                    @foreach($grades as $key => $grade)
                        @php
                            $datas = App\Models\Production::where('rooms_id', $room->id)->where('grades_id', $grade->id)->first();
                        @endphp
                    <td> <small>Q{{ @$datas->qty }} X R{{  $grade->rate }}</small><br><b>Rs. <span class="text-success">{{ round(@$datas->qty* $grade->rate, 2) }}/-</span></b></td>
                    @php 
                        $total += round(@$datas->qty* $grade->rate, 2);
                    @endphp
                    @endforeach
                    @endif
                    <td><b>Rs. <span class="text-info">{{ $total }}/-</span></b></td>
                    <td>{{ date('d-m-Y', strtotime(@$room->production->created_at)) }}</td>

                    @if(dsld_check_permission(['edit-production']))
                    <td>
                            @if(dsld_check_permission(['edit-production']))
                            <a href="javascript:void(0)"  onclick="edit_lg_modal_form({{ $room->id }}, '{{ route('rooms.production.edit') }}', 'Production');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">
                                <i class="zmdi zmdi-edit"></i>
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