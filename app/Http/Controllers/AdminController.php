<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function AdminDashboard(){

        return view('admin.index');

    } //Fin method adminDashboard


    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/Page/Login');
    }//Fin method adminDashboard

    public function AdminLogin()
    {
        return view('admin.admin_login');

    }//Fin method adminDashboard

    public function AdminProfile(){

        $id = Auth::user()->id;
        $profileData = User::find( $id );
        return view('admin.admin_profile_view', compact('profileData'));

    }

    public function AdminProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find( $id );
        $data->name = $request->name;
        $data->prenom = $request->prenom;
        $data->email = $request->email;
        $data->telephone = $request->telephone;
        $data->adresse = $request->adresse;

        if($request->file('photo'))
        {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();

        $notification = array(
            'message'=>'Mis a jour Réussie',
            'alert-type'=>'success'

        );

        return redirect()->back()->with($notification);
    }

    public function AdminChangePassword()
    {

        $id = Auth::user()->id;
        $profileData = User::find( $id );

        return view('admin.admin_change_password',compact('profileData'));
    }

    public function AdminUpdatePassword(Request $request){
      // Validation
      $request->validate ([
          'old_password'=>'required',
          'new_password'=>'required|confirmed',

      ]);
      // Match old password
      if(!Hash::check($request->old_password,auth::user()->password)){
          $notification = array(
              'message' => 'Erreur',
              'alert-type' => 'error'
          );
          return redirect()->back()->with($notification);

      }

              // Match old password
      User::whereId(auth()->user()->id)->update([
          'password'=> Hash::make($request->new_password)
      ]);
      $notification = array(
          'message' => ' Mot de Passe Changer',
          'alert-type' => 'success'
      );

      return redirect()->back()->with($notification);
    }
}

