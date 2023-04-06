<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kelas;

class Mahasiswa extends Model
{
    protected $table = "mahasiswas"; // Eloquent akan membuat model mahasiswa
    //menyimpan record di tabel mahasiswas
    public $timestamps = true;
    protected $primaryKey = 'Nim'; // Memanggil isi DB Dengan primarykey
    use HasFactory;

    protected $fillable = [
        'Nim',
        'Nama',
        'kelas_id',
        'Jurusan',
        'No_Handphone',
        'email',
        'tgl_lahir',
    ];
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
