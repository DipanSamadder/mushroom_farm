
<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th width="40%">Details</th>
                <th>Form Name</th>
                <th>Date</th>
                @if(dsld_check_permission(['edit-contactf-leads']) || dsld_check_permission(['delete-contactf-leads']))
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th width="40%">Details</th>
                <th>Form Name</th>
                <th>Date</th>
                
                @if(dsld_check_permission(['edit-contactf-leads']) || dsld_check_permission(['delete-contactf-leads']))
                <th>Action</th>
                @endif
            </tr>
        </tfoot>
    <tbody>
        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $key => $value)
            @php $key++; @endphp
                <tr>
                    <th scope="row">{{ $key }}</th>
                    <td>
                        
                        @foreach(json_decode($value->meta_value, true) as $key2 => $val)
                           @foreach($val as $k => $v)
                                    @php echo '<b>'.ucfirst(str_replace('_', ' ', $k)).'</b> : '.$v.'<br>'; @endphp
                           @endforeach
                        @endforeach
                    
                    </td>
                    <td>{{ $value->page->title }}</td>
                    <td><small>U: {{ date('h:i:s d M, Y', strtotime($value->updated_at)) }}<br>C: {{ date('h:i:s d M, Y', strtotime($value->created_at)) }}</small></td>

                    @if(dsld_check_permission(['edit-contactf-leads']) || dsld_check_permission(['delete-contactf-leads']))
                    <td>
                        <p class="text-center mb-0 action_items">

                            @if(dsld_check_permission(['delete-contactf-leads']))
                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-danger" onclick="DSLDDeleteAlert('{{ $value->id }}','{{ route('contact_form_leads.destory') }}','{{ csrf_token() }}')">
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
