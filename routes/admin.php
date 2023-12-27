<?php



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;



/*

|--------------------------------------------------------------------------

| API Routes

|--------------------------------------------------------------------------

|

| Here is where you can register API routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| is assigned the "api" middleware group. Enjoy building your API!

|

*/
	Route::middleware('guest')->group(function () {
	 	Route::get('login', 'Auth\AuthController@login');
	});
	
 	Route::get('/', 'HomeController@admin_dashboard')->middleware(['auth', 'verified', 'admin'])->name('backend.dashboard');

	

	// Route::get('change-password', function(){

	// 	App\Models\User::where('id', 1)->update(['password' => Hash::make('Admin@!!123')]);

	// });



	Route::get('/optimize', function() {

		Artisan::call('optimize:clear');

		Artisan::call('config:clear');

		Artisan::call('route:clear');

		Artisan::call('view:clear');

		Artisan::call('cache:clear');

		return "Cache is cleared";

	})->name('clear.cache');





	//Profile Users

	Route::get('profiles', 'User\UsersController@profiles')->name('profiles.index');

	Route::post('profiles/update', 'User\UsersController@profiles_update')->name('profiles.update');





	//Media library

	Route::get('media-library-admin', 'UploadsMediaController@media_library_admin')->name('media.library.admin');

	Route::post('media-uploads', 'UploadsMediaController@uploads')->name('media.uploads');

	Route::post('media-files_gets', 'UploadsMediaController@files_gets_admin')->name('media.gets.admin');

	Route::post('media-files_gets_page_edit', 'UploadsMediaController@files_gets_page_edit_admin')->name('media.gets_page_edit.admin');

	Route::post('media-destroy-file', 'UploadsMediaController@files_destroy_admin')->name('media.destroy.admin');

	Route::post('media-files_gets_modals', 'UploadsMediaController@files_gets_admin_modals')->name('media.gets.admin_modals');

	Route::post('media/update', 'UploadsMediaController@update')->name('media.update');

	Route::post('media/edit', 'UploadsMediaController@edit')->name('media.edit');

	Route::post('media-files_gets_page_edit', 'UploadsMediaController@files_gets_page_edit_admin')->name('media.gets_page_edit.admin');





	//Users

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|user']], function () {

		Route::get('users', 'User\UsersController@index')->name('users.index');

		Route::get('user/edit/{id}', 'User\UsersController@edit')->name('users.edit');

		Route::post('user/store', 'User\UsersController@store')->name('users.store');

		Route::post('get-all-users', 'User\UsersController@get_ajax_users')->name('ajax_users');

		Route::post('user/destory', 'User\UsersController@destory')->name('users.destory');

		Route::post('user/status', 'User\UsersController@status')->name('users.status');

		Route::post('user/update', 'User\UsersController@update')->name('users.update');

		Route::post('user/update', 'User\UsersController@update')->name('users.update');

		Route::post('user/permissions', 'User\UsersController@show_permissions')->name('users.show_permissions');

		Route::post('user/assign-permissions', 'User\UsersController@assign_permissions')->name('users.assign_permissions');

	}); 









	//Backend setting

	Route::get('backend-setting', 'Setting\BusinessSettingsController@backend_setting')->name('backend.setting');

	Route::get('frontend-setting', 'Setting\BusinessSettingsController@frontend_setting')->name('frontend.setting');

	Route::post('business-setting-update', 'Setting\BusinessSettingsController@update')->name('business.setting.update');

	Route::post('/env_key_update', 'Setting\BusinessSettingsController@env_key_update')->name('env_key_update.update');





	//Roles

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|roles']], function () {

		Route::resource('roles', 'Setting\RolesController');

		Route::post('get-all-roles', 'Setting\RolesController@get_ajax_roles')->name('ajax_roles');

		Route::post('role/destory', 'Setting\RolesController@destory')->name('role.destory');

		Route::get('role/edit/{id}', 'Setting\RolesController@edit')->name('role.edit');

		Route::post('role/update', 'Setting\RolesController@update')->name('role.update');

		Route::post('role/permissions', 'Setting\RolesController@show_permissions')->name('roles.show_permissions');

		Route::post('role/assign-permissions', 'Setting\RolesController@assign_permissions')->name('roles.assign_permissions');

	}); 



 	//Permissions

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|permissions']], function () {

		Route::resource('permissions', 'Setting\PermissionsController');

		Route::post('get-all-permissions', 'Setting\PermissionsController@get_ajax_permissions')->name('ajax_permissions');

		Route::post('permissions/status', 'Setting\PermissionsController@status')->name('permission.status');



		Route::post('permissions/edit', 'Setting\PermissionsController@edit')->name('permission.edit');

		Route::post('permissions/store', 'Setting\PermissionsController@store')->name('permission.store');

		Route::post('permissions/destory', 'Setting\PermissionsController@destory')->name('permission.destory');

		Route::post('permissions/update', 'Setting\PermissionsController@update')->name('permission.update');

	}); 





	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|pages']], function () {

		Route::get('pages', 'Pages\PagesController@index')->name('pages.index');

		Route::post('get-ajax-pages', 'Pages\PagesController@get_ajax_pages')->name('ajax_pages');

		Route::post('pages/status', 'Pages\PagesController@status')->name('pages.status');

		Route::post('pages/update', 'Pages\PagesController@update')->name('pages.update');
		Route::post('pages/stores', 'Pages\PagesController@store')->name('pages.store');

		Route::post('pages/destory', 'Pages\PagesController@destory')->name('pages.destory');

		Route::any('pages/edit/{id}', 'Pages\PagesController@edit')->name('pages.edit');


		Route::get('pages/destroy/{id}', 'Pages\PagesController@destroy')->name('pages.destroy');

		Route::post('page/edit_extra', 'Pages\PagesController@edit_extra')->name('pages.edit_extra');

		Route::post('page-extra-content/update', 'Pages\PagesController@update_extra_content')->name('pages_extra_content.update');

	});





	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|page-sections']], function () {



		//Page Section

		Route::resource('pages-sections','Pages\PageSectionController', ['names' => [

			'index' => 'pages_section.index',

			'store' => 'pages_section.store',

			]]);

		Route::post('page-sections/edit', 'Pages\PageSectionController@edit')->name('pages_section.edit');

		Route::get('page-sections-fields/edit/{id}', 'Pages\PageSectionController@edit_fields')->name('pages_section_fields.edit');

		Route::post('get-all-page-sections', 'Pages\PageSectionController@get_ajax_page_sections')->name('ajax_page_sections');

		Route::post('page-sections/destory', 'Pages\PageSectionController@destory')->name('pages_section.destory');

		Route::post('page-sections/status', 'Pages\PageSectionController@status')->name('pages_section.status');

		Route::post('page-sections/update', 'Pages\PageSectionController@update')->name('pages_section.update');

		Route::post('page-sections-fields/update', 'Pages\PageSectionController@edit_field_update')->name('pages_section_fields.update');

	});





	//languages

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|languages']], function () {

		Route::get('languages', 'Setting\LanguageController@index')->name('languages.index');

		Route::post('get-all-languages', 'Setting\LanguageController@get_ajax_languages')->name('ajax_languages');

		Route::post('languages/edit', 'Setting\LanguageController@edit')->name('languages.edit');

		Route::post('languages/store', 'Setting\LanguageController@store')->name('languages.store');

		Route::post('languages/destory', 'Setting\LanguageController@destory')->name('languages.destory');

		Route::post('languages/update', 'Setting\LanguageController@update')->name('languages.update');

		

		Route::get('translate', 'Setting\LanguageController@translate')->name('translate.index');

		Route::post('get-all-translates', 'Setting\LanguageController@get_ajax_translates')->name('ajax_translates');

		Route::post('translate/edit', 'Setting\LanguageController@translate_edit')->name('translate.edit');

		Route::post('translate/destory', 'Setting\LanguageController@translate_destory')->name('translate.destory');

		Route::post('translate/update', 'Setting\LanguageController@translate_update')->name('translate.update');

		Route::post('translate/store', 'Setting\LanguageController@translate_store')->name('translate.store');

	}); 



	

	//Template

	Route::group(['middleware' => ['role_or_permission:Super-Admin']], function () {

		Route::get('templates', 'Setting\TemplateController@index')->name('templates.index');

		Route::post('get-all-templatess', 'Setting\TemplateController@get_ajax_templates')->name('ajax_templates');

		Route::post('templates/edit', 'Setting\TemplateController@edit')->name('templates.edit');

		Route::post('templates/destory', 'Setting\TemplateController@destory')->name('templates.destory');

		Route::post('templates/update', 'Setting\TemplateController@update')->name('templates.update');

		Route::post('templates/store', 'Setting\TemplateController@store')->name('templates.store');

	}); 





	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|news-events']], function () {

		Route::get('news-events', 'Pages\NewsEventsController@index')->name('news.events.index');

		Route::post('news-events/get-ajax-data', 'Pages\NewsEventsController@get_ajax_data')->name('news.events.ajax_data');

		Route::post('news-events/edit', 'Pages\NewsEventsController@edit')->name('news.events.edit');

	});

	

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|placements']], function () {

		Route::get('placements', 'Pages\PlacementsController@index')->name('placements.index');

		Route::post('placements/get-ajax-data', 'Pages\PlacementsController@get_ajax_data')->name('placements.ajax_data');

		Route::post('placements/edit', 'Pages\PlacementsController@edit')->name('placements.edit');

	});

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|page-others']], function () {

		Route::get('page-others', 'Pages\PageOthersController@index')->name('page.others.index');

		Route::post('page-others/get-ajax-data', 'Pages\PageOthersController@get_ajax_data')->name('page.others.ajax_data');

		Route::post('page-others/edit', 'Pages\PageOthersController@edit')->name('page.others.edit');

	});


	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|updates']], function () {

		Route::get('updates', 'Pages\NewsUpdateController@index')->name('news.updates.index');
		Route::post('updates/get-ajax-data', 'Pages\NewsUpdateController@get_ajax_data')->name('news.updates.ajax_data');

		Route::post('updates/edit', 'Pages\NewsUpdateController@edit')->name('news.updates.edit');

	});



	//gallery

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|galleries']], function () {

		Route::get('galleries', 'Pages\GalleryPageController@index')->name('galleries.index');
		Route::post('galleries/get-ajax-data', 'Pages\GalleryPageController@get_ajax_data')->name('galleries.ajax_data');

		Route::get('galleries/edit/{id}', 'Pages\GalleryPageController@edit')->name('galleries.edit');



	});

	  

   

    //Contact Form

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|contactfs']], function () {

		Route::resource('contact-form','Setting\ContactFormController', ['names' => [

			'index' => 'contact_form.index',

		]]);

		Route::post('contact-form/edit', 'Setting\ContactFormController@edit')->name('contact_form.edit');



		Route::post('get-all-contact-form', 'Setting\ContactFormController@get_ajax_contact_forms')->name('ajax_contact_forms');



		Route::get('contact-form-fields/edit/{id}', 'Setting\ContactFormController@edit_fields')->name('contact_form_fields.edit');



		Route::post('contact-form-fields/update', 'Setting\ContactFormController@edit_field_update')->name('contact_form_fields.update');



		Route::post('contact-form/update', 'Setting\ContactFormController@update')->name('contact_form.update');



		Route::get('contact-form/leads', 'Setting\ContactFormController@contact_form_leads')->name('contact_form.leads');



		Route::post('get-all-contact-form-leads', 'Setting\ContactFormController@get_ajax_contact_forms_leads')->name('ajax_contact_forms_leads');



		Route::post('contact-form-leads/destory', 'Setting\ContactFormController@leads_destory')->name('contact_form_leads.destory');



		Route::get('contact-form/leads-export/{id}','Setting\ContactFormController@exportCfLeads')->name('cf-export-leads');



	});



	//Contact Form

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|contactfs']], function () {


		Route::get('menus','Setting\MenuController@index')->name('menus.index');


		Route::get('menu/edit/{id}','Setting\MenuController@edit')->name('menus.edit');

		Route::post('menu/store','Setting\MenuController@store')->name('menus.store');

		Route::post('get-all-menus','Setting\MenuController@get_ajax_menus')->name('ajax_menus');

		Route::post('menu/destory','Setting\MenuController@destory')->name('menus.destory');

		Route::post('menu/update','Setting\MenuController@update')->name('menus.update');

		Route::post('menus/status','Setting\MenuController@status')->name('menus.status');

		Route::get('menus-ordering/edit/{type}','Setting\MenuController@menus_ordering')->name('menus.ordering');

		Route::post('menus-ordering/update/','Setting\MenuController@menus_ordering_update')->name('menus.ordering.update');



	});





	//Programs

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|programs']], function () {
		Route::get('programs', 'Pages\ProgramController@index')->name('programs.index');
		Route::post('programs/get-ajax-data', 'Pages\ProgramController@get_ajax_data')->name('programs.ajax_data');

		Route::get('programs/edit/{id}', 'Pages\ProgramController@edit')->name('programs.edit');



	});



	//Departments

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|departments']], function () {

		Route::get('departments', 'Pages\DepartmentsController@index')->name('departments.index');
		Route::post('departments/get-ajax-data', 'Pages\DepartmentsController@get_ajax_data')->name('departments.ajax_data');

		Route::get('departments/edit/{id}', 'Pages\DepartmentsController@edit')->name('departments.edit');

		Route::post('departments/edit_extra', 'Pages\DepartmentsController@department_edit_extra')->name('departments.edit_extra');

	});