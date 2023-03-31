@extends('mahasiswas.layout')

@section('content')

<div class="container mt-5">

    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
            <div class="card-header">
            Edit Mahasiswa
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="pt-3">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endif
            <form method="post" action="{{ route('mahasiswa.update', $Mahasiswa->Nim) }}" id="myForm">
            @csrf
            @method('PUT')
                <div class="form-group">
                    <label for="Nim">Nim</label>
                    <input type="text" name="Nim" class="form-control" id="Nim" 
                    value="{{ $Mahasiswa->Nim }}" 
                    ariadescribedby="Nim">
                </div>
                <div class="form-group">
                    <label for="Nama">Nama</label>
                    <input type="text" name="Nama" class="form-control" id="Nama" 
                    value="{{ $Mahasiswa->Nama }}" 
                    ariadescribedby="Nama">
                </div>
                <div class="form-group">
                    <label for="Kelas">Kelas</label>
                    <input type="text" name="Kelas" class="form-control" id="Kelas" 
                    value="{{ $Mahasiswa->Kelas }}" 
                    ariadescribedby="Kelas">
                </div>
                <div class="form-group">
                    <label for="Jurusan">Jurusan</label>
                    <input type="text" name="Jurusan" class="form-control" id="Jurusan" 
                    value="{{ $Mahasiswa->Jurusan }}" 
                    ariadescribedby="Jurusan">
                </div>
                <div class="form-group">
                    <label for="No_Handphone">No Handphone</label>
               
                    <input type="number" name="No_Handphone" class="form-control" id="No_Handphone" 
                    value="{{ $Mahasiswa->No_Handphone }}" 
                    ariadescribedby="No_Handphone" >
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
               
                    <input type="email" name="email" class="form-control" id="email" 
                    value="{{ $Mahasiswa->email }}" 
                    ariadescribedby="email" >
                </div>
                <div class="form-group">
                    <label for="tgl_lahir">Tanggal Lahir</label>
               
                    <input type="text" name="tgl_lahir" class="form-control" id="date" 
                    value="{{ $Mahasiswa->tgl_lahir }}" 
                    ariadescribedby="tgl_lahir" >
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection