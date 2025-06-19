<!-- Modal -->

<div class="modal fade bd-example-modal-xl" id="modalPDFRender" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
            background-repeat: no-repeat;
            color: white;
            font-family: 'Mallanna';
            font-size: 17px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="mediumBody">


                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
            
                            <span id="card_title">
                                
                            </span>
            
                             <div class="float-right">                                    
                                {{ __('Generar Cuenta') }}
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
            
                    <div class="card-body">
                        <div class="row">
                            <select class="form-control" id="formatos" onchange="traerPDF({{$id}})">
                                
                                <option value="">Selectione un formato</option>
                                @foreach($queryFormatos as $queryFormato)
                                    <option value="{{ $queryFormato->Id }}">{{ $queryFormato->Nombre }}</option>                            
                                @endforeach
                            </select>
                        </div>
                        <p></p>
                        <div class="row">
                            <div id="render" style="height: 700px" ></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer"  >
                
            </div>
        </div>
    </div>
</div>