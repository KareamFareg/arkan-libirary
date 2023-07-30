<?php
# Backend Controllers
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BackendAdminController;
use App\Http\Controllers\Backend\BackendNotificationsController;
use App\Http\Controllers\Backend\BackendHelperController;
use App\Http\Controllers\Backend\BackendTestController;
use App\Http\Controllers\Backend\BackendProfileController;
use App\Http\Controllers\Backend\BackendArticleController;
use App\Http\Controllers\Backend\BackendArticleCommentController;
use App\Http\Controllers\Backend\BackendSiteMapController;
use App\Http\Controllers\Backend\BackendSettingController;
use App\Http\Controllers\Backend\BackendContactController;
use App\Http\Controllers\Backend\BackendCategoryController;
use App\Http\Controllers\Backend\BackendRedirectionController;
use App\Http\Controllers\Backend\BackendUserController;
use App\Http\Controllers\Backend\BackendTrafficsController;
use App\Http\Controllers\Backend\BackendPageController;
use App\Http\Controllers\Backend\BackendMenuController;
use App\Http\Controllers\Backend\BackendMenuLinkController;
use App\Http\Controllers\Backend\BackendFileController;
use App\Http\Controllers\Backend\BackendFaqController;
use App\Http\Controllers\Backend\BackendContactReplyController;
use App\Http\Controllers\Backend\BackendAnnouncementController;
use App\Http\Controllers\Backend\BackendPermissionController;
use App\Http\Controllers\Backend\BackendUserPermissionController;
use App\Http\Controllers\Backend\BackendUserRoleController;
use App\Http\Controllers\Backend\BackendRoleController;
use App\Http\Controllers\Backend\BackendTagController;
use App\Http\Controllers\Backend\BackendPluginController;


# Frontend Controllers
use App\Http\Controllers\FrontController;
use App\Http\Controllers\FrontendProfileController;

Auth::routes();





Route::get('/', [FrontController::class,'index'])->name('home');
Route::get('/index2', function(){return view('front.index2');})->name('index2');



Route::prefix('dashboard')->middleware(['auth','ActiveAccount','verified'])->name('user.')->group(function () {
    // Route::get('/', [FrontendProfileController::class,'dashboard'])->name('dashboard');
     Route::get('/', [BackendAdminController::class,'index'])->name('dashboard');


    Route::get('/support', [FrontendProfileController::class,'support'])->name('support');
    Route::get('/support/create-ticket', [FrontendProfileController::class,'create_ticket'])->name('create-ticket');
    Route::post('/support/create-ticket', [FrontendProfileController::class,'store_ticket'])->name('store-ticket');
    Route::get('/support/{ticket}', [FrontendProfileController::class,'ticket'])->name('ticket');
    Route::post('/support/{ticket}/reply', [FrontendProfileController::class,'reply_ticket'])->name('reply-ticket');
    Route::get('/notifications', [FrontendProfileController::class,'notifications'])->name('notifications');
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/settings',[FrontendProfileController::class,'profile_edit'])->name('edit');
        Route::put('/update',[FrontendProfileController::class,'profile_update'])->name('update');
        Route::put('/update-password',[FrontendProfileController::class,'profile_update_password'])->name('update-password');
        Route::put('/update-email',[FrontendProfileController::class,'profile_update_email'])->name('update-email');
    });
});



#Route::get('/test',[BackendTestController::class,'test']);

Route::prefix('admin')->middleware(['auth','ActiveAccount'])->name('admin.')->group(function () {

    Route::get('/',[BackendAdminController::class,'index'])->name('index');
    Route::middleware('auth')->group(function () {
        Route::resource('announcements',BackendAnnouncementController::class);
        Route::resource('files',BackendFileController::class);
        Route::post('contacts/resolve',[BackendContactController::class,'resolve']);
        Route::resource('contacts',BackendContactController::class);
        Route::resource('menus',BackendMenuController::class);
        Route::get('users/{user}/access',[BackendUserController::class,'access'])->name('users.access');
        Route::resource('users',BackendUserController::class);
        Route::resource('roles',BackendRoleController::class);
        Route::resource('permissions',BackendPermissionController::class);
        Route::get('user-roles/{user}',[BackendUserRoleController::class,'index'])->name('users.roles.index');
        Route::put('user-roles/{user}',[BackendUserRoleController::class,'update'])->name('users.roles.update');
        Route::resource('articles',BackendArticleController::class);
        Route::post('article-comments/change_status',[BackendArticleCommentController::class,'change_status'])->name('article-comments.change_status');
        Route::resource('article-comments',BackendArticleCommentController::class);
        Route::resource('pages',BackendPageController::class);
        Route::resource('tags',BackendTagController::class);
        Route::resource('contact-replies',BackendContactReplyController::class);
        Route::post('faqs/order',[BackendFaqController::class,'order'])->name('faqs.order');
        Route::resource('faqs',BackendFaqController::class);
        Route::post('menu-links/get-type',[BackendMenuLinkController::class,'getType'])->name('menu-links.get-type');
        Route::post('menu-links/order',[BackendMenuLinkController::class,'order'])->name('menu-links.order');
        Route::resource('menu-links',BackendMenuLinkController::class);
        Route::resource('categories',BackendCategoryController::class);
        Route::resource('redirections',BackendRedirectionController::class);
        Route::get('traffics',[BackendTrafficsController::class,'index'])->name('traffics.index');
        Route::get('traffics/logs',[BackendTrafficsController::class,'logs'])->name('traffics.logs');
        Route::get('error-reports',[BackendTrafficsController::class,'error_reports'])->name('traffics.error-reports');
        Route::get('error-reports/{report}',[BackendTrafficsController::class,'error_report'])->name('traffics.error-report');
        
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/',[BackendSettingController::class,'index'])->name('index');
            Route::put('/update',[BackendSettingController::class,'update'])->name('update');
        });
    });

    Route::prefix('upload')->name('upload.')->group(function(){
        Route::post('/image',[BackendHelperController::class,'upload_image'])->name('image');
        Route::post('/file',[BackendHelperController::class,'upload_file'])->name('file');
        Route::post('/remove-file',[BackendHelperController::class,'remove_files'])->name('remove-file');
    });

    Route::prefix('plugins')->name('plugins.')->group(function(){
        Route::get('/',[BackendPluginController::class,'index'])->name('index');
        Route::get('/create',[BackendPluginController::class,'create'])->name('create');
        Route::post('/create',[BackendPluginController::class,'store'])->name('store');
        Route::post('/{plugin}/activate',[BackendPluginController::class,'activate'])->name('activate');
        Route::post('/{plugin}/deactivate',[BackendPluginController::class,'deactivate'])->name('deactivate');
        Route::post('/{plugin}/delete',[BackendPluginController::class,'delete'])->name('delete');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/',[BackendProfileController::class,'index'])->name('index');
        Route::get('/edit',[BackendProfileController::class,'edit'])->name('edit');
        Route::put('/update',[BackendProfileController::class,'update'])->name('update');
        Route::put('/update-password',[BackendProfileController::class,'update_password'])->name('update-password');
        Route::put('/update-email',[BackendProfileController::class,'update_email'])->name('update-email');
    });

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/',[BackendNotificationsController::class,'index'])->name('index');
        Route::get('/ajax',[BackendNotificationsController::class,'ajax'])->name('ajax');
        Route::post('/see',[BackendNotificationsController::class,'see'])->name('see');
        Route::get('/create',[BackendNotificationsController::class,'create'])->name('create');
        Route::post('/create',[BackendNotificationsController::class,'store'])->name('store');
    });

});

Route::get('/login/google/redirect', [LoginController::class,'redirect_google']);
Route::get('/login/google/callback', [LoginController::class,'callback_google']);
Route::get('/login/facebook/redirect', [LoginController::class,'redirect_facebook']);
Route::get('/login/facebook/callback', [LoginController::class,'callback_facebook']);


Route::get('blocked',[BackendHelperController::class,'blocked_user'])->name('blocked');
Route::get('robots.txt',[BackendHelperController::class,'robots']);
Route::get('manifest.json',[BackendHelperController::class,'manifest'])->name('manifest');
Route::get('sitemap.xml',[BackendSiteMapController::class,'sitemap']);
Route::get('sitemaps/links',[BackendSiteMapController::class,'custom_links']);
Route::get('sitemaps/{name}/{page}/sitemap.xml',[BackendSiteMapController::class,'viewer']);


Route::view('contact','front.pages.contact')->name('contact');
Route::get('page/{page}',[FrontController::class,'page'])->name('page.show');
Route::get('tag/{tag}',[FrontController::class,'tag'])->name('tag.show');
Route::get('category/{category}',[FrontController::class,'category'])->name('category.show');
Route::get('article/{article}',[FrontController::class,'article'])->name('article.show');
Route::get('blog',[FrontController::class,'blog'])->name('blog');
Route::post('contact',[FrontController::class,'contact_post'])->name('contact-post');
Route::post('comment',[FrontController::class,'comment_post'])->name('comment-post');

//e-book
    Route::get('/ebooks/view', [App\Http\Controllers\Admin\EBookController::class, 'index'])->name('admin.ebooks.index');
    Route::get('/ebooks/viewsingle/{id}', [App\Http\Controllers\Admin\EBookController::class, 'show'])->name('viewsingleebooks');
    Route::get('/ebooks/add', [App\Http\Controllers\Admin\EBookController::class, 'create'])->name('add-ebooks');
    Route::post('/ebooks/insert', [App\Http\Controllers\Admin\EBookController::class, 'store'])->name('insertebooks');
    Route::post('/ebooks/search', [App\Http\Controllers\Admin\EBookController::class, 'searchebook'])->name('searchebook'); 
    Route::get('/ebooks/edit/{id}', [App\Http\Controllers\Admin\EBookController::class, 'edit'])->name('updateebooks');
    Route::post('/ebooks/update/{id}', [App\Http\Controllers\Admin\EBookController::class, 'update'])->name('updateebooks');
    Route::get('/ebooks/delete/{id}', [App\Http\Controllers\Admin\EBookController::class, 'destroy'])->name('deleteebooks'); 
    Route::get('/getsubcat/{id}', [App\Http\Controllers\Admin\customers::class, 'getsubcat'])->name('getsubcat');

    Route::get('/ebooks/featuredEbooks/{id}/{f}', [App\Http\Controllers\Admin\EBookController::class, 'featuredEbooks'])->name('featuredEbooks'); 

    //books
    Route::prefix('products')->name('products.')->group(function(){
        Route::get('/view', [App\Http\Controllers\Admin\ProductController::class, 'view'])->name('view'); 
        Route::get('/viewsingle/{id}', [App\Http\Controllers\Admin\ProductController::class, 'viewsingle'])->name('viewsingle');
        Route::get('/add', [App\Http\Controllers\Admin\ProductController::class, 'addproduct'])->name('create');
        Route::post('/insert', [App\Http\Controllers\Admin\ProductController::class, 'insertproduct'])->name('insertproduct');
        Route::post('/search', [App\Http\Controllers\Admin\ProductController::class, 'searchproduct'])->name('searchproduct'); 
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\ProductController::class, 'editproduct'])->name('editproduct');
        Route::post('/update', [App\Http\Controllers\Admin\ProductController::class, 'updateproduct'])->name('updateproduct');
        Route::get('/delete/{id}', [App\Http\Controllers\Admin\ProductController::class, 'deleteproduct'])->name('deleteproduct'); 
        Route::get('/featuredProduct/{id}/{f}', [App\Http\Controllers\Admin\ProductController::class, 'featuredProduct'])->name('featuredProduct'); 
    
    });
    Route::prefix('customer')->name('customer.')->group(function(){
        Route::get('/add/{id}', [App\Http\Controllers\Admin\customers::class, 'addcustomer'])->name('addcustomer');
        Route::post('/insert', [App\Http\Controllers\Admin\customers::class, 'insertcustomer'])->name('insertcustomer'); 
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\customers::class, 'editcustomer'])->name('contentcustomer');
        Route::post('/update', [App\Http\Controllers\Admin\customers::class, 'updatecustomer'])->name('updatecustomer');
        Route::post('/search/{id?}', [App\Http\Controllers\Admin\customers::class, 'searchcustomer'])->name('searchcustomer');
        Route::get('/view/{id}', [App\Http\Controllers\Admin\customers::class, 'view'])->name('custview');
        Route::get('/viewsingle/{id}', [App\Http\Controllers\Admin\customers::class, 'viewsingle'])->name('viewsingle');
        Route::get('/delete/{id}', [App\Http\Controllers\Admin\customers::class, 'deletecustomer'])->name('deletecustomer');
});
Route::prefix('BookCategory')->name('BookCategory.')->group(function(){
    Route::get('/view', [App\Http\Controllers\Admin\category::class, 'view'])->name('categoryview');
    Route::get('/view/{id}', [App\Http\Controllers\Admin\category::class, 'viewsingle'])->name('categoryviewsingle');
    Route::get('/add', [App\Http\Controllers\Admin\category::class, 'addcategory'])->name('addcategory');
    Route::get('/add/{id}', [App\Http\Controllers\Admin\category::class, 'addsubcategory'])->name('addsubcategory');
    Route::post('/insert', [App\Http\Controllers\Admin\category::class, 'insertcategory'])->name('insertcategory'); 
    Route::get('/edit/{id}', [App\Http\Controllers\Admin\category::class, 'editcategory'])->name('contentcategory');
    Route::post('/update', [App\Http\Controllers\Admin\category::class, 'updatecategory'])->name('updatecategory');
});
Route::prefix('orders')->name('orders.')->group(function(){
    Route::get('/view', [App\Http\Controllers\Admin\orders::class, 'view'])->name('viewallorders');
    Route::get('/order_details/{id}', [App\Http\Controllers\Admin\orders::class, 'order_details'])->name('order_details');
    Route::get('/accept/{t}/{id}', [App\Http\Controllers\Admin\orders::class, 'accept'])->name('accept');
});
Route::prefix('city')->name('city.')->group(function(){
    Route::get('/view', [App\Http\Controllers\Admin\city::class, 'view'])->name('cityview');
    Route::get('/add', [App\Http\Controllers\Admin\city::class, 'addcity'])->name('addcity');
    Route::post('/insert', [App\Http\Controllers\Admin\city::class, 'insertcity'])->name('insertcity'); 
    Route::get('/edit/{id}', [App\Http\Controllers\Admin\city::class, 'editcity'])->name('contentcity');
    Route::post('/update', [App\Http\Controllers\Admin\city::class, 'updatecity'])->name('updatecity');
});
Route::get('/getsubcat/{id}', [App\Http\Controllers\Admin\customers::class, 'getsubcat'])->name('getsubcat');
Route::get('/getcitybyid/{id}', [App\Http\Controllers\Admin\customers::class, 'getcitybyid'])->name('getcitybyid');

Route::get('/specialoffers/view', [App\Http\Controllers\Admin\specialofferscontroller::class, 'view'])->name('viewspecialoffers');
Route::get('/payments/view', [App\Http\Controllers\Admin\paymentscontroller::class, 'view'])->name('viewpayments');