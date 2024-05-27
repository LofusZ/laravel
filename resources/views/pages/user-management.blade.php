@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Utilisateurs'])
    <div class="row mt-4 mx-4">
        <div class="col-12">

            @if (\Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                <span class="alert-icon"><i class="fa fa-check"></i></span>
                {!! \Session::get('success') !!}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (\Session::has('danger'))
            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                <span class="alert-icon"><i class="fa fa-times"></i></span>
                {!! \Session::get('danger') !!}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif


            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                    <span class="alert-icon"><i class="fa fa-times"></i></span>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
    
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="col-10">Utilisateurs ({{ count($users) }})</h6>
                    <btn class="col-2 btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalCreateUser">Ajouter un utilisateur</btn>

                    <div class="modal fade" id="modalCreateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                          <div class="modal-content">
                            <div class="modal-body p-0">
                              <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Créer un utilisateur</h3>
                                    <p class="mb-0">Entrez des identifiants et un mot de passe pour ajouter un nouvel utilisateur</p>
                                </div>
                                <div class="card-body pb-3">
                                  <form role="form text-left" method="POST" action="{{ route("users.add") }}">
                                    @csrf <!-- {{ csrf_field() }} -->
                                    <label>Pseudo</label>
                                    <div class="input-group mb-3">
                                      <input type="text" class="form-control" placeholder="Pseudo" aria-label="Pseudo" aria-describedby="name-addon" name="username" required>
                                    </div>
                                    <label>Email</label>
                                    <div class="input-group mb-3">
                                      <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="name-addon" name="email" required>
                                    </div>
                                    <label>Prénom</label>
                                    <div class="input-group mb-3">
                                      <input type="text" class="form-control" placeholder="Prénom" aria-label="Prénom" aria-describedby="name-addon" name="firstname" required>
                                    </div>
                                    <label>Nom</label>
                                    <div class="input-group mb-3">
                                      <input type="text" class="form-control" placeholder="Nom" aria-label="Nom" aria-describedby="name-addon" name="lastname" required>
                                    </div>
                                    <label>Mot de passe</label>
                                    <div class="input-group mb-3">
                                      <input type="password" class="form-control" placeholder="Mot de passe" aria-label="Mot de passe" aria-describedby="name-addon" name="password" required>
                                    </div>
                                    <div class="text-center">
                                      <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Créer</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pseudo</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Rejoint le</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img src="https://gravatar.com/avatar/" class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm"><b>{{$user->firstname}} {{$user->lastname}}</b> ({{$user->username}})</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0"><span class="badge bg-gradient-warning">{{ $user->getRoleNames()[0] }}</span></p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{$user->created_at}}</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <div class="row">
                                                <div class="col">
                                                     @if(Auth::user()->can('edit users') || Auth::user()->can('admin'))
                                                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{$user->id}}" href="#!edit_{{$user->id}}" >Modifier</a>
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    @if(Auth::user()->id != $user->id)
                                                        @if(Auth::user()->can('delete users') || Auth::user()->can('admin'))
                                                        <a class="text-danger" href="#!delete_{{$user->id}}" data-bs-toggle="modal" data-bs-target="#modelDelete{{$user->id}}"><i class="fa fa-trash"></i></a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>


                                
                            @if(Auth::user()->id != $user->id)
                                @if(Auth::user()->can('delete users') || Auth::user()->can('admin'))
                                <div class="modal fade" id="modelDelete{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="modelDelete{{$user->id}}" aria-hidden="true">
        
                                    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h6 class="modal-title" id="modal-title-notification">Suppression d'un utilisateur</h6>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="py-3 text-center">
                                            <i class="fa fa-exclamation-triangle fa-4x text-danger"></i>
                                            <h4 class="text-gradient text-danger mt-4">Attention</h4>
                                            <p>Cette action est irréversible. Soyez sûr de votre choix !</p>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                            <form id="del{{$user->id}}" method="POST" action="{{ route("users.delete", ["id"=>$user->id] ) }}">@csrf <!-- {{ csrf_field() }} --></form>
                                          <a type="button" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('del{{$user->id}}').submit();">Ok, supprimer</a>
                                          <button type="button" class="btn btn-link text-dark ml-auto" data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                      </div>
                                    </div>
                                </div>                                @endif
                            @endif
                                
                                @if(Auth::user()->can('edit users') || Auth::user()->can('admin'))
                                <div class="modal fade" id="modalEdit{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="modalEdit{{$user->id}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                      <div class="modal-content">
                                        <div class="modal-body p-0">
                                          <div class="card card-plain">
                                            <div class="card-header pb-0 text-left">
                                                <h3 class="font-weight-bolder text-primary text-gradient">Modifier un utilisateur</h3>
                                                <p class="mb-0">Modifiez les informations d'un utilisateur.</p>
                                            </div>
                                            <div class="card-body pb-3">
                                              <form role="form text-left" method="POST" action="{{ route("users.edit") }}">
                                                @csrf <!-- {{ csrf_field() }} -->
                                                <input type="hidden" name="id" value="{{$user->id}}" required>
                                                <label>Pseudo</label>
                                                <div class="input-group mb-3">
                                                  <input type="text" class="form-control" placeholder="Pseudo" aria-label="Pseudo" aria-describedby="name-addon" name="username" value="{{$user->username}}" required>
                                                </div>
                                                <label>Email</label>
                                                <div class="input-group mb-3">
                                                  <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="name-addon" name="email" value="{{$user->email}}" required>
                                                </div>
                                                <label>Prénom</label>
                                                <div class="input-group mb-3">
                                                  <input type="text" class="form-control" placeholder="Prénom" aria-label="Prénom" aria-describedby="name-addon" name="firstname" value="{{$user->firstname}}" required>
                                                </div>
                                                <label>Nom</label>
                                                <div class="input-group mb-3">
                                                  <input type="text" class="form-control" placeholder="Nom" aria-label="Nom" aria-describedby="name-addon" name="lastname" value="{{$user->lastname}}" required>
                                                </div>
                                                <label>Mot de passe</label>
                                                <div class="input-group mb-3">
                                                  <input type="password" class="form-control" placeholder="Mot de passe" aria-label="Mot de passe" aria-describedby="name-addon" name="password">
                                                </div>
                                                <div class="text-center">
                                                  <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Modifier</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>                                


                                  

                                @endif
                            @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')

    </div>
@endsection
