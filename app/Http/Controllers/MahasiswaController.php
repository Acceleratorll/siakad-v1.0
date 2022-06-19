<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;
use App\Models\Mahasiswa_MataKuliah;
use Illuminate\Support\Facades\Storage;
use PDF;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with('kelas')->get(); // Mengambil semua isi tabel
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'desc')->paginate(3);
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
            'Foto' => 'required'
        ]);
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->kelas_id = $request->get('Kelas');
        // $mahasiswa->foto = $image_name;
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
    
    public function nilai($id)
    {
        $mhs_matakuliah = Mahasiswa_Matakuliah::with('matakuliah')->where('mahasiswa_id', $id)->get();
        $mhs_matakuliah -> mahasiswa = Mahasiswa::where('nim', $id)->first();
        return view('mahasiswa.nilai', ['mhs_matakuliah' => $mhs_matakuliah]);
    }

    public function cetak_pdf($id)
    {
        $mhs = Mahasiswa::with('kelas')->where('id_mahasiswa', $id)->first();
        $matkul = Mahasiswa_MataKuliah::with('matakuliah')->where('mahasiswa_id', $id)->get();
        $pdf = PDF::loadview('mahasiswa.mhs_pdf', ['mhs' => $mhs, 'matkul' => $matkul]);
        return $pdf->stream();
    }
};    