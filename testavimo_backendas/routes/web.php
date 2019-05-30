<?php

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


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function($router){
    $router->get('/tests/categories','TestFormController@showAllCategories');
    $router->get('tests','TestFormController@showAllTests');
    $router->get('/tests/{test_id}','TestFormController@show');
    $router->get('/tests/showquestion/{question_id}','TestFormController@showOneQuestion');
    $router->delete('/tests/deletequestion/{question_id}','TestFormController@destroyQuestion');
    $router->delete('/tests/deleteanswer/{answer_id}','TestFormController@destroyAnswer');
    $router->delete('/tests/deletetest/{test_id}','TestFormController@destroyTest');
    $router->put('/tests/updatequestion/{question_id}','TestFormController@updateQuestion');
    $router->put('/tests/updateanswer/{answer_id}','TestFormController@updateAnswer');
    $router->put('/tests/updatetest/{test_id}','TestFormController@updateTest');
    $router->post('/test', 'TestFormController@postdata');
    $router->post('/test/question/{test_id}', 'PostMethodsController@postQuestion');
    $router->post('/test/answer/{question_id}', 'PostMethodsController@postAnswer');
    $router->get('/tests/generate/{test_id}/Title={title}/Description={des}/questionHash/{q}/answerHash/{a}/quantity/{num}', 
    'GeneratorController@generatePDF');
});
