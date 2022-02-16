<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BreedController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AccessoryController;
use App\Http\Controllers\Admin\AgeController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\CategoryTypeController;
use App\Http\Controllers\Admin\CouponTypeController;
use App\Http\Controllers\Admin\DiscountTypeController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\GenderController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\StatisticalController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\ReviewController;
use Doctrine\DBAL\Driver\Middleware;

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

Route::middleware('permission:login_admin')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    
    Route::prefix('danh-gia')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('list.review.index');
        Route::get('/{id}', [ReviewController::class, 'updateStatus'])->name('update.status.review');
    });
    
    Route::prefix('tai-khoan')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
    
        Route::delete('xoa/{id}', [UserController::class, 'remove'])->name('user.remove');
    
        Route::get('tao-moi', [UserController::class, 'addForm'])->name('user.add');
        Route::post('tao-moi', [UserController::class, 'saveAdd'])->name('user.saveAdd');
    
        Route::get('cap-nhat/{id}', [UserController::class, 'editForm'])->name('user.edit');
        Route::post('cap-nhat/{id}', [UserController::class, 'saveEdit'])->name('user.saveEdit');
    
        Route::get('phan-quyen', [UserController::class, 'permission_form'])->name('user.permission');
        Route::post('phan-quyen', [UserController::class, 'save_form_permission']);
    
        Route::get('ho-so/{id}', [UserController::class, 'proFile'])->name('user.profile');
        
        Route::get('update-status/{id}', [UserController::class, 'updateStatus'])->name('user.updateStatus');
    
        Route::get('doi-mat-khau/{id}', [UserController::class, 'changePForm'])->name('user.changeP');
        Route::post('doi-mat-khau/{id}', [UserController::class, 'saveChangeP']);
    
        Route::get('dataUser', [UserController::class, 'getData'])->name('user.filter');
        Route::get('trash', [UserController::class, 'backUp'])->name('user.backup');
        Route::get('dataBackUp', [UserController::class, 'getBackUp'])->name('user.getBackup');
        Route::get('trash/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
        Route::delete('trash/deleteForver/{id}', [UserController::class, 'delete'])->name('user.delete');
        Route::delete('trash/remove', [UserController::class, 'removeMultiple'])->name('user.removeMul');
        Route::get('trash/restore', [UserController::class, 'restoreMultiple'])->name('user.restoreMul');
        Route::delete('trash/deleteForeverMul', [UserController::class, 'deleteMultiple'])->name('user.deleteMul');
    });
    
    Route::prefix('phan-quyen')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
    
        Route::get('tao-moi-role-user', [RoleController::class, 'addRoleUser'])->middleware('permission:add roles')->name('role.user.add');
        Route::post('tao-moi-role-user', [RoleController::class, 'saveAddRoleUser'])->name('role.user.saveAdd');
    
        Route::get('sua-role-user/{id}', [RoleController::class, 'editRoleUser'])->name('role.user.edit');
        Route::post('sua-role-user/{id}', [RoleController::class, 'saveEditRoleUser'])->name('role.user.saveEdit');
        Route::get('xoa-role-user/{id}', [RoleController::class, 'removeRoleUser'])->name('role.user.remove');
    
        Route::get('add-role-permission', [RoleController::class, 'addRolePermission'])->middleware('permission:add roles')->name('role.permission.add');
        Route::post('add-role-permission', [RoleController::class, 'saveAddRolePermission']);
        
        Route::get('edit-role/{id}', [RoleController::class, 'editRolePermission'])->name('role.edit');
        Route::post('edit-role/{id}', [RoleController::class, 'saveEditRolePermission']);
        Route::get('remove-role/{id}', [RoleController::class, 'removeRole'])->name('role.remove');
    
        Route::get('edit-role-permission', [RoleController::class, 'editRolePermission'])->name('role.permission.edit');
        Route::post('edit-role-permission', [RoleController::class, 'saveEditRolePermission']);
    });
    
    Route::prefix('danh-muc')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    
        Route::get('tao-moi', [CategoryController::class, 'addForm'])->name('category.add');
        Route::post('tao-moi', [CategoryController::class, 'saveAdd'])->name('category.saveAdd');
    
        Route::get('cap-nhat/{id}', [CategoryController::class, 'editForm'])->name('category.edit');
        Route::post('cap-nhat/{id}', [CategoryController::class, 'saveEdit'])->name('category.saveEdit');
    
        Route::get('chi-tiet/{id}', [CategoryController::class, 'detail'])->name('category.detail');
    
        Route::delete('xoa/{id}', [CategoryController::class, 'remove'])->name('category.remove');
        Route::get('dataCate', [CategoryController::class, 'getData'])->name('category.filter');
        Route::get('trash', [CategoryController::class, 'backUp'])->name('category.backup');
        Route::get('dataBackUp', [CategoryController::class, 'getBackUp'])->name('category.getBackup');
        Route::get('trash/restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
        Route::delete('trash/deleteForver/{id}', [CategoryController::class, 'delete'])->name('category.delete');
        Route::delete('trash/remove', [CategoryController::class, 'removeMultiple'])->name('category.removeMul');
        Route::get('trash/restore', [CategoryController::class, 'restoreMultiple'])->name('category.restoreMul');
        Route::delete('trash/deleteForeverMul', [CategoryController::class, 'deleteMultiple'])->name('category.deleteMul');
    });
    
    Route::prefix('don-hang')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
    
        // Route::get('cap-nhat', [OrderController::class, 'editForm'])->name('order.edit');
        Route::get('cap-nhat/{id}', [OrderController::class, 'editForm'])->name('order.edit');
        Route::post('cap-nhat/{id}', [OrderController::class, 'saveEdit']);;
    
        Route::get('chi-tiet/{id}', [OrderController::class, 'detail'])->name('order.detail');
    
        Route::get('xoa/{id}', [OrderController::class, 'remove'])->name('order.remove');
    
        Route::get('dataOrder', [OrderController::class, 'getData'])->name('order.filter');
    });
    
    Route::prefix('giong-loai')->group(function () {
        Route::get('/', [BreedController::class, 'index'])->name('breed.index');
    
        Route::get('tao-moi', [BreedController::class, 'addForm'])->name('breed.add');
        Route::post('tao-moi', [BreedController::class, 'saveAdd'])->name('breed.saveAdd');
    
        Route::get('cap-nhat/{id}', [BreedController::class, 'editForm'])->name('breed.edit');
        Route::post('cap-nhat/{id}', [BreedController::class, 'saveEdit'])->name('breed.saveEdit');
    
        Route::get('chi-tiet/{id}', [BreedController::class, 'detail'])->name('breed.detail');
    
        Route::delete('xoa/{id}', [BreedController::class, 'remove'])->name('breed.remove');
        Route::get('dataPet', [BreedController::class, 'getData'])->name('breed.filter');
        Route::get('trash', [BreedController::class, 'backUp'])->name('breed.backup');
        Route::get('dataBackUp', [BreedController::class, 'getBackUp'])->name('breed.getBackup');
        Route::get('trash/restore/{id}', [BreedController::class, 'restore'])->name('breed.restore');
        Route::delete('trash/deleteForver/{id}', [BreedController::class, 'delete'])->name('breed.delete');
        Route::delete('trash/remove', [BreedController::class, 'removeMultiple'])->name('breed.removeMul');
        Route::get('trash/restore', [BreedController::class, 'restoreMultiple'])->name('breed.restoreMul');
        Route::delete('trash/deleteForeverMul', [BreedController::class, 'deleteMultiple'])->name('breed.deleteMul');
    });
    
    Route::prefix('tuoi')->group(function () {
        Route::get('/', [AgeController::class, 'index'])->name('age.index');
    
        Route::get('tao-moi', [AgeController::class, 'addForm'])->name('age.add');
        Route::post('tao-moi', [AgeController::class, 'saveAdd'])->name('age.saveAdd');
    
        Route::get('cap-nhat/{id}', [AgeController::class, 'editForm'])->name('age.edit');
        Route::post('cap-nhat/{id}', [AgeController::class, 'saveEdit'])->name('age.saveEdit');
    
        Route::get('chi-tiet/{id}', [AgeController::class, 'detail'])->name('age.detail');
    
        Route::delete('xoa/{id}', [AgeController::class, 'remove'])->name('age.remove');
        Route::get('dataAge', [AgeController::class, 'getData'])->name('age.filter');
        Route::get('trash', [AgeController::class, 'backUp'])->name('age.backup');
        Route::get('dataBackUp', [AgeController::class, 'getBackUp'])->name('age.getBackup');
        Route::get('trash/restore/{id}', [AgeController::class, 'restore'])->name('age.restore');
        Route::delete('trash/deleteForver/{id}', [AgeController::class, 'delete'])->name('age.delete');
        Route::delete('trash/remove', [AgeController::class, 'removeMultiple'])->name('age.removeMul');
        Route::get('trash/restore', [AgeController::class, 'restoreMultiple'])->name('age.restoreMul');
        Route::delete('trash/deleteForeverMul', [AgeController::class, 'deleteMultiple'])->name('age.deleteMul');
    });
    
    Route::prefix('san-pham')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
    
        Route::get('tao-moi', [ProductController::class, 'addForm'])->name('product.add');
        Route::post('tao-moi', [ProductController::class, 'saveAdd'])->name('product.saveAdd');
    
        Route::get('cap-nhat/{id}', [ProductController::class, 'editForm'])->name('product.edit');
        Route::post('cap-nhat/{id}', [ProductController::class, 'saveEdit'])->name('product.saveEdit');
    
        Route::get('chi-tiet/{id}', [ProductController::class, 'detail'])->name('product.detail');
    
        Route::delete('xoa/{id}', [ProductController::class, 'remove'])->name('product.remove');
        Route::post('upload', [UploadController::class, 'upload'])->name('product.upload');
    
        Route::get('dataProduct', [ProductController::class, 'getData'])->name('product.filter');
        Route::get('trash', [ProductController::class, 'backUp'])->name('product.backup');
        Route::get('dataBackUp', [ProductController::class, 'getBackUp'])->name('product.getBackup');
        Route::get('trash/restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
        Route::delete('trash/deleteForver/{id}', [ProductController::class, 'delete'])->name('product.delete');
        Route::post('import', [ProductController::class, 'store'])->name('product.import');
        Route::delete('trash/remove', [ProductController::class, 'removeMultiple'])->name('product.removeMul');
        Route::get('trash/restore', [ProductController::class, 'restoreMultiple'])->name('product.restoreMul');
        Route::delete('trash/deleteForeverMul', [ProductController::class, 'deleteMultiple'])->name('product.deleteMul');
    });
    
    Route::prefix('phu-kien')->group(function () {
        Route::get('/', [AccessoryController::class, 'index'])->name('accessory.index');
    
        Route::get('tao-moi', [AccessoryController::class, 'addForm'])->name('accessory.add');
        Route::post('tao-moi', [AccessoryController::class, 'saveAdd'])->name('accessory.saveAdd');
    
        Route::get('cap-nhat/{id}', [AccessoryController::class, 'editForm'])->name('accessory.edit');
        Route::post('cap-nhat/{id}', [AccessoryController::class, 'saveEdit'])->name('accessory.saveEdit');
    
        Route::get('chi-tiet/{id}', [AccessoryController::class, 'detail'])->name('accessory.detail');
    
        Route::delete('xoa/{id}', [AccessoryController::class, 'remove'])->name('accessory.remove');
        Route::post('upload', [UploadController::class, 'upload'])->name('accessory.upload');
    
        Route::get('dataProduct', [AccessoryController::class, 'getData'])->name('accessory.filter');
        Route::get('trash', [AccessoryController::class, 'backUp'])->name('accessory.backup');
        Route::get('dataBackUp', [AccessoryController::class, 'getBackUp'])->name('accessory.getBackup');
        Route::get('trash/restore/{id}', [AccessoryController::class, 'restore'])->name('accessory.restore');
        Route::delete('trash/deleteForver/{id}', [AccessoryController::class, 'delete'])->name('accessory.delete');
        Route::delete('trash/remove', [AccessoryController::class, 'removeMultiple'])->name('accessory.removeMul');
        Route::get('trash/restore', [AccessoryController::class, 'restoreMultiple'])->name('accessory.restoreMul');
        Route::delete('trash/deleteForeverMul', [AccessoryController::class, 'deleteMultiple'])->name('accessory.deleteMul');
    });
    
    Route::prefix('giam-gia')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('coupon.index');
    
        Route::get('tao-moi', [CouponController::class, 'addForm'])->name('coupon.add');
        Route::post('tao-moi', [CouponController::class, 'saveAdd'])->name('coupon.saveAdd');
    
        Route::get('cap-nhat/{id}', [CouponController::class, 'editForm'])->name('coupon.edit');
        Route::post('cap-nhat/{id}', [CouponController::class, 'saveEdit'])->name('coupon.saveEdit');
    
        Route::get('chi-tiet/{id}', [CouponController::class, 'detail'])->name('coupon.detail');
    
        Route::delete('xoa/{id}', [CouponController::class, 'remove'])->name('coupon.remove');
    
        Route::get('dataCoupon', [CouponController::class, 'getData'])->name('coupon.filter');
        Route::get('trash', [CouponController::class, 'backUp'])->name('coupon.backup');
        Route::get('dataBackUp', [CouponController::class, 'getBackUp'])->name('coupon.getBackup');
        Route::get('trash/restore/{id}', [CouponController::class, 'restore'])->name('coupon.restore');
        Route::delete('trash/deleteForver/{id}', [CouponController::class, 'delete'])->name('coupon.delete');
        Route::post('import', [CouponController::class, 'store'])->name('coupon.import');
        Route::delete('trash/remove', [CouponController::class, 'removeMultiple'])->name('coupon.removeMul');
        Route::get('trash/restore', [CouponController::class, 'restoreMultiple'])->name('coupon.restoreMul');
        Route::delete('trash/deleteForeverMul', [CouponController::class, 'deleteMultiple'])->name('coupon.deleteMul');
    });
    
    Route::prefix('loai-phieu-giam-gia')->group(function () {
        Route::get('/', [CouponTypeController::class, 'index'])->name('couponType.index');
    
        Route::get('tao-moi', [CouponTypeController::class, 'addForm'])->name('couponType.add');
        Route::post('tao-moi', [CouponTypeController::class, 'saveAdd'])->name('couponType.saveAdd');
    
        Route::get('cap-nhat/{id}', [CouponTypeController::class, 'editForm'])->name('couponType.edit');
        Route::post('cap-nhat/{id}', [CouponTypeController::class, 'saveEdit'])->name('couponType.saveEdit');
    
        Route::get('chi-tiet/{id}', [CouponTypeController::class, 'detail'])->name('couponType.detail');
    
        Route::delete('xoa/{id}', [CouponTypeController::class, 'remove'])->name('couponType.remove');
    
        Route::get('dataCoupon', [CouponTypeController::class, 'getData'])->name('couponType.filter');
        Route::get('trash', [CouponTypeController::class, 'backUp'])->name('couponType.backup');
        Route::get('dataBackUp', [CouponTypeController::class, 'getBackUp'])->name('couponType.getBackup');
        Route::get('trash/restore/{id}', [CouponTypeController::class, 'restore'])->name('couponType.restore');
        Route::delete('trash/deleteForver/{id}', [CouponTypeController::class, 'delete'])->name('couponType.delete');
        Route::post('import', [CouponTypeController::class, 'store'])->name('couponType.import');
        Route::delete('trash/remove', [CouponTypeController::class, 'removeMultiple'])->name('couponType.removeMul');
        Route::get('trash/restore', [CouponTypeController::class, 'restoreMultiple'])->name('couponType.restoreMul');
        Route::delete('trash/deleteForeverMul', [CouponTypeController::class, 'deleteMultiple'])->name('couponType.deleteMul');
    });
    
    Route::prefix('loai-giam-gia')->group(function () {
        Route::get('/', [DiscountTypeController::class, 'index'])->name('discountType.index');
    
        Route::get('tao-moi', [DiscountTypeController::class, 'addForm'])->name('discountType.add');
        Route::post('tao-moi', [DiscountTypeController::class, 'saveAdd'])->name('discountType.saveAdd');
    
        Route::get('cap-nhat/{id}', [DiscountTypeController::class, 'editForm'])->name('discountType.edit');
        Route::post('cap-nhat/{id}', [DiscountTypeController::class, 'saveEdit'])->name('discountType.saveEdit');
    
        Route::get('chi-tiet/{id}', [DiscountTypeController::class, 'detail'])->name('discountType.detail');
    
        Route::delete('xoa/{id}', [DiscountTypeController::class, 'remove'])->name('discountType.remove');
    
        Route::get('datadiscount', [DiscountTypeController::class, 'getData'])->name('discountType.filter');
        Route::get('trash', [DiscountTypeController::class, 'backUp'])->name('discountType.backup');
        Route::get('dataBackUp', [DiscountTypeController::class, 'getBackUp'])->name('discountType.getBackup');
        Route::get('trash/restore/{id}', [DiscountTypeController::class, 'restore'])->name('discountType.restore');
        Route::delete('trash/deleteForver/{id}', [DiscountTypeController::class, 'delete'])->name('discountType.delete');
        Route::post('import', [DiscountTypeController::class, 'store'])->name('discountType.import');
        Route::delete('trash/remove', [DiscountTypeController::class, 'removeMultiple'])->name('discountType.removeMul');
        Route::get('trash/restore', [DiscountTypeController::class, 'restoreMultiple'])->name('discountType.restoreMul');
        Route::delete('trash/deleteForeverMul', [DiscountTypeController::class, 'deleteMultiple'])->name('discountType.deleteMul');
    });
    
    Route::prefix('tin-tuc')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    
        Route::get('tao-moi', [BlogController::class, 'addForm'])->name('blog.add');
        Route::post('tao-moi', [BlogController::class, 'saveAdd'])->name('blog.saveAdd');
    
        Route::get('cap-nhat/{id}', [BlogController::class, 'editForm'])->name('blog.edit');
        Route::post('cap-nhat/{id}', [BlogController::class, 'saveEdit'])->name('blog.saveEdit');
    
        Route::get('chi-tiet/{id}', [BlogController::class, 'detail'])->name('blog.detail');
    
        Route::delete('xoa/{id}', [BlogController::class, 'remove'])->name('blog.remove');
        Route::post('upload', [BlogController::class, 'upload'])->name('blog.upload');
    
        Route::get('dataBlog', [BlogController::class, 'getData'])->name('blog.filter');
        Route::get('trash', [BlogController::class, 'backUp'])->name('blog.backup');
        Route::get('dataBackUp', [BlogController::class, 'getBackUp'])->name('blog.getBackup');
        Route::get('trash/restore/{id}', [BlogController::class, 'restore'])->name('blog.restore');
        Route::delete('trash/deleteForver/{id}', [BlogController::class, 'delete'])->name('blog.delete');
        Route::delete('trash/remove', [BlogController::class, 'removeMultiple'])->name('blog.removeMul');
        Route::get('trash/restore', [BlogController::class, 'restoreMultiple'])->name('blog.restoreMul');
        Route::delete('trash/deleteForeverMul', [BlogController::class, 'deleteMultiple'])->name('blog.deleteMul');
    });
    
    Route::prefix('danh-muc-tin-tuc')->group(function () {
        Route::get('/', [BlogCategoryController::class, 'index'])->name('blogCategory.index');
    
        Route::get('tao-moi', [BlogCategoryController::class, 'addForm'])->name('blogCategory.add');
        Route::post('tao-moi', [BlogCategoryController::class, 'saveAdd'])->name('blogCategory.saveAdd');
    
        Route::get('cap-nhat/{id}', [BlogCategoryController::class, 'editForm'])->name('blogCategory.edit');
        Route::post('cap-nhat/{id}', [BlogCategoryController::class, 'saveEdit'])->name('blogCategory.saveEdit');
    
        Route::get('chi-tiet/{id}', [BlogController::class, 'detail'])->name('blogCategory.detail');
    
        Route::delete('xoa/{id}', [BlogCategoryController::class, 'remove'])->name('blogCategory.remove');
    
        Route::get('dataBlogCategory', [BlogCategoryController::class, 'getData'])->name('blogCategory.filter');
    
        Route::get('trash', [BlogCategoryController::class, 'backUp'])->name('blogCategory.backup');
        Route::get('dataBackUp', [BlogCategoryController::class, 'getBackUp'])->name('blogCategory.getBackup');
        Route::get('trash/restore/{id}', [BlogCategoryController::class, 'restore'])->name('blogCategory.restore');
        Route::delete('trash/deleteForver/{id}', [BlogCategoryController::class, 'delete'])->name('blogCategory.delete');
        Route::delete('trash/remove', [BlogCategoryController::class, 'removeMultiple'])->name('blogCategory.removeMul');
        Route::get('trash/restore', [BlogCategoryController::class, 'restoreMultiple'])->name('blogCategory.restoreMul');
        Route::delete('trash/deleteForeverMul', [BlogCategoryController::class, 'deleteMultiple'])->name('blogCategory.deleteMul');
    });
    
    Route::prefix('thong-tin-he-thong')->group(function () {
        Route::get('/', [GeneralSettingController::class, 'index'])->name('general.index');
    
        Route::post('tao-moi', [GeneralSettingController::class, 'saveAdd'])->name('general.saveAdd');
        Route::get('xoa/{id}', [GeneralSettingController::class, 'remove'])->name('generalSetting.remove');
    
        Route::get('/footer', [GeneralSettingController::class, 'footer'])->name('generalSetting.footer');
        Route::post('/footer', [GeneralSettingController::class, 'saveFooter']);
    });
    
    Route::prefix('slide')->group(function () {
        Route::get('/', [SlideController::class, 'index'])->name('slide.index');
    
        Route::get('tao-moi', [SlideController::class, 'addForm'])->name('slide.add');
        Route::post('tao-moi', [SlideController::class, 'saveAdd'])->name('slide.saveAdd');
    
        Route::get('cap-nhat/{id}', [SlideController::class, 'editForm'])->name('slide.edit');
        Route::post('cap-nhat/{id}', [SlideController::class, 'saveEdit'])->name('slide.saveEdit');
    
        Route::get('chi-tiet/{id}', [SlideController::class, 'detail'])->name('slide.detail');
    
        Route::delete('xoa/{id}', [SlideController::class, 'remove'])->name('slide.remove');
    
        Route::get('dataSlide', [SlideController::class, 'getData'])->name('slide.filter');
    
        Route::get('trash', [SlideController::class, 'backUp'])->name('slide.backup');
        Route::get('dataBackUp', [SlideController::class, 'getBackUp'])->name('slide.getBackup');
        Route::get('trash/restore/{id}', [SlideController::class, 'restore'])->name('slide.restore');
        Route::delete('trash/deleteForver/{id}', [SlideController::class, 'delete'])->name('slide.delete');
        Route::delete('trash/remove', [SlideController::class, 'removeMultiple'])->name('slide.removeMul');
        Route::get('trash/restore', [SlideController::class, 'restoreMultiple'])->name('slide.restoreMul');
        Route::delete('trash/deleteForeverMul', [SlideController::class, 'deleteMultiple'])->name('slide.deleteMul');
    });
    
    Route::prefix('loai-danh-muc')->group(function () {
        Route::get('/', [CategoryTypeController::class, 'index'])->name('categoryType.index');
    
        Route::get('tao-moi', [CategoryTypeController::class, 'addForm'])->name('categoryType.add');
        Route::post('tao-moi', [CategoryTypeController::class, 'saveAdd'])->name('categoryType.saveAdd');
    
        Route::get('cap-nhat/{id}', [CategoryTypeController::class, 'editForm'])->name('categoryType.edit');
        Route::post('cap-nhat/{id}', [CategoryTypeController::class, 'saveEdit'])->name('categoryType.saveEdit');
    
        Route::get('chi-tiet/{id}', [CategoryTypeController::class, 'detail'])->name('categoryType.detail');
    
        Route::delete('xoa/{id}', [CategoryTypeController::class, 'remove'])->name('categoryType.remove');
        Route::get('dataPet', [CategoryTypeController::class, 'getData'])->name('categoryType.filter');
        Route::get('trash', [CategoryTypeController::class, 'backUp'])->name('categoryType.backup');
        Route::get('dataBackUp', [CategoryTypeController::class, 'getBackUp'])->name('categoryType.getBackup');
        Route::get('trash/restore/{id}', [CategoryTypeController::class, 'restore'])->name('categoryType.restore');
        Route::delete('trash/deleteForver/{id}', [CategoryTypeController::class, 'delete'])->name('categoryType.delete');
        Route::delete('trash/remove', [CategoryTypeController::class, 'removeMultiple'])->name('categoryType.removeMul');
        Route::get('trash/restore', [CategoryTypeController::class, 'restoreMultiple'])->name('categoryType.restoreMul');
        Route::delete('trash/deleteForeverMul', [CategoryTypeController::class, 'deleteMultiple'])->name('categoryType.deleteMul');
    });
    
    Route::prefix('gioi-tinh')->group(function () {
        Route::get('/', [GenderController::class, 'index'])->name('gender.index');
    
        Route::get('tao-moi', [GenderController::class, 'addForm'])->name('gender.add');
        Route::post('tao-moi', [GenderController::class, 'saveAdd'])->name('gender.saveAdd');
    
        Route::get('cap-nhat/{id}', [GenderController::class, 'editForm'])->name('gender.edit');
        Route::post('cap-nhat/{id}', [GenderController::class, 'saveEdit'])->name('gender.saveEdit');
    
        Route::get('chi-tiet/{id}', [GenderController::class, 'detail'])->name('gender.detail');
    
        Route::delete('xoa/{id}', [GenderController::class, 'remove'])->name('gender.remove');
        Route::get('dataPet', [GenderController::class, 'getData'])->name('gender.filter');
        Route::get('trash', [GenderController::class, 'backUp'])->name('gender.backup');
        Route::get('dataBackUp', [GenderController::class, 'getBackUp'])->name('gender.getBackup');
        Route::get('trash/restore/{id}', [GenderController::class, 'restore'])->name('gender.restore');
        Route::delete('trash/deleteForver/{id}', [GenderController::class, 'delete'])->name('gender.delete');
        Route::delete('trash/remove', [GenderController::class, 'removeMultiple'])->name('gender.removeMul');
        Route::get('trash/restore', [GenderController::class, 'restoreMultiple'])->name('gender.restoreMul');
        Route::delete('trash/deleteForeverMul', [GenderController::class, 'deleteMultiple'])->name('gender.deleteMul');
    });
    
    Route::prefix('chan-trang')->group(function () {
        Route::get('/', [FooterController::class, 'index'])->name('footer.index');
    
        Route::get('tao-moi', [FooterController::class, 'addForm'])->name('footer.add');
        Route::post('tao-moi', [FooterController::class, 'saveAdd'])->name('footer.saveAdd');
    
        Route::get('cap-nhat/{id}', [FooterController::class, 'editForm'])->name('footer.edit');
        Route::post('cap-nhat/{id}', [FooterController::class, 'saveEdit'])->name('footer.saveEdit');
    
        Route::get('chi-tiet/{id}', [FooterController::class, 'detail'])->name('footer.detail');
    
        Route::delete('xoa/{id}', [FooterController::class, 'remove'])->name('footer.remove');
        Route::get('dataPet', [FooterController::class, 'getData'])->name('footer.filter');
        Route::get('trash', [FooterController::class, 'backUp'])->name('footer.backup');
        Route::get('dataBackUp', [FooterController::class, 'getBackUp'])->name('footer.getBackup');
        Route::get('trash/restore/{id}', [FooterController::class, 'restore'])->name('footer.restore');
        Route::delete('trash/deleteForver/{id}', [FooterController::class, 'delete'])->name('footer.delete');
        Route::delete('trash/remove', [FooterController::class, 'removeMultiple'])->name('footer.removeMul');
        Route::get('trash/restore', [FooterController::class, 'restoreMultiple'])->name('footer.restoreMul');
        Route::delete('trash/deleteForeverMul', [FooterController::class, 'deleteMultiple'])->name('footer.deleteMul');
    });
    
    Route::prefix('thong-ke')->group(function () {
        Route::get('binh-luan/tong', [StatisticalController::class, 'commentSum'])->name('statistical.commentSum');
    
        Route::get('binh-luan/{slug}', [StatisticalController::class, 'commentPet'])->name('statistical.cmtPet');
    
        Route::get('don-hang/tong', [StatisticalController::class, 'orderSum'])->name('statistical.orderSum');
    
        Route::get('don-hang/huy', [StatisticalController::class, 'orderCancel'])->name('statistical.orderCancel');
    
        Route::get('don-hang/so-sanh', [StatisticalController::class, 'compare'])->name('statistical.compare');
    
        Route::get('don-hang/so-sanh/{slug}', [StatisticalController::class, 'compareCate'])->name('statistical.compareCate');
    
        Route::get('thoi-gian', [StatisticalController::class, 'time'])->name('statistical.time');
    
        Route::get('chi-tiet/{id}', [StatisticalController::class, 'detail'])->name('statistical.detail');
    
        Route::get('dataDetail/{id}', [StatisticalController::class, 'getDetail'])->name('statistical.getDetail');
    
        Route::get('doanh-thu/tong', [StatisticalController::class, 'revenueSum'])->name('statistical.revenueSum');
    
        Route::get('doanh-thu/{slug}', [StatisticalController::class, 'revenue'])->name('statistical.revenue');
    });

});