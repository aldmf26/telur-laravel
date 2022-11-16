<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    public function email(Request $r)
    {
        $data = [
            'title' => 'Email',
            'email' => DB::table('tb_email')->get()
        ];
        return view('email.email',$data);
    }

    public function addEmail(Request $r)
    {
        DB::table('tb_email')->insert([
            'email' => $r->email,
        ]);
        return redirect()->route('email')->with('sukses', "Data berhasil ditambahkan");
    }

    public function editModalEmail(Request $r)
    {
        return view('email.modal',[
            'email' =>  DB::table('tb_email')->where('id_email', $r->id_email)->first(),
        ]);
    }

    public function editEmail(Request $r)
    {
        DB::table('tb_email')->where('id_email', $r->id_email)->update([
            'email' => $r->email
        ]);
        return redirect()->route('email')->with('sukses', 'Data berhasil diubah');
    }

    public function deleteEmail($id)
    {
        DB::table('tb_email')->where('id_email', $id)->delete();
        return redirect()->route('email')->with('sukses', "Data berhasil dihapus");
    }
}
