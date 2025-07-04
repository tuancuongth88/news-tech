<!DOCTYPE html>
<html lang="vi">
@include('news.theme-1.partials.head')
<body class="bg-gray-50">
<!-- Top Bar -->
@include('news.theme-1.partials.topbar')
<!-- Header -->
@include('news.theme-1.partials.header')
<main class="container mx-auto px-4 py-6">
    @yield('content')
</main>
@include('news.theme-1.partials.footer')
<!-- Back to top button -->
<button
    id="backToTop"
    class="back-to-top fixed bottom-6 right-6 bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg"
>
    <i class="ri-arrow-up-line ri-lg"></i>
</button>
@include('news.theme-1.partials.js')
</body>
@yield('js')
</html>
