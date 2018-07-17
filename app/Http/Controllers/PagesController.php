<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Friend;
use App\Language;

class PagesController extends Controller
{
    // Homepage
    public function homepage()
    {
        return view('homepage');
    }

    // Do Custom Login With User ID = 1
    public function customLoginByUserID()
    {
        $user = User::findOrFail(1);
        auth()->login($user);
        return redirect()->route('find-friends-index');
    }

    // Show Find Friends Page
    public function findFriendsIndex()
    {
        // Get countries info
        $countries = Language::get();

        return view('findfriends.index', compact('countries'));
    }

    // Prepare Friends Suggestions
    public function findFriendsSuggestionsPrepare()
    {   
        return redirect()->route('find-friends-suggestions', ['country_id' =>request('country_id')]);
    }

    // Show Friend Suggestions
    public function findFriendsSuggestions($country_id = 1)
    {
        // Ajax Loading Results
        if (isset($_GET['ajax'])) {
            $isAjax = true;
            $json = array(array());
            $index = 0;
        }else
        {
            $isAjax = false;
        }

        /*
            Logic is simple:
            
            - Get IDs of my friends
            - Get users which are not in IDs of my friends
        */

        // First, get friends which I am added to friends
        $myFriends1 = Friend::where('fr1', '=', Auth::user()->user_id)->get();

        // Second, get friends which they added me to friends
        $myFriends2 = Friend::where('fr2', '=', Auth::user()->user_id)->get();

        // Now, get IDs of my friends
        $myFriendsIDs = array();

        foreach ($myFriends1 as $row) {
            $myFriendsIDs[] = $row->fr2;
        }

        foreach ($myFriends2 as $row) {
            $myFriendsIDs[] = $row->fr1;
        }

        // Remove duplicate IDs
        $myFriendsIDs = array_unique($myFriendsIDs);

        // Get countries info
        $countries = Language::get();
        
        // Get users which are not in IDs of my friends
        $users = User::whereNotIn('user_id', $myFriendsIDs)->where('country', $country_id)->inRandomOrder()->paginate(25);

        // Set country name
        foreach($users as $key => $user)
        {
            $users[$key]['country_name'] = $countries[($user->country - 1)]->country_name;
            
            // If Ajax Is Used
            if($isAjax)
            {

                $json[$index]['real_name'] = $users[$key]['real_name'];
                $json[$index]['email'] = $users[$key]['email'];
                $json[$index]['country_name'] = $users[$key]['country_name'];
                $index++;
            }
        }

        // Response Depends If Ajax Is Used
        if($isAjax)
        {
            // Return Ajax Json Response
            echo json_encode($json);
        }else
        {
            // Normal
            return view('findfriends.suggestions', compact('users', 'country_id'));
        }
    }
}
