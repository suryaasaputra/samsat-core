<?php

use App\Http\Controllers\Admin\PenerimaanHarianController as PenerimaanAdmin;
use App\Http\Controllers\Admin\PenerimaanOpsen;
use App\Http\Controllers\Admin\RekapitulasiPenerimaanDetailController as RekapDetailAdmin;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CetakNoticeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenerimaanHarianController;
use App\Http\Controllers\PenerimaanHarianOpsenController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapitulasiPenerimaanDetailController;
use App\Http\Controllers\RekapitulasiPenerimaanPerUserController;
use App\Http\Controllers\RekapitulasiPenerimaanRingkasController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UlangCetakNoticeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZenixadminController;
use App\Models\NamaLokasi;
use Illuminate\Http\Request;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('login'); // Redirect to the login page
});

Route::get('/check-ip', function (Request $request) {
    return "IP address Anda: " . $request->ip();
});

// Route::get('/', [ZenixadminController::class, 'dashboard_1']);
// Route::get('/', [ZenixadminController::class, 'dashboard_1']);
Route::get('/index', [ZenixadminController::class, 'dashboard_1']);
// Route::get('/index-2', [ZenixadminController::class, 'dashboard_2']);
// Route::get('/coin-details', [ZenixadminController::class, 'coin_details']);
// Route::get('/portofolio', [ZenixadminController::class, 'portofolio']);
// Route::get('/market-capital', [ZenixadminController::class, 'market_capital']);
// Route::get('/tranasactions', [ZenixadminController::class, 'tranasactions']);
// Route::get('/my-wallets', [ZenixadminController::class, 'my_wallets']);
// Route::get('/app-profile', [ZenixadminController::class, 'app_profile']);
// Route::get('/post-details', [ZenixadminController::class, 'post_details']);
// Route::get('/page-chat', [ZenixadminController::class, 'page_chat']);
// Route::get('/project-list', [ZenixadminController::class, 'project_list']);
// Route::get('/project-card', [ZenixadminController::class, 'project_card']);
// Route::get('/contact-list', [ZenixadminController::class, 'contact_list']);
// Route::get('/contact-card', [ZenixadminController::class, 'contact_card']);
// Route::get('/email-compose', [ZenixadminController::class, 'email_compose']);
// Route::get('/email-inbox', [ZenixadminController::class, 'email_inbox']);
// Route::get('/email-read', [ZenixadminController::class, 'email_read']);
// Route::get('/app-calender', [ZenixadminController::class, 'app_calender']);
// Route::get('/ecom-checkout', [ZenixadminController::class, 'ecom_checkout']);
// Route::get('/ecom-customers', [ZenixadminController::class, 'ecom_customers']);
// Route::get('/ecom-invoice', [ZenixadminController::class, 'ecom_invoice']);
// Route::get('/ecom-product-detail', [ZenixadminController::class, 'ecom_product_detail']);
// Route::get('/ecom-product-grid', [ZenixadminController::class, 'ecom_product_grid']);
// Route::get('/ecom-product-list', [ZenixadminController::class, 'ecom_product_list']);
// Route::get('/ecom-product-order', [ZenixadminController::class, 'ecom_product_order']);
// Route::get('/chart-chartist', [ZenixadminController::class, 'chart_chartist']);
// Route::get('/chart-chartjs', [ZenixadminController::class, 'chart_chartjs']);
// Route::get('/chart-flot', [ZenixadminController::class, 'chart_flot']);
// Route::get('/chart-morris', [ZenixadminController::class, 'chart_morris']);
// Route::get('/chart-peity', [ZenixadminController::class, 'chart_peity']);
// Route::get('/chart-sparkline', [ZenixadminController::class, 'chart_sparkline']);
// Route::get('/ui-accordion', [ZenixadminController::class, 'ui_accordion']);
// Route::get('/ui-alert', [ZenixadminController::class, 'ui_alert']);
// Route::get('/ui-badge', [ZenixadminController::class, 'ui_badge']);
// Route::get('/ui-button', [ZenixadminController::class, 'ui_button']);
// Route::get('/ui-button-group', [ZenixadminController::class, 'ui_button_group']);
// Route::get('/ui-card', [ZenixadminController::class, 'ui_card']);
// Route::get('/ui-carousel', [ZenixadminController::class, 'ui_carousel']);
// Route::get('/ui-dropdown', [ZenixadminController::class, 'ui_dropdown']);
// Route::get('/ui-grid', [ZenixadminController::class, 'ui_grid']);
// Route::get('/ui-list-group', [ZenixadminController::class, 'ui_list_group']);
// Route::get('/ui-media-object', [ZenixadminController::class, 'ui_media_object']);
// Route::get('/ui-modal', [ZenixadminController::class, 'ui_modal']);
// Route::get('/ui-pagination', [ZenixadminController::class, 'ui_pagination']);
// Route::get('/ui-popover', [ZenixadminController::class, 'ui_popover']);
// Route::get('/ui-progressbar', [ZenixadminController::class, 'ui_progressbar']);
// Route::get('/ui-tab', [ZenixadminController::class, 'ui_tab']);
// Route::get('/ui-typography', [ZenixadminController::class, 'ui_typography']);
Route::get('/uc-nestable', [ZenixadminController::class, 'uc_nestable']);
// Route::get('/uc-lightgallery', [ZenixadminController::class, 'uc_lightgallery']);
// Route::get('/uc-noui-slider', [ZenixadminController::class, 'uc_noui_slider']);
// Route::get('/uc-select2', [ZenixadminController::class, 'uc_select2']);
// Route::get('/uc-sweetalert', [ZenixadminController::class, 'uc_sweetalert']);
// Route::get('/uc-toastr', [ZenixadminController::class, 'uc_toastr']);
// Route::get('/map-jqvmap', [ZenixadminController::class, 'map_jqvmap']);
// Route::get('/widget-basic', [ZenixadminController::class, 'widget_basic']);
// Route::get('/form-editor-summernote', [ZenixadminController::class, 'form_editor_summernote']);
// Route::get('/form-element', [ZenixadminController::class, 'form_element']);
// Route::get('/form-pickers', [ZenixadminController::class, 'form_pickers']);
// Route::get('/form-validation-jquery', [ZenixadminController::class, 'form_validation_jquery']);
// Route::get('/form-wizard', [ZenixadminController::class, 'form_wizard']);
// Route::get('/table-bootstrap-basic', [ZenixadminController::class, 'table_bootstrap_basic']);
// Route::get('/table-datatable-basic', [ZenixadminController::class, 'table_datatable_basic']);
// Route::get('/page-error-400', [ZenixadminController::class, 'page_error_400']);
// Route::get('/page-error-403', [ZenixadminController::class, 'page_error_403']);
// Route::get('/page-error-404', [ZenixadminController::class, 'page_error_404']);
// Route::get('/page-error-500', [ZenixadminController::class, 'page_error_500']);
// Route::get('/page-error-503', [ZenixadminController::class, 'page_error_503']);
// Route::get('/page-forgot-password', [ZenixadminController::class, 'page_forgot_password']);
// Route::get('/page-lock-screen', [ZenixadminController::class, 'page_lock_screen']);
// Route::get('/page-login', [ZenixadminController::class, 'page_login']);
// Route::get('/page-register', [ZenixadminController::class, 'page_register']);

// MAIN ROUTE
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    // Handle the login form submission (POST request)
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Authentication routes (Auth middleware will protect these)
Route::middleware('auth')->group(function () {

    Route::resources([
        'roles'       => RoleController::class,
        'users'       => UserController::class,
        'permissions' => PermissionController::class,
    ]);

    Route::middleware(['access.mode:offline'])->group(function () {
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
        Route::post('/pembayaran/detail', [PembayaranController::class, 'searchNopol'])->name('detail-pembayaran');
        Route::post('/pembayaran/bayar', [PembayaranController::class, 'bayar'])->name('bayar');

        Route::get('/batal-pembayaran', [PembayaranController::class, 'indexBatalBayar'])->name('batal-pembayaran');
        Route::post('/batal-pembayaran', [PembayaranController::class, 'searchDataBatalBayar'])->name('detail-batal-pembayaran');
        Route::post('/batal-pembayaran/submit', [PembayaranController::class, 'batalBayar'])->name('proses-batal-bayar');

        Route::post('/pembayaran/generateQris', [PembayaranController::class, 'generateQris'])->name('generate-qris');

        Route::get('/cetak-notice', [CetakNoticeController::class, 'index'])->name('cetak-notice');
        Route::post('/cetak-notice', [CetakNoticeController::class, 'nopol'])->name('cetak-notice.input-nopol');
        Route::post('/cetak-notice/detail', [CetakNoticeController::class, 'searchNopol'])->name('detail-cetak-notice');
        Route::post('/cetak-notice/cetak', [CetakNoticeController::class, 'cetak'])->name('cetak-notice.cetak');

        Route::get('/ulang-cetak-notice', [UlangCetakNoticeController::class, 'index'])->name('ulang-cetak-notice');
        Route::post('/ulang-cetak-notice', [UlangCetakNoticeController::class, 'nopol'])->name('ulang-cetak-notice.input-nopol');
        Route::post('/ulang-cetak-notice/detail', [UlangCetakNoticeController::class, 'searchNopol'])->name('ulang-detail-cetak-notice');
        Route::post('/ulang-cetak-notice/cetak', [UlangCetakNoticeController::class, 'cetak'])->name('ulang-cetak-notice.cetak');
    });

    // Protected routes (Only accessible by authenticated users)
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Route for showing the profile update form
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/laporan/penerimaan-harian', [PenerimaanHarianController::class, 'showForm'])->name('penerimaan-harian.form');
    Route::post('/laporan/penerimaan-harian', [PenerimaanHarianController::class, 'handleFormSubmission'])->name('penerimaan-harian.submit');
    Route::post('/laporan/penerimaan-harian/pdf', [PenerimaanHarianController::class, 'exportToPdf'])->name('penerimaan-harian.pdf');
    Route::post('/laporan/penerimaan-harian/excel', [PenerimaanHarianController::class, 'exportToExcel'])->name('penerimaan-harian.excel');

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/laporan/penerimaan-harian', [PenerimaanAdmin::class, 'showForm'])->name('admin.penerimaan-harian.form');
        Route::post('/laporan/penerimaan-harian', [PenerimaanAdmin::class, 'handleFormSubmission'])->name('admin.penerimaan-harian.submit');
        Route::post('/laporan/penerimaan-harian/pdf', [PenerimaanAdmin::class, 'exportToPdf'])->name('admin.penerimaan-harian.pdf');
        Route::post('/laporan/penerimaan-harian/excel', [PenerimaanAdmin::class, 'exportToExcel'])->name('admin.penerimaan-harian.excel');

        Route::get('/laporan/rekapitulasi-penerimaan-detail', [RekapDetailAdmin::class, 'showForm'])->name('admin.rekapitulasi-penerimaan-detail.form');
        Route::post('/laporan/rekapitulasi-penerimaan-detail', [RekapDetailAdmin::class, 'handleFormSubmission'])->name('admin.rekapitulasi-penerimaan-detail.submit');
        Route::post('/laporan/rekapitulasi-penerimaan-detail/pdf', [RekapDetailAdmin::class, 'exportToPdf'])->name('admin.rekapitulasi-penerimaan-detail.pdf');

        Route::get('/laporan/penerimaan-opsen', [PenerimaanOpsen::class, 'showForm'])->name('admin.penerimaan-opsen.form');
        Route::post('/laporan/penerimaan-opsen', [PenerimaanOpsen::class, 'handleFormSubmission'])->name('admin.penerimaan-opsen.submit');
        Route::post('/laporan/penerimaan-opsen/pdf', [PenerimaanOpsen::class, 'exportToPdf'])->name('admin.penerimaan-opsen.pdf');
    });

    Route::get('/laporan/penerimaan-harian-opsen', [PenerimaanHarianOpsenController::class, 'showForm'])->name('penerimaan-harian-opsen.form');
    Route::post('/laporan/penerimaan-harian-opsen', [PenerimaanHarianOpsenController::class, 'handleFormSubmission'])->name('penerimaan-harian-opsen.submit');
    Route::post('/laporan/penerimaan-harian-opsen/pdf', [PenerimaanHarianOpsenController::class, 'exportToPdf'])->name('penerimaan-harian-opsen.pdf');
    Route::post('/laporan/penerimaan-harian-opsen/excel', [PenerimaanHarianOpsenController::class, 'exportToExcel'])->name('penerimaan-harian-opsen.excel');

    Route::get('/laporan/rekapitulasi-penerimaan-ringkas', [RekapitulasiPenerimaanRingkasController::class, 'showForm'])->name('rekapitulasi-penerimaan-ringkas.form');
    Route::post('/laporan/rekapitulasi-penerimaan-ringkas', [RekapitulasiPenerimaanRingkasController::class, 'handleFormSubmission'])->name('rekapitulasi-penerimaan-ringkas.submit');
    Route::post('/laporan/rekapitulasi-penerimaan-ringkas/pdf', [RekapitulasiPenerimaanRingkasController::class, 'exportToPdf'])->name('rekapitulasi-penerimaan-ringkas.pdf');

    Route::get('/laporan/rekapitulasi-penerimaan-user', [RekapitulasiPenerimaanPerUserController::class, 'showForm'])->name('rekapitulasi-penerimaan-user.form');
    Route::post('/laporan/rekapitulasi-penerimaan-user', [RekapitulasiPenerimaanPerUserController::class, 'handleFormSubmission'])->name('rekapitulasi-penerimaan-user.submit');
    Route::post('/laporan/rekapitulasi-penerimaan-user/pdf', [RekapitulasiPenerimaanPerUserController::class, 'exportToPdf'])->name('rekapitulasi-penerimaan-user.pdf');
    Route::get('/laporan/rekapitulasi-penerimaan-user/rincian', [RekapitulasiPenerimaanPerUserController::class, 'unduhDetailExcel'])->name('rekapitulasi-penerimaan-user.rincian');

    Route::get('/laporan/rekapitulasi-penerimaan-detail', [RekapitulasiPenerimaanDetailController::class, 'showForm'])->name('rekapitulasi-penerimaan-detail.form');
    Route::post('/laporan/rekapitulasi-penerimaan-detail', [RekapitulasiPenerimaanDetailController::class, 'handleFormSubmission'])->name('rekapitulasi-penerimaan-detail.submit');
    Route::post('/laporan/rekapitulasi-penerimaan-detail/pdf', [RekapitulasiPenerimaanDetailController::class, 'exportToPdf'])->name('rekapitulasi-penerimaan-detail.pdf');

    Route::get('/fetch-lokasi', function (Request $request) {
        $kd_wilayah = $request->get('kd_wilayah');

        // Fetch Lokasi based on the selected Wilayah
        $lokasi = NamaLokasi::where('kd_upt', substr($kd_wilayah, -2))->orderBy('kd_lokasi', 'asc')->get(['kd_lokasi', 'nm_lokasi']);

        return response()->json($lokasi);
    })->name('fetch.lokasi');

    // Logout route (default for Breeze)
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// If needed, add a route to redirect logged-in users from the login page:
