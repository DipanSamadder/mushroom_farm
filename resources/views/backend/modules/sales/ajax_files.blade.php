

<table class="table table-bordered table-striped table-hover dataTable">
    <thead>
            <tr class="text-center">
                <th>Sr</th>
                <th>Photo</th>
                <th>Vendor</th>
                @php
                    $pcate = App\Models\Grade::where('status', 1)->get();
                @endphp
                @if(!is_null($pcate))
                @foreach($pcate as $key => $value)
                <th>{{ @$value->name }}</th>
                @endforeach
                @endif

                <th>Total</th>
                <th>Date</th>
                @if(dsld_check_permission(['edit-sale', 'delete-sale']))
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr class="text-center">
                <th>Sr</th>
                <th>Photo</th>
                <th>Vendor</th>
                @php
                    $pcate = App\Models\Grade::where('status', 1)->get();
                @endphp
                @if(!is_null($pcate))
                @foreach($pcate as $key => $value)
                <th>{{ @$value->name }}</th>
                @endforeach
                @endif
                <th>Total</th>
                <th>Date</th>
                @if(dsld_check_permission(['edit-sale', 'delete-sale']))
                <th>Action</th>
                @endif
            </tr>
        </tfoot>
    <tbody>

        @if(is_array($data) || count($data) > 0 )
            @foreach($data as $rkey => $order)
                
                <tr>
                    <th scope="row">{{ $rkey+1 }}</th>
                    <td>
                        @if($order->users->avatar_original > 0)
                            <img src="{{ dsld_uploaded_file_path($order->users->avatar_original) }}" alt="{{ dsld_upload_file_title($order->users->avatar_original) }}" class="rounded-circle" style="width: 45px; height:45px;">
                        @else
                            <img src="{{ dsld_static_asset('backend/assets/images/xs/avatar1.jpg') }}" alt="Dummy Image" class="rounded-circle" style="width: 45px; height:45px;">
                        @endif
                    </td>
                    <td>
                  
                    <strong class="text-success">{{ @$order->users->name }}</strong><br><strong>{{ @$order->vendors->framesType->name }}</strong><br>{{ @$order->users->phone }}</td>

                    
                    @php
                        $proCat = App\Models\Grade::where('status', 1)->get();
                        $today_total = 0;
                    @endphp
                    @if(!is_null($proCat))
                        @foreach($proCat as $key => $value)
                            @php 
                                $sales = App\Models\Sale::where('rooms_id', $order->id)->where('grades_id',  $value->id)->first();
                                if(!Empty($sales)){
                                    $today_total += $sales->total;
                                }
                                
                            @endphp
                            <td>
                                @if(@$sales->qty > 0)
                                <small>Quanty: <b>{{ @$sales->qty }} Pcs<b></small><br>
                                <small>Rate: <b>{{ @$sales->grades_rate }} Rs<b></small><br>
                                <b>Rs. <span class="text-primary">{{ @$sales->total }}/-</span>
                                @endif
                            </td>
                        @endforeach
                    @endif
                    <td>{{ $today_total }}</td>
                    
                   
                    @php 
                        $created  = explode(',', $order->created_at);
                        $Todays = \Carbon\Carbon::today();
                    @endphp

                    <td>{{ date('d-m-Y', strtotime(@$created[0])) }}</td>

                    @if(dsld_check_permission(['edit-sale']))
                    <td>
                        @if($Todays->isSameDay(@$created[0])) 
                        @if(dsld_check_permission(['edit-sale']))
                        <a href="javascript:void(0)" onclick="sale_edit_lg_modal_form('{{ $order->vendor_id }}', '{{  $order->id }}', '{{ route('sale.edit') }}', 'Sale');" class="btn btn-default waves-effect waves-float btn-sm waves-red bg-primary"><i class="zmdi zmdi-edit"></i></a>
                        @endif
                        @endif
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

