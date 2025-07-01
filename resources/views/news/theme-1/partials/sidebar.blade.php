<div class="lg:w-1/4">
    <!-- Tin mới nhất -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <h3 class="text-lg font-bold mb-4 pb-2 border-b">Tin mới nhất</h3>
        <div class="space-y-4">
            @foreach($postNew as $key =>  $post)
                <a href="post/{{$post['slug'] }}.html" class="block group">
                    <div class="flex items-start">
                        <span class="text-primary font-bold mr-2">{{ $key + 1 }}</span>
                        <p class="text-sm group-hover:text-primary">
                            {{ $post->title }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <!-- Thời tiết -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <h3 class="text-lg font-bold mb-4 pb-2 border-b">Thời tiết</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-medium">Hà Nội</p>
                    <p class="text-sm text-gray-500">Có mây, có mưa rào</p>
                </div>
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 flex items-center justify-center text-yellow-500 mr-1"
                    >
                        <i class="ri-sun-cloudy-fill ri-lg"></i>
                    </div>
                    <span class="font-bold">28°C</span>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-medium">TP.HCM</p>
                    <p class="text-sm text-gray-500">Nắng, có mây</p>
                </div>
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 flex items-center justify-center text-yellow-500 mr-1"
                    >
                        <i class="ri-sun-fill ri-lg"></i>
                    </div>
                    <span class="font-bold">33°C</span>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-medium">Đà Nẵng</p>
                    <p class="text-sm text-gray-500">Nắng, gió nhẹ</p>
                </div>
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 flex items-center justify-center text-yellow-500 mr-1"
                    >
                        <i class="ri-sun-fill ri-lg"></i>
                    </div>
                    <span class="font-bold">31°C</span>
                </div>
            </div>
        </div>
        <a href="#" class="text-primary text-sm block text-right mt-3"
        >Xem thêm</a
        >
    </div>
    <!-- Tỷ giá -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <h3 class="text-lg font-bold mb-4 pb-2 border-b">
            Tỷ giá ngoại tệ
        </h3>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span>USD</span>
                <span class="font-medium">24.850 VND</span>
            </div>
            <div class="flex justify-between">
                <span>EUR</span>
                <span class="font-medium">26.720 VND</span>
            </div>
            <div class="flex justify-between">
                <span>JPY</span>
                <span class="font-medium">165,25 VND</span>
            </div>
            <div class="flex justify-between">
                <span>GBP</span>
                <span class="font-medium">31.450 VND</span>
            </div>
        </div>
        <a href="#" class="text-primary text-sm block text-right mt-3"
        >Xem thêm</a
        >
    </div>
    <!-- Quảng cáo -->
    <div class="bg-gray-100 rounded-lg p-4 mb-6 text-center">
        <p class="text-sm text-gray-500 mb-2">Quảng cáo</p>
        <div class="bg-white rounded p-4">
            <div
                class="w-16 h-16 mx-auto mb-3 flex items-center justify-center text-primary"
            >
                <i class="ri-advertisement-fill ri-3x"></i>
            </div>
            <h4 class="font-bold mb-2">Đăng ký gói tin VIP</h4>
            <p class="text-sm text-gray-600 mb-3">
                Truy cập không giới hạn tất cả các bài báo và nội dung độc quyền
            </p>
            <a
                href="#"
                class="inline-block bg-primary text-white px-4 py-2 rounded-button text-sm font-medium whitespace-nowrap"
            >Đăng ký ngay</a
            >
        </div>
    </div>
</div>
