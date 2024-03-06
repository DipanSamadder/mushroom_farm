
@if($room_id !='')
<div class="body">
<input type="hidden" name="room_id" value="{{ $room_id }}">
@foreach(App\Models\Grade::where('status', 1)->get() as $key => $grade)
@php 
    $pro = App\Models\Production::where('rooms_id', $room_id)->where('grades_id', $grade->id)->first();
@endphp
<input type="hidden" name="gid[]" value="{{ $grade->id }}">
<div class="row clearfix">
    <div class="col-sm-12">
        <div class="form-group">
            <label class="form-label">Stock Qty ({{ $grade->name }}) <small class="text-danger">*</small></label>                                 
            <input type="text" name="qty[]" class="form-control" placeholder="1" value="{{ @$pro->qty }}" />                                   
        </div>
    </div>
</div>
@endforeach
</div>
@endif
                