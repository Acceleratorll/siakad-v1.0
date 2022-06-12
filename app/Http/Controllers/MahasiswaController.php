<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;

class MahasiswaController extends Controller
{
 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
 public function index()
 {
 //fungsi eloquent menampilkan data menggunakan pagination

 $mahasiswa = Mahasiswa::with('kelas')->get(); // Mengambil semua isi tabel
 $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
 return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate'=>$paginate]);
 }

 public function create()
 {
    $kelas = Kelas::all();
 return view('mahasiswa.create',['kelas'=>$kelas]);
 }

 public function store(Request $request)
 {
          $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            
        ]);
              $mahasiswa = new Mahasiswa;
              $mahasiswa->nim = $request->get('Nim');
              $mahasiswa->nama = $request->get('Nama');
              $mahasiswa->jurusan = $request->get('Jurusan');
              $mahasiswa->kelas_id = $request->get('Kelas');
              $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

public function show($Nim)
    {
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        return view('mahasiswa.detail', ['Mahasiswa' => $Mahasiswa]);
    }

 public function edit($Nim)
 {    
     $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
     $kelas = Kelas::all();
     return view('mahasiswa.edit', compact('Mahasiswa', 'kelas'));
    }
    
 public function update(Request $request, $Nim)
 {
//melakukan validasi data
 $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
        ]);
        
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->save();
  

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
 }

 public function cari(Request $request){
         $cari = $request->cari;
         
         $mahasiswa = Mahasiswa::where('nama','like', "%" . $cari ."%")
         ->paginate(3);
 
         return view('mahasiswa.index',['mahasiswa'=>$mahasiswa]);
     }
};
