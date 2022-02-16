@section('title', 'Danh sách bình luận sản phẩm')
@extends('layouts.admin.main')
@section('content')
<!-- @php
    use Illuminate\Support\Facades\Auth;
@endphp
@dump(Auth::user()) -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card card-white my-0">
                <div class="card-header">
                    <ol class="breadcrumb float-sm-left ">
                        <li class="breadcrumb-item card-title">Danh sách bình luận sản phẩm</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid pb-1">
            <div class="card">
                <div class="card-body">
                    <form action="" method="get">
                        <div class="row">
                            <div class="col">
                            <label for="">Sắp xếp theo danh mục</label>
                                <select class="form-control" name="category_id" >
                                    <option value="">Tất cả sản phẩm</option>
                                    <option @if(isset($searchData['category_id']) &&  $searchData['category_id'] == 1) selected @endif value="1">Thú cưng</option>
                                    <option @if(isset($searchData['category_id']) &&  $searchData['category_id'] == 2) selected @endif value="2">Phụ kiện</option>
                                </select>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Sắp xếp theo đánh giá</label>
                                    <select class="form-control" name="review_rating" >
                                        <option value="">Mặc định</option>
                                        <option @if(isset($searchData['review_rating']) &&  $searchData['review_rating'] == 5) selected @endif value="5">5 Sao</option>
                                        <option @if(isset($searchData['review_rating']) &&  $searchData['review_rating'] == 4) selected @endif value="4">4 Sao</option>
                                        <option @if(isset($searchData['review_rating']) &&  $searchData['review_rating'] == 3) selected @endif value="3">3 Sao</option>
                                        <option @if(isset($searchData['review_rating']) &&  $searchData['review_rating'] == 2) selected @endif value="2">2 Sao</option>
                                        <option @if(isset($searchData['review_rating']) &&  $searchData['review_rating'] == 1) selected @endif value="1">1 Sao</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6 text-right">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info mt-2">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                                <th>STT</th>
                                <th>Sản phẩm</th>
                                <th>Tài khoản</th>
                                <th>Đánh giá</th>
                                <th>Nội dung</th>
                                <th>Thời gian</th>
                                <th class="text-right">Trạng thái</th>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                <tr>
                                    <td>{{(($reviews->currentPage()-1)*5) + $loop->iteration}}</td>
                                    <td>
                                        @if($review->product_type == 1)
                                            <a href="{{route('product.detail', ['id' => $review->product->id])}}">
                                                <img src="{{asset( 'storage/' . $review->product->image)}}" width="70" />
                                            </a>
                                        @else
                                            <a href="{{route('accessory.detail', ['id' => $review->accessory->id])}}">
                                                <img src="{{asset( 'storage/' . $review->accessory->image)}}" width="70" />
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach($users as $user)
                                            @if($user->id == $review->user_id)
                                                {{$user->name}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @for($count=1; $count<=5; $count++)
                                            @if($count <= $review->rating)
                                                <i class="fas fa-star rating text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </td>
                                    <td>{{$review->comment}}</td>
                                    <td>{{$review->created_at->diffForHumans()}}</td>
                                    <td class="text-right">
                                        @if($review->status == 1)
                                        <a href="{{route('update.status.review', ['id' => $review->id])}}" onclick="return confirm('Bạn có muốn tắt hiển thị Bình luận này này?')" class="btn @if($review->status == 1) btn-info @else btn-danger @endif">
                                            <i class="{{ $review->status == 1 ? 'fas fa-eye text-light' : 'fas fa-eye-slash text-light'  }}"></i>
                                        </a>
                                        @else
                                        <a href="{{route('update.status.review', ['id' => $review->id])}}" onclick="return confirm('Bạn có muốn khôi phục hiển thị Bình luận này này?')" class="btn @if($review->status == 1) btn-info @else btn-danger @endif">
                                            <i class="{{ $review->status == 1 ? 'fas fa-eye text-light' : 'fas fa-eye-slash text-light'  }}"></i>
                                        </a>
                                        @endif
                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{$reviews->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection