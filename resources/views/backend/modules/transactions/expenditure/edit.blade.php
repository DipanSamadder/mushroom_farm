@if($data !='')

<input type="hidden" name="id" value="{{ $data->id }}">
<input type="hidden" name="updated_by" value="{{ Auth::user()->id }}">
<input type="hidden" name="category" value="expenditure">
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-12"><h6>Expenditure Details</h6><hr></div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Purpose <small class="text-danger">*</small></label>                                 
                <input type="text" name="purpose" class="form-control" placeholder="Purpose"  @if($data->purpose) value="{{ $data->purpose }}" @endif />                                   
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Vendor Name</label>                                 
                <select class="form-control demo-select2-placeholder" name="vendor_id">
                    @if(App\Models\User::where('user_type', 'employer')->get())
                        @foreach(App\Models\User::where('user_type', 'employer')->get() as $key => $type)
                            <option value="{{ $type->id }}" @if($data->vendor_id == $type->id) selected @endif>{{ $type->name }}</option>
                        @endforeach
                    @endif
                </select>                                
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Date of Invoice <small class="text-danger">*</small></label>                                 
                <input type="date" name="invoice_date" class="form-control" placeholder="Invoice Date" disabled="disabled" @if($data->invoice_date) value="{{ $data->invoice_date }}" @endif/>                                   
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Date of Delivery <small class="text-danger">*</small></label>                                 
                <input type="date" name="delivery_date" class="form-control" placeholder="Delivery Date" @if($data->delivery_date) value="{{ $data->delivery_date }}" @endif/>                                   
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Type of Work <small class="text-danger">*</small></label>                                 
                <select class="form-control demo-select2-placeholder" name="work_type">
                    <option value="service" @if($data->work_type == 'service') seleted @endif>Service</option>
                    <option value="purchase" @if($data->work_type == 'purchase') seleted @endif>Purchase</option>
                </select>                                
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Amount <small class="text-danger">*</small></label>                                 
                <input type="text" name="amount" class="form-control" placeholder="Amount"  @if($data->amount) value="{{ $data->amount }}" @endif/>                                   
            </div>
        </div>

        <div class="col-sm-12"><br><h6>Payment Details</h6><hr></div>

        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Payment Model <small class="text-danger">*</small></label>                                 
                <select class="form-control demo-select2-placeholder" name="payment_mode">
                    @if(App\Models\Type::where('type', 'payment_mode')->get())
                        @foreach(App\Models\Type::where('type', 'payment_mode')->get() as $key => $type)
                            <option value="{{ $type->id }}" @if(@$transaction->payment_mode == $type->id) selected @endif>{{ $type->title }}</option>
                        @endforeach
                    @endif
                </select>                                
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Payee Name <small class="text-danger">*</small></label>                                 
                <input type="text" name="payee_name" class="form-control" placeholder="Payee Name" @if(@$transaction->payee_name) value="{{ @$transaction->payee_name }}" @endif/>                                   
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Pay Amount <small class="text-danger">*</small></label>                                 
                <input type="text" name="payamount" class="form-control" placeholder="Pay Amount"  @if(@$transaction->amount > 0) value="{{ @$transaction->amount }}" @else value="{{ $data->amount }}" @endif/>                                   
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Transaction <small class="text-danger">*</small></label>                                 
                <input type="text" name="transaction_id" class="form-control" placeholder="Transaction" @if(@$transaction->transaction_id) value="{{ @$transaction->transaction_id }}" @endif/>                                   
            </div>
        </div>


        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Date of Payment <small class="text-danger">*</small></label>                                 
                <input type="date" name="date" class="form-control" placeholder="Date" @if(@$transaction->date) value="{{ @$transaction->date }}" @endif/>                                   
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Status <small class="text-danger">*</small></label>        
                <select class="form-control demo-select2-placeholder" name="status">
                    <option value="1"  @if(@$transaction->status == 1) selected @endif>Active</option>
                    <option value="0" @if(@$transaction->status == 0) selected @endif>Deactive</option>
                </select>
            </div>
        </div>

    </div>
</div>
@endif
                