@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-navy text-white">
                    <h4 class="mb-0"><i class="bi bi-person-circle"></i> Profil Saya</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/users/' . Auth::user()->photo) }}" 
                                 class="rounded-circle" width="150" height="150" alt="Profile">
                        @else
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 150px; height: 150px;">
                                <i class="bi bi-person-fill text-white" style="font-size: 5rem;"></i>
                            </div>
                        @endif
                    </div>
                    
                    <table class="table">
                        <tr>
                            <th width="200">Nama</th>
                            <td>{{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ Auth::user()->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ Auth::user()->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>
                                <span class="badge bg-{{ Auth::user()->role == 'admin' ? 'danger' : (Auth::user()->role == 'seller' ? 'success' : 'info') }}">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection