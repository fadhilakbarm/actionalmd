<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAdministrator;
use Auth;
use Exception;
use Socialite;

class GitHubController extends Controller
{
    public function gitRedirect()
    {
        return Socialite::driver('github')->redirect();
    }
       
    public function gitCallback()
    {
        try {
            $userAdministrator = Socialite::driver('github')->user();
      
            $searchUser = UserAdministrator::where('github_id', $userAdministrator->id)->first();
      
            if($searchUser){
                Auth::login($searchUser);
     
                return redirect('/user');
            }else{
                $gitUser = UserAdministrator::create([
                    'name' => $userAdministrator->name,
                    'email' => $userAdministrator->email,
                    'github_id'=> $userAdministrator->id,
                    'auth_type'=> 'github',
                    'password' => encrypt('12345')
                ]);
     
                Auth::login($gitUser);
      
                return redirect('/user');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}