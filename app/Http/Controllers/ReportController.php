<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use App\Models\Customer;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\SalesOrderDetail;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderDetail;

class ReportController extends Controller
{
    public function index(){
        $items = Item::orderBy('created_at','desc')->get();
        $data = [];
        foreach($items as $item){
            $latestPurchase = PurchaseOrderDetail::where('item_id',$item->id)->latest()->first();
            if($latestPurchase != null){
              $latest_unit_price = $latestPurchase->total - $latestPurchase->quantity;
              $latest_total_price = $latest_unit_price * $item->quantity;
              $reorderflag = ( $item->quantity > $item->reorder ) ? 'Ok' : 'Reorder';
                $data [] = [
                    'reorder_flag' => $reorderflag,
                    'product_code' => $item->product_code,
                    'product_name' => $item->item_name,
                    'product_image' => $item->image,
                    'cost_per_item' => $latest_unit_price,
                    'stock_qauntity' => $item->quantity,
                    'inventory_value' => $latest_total_price,
                    'reorder_level' => $item->reorder,
                ];
            }
        }
        return view('pages.reports.general_report')->with('data',$data);
    }

    public function stockReport( ){

        $data= Item::all();

        return view('pages.reports.stock_report',compact('data'));
    }

   public function dailySalesReport(){

     $pr_code = [];
     $data = [];
     $salers = [];
     $salesPerson = '';
     $sales = SalesOrder::Where('created_at','<=', Carbon::now())
                         ->Where('created_at','>', Carbon::now()->subDay())
                        // ->Where('created_at','<=', Carbon::now('+3')->subDay()->toDateTimeString())
                        ->get();
                    // $bl = Carbon::now()->toDateTimeString() > Carbon::now()->todateString() ? 'True' : 'False';
    // return $sales;
    foreach($sales as $sale){
        $salers []= $sale->sales_person;
            $detail = SalesOrderDetail::where('sales_order_id', $sale->id)->get();
            foreach($detail as $det){
            $pr_code []= $det->item_name;
                $item = Item::select('id','item_name','product_code','image')->where('id',$det->item_id)->first();
                $data [] = [
                 'product_code' => $item->product_code,
                 'product_name' => $item->item_name,
                 'product_image' => $item->image,
                 'amount' => $det->amount,
                 'qyt' => $det->quantity,
                 'tax_rate' =>  $det->tax,
                 'tax' =>  $det->total - $det->amount,
                 'total' => $det->total,
               ];
            }
        }

        $final_data = [];
        $g_amount = 0;
        $g_tax = 0;
        $g_total = 0;
        foreach(array_unique($pr_code) as $newlist){
            $price = 0;
            $quantity = 0;
            $total = 0;
            $tax = 0;
            $tax_rate = 0;
            $length = 0;
            foreach($data as $dt){
               if($dt['product_code'] == $newlist){
                $code = $dt['product_code'];
                $pr_name = $dt['product_name'];
                $pr_image = $dt['product_image'];
                $price = $price + $dt['amount'];
                $quantity = $quantity + $dt['qyt'];
                $total = $total + $dt['total'];
                $tax  = $tax + $dt['tax'];
                $tax_rate  = $tax_rate  + $dt['tax_rate'];
                ++$length;
               }
            }
            if($length != 0 && $quantity !=0){
                $final_data [] = [
                    'pr_code' => $code,
                    'pr_name' => $pr_name,
                    'pr_image' => $pr_image,
                    'quantity' => $quantity,
                    'avg_unit_price' =>  ($price / $quantity) / $length,
                    'amount' => $price,
                    'avg_tax_rate' =>  $tax_rate / $length,
                    'tax' =>  $tax,
                    'tatal' => $total,
                    'length' => $length,
                ];
            }
            $g_amount = $g_amount + $price;
            $g_tax = $g_tax + $tax;
            $g_total = $g_total + $total;

        }

        // dd($final_data);
      return view('pages.reports.daily_sales_report')
      ->with('g_amount',$g_amount)
      ->with('g_tax',$g_tax)
      ->with('g_total',$g_total)
      ->with('data',$final_data)
      ->with('salesPerson',$salesPerson)
      ->with('salers',array_unique($salers));
   }


   public function dailySalesReportByDate(Request $request){

     $pr_code = [];
     $data = [];
     $salers = [];
     $salesPerson = $request->sales_person;

     $from = Carbon::parse($request->report_date)->subDay()->toDateString();
     $to = Carbon::parse($request->report_date)->addDay()->toDateString();


     $sales = $salesPerson != null ?
     SalesOrder::Where('sales_person', $salesPerson)->Where('created_at','>', $from)->Where('created_at','<', $to)->get()
                        :
                        SalesOrder::Where('created_at','>', $from)->Where('created_at','<', $to)->get();
    foreach($sales as $sale){
        $salers []= $sale->sales_person;
            $detail = SalesOrderDetail::where('sales_order_id', $sale->id)->get();
            foreach($detail as $det){
            $pr_code []= $det->item_name;
                $item = Item::select('id','item_name','product_code')->where('id',$det->item_id)->first();
                $data [] = [
                 'product_code' => $item->product_code,
                 'product_name' => $item->item_name,
                 'product_image' => $item->image,
                 'amount' => $det->amount,
                 'qyt' => $det->quantity,
                 'tax_rate' =>  $det->tax,
                 'tax' =>  $det->total - $det->amount,
                 'total' => $det->total,
               ];
            }
        }

        $final_data = [];
        $g_amount = 0;
        $g_tax = 0;
        $g_total = 0;
        foreach(array_unique($pr_code) as $newlist){
            $price = 0;
            $quantity = 0;
            $total = 0;
            $tax = 0;
            $tax_rate = 0;
            $length = 0;
            foreach($data as $dt){
               if($dt['product_code'] == $newlist){
                $code = $dt['product_code'];
                $pr_name = $dt['product_name'];
                $pr_image = $dt['product_image'];
                $price = $price + $dt['amount'];
                $quantity = $quantity + $dt['qyt'];
                $total = $total + $dt['total'];
                $tax  = $tax + $dt['tax'];
                $tax_rate  = $tax_rate  + $dt['tax_rate'];
                ++$length;
               }
            }
            if($length != 0 && $quantity !=0){
                $final_data [] = [
                    'pr_code' => $code,
                    'pr_name' => $pr_name,
                    'pr_image'=>$pr_image,
                    'quantity' => $quantity,
                    'avg_unit_price' =>  ($price / $quantity) / $length,
                    'amount' => $price,
                    'avg_tax_rate' =>  $tax_rate / $length,
                    'tax' =>  $tax,
                    'tatal' => $total,
                    'length' => $length,
                ];
            }
            $g_amount = $g_amount + $total;
            $g_tax = $g_tax + $tax;
            $g_total = $g_total + $total;

        }

        // dd($final_data);
      return view('pages.reports.daily_sales_report')
      ->with('g_amount',$g_amount)
      ->with('g_tax',$g_tax)
      ->with('g_total',$g_total)
      ->with('data',$final_data)
      ->with('salesPerson',$salesPerson)
      ->with('salers',array_unique($salers));

   }


   //custmer performancee
   public function customerPerformance(){
   //setdefault from and to dates.
    $from = Carbon::now()->subMonth();
   $to = Carbon::now();

   //get all sales registred on between from and to date.
   $sales = SalesOrder::Where('created_at','>', $from)->Where('created_at','<=', $to)->get();

   $data = [];
   $customer = [];
   $g_total = 0;
   foreach($sales as $sale){
    $customer [] = $sale->customer_id;
        $detail = SalesOrderDetail::where('sales_order_id', $sale->id)->get();
        foreach($detail as $det){
            $data [] = [
             'cust_id' => $sale->customer_id,
             'qyt' => $det->quantity,
             'total' => $det->total,
           ];
           $g_total = $g_total + $det->quantity;
        }
    }

    // return $customer;
    $performance_final_summery = [];
    foreach(array_unique($customer) as $cust){
      $cst = Customer::find($cust);
      if($cst != null){
        $quantity = 0;
        $total = 0;
        $length = 0;
        foreach($data as $dt){
           if($dt['cust_id'] == $cust){
                $name = $cst->name;
                $phone = $cst->phone;
                $quantity = $quantity + $dt['qyt'];
                $total = $total + $dt['total'];
                ++$length;
            }
           }
        $performance_final_summery [] = [
            'customer_name' => $name,
            'phone' => $phone,
            'qyt' => $quantity,
            'total' => $total,
            'length' => $length,
        ];
      }

    }
    $tot = array_column($performance_final_summery, 'total');
    array_multisort($tot, SORT_DESC, $performance_final_summery);
    // dd($performance_final_summery);
     return view('pages.reports.customer_perfoormance')
                 ->with('to',$to)
                 ->with('from',$from)
                 ->with('g_total',$g_total)
                 ->with('performance_final_summery',$performance_final_summery);
   }

   public function customerPerformanceByDate(Request $request){
        //setdefault from and to dates.
    $from =$request->from;
    $to = $request->to;

    //get all sales registred on between from and to date.
    $sales = SalesOrder::Where('created_at','>', $from)->Where('created_at','<=', $to)->get();

    $data = [];
    $g_total = 0;
    $customer = [];
    foreach($sales as $sale){
     $customer []= $sale->customer_id;
         $detail = SalesOrderDetail::where('sales_order_id', $sale->id)->get();
         foreach($detail as $det){
             $data [] = [
              'cust_id' => $sale->customer_id,
              'qyt' => $det->quantity,
              'total' => $det->total,
            ];
            $g_total = $g_total + $det->quantity;
         }
     }
     $performance_final_summery = [];
    //  if($customer == []){
        foreach(array_unique($customer) as $cust){
            $cst = Customer::find($cust);
            if($cst != null){
              $quantity = 0;
              $total = 0;
              $length = 0;
              foreach($data as $dt){
                 if($dt['cust_id'] == $cust){
                      $name = $cst->name;
                      $phone = $cst->phone;
                      $quantity = $quantity + $dt['qyt'];
                      $total = $total + $dt['total'];
                      ++$length;
                  }
                 }
              $performance_final_summery [] = [
                  'customer_name' => $name,
                  'phone' => $phone,
                  'qyt' => $quantity,
                  'total' => $total,
                  'length' => $length,
              ];
            }

          }
    //  }else{
    //     return back()->with('error', 'There is no sales information between '.$request->from.' and '.$request->to);
    //  }
    if($performance_final_summery != null){
        $tot = array_column($performance_final_summery, 'total');
        array_multisort($tot, SORT_DESC, $performance_final_summery);
    }
      return view('pages.reports.customer_perfoormance')
                  ->with('to',$to)
                  ->with('from',$from)
                  ->with('g_total',$g_total)
                  ->with('performance_final_summery',$performance_final_summery);
   }


   public function dailyCustomerReport(){
    $startOfDay  = Carbon::now()->startOfDay();
    $endOfDay  = Carbon::now()->endOfDay();

    $salesDetail = SalesOrder::whereBetween('created_at',[$startOfDay,$endOfDay])
    ->with('salesDetails.item:id,item_name')
    ->with('customer:id,name')
    ->get();
    // return $salesTotal;

    $sales =  collect($salesDetail)->groupBy('customer_id');
    $dialyTotal= $salesDetail->sum('grand_total');
   return view('pages.reports.daily_customer_report')
   ->with('sales', $sales)
   ->with('date', Carbon::now()->toDateString())
   ->with('dialyTotal',$dialyTotal);
   }


   public function dailyCustomerReportByDate(Request $request){
    $request->validate(['report_date'=>'required']);
    $startOfDay  =  Carbon::parse($request->report_date)->startOfDay();
    $endOfDay  = Carbon::parse($request->report_date)->endOfDay();

    $salesDetail = SalesOrder::whereBetween('created_at',[$startOfDay,$endOfDay])
    ->with('salesDetails.item:id,item_name')
    ->with('customer:id,name')
    ->get();
    // return $salesTotal;
    $sales =  collect($salesDetail)->groupBy('customer_id');
    $dialyTotal= $salesDetail->sum('grand_total');
    return view('pages.reports.daily_customer_report')
    ->with('sales', $sales)
    ->with('date', Carbon::now()->toDateString())
    ->with('dialyTotal',$dialyTotal);

   }
}
