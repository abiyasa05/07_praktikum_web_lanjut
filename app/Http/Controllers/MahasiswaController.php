<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        $katakunci = $request->katakunci;
        $jumlahbaris = 4;
        if(strlen($katakunci)){
            $mahasiswas = Mahasiswa::with('Nim', 'like', "%$katakunci%")
                ->orwhere('Nama', 'like', "%$katakunci%")
                ->orwhere('kelas_id', 'like', "%$katakunci%")
                ->orwhere('Jurusan', 'like', "%$katakunci%")
                ->orwhere('No_Handphone', 'like', "%$katakunci%")
                ->orwhere('email', 'like', "%$katakunci%")
                ->orwhere('tgl_lahir', 'like', "%$katakunci%")
                ->paginate($jumlahbaris);
        } else {
            $mahasiswas = Mahasiswa::with('kelas')->get();
            $paginate = Mahasiswa::orderBy('Nim', 'asc')->paginate(5);
        }
        return view('mahasiswas.index', ['mahasiswa' => $mahasiswas, 'paginate'=>$paginate]);
    }
    // public function indexx(Request $request){
    //     $katakunci = $request->katakunci;
    //     $jumlahbaris = 4;
    //     if(strlen($katakunci)){
    //         $mahasiswas = Mahasiswa::where('Nim', 'like', "%$katakunci%")
    //             ->orwhere('Nama', 'like', "%$katakunci%")
    //             ->orwhere('Kelas', 'like', "%$katakunci%")
    //             ->orwhere('Jurusan', 'like', "%$katakunci%")
    //             ->orwhere('No_Handphone', 'like', "%$katakunci%")
    //             ->orwhere('email', 'like', "%$katakunci%")
    //             ->orwhere('tgl_lahir', 'like', "%$katakunci%")
    //             ->paginate($jumlahbaris);
    //     } else {
    //         $mahasiswas = Mahasiswa::orderBy('Nim', 'desc')->paginate(5);
    //     }
    //     return view('mahasiswas.index')->with('mahasiswas',$mahasiswas);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswas.create' , ['kelas' => $kelas]);
    }
    // public function createe()
    // {
    //     return view('mahasiswas.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required|unique:mahasiswas,Nim',
            'Nama' => 'required',
            'kelas_id' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required|unique:mahasiswas,No_Handphone',
            'email' => 'required|unique:mahasiswas,email',
            'tgl_lahir' => 'required',
        ],
        [
            'Nim.required' => 'Nim wajib diisi',
            'Nim.unique' => 'Nim yang diisikan sudah ada dalam database',
            'No_Handphone.unique' => 'No Handphone yang diisikan sudah ada dalam database',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email yang diisikan sudah ada dalam database',
            'Nama.required' => 'Nama wajib diisi',
            'kelas_id.required' => 'Kelas wajib diisi',
            'Jurusan.required' => 'Jurusan wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'No_Handphone.required' => 'No Handphone wajib diisi',
        ]);
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->no_handphone = $request->get('No_Handphone');
        $mahasiswa->email = $request->get('email');
        $mahasiswa->tgl_lahir = $request->get('tgl_lahir');
        // $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('kelas_id');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil ditambahkan');
    }
    // public function store(Request $request)
    // {
    //     //melakukan validasi data
    //     $request->validate([
    //         'Nim' => 'required|unique:mahasiswas,Nim',
    //         'Nama' => 'required',
    //         'Kelas' => 'required',
    //         'Jurusan' => 'required',
    //         'No_Handphone' => 'required|unique:mahasiswas,No_Handphone',
    //         'email' => 'required|unique:mahasiswas,email',
    //         'tgl_lahir' => 'required',
    //     ],
    //     [
    //         'Nim.required' => 'Nim wajib diisi',
    //         'Nim.unique' => 'Nim yang diisikan sudah ada dalam database',
    //         'No_Handphone.unique' => 'No Handphone yang diisikan sudah ada dalam database',
    //         'email.required' => 'Email wajib diisi',
    //         'email.unique' => 'Email yang diisikan sudah ada dalam database',
    //         'Nama.required' => 'Nama wajib diisi',
    //         'Kelas.required' => 'Kelas wajib diisi',
    //         'Jurusan.required' => 'Jurusan wajib diisi',
    //         'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
    //         'No_Handphone.required' => 'No Handphone wajib diisi',
    //     ]);
    //     $data = [
    //         'Nim' => $request->Nim,
    //         'Nama' => $request->Nama,
    //         'Kelas' => $request->Kelas,
    //         'Jurusan' => $request->Jurusan,
    //         'No_Handphone' => $request->No_Handphone,
    //         'email' => $request->email,
    //         'tgl_lahir' => $request->tgl_lahir,
    //     ];
    //         //fungsi eloquent untuk menambah data
    //         Mahasiswa::create($data);
    //         //jika data berhasil ditambahkan, akan kembali ke halaman utama
    //         return redirect()->to('mahasiswa')->with('success', 'Mahasiswa Berhasil ditambahkan');
    // }

    /**
     * Display the specified resource.
     */
    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa
        //code sebelum dibuat relasi --> $mahasiswa = Mahasiswa::find($Nim);
        $mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();
        return view('mahasiswas.detail', ['Mahasiswa' => $mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim 
        //Mahasiswa untuk diedit
            $mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();
            $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
            return view('mahasiswas.edit', compact('mahasiswa','kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required|unique:mahasiswas,Nim',
            'Nama' => 'required',
            'kelas_id' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required|unique:mahasiswas,No_Handphone',
            'email' => 'required|unique:mahasiswas,email',
            'tgl_lahir' => 'required',
        ],
        [
            'Nim.required' => 'Nim wajib diisi',
            'Nim.unique' => 'Nim yang diisikan sudah ada dalam database',
            'No_Handphone.unique' => 'No Handphone yang diisikan sudah ada dalam database',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email yang diisikan sudah ada dalam database',
            'Nama.required' => 'Nama wajib diisi',
            'kelas_id.required' => 'Kelas wajib diisi',
            'Jurusan.required' => 'Jurusan wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'No_Handphone.required' => 'No Handphone wajib diisi',
        ]);
        $data = [
            'Nim' => $request->Nim,
            'Nama' => $request->Nama,
            'Kelas' => $request->Kelas,
            'Jurusan' => $request->Jurusan,
            'No_Handphone' => $request->No_Handphone,
            'email' => $request->email,
            'tgl_lahir' => $request->tgl_lahir,
        ];

        $mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->no_handphone = $request->get('No_Handphone');
        $mahasiswa->email = $request->get('email');
        $mahasiswa->tgl_lahir = $request->get('tgl_lahir');

        $kelas = new Kelas;
        $kelas->id = $request->get('kelas_id');

        //fungsi eloquent untuk mengupdate data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }
    //  public function update(Request $request, $Nim)
    // {
    //     //melakukan validasi data
    //     $request->validate([
    //         'Nim' => 'required|unique:mahasiswas,Nim',
    //         'Nama' => 'required',
    //         'Kelas' => 'required',
    //         'Jurusan' => 'required',
    //         'No_Handphone' => 'required|unique:mahasiswas,No_Handphone',
    //         'email' => 'required|unique:mahasiswas,email',
    //         'tgl_lahir' => 'required',
    //     ],
    //     [
    //         'Nim.required' => 'Nim wajib diisi',
    //         'Nim.unique' => 'Nim yang diisikan sudah ada dalam database',
    //         'No_Handphone.unique' => 'No Handphone yang diisikan sudah ada dalam database',
    //         'email.required' => 'Email wajib diisi',
    //         'email.unique' => 'Email yang diisikan sudah ada dalam database',
    //         'Nama.required' => 'Nama wajib diisi',
    //         'Kelas.required' => 'Kelas wajib diisi',
    //         'Jurusan.required' => 'Jurusan wajib diisi',
    //         'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
    //         'No_Handphone.required' => 'No Handphone wajib diisi',
    //     ]);
    //     $data = [
    //         'Nim' => $request->Nim,
    //         'Nama' => $request->Nama,
    //         'Kelas' => $request->Kelas,
    //         'Jurusan' => $request->Jurusan,
    //         'No_Handphone' => $request->No_Handphone,
    //         'email' => $request->email,
    //         'tgl_lahir' => $request->tgl_lahir,
    //     ];
    //         //fungsi eloquent untuk mengupdate data inputan kita
    //         Mahasiswa::where('Nim',$Nim)->update($data);
    //         //jika data berhasil diupdate, akan kembali ke halaman utama
    //         return redirect()->to('mahasiswa')->with('success', 'Mahasiswa Berhasil Diupdate');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
            Mahasiswa::find($Nim)->delete();
            return redirect()->route('mahasiswa.index')
                -> with('success', 'Mahasiswa Berhasil Dihapus');
    }
}
