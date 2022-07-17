<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * @method __construct 
     * use middleware to protected routes
    */
    public function __construct()
    {
      $this->middleware(
        'auth:api', 
        ['except' => ['register', 'login']]);
    }
    
    /**
     * @method register
     * this method to add new user to the database
    */
    public function register(Request $request)
    {
      // fields validating
      $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|min:6|confirmed'
        ]);
      
      // after validated, input fields to the database
      User::create([
        'name' => $request->name,
        'email' =>$request->email,
        'password' => Hash::make($request->password)
        ]);
       
      // send response  
      return response()->json([
        'message' => 'registered successfully'
        ]);
    }
    
    /**
     * 
     * 
    */
    public function login(Request $request)
    {
      // fields validation
      $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|min:6'
        ]);
        
      // log in
      $credentials = $request->only('email', 'password');
      $token = auth()->attempt($credentials);
      if(!$token) {
        return response()->json([
          'message' => 'email or password not match'
          ]);
      }
   
      return response()->json([
        'message' => 'logged in',
        'token' => $token
        ]);
    }
    
    /**
     * GET - http://127.0.0.1:8000/api/logout
     */
    public function logout() 
    {
      
      auth()->logout();
      return response()->json([
        'message' => 'logged out'
        ]);
    }
   
}
