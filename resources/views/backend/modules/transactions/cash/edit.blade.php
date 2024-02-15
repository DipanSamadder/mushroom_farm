@if($data !='')

<input type="hidden" name="id" value="{{ $data->id }}">
<input type="hidden" name="updated_by" value="{{ Auth::user()->id }}">
<input type="hidden" name="category" value="cash_imprest">
<div class="body">
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Payment Model <small class="text-danger">*</small></label>                                 
                <select class="form-control demo-select2-placeholder" name="payment_mode">
                    @if(App\Models\Type::where('type', 'payment_mode')->get())
                        @foreach(App\Models\Type::where('type', 'payment_mode')->get() as $key => $type)
                            <option value="{{ $type->id }}" @if($data->payment_mode == $type->id) selected @endif>{{ $type->title }}</option>
                        @endforeach
                    @endif
                </select>                                
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Purpose <small class="text-danger">*</small></label>                                 
                <input type="text" name="purpose" class="form-control" placeholder="Purpose" @if($data->purpose) value="{{ $data->purpose }}" @endif/>                                   
            </div>
        </div>
        
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Type <small class="text-danger">*</small></label>                                 
                <select class="form-control demo-select2-placeholder" name="type">
                    <option value="debit" @if($data->type == 'debit') selected @endif>Debit</option>
                    <option value="credit" @if($data->type == 'credit') selected @endif>Credit</option>
                </select>                                
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Amount <small class="text-danger">*</small></label>                                 
                <input type="text" name="amount" class="form-control" placeholder="Amount" @if($data->amount) value="{{ $data->amount }}" @endif/>                                   
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Pay to <small class="text-danger">*</small></label>                                 
                <select class="form-control demo-select2-placeholder" name="emp_id">
                    @if(App\Models\User::where('user_type', 'employer')->get())
                        @foreach(App\Models\User::where('user_type', 'employer')->get() as $key => $type)
                            <option value="{{ $type->id }}" @if($data->emp_id == $type->id) selected @endif>{{ $type->name }}</option>
                        @endforeach
                    @endif
                </select>                                
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Date <small class="text-danger">*</small></label>                                 
                <input type="date" name="date" class="form-control" placeholder="Date" @if($data->date) value="{{ $data->date }}" @endif/>                                   
            </div>
        </div>
        
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Status <small class="text-danger">*</small></label>        
                <select class="form-control demo-select2-placeholder" name="status">
                    <option value="0" @if($data->status == 0) selected @endif>Deactive</option>
                    <option value="1"  @if($data->status == 1) selected @endif>Active</option>
                </select>
            </div>
        </div>
    </div>

</div>
@endif
                