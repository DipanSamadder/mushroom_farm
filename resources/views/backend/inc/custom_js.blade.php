@if(Session::get('success') != '')

<script> dsldFlashNotification('success', '<?= Session::get('success'); ?>'); </script>

@elseif(Session::get('warning') != '')

<script> dsldFlashNotification('warning', '<?= Session::get('warning'); ?>'); </script>

@elseif(Session::get('info') != '')

<script> dsldFlashNotification('info', '<?= Session::get('info'); ?>'); </script>

@elseif(Session::get('error') != '')

<script> dsldFlashNotification('error', '<?= Session::get('error'); ?>'); </script>

@endif



<script>

var model_open = 0;

    // Function to show the progress bar
    function showProgressBar() {
        $('#top-progress-bar').css('width', '100%');
    }

    // Function to hide the progress bar
    function hideProgressBar() {
        $('#top-progress-bar').css('width', '0');
    }

    // Hook into AJAX events to show/hide the progress bar
    $(document).ajaxStart(function() {
        showProgressBar();
    });

    $(document).ajaxStop(function() {
        hideProgressBar();
    });
function clear_media_file(data){
    $('input'+data).val(0);
    $('div'+data).html('');
    $('img'+data).remove();
    is_edited();
}

function media_file_get(id,cl,ty){

    if($('body').hasClass('modal-open')){

            model_open =1;

    }

    $('#DSLDImageGeT').modal('show');

    get_media_files(id,cl,ty);

}

  function media_file_remove(id,cl,ty){

        $('input.'+cl).val(0);

        $('div.'+cl).html('<strong class="text-warning">Selected Image:</strong><i class="text-warning">' + $('input.'+cl).val() + '</i>');

        

    }

   

    function filter_media(){

        $('#media_page_no').val(1);

        get_media_files();

    }

    function get_media_files(id,cl,ty){

        var search = $('input[name=msearch]').val();

        var sort = $('select[name=sort]').val();

        var media_type = $('select[name=media_type]').val();

        var page = $('#media_page_no').val();

        $('#modal_load_files').html('<center><img src="{{ dsld_static_asset('backend/assets/images/circle-loading.gif') }}" style="max-width:100px" ></center>');



        $.ajax({

            url: "{{ route('media.gets.admin_modals') }}",

            type: "post",

            cache : false,

            data: {'_token':'{{ csrf_token() }}', 'user_id':'{{ Auth::user()->id }}', 'search':search, 'sort':sort, 'media_type':media_type, 'page':page, 'class': cl, 'type':ty, 'id':id},

            success: function(d) {

                $('#modal_load_files').html(d);

            }

        });

    }

    


    function selected_image(id){

       $('input[name=select_media_image_field]').val(id);

       $('#put_media_form_btn').show();

       is_edited();

     

    }



$(document).ready(function()

{

    $(document).on('click', '#put_media_form_btn',function(event){

        $('#DSLDImageGeT').modal('hide');

        var data = $('input[name=put_media_image_field_class]').val();

        $('input.'+data).val($('input[name=select_media_image_field]').val());

        $('div.'+data).html('<strong class="text-warning">Selected Image:</strong><i class="text-warning">' + $('input[name=select_media_image_field]').val() + '</i>');

        

        

    });



    $(document).on('click', '.media .pagination a',function(event)

    {

        $('li').removeClass('active');

        $(this).parent('li').addClass('active');

        event.preventDefault();

        var myurl = $(this).attr('href');

        var page=$(this).attr('href').split('page=')[1];

        $('#media_page_no').val(page);

        get_media_files();

    });

});





function clear_cache(){

    DSLDAjaxSubmitFullLoader('{{ route("clear.cache") }}', '', 'GET', '1');

}



function ajax_get_program_by_institute(){

    var data = $(this).select2('data'); 

    alert(data);

}







function logout(){

    $('.full_page_loader').fadeIn('slow');

    $.post('{{ route("logout") }}', { '_token':'{{ csrf_token() }}'},window.location.replace('{{ route("login") }}'));

}




$(document).ready(function() { 

    

   

     $('#upload_media_form').on('submit', function(event){

        event.preventDefault();

            var images = $('#upload_images').val();

            var formData = new FormData(this);

            let TotalFiles = $('#upload_images')[0].files.length; //Total files

            let files = $('#upload_images')[0];

            for (let i = 0; i < TotalFiles; i++) {

            formData.append('files' + i, files.files[i]);

            }

            formData.append('TotalFiles', TotalFiles);

            if(images != null && images != ''){

                $(this).addClass('btnloading');

                DSLDAjaxSubmit("{{ route('media.uploads') }}", formData, "POST", ".btnloading", 1);

                $(this)[0].reset();

                $('.dropify-render img').attr('src','');

                $('#DSLDImageUpload').modal('hide');

                get_files();

            }else{

                dsldFlashNotification('warning', 'Please select file. Then upload again.');

            }



        });

        $(".select2").select2(); 

  

});



    



$("#DSLDImageGeT").on('hide.bs.modal', function () {

    if(model_open ==1){

        setTimeout(function() {$('body').addClass('modal-open')}, 500);

    }

});

</script>