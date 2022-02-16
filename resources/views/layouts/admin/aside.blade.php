<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('client.home')}}" class="brand-link">
        <img src="{{ asset('client-theme/images/logo.png')}}" alt="LoliPetVN Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-success"><b>Lolipetvn</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(Auth::check())
                    <img src="{{(strpos(Auth::user()->avatar, 'uploads/') === false ? Auth::user()->avatar:asset('storage/' . Auth::user()->avatar))}}" class="img-rounded elevation-2" alt="User Image" width="70" />
                @else
                    <img src="{{ asset('admin-theme/dist/img/user2-160x160.jpg')}}" class="img-rounded elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                @if(Auth::check())
                    <a href="{{route('user.profile', ['id' => Auth::user()->id])}}" class="d-block">
                        {{Auth::user()->name}}
                    </a>
                    <span class="text-info">{{ Auth::user()->roles->pluck('name')[0] ?? '' }}</span>
                @else
                    <a href="">Chua dang nhap</a>
                @endif
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('dashboard.index')}}" class="nav-link border border-secondary rounded">
                        <i class="fa fa-home"></i>
                        <p>
                            Trang chủ
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-chart-pie"></i>
                        <p>
                            Thống kê
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="right fas fa-angle-left"></i>
                                <p>Bình luận</p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('statistical.commentSum')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tổng bình luận</p>
                                    </a>
                                </li>
                                @foreach($cateType as $cate)
                                <li class="nav-item">
                                    <a href="{{route('statistical.cmtPet',['slug' => $cate->slug])}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Thống kê {{$cate->name}}</p>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('statistical.orderSum')}}" class="nav-link">
                                <i class="right fas fa-angle-left"></i>
                                <p>Đơn hàng</p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('statistical.orderSum')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tổng đơn hàng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('statistical.orderCancel')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tổng đơn hàng bị hủy</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('statistical.compare')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>So sánh thể loại</p>
                                    </a>
                                </li>
                                @foreach($cateType as $cate)
                                <li class="nav-item">
                                    <a href="{{route('statistical.compareCate',['slug' => $cate->slug])}}"
                                        class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>So sánh {{$cate->name}}</p>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('statistical.revenueSum')}}" class="nav-link">
                                <i class="right fas fa-angle-left"></i>
                                <p>Doanh thu</p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('statistical.revenueSum')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tổng doanh thu</p>
                                    </a>
                                </li>
                                @foreach($cateType as $cate)
                                <li class="nav-item">
                                    <a href="{{route('statistical.revenue',['slug' => $cate->slug])}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Doanh thu {{$cate->name}}</p>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        <p>
                            Đơn hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('order.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tất cả đơn hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">Tài khoản & Phân quyền</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        <p>
                            Quản lý tài khoản
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('user.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách tài khoản</p>
                            </a>
                        </li>
                        @hasanyrole('Admin|Manage')
                        <li class="nav-item">
                            <a href="{{route('user.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tạo tài khoản</p>
                            </a>
                        </li>
                        @endhasanyrole
                        <li class="nav-item">
                            <a href="{{route('user.backup')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tài khoản đã xóa</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @hasanyrole('Admin')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-project-diagram"></i>
                        <p>
                            Phân quyền
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('role.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách phân quyền</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasanyrole
                <li class="nav-header">Danh mục & Sản phẩm</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-paw"></i>
                        <p>
                            Quản lý sản phẩm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('product.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thú cưng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('accessory.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Phụ kiện</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('list.review.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Đánh giá sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('product.backup')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sản phẩm đã xóa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('accessory.backup')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Phụ kiện đã xóa</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cat"></i>
                        <p>
                            Quản lý danh mục
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('category.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('breed.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Giống loài
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('breed.index')}}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Danh sách</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('breed.backup')}}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Giống loài đã xóa</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('category.backup')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh mục đã xóa</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">Khuyến mãi</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-percent"></i>
                        <p>
                            Giảm giá
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('coupon.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('coupon.backup')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Giảm giá bị xóa</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--<li class="nav-item">-->
                <!--    <a href="#" class="nav-link">-->
                <!--        <i class="fas fa-percent"></i>-->
                <!--        <p>-->
                <!--            Loại phiếu giảm giá-->
                <!--            <i class="right fas fa-angle-left"></i>-->
                <!--        </p>-->
                <!--    </a>-->
                <!--    <ul class="nav nav-treeview">-->
                <!--        <li class="nav-item">-->
                <!--            <a href="{{route('couponType.index')}}" class="nav-link">-->
                <!--                <i class="far fa-circle nav-icon"></i>-->
                <!--                <p>Danh sách</p>-->
                <!--            </a>-->
                <!--        </li>-->
                <!--        <li class="nav-item">-->
                <!--            <a href="{{route('couponType.backup')}}" class="nav-link">-->
                <!--                <i class="far fa-circle nav-icon"></i>-->
                <!--                <p>phiếu giảm giá bị xóa</p>-->
                <!--            </a>-->
                <!--        </li>-->
                <!--    </ul>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a href="#" class="nav-link">-->
                <!--        <i class="fas fa-swatchbook"></i>-->
                <!--        <p>-->
                <!--            Loại giảm giá-->
                <!--            <i class="right fas fa-angle-left"></i>-->
                <!--        </p>-->
                <!--    </a>-->
                <!--    <ul class="nav nav-treeview">-->
                <!--        <li class="nav-item">-->
                <!--            <a href="{{route('discountType.index')}}" class="nav-link">-->
                <!--                <i class="far fa-circle nav-icon"></i>-->
                <!--                <p>Danh sách</p>-->
                <!--            </a>-->
                <!--        </li>-->
                <!--        <li class="nav-item">-->
                <!--            <a href="{{route('discountType.backup')}}" class="nav-link">-->
                <!--                <i class="far fa-circle nav-icon"></i>-->
                <!--                <p>Loại giảm giá bị xóa</p>-->
                <!--            </a>-->
                <!--        </li>-->
                <!--    </ul>-->
                <!--</li>-->
                <li class="nav-header">Quản lý chung</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-newspaper"></i>
                        <p>
                            Bài viết
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('blog.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                        @hasanyrole('Admin|Manage')
                        <li class="nav-item">
                            <a href="{{route('blog.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm bài viết</p>
                            </a>
                        </li>
                        @endhasanyrole
                        <li class="nav-item">
                            <a href="{{route('blogCategory.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh mục bài viết</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('blogCategory.backup')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thùng rác danh mục</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('blog.backup')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Bài viết bị xóa</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('slide.index')}}" class="nav-link">
                        <i class="fas fa-table"></i>
                        <p>Slide</p>
                    </a>
                </li>
                @hasanyrole('Admin')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cogs"></i>
                            <p>
                                Hệ thống
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('general.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Thông tin chung</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-transgender-alt"></i>
                            <p>
                                Giới tính
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('gender.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Danh sách</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('gender.add')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Thêm giới tính</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('gender.backup')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Giới tính bị xóa</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-seedling"></i>
                            <p>
                                Tuổi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('age.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Danh sách</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('age.backup')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tuổi bị xóa</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endhasanyrole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>