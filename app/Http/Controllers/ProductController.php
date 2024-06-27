<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ProductRequest;
use App\Imports\ProductsImport;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductBatch;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use PDF;
use setasign\Fpdi\Fpdi;
use Carbon\Carbon;

class ProductController extends Controller
{
    
    public function import(ProductRequest $request) 
    {
        DB::beginTransaction();
        try{
           
            $batch_data = $request->all();
            $product_batch=ProductBatch::create([
            'batche_name'=> $batch_data['batche_name'],
            'batche_number'=> $batch_data['batche_number'],
            ]);
            
            Excel::import(new ProductsImport($product_batch['id']), $request->file('file'));
            DB::commit();
            return response()->json(['data'=>'Products imported successfully.',201]);
        }catch(\Exception $ex){
            DB::rollBack();
            Log::info($ex);
            return response()->json(['data'=>'Some error has occur.'.$ex ,400]);

        }
        
    }

    public function index(){
     $product_batches = ProductBatch::all();
     return view('products.dashboard', ['product_batches' => $product_batches]);

    }

    public function view_batch($encoded_product_batch_id){
        $product_batch_id  = base64_decode($encoded_product_batch_id);
        //dd($product_batch_id);
        $products = Product::select('*')
                                    ->where('product_batch_id',$product_batch_id )
                                    -> get();
        return view('products.view_batch', ['products'=> $products,
                                            'encoded_product_batch_id'=>$encoded_product_batch_id]);
   
       }

     /**
    * @return \Illuminate\Support\Collection
    */
//     public function export() 
//     {
//         return Excel::download(new ProductsExport, 'Products.xlsx');
//     }
//


    private $fpdf;
 
    public function __construct()
    {
         
    }
 
    public function createPDF($product_batch_id)
    {
        $product_batch_id=base64_decode($product_batch_id);
        $products = Product::where('product_batch_id',$product_batch_id)
                            ->select('*')
                            ->get();
        $pdf = new Fpdi();

        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(0, 10, 'Products Data', 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Times', 'B', 12);

        
        $cellHeight = 10; 
        $multiCellHeight = 10; 

        $yPos = $pdf->GetY();
        $xPos = $pdf->GetX();
        $pdf->Cell(10, $cellHeight, '#', 1, 0, 'C', 0);
        $pdf->Cell(40, $cellHeight, 'Product Name', 1, 0, 'C', 0);
        $pdf->Cell(60, $cellHeight, 'Description', 1, 0, 'C', 0);
        $pdf->Cell(20, $cellHeight, 'Quantity', 1, 0, 'C', 0);
        $pdf->SetXY($xPos + 130, $yPos);
        $pdf->MultiCell(30, $multiCellHeight / 2, "Price per\nquantity", 1, 'C');
        $pdf->SetXY($xPos + 160, $yPos);
        $pdf->Cell(30, $cellHeight, 'Sub total', 1, 0, 'C', 0);

        $pdf->Ln($cellHeight); 
      
        $counter = 1;
        $total = 0;
        $product_name_cell_width = 40;
        $descriptioncell_width = 60;
        $lineHeight = 10; 


        $pdf->SetFont('Times', '', 12);
        foreach ($products as $product) {
            $product_name_length = max(1, ceil($pdf->GetStringWidth($product['product_name']) / $product_name_cell_width));
            $description_length = max(1, ceil($pdf->GetStringWidth($product['description']) / $descriptioncell_width));
            if($product_name_length > $description_length){
                $adjustedCellHeight = $product_name_length * $lineHeight;
                $product_name_cell_heigth = $lineHeight;
                $descriptioncell_heigth = ( $product_name_length/$description_length)*$lineHeight;
            }else{
                $adjustedCellHeight = $description_length * $lineHeight; 
                $product_name_cell_heigth = ($description_length/$product_name_length)*$lineHeight;
                $descriptioncell_heigth = $lineHeight;
            }
            $xPos = $pdf->GetX();
            $yPos = $pdf->GetY();
            
            $pdf->Cell(10, $adjustedCellHeight, $counter, 1, 0, 'C');
            
            $pdf->MultiCell(40, $product_name_cell_heigth, $product['product_name'], 1);
            
            $pdf->SetXY($xPos + 50, $yPos); 
        
           
            $pdf->MultiCell(60, $descriptioncell_heigth, $product['description'], 1);
        
           
            $pdf->SetXY($xPos + 110, $yPos); 

            $pdf->Cell(20, $adjustedCellHeight, $product['quantity'], 1, 0, 'C');
        
           
            $pdf->Cell(30, $adjustedCellHeight, number_format($product['price_quantity'], 2), 1, 0, 'R');
        
           
            $pdf->Cell(30, $adjustedCellHeight, number_format($product['quantity'] * $product['price_quantity'], 2), 1, 0, 'R');
        
           
            $pdf->Ln($adjustedCellHeight);
        
            $counter++;
            $total += $product['quantity'] * $product['price_quantity'];
        }
        

        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(130, 15, '', 0);
        $pdf->Cell(30, 15, 'Total (Kshs)', 1);
        $pdf->Cell(30, 15, number_format($total, 2), 1, 0, 'R');
        $pdf->Ln();
        
        $pdf->Ln(10);

       
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, 'Official Stamp And Signature', 0, 1, 'L');

       
        $stampPath = public_path('images/stamp.png');
        $pdf->Image($stampPath, 10, $pdf->GetY(), 50); 

       
        $signaturePath = public_path('images/signature.png'); 
        $pdf->Image($signaturePath, 15, $pdf->GetY()+5, 40);

        
        $pdf->SetY($pdf->GetY() + 30); 
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0, 10, 'Date: ' . Carbon::now()->toFormattedDateString(), 0, 1, 'L');

       
        return response($pdf->Output('S', 'products.pdf'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . Carbon::now()->format('YmdHi') . 'products.pdf"');
    }
 }