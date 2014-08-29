<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/',[
	'as'	=>		'welcome.user',
	function(){
		return Redirect::route('user-panel');
	}]);

Route::get('admin',[
	'as'	=>		'welcome.admin',
	function(){
		return Redirect::to('admin-panel');
	}]);

Route::get('admin/login',[
	'as'		=>		'admin.login.form',
	'uses'		=>		'LoginController@getAdmin',
	]);

Route::post('admin/login',[
	'as'		=>		'admin.login',
	'uses'		=>		'LoginController@postAdmin',
	]);

// Route::get('admin/logout',[
// 	'as'		=>		'admin.logout',
// 	'uses'		=>		'LoginController@getAdminLogout'
// 	]);

Route::controller('/login','LoginController',[
	'getIndex'		=>		'user.login.form',
	'postLogin'		=>		'user.login',
	// 'getAdmin'		=>		'admin.login.form',
	// 'postAdmin'		=>		'admin.login',
	// 'getAdminLogout'	=>		'admin.logout',
	]);


/**
 * Prefix all the routes to User Panel with /user-panel/
 */
Route::group(['prefix'=>'user-panel','before'=>'isUser'], function(){
	

	Route::get('/',function(){
		return Redirect::route('user-panel');
	});

	Route::get('logout',[
		'as'	=>		'user.logout',
		function(){
			Auth::logout();
			return Redirect::route('user.login.form');
		}]);

	Route::controller('my-account','UserController',[
			  'getIndex'   =>	'user-panel',
		  	 'getRecharge' =>	'user.recharge.form',
		 'postPinRecharge' =>	'user.pin.recharge',
     'getRechargeHistory'  =>	'user.recharge.history',
	  'getSessionHistory'  =>	'user.session.history',
	  'getChangePassword'  =>	'user.password.form',
	  'postChangePassword' =>	'user.changepassword',
		]);
});


/**
 * Prefix all the routes to Admin Panel with /admin-panel/
 */
Route::group( ['prefix'=>'admin-panel',
	'before'=>'isAdmin'
	], function() {

	Route::get('/',[
		'as'	=>		'admin-panel',
		function(){
			return Redirect::route('subscriber.active');
		}]);

	Route::get('logout',[
		'as'	=>		'admin.logout',
		function(){
			Auth::logout();
			Session::flash('success', "Logout Successful.");
			return Redirect::route('admin.login');
		}]);
	Route::get('system/about',[
		'as'	=>		'system.about',
		'uses'	=>		'SystemController@about'
		]);

Route::controller('bandwidth-policies', 'PoliciesController', [
			'getIndex'  =>	'policies.index',
			'getAdd'	=>	'policy.add.form',
			'postAdd'	=>	'policy.add',
			'getEdit'	=>	'policy.edit.form',
			'postEdit'	=>	'policy.edit',
			'postDelete'=>	'policy.delete',
	]);

Route::controller('policy-schemas', 'SchemasController',[
			'getIndex'		=>		'schema.index',
			'getAdd'		=>		'schema.add.form',
			'postAdd'		=>		'schema.add',
			'getEdit'		=>		'schema.edit.form',
			'postEdit'		=>		'schema.edit',
			'postDelete'	=>		'schema.delete',

			'getTemplateIndex'	=>		'schematemplate.index',
			'getAddTemplate'	=>		'schematemplate.add.form',
			'postAddTemplate'	=>		'schematemplate.add',
			'getEditTemplate'	=>		'schematemplate.edit.form',
			'postEditTemplate'	=>		'schematemplate.edit',
			'postDeleteTemplate'	=>	'schematemplate.delete',
	]);

Route::controller('subscribers', 'AccountsController',[
			'getIndex'			=>		'subscriber.index',
			'getAdd'			=>		'subscriber.add.form',
			'postAdd'			=>		'subscriber.add',
			'getEdit'			=>		'subscriber.edit.form',
			'postEdit'			=>		'subscriber.edit',
			'postDelete'		=>		'subscriber.delete',
			'getActive'			=>		'subscriber.active',
			'getProfile'		=>		'subscriber.profile',
			'postResetPassword'	=>		'subscriber.reset.password',
			'postRefill'		=>		'subscriber.refill',
	]);

Route::controller('prepaid-vouchers','VouchersController',[
			'getIndex'			=>		'voucher.index',
			'getGenerate'		=>		'voucher.generate.form',
			'postGenerate'		=>		'voucher.generate',
			'getRecharge'		=>		'voucher.recharge.form',
			'postRecharge'		=>		'voucher.recharge',
			'postSelectTemplate'=>		'voucher.handle',
			'postPrint'			=>		'voucher.print',
	]);

Route::controller('service-plans','ServicePlansController',[
			'getIndex'			=>		'plan.index',
			'getAdd'			=>		'plan.add.form',
			'postAdd'			=>		'plan.add',
			'getEdit'			=>		'plan.edit.form',
			'postEdit'			=>		'plan.edit',
			'postDelete'		=>		'plan.delete',
	]);

Route::controller('routers','RoutersController',[
			'getIndex'			=>		'router.index',
			'getAdd'			=>		'router.add.form',
			'postAdd'			=>		'router.add',
			'getEdit'			=>		'router.edit.form',
			'postEdit'			=>		'router.edit',
			'postDelete'		=>		'router.delete',
	]);

Route::controller('templates','TemplatesController',[
			'getVoucherTemplates'	=>	'tpl.voucher.index',
			'getAddVoucherTemplate'	=>	'tpl.voucher.add.form',
			'postAddVoucherTemplate' =>	'tpl.voucher.add',
			'getEditVoucherTemplate' =>	'tpl.voucher.edit.form',
			'postEditVoucherTemplate' => 'tpl.voucher.edit',
			'postDeleteVoucherTemplate' => 'tpl.voucher.delete',

			'getEmailTemplates'		=>		'tpl.email.index',
			'getAddEmailTemplate'	=>		'tpl.email.add.form',
			'postAddEmailTemplate'	=>		'tpl.email.add',
			'getEditEmailTemplate'	=>		'tpl.email.edit.form',
			'postEditEmailTemplate'	=>		'tpl.email.edit',
			'postDeleteEmailTemplate'	=>	'tpl.email.delete',
	]);
Route::controller('settings','SettingsController',[
			'getGeneral'		=>		'setting.general.form',
			'postGeneral'		=>		'setting.general',
			'getEmail'			=>		'setting.email.form',
			'postEmail'			=>		'setting.email',
			'getSmtp'			=>		'setting.smtp.form',
			'postSmtp'			=>		'setting.smtp',
			'getPaypal'			=>		'setting.paypal.form',
			'postPaypal'		=>		'setting.paypal',
			'getThemes'			=>		'setting.themes.form',
			'postThemes'		=>		'setting.themes',
	]);

Route::controller('my-profile','AdminProfileController',[
			'getEdit'			=>		'admin.profile.edit',
			'postEdit'			=>		'admin.profile',
			'getChangePassword'	=>		'admin.changepassword.form',
			'postChangePassword'=>		'admin.changepassword',
	]);
	

}); //ends Admin Prefix.

/**
 * Registering Form Macros.
 */
Form::macro('helpBlock',function($string){
	return "<span class='help-block'>$string</span>";
});

Form::macro('error', function($errors, $field){
  if( $errors->has($field) )
    return 'has-error';
  return NULL;
});

Form::macro('edit', function($path,$value = 'update'){
	return "<a href='{$path}' class='btn btn-xs btn-default'>
                <i class='fa fa-edit'></i> {$value}</a>";
});

Form::macro('delete', function($value = 'delete'){
	return "<button type='submit' class='btn btn-xs btn-danger'>
	<i class='fa fa-trash-o'></i> {$value}
	 </button>";
});

Form::macro('actions', function ($edit_path, $del_path, $edit='update', $delete='delete'){
	return	Form::open(['url'=>$del_path,'onsubmit'=>"return confirm('Do you really want to delete?')"]).
	 "<a href='{$edit_path}' class='btn btn-xs btn-default'>
                <i class='fa fa-edit'></i> {$edit}</a>" .
                "<button type='submit' class='btn btn-xs btn-danger'>
	<i class='fa fa-trash-o'></i> {$delete}
	 </button>" .
	 Form::close();
});

Form::macro('buttons', function($submit = 'Save Changes'){
	return "<div class='btn-toolbar'>
          <div class='btn-group'>" .
          Form::button('Reset', ['type'=>'reset','class'=>'btn btn-default']) .
          Form::submit($submit,['class'=>'btn btn-primary']) .
          "</div>
        </div>";
});


//end of file routes.php