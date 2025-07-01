<footer class="bg-gray-800 text-white pt-10 pb-6">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <div>
                <a href="#" class="text-3xl font-['Pacifico'] text-white mb-4 block">logo</a
                >
                <p class="text-gray-400 mb-4">
                    Cập nhật tin tức mới nhất, nhanh nhất và chính xác nhất về mọi
                    lĩnh vực trong nước và quốc tế.
                </p>
                <div class="flex space-x-4">
                    <a
                        href="#"
                        class="w-8 h-8 flex items-center justify-center bg-gray-700 rounded-full hover:bg-primary"
                    >
                        <i class="ri-facebook-fill"></i>
                    </a>
                    <a
                        href="#"
                        class="w-8 h-8 flex items-center justify-center bg-gray-700 rounded-full hover:bg-primary"
                    >
                        <i class="ri-twitter-fill"></i>
                    </a>
                    <a
                        href="#"
                        class="w-8 h-8 flex items-center justify-center bg-gray-700 rounded-full hover:bg-primary"
                    >
                        <i class="ri-youtube-fill"></i>
                    </a>
                    <a
                        href="#"
                        class="w-8 h-8 flex items-center justify-center bg-gray-700 rounded-full hover:bg-primary"
                    >
                        <i class="ri-instagram-fill"></i>
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 text-center">
                    <h4 class="text-lg font-bold mb-1 text-left ml-20">Chuyên mục</h4>
                </div>
                @foreach($categories->chunk(ceil($categories->count() / 2)) as $chunk)
                    <div>
                        <ul class="space-y-2">
                            @foreach($chunk as $cate)
                                <li>
                                    <a href="category/{{ $cate->slug }}" class="text-gray-400 hover:text-white">{{ $cate->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Thông tin</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white"
                        >Giới thiệu</a
                        >
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white"
                        >Liên hệ quảng cáo</a
                        >
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white"
                        >Điều khoản sử dụng</a
                        >
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white"
                        >Chính sách bảo mật</a
                        >
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white"
                        >Quy chế hoạt động</a
                        >
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Liên hệ</h4>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-start">
                        <div
                            class="w-5 h-5 flex items-center justify-center mr-2 mt-0.5"
                        >
                            <i class="ri-map-pin-line"></i>
                        </div>
                        <span>Tòa nhà Media, 123 Đường Nguyễn Huệ, Quận 1, TP.HCM</span>
                    </li>
                    <li class="flex items-center">
                        <div class="w-5 h-5 flex items-center justify-center mr-2">
                            <i class="ri-phone-line"></i>
                        </div>
                        <span>(028) 3822 1188</span>
                    </li>
                    <li class="flex items-center">
                        <div class="w-5 h-5 flex items-center justify-center mr-2">
                            <i class="ri-mail-line"></i>
                        </div>
                        <span>contact@news.tuancuong.store</span>
                    </li>
                </ul>
                <div class="mt-4">
                    <h5 class="font-medium mb-2">Đăng ký nhận tin</h5>
                    <div class="flex">
                        <input
                            type="email"
                            placeholder="Email của bạn"
                            class="bg-gray-700 text-white px-3 py-2 rounded-l-button w-full text-sm border-none"
                        />
                        <button
                            class="bg-primary text-white px-4 py-2 rounded-r-button whitespace-nowrap"
                        >
                            Đăng ký
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="border-t border-gray-700 pt-6 flex flex-col md:flex-row justify-between items-center"
        >
            <p class="text-gray-400 text-sm mb-4 md:mb-0">
                © 2025 Tin Tức Việt Nam. Tất cả các quyền được bảo lưu.
            </p>
            <div class="flex space-x-4">
                <div class="w-8 h-8 flex items-center justify-center text-gray-400">
                    <i class="ri-visa-fill ri-lg"></i>
                </div>
                <div class="w-8 h-8 flex items-center justify-center text-gray-400">
                    <i class="ri-mastercard-fill ri-lg"></i>
                </div>
                <div class="w-8 h-8 flex items-center justify-center text-gray-400">
                    <i class="ri-paypal-fill ri-lg"></i>
                </div>
            </div>
        </div>
    </div>
</footer>
