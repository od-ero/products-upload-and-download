<!-- ttt -->
@extends('layouts.my_app')
@section('subtitle')
  view batches
@endsection

@section('contentheader_title')
    view batches
@endsection

@section('content')
<div class="container-fluid px-4">
<div class="container">
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      Are You Sure you want to delete this product batch? 
      <form id="deleteForm" action="/rooms/destroy" method="POST">
                    @csrf
                    <input type="hidden" name="unit_id" id="unitIdInput">
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteForm').submit()">Delete</button>

      </div>
    </div>
  </div>
</div>
                    
                        
                        <!-- <div class="card mb-4">
                            <div class="card-body">
                                <form action="{{ route('product.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="file">Choose Excel File</label>
                                        <input type="file" name="file" id="file" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Import</button>
                            </form>
                                .
                            </div>
                        </div> -->
                        <div class="card mb-4">
                           
                            <div class="card-body">
                            <iframe src="data:application/pdf;base64,{{ $pdfContent }}" width="100%" height="600px"></iframe>
                                
                            </div>
                    </div>
        <div class="row">
        <div class="mb-4 col-auto">
                 <a href="/create/fpdf/download/{{$encoded_product_batch_id}}" class="btn btn-outline-success btn-sm" tabindex="-1" role="button">back</a>        
            </div>
            <div class="mb-4 col-auto">
                 <a href="/send/mail/{{$encoded_product_batch_id}}" class="btn btn-outline-secondary btn-sm" tabindex="-1" role="button">Email PDF</a>        
            </div>
        </div>
           
</div>
<script>
                function setUnitId(unitId) {
                    document.getElementById('unitIdInput').value = unitId;
                }
            </script>
                    @endsection