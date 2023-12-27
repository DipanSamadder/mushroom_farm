@if(dsld_form_field_by_form_id($form_id) != '') 


<div class="froms-body">
<form action="javascript:void(0);" id="contact_submit{{ $form_id }}" method="post" enctype="multipart/form-data" class="bg-transparent p-0 contact_query">
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
        @if ($element->type == 'text' || $element->type == 'file' || $element->type == 'timepicker')
           
            <div class="{{ $col }}">
                <input type="hidden" name="form_type[]" value="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}">
                @if($label_setting =='show')
                <div class="">
                    <label class="col-from-label"> {{ ucfirst(str_replace('_', ' ', $element->label)) }} @if($is_required =='required') <span style="color:red">*</span> @endif </label>
                </div>
                @endif
                <input class="form-control mb-2 @if($class_name !='') {{ $class_name }} @endif" type="{{ $element->type }}" name="form_label[]" placeholder="{{ $element->label }} @if($is_required =='required') * @endif" onchange="is_edited()">
            </div>

        @elseif ($element->type == 'email')
           
            <div class="{{ $col }}">
                <input type="hidden" name="form_type[]" value="email">
                @if($label_setting =='show')
                <div class="">
                    <label class="col-from-label"> {{ ucfirst(str_replace('_', ' ', $element->label)) }} @if($is_required =='required') <span style="color:red">*</span> @endif </label>
                </div>
                @endif
                <input class="form-control mb-2 @if($class_name !='') {{ $class_name }} @endif" type="{{ $element->type }}" name="form_label[]" placeholder="{{ $element->label }} @if($is_required =='required') * @endif" onchange="is_edited()">
            </div>
        @elseif ($element->type == 'datepicker')
           
           <div class="{{ $col }}">
               <input type="hidden" name="form_type[]" value="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}">
                @if($label_setting =='show')
                <div class="">
                    <label class="col-from-label"> {{ ucfirst(str_replace('_', ' ', $element->label)) }} @if($is_required =='required') <span style="color:red">*</span> @endif </label>
                </div>
                @endif
                <input class="form-control mb-2 @if($class_name !='') {{ $class_name }} @endif" type="date" name="form_label[]" placeholder="{{ $element->label }} @if($is_required =='required') * @endif" onchange="is_edited()">
           </div>
        @elseif ($element->type == 'phone')
           
           <div class="{{ $col }}">
               <input type="hidden" name="form_type[]" value="phone">
                @if($label_setting =='show')
                <div class="">
                    <label class="col-from-label"> {{ ucfirst(str_replace('_', ' ', $element->label)) }} @if($is_required =='required') <span style="color:red">*</span> @endif </label>
                </div>
                @endif
                <input class="form-control mb-2 @if($class_name !='') {{ $class_name }} @endif" type="number" name="form_label[]" placeholder="{{ $element->label }} @if($is_required =='required') * @endif" onchange="is_edited()">
           </div>
        @elseif ($element->type == 'textarea')
           
           <div class="{{ $col }}">
               <input type="hidden" name="form_type[]" value="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}">
                @if($label_setting =='show')
                <div class="">
                    <label class="col-from-label"> {{ ucfirst(str_replace('_', ' ', $element->label)) }} @if($is_required =='required') <span style="color:red">*</span> @endif </label>
                </div>
                @endif
               <textarea class="form-control @if($class_name !='') {{ $class_name }} @endif" name="form_label[]" placeholder="{{ $element->label }} @if($is_required =='required') * @endif" onchange="is_edited()"></textarea>
           </div>
        @elseif ($element->type == 'select')

            
            <div class="{{ $col }}">
                <input type="hidden" name="form_type[]" value="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}">
                @if($label_setting =='show')
                <div class="">
                    <label class="col-from-label"> {{ ucfirst(str_replace('_', ' ', $element->label)) }} @if($is_required =='required') <span style="color:red">*</span> @endif</label>
                </div>
                @endif
                <select class="form-control @if($class_name !='') {{ $class_name }} @endif" type="text" name="form_label[]"  onchange="is_edited()">
                    <option value="">Please Select</option>
                    @if (is_array(json_decode($element->options)))
                        @foreach (json_decode($element->options) as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        @elseif ($element->type == 'country')

            @if($element->label =='all')
            <div class="{{ $col }}">
                <input type="hidden" name="form_type[]" value="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}">
                @if($label_setting =='show')
                <div class="">
                    <label class="col-from-label"> Country @if($is_required =='required') <span style="color:red">*</span> @endif</label>
                </div>
                @endif
                <select class="form-control @if($class_name !='') {{ $class_name }} @endif country-id" type="text" name="form_label[]"  onchange="onclick_country_cf7()">
                    <option value="">Please Country</option>
                     @foreach (App\Models\Country::where('status', 1)->orderBy('name', 'ASC')->get() as $key => $value)
                    <option value="{{ $value->id }}" @if($element->label == $value->id) selected @endif>{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
            @else
                <input type="hidden"  name="form_type[]" value="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}">
                <input type="hidden" class="country-id" name="form_label[]" value="{{ $element->label }}">
            @endif
        @elseif ($element->type == 'state')

            <div class="{{ $col }}">
                <input type="hidden" name="form_type[]" value="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}">
                @if($label_setting =='show')
                <div class="">
                    <label class="col-from-label"> {{ ucfirst(str_replace('_', ' ', $element->label)) }} @if($is_required =='required') <span style="color:red">*</span> @endif <span class="dropdown-loading dropdown-state"></span></label>
                </div>
                @endif
                <select class="form-control @if($class_name !='') {{ $class_name }} @endif state-id" type="text" name="form_label[]"  onchange="onclick_state_cf7()">
                    <option value="">Please State</option>
                </select>
            </div>

        @elseif ($element->type == 'city')

            <div class="{{ $col }}">
                <input type="hidden" name="form_type[]" value="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}">
                @if($label_setting =='show')
                <div class="">
                    <label class="col-from-label"> {{ ucfirst(str_replace('_', ' ', $element->label)) }} @if($is_required =='required') <span style="color:red">*</span> @endif <span class="dropdown-loading dropdown-city"></span></label>
                </div>
                @endif
                <select class="form-control @if($class_name !='') {{ $class_name }} @endif city-id" type="text" name="form_label[]">
                    <option value="">Please City</option>
                </select>
            </div>

        @elseif ($element->type == 'checkbox' || $element->type == 'radio') 

            <div class="{{ $col }}">
                <input type="hidden" name="form_type[]" value="{{ strtolower(dsld_generate_slug_by_text($element->label)) }}">
                @if($label_setting =='show')
                <div class="">
                    <label class="col-from-label"> {{ ucfirst(str_replace('_', ' ', $element->label)) }} @if($is_required =='required') <span style="color:red">*</span> @endif </label>
                </div>
                @endif
                @if (is_array(json_decode($element->options)))
                    @foreach (json_decode($element->options)  as $key2 => $value)
                        <div class="form-check">
                            <input class="form-check-input" type="{{ $element->type }}" name="form_label[]" value="{{ $value }}" id="{{ $element->type }}{{ $key2 }}" checked>
                            <label class="form-check-label" for="{{ $element->type }}{{ $key2 }}">
                            {{ $value }}
                            </label>
                        </div>
                    @endforeach
                @endif

            </div>
        
        @elseif ($element->type == 'button')
            <div class="{{ $col }}">
                <div class="">
                    <label class="col-from-label">&nbsp;</label>
                </div>
                <input class="dsld-btn-loader form-control @if($class_name !='') {{ $class_name }} @endif" type="submit"  value="{{ $element->label }}" onclick="ajax_form_submit_cf7({{ $form_id }})">
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
@endif

@section('footer')
<script>
    $(document).ready(function(){
       onclick_country_cf7()
        
    });
    
    function onclick_country_cf7(){
        var country_id =  $('#contact_submit{{ $form_id }} .country-id').val();
        $('.dropdown-state').html('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');
            jQuery('#contact_submit{{ $form_id }} .state-id option:not(:first)').remove();
            $.post( "{{ route('ajax_get_state_by_country') }}", {'_token':'{{ csrf_token() }}', 'id':country_id }).done(function( data ) {
            $('#contact_submit{{ $form_id }} .state-id').append(data);
            $('.dropdown-state').html('');
        });
    }
    function onclick_state_cf7(){
        var state_id =  $('#contact_submit{{ $form_id }} .state-id').val();
        $('.dropdown-city').html('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');
            jQuery('#contact_submit{{ $form_id }} .city-id option:not(:first)').remove();
            $.post( "{{ route('ajax_get_city_by_state') }}", {'_token':'{{ csrf_token() }}', 'id':state_id }).done(function( data ) {
            $('#contact_submit{{ $form_id }} .city-id').append(data);
            $('.dropdown-city').html('');
        });
    }

    function ajax_form_submit_cf7(id){
        var form_label = $('#contact_submit'+id+' input[name="form_label[]"], #contact_submit'+id+'  textarea[name="form_label[]"], #contact_submit'+id+' select[name="form_label[]"]').map(function(){ 
                    return this.value; 
                }).get();
        var form_type = $('#contact_submit'+id+' input[name="form_type[]"]').map(function(){ 
            return this.value; 
            }).get();

        $('.loading_after_submit_form').show();
        $('.form-body-items').addClass('form-body-blur');

        $.ajax({
            url: "{{ route('contact_form.submit_data') }}",
            type: "post",
            cache : false,
            data: {
                '_token':'{{ csrf_token() }}', 
                'form_label': form_label,
                'form_type': form_type,
                'form_id': id,
            },
            success: function(data) {
                if(data['status'] =='success'){
                    $('#contact_submit'+id)[0].reset(); 
                }
                dslp_session_flash(data['status'], data['message']);
                $('.loading_after_submit_form').hide();
                $('.form-body-items').removeClass('form-body-blur');
            }
        });
    }    
</script>
@endsection