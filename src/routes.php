<?php

//Bind route parameter
Route::model('vote','Vvote');

Route::pattern('vote', '[0-9]+');

Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{

//Show pages
    Route::get('vote/create', 'VvoteController@getCreate');
    Route::get('vote/{vote}/edit', 'VvoteController@getEdit');
    Route::get('vote/{vote}/results', 'VvoteController@getResults');
    Route::post('vote/create', 'VvoteController@postCreate');
    Route::post('vote/{vote}/edit', 'VvoteController@postEdit');
    Route::post('vote/delete', 'VvoteController@postDelete');
    Route::controller('vote', 'VvoteController');

});

Route::group(array('prefix' => 'vote', 'before' => 'auth'), function()
{
    Route::post('submit', 'VvoteController@postVote');

//Show pages
/*Route::get('/inbox', 'VvoteController@index');
Route::get('/outbox', 'VvoteController@index_outbox');
Route::get('/new', 'VvoteController@create');
Route::get('/show/{msg}', 'VvoteController@getMsg');
Route::get('/show/sent/{msg}', 'VvoteController@getSentMsg');
Route::get('/reply/{msg}', 'VvoteController@reply');
Route::get('/delete/{msg}', 'VvoteController@delete');
Route::get('/new/users.json', 'VvoteController@data');

//handle form submissions
Route::post('/new', 'VvoteController@handleCreate');
Route::post('/delete', 'VvoteController@handleDelete');*/

});