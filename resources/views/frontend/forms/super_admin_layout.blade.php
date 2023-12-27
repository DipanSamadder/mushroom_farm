@if(dsld_form_field_by_form_id($form_id) != '') 

<div class="container">
    <div style="position: relative;">
<form action="{{ route('contact_form.submit_data_two') }}" id="contact_submit" method="Post" enctype="multipart/form-data" class="mt-4 bg-transparent p-0 contact_query">
    @csrf
    <input type="hidden" name="form_id" id="form_id" value="{{ $form_id }}">
    <div class="form-body-items">
    <div class="row clearfix  mb-2">
    @foreach (dsld_form_field_by_form_id($form_id) as $key => $element)
        @php 
            $width = json_decode($element->setting)->width;
            $class_name = json_decode($element->setting)->class_name;
            $label_setting = json_decode($element->setting)->label_setting;
            $is_required = json_decode($element->setting)->is_required;
            $col = 'col-md-12 col-md-12';
            if($width == '25'){
                $col = 'col-md-3 col-md-3';
            }elseif($width == '33'){
                $col = 'col-md-4 col-md-4';
            }elseif($width == '50'){
                $col = 'col-md-6 col-md-6';
            }elseif($width == '75'){
                $col = 'col-md-9 col-md-9';
            }else{
                $col = 'col-md-12 col-md-12';
            }
            
        @endphp
        @if ($element->type == 'text' || $element->type == 'file')
           
            <div class="{{ $col }}">
                <input type="hidden" name="form_type[]" value="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}">
                <div class="">
                    <label class="col-from-label">@if($label_setting =='show') {{ ucfirst(str_replace('_', ' ', $element->label)) }} @if($is_required =='required') <span style="color:red">*</span> @endif @else &nbsp; @endif </label>
                </div>
                <input class="form-control rounded-0 my-2 @if($class_name !='') {{ $class_name }} @endif" type="{{ $element->type }}" name="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}" placeholder="{{ $element->label }} @if($is_required =='required') * @endif" onchange="is_edited()">
            </div>
        
        @elseif ($element->type == 'email')
           
            <div class="{{ $col }}">
                <input type="hidden" name="form_type[]" value="email">
                <div class="">
                    <label class="col-from-label">@if($label_setting =='show') {{ ucfirst(str_replace('_', ' ', $element->label)) }} @if($is_required =='required') <span style="color:red">*</span> @endif @else &nbsp; @endif </label>
                </div>
                <input class="form-control rounded-0 my-2 @if($class_name !='') {{ $class_name }} @endif" type="{{ $element->type }}" name="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}" placeholder="{{ $element->label }} @if($is_required =='required') * @endif" onchange="is_edited()">
            </div>
        @elseif ($element->type == 'phone')
           
           <div class="{{ $col }}">
               <input type="hidden" name="form_type[]" value="phone">
               <div class="">
                   <label class="col-from-label">@if($label_setting =='show') {{ ucfirst(str_replace('_', ' ', $element->label)) }} @if($is_required =='required') <span style="color:red">*</span> @endif @else &nbsp; @endif</label>
               </div>
                <input class="form-control rounded-0 my-2 @if($class_name !='') {{ $class_name }} @endif" type="number" name="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}" placeholder="{{ $element->label }} @if($is_required =='required') * @endif" onchange="is_edited()">
           </div>
        @elseif ($element->type == 'button')
            <div class="{{ $col }}">
                <div class="">
                    <label class="col-from-label">&nbsp;</label>
                </div>
                <input class="btn text-decoration-none f19 gothamnarrow325 applynowwe rounded-0 dsld-btn-loader  my-2 @if($class_name !='') {{ $class_name }} @endif" type="submit"  value="{{ $element->label }}">
            </div>
        @endif
    @endforeach

    </div>
    </div>
</form>
<div class="loading_after_submit_form" style="display: none;">
    <div class="lds-ripple"><div></div><div></div></div>
</div>
</div>
</div>
@endif

@section('footer')
<script>
$(document).ready(function (e) {
    $("#contact_submit").on('submit',(function(e) {
        e.preventDefault();

        //$('.loading_after_submit_form').show();
        //$('.form-body-items').addClass('form-body-blur');
        
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: new FormData(this),
            dataType: "json",
            mimeType: "multipart/form-data",
            cache: false,
            processData:false,
            contentType: false,
            success: function(data) {
                if(data['status'] =='success'){
                    $('#contact_submit')[0].reset(); 
                }
                dslp_session_flash(data['status'], data['message']);
                $('.loading_after_submit_form').hide();
                $('.form-body-items').removeClass('form-body-blur');
            }
        });

  }));
});
  
</script>
@endsection