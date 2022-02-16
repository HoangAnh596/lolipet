<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Review;
use App\Models\Statistical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class StatisticalController extends Controller
{
    public function commentSum(Request $request)
    {
        $year = Review::select(DB::raw('Year(created_at) as year'))
            ->groupBy(DB::raw("Year(created_at)"))
            ->pluck('year');

        $reviewData = Review::get();
        $month = Review::select(DB::raw('Month(updated_at) as month'));
        $review = Review::select(DB::raw('COUNT(*) as count'));
        if ($request->time && $request->time > 0) {
            $review = $review->whereYear('updated_at', $request->time)
                ->groupBy(DB::raw("Month(updated_at)"))
                ->pluck('count');
            $month = $month->whereYear('updated_at', $request->time)
                ->groupBy(DB::raw("Month(updated_at)"))
                ->pluck('month');

            $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            foreach ($month as $index => $mon) {
                if (!empty($review)) {
                    if (empty($review[$index])) {
                        $review[$index] = 0;
                    }
                    $data[$mon - 1] = $review[$index];
                }
            }
            return response()->json(['data' => $data, 'year' => $month, 'time' => $request->time]);
        }

        $review = $review->whereYear('updated_at', date('Y'))
            ->groupBy(DB::raw("Month(updated_at)"))
            ->pluck('count');

        $month = $month->whereYear('updated_at', date('Y'))
            ->groupBy(DB::raw("Month(updated_at)"))
            ->pluck('month');

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($month as $index => $mon) {
            if (!empty($review)) {
                if (empty($review[$index])) {
                    $review[$index] = 0;
                }
                $data[$mon - 1] = $review[$index];
            }
        }

        return view('admin.statistical.commentSum', compact('data', 'reviewData', 'year'));
    }

    public function commentPet($slug, Request $request)
    {
        $categoryType = CategoryType::where('slug', $slug)->first();

        if ($categoryType->id == 1) {
            $product = Product::get();
        } else {
            $product = Accessory::get();
        }
        $count = [];
        $data = [];
        foreach ($product as $index => $pro) {
            array_push($data, $pro->name);
        }
        if ($request->time) {
            foreach ($product as $pro) {
                $prod = $pro->reviews()->where('updated_at', 'like', '%' . $request->time . '%')->where('product_type', $categoryType->id)->count();
                array_push($count, $prod);
            }
            return response()->json(['data' => $count]);
        }
        foreach ($product as $pro) {
            $prod = $pro->reviews()->where('product_type', $categoryType->id)->count();
            array_push($count, $prod);
        }

        return view('admin.statistical.comment', compact('data', 'count', 'slug'));
    }

    public function orderSum(Request $request)
    {
        $year = Order::select(DB::raw('Year(created_at) as year'))
            ->groupBy(DB::raw("Year(created_at)"))
            ->pluck('year');

        $month = Order::select(DB::raw('Month(created_at) as month'));
        $order = Order::select(DB::raw('COUNT(*) as count'));
        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        if ($request->time) {
            $order = $order->whereYear('created_at', $request->time)
                ->groupBy(DB::raw("Month(created_at)"))
                ->pluck('count');
            $month = $month->whereYear('created_at', $request->time)
                ->groupBy(DB::raw("Month(created_at)"))
                ->pluck('month');

            foreach ($month as $index => $mon) {
                if (!empty($order)) {
                    if (empty($order[$index])) {
                        $order[$index] = 0;
                    }
                    $data[$mon - 1] = $order[$index];
                }
            }
            return response()->json(['data' => $data, 'year' => $month]);
        }

        $order = $order->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');

        $month = $month->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('month');

        foreach ($month as $index => $mon) {
            if (!empty($order)) {
                if (empty($order[$index])) {
                    $order[$index] = 0;
                }
                $data[$mon - 1] = $order[$index];
            }
        }

        return view('admin.statistical.orderSum', compact('data', 'year'));
    }

    public function orderCancel(Request $request)
    {
        $year = Order::select(DB::raw('Year(updated_at) as year'))
            ->groupBy(DB::raw("Year(updated_at)"))
            ->pluck('year');

        $orderData = Order::get();
        $month = Order::select(DB::raw('Month(updated_at) as month'));
        $order = Order::select(DB::raw('COUNT(*) as count'));
        if ($request->time) {
            $order = $order->whereYear('updated_at', $request->time)
                ->groupBy(DB::raw("Month(updated_at)"))
                ->pluck('count');
            $month = $month->whereYear('updated_at', $request->time)
                ->groupBy(DB::raw("Month(updated_at)"))
                ->pluck('month');

            $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            foreach ($month as $index => $mon) {
                if (!empty($order)) {
                    if (empty($order[$index])) {
                        $order[$index] = 0;
                    }
                    $data[$mon - 1] = $order[$index];
                }
            }
            return response()->json(['data' => $data, 'year' => $month]);
        }

        $order = $order
            ->where(function ($query) {
                $query->where('delivery_status', 0)
                    ->orWhere('delivery_status', 4);
            })
            ->whereYear('updated_at', date('Y'))
            ->groupBy(DB::raw("Month(updated_at)"))
            ->pluck('count');

        $month = $month->whereYear('updated_at', date('Y'))
            ->groupBy(DB::raw("Month(updated_at)"))
            ->pluck('month');

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($month as $index => $mon) {
            if (!empty($order)) {
                if (empty($order[$index])) {
                    $order[$index] = 0;
                }
                $data[$mon - 1] = $order[$index];
            }
        }
        return view('admin.statistical.orderCancel', compact('data', 'orderData', 'year'));
    }

    public function compare(Request $request)
    {
        $categoryType = CategoryType::get();
        $data = [];
        $labels = [];

        if ($request->time) {
            foreach ($categoryType as $index => $value) {
                $pro = OrderDetail::select(DB::raw('COUNT(*) as count'))
                    ->where('product_type', $value->id)
                    ->where('created_at', 'like', '%' . $request->time . '%')
                    ->pluck('count');
                array_push($data, $pro[0]);
                array_push($labels, $value->name);
            }
            return response()->json(['data' => $data, 'labels' => $labels]);
        }
        foreach ($categoryType as $index => $value) {

            $pro = OrderDetail::select(DB::raw('COUNT(*) as count'))
                ->where('product_type', $value->id)
                ->pluck('count');
            array_push($data, $pro[0]);
            array_push($labels, $value->name);
        }
        return view('admin.statistical.compare', compact('data', 'labels'));
    }

    public function compareCate($slug, Request $request)
    {
        $categoryType = CategoryType::where('slug', $slug)->first();
        $data = [];
        $labels = [];

        if ($categoryType->id == 1) {
            $petName = Product::select('products.name as name', 'products.id as id', 'category_types.id as idType')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->join('category_types', 'category_types.id', '=', 'categories.category_type_id')
                ->where('categories.category_type_id', $categoryType->id)->get();
        } else {
            $petName = Accessory::select('accessories.name as name', 'accessories.id as id', 'category_types.id as idType')
                ->join('categories', 'categories.id', '=', 'accessories.category_id')
                ->join('category_types', 'category_types.id', '=', 'categories.category_type_id')
                ->where('categories.category_type_id', $categoryType->id)->get();
        }

        if ($request->time) {
            foreach ($petName as $name) {
                $petPro = OrderDetail::select(DB::raw('COUNT(*) as count'))
                    ->where('product_type', $name->idType)
                    ->where('created_at', 'like', '%' . $request->time . '%')
                    ->where('product_id', $name->id)
                    ->pluck('count');
                foreach ($petPro as $count) {
                    array_push($data, $count);
                }

                array_push($labels, $name->name);
            }

            return response()->json(['data' => $data, 'labels' => $labels]);
        }

        foreach ($petName as $name) {
            $petPro = OrderDetail::select(DB::raw('COUNT(*) as count'))
                ->where('product_type', $name->idType)
                ->where('product_id', $name->id)
                ->pluck('count');
            foreach ($petPro as $count) {
                array_push($data, $count);
            }

            array_push($labels, $name->name);
        }

        return view('admin.statistical.compareCate', compact('data', 'labels', 'slug'));
    }

    public function revenueSum(Request $request)
    {
        $year = Order::select(DB::raw('Year(updated_at) as year'))
            ->groupBy(DB::raw("Year(updated_at)"))
            ->pluck('year');

        $orderData = Order::get();
        $month = Order::select(DB::raw('Month(updated_at) as month'));
        $order = Order::select(DB::raw('sum(grand_total) as sum'));
        if ($request->time) {
            $order = $order
                ->where('payment_status', 2)
                ->where(function ($status) {
                    $status->where('delivery_status', 2)
                        ->orWhere('delivery_status', 3);
                })
                ->whereYear('updated_at', $request->time)
                ->groupBy(DB::raw("Month(updated_at)"))
                ->pluck('sum');
            $month = $month->whereYear('updated_at', $request->time)
                ->groupBy(DB::raw("Month(updated_at)"))
                ->pluck('month');

            $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            foreach ($month as $index => $mon) {
                if (!empty($order)) {
                    if (empty($order[$index])) {
                        $order[$index] = 0;
                    }
                    $data[$mon - 1] = $order[$index];
                }
            }
            return response()->json(['data' => $data, 'year' => $month]);
        }

        $order = $order
            ->where('payment_status', 2)
            ->where(function ($status) {
                $status->where('delivery_status', 2)
                    ->orWhere('delivery_status', 3);
            })
            ->whereYear('updated_at', date('Y'))
            ->groupBy(DB::raw("Month(updated_at)"))
            ->pluck('sum');

        $month = $month->whereYear('updated_at', date('Y'))
            ->groupBy(DB::raw("Month(updated_at)"))
            ->pluck('month');


        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($month as $index => $mon) {
            if (!empty($order)) {
                if (empty($order[$index])) {
                    $order[$index] = 0;
                }
                $data[$mon - 1] = $order[$index];
            }
        }

        return view('admin.statistical.revenueSum', compact('data', 'orderData', 'year'));
    }

    public function revenue($slug, Request $request)
    {
        $categoryType = CategoryType::where('slug', $slug)->first();
        $data = [];
        $labels = [];

        $d = [];
        $count = OrderDetail::select(DB::raw('count(order_details.order_id) as count,order_id'))
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->where('orders.payment_status', 2)
            ->where(function ($query) {
                $query->where('orders.delivery_status', 2)
                    ->orWhere('orders.delivery_status', 3);
            })
            ->groupBy('order_id')
            ->get();
        foreach ($count as $r) {
            if ($r->count > 1) {
                array_push($d, array($r->order_id, $r->count));
            }
        }

        if ($categoryType->id == 1) {
            $petName = Product::select('products.name as name', 'products.id as id', 'category_types.id as idType')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->join('category_types', 'category_types.id', '=', 'categories.category_type_id')
                ->where('categories.category_type_id', $categoryType->id)->get();
        } else {
            $petName = Accessory::select('accessories.name as name', 'accessories.id as id', 'category_types.id as idType')
                ->join('categories', 'categories.id', '=', 'accessories.category_id')
                ->join('category_types', 'category_types.id', '=', 'categories.category_type_id')
                ->where('categories.category_type_id', $categoryType->id)->get();
        }
        if ($request->time) {
            foreach ($petName as $name) {
                $petSum = OrderDetail::select(DB::raw('sum(price) as sum,sum(tax) as sumTax,price', 'order_id'))
                    ->join('orders', 'orders.id', '=', 'order_details.order_id')
                    ->where('orders.payment_status', 2)
                    ->where(function ($query) {
                        $query->where('orders.delivery_status', 2)
                            ->orWhere('orders.delivery_status', 3);
                    })
                    ->where('order_details.product_type', $name->idType)
                    ->where('order_details.product_id', $name->id)
                    ->where('order_details.updated_at', 'like', '%' . $request->time . '%')
                    ->get();
                foreach ($petSum as $sum) {
                    foreach ($d as $index => $a) {
                         if (isset($a[$index])) {
                            if ($a[$index] == $sum->order_id) {
                                if ($a[$index] > 1) {
                                    $sum->sum = ($sum->price + (($sum->price * 10) / 100));
                                }
                            } else {
                                $sum->sum = ($sum->sum + $sum->sumTax);
                            }
                         }
                    }
                    array_push($data, $sum->sum);
                }

                array_push($labels, $name->name);
            }

            return response()->json(['data' => $data, 'labels' => $labels]);
        }

        foreach ($petName as $name) {

            $petSum = OrderDetail::select(DB::raw('sum(price) as sum,sum(tax) as sumTax,price,order_id'))
                ->join('orders', 'orders.id', '=', 'order_details.order_id')
                ->where('orders.payment_status', 2)
                ->where(function ($query) {
                    $query->where('orders.delivery_status', 2)
                        ->orWhere('orders.delivery_status', 3);
                })
                ->where('order_details.product_type', $name->idType)
                ->where('order_details.product_id', $name->id)
                ->get();

            foreach ($petSum as $sum) {
                foreach ($d as $index => $a) {
                     if (isset($a[$index])) {
                        if ($a[$index] == $sum->order_id) {
                            if ($a[$index] > 1) {
                                $sum->sum = ($sum->price + (($sum->price * 10) / 100));
                            }
                        } else {
                            $sum->sum = ($sum->sum + $sum->sumTax);
                        }
                     }
                }
                array_push($data, $sum->sum);
            }

            array_push($labels, $name->name);
        }
        return view('admin.statistical.revenue', compact('data', 'labels', 'slug'));
    }
}