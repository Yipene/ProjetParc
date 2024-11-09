<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\gestionnaire\GestionnaireController;
use App\Http\Controllers\atelier\AtelierController;
use App\Http\Controllers\atelier\MaintenanceController;
use App\Http\Controllers\Equipement\TypeEquipementController;
use App\Http\Controllers\Personne\ServiceController;
use App\Http\Controllers\Personne\GradeController;
use App\Http\Controllers\Equipement\AcquisitionController;
use App\Http\Controllers\Equipement\DotationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Equipement\RestitutionController;

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
    return view('admin/admin_login');
});


Route::post('/user/{user}/assign-role', [UserController::class, 'assignRole'])->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Routes pour l'administrateur
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');



    Route::controller(RoleController::class)->group(function () {
        Route::get('/All/Permission', 'AllPermission')->name('all.permission');

    });

    // Routes pour gérer les services
    Route::controller(ServiceController::class)->group(function () {
        Route::get('/Service/Liste', 'ListeService')->name('liste.service');
        Route::post('/Store/Service', 'StoreService')->name('store.service');
        Route::post('/Update/Service', 'UpdateService')->name('update.service');
        Route::get('/Delete/Service/{id}', 'DeleteService')->name('delete.service');
    });

    // Routes pour gérer les grades
    Route::controller(GradeController::class)->group(function () {
        Route::get('/Grade/Liste', 'ListeGrade')->name('liste.grade');
        Route::post('/Store/Grade', 'StoreGrade')->name('store.grade');
        Route::post('/Update/Grade', 'UpdateGrade')->name('update.grade');
        Route::get('/Delete/Grade/{id}', 'DeleteGrade')->name('delete.grade');
    });



    Route::controller(UserController::class)->group(function () {
        Route::get('/admin/users', 'index')->name('admin.users.liste'); // Afficher tous les utilisateurs
        Route::get('/admin/users/create', 'create')->name('admin.users.create'); // Formulaire pour créer un utilisateur
        Route::post('/admin/users/store', 'store')->name('admin.users.store'); // Stocker un nouvel utilisateur
        Route::get('/admin/users/edit/{id}', 'edit')->name('admin.users.edit'); // Formulaire pour éditer un utilisateur
        Route::post('/admin/users/update/{id}', 'update')->name('admin.users.update'); // Mettre à jour un utilisateur
        Route::post('/admin/users/destroy/{id}', 'destroy')->name('admin.users.destroy'); // Supprimer un utilisateur
        Route::get('/Admin/Acquisition/Stock', 'AdminStockAcquisition')->name('admin.stock.acquisition');
        Route::get('/admin/Graphique/Stock', 'AdminStockGraphique')->name('admin.stock.graphique');

    });



});


// Routes pour le gestionnaire
Route::middleware(['auth', 'role:gestionnaire'])->group(function () {
    Route::get('/gestionnaire/dashboard', [GestionnaireController::class, 'GestionnaireDashboard'])->name('gestionnaire.dashboard');
    Route::get('/gestionnaire/logout', [GestionnaireController::class, 'GestionnaireLogout'])->name('gestionnaire.logout');
    Route::get('/gestionnaire/profile', [GestionnaireController::class, 'GestionnaireProfile'])->name('gestionnaire.profile');
    Route::post('/gestionnaire/profile/store', [GestionnaireController::class, 'GestionnaireProfileStore'])->name('gestionnaire.profile.store');
    Route::get('/gestionnaire/change/password', [GestionnaireController::class, 'GestionnaireChangePassword'])->name('gestionnaire.change.password');
    Route::post('/gestionnaire/update/password', [GestionnaireController::class, 'GestionnaireUpdatePassword'])->name('gestionnaire.update.password');

    Route::controller(TypeEquipementController::class)->group(function () {
        Route::get('/Equipement/Types', 'EquipementType')->name('liste.type');
        Route::post('/Store/Type', 'StoreType')->name('store.type');
        Route::post('/Update/Type', 'UpdateType')->name('update.type');
        Route::get('/Delete/Type/{id}', 'DeleteType')->name('delete.type');
    });



    Route::controller(AcquisitionController::class)->group(function () {
        Route::get('/Acquisition/Liste', 'ListeAcquisition')->name('liste.acquisition');
        Route::post('/Store/Acquisition', 'StoreAcquisition')->name('store.acquisition');
        Route::post('/Update/Acquisition/{id}', 'UpdateAcquisition')->name('update.acquisition');
        Route::get('/Acquisition/Stock', 'StockAcquisition')->name('stock.acquisition');
        Route::get('/Graphique/Stock', 'StockGraphique')->name('stock.graphique');
        Route::get('/Acquisition/PDF', 'GenererPDF')->name('acquisition.pdf');
    });

    Route::controller(DotationController::class)->group(function () {
        Route::get('/Dotation/Liste', 'ListeDotation')->name('liste.dotation');
        Route::post('/Store/Dotation', 'StoreDotation')->name('store.dotation');
        Route::post('/Update/Dotation/{id}', 'UpdateDotation')->name('update.dotation');
        Route::get('/Dotation/Stock', 'StockDotagraph')->name('stock.dotagraph');
        Route::post('/restituer/dotation/{id}', 'restituerDotation')->name('restituer.dotation');
        Route::get('/Dotation/PDF', 'GenererPDFDotations')->name('dotation.pdf');


    });

    Route::controller(RestitutionController::class)->group(function () {
        Route::post('/dotations/{dotation}/restitution', 'createRestitution')->name('create.restitution');

    });



});

// Routes pour le maintenancier
Route::middleware(['auth', 'role:technicien'])->group(function () {
    Route::get('/atelier/dashboard', [AtelierController::class, 'AtelierDashboard'])->name('atelier.dashboard');
    Route::get('/atelier/logout', [AtelierController::class, 'AtelierLogout'])->name('atelier.logout');
    Route::get('/atelier/profile', [AtelierController::class, 'AtelierProfile'])->name('atelier.profile');
    Route::post('/atelier/profile/store', [AtelierController::class, 'AtelierProfileStore'])->name('atelier.profile.store');
    Route::get('/atelier/change/password', [AtelierController::class, 'AtelierChangePassword'])->name('atelier.change.password');
    Route::post('/atelier/update/password', [AtelierController::class, 'AtelierUpdatePassword'])->name('atelier.update.password');

    Route::controller(AtelierController::class)->group(function () {
        Route::get('/Technicien/Liste', 'ListeTechnicien')->name('liste.technicien');
        Route::post('/Store/Technicien', 'StoreTechnicien')->name('store.technicien');
        Route::post('/Update/Technicien/{id}', 'UpdateTechnicien')->name('update.technicien');
        Route::get('/Delete/Technicien/{id}', 'DeleteTechnicien')->name('delete.technicien');
    });

    Route::controller(MaintenanceController::class)->group(function () {
        Route::get('/Maintenance/Liste', 'ListeMaintenance')->name('liste.maintenance');
        Route::post('/Store/Maintenance', 'StoreMaintenance')->name('store.maintenance');
        Route::post('/Store/Statut/{id}', 'StoreStatut')->name('store.statut');
        Route::post('/Update/Maintenance/{id}', 'UpdateMaintenance')->name('update.maintenance');
        Route::get('/Delete/Service/{id}', 'DeleteMaintenance')->name('delete.maintenance');
        Route::get('/Maintenance/Stock', 'Stock')->name('stock.equipement');
        Route::get('/Maintenance/Graphique/Stock', 'MaintenanceStockGraphique')->name('maintenance.stock.graphique');
        Route::get('/Maintenance/PDF', 'GenererPDFMaintenance')->name('maintenance.pdf');
    });


});


// Routes de connexion
Route::get('/Page/Login', [AdminController::class, 'AdminLogin'])->name('admin.login');



