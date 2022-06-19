@extends('mahasiswa.layout')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
        </div>
    </div>
    <div class="col-lg-12 margin-tb">
        <p><b>Nama :</b> {{ $mhs->nama }}<br>
        <b>NIM :</b> {{ $mhs->nim }}<br>
        {{-- <b>Kelas :</b> {{ $mhs_matakuliah->mahasiswa->kelas_id->nama_kelas }}</p> --}}
    </div>
</div>

    <table class="table table-bordered">
        <tr>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Nilai</th>
        </tr>
        @foreach ($matkul as $mk)
        <tr>
            <td>{{ $mk->matakuliah->nama_matkul }}</td>
            <td>{{ $mk->matakuliah->sks }}</td>
            <td>{{ $mk->matakuliah->semester }}</td>
            <td>{{ $mk->nilai }}</td>
        </tr>
        @endforeach
    </table>
@endsection

