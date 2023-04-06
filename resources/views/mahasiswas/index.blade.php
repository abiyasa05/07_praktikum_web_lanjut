@extends('mahasiswas.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
                <br>
            </div>
            <div class="pb-3">
                <form class="d-flex" action="{{ url ('mahasiswa')}}" method="get">
                    <input class="form-control me-1" type="search" name="katakunci" value="{{
                        Request::get('katakunci')}}" placeholder="Masukkan kata kunci"
                        aria-label="Search">
                        <button class="btn btn-primary" type="submit">Cari</button>
                </form>
            </div>
            <div class="pb-3">
                <a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input Mahasiswa</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nim</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>No Handphone</th>
            <th>Email</th>
            <th>Tanggal Lahir</th>
            <th width="280px">Action</th>
        </tr>
        <?php $i = $paginate->firstItem() ?>
        @foreach ($paginate as $Mahasiswa)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $Mahasiswa->Nim }}</td>
            <td>{{ $Mahasiswa->Nama }}</td>
            <td>{{ $Mahasiswa->kelas->nama_kelas }}</td>
            <td>{{ $Mahasiswa->Jurusan }}</td>
            <td>{{ $Mahasiswa->No_Handphone }}</td>
            <td>{{ $Mahasiswa->email }}</td>
            <td>{{ $Mahasiswa->tgl_lahir }}</td>
            <td>
            <form action="{{ route('mahasiswa.destroy',$Mahasiswa->Nim) }}" method="POST">

                <a class="btn btn-info" href="{{ route('mahasiswa.show',$Mahasiswa->Nim) }}">Show</a>
                <a class="btn btn-primary" href="{{ route('mahasiswa.edit',$Mahasiswa->Nim) }}">Edit</a>
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            </td>
        </tr>
        <?php $i++ ?>
        @endforeach
    </table>
    {{ $paginate->links() }}
@endsection