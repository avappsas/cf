<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . ($user->foto ?? 'fotoPerfil/perfilDefault.png')) }}" alt="Foto de perfil" id="fotoPerfil" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        <label for="fotoPerfilInput" class="position-absolute bottom-0 end-0 bg-light border rounded-circle p-1" style="cursor: pointer;">
                            <i class="fas fa-camera text-secondary"></i>
                        </label>
                    </div>
                    {!! Form::file('fotoPerfil', [
                        'id'       => 'fotoPerfilInput',
                        'class'    => 'd-none',
                        'accept'   => 'image/png,image/jpeg,image/gif',
                        'onchange' => 'preview_2(this)'
                    ]) !!}
                    @error('fotoPerfil')
                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                    @enderror
                    <div class="mt-3">
                        <p class="text-muted mb-1">Tamaño recomendado: 150x150</p>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-secondary">
                            @foreach($perfiles as $perfil)
                                <span class="badge bg-primary me-1" style="font-size: 1.2em; color: white; font-weight: bold;">{{ $perfil->PERFIL }}</span>
                            @endforeach
                            @if($perfiles->isEmpty())
                                <span class="text-muted" style="font-size: 1.2em; color: white; font-weight: bold;">Sin perfiles asignados</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Cedula</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {!! Form::text('usuario', $user->usuario ?? '', [
                            'class' => 'form-control' . ($errors->has('usuario') ? ' is-invalid' : ''),
                            'id'    => 'usuario'
                        ]) !!}
                        @error('usuario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Nombres</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {!! Form::text('name', $user->name, [
                            'class' => 'form-control'.($errors->has('name')?' is-invalid':''),
                            'id'    => 'name'
                        ]) !!}
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {!! Form::email('email', $user->email, [
                            'class' => 'form-control'.($errors->has('email')?' is-invalid':''),
                            'id'    => 'email'
                        ]) !!}
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Contraseña</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {!! Form::password('password', [
                            'class'       => 'form-control'.($errors->has('password')?' is-invalid':''),
                            'id'          => 'password',
                            'placeholder' => 'Dejar en blanco para no cambiar'
                        ]) !!}
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <hr>
            </div>
        </div>
        {!! Form::hidden('activacion', $user->activacion) !!}
        {!! Form::hidden('id_dp', $user->id_dp) !!}
        {!! Form::hidden('pro', $user->pro) !!}
        {!! Form::hidden('id_buzon', $user->id_buzon) !!}

    </div>
 
</div>



<script>
    function preview_2(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('fotoPerfil').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>