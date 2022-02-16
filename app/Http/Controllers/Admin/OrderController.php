<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Accessory;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Datatables;
use App\Mail\SendMailUpdateStatusOrder;
use App\Models\GeneralSetting;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.order.index');
    }

    public function getData(Request $request)
    {
        $order = Order::select('orders.*');
        return dataTables::of($order)
            ->addIndexColumn()
            ->orderColumn('created_at', function ($row, $order) {
                return $row->orderBy('created_at', $order);
            })
            ->orderColumn('delivery_status', function ($row, $order) {
                return $row->orderBy('delivery_status', $order);
            })
            ->addColumn('delivery_status',function($row){
                if($row->delivery_status == 0){
                    $row->delivery_status = "<a class='btn btn-dark'>Hủy đơn hàng</a>";
                }elseif($row->delivery_status == 1){
                    $row->delivery_status = "<a class='btn btn-warning'>Đang chờ xử lý</a>";
                }elseif($row->delivery_status == 2){
                    $row->delivery_status = "<a class='btn btn-info'>Đang giao hàng</a>";
                }elseif($row->delivery_status == 3){
                    $row->delivery_status = "<a class='btn btn-success'>Giao hàng thành công</a>";
                }elseif($row->delivery_status == 4){
                     $row->delivery_status = "<a class='btn btn-danger'>Đơn hàng bị hủy</a>";
                }
                return $row->delivery_status;
            })
            ->addColumn('created_at',function($row){
                return $row->created_at->format('d/m/Y');
            })
            ->addColumn('payment_status',function($row){
                if($row->payment_status == 1){
                    $row->payment_status = "<i class='far fa-times-circle text-danger'></i>";
                }elseif($row->payment_status == 2){
                    $row->payment_status = "<i class='far fa-check-circle text-success'></i>";
                }

                return $row->payment_status;
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a href="' . route('order.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    <a  class="btn btn-success" href="' . route('order.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('delivery_status') == '0' || $request->get('delivery_status') == '1' || $request->get('delivery_status') == '2' || $request->get('delivery_status') == '3') {
                    $instance->where('delivery_status', $request->get('delivery_status'));
                }

                if ($request->get('payment_status') == '1' || $request->get('payment_status') == '2') {
                    $instance->where('payment_status', $request->get('payment_status'));
                }
  
                if ($request->get('created_at') && $request->get('updated_at')) {
                    
                    $instance->whereBetween('created_at', [date($request->get('created_at')), date($request->get('updated_at'))]);
                }
                
                
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action','payment_status','delivery_status'])
            ->make(true);
    }

    public function editForm($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->back();
        }
        $orderDetail = OrderDetail::where('order_id', $id)->get();
        $tam_tinh = 0;
        foreach ($orderDetail as $value) {
            $tam_tinh += $value->price;
        }
        return view('admin.order.edit-form', compact('order', 'orderDetail', 'tam_tinh'));
    }

    public function saveEdit($id, Request $request)
    {
        $order = Order::find($id);

        $check_delivery_order = $order->delivery_status;
        $delivery_post_request = $request->delivery_status;

        if (!$order) {
            return redirect()->back()->with('danger', "Không tìm thấy đơn hàng này!");
        }
        // if ($order->delivery_status == 4) {
        //     return redirect(route('order.index'))->with('danger', "Không thể cập nhật đơn hàng này do Khách hàng đã hủy đơn!");
        // }

        if ($delivery_post_request == 3) {
            if ($check_delivery_order == 2) {
                $order->fill($request->all());
                $order->seller_id = Auth::user()->id;
            } elseif ($check_delivery_order == 3) {
                $order->fill($request->all());
                $order->seller_id = Auth::user()->id;
            } else {
                return redirect()->back()->with('danger', "Yêu cầu chuyển trạng thái đơn hàng sang `Đang giao hàng` Trước khi cập nhật trạng thái thành `Giao hàng thành công`. Cập nhật thất bại!");
            }
        } else {
            $order->fill($request->all());
            $order->seller_id = Auth::user()->id;
        }

        $order_detail = OrderDetail::where('order_id', $id)->get();

        $order_detail = OrderDetail::where('order_id', $id)->get();
        
        foreach ($order_detail as $key => $value) {
            // Tạo vòng lặp cập nhật lại trạng thái chuyển hàng và thanh toán dạng text cho OrderDetail
            $orderDetail = OrderDetail::find($value->id);
            if ($order->payment_status == 1) {
                $orderDetail->payment_status = "Chưa thanh toán";
            } elseif ($order->payment_status == 2) {
                $orderDetail->payment_status = "Đã thanh toán";
            } else {
                $orderDetail->payment_status = "Lỗi code";
            }
            if ($order->delivery_status == 1) {
                $orderDetail->delivery_status = "Đang chờ xử lý";
            } elseif ($order->delivery_status == 2) {
                $orderDetail->delivery_status = "Đang giao hàng";
            } elseif ($order->delivery_status == 3) {
                $orderDetail->delivery_status = "Giao hàng thành công";
            } elseif ($order->delivery_status == 0) {
                $orderDetail->delivery_status = "Hủy đơn hàng";
            } else {
                $orderDetail->delivery_status = "Lỗi code";
            }
            $orderDetail->save();
            if ($check_delivery_order == 0 && $delivery_post_request == 2) {
                if ($value->product_type == 1) {
                    $product = Product::find($value->product_id);
                } else {
                    $product = Accessory::find($value->product_id);
                }
                if ($product->quantity < $value->quantity || $product->quantity <= 0) {
                    return redirect()->back()->with('danger', "Số lượng của sản phẩm `" . $product->name .  "` hiện tại còn `" . $product->quantity . "` sản phẩm. Không đủ số lượng sản phẩm để nhận đơn hàng này!");
                }
                $tru = $product->quantity - $value->quantity;
                $product->quantity = $tru;
                $product->save();
            }

            if ($delivery_post_request == 0 && $check_delivery_order != 0) {
                if ($value->product_type == 1) {
                    $product = Product::find($value->product_id);
                } else {
                    $product = Accessory::find($value->product_id);
                }
                $cong = $product->quantity + $value->quantity;
                $product->quantity = $cong;
                $product->save();
            }
        }
        $order->save();

        // Gửi mail cập nhật trạng thái đơn hàng
        if ($request->has('send_mail')) {
            $OrderDetail = OrderDetail::where('order_id', $id)->get();
            $product = Product::all();
            $generalSetting = GeneralSetting::first('logo');
            $accessory = Accessory::all();
            // dd($generalSetting);
            $tax = 0;
            $total = 0;
            foreach ($OrderDetail as $key => $value) {
                $total += $value->price;
            }
            $name_client = $order->name;
            $number_phone = $order->phone;
            $to_email = $order->email;
            $order_code = $order->code;
            $date_time_order = $order->created_at->format('d/m/Y');
            $shipping_address = $order->shipping_address;
            $number_quantity_product_order = count($OrderDetail);
            $total = number_format($total, 0, ',', '.');
            $tax = number_format($tax, 0, ',', '.');
            $grand_total = number_format($order->grand_total, 0, ',', '.');

            // dd($name_client, $to_email, $order_code, $date_time_order, $shipping_address, $number_quantity_product_order, $grand_total);
            if ($order->delivery_status == 1) {
                $delivery_status = 'Đã tiếp nhận đơn hàng. Đang chờ xử lý!';
            } elseif ($order->delivery_status == 2) {
                $delivery_status = 'Đơn hàng của bạn đã được gửi';
            } elseif ($order->delivery_status == 3) {
                $delivery_status = 'Hoàn thành đơn hàng!';
            } else {
                $delivery_status = 'Đơn hàng của bạn đã bị hủy!';
            }

            $mailData = [
                'name_client' => $name_client,
                'number_phone' => $number_phone,
                'to_email' => $to_email,
                'order_code' => $order_code,
                'date_time_order' => $date_time_order,
                'number_quantity_product_order' => $number_quantity_product_order,
                'shipping_address' => $shipping_address,
                'grand_total' => $grand_total,
                'orderDetail' => $OrderDetail,
                'product' => $product,
                'accessory' => $accessory,
                'tax' => $tax,
                'total' => $total,
                'generalSetting' => $generalSetting,
                'delivery_status' => $delivery_status
            ];
            $toMail = $to_email;
            Mail::to($toMail)->send(new SendMailUpdateStatusOrder($mailData));
        }
        return redirect(route('order.index'))->with('success', "Cập nhật đơn hàng " . $order->code . " thành công");
    }

    public function detail($id, Request $request)
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->back();
        }
        $orderDetail = OrderDetail::where('order_id', $id)->get();
        return view('admin.order.detail', compact('order', 'orderDetail'));
    }
}