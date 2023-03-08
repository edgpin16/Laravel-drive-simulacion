@extends('layouts.app')

<!DOCTYPE html>
    <html>
        <head>
            <title>Simulador de drive</title>
        </head>
        <body>
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading mt-5 text-center">
                        <h2>Simulador de drive</h2>
                    </div>
                    <div class="panel-body mt-5">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-2" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('fileUpload.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="inputFiles">Selecciona un archivo:</label>
                                <input 
                                    type="file" 
                                    name="files" 
                                    id="inputFiles"
                                    class="form-control @error('files') is-invalid @enderror">
                
                                @error('files')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success">Subir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </body>
    </html>