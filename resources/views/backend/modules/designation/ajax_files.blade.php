

<table class="table table-bordered table-striped table-hover dataTable">

    <thead>

            <tr class="text-center">

                <th>Sr</th>

                <th>Name</th>

                <th>Parent</th>

                <th>Level</th>

                <th>Status</th>

                @if(dsld_check_permission(['edit-designations', 'delete-designations']))

                <th>Action</th>

                @endif

            </tr>

        </thead>

        <tfoot>

            <tr class="text-center">

                <th>Sr</th>

                <th>Name</th>

                <th>Parent</th>

                <th>Level</th>

                <th>Status</th>

                @if(dsld_check_permission(['edit-designations', 'delete-designations']))

                <th>Action</th>

                @endif

            </tr>

        </tfoot>

    <tbody>

        @if(is_array($data) || count($data) > 0 )

            @foreach($data as $key => $value)

        

                <tr @if($value->level ==1) style="background:#ff00001f;" @endif>

                    <th scope="row">{{ $key+1 }}</th>

                    <td>{{ $value->name }} @if($value->is_temporary== 0) (Fix) <i class="zmdi zmdi-trending-up text-success"></i> @else <i class="zmdi zmdi-trending-down text-warning"></i>@endif</td>

                    <td>@if(@$value->parent != 0) <span class="badge bg-success text-white">{{ @$value->parents->name }}</span> @else - @endif</td>

                    <td>{{ $value->level }}</td>

                    <td><span class="badge @if($value->status == 1 ) bg-success @else bg-danger @endif text-white">@if($value->status == 1 ) Active @else Deactive @endif</span></td>



                    @if(dsld_check_permission(['edit-designations', 'delete-designations']))

                    <td>

                            @if(dsld_check_permission(['edit-designations']))

                            <a href="javascript:void(0)"  onclick="edit_lg_modal_form({{ $value->id }}, '{{ route('designations.edit') }}', 'Template');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary">

                                <i class="zmdi zmdi-edit"></i>

                            </a>

                            @endif

                            @if(dsld_check_permission(['delete-designations']))

                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('designations.destory') }}','{{ csrf_token() }}')">

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

