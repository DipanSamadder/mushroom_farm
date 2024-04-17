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

	
	Route::get('support/room-production', 'SupportController@room_productions')->name('support.room.productions');

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

	

	

	//Employes

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|employee']], function () {

		Route::get('employes', 'User\EmployesController@index')->name('employes.index');

		Route::get('employe/edit/{id}', 'User\EmployesController@edit')->name('employes.edit');

		Route::post('employe/store', 'User\EmployesController@store')->name('employes.store');

		Route::post('get-all-employes', 'User\EmployesController@get_ajax_employes')->name('ajax_employes');

		Route::post('employe/destory', 'User\EmployesController@destory')->name('employes.destory');

		Route::post('employe/status', 'User\EmployesController@status')->name('employes.status');

		Route::post('employe/update', 'User\EmployesController@update')->name('employes.update');

	}); 

	

	//Vendor

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|vendor']], function () {

		Route::get('vendors', 'User\VendorController@index')->name('vendor.index');

		Route::get('vendors/edit/{id}', 'User\VendorController@edit')->name('vendor.edit');

		Route::post('get-all-vendors', 'User\VendorController@get_ajax_vendors')->name('ajax_vendor');

		Route::post('vendors/destory', 'User\VendorController@destory')->name('vendor.destory');

		Route::post('vendors/status', 'User\VendorController@status')->name('vendor.status');

		Route::post('vendors/update', 'User\VendorController@update')->name('vendor.update');

		Route::post('vendors/store', 'User\VendorController@store')->name('vendor.store');

	});



	//Room
	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|room']], function () {
		Route::get('rooms', 'Room\RoomController@index')->name('rooms.index');
		Route::post('room/edit', 'Room\RoomController@edit')->name('rooms.edit');
		Route::post('room/store', 'Room\RoomController@store')->name('rooms.store');
		Route::post('get-all-rooms', 'Room\RoomController@get_ajax_rooms')->name('ajax_rooms');
		Route::post('room/destory', 'Room\RoomController@destory')->name('rooms.destory');
		Route::post('room/status', 'Room\RoomController@status')->name('rooms.status');
		Route::post('room/update', 'Room\RoomController@update')->name('rooms.update');
	}); 

	
	//RoomHistory

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|room']], function () {
		Route::get('rooms-history', 'Room\RoomHistoryController@index')->name('rooms.history.index');
		Route::post('room-history/edit', 'Room\RoomHistoryController@edit')->name('rooms.history.edit');
		Route::post('room-history/store', 'Room\RoomHistoryController@store')->name('rooms.history.store');
		Route::post('get-all-rooms-history', 'Room\RoomHistoryController@get_ajax_rooms_history')->name('ajax_rooms_history');
		Route::post('room-history/destory', 'Room\RoomHistoryController@destory')->name('rooms.history.destory');
		Route::post('room-history/status', 'Room\RoomHistoryController@status')->name('rooms.history.status');
		Route::post('room-history/update', 'Room\RoomHistoryController@update')->name('rooms.history.update');
		
		Route::get('room-details/edit/{id}', 'Room\RoomHistoryController@details_edit')->name('rooms.details.edit');
		Route::post('room-details/edit', 'Room\RoomHistoryController@details_edit_ajax')->name('rooms.details_ajax.edit');
		Route::post('room/table/details', 'Room\RoomHistoryController@ajax_room_table_details')->name('rooms.table.details');
		Route::post('room-details/update', 'Room\RoomHistoryController@details_update')->name('rooms.details.update');
		Route::post('room-details/get-pending-cycle', 'Room\RoomHistoryController@get_pending_cycle')->name('rooms.details.pending_cycle');
		Route::post('room-production/update', 'Production\ProductionController@production_edit')->name('rooms.production.edit');
	}); 


	//Room Assign

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|room-assgin']], function () {

		Route::get('room-assign', 'Room\RoomAssignController@index')->name('room_assign.index');
		Route::post('get-all-room-assigns', 'Room\RoomAssignController@get_ajax_room_assign')->name('ajax_room_assign');
		Route::post('room-assign/edit', 'Room\RoomAssignController@edit')->name('room_assign.edit');
		Route::post('room-assign/destory', 'Room\RoomAssignController@destory')->name('room_assign.destory');
		Route::post('room-assign/update', 'Room\RoomAssignController@update')->name('room_assign.update');
		Route::post('room-assign/store', 'Room\RoomAssignController@store')->name('room_assign.store');
		Route::post('room-assign/employee/find', 'Room\RoomAssignController@employee_find')->name('room_assign.employee.find');
	});



	//Production category

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|pro_categorie']], function () {
		Route::get('pro-categories', 'Production\CategoryController@index')->name('pro_categorie.index');
		Route::post('pro-categories/edit', 'Production\CategoryController@edit')->name('pro_categorie.edit');
		Route::post('get-all-pro-categories', 'Production\CategoryController@get_ajax_pro_categories')->name('ajax_pro_categorie');
		Route::post('pro-categories/destory', 'Production\CategoryController@destory')->name('pro_categorie.destory');
		Route::post('pro-categories/status', 'Production\CategoryController@status')->name('pro_categorie.status');
		Route::post('pro-categories/update', 'Production\CategoryController@update')->name('pro_categorie.update');
		Route::post('pro-categories/store', 'Production\CategoryController@store')->name('pro_categorie.store');

	}); 







	//grade

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|grade']], function () {

		Route::get('grades', 'Production\GradeController@index')->name('grade.index');

		Route::post('grades/edit', 'Production\GradeController@edit')->name('grade.edit');

		Route::post('get-all-grades', 'Production\GradeController@get_ajax_grades')->name('ajax_grade');

		Route::post('grades/destory', 'Production\GradeController@destory')->name('grade.destory');

		Route::post('grades/status', 'Production\GradeController@status')->name('grade.status');

		Route::post('grades/update', 'Production\GradeController@update')->name('grade.update');

		Route::post('grades/store', 'Production\GradeController@store')->name('grade.store');

	}); 



	//Porduction

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|productions']], function () {

		Route::get('productions', 'Production\ProductionController@index')->name('production.index');

		Route::post('productions/edit', 'Production\ProductionController@edit')->name('production.edit');

		Route::post('get-all-productions', 'Production\ProductionController@get_ajax_productions')->name('ajax_production');

		Route::post('productions/destory', 'Production\ProductionController@destory')->name('production.destory');

		Route::post('productions/status', 'Production\ProductionController@status')->name('production.status');

		Route::post('productions/update', 'Production\ProductionController@update')->name('production.update');

		Route::post('productions/store', 'Production\ProductionController@store')->name('production.store');

	});





	//Sale

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|sale']], function () {

		Route::get('sales', 'Production\SalesController@index')->name('sale.index');

		Route::post('sales/add', 'Production\SalesController@add')->name('sale.add');
		Route::post('sales/edit', 'Production\SalesController@edit')->name('sale.edit');
		Route::post('sales/edit-bluk', 'Production\SalesController@edit_bluk')->name('sale.edit.bluk');

		Route::post('get-all-sales', 'Production\SalesController@get_ajax_sales')->name('ajax_sale_dashboard');

		Route::post('sales/destory', 'Production\SalesController@destory')->name('sale.destory');

		Route::post('sales/status', 'Production\SalesController@status')->name('sale.status');

		Route::post('sales/update', 'Production\SalesController@update')->name('sale.update');

		Route::post('sales/store', 'Production\SalesController@store')->name('sale.store');
		Route::post('sales/bluk-store', 'Production\SalesController@bluk_store')->name('sale.bluk.store');

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

	

	//Labours Rate

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|labours-rate']], function () {

		Route::get('labours-rate', 'User\LabourController@index')->name('labours_rate.index');
		Route::post('get-all-labours-rates', 'User\LabourController@get_ajax_labour')->name('ajax_labours_rate');
		Route::post('labours-rate/edit', 'User\LabourController@edit')->name('labours_rate.edit');
		Route::post('labours-rate/destory', 'User\LabourController@destory')->name('labours_rate.destory');
		Route::post('labours-rate/update', 'User\LabourController@update')->name('labours_rate.update');
		Route::post('labours-rate/store', 'User\LabourController@store')->name('labours_rate.store');

	}); 

	

	//Deduction

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|deduction']], function () {

		Route::get('deductions', 'User\DeductionController@index')->name('deductions.index');
		Route::post('get-all-deductionss', 'User\DeductionController@get_ajax_deduction')->name('ajax_deductions');
		Route::post('deductions/edit', 'User\DeductionController@edit')->name('deductions.edit');
		Route::post('deductions/destory', 'User\DeductionController@destory')->name('deductions.destory');
		Route::post('deductions/update', 'User\DeductionController@update')->name('deductions.update');
		Route::post('deductions/store', 'User\DeductionController@store')->name('deductions.store');

	}); 

	

	//Allowances

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|allowance']], function () {

		Route::get('allowances', 'User\AllowanceController@index')->name('allowances.index');
		Route::post('get-all-allowances', 'User\AllowanceController@get_ajax_allowances')->name('ajax_allowances');
		Route::post('allowances/edit', 'User\AllowanceController@edit')->name('allowances.edit');
		Route::post('allowances/destory', 'User\AllowanceController@destory')->name('allowances.destory');
		Route::post('allowances/update', 'User\AllowanceController@update')->name('allowances.update');
		Route::post('allowances/store', 'User\AllowanceController@store')->name('allowances.store');

	}); 



	//Room Cycle

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|cycle']], function () {
		Route::get('room-cycles', 'Room\RoomCycleController@index')->name('room_cycles.index');
		Route::post('get-all-room-cycles', 'Room\RoomCycleController@get_ajax_room_cycles')->name('ajax_room_cycles');
		Route::post('room-cycles/edit', 'Room\RoomCycleController@edit')->name('room_cycles.edit');
		Route::post('room-cycles/destory', 'Room\RoomCycleController@destory')->name('room_cycles.destory');
		Route::post('room-cycles/update', 'Room\RoomCycleController@update')->name('room_cycles.update');
		Route::post('room-cycles/store', 'Room\RoomCycleController@store')->name('room_cycles.store');
	}); 



	//Designationss

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|designations']], function () {

		Route::get('designations', 'User\DesignationController@index')->name('designations.index');
		Route::post('get-all-designationss', 'User\DesignationController@get_ajax_designations')->name('ajax_designations');
		Route::post('designations/edit', 'User\DesignationController@edit')->name('designations.edit');
		Route::post('designations/destory', 'User\DesignationController@destory')->name('designations.destory');
		Route::post('designations/update', 'User\DesignationController@update')->name('designations.update');
		Route::post('designations/store', 'User\DesignationController@store')->name('designations.store');
	});





	//PaymentMode

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|payment-mode']], function () {

		Route::get('payment-mode', 'Transaction\PaymentModeController@index')->name('payment_mode.index');
		Route::post('get-all-payment-mode', 'Transaction\PaymentModeController@get_ajax_payment_mode')->name('ajax_payment_mode');
		Route::post('payment-mode/edit', 'Transaction\PaymentModeController@edit')->name('payment_mode.edit');
		Route::post('payment-mode/destory', 'Transaction\PaymentModeController@destory')->name('payment_mode.destory');
		Route::post('payment-mode/update', 'Transaction\PaymentModeController@update')->name('payment_mode.update');
		Route::post('payment-mode/store', 'Transaction\PaymentModeController@store')->name('payment_mode.store');

	});





	//CashImprest

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|cash-imprest']], function () {

		Route::get('cash-imprest', 'Transaction\CashController@index')->name('cash.imprest.index');
		Route::post('get-all-cash-imprest', 'Transaction\CashController@get_ajax_cash_imprest')->name('ajax_cash_imprest');
		Route::post('cash-imprest/edit', 'Transaction\CashController@edit')->name('cash.imprest.edit');
		Route::post('cash-imprest/destory', 'Transaction\CashController@destory')->name('cash.imprest.destory');
		Route::post('cash-imprest/update', 'Transaction\CashController@update')->name('cash.imprest.update');
		Route::post('cash-imprest/store', 'Transaction\CashController@store')->name('cash.imprest.store');

	});



	

	//Expenditure

	Route::group(['middleware' => ['role_or_permission:Super-Admin|admin|expenditure']], function () {

		Route::get('expenditure', 'Transaction\ExpenditureController@index')->name('expenditure.index');
		Route::post('get-all-expenditure', 'Transaction\ExpenditureController@get_ajax_expenditure')->name('ajax_expenditure');
		Route::post('expenditure/edit', 'Transaction\ExpenditureController@edit')->name('expenditure.edit');
		Route::post('expenditure/destory', 'Transaction\ExpenditureController@destory')->name('expenditure.destory');
		Route::post('expenditure/update', 'Transaction\ExpenditureController@update')->name('expenditure.update');
		Route::post('expenditure/store', 'Transaction\ExpenditureController@store')->name('expenditure.store');

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

	

