<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('routes', function () {
    $routeCollection = Route::getRoutes();

    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "<td width='70%'><h4>Corresponding Action</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td>" . $value->methods()[0] . "</td>";
        echo "<td>" . $value->uri() . "</td>";
        echo "<td>" . $value->getName() . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
    echo count($routeCollection);
    echo "</table>";
});

Route::get('/clear', function () {
    try {


        $out = '';
        Artisan::call('cache:clear');

        $out .= Artisan::output() . '<br>';
        Artisan::call('view:clear');
        $out .= Artisan::output() . '<br>';
        Artisan::call('config:clear');
        $out .= Artisan::output() . '<br>';
        Artisan::call('route:clear');
        $out .= Artisan::output() . '<br>';
        return $out;
    } catch (Exception $exception) {
        dd($exception->getMessage());
    }

});

Route::get('/link', function () {
    Artisan::call('storage:link');
    return Artisan::output() . '<br>';
});

Auth::routes();

Route::get('lang/{locale}', [App\Http\Controllers\LocalizationController::class, 'index']);

//Home
Route::get('/', [App\Http\Controllers\Frontend\HomeFrontendController::class, 'homePageLoad'])->name('frontend.home');

Route::get('/search', [App\Http\Controllers\Frontend\SearchController::class, 'Search'])->name('frontend.search');

Route::prefix('backend')->group(function () {

    //Not Found Page
    Route::get('/notfound', [App\Http\Controllers\HomeController::class, 'notFoundPage'])->name('backend.notfound')->middleware('auth');

    //Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Backend\DashboardController::class, 'getDashboardData'])->name('backend.dashboard')->middleware(['auth']);


    //Users Page
    Route::get('/users', [App\Http\Controllers\Backend\UsersController::class, 'getUsersPageLoad'])->name('backend.users')->middleware(['auth', 'is_admin']);
    Route::get('/getUsersTableData', [App\Http\Controllers\Backend\UsersController::class, 'getUsersTableData'])->name('backend.getUsersTableData')->middleware(['auth', 'is_admin']);
    Route::post('/saveUsersData', [App\Http\Controllers\Backend\UsersController::class, 'saveUsersData'])->name('backend.saveUsersData')->middleware(['auth', 'is_admin']);
    Route::post('/deleteUser', [App\Http\Controllers\Backend\UsersController::class, 'deleteUser'])->name('backend.deleteUser')->middleware(['auth', 'is_admin']);
    Route::post('/bulkActionUsers', [App\Http\Controllers\Backend\UsersController::class, 'bulkActionUsers'])->name('backend.bulkActionUsers')->middleware(['auth', 'is_admin']);

    Route::post('/getUserById', [App\Http\Controllers\Backend\UsersController::class, 'getUserById'])->name('backend.getUserById')->middleware(['auth', 'is_admin_or_editor']);

    //Profile Page
    Route::get('/profile', [App\Http\Controllers\Backend\UsersController::class, 'getProfilePageLoad'])->name('backend.profile')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/profileUpdate', [App\Http\Controllers\Backend\UsersController::class, 'profileUpdate'])->name('backend.profileUpdate')->middleware(['auth', 'is_admin_or_editor']);


    //Multiple sites
    Route::get('/multiple-sites', [App\Http\Controllers\Backend\MultipleSitesController::class, 'getMultipleSitesPageLoad'])->name('backend.MultipleSites')->middleware(['auth', 'is_admin_or_editor']);
    Route::get('/getMultipleSitesTableData', [App\Http\Controllers\Backend\MultipleSitesController::class, 'getMultipleSitesTableData'])->name('backend.getMultipleSitesTableData')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/saveMultipleSitesData', [App\Http\Controllers\Backend\MultipleSitesController::class, 'saveMultipleSitesData'])->name('backend.saveMultipleSitesData')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/deleteMultipleSites', [App\Http\Controllers\Backend\MultipleSitesController::class, 'deleteMultipleSites'])->name('backend.deleteMultipleSites')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/cloneMultipleSites', [App\Http\Controllers\Backend\MultipleSitesController::class, 'cloneMultipleSites'])->name('backend.cloneMultipleSites')->middleware(['auth', 'is_admin_or_editor']);
    Route::get('/site/{id?}', [App\Http\Controllers\Backend\MultipleSitesController::class, 'getMultipleSitesPageData'])->name('backend.site')->middleware(['auth', 'is_admin_or_editor']);

    //Theme Logo
    Route::get('/theme-options', [App\Http\Controllers\Backend\ThemeOptionsController::class, 'getThemeOptionsPageLoad'])->name('backend.theme-options')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/saveThemeLogo', [App\Http\Controllers\Backend\ThemeOptionsController::class, 'saveThemeLogo'])->name('backend.saveThemeLogo')->middleware(['auth', 'is_admin_or_editor']);

    //Categories
    Route::get('/categories', [App\Http\Controllers\Backend\CategoriesController::class, 'getCategoriesPageLoad'])->name('backend.categories')->middleware(['auth', 'is_admin_or_editor']);
    Route::get('/getCategoriesTableData', [App\Http\Controllers\Backend\CategoriesController::class, 'getCategoriesTableData'])->name('backend.getCategoriesTableData')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/saveCategoriesData', [App\Http\Controllers\Backend\CategoriesController::class, 'saveCategoriesData'])->name('backend.saveCategoriesData')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/getCategoriesById', [App\Http\Controllers\Backend\CategoriesController::class, 'getCategoriesById'])->name('backend.getCategoriesById')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/deleteCategories', [App\Http\Controllers\Backend\CategoriesController::class, 'deleteCategories'])->name('backend.deleteCategories')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/bulkActionCategories', [App\Http\Controllers\Backend\CategoriesController::class, 'bulkActionCategories'])->name('backend.bulkActionCategories')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/hasCategorySlug', [App\Http\Controllers\Backend\CategoriesController::class, 'hasCategorySlug'])->name('backend.hasCategorySlug')->middleware(['auth', 'is_admin_or_editor']);

    //News
    Route::get('/news', [App\Http\Controllers\Backend\NewsController::class, 'getNewsPageLoad'])->name('backend.news')->middleware(['auth', 'is_admin_or_editor']);
    Route::get('/getNewsTableData', [App\Http\Controllers\Backend\NewsController::class, 'getNewsTableData'])->name('backend.getNewsTableData')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/saveNewsData', [App\Http\Controllers\Backend\NewsController::class, 'saveNewsData'])->name('backend.saveNewsData')->middleware(['auth', 'is_admin_or_editor']);
    Route::get('/getNewsById', [App\Http\Controllers\Backend\NewsController::class, 'getNewsById'])->name('backend.getNewsById')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/deleteNews', [App\Http\Controllers\Backend\NewsController::class, 'deleteNews'])->name('backend.deleteNews')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/bulkActionNews', [App\Http\Controllers\Backend\NewsController::class, 'bulkActionNews'])->name('backend.bulkActionNews')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/hasNewsSlug', [App\Http\Controllers\Backend\NewsController::class, 'hasNewsSlug'])->name('backend.hasNewsSlug')->middleware(['auth', 'is_admin_or_editor']);

    //Media Page
    Route::get('/media', [App\Http\Controllers\Backend\MediaController::class, 'getMediaPageLoad'])->name('backend.media')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/getMediaById', [App\Http\Controllers\Backend\MediaController::class, 'getMediaById'])->name('backend.getMediaById')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/mediaUpdate', [App\Http\Controllers\Backend\MediaController::class, 'mediaUpdate'])->name('backend.mediaUpdate')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/onMediaDelete', [App\Http\Controllers\Backend\MediaController::class, 'onMediaDelete'])->name('backend.onMediaDelete')->middleware(['auth', 'is_admin_or_editor']);
    Route::get('/getGlobalMediaData', [App\Http\Controllers\Backend\MediaController::class, 'getGlobalMediaData'])->name('backend.getGlobalMediaData')->middleware(['auth', 'is_admin_or_editor']);
    Route::get('/getMediaPaginationData', [App\Http\Controllers\Backend\MediaController::class, 'getMediaPaginationData'])->name('backend.getMediaPaginationData')->middleware(['auth', 'is_admin_or_editor']);
    Route::get('/syncImagesAndTable', [App\Http\Controllers\Backend\MediaController::class, 'syncImagesAndTable'])->name('backend.syncImagesAndTable')->middleware(['auth', 'is_admin_or_editor']);
    Route::get('/insert-hash', [App\Http\Controllers\Backend\MediaController::class, 'insertHash'])->name('backend.insertHash')->middleware(['auth', 'is_admin_or_editor']);
    Route::get('/check-duplicate-images', [App\Http\Controllers\Backend\MediaController::class, 'checkDuplicateImages'])->name('backend.checkDuplicateImages')->middleware(['auth', 'is_admin_or_editor']);

    //All File Upload
    Route::post('/FileUpload', [App\Http\Controllers\Backend\UploadController::class, 'FileUpload'])->name('backend.FileUpload')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/MediaUpload', [App\Http\Controllers\Backend\UploadController::class, 'MediaUpload'])->name('backend.MediaUpload')->middleware(['auth', 'is_admin_or_editor']);

    //Theme Options Social Media
    Route::get('/theme-options-social-media', [App\Http\Controllers\Backend\ThemeOptionsController::class, 'getThemeOptionsSocialMediaPageLoad'])->name('backend.theme-options-social-media')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/saveThemeOptionsSocialMedia', [App\Http\Controllers\Backend\ThemeOptionsController::class, 'saveThemeOptionsSocialMedia'])->name('backend.saveThemeOptionsSocialMedia')->middleware(['auth', 'is_admin_or_editor']);

    //Theme Options ADS Manage
    Route::get('/theme-options-ads-manage', [App\Http\Controllers\Backend\ThemeOptionsController::class, 'getThemeOptionsAdsManagePageLoad'])->name('backend.theme-options-ads-manage')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/saveThemeOptionsAdsManage', [App\Http\Controllers\Backend\ThemeOptionsController::class, 'saveThemeOptionsAdsManage'])->name('backend.saveThemeOptionsAdsManage')->middleware(['auth', 'is_admin_or_editor']);

    //Theme Options SEO
    Route::get('/theme-options-seo', [App\Http\Controllers\Backend\ThemeOptionsController::class, 'getThemeOptionsSEOPageLoad'])->name('backend.theme-options-seo')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/saveThemeOptionsSEO', [App\Http\Controllers\Backend\ThemeOptionsController::class, 'saveThemeOptionsSEO'])->name('backend.saveThemeOptionsSEO')->middleware(['auth', 'is_admin_or_editor']);


    //Theme Options Footer
    Route::get('/theme-options-footer', [App\Http\Controllers\Backend\ThemeOptionsController::class, 'getThemeOptionsFooterPageLoad'])->name('backend.theme-options-footer')->middleware(['auth', 'is_admin_or_editor']);
    Route::post('/saveThemeOptionsFooter', [App\Http\Controllers\Backend\ThemeOptionsController::class, 'saveThemeOptionsFooter'])->name('backend.saveThemeOptionsFooter')->middleware(['auth', 'is_admin_or_editor']);

});


foreach (allCategories() as $category) {
    Route::get($category->slug . '/{newscategory?}', [\App\Http\Controllers\Frontend\NewsController::class, 'news'])->name($category->slug);
    Route::get($category->slug . '/details/{id}/{slug?}', [\App\Http\Controllers\Frontend\NewsController::class, 'newsDetails'])->name($category->slug . '.details');

}

