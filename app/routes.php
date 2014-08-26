<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::model('task','Task');


Route::get('/','TasksController@home');
Route::get('/create','TasksController@create');
Route::get('/edit/{task}','TasksController@edit');
Route::get('/delete/{task}','TasksController@delete');
Route::get('task/{id}', 'TasksController@show')->where('id', '\d+');


Route::post('/create', 'TasksController@saveCreate');
Route::post('/edit', 'TasksController@doEdit');
Route::post('/delete', 'TasksController@doDelete');

/*
Route::get('/', function()
{
	$task = Task::find(1);
	return $task->title;

	$task = Task::find(1);
	$task->title = 'Eating different breakfast';
	$task->body = 'Remember to buy beefsteak';
	$task->save();

	$task = new Task;
	$task->title = 'Eating breakfast';
	$task->body = 'Remember to buy bread, egg and milk.';
	$task->save();

	//Schema::dropIfExists('tasks');
	//return View::make('home');
	//return 'Hello! Welcome to my first app!';
});
*/

Route::get('/about', function()
{
    return View::make('about');
});

Route::get('/contact', function()
{
    return View::make('contact');
});

Route::post('contact' , function()
{
	$data = Input::all();
	$rules = array('subject' => 'required',
					'message' => 'required');

	$validator = Validator::make($data , $rules);

	if ($validator->fails()){
		return Redirect::to('contact')->withErrors($validator)->withInput();
	}

	$emailcontent = array (
			'subject' => $data['subject'],
			'emailmessage' => $data['message']
	);

	Mail::send('emails.contactemail', $emailcontent, function($message)
	{
		$message->to('xingyinzhu@163.com','Learning Laravel Support')
		->subject('Contact via Our Contact Form');
	});

	return 'Your message has been sent';

});
