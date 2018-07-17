<?php
// Homepage
Route::get('/', 'PagesController@homepage')->middleware('guest')->name('homepage');

// Custom Login By User ID ( =1 )
Route::get('/custom-login', 'PagesController@customLoginByUserID')->name('custom-login');

// Find Friends Panel
Route::get('/find-friends', 'PagesController@findFriendsIndex')->name('find-friends-index');

// Friends Suggestions Prepare
Route::post('/friends-suggestions-prepare', 'PagesController@findFriendsSuggestionsPrepare')->name('find-friends-suggestions-prepare');

// Friends Suggestions
Route::get('/friends-suggestions/{country_id}/', 'PagesController@findFriendsSuggestions')->name('find-friends-suggestions');

// Laravel Routes For Auth. Here is used only for Logout route.
Auth::routes();


