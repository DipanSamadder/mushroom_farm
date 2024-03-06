<script>
    
    function edit_lg_modal_form(id, route, name){
        $('#edit_larger_modals_body').html('');
        $('#edit_larger_modals').modal('show');
        $('#edit_larger_modals_title').text('Edit '+name);
        $.ajax({
            url: route,
            type: "post",
            cache : false,
            data: {
                '_token':'{{ csrf_token() }}',
                'id': id,
            },
            success: function(d) {
                
                $('#edit_larger_modals_body').html(d);
                $('#edit_larger_modals_body select').select2();
            }
        });
    }


    $(document).ready(function(){
        $('#update_form').on('submit', function(event){
        event.preventDefault();
            var Loader = "#update_form .dsld-btn-loader";

            DSLDButtonLoader(Loader, "start");
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                cache : false,
                data: $(this).serialize(),
                success: function(data) {
                    DSLDButtonLoader(Loader, "");
                    dsldFlashNotification(data['status'], data['message']);
                    
                    $('#update_form .dsld-btn-loader').removeClass('btnloading');
                    if(data['status'] =='success'){
                       
                        get_pages();
                        $('#edit_larger_modals').modal('hide');
                       
                    }
                }
            });
        });
    });

    $(document).ready(function(){
        $('#add_new_form').on('submit', function(event){
        event.preventDefault();var Loader = "#add_new_form .dsld-btn-loader";
            DSLDButtonLoader(Loader, "start");
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                cache : false,
                data: $(this).serialize(),
                success: function(data) {
                    if(data['status'] =='success'){
                        $('#add_new_form')[0].reset();   
                        get_pages();
                    }
                    
                    $('#add_new_form .dsld-btn-loader').removeClass('btnloading');
                    dsldFlashNotification(data['status'], data['message']);
                    DSLDButtonLoader(Loader, "");
                }
            });
        });
    });
   

    function get_pages(){
        var search = $('input[name=search]').val();
        var sort = $('select[name=sort]').val();
        var page = $('#page_no').val();
        var type = $('#type').val();
        var route = $('#get_pages').val();
        $('#data_table').html('<center><img src="{{ dsld_static_asset('backend/assets/images/circle-loading.gif') }}" style="max-width:100px" ></center>');

        $.ajax({
            url: route,
            type: "post",
            cache : false,
            data: {
                    '_token':'{{ csrf_token() }}',
                    'user_id':'{{ Auth::user()->id }}',
                    'search': search,
                    'page': page,
                    'sort': sort,
                    'type': type
                },
            success: function(d) {
                $('#data_table').html(d);
            }
        });
    }

    $(document).ready(function(){
        $('#page_no').val(1);
        get_pages();
    });
    function filter(){
        $('#page_no').val(1);
        get_pages();
    }
    $(document).ready(function()
{
        $(document).on('click', '.pagination a',function(event)
        {
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            event.preventDefault();
            var myurl = $(this).attr('href');
            var page=$(this).attr('href').split('page=')[1];
            $('#page_no').val(page);
            get_pages();
        });
    });

</script>