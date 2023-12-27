
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Name</th>
                @if(dsld_check_permission(['edit user']))
                <th>Status</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Name</th>
                @if(dsld_check_permission(['edit user']))
                <th>Status</th>
                @endif
            </tr>
        </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $key => $value)
        
                <tr>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $value->name }}</td>
                     @if(dsld_check_permission(['edit user']))
                    <td>
                    @php
                        $user = App\Models\User::find($user_id);
                    @endphp
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="status{{$value->id }}" onchange="DSLDStatusUpdate('{{ $value->id }}','{{ $user_id  }}', '{{ route('users.assign_permissions') }}','{{ csrf_token() }}')" @if($user->hasDirectPermission($value->name) == 1) checked @endif >
                        <label class="custom-control-label" for="status{{$value->id }}"></label>
                    </div>

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
