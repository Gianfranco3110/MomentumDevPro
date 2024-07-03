<?php

use App\Http\Controllers\Controller;
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


Route::group(['middleware' => ['api']], function ($router) {

    Route::get('email/verify/{id}', 'AuthController@verify')->name('verification.verify');

    Route::get('menu', 'MenuController@index');

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('register', 'AuthController@register');


    Route::put('user/password/change','UsersController@updatePassword');
    Route::get('user/logged','UsersController@userLogged');

    Route::resource('notes', 'NotesController');

    //RUTA PARA GUARDAR LAS RESPUESTA DE LOS TEST
    Route::post('answer/store','AnswerUserController@store');
    Route::post('answer/validate-answer','AnswerUserController@validateanswer');

    //ROUTE PARA CREAR PRODUCTOS ANTONIO
    Route::post('products/image/store','productsController@uploadImage');
    Route::put('products/eliminate/{product}','productsController@deleteProduct');
    Route::get('products/myproducts', 'productsController@showPerUser');
    Route::get('products/all','productsController@AllProducts');
    Route::resource('products', 'productsController');

    //ROUTE PARA CREAR CURSOS GIANF
    Route::post('courses/image/store','CoursesController@uploadImage');
    Route::get('courses/courses', 'CoursesController@showPerUser');
    Route::get('courses/list', 'CoursesController@nameCourses');
    Route::get('courses/all','CoursesController@allCourses');
    Route::get('courses/mycourses','CoursesController@misCursos');
    Route::resource('courses', 'CoursesController');
    Route::get('courses/details/landig', 'CoursesController@details');
    Route::post('courses/verificarfecha', 'CoursesController@valueDateExpirate');

    //ROUTE PARA OBTENER LAS IMG DE LOS CURSOS
    Route::get('courses/img/{img}', function ($img)
    {
        // dd($img);
        $path  = public_path(Controller::FOLDERCOURSE.'/'.$img);

        if (!File::exists($path))
        {
            abort(404);
        }

        $file = File::get($path);

        $type = File::mimeType($path);

        $response = Response::make($file, 200);

        $response->header("Content-Type", $type);

        return $response;

    });



    Route::post('user/forget-password','AuthController@forgetPassword');
    Route::post('user/password/reset','AuthController@resetPassword');

    //ROUTES PARA VINCULACION CURSO-USUARIO
    Route::post('usercourses/create','UserCourseController@create');
    Route::put('usercourses/{id}/changestatus','UserCourseController@changeStatus');
    Route::get('usercourses/{id}','UserCourseController@index');
    Route::get('usercourses/list/{id}','UserCourseController@course_user');
    Route::delete('usercourses/{id}','UserCourseController@destroy');
    Route::post('position/urlcurso/', 'UserCourseController@positionCurso');

    //ROUTE PARA GENERAR PDF
    Route::get('usercourses/pdf','UserCourseController@generatePDF');

    //ROUTE PARA ASOCIAR VIDEOS A LOS CURSOS GIANF
    Route::post('coursesvideos/store','Courses_videoController@store');
    //ACTUALIZAR EL STATUS DEL VIDEO A INACTIVO
    Route::post('coursesvideos/updatestatus','Courses_videoController@changeStatus');
    Route::get('coursesvideos/list/{id}', 'Courses_videoController@index');
    // TRAER LAS SECCIONES
    Route::get('coursesvideos/listsections', 'Courses_videoController@getSections');

    //ROUTE PARA CREAR LAS PREGUNTAS-TEST DE LOS CURSOS
    Route::get('coursestest/list/{id}', 'User_questionController@index');

    //ROUTE PARA OBTENER LAS IMG DE LOS TEST DE REPUESTAS
    Route::get('coursestest/img-verifi/{id_user}/{id_course}/{img}', function ($id_user,$id_course,$img)
    {

        $path  = public_path('imgquestion/user_'.$id_user.'/question_'.$id_course.'/'.$img);

        if (!File::exists($path))
        {
            abort(404);
        }

        $file = File::get($path);

        $type = File::mimeType($path);

        $response = Response::make($file, 200);

        $response->header("Content-Type", $type);

        return $response;

    });


    Route::post('coursestest/store','User_questionController@store');
    Route::post('coursestest/updatestatus','User_questionController@changeStatus');
    Route::get('coursestest/listfieldsquestion/{id}', 'User_questionController@fieldsquestion');

    //RUTA ENVIA LAS OPCIONES DEL TEST CUANDO ES SELECCION SIMPLE
    Route::get('questionfields/listoptionsquestion/{id_curso}/{id_question}', 'User_questionController@questionfieldsAux');


    //RUTA QUE SE ENCARGA DE IMPRIMIR LOS CERTIFICADOS
    Route::post('usercertificado', 'Pdf_CertificadoController@getPDF');
    Route::post('usercertificado/img/upload', 'Pdf_CertificadoController@uploadImage');

    Route::resource('resource/{table}/resource', 'ResourceController');
    Route::get('media/storage','MediaController@getStoragePath');

    //RUTA PARA ENVIAR TODOS LOS DATOS DE UN CURSO EN ESPECIFICO
    Route::get('viewcoursestart/{id_curso}/{id_user}', 'Courses_videoController@viewcoursestart');



    //RUTA SECCIONES DE CURSOS
    Route::resource('course-sections',"CourseSectionController");

      //RUTA PARA TRAER LOS ESTADOS Y MUNICIPIOS
    Route::get('states', 'CountriesController@states');




    Route::group(['middleware' => 'admin'], function ($router) {

        Route::resource('mail',        'MailController');
        Route::get('prepareSend/{id}', 'MailController@prepareSend')->name('prepareSend');
        Route::post('mailSend/{id}',   'MailController@send')->name('mailSend');

        Route::resource('bread',  'BreadController');   //create BREAD (resource)

        Route::resource('users', 'UsersController')->except( ['create', 'store'] );

        Route::prefix('menu/menu')->group(function () {
            Route::get('/',         'MenuEditController@index')->name('menu.menu.index');
            Route::get('/create',   'MenuEditController@create')->name('menu.menu.create');
            Route::post('/store',   'MenuEditController@store')->name('menu.menu.store');
            Route::get('/edit',     'MenuEditController@edit')->name('menu.menu.edit');
            Route::post('/update',  'MenuEditController@update')->name('menu.menu.update');
            Route::get('/delete',   'MenuEditController@delete')->name('menu.menu.delete');
        });
        Route::prefix('menu/element')->group(function () {
            Route::get('/',             'MenuElementController@index')->name('menu.index');
            Route::get('/move-up',      'MenuElementController@moveUp')->name('menu.up');
            Route::get('/move-down',    'MenuElementController@moveDown')->name('menu.down');
            Route::get('/create',       'MenuElementController@create')->name('menu.create');
            Route::post('/store',       'MenuElementController@store')->name('menu.store');
            Route::get('/get-parents',  'MenuElementController@getParents');
            Route::get('/edit',         'MenuElementController@edit')->name('menu.edit');
            Route::post('/update',      'MenuElementController@update')->name('menu.update');
            Route::get('/show',         'MenuElementController@show')->name('menu.show');
            Route::get('/delete',       'MenuElementController@delete')->name('menu.delete');
        });
        Route::prefix('media')->group(function ($router) {
            Route::get('/',                 'MediaController@index')->name('media.folder.index');
            Route::get('/folder/store',     'MediaController@folderAdd')->name('media.folder.add');
            Route::post('/folder/update',   'MediaController@folderUpdate')->name('media.folder.update');
            Route::get('/folder',           'MediaController@folder')->name('media.folder');
            Route::post('/folder/move',     'MediaController@folderMove')->name('media.folder.move');
            Route::post('/folder/delete',   'MediaController@folderDelete')->name('media.folder.delete');;

            Route::post('/file/store',      'MediaController@fileAdd')->name('media.file.add');
            Route::get('/file',             'MediaController@file');
            Route::post('/file/delete',     'MediaController@fileDelete')->name('media.file.delete');
            Route::post('/file/update',     'MediaController@fileUpdate')->name('media.file.update');
            Route::post('/file/move',       'MediaController@fileMove')->name('media.file.move');
            Route::post('/file/cropp',      'MediaController@cropp');
            Route::get('/file/copy',        'MediaController@fileCopy')->name('media.file.copy');

            Route::get('/file/download',    'MediaController@fileDownload');
        });

        Route::resource('roles',        'RolesController');
        Route::get('/roles/move/move-up',      'RolesController@moveUp')->name('roles.up');
        Route::get('/roles/move/move-down',    'RolesController@moveDown')->name('roles.down');
    });
});
