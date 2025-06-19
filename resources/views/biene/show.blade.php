 

@section('template_title')
    {{ $biene->name ?? 'Show Biene' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Biene</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('bienes.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Bien:</strong>
                            {{ $biene->id_bien }}
                        </div>
                        <div class="form-group">
                            <strong>Id Caso:</strong>
                            {{ $biene->id_Caso }}
                        </div>
                        <div class="form-group">
                            <strong>Bien Asegurado:</strong>
                            {{ $biene->Bien_Asegurado }}
                        </div>
                        <div class="form-group">
                            <strong>Objeto:</strong>
                            {{ $biene->Objeto }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo:</strong>
                            {{ $biene->Tipo }}
                        </div>
                        <div class="form-group">
                            <strong>Caracteristicas:</strong>
                            {{ $biene->Caracteristicas }}
                        </div>
                        <div class="form-group">
                            <strong>Fotos:</strong>
                            {{ $biene->Fotos }}
                        </div>
                        <div class="form-group">
                            <strong>Detalles:</strong>
                            {{ $biene->Detalles }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
