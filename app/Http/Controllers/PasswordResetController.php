<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;

class PasswordResetController extends Controller
{
    public function reset(){
        return view('auth.changePassword');
    }

    public function changePassword(Request $request){

                $PassIn = $request->get('current-password');
                $PassNew = $request->get('new-password');
                $hashedPassIn = hash('sha256', $PassIn, false);
                $NewPassword = hash('sha256', $PassNew, false);
                // if (!(Hash::check($hashedPassIn, Auth::user()->clave))) {
                if (!($hashedPassIn == Auth::user()->clave)) {
                    // The passwords matches
                    
                    return redirect()->back()->with("error","Su contraseña actual no coincide con la contraseña que proporcionó. Inténtalo de nuevo.");
                }
                if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
                    //Current password and new password are same
                    return redirect()->back()->with("error","La nueva contraseña no puede ser la misma que su contraseña actual. Por favor elija una contraseña diferente.");
                }
                $validatedData = $request->validate([
                    'current-password' => 'required',
                    'new-password' => 'required|string|min:6|confirmed',
                ]);
                //Change Password
                $user = Auth::user();
                // $user->clave = bcrypt($request->get('new-password'));
                $user->clave = $NewPassword;
                $user->save();
                return redirect()->back()->with("success","Contraseña cambiada con éxito !");
    }
}
