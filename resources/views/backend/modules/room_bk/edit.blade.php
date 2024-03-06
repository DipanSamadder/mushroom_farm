@if($data !='')



<input type="hidden" name="id" value="{{ $data->id }}">

<div class="body">

    <div class="row clearfix">

        <div class="col-sm-12">

            <div class="form-group">

                <label class="form-label">Name <small class="text-danger">*</small></label>                                 

                <input type="text" name="name" class="form-control" placeholder="Name" @if($data->name) value="{{ $data->name }}" @endif  />                                   

            </div>

        </div>

        <div class="col-sm-12">

            <div class="form-group">

                <label class="form-label">Remark <small class="text-danger">*</small></label>                                 

                <input type="text" name="remark" class="form-control" placeholder="Remark" @if($data->remark) value="{{ $data->remark }}" @endif  />                                   

            </div>

        </div>

        

        <div class="col-sm-12">

            <div class="form-group">

                <label class="form-label">Status <small class="text-danger">*</small></label>        

                <select class="form-control demo-select2-placeholder" name="status">

                    <option value="0" @if($data->status == 0) selected @endif>Running</option>

                    <option value="1"  @if($data->status == 1) selected @endif>Active</option>
                    <option value="2"  @if($data->status == 2) selected @endif>Finished</option>

                </select>

            </div>

        </div>

    </div>



</div>

@endif

                