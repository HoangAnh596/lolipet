<div class="info_customer">
    <div class="avatar">
        <img src="{{(strpos(Auth::user()->avatar, 'uploads/') === false ? Auth::user()->avatar:asset('storage/' . Auth::user()->avatar))}}"
            id="blah" alt="User profile picture">
    </div>
    <div class="info">
        <h5>{{Auth::user()->name}}</h5>
        <p>
            @if(count(Auth::user()->roles)>0)
                @foreach(Auth::user()->roles as $role)
                <span class="badge badge-success">{{$role->name}}</span>
                @endforeach
            @else
                <span class="badge badge-info">Khách hàng</span>
            @endif
        </p>
    </div>
    <div class="nav_bar">
        <ul>
            <li>
                <a href="{{route('client.customer.info')}}" id="link_info">
                    <i class="fas fa-user"></i>
                    Thông tin tài khoản
                </a>
            </li>
            <li>
                <a href="{{route('client.customer.orderHistory')}}" id="link_order">
                    <i class="fas fa-swatchbook"></i>
                    Lịch sử đặt hàng
                </a>
            </li>
            <li>
                <a href="{{route('client.customer.review')}}" id="link_review">
                    <i class="fas fa-star-half-alt"></i>
                    Lịch sử nhận xét
                </a>
            </li>
        </ul>
    </div>
</div>