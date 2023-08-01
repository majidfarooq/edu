<?php

use App\Http\Controllers\backend\{
    AdminController,
    CategoryController,
    ElementController,
    MediaController,
    MenuController,
    PageController,
    PostController,
    TagController,
    UserController,
};

use App\Http\Controllers\frontend\{
    CategoryController as FrontCategoryController,
    ContactController as FrontContactController,
    PageController as FrontPageController,
    PostController as FrontPostController,
    PropertiesController,
    CoursesController,
    HomeController,
    ApplicationController
};

use Illuminate\Support\Facades\Route;

Route::get('/category/{slug}', [FrontPostController::class, 'showCategory'])->name('category.show');
Route::get('/tag/{slug}', [FrontPostController::class, 'showTag'])->name('tag.show');
Route::get('/blog/{slug}', [FrontPostController::class, 'show'])->name('blog.show');
Route::get('/blog', [FrontPostController::class, 'index'])->name('blogs.index');
Route::get('/author/{name}', [FrontPostController::class, 'author'])->name('author.index');
Route::get('/search/', [FrontPageController::class, 'search'])->name('search.index');
Route::any('/searchInformation/', [FrontPageController::class, 'searchInform'])->name('searchInform');
Route::any('/reset/password/{auth?}', [FrontPageController::class, 'resetUserPassword'])->name('resetUserPassword');
Route::any('user/courses/sorting/{id?}', [CoursesController::class, 'courseSorting'])->name('courseSorting');
Route::any('user/courses/searchCourse/{id?}', [CoursesController::class, 'searchCourse'])->name('searchCourse');
Route::any('testBody/{id?}', [CoursesController::class, 'testBody'])->name('testBody');

Route::get('/listings', [PropertiesController::class, 'listings'])->name('listings');
Route::post('/search', [PropertiesController::class, 'search'])->name('search');
Route::get('/listings/{slug}/detail', [PropertiesController::class, 'detail'])->name('detail');
Route::post('/contactPost', [FrontContactController::class, 'contactPost'])->name('contactForm');
Route::get('/contact', [FrontContactController::class, 'contact'])->name('contact');

Route::get('/university/contact', [FrontContactController::class, 'universityContact'])->name('universityContact');
Route::post('/university/universityContactPost', [FrontContactController::class, 'universityContactPost'])->name('universityContactPost');

Route::get('password/change/request/{var?}', [FrontPageController::class, 'home'])->name('passwordChangeRequest');
Route::get('/', [FrontPageController::class, 'home'])->name('home');

Route::any('emailTesting/', [HomeController::class, 'emailTesting'])->name('emailTesting');
Route::any('setFullnames/', [HomeController::class, 'setFullnames'])->name('setFullnames');

Route::any('submitPopupRes/{var?}', [HomeController::class, 'submitPopupRes'])->name('submitPopupRes');
Route::any('getUniProgrames/{var?}', [HomeController::class, 'getUniProgrames'])->name('getUniProgrames');
Route::any('facebook-signup/{var?}', [HomeController::class, 'facebook_signup'])->name('facebook-signup');
Route::any('google-signup/{var?}', [HomeController::class, 'google_signup'])->name('google-signup');
Route::any('get_social_credentials/', [HomeController::class, 'get_social_credentials'])->name('get_social_credentials');
Route::any('get_social_credentials_google/', [HomeController::class, 'get_social_credentials_google'])->name('get_social_credentials_google');
Route::any('facebook-response/{var?}', [HomeController::class, 'facebook_login'])->name('facebook-response');
Route::any('setUserType/{var?}', [HomeController::class, 'setUserType'])->name('setUserType');
Route::any('resetPassword/{var?}', [HomeController::class, 'resetPassword'])->name('resetPassword');
Route::any('resetPasswordNow/{var?}', [HomeController::class, 'resetPasswordNow'])->name('resetPasswordNow');
Route::any('google-login/{var?}', [HomeController::class, 'googleSignup'])->name('google-login');
Route::any('updateProfile/', [HomeController::class, 'updateProfile'])->name('updateProfile');
Route::any('studentFactors/', [HomeController::class, 'studentFactors'])->name('studentFactors');
Route::any('submitsignup/', [HomeController::class, 'store'])->name('submitsignup');
//Route::post('check-email-availability/', [HomeController::class, 'checkEmailAvailability'])->name('checkEmailAvailability');
Route::any('submitSecond/', [HomeController::class, 'submitSecond'])->name('submitSecond');
Route::any('submitThird/', [HomeController::class, 'submitThird'])->name('submitThird');
Route::any('submitFourth/', [HomeController::class, 'submitFourth'])->name('submitFourth');
Route::any('signup/profile/{id?}', [HomeController::class, 'second_step'])->name('second_step');
Route::any('signup/addresses/{id?}', [HomeController::class, 'third_step'])->name('third_step');
Route::any('signup/educational/{id?}', [HomeController::class, 'fourth_step'])->name('fourth_step');
Route::any('user/logout/', [HomeController::class, 'logout'])->name('logout');
Route::any('user/login/', [HomeController::class, 'loginUser'])->name('loginUser');
Route::any('thankyou/', [HomeController::class, 'thankyou'])->name('thankyou');
Route::any('unpublish/', [HomeController::class, 'unpublish'])->name('unpublish');
Route::any('user/searchUniversity/', [HomeController::class, 'searchUniversity'])->name('searchUniversity');
Route::any('university/detail/{id?}', [HomeController::class, 'universityDetail'])->name('universityDetail');
//Route::any('university/detail/{id?}', [HomeController::class, 'universityDetail'])->name('university-detail');


Route::group(['namespace' => 'frontend', 'middleware' => ['auth:web']], function () {
    Route::any('addStartRatings/', [HomeController::class, 'addStartRatings'])->name('addStartRatings');
    Route::any('removeRatingsFactor/', [HomeController::class, 'removeRatingsFactor'])->name('removeRatingsFactor');
    Route::any('applyUniversity/{id?}', [HomeController::class, 'applyUniversity'])->name('applyUniversity');
    Route::any('changeStatusMultipleStatus/{id?}', [HomeController::class, 'changeStatusMultipleStatus'])->name('changeStatusMultipleStatus');
    Route::any('markFavourite/{id?}', [HomeController::class, 'markFavourite'])->name('markFavourite');
    Route::any('user/dashboard/{pattern?}/{type?}', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::any('user/profile/{id?}', [HomeController::class, 'StudentProfile'])->name('StudentProfile');
    Route::any('student/offer/{id?}', [HomeController::class, 'studentOffer'])->name('studentOffer');
    Route::any('submitOffer/{id?}', [ApplicationController::class, 'submitOffer'])->name('submitOffer');
    Route::any('changeApplicationStatus/{id?}', [ApplicationController::class, 'changeApplicationStatus'])->name('changeApplicationStatus');
    Route::any('storeLatLong/{id?}', [ApplicationController::class, 'storeLatLong'])->name('storeLatLong');
    Route::any('ChangeofferStatus/{id?}', [ApplicationController::class, 'ChangeofferStatus'])->name('ChangeofferStatus');
    Route::any('user/courses/edit/{id?}', [CoursesController::class, 'edit'])->name('courses-edit');
    Route::any('user/courses/update/{id?}', [CoursesController::class, 'update'])->name('courses-update');
    Route::any('user/courses/listing/{type?}', [CoursesController::class, 'index'])->name('courses-listing');
    Route::any('user/courses/create/{type?}', [CoursesController::class, 'store'])->name('courses-create');
    Route::any('user/courses/delete/{id?}', [CoursesController::class, 'destroy'])->name('courses-delete');

});

//Route::view('login', 'backend.login.login')->name('admin.login');

//Route::any('admin', [AdminController::class, 'login'])->name('admin.auth');

Route::any('admin', [AdminController::class, 'login'])->name('admin');
Route::any('login', [AdminController::class, 'login'])->name('login');
Route::any('admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::any('admin-login-auth', [AdminController::class, 'loginSubmit'])->name('admin.auth');

Route::group(['prefix'=>'admin','namespace' => 'backend','middleware' => ['auth:admin']],function() {
    Route::any('changeApplicationModal/{id?}', [ApplicationController::class, 'changeApplicationModal'])->name('changeApplicationModal');

    Route::get('/dashboard/{sort?}', [AdminController::class, 'dashboard'])->name('admin-dashboard');
    Route::get('/dashboard/{sort?}', [AdminController::class, 'dashboard'])->name('admin.home');
    Route::any('/applications', [AdminController::class, 'applications'])->name('admin.applications');
    Route::get('/account', [AdminController::class, 'account'])->name('account.settings');
    Route::post('/change/information', [AdminController::class, 'basicInformation'])->name('account.information');
    Route::post('/change/password', [AdminController::class, 'changePassword'])->name('account.password');
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('medias', [MediaController::class, 'index'])->name('media.index');

    Route::any('marKHbcu', [UserController::class, 'marKHbcu'])->name('marKHbcu');
    Route::any('activeInActive', [UserController::class, 'activeInActive'])->name('activeInActive');
    Route::any('marKFeatured', [UserController::class, 'marKFeatured'])->name('marKFeatured');
    Route::any('users/student', [UserController::class, 'student'])->name('users.student');
    Route::any('users/university', [UserController::class, 'university'])->name('users.university');
    Route::any('users/details/{id?}', [UserController::class, 'userdetail'])->name('user-detail');
    Route::get('users/show/{var?}', [UserController::class, 'show'])->name('admin.users.show');
    Route::any('users/delete/{var?}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::any('users/applications/delete/{var?}', [UserController::class, 'deleteApplications'])->name('admin.application.destroy');
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('admin.users.restore');

//  Categories
    Route::any('categories/', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::post('categories/{slug}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::post('categories/{slug}/update', [CategoryController::class, 'update'])->name('admin.categories.update');

//  Tags
    Route::get('tags', [TagController::class, 'index'])->name('admin.tags.index');
    Route::get('tag/create', [TagController::class, 'create'])->name('admin.tag.create');
    Route::post('tag/store', [TagController::class, 'store'])->name('admin.tag.store');
    Route::get('tag/{slug}/edit', [TagController::class, 'edit'])->name('admin.tag.edit');
    Route::post('tag/{slug}/update', [TagController::class, 'update'])->name('admin.tag.update');
    Route::post('tag/{id}/destroy', [TagController::class, 'destroy'])->name('admin.tag.destroy');

    Route::any('posts/', [PostController::class, 'index'])->name('admin.posts.index');
    Route::get('post/create', [PostController::class, 'create'])->name('admin.post.create');
    Route::post('post/store', [PostController::class, 'store'])->name('admin.post.store');
    Route::post('post/{slug}/edit', [PostController::class, 'edit'])->name('admin.post.edit');
    Route::post('post/update', [PostController::class, 'update'])->name('admin.post.update');
    Route::delete('post/{id}/delete', [PostController::class, 'destroy'])->name('admin.post.destroy');
    Route::post('post/{id}/restore', [PostController::class, 'restore'])->name('admin.post.restore');

    Route::get('menu/show/{menu:slug}', [MenuController::class, 'show'])->name('menu.show');
    Route::post('menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::post('menu/list', [MenuController::class, 'listMenu'])->name('listMenu');
    Route::post('menu/delete', [MenuController::class, 'delete'])->name('menu.delete');

    Route::any('pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('page/create', [PageController::class, 'create'])->name('page.create');
    Route::post('page/edit/{page:slug}', [PageController::class, 'create'])->name('page.edit');
    Route::put('page/update/{page}', [PageController::class, 'update'])->name('page.update');
    Route::delete('page/{id}/disable', [PageController::class, 'disable'])->name('page.disable');
    Route::delete('page/{id}/destroy', [PageController::class, 'destroy'])->name('page.destroy');
    Route::post('page/{id}/restore', [PageController::class, 'restore'])->name('page.restore');

    Route::post('getChildPageElement', [PageController::class, 'getChildPageElement'])->name('getChildPageElement');
    Route::post('getElement', [PageController::class, 'getElement'])->name('getElement');
    Route::post('addSection', [PageController::class, 'addSection'])->name('addSection');

    Route::get('page/edit/element/{id?}', [PageController::class, 'editInnerElement'])->name('editInnerElement');
    Route::post('InnerElement/store', [PageController::class, 'storeInnerElement'])->name('storeInnerElement');
    Route::post('storeChildPe', [PageController::class, 'storeChildPe'])->name('storeChildPe');
    Route::post('InnerElement/update', [PageController::class, 'updateInnerElement'])->name('updateInnerElement');
    Route::post('getPageSections', [PageController::class, 'getPageSections'])->name('getPageSections');
    Route::post('section/order', [PageController::class, 'sectionOrder'])->name('parent.order');
    Route::post('section/delete', [PageController::class, 'deleteSection'])->name('delete.section');
    Route::post('change/selector', [PageController::class, 'changeSelector'])->name('changeSelector');
    Route::post('elements/delete', [PageController::class, 'deleteElements'])->name('element.delete');

    Route::any('elements', [ElementController::class, 'index'])->name('elements.index');
    Route::get('element/create', [ElementController::class, 'create'])->name('element.create');
    Route::post('element/store', [ElementController::class, 'store'])->name('element.store');
    Route::get('element/edit/{element:id}', [ElementController::class, 'edit'])->name('element.edit');
    Route::post('element/update', [ElementController::class, 'update'])->name('element.update');
    Route::post('elementDelete', [ElementController::class, 'delete'])->name('elementDelete');

    Route::post('field/create', [ElementController::class, 'fieldCreate'])->name('field.create');
    Route::post('field/get', [ElementController::class, 'fieldGet'])->name('field.get');
    Route::post('field/update', [ElementController::class, 'fieldUpdate'])->name('field.update');
    Route::post('field/delete', [ElementController::class, 'fieldDelete'])->name('field.delete');

});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE';
});
Route::get('/cli/migrate', function () {
    Artisan::call('migrate');
});
Route::get('/cli/config', function () {
    Artisan::call('config:cache');
});
Route::get('/cli/con', function () {
    Artisan::call('cache:clear');
});
Route::get('/cli/seed', function () {
    Artisan::call('db:seed');
});
Route::get('/cli/view', function () {
    Artisan::call('view:clear');
});
Route::get('/cli/queue', function () {
    Artisan::call('queue:work');
});
Route::get('/cli/sto', function () {
    Artisan::call('storage:link');
});
Route::get('/cli/route', function () {
    Artisan::call('route:clear');
});
Route::get('/cli/cache', function () {
    Artisan::call('route:cache');
});
Route::get('/cli/bread', function () {
    Artisan::call('vendor:publish', '--provider="DaveJamesMiller\Breadcrumbs\BreadcrumbsServiceProvider"');
});

Route::get('/{page:slug}', [FrontPageController::class, 'show'])->name('page.show');
