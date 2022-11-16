<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class UserController extends Controller
{
    public function user(Request $r)
    {
        $data = [
            'title' => 'Data User',
            'user' => DB::select("SELECT *,a.name as nama,a.email_notif as emailNotif, a.id as id_user FROM users as a 
                                LEFT JOIN model_has_roles as b on a.id = b.model_id 
                                LEFT JOIN roles as c on b.role_id = c.id"),
        ];
        return view('user.user',$data);
    }

    public function addUser(Request $r)
    {
        $user = User::create([
            'name' => $r->name,
            'email' => $r->email,
            'password' => Hash::make($r->password),
        ]); 
        if($r->role == 'presiden')
        {
            $user->assignRole('presiden');
        } else {
            $user->assignRole('admin');
        }

        return redirect()->route('user')->with('sukses', "Data berhasil ditambahkan");
    }

    public function editModalUser(Request $r)
    {
        return view('user.modal',[
            'user' =>  DB::selectOne("SELECT *,a.name as nama, a.id as id_user FROM users as a 
                        LEFT JOIN model_has_roles as b on a.id = b.model_id 
                        LEFT JOIN roles as c on b.role_id = c.id
                        WHERE a.id = '$r->id_user'"),
        ]);
    }

    public function editUser(Request $r)
    {
        User::where('id', $r->id_user)->update([
            'email' => $r->email,
            'name' => $r->name,
        ]);
        DB::table('model_has_roles')->where('model_id', $r->id_user)->update([
            'role_id' => $r->role
        ]);
        return redirect()->route('email')->with('sukses', 'Data berhasil diubah');
    }

    public function deleteUser($id)
    {
        User::where('id', $id)->delete();
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        return redirect()->route('user')->with('sukses', "Data berhasil dihapus");
    }

    public function emailNotif($id,$status)
    {
        // dd($id . $status);
        User::where('id',$id)->update([
            'email_notif' => $status
        ]);
        return redirect()->route('user')->with('sukses', "Data berhasil diupdate");
    }
}
