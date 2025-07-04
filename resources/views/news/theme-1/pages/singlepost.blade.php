@extends('news.theme-1.layout.layout')
@section('title')
    | {{ $post->title }}
@endsection
@section('content')
    <!-- Breadcrumb -->
    <div class="flex items-center text-sm text-gray-500 mb-4">
        <a href="#" class="hover:text-primary">Trang chủ</a>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium">{{ @$post->category->parent->name }}</span>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium">{{ @$post->category->name }}</span>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium">{{ @$post->title }}</span>
    </div>
    <!-- Page Title -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ @$post->title }}</h1>
            <div class="flex items-center text-gray-600 text-sm mb-6">
                <span class="mr-4">Tác giả: {{ $post->Admin->name }}</span>
                <span>Ngày đăng: {{ \Carbon\Carbon::parse($post->created_at)->format('Y-m-d') }}</span>
            </div>

            <img src="{{ $post->feture }}"
                alt="{{ $post->title }}"
                class="w-full h-auto rounded-lg mb-6"
            />

            <div class="prose max-w-none text-gray-700 leading-relaxed">
                {!! $post->content !!}
            </div>

            <!-- Related Articles -->
            <div class="mt-10 pt-6 border-t border-gray-200">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Tin tức liên quan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($lq as $post)
                        <a href="/post/{{$post['slug'] }}.html" class="block group">
                            <div class="flex">
                                <div class="w-1/3 mr-3">
                                    <div class="overflow-hidden rounded">
                                        <img
                                            src="{{ $post->feture }}"
                                            alt="{{ $post->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        />
                                    </div>
                                </div>
                                <div class="w-2/3">
                                    <h3 class="font-bold mb-1 group-hover:text-primary">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar for popular news -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Tin tức phổ biến -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4 text-gray-800 border-b-2 border-primary pb-2">Tin tức phổ biến</h2>
                <ul class="space-y-4">
                    @foreach($pho_bien as $post)
                        <li>
                            <a href="/post/{{$post['slug'] }}.html" class="block group">
                                <h3 class="font-bold mb-1 group-hover:text-primary">
                                    {{ $post->title }}
                                </h3>
                                <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
                            </a>
                        </li>

                    @endforeach

                </ul>
            </div>
            <!-- Thời tiết -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-lg shadow-md text-white">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <i class="ri-sun-line mr-2"></i>
                    Thời tiết hôm nay
                </h2>
                <div class="text-center">
                    <div class="text-3xl font-bold mb-2">28°C</div>
                    <div class="text-sm opacity-90 mb-2">Hà Nội</div>
                    <div class="flex justify-between text-sm">
                        <span>Cao: 32°C</span>
                        <span>Thấp: 24°C</span>
                    </div>
                    <div class="mt-3 text-sm opacity-90">
                        <i class="ri-cloudy-line mr-1"></i>
                        Có mây, khả năng mưa nhỏ
                    </div>
                </div>
            </div>

            <!-- Tin nổi bật trong ngày -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4 text-gray-800 border-b-2 border-primary pb-2">Nổi bật trong ngày</h2>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="ri-line-chart-line text-primary text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm mb-1">Chứng khoán VN-Index tăng 1.2%</h3>
                            <p class="text-gray-500 text-xs">Thị trường chứng khoán khởi sắc</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="ri-leaf-line text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm mb-1">Dự án năng lượng xanh mới</h3>
                            <p class="text-gray-500 text-xs">Đầu tư 2 tỷ USD vào điện mặt trời</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="ri-graduation-cap-line text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm mb-1">Cải cách giáo dục 2025</h3>
                            <p class="text-gray-500 text-xs">Chương trình mới áp dụng toàn quốc</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quảng cáo -->
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6 rounded-lg shadow-md text-white text-center">
                <h3 class="text-lg font-bold mb-2">Đăng ký nhận tin</h3>
                <p class="text-sm opacity-90 mb-4">Nhận tin tức mới nhất qua email</p>
                <div class="space-y-3">
                    <input
                        type="email"
                        placeholder="Nhập email của bạn"
                        class="w-full px-3 py-2 rounded-button text-gray-800 text-sm focus:outline-none"
                    />
                    <button class="w-full bg-white text-purple-600 py-2 rounded-button font-bold text-sm hover:bg-gray-100 transition-colors">
                        Đăng ký ngay
                    </button>
                </div>
            </div>

            <!-- Tags phổ biến -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4 text-gray-800 border-b-2 border-primary pb-2">Từ khóa phổ biến</h2>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white cursor-pointer transition-colors">#Kinh tế</span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white cursor-pointer transition-colors">#Chính trị</span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white cursor-pointer transition-colors">#Thể thao</span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white cursor-pointer transition-colors">#Giải trí</span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white cursor-pointer transition-colors">#Công nghệ</span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white cursor-pointer transition-colors">#Sức khỏe</span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white cursor-pointer transition-colors">#Du lịch</span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white cursor-pointer transition-colors">#Giáo dục</span>
                </div>
            </div>

            <!-- Thống kê nhanh -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4 text-gray-800 border-b-2 border-primary pb-2">Thống kê nhanh</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">USD/VND</span>
                        <span class="font-bold text-green-600">24.350 ↑</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Vàng SJC</span>
                        <span class="font-bold text-red-600">76.5 triệu ↑</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">VN-Index</span>
                        <span class="font-bold text-green-600">1.245 ↑</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Xăng RON95</span>
                        <span class="font-bold text-gray-600">22.050đ →</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            $('.video a').fancybox({
                helpers: {  title : { type : 'over' } },
                type: 'iframe'
            });
        });
    </script>
@endsection
