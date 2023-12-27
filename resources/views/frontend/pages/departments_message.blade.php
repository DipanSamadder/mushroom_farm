@extends('frontend.layouts.app')

@include('frontend.partials.page_meta')

@section('content')

@php 

    $title_page = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $page->key_title));

@endphp

<section class="details_sec common____fix">

<div class="container-fluid g-0">

    <div class="row g-0">

    <div class="col-md-3">

        @include('frontend.partials.sidebar')

    </div>

    <div class="col-md-9">

        @include('frontend.partials.department_banner')

        <div class="below-content-new">

        <h1 class="hossec">

            {{ $page->getTranslation('title', env('DEFAULT_LANGUAGE'));  }}

            @auth()

                <a href="{{ route('departments.edit', [$page->id]) }}"><i class="fas fa-edit"></i> </a>

            @endauth

        </h1>



        @if(!is_null($page->getTranslation('short_content', env('DEFAULT_LANGUAGE'))))

            <p>{{ $page->getTranslation('short_content', env('DEFAULT_LANGUAGE')); }}</p>

        @endif



        @if(!is_null($page->getTranslation('content', env('DEFAULT_LANGUAGE'))) && $page->getTranslation('content', env('DEFAULT_LANGUAGE')) !="<p><br></p>")

            <p>

                @php $str = $page->getTranslation('content', env('DEFAULT_LANGUAGE')); @endphp

                <?php echo htmlspecialchars_decode($str); ?>

            </p>

        @endif



        @if(dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_message_0_image', $page->id) > 0)

            <div class="denninfo">

                <div class="denimd">

                    <img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_message_0_image', $page->id)) }}" style="max-width:320px">

                </div>

                <div class="denind">

                    <div class="namede">

                        <p>{{ dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_message_0_name', $page->id) }}</p>

                    </div>

                    <div class="desig">

                        <div class="desnam">

                            <p>{{ dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_message_0_designations', $page->id) }}</p>

                        </div>

                        <p>{{ dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_message_0_institute', $page->id)}}</p>

                    </div>

                </div>

            </div>

        @endif

        

        @if(!is_null(dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_editor_1', $page->id)) && dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_editor_1', $page->id) !="<p><br></p>")   

            @php $str = dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_editor_1', $page->id); @endphp

            <?php echo htmlspecialchars_decode($str); ?>   

        @endif





        @if(dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_message_2_image', $page->id) > 0)

            <div class="denninfo">

                <div class="denimd">

                    <img src="{{ dsld_uploaded_file_path(dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_message_2_image', $page->id)) }}" style="max-width:320px">

                </div>

                <div class="denind">

                    <div class="namede">

                        <p>{{ dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_message_2_name', $page->id) }}</p>

                    </div>

                    <div class="desig">

                        <div class="desnam">

                            <p>{{ dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_message_2_designations', $page->id) }}</p>

                        </div>

                        <p>{{ dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_message_2_institute', $page->id)}}</p>

                    </div>

                </div>

            </div>

        @endif





        @if(!is_null(dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_editor_3', $page->id)) && dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_editor_3', $page->id) !="<p><br></p>")   

            @php $str = dsld_page_meta_value_by_meta_key($title_page.'_messagetemplate_editor_3', $page->id); @endphp

            <?php echo htmlspecialchars_decode($str); ?>   

        @endif

        @include('frontend.partials.updates')

        </div>

    </div>

    </div>

</div>

</section>

@endsection

