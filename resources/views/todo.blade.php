<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <div class="container mt-4">
        <div class="d-flex flex-row align-items-center flex-wrap">
            <div class="me-2"><h3>To Do List</h3></div>
            <div class="text-dark">Catat semua hal yang kamu kerjakan disini.</div>
        </div>
        <hr>
        <form action="/create" method="post">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="isi" class="form-control" placeholder="Kegiatan" required>
                </div>
                <div class="col-md-3">
                    <input type="date" name="tgl_awal" class="form-control" placeholder="Tanggal Awal" required>
                </div>
                <div class="col-md-3">
                    <input type="date" name="tgl_akhir" class="form-control" placeholder="Tanggal Awal" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
        <hr>
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>            
        @endif
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Kegiatan</th>
                <th scope="col">Awal</th>
                <th scope="col">Akhir</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($todos as $todo)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$todo->isi}}</td>
                        <td>{{date('d F, Y',strtotime($todo->tgl_awal))}}</td>
                        <td>{{date('d F, Y',strtotime($todo->tgl_akhir))}}</td>
                        <td><a href="/update-status/{{$todo->id}}/{{$todo->status == 'Belum' ? 'Sudah' : 'Belum'}}" class="text-decoration-none badge rounded-pill text-bg-{{$todo->status == 'Belum' ? 'warning' : 'success'}}">{{$todo->status}}</a></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#editModal">Ubah</button>
                            <a href="/delete/{{$todo->id}}" class="btn btn-sm btn-danger">Hapus</a>
                        </td>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editModalLabel">Ubah Kegiatan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/update" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$todo->id}}">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="isi" class="form-label">Kegiatan</label>
                                            <input type="text" name="isi" class="form-control" id="isi" value="{{$todo->isi}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tgl_awal" class="form-label">Tanggal Awal</label>
                                            <input type="date" name="tgl_awal" class="form-control" id="tgl_awal" value="{{date('Y-m-d',strtotime($todo->tgl_awal))}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tgl_awal" class="form-label">Tanggal Akhir</label>
                                            <input type="date" name="tgl_akhir" class="form-control" id="tgl_akhir" value="{{date('Y-m-d',strtotime($todo->tgl_akhir))}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status">
                                                <option value="Belum" @if($todo->status == 'Belum') selected @endif>Belum</option>
                                                <option value="Sudah" @if($todo->status == 'Sudah') selected @endif>Sudah</option>
                                            </select>                                            
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                    </div>                                
                                </form>
                            </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
            </tbody>
          </table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>