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
                    
                        <h2 class="mt-4 text-white">Product Batches</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="/welcome">Dashboard</a></li>
                            <li class="breadcrumb-item active">Product Batches</li>
                        </ol>
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
                            <div class="card-header">
                                <i class="fas fa-house-medical me-1"></i>
                                Product Batches
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Price Per Item</th>
                                            <th>Sub total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Price Per Item</th>
                                            <th>Sub total</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody> 
                                        {{$total_price= 0}}
                                     @foreach ($products as $product)
                                    {{$total_price += $product['quantity'] * $product['price_quantity'];}}
                                      
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$product['product_name']}}</td>
                                            <td>{{$product['description']}}</td>
                                            <td>{{$product['quantity']}}</td>
                                            <td style="text-align: right;"> {{ number_format($product['price_quantity'], 2)}}</td>
                                            <td style="text-align: right;"> {{ number_format((float)$product['quantity'] * (float)$product['price_quantity'], 2) }}</td>
                                            <td class="float-end">  
                                                <div class="btn-group">
                                                    <a href="/products/view/{{base64_encode($product['id'])}}" class="btn btn-outline-success btn-sm" tabindex="-1" role="button">View</a>
                                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split  btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="visually-hidden">Toggle Dropright</span> 
                                                    </button>
                                                    <ul class="dropdown-menu"><div class="m-2 text-center">
                                            
                                                       <li class="mb-2"><a href="/products/view/{{base64_encode($product['id'])}}" class="btn btn-outline-success  btn-sm" role="button">Update</a></li>
                                                       <li>
                                                        <button type="button" class="btn btn-outline-danger  btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="setUnitId('{{ $product->id}}')">Delete</button>

                                                        </li>
                                               
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                       
                                        @endforeach   
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                             <td><b>Total ( KSH):</b></td>
                                            <td style="text-align: right;"> <b>{{number_format($total_price, 2)}} </b></td>
                                            <td></td>
                                         </tr>     
                                    </tbody>
                                </table>
                            </div>
                    </div>
        <div class="row">
        <div class="mb-4 col-auto">
                 <a href="/create/fpdf/download/{{$encoded_product_batch_id}}" class="btn btn-outline-success btn-sm" tabindex="-1" role="button">Preview As PDF</a>        
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