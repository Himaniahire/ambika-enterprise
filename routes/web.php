<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerformaController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\EmployeeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(App\Http\Controllers\LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('post-login', 'postLogin')->name('post-login');
    Route::get('logout', 'logout')->name('logout');
});

Route::group(['prefix' => '/admin','middleware' => ['auth','isAdmin']], function () {
    Route::controller(App\Http\Controllers\AdminController::class)->group(function () {
        Route::get('/', 'index')->name('adminhome');
        Route::get('/activity_log', 'activityLog')->name('activity_log.index');
        Route::get('/export-excel',  'exportExcel')->name('export.excel');
        Route::get('/export-pdf', 'exportPDF')->name('export.pdf');


        // Route::get('/admin_password_changes', 'adminPasswordChange')->name('password.changes');
    });

    Route::resource('/complacences', App\Http\Controllers\ComplacenceController::class);
    Route::delete('/complacences/{id}', [App\Http\Controllers\ComplacenceController::class, 'deleteDoc'])->name('complacences.deleteDoc');

    Route::controller(App\Http\Controllers\UserController::class)->group(function () {
        Route::get('user', 'index')->name('user.index');
        Route::get('user/create', 'create')->name('user.create');
        Route::post('user/store', 'store')->name('user.store');
        Route::post('/user/validation', 'validateForm')->name('validation');
        Route::get('/user/edit/{id}', 'edit')->name('user.edit');
        Route::put('/user/update/{id}', 'update')->name('user.update');
        Route::delete('/user/destroy/{id}', 'destroy')->name('user.destroy');
        Route::post('/remove-permissions', action: 'removePermissions')->name('permissions.remove');

    });
});

Route::group(['prefix' => '/admin/accountant','middleware' => ['auth','isAccountant']], function () {
    Route::controller(App\Http\Controllers\AccountantController::class)->group(function () {
        Route::get('/', 'index')->name('accountant');
        // Route::get('/accountant_password_changes', 'accountantPasswordChange')->name('password.changes');
        Route::get('/reports/master_report', 'masterReport')->name('reports.master_report');
        Route::post('/generate-excel',  'generateExcel')->name('generate.excel');
        Route::get('/reports/company_po_report', 'companyPoReport')->name('reports.company_po_report');
        Route::get('/reports/company_inv_report', 'companyInvReport')->name('reports.company_inv_report');
        Route::get('/reports/invoice_report', 'invoiveReport')->name('reports.invoice_report');
        Route::get('/reports/service_code_report', 'serviceCodeReport')->name('reports.service_code_report');
        Route::get('/reports/final_invoice_report', 'finalInvoiceReport')->name('reports.final_invoice_report');
        Route::get('/getPurchaseOrders/{companyId}', 'getPurchaseOrders')->name('purchase-orders');
        Route::get('/get-services/{company_id}', 'getServices')->name('get.services');
        Route::get('/get-service/{po_no_id}',  'getServiceByPO')->name('get-service');
        Route::post('/fetch-data-company', 'fetchDataCompany')->name('fetch.data.company');
        Route::post('/fetch-data-company-inv', 'fetchDataCompanyInvoice')->name('fetch.data.company.inv');
        Route::get('/fetch-data-service-code', 'fetchDataServiceCode')->name('fetch.data.service.code');
        Route::post('/fetch-data-invoice', 'fetchDataInvoice')->name('fetch.data.invoice');
        Route::post('/fetch-invoices', 'fetchFinalInvoices')->name('fetch.invoices');

    });

    Route::resource('/register_company', App\Http\Controllers\RegisterCompanyController::class);
    Route::post('/delete-service-code', 'App\Http\Controllers\RegisterCompanyController@serviceDestroy')->name('delete.service.code');
    Route::post('/toggle-status', 'App\Http\Controllers\RegisterCompanyController@toggleStatus')->name('toggle.status');
    Route::post('/check-unique', 'App\Http\Controllers\RegisterCompanyController@checkUnique')->name('check.unique');
    Route::delete('/gst', 'App\Http\Controllers\RegisterCompanyController@Gstdestroy')->name('gst.destroy');



    // Route::delete('register_company/service_destroy/{id}', 'App\Http\Controllers\RegisterCompanyController@serviceDestroy')->name('register_company.service_destroy');

    Route::resource('/category_of_service', App\Http\Controllers\CategoryOfServiceController::class);

    // Route::resource('/performa', App\Http\Controllers\PerformaController::class);
    Route::controller(App\Http\Controllers\PerformaController::class)->group(function () {
        Route::get('performa', 'index')->name('performa.index');
        Route::get('performa/show/{id}', 'show')->name('performa.show');
        Route::get('performa/excel/{id}', 'exportExcel')->name('performa.excel');
        Route::put('/performa/update/{id}', 'update')->name('performa.update');
        Route::delete('/performa/destroy/{id}', 'destroy')->name('performa.destroy');
        Route::get('/performa/pending/', 'pending')->name('performa.pending');
        Route::get('/performa/complete/', 'complete')->name('performa.complete');
        Route::get('/performa/report', 'report')->name('performa.report');
        Route::post('/get-performa', 'getPerformaByDateAndCompany')->name('get-performa');
        Route::get('/performa/{performa}/cancel', 'cancel')->name('performa.cancel');
    });

    // Route::resource('/invoice', App\Http\Controllers\InvoiceController::class);
    Route::controller(App\Http\Controllers\InvoiceController::class)->group(function () {
        Route::get('invoice', 'index')->name('invoice.index');
        Route::get('/invoice/cancel', 'cancel')->name('invoice.cancel');
        Route::get('/invoice_data', 'getInvoiceData')->name('invoice.data');
        Route::get('invoice/show/{id}', 'show')->name('invoice.show');
        Route::get('invoice/excel/{id}', 'exportExcel')->name('invoice.excel');
        Route::put('invoice/update/{id}', 'update')->name('invoice.update');
        Route::delete('invoice/destroy/{id}', 'destroy')->name('invoice.destroy');
        Route::post('/complete-invoice', 'completeInvoice')->name('complete.invoice');
        Route::get('/invoice/complete/', 'Complete')->name('invoice.complete');
        Route::get('/invoice_complete_data', 'getInvoiceCompleteData')->name('invoice-complete.data');
        Route::get('/invoice/pending/', 'pending')->name('invoice.pending');
        Route::get('/invoice-pending-data', 'getInvoicePendingData')->name('invoice-pending.data');
        Route::get('/invoice/report', 'report')->name('invoice.report');
        Route::get('/invoice/performa_invoice_report', 'performaInvoiceReport')->name('invoice.performa_invoice_report');
        Route::post('/get-invoice', 'getInvoiceByDateAndCompany')->name('get-invoice');
        Route::get('/invoice/complete_details/{id}', 'getCompleteInvoice')->name('invoice.complete_details');
        Route::post('/invoice/update-complete-invoice', 'updateCompleteInvoice')->name('invoice.update-complete-invoice');
        Route::delete('/invoice/delete-complete-invoice/{id}', 'deleteCompleteInvoice')->name('invoice.delete-complete-invoice');
        Route::get('/check-invoice-unique', 'checkUniqueInvoice')->name('check.invoice');
        Route::get('/invoice/{invoice}/cancel', 'cancel')->name('invoice.cancel');
    });

    // Route::resource('/summary', App\Http\Controllers\SummaryController::class);
    Route::controller(App\Http\Controllers\SummaryController::class)->group(function () {
        Route::get('summary', 'index')->name('summary.index');
        Route::get('/summaries-data', 'getSummariesData')->name('summaries.data');
        Route::get('summary/create', 'create')->name('summary.create');
        Route::post('summary/store', 'store')->name('summary.store');
        Route::get('summary/show/{id}', 'show')->name('summary.show');
        Route::get('summary/excel/{id}', 'exportExcel')->name('summary.excel');
        Route::get('summary/edit/{id}', 'edit')->name('summary.edit');
        Route::put('summary/update/{id}', 'update')->name('summary.update');
        Route::delete('summary/destroy/{id}', 'destroy')->name('summary.destroy');
        Route::delete('summary/product_destroy/{id}', 'productDestroy')->name('summary.product_destroy');
        Route::get('/get-summary-number', 'getSummaryNumber')->name('get-summary-number');
        Route::delete('/summary/deletesummarydocument/{id}',  'deletesummarydocument')->name('deletesummarydocument');
        Route::post('/get-sum', 'getSumByDateAndCompany')->name('get-sum');
        Route::get('/getPurchaseOrders/{companyId}', 'getPurchaseOrders')->name('purchase-orders');
        Route::get('/get-services/{company_id}', 'getServices')->name('get.services');
        Route::get('/get-service/{po_no_id}',  'getServiceByPO')->name('get-service');
        Route::get('/get-service-code-details/{id}', 'getServiceCodeDetails')->name('get.service.code.details');
        Route::get('/get-gst-numbers/{companyId}', 'getGstNumbers')->name('get-gst-numbers');

    });

    // Route::resource('/purchase_order', App\Http\Controllers\PurchaseOrderController::class);
    Route::controller(App\Http\Controllers\PurchaseOrderController::class)->group(function () {
        Route::get('purchase_order', 'index')->name('purchase_order.index');
        Route::get('/purchase_order_data', 'getPurchaseOrderData')->name('purchase_order.data');
        Route::get('purchase_order/create', 'create')->name('purchase_order.create');
        Route::post('purchase_order/store', 'store')->name('purchase_order.store');
        Route::get('purchase_order/show/{id}', 'show')->name('purchase_order.show');
        Route::get('purchase_order/edit/{id}', 'edit')->name('purchase_order.edit');
        Route::put('purchase_order/update/{id}', 'update')->name('purchase_order.update');
        Route::delete('purchase_order/destroy/{id}', 'destroy')->name('purchase_order.destroy');
        Route::delete('purchase_order/product_destroy/{id}', 'productDestroy')->name('purchase_order.product_destroy');
        Route::delete('/purchase_order/deletepodocument/{id}',  'deletepodocument')->name('deletepodocument');
        Route::get('/get-service-codes/{companyId}','getServiceCodes')->name('get.service.codes');
        Route::get('/get-service-code-details/{id}', 'getServiceCodeDetails')->name('get.service.code.details');
        Route::get('/purchase_order/report', 'report')->name('purchase_order.report');
        Route::post('/get-pos', 'getPOByDateAndCompany')->name('get-pos');
    });

});

Route::group(['prefix' => 'admin/employee','middleware' => ['auth','isDataEntry']], function () {
    Route::controller(App\Http\Controllers\DataEntryController::class)->group(function () {
        Route::get('/', 'index')->name('employee');
        // Route::get('/employee_password_changes', 'employeePasswordChange')->name('password.changes');
        Route::get('/reports/attendance_report', 'attendanceReport')->name('reports.attendance_report');
        Route::get('/export-attendance', 'attendanceExport')->name('export.attendance');
        Route::get('/reports/salary_report', 'salaryReport')->name('reports.salary_report');
        Route::get('/export-salary', 'salaryExport')->name('export.salary');
        Route::get('/reports/emp_advance_report', 'EmpAdvanceReport')->name('reports.emp_advance_report');
        Route::post('/reports/fetch_emp_advance_report', 'fetchEmpAdvanceReport')->name('reports.fetch_emp_advance_report');
        Route::get('/reports/emp_salary_report', 'EmpSalaryReport')->name('reports.emp_salary_report');
        Route::post('/reports/fetch_emp_salary_report', 'fetchEmpSalaryeport')->name('reports.fetch_emp_salary_report');
        Route::get('/reports/emp_join_leave_report', 'EmpJoinLeaveReport')->name('reports.emp_join_leave_report');
        Route::post('/reports/fetch_join_leave_report', 'fetchJoinLeaveport')->name('reports.fetch_join_leave_report');
    });

    Route::resource('/employee_advance_salary', App\Http\Controllers\EmployeeAdvanceSalaryController::class);
    Route::get('/getEmployees/{companyId}', [App\Http\Controllers\EmployeeAdvanceSalaryController::class, 'getEmployeesByCompany'])->name('getEmployees');

    // Route::resource('/employee_salary', App\Http\Controllers\EmployeeSalaryController::class);
    Route::controller(App\Http\Controllers\EmployeeSalaryController::class)->group(function () {
        Route::get('employee_salary/create', 'create')->name('employee_salary.create');
        Route::post('employee_salary/get-employee-data', 'getEmployeeData')->name('getEmployeeData');
        Route::post('employee_salary/store', 'store')->name('employee_salary.store');
    });
    Route::controller(App\Http\Controllers\EmployeeController::class)->group(function () {
        Route::get('employee_details', 'index')->name('employee_details.index');
        Route::get('employee_details/create', 'create')->name('employee_details.create');
        Route::post('employee_details/store', 'store')->name('employee_details.store');
        Route::get('/employee_details/site', 'Site')->name('employee_details.site');
        Route::get('/employee_details/edit/{id}', 'edit')->name('employee_details.edit');
        // Route::put('/employee_details/update/{id}', 'update')->name('employee_details.update');
        Route::delete('/employee_details/destroy/{id}', 'destroy')->name('employee_details.destroy');
    });

    Route::put('/employee_details/update/{id}', [EmployeeController::class, 'update'])->name('employee_details.update');

    Route::resource('/employee_holidays', App\Http\Controllers\HolidayController::class);
    Route::resource('/employee_categories', App\Http\Controllers\EmployeeCategoryController::class);
    Route::resource('/employee_posts', App\Http\Controllers\EmployeePostController::class);
    // Route::resource('/employee_company_transfer', App\Http\Controllers\EmployeeCompanyTransferController::class);
    Route::controller(App\Http\Controllers\EmployeeCompanyTransferController::class)->group(function () {
        Route::get('employee_company_transfer', 'index')->name('employee_company_transfer.index');
        Route::put('/employee_company_transfer/update/{id}', 'update')->name('employee_company_transfer.update');
        Route::get('/employee-company-transfer-data', 'getData')->name('employee.company.transfer.data');
    });
    // Route::resource('/employee_attendance', App\Http\Controllers\EmployeeAttendanceController::class);
    Route::controller(App\Http\Controllers\EmployeeAttendanceController::class)->group(function () {
        Route::get('employee_attendance', 'index')->name('employee_attendance.index');
        Route::get('employee_attendance/create', 'create')->name('employee_attendance.create');
        Route::post('employee_attendance/store', 'store')->name('employee_attendance.store');
        Route::get('/get-employees-by-company', 'getEmployeesByCompany')->name('get.employees.by.company');
        Route::get('fetch-attendance', 'fetchAttendanceByDate')->name('fetch.attendance.by.date');
        Route::post('employee_attendance/empupdate', 'empUpdate')->name('employee_attendance.empupdate');
        Route::get('/employee_attendance/attendance_edit', 'attendanceEdit')->name('employee_attendance.attendance_edit');
        Route::get('/get-employee-details/{companyId}', 'getEmployeeDetails')->name("get.employee.details");
        Route::get('/attendance/check', 'checkAttendance')->name('attendance.check');
        Route::get('/employee-attendance/fetch', 'fetchAttendance')->name('employee_attendance.fetch');
    });

});


