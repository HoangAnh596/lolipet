<footer class="footer-wrapper">
    <div class="footer-container">
        <div class="footer-top">
            <div class="footer-item">
                <h3>Liên lạc</h3>
                <div class="info">
                    <ul>
                        <li>
                            @if(!empty($generalSetting->address))
                            <i class="fas fa-map-marker-alt"></i>
                            <span><strong>Địa chỉ:</strong> {{$generalSetting->address}}</span>
                            @else
                            <i class="fas fa-map-marker-alt"></i>
                            <span><strong>Địa chỉ:</strong></span>
                            @endif
                        </li>
                        <li>
                            @if(!empty($generalSetting->phone))
                            <i class="fas fa-phone-alt"></i>
                            <span><strong>Điện thoại:</strong> {{$generalSetting->phone}}</span>
                            @else
                            <i class="fas fa-phone-alt"></i>
                            <span><strong>Điện thoại:</strong></span>
                            @endif
                        </li>
                        <li>
                            @if(!empty($generalSetting->email))
                            <i class="fas fa-at"></i>
                            <span><strong>Email:</strong> <a href="mailto:{{$generalSetting->email}}">{{$generalSetting->email}}</a></span>
                            @else
                            <i class="fas fa-at"></i>
                            <span><strong>Email:</strong> <a href="javascript:;"></a></span>
                            @endif
                        </li>
                        <li>
                            @if(!empty($generalSetting->open_time))
                            <i class="fas fa-clock"></i>
                            <span><strong>Thời gian mở cửa:</strong> {{$generalSetting->open_time}}</span>
                            @else
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
            <!-- <div class="footer-item">
                <h3>Hướng dẫn</h3>
                <div class="menu-link">
                    <ul>
                        <li><a href="#"><i class="fas fa-arrow-right"></i>Hướng đẫn mua hàng</a></li>
                        <li><a href="#"><i class="fas fa-arrow-right"></i>Hướng dẫn lấy lại mật khẩu</a></li>
                        <li><a href="#"><i class="fas fa-arrow-right"></i>Hướng dẫn xem đơn hàng</a></li>
                        <li><a href="#"><i class="fas fa-arrow-right"></i>Hướng dẫn chung</a></li>
                    </ul>
                </div>
            </div> -->
            <!-- <div class="footer-item">
                <h3>Links</h3>
                <div class="menu-link">
                    <ul>
                        <li><a href="#"><i class="fas fa-arrow-right"></i>danh mục</a></li>
                        <li><a href="#"><i class="fas fa-arrow-right"></i>sản phẩm</a></li>
                        <li><a href="#"><i class="fas fa-arrow-right"></i>giới thiệu</a></li>
                        <li><a href="#"><i class="fas fa-arrow-right"></i>liên hệ</a></li>
                    </ul>
                </div>
            </div> -->
            <div class="footer-item">
                <h3>Theo dõi chúng tôi</h3>
                <div class="socials">
                    <ul>
                        <li>
                            <a href="{{$generalSetting->facebook}}" class="fab fa-facebook-f" id="fb"></a>
                        </li>
                        <li>
                            <a href="{{$generalSetting->twitter}}" class="fab fa-twitter" id="twit"></a>
                        </li>
                        <li>
                            <a href="{{$generalSetting->instagram}}" class="fab fa-instagram" id="insta"></a>
                        </li>
                        <li>
                            <a href="{{$generalSetting->youtube}}" class="fab fa-youtube" id="yto"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- <div class="footer-middle">
            <div class="footer-item-top">
                <div class="content">
                    <p>Bạn đang gặp vấn đề về việc lựa chọn thú cưng?</p>
                    <span>Để nhận thông tin tư vấn miễn phí về các loại thú cưng phù hợp với mình. Bạn hãy để lại cho chúng tôi thông tin liên lạc.</span>
                </div>
                <div class="thumbnail">
                    <img src="{{ asset('client-theme/images/introduce.png')}}" alt="">
                </div>
            </div>
            <div class="footer-item">
                <h3>Đăng Ký Tư Vấn Mua Hàng Miễn Phí</h3>
                <form action="">
                    <div class="group-form">
                        <input type="text" placeholder="Họ tên*" name="name">
                        <input type="text" placeholder="Số điện thoại*" name="sdt">
                    </div>
                    <input type="email" placeholder="Email*" class="email">
                    <textarea name="note" id="" cols="30" rows="4" placeholder="Nội dung*"></textarea>
                    <button type="submit" class="btn-blue">Đăng ký ngay</button>
                </form>
            </div>
        </div> -->
        <div class="footer-bottom">
            <div class="credit"> created by <span> hungtmph10583 </span> | all rights reserved </div>
        </div>
    </div>
</footer>