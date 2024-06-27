<!-- ttt -->
@extends('layouts.my_app')
@section('subtitle')
  Dashboard
@endsection

@section('contentheader_title')
    Dashboard
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
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="exampleModalLabel">Upload Your Products Sheet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      <div class="row justify-content-center">
                
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-body">
                            <form method="POST" id="uploadForm" action="{{ route('product.import') }}" enctype="multipart/form-data">
                            @csrf
                           
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputbatche_name" name="batche_name" type="text" placeholder="Enter the batch name"  required autocomplete="batche_name"  />
                                            <label for="inputbatche_name">Batch Name</label>
                                            @if ($errors->has('batche_name'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('batche_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3" >
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputBatche_number" type="text" placeholder="Enter the batch number"  name="batche_number" required autocomplete="batche_number" />
                                            <label for="inputBatche_number">Batch Number</label>
                                            @if ($errors->has('batche_number'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('batche_number') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-floating mb-3 mt-3">
                                    <input class="form-control" type="file" name="file" id="file" placeholder="Enter your name" required autofocus autocomplete="file" accept=".csv, .xls, .xlsx"/>
                                    <label for="inputEmail">Upload products excel file.</label>
                                    @if ($errors->has('file'))
                                        <div class="text-danger mt-2">
                                            {{ $errors->first('file') }}
                                        </div>
                                   @endif
                                </div>
                                </div>
                                
                            </form>
                        </div>
                       
                    </div>
                
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="document.getElementById('uploadForm').submit()">Upload</button>

      </div>
    </div>
  </div>
</div>                   
<div class="row align-items-center">
    <div class="col">
        <h2 class="mt-4 text-white">Product Batches</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/welcome">Dashboard</a></li>
            <li class="breadcrumb-item active">Product Batches</li>
        </ol>
    </div>
    <div class="col-auto ms-auto">
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload a new batch</button>
    </div>
</div>

<!--                         
                        <div class="card mb-4">
                            <div class="card-body">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload a new batch</button>
                                
                            </div>
                        </div> -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-house-medical me-1"></i>
                                Product Batches
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Batch Name</th>
                                            <th>Batch Number</th>
                                            <th>Upload Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Batch Name</th>
                                            <th>Upload Date</th>
                                            <th>Test ee</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                     @foreach ($product_batches as $product_batch)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$product_batch['batche_name']}}</td>
                                            <td>{{$product_batch['batche_number']}}</td>
                                            <td>{{$product_batch['created_at']}}</td>
                                           
                                            <td class="float-end">  
                                                <div class="btn-group">
                                                    <a href="/batches/products/view/{{base64_encode($product_batch['id'])}}" class="btn btn-outline-success btn-sm" tabindex="-1" role="button">View</a>
                                                    <button type="button" class="btn  btn-sm btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="visually-hidden">Toggle Dropright</span> 
                                                    </button>
                                                    <ul class="dropdown-menu"><div class="m-2 text-center">
                                            
                                                       <li class="mb-2"><a href="/batches/products/view/{{base64_encode($product_batch['id'])}}" class="btn btn-outline-success  btn-sm" role="button">Update</a></li>
                                                       <li>
                                                        <button type="button" class="btn btn-outline-danger  btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="setUnitId('{{ $product_batch->id}}')">Delete</button>

                                                        </li>
                                               
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                   
           
            
           
</div>
<script>
                function setUnitId(unitId) {
                    document.getElementById('unitIdInput').value = unitId;
                }
            </script>
                    @endsection