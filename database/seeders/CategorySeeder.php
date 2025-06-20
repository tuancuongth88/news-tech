<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $baseUrl = 'https://vietstock.vn';

        $categories = [
            [
                'name' => 'Chứng khoán',
                'rss' => "$baseUrl/144/chung-khoan.rss",
                'children' => [
                    ['name' => 'Cổ phiếu', 'rss' => "$baseUrl/830/chung-khoan/co-phieu.rss"],
                    ['name' => 'Giao dịch nội bộ', 'rss' => "$baseUrl/739/chung-khoan/giao-dich-noi-bo.rss"],
                    ['name' => 'Niêm yết', 'rss' => "$baseUrl/741/chung-khoan/niem-yet.rss"],
                    ['name' => 'ETF và các quỹ', 'rss' => "$baseUrl/3358/chung-khoan/etf-va-cac-quy.rss"],
                    ['name' => 'Chứng khoán phái sinh', 'rss' => "$baseUrl/4186/chung-khoan/chung-khoan-phai-sinh.rss"],
                    ['name' => 'Chứng quyền', 'rss' => "$baseUrl/4308/chung-khoan/chung-quyen.rss"],
                    ['name' => 'Ý kiến chuyên gia', 'rss' => "$baseUrl/145/chung-khoan/y-kien-chuyen-gia.rss"],
                    ['name' => 'Câu chuyện đầu tư', 'rss' => "$baseUrl/3355/chung-khoan/cau-chuyen-dau-tu.rss"],
                    ['name' => 'Chính sách', 'rss' => "$baseUrl/143/chung-khoan/chinh-sach.rss"],
                    ['name' => 'Trái phiếu', 'rss' => "$baseUrl/785/chung-khoan/thi-truong-trai-phieu.rss"],
                ],
            ],
            [
                'name' => 'Doanh nghiệp',
                'rss' => "$baseUrl/733/doanh-nghiep.rss",
                'children' => [
                    ['name' => 'Hoạt động kinh doanh', 'rss' => "$baseUrl/737/doanh-nghiep/hoat-dong-kinh-doanh.rss"],
                    ['name' => 'Cổ tức', 'rss' => "$baseUrl/738/doanh-nghiep/co-tuc.rss"],
                    ['name' => 'Tăng vốn - M&A', 'rss' => "$baseUrl/764/doanh-nghiep/tang-von-m-a.rss"],
                    ['name' => 'IPO - Cổ phần hóa', 'rss' => "$baseUrl/746/doanh-nghiep/ipo-co-phan-hoa.rss"],
                    ['name' => 'Nhân vật', 'rss' => "$baseUrl/214/doanh-nghiep/nhan-vat.rss"],
                    ['name' => 'Trái phiếu doanh nghiệp', 'rss' => "$baseUrl/3118/doanh-nghiep/trai-phieu-doanh-nghiep.rss"],
                ],
            ],
            [
                'name' => 'Bất động sản',
                'rss' => "$baseUrl/763/bat-dong-san.rss",
                'children' => [
                    ['name' => 'Thị trường nhà đất', 'rss' => "$baseUrl/4220/bat-dong-san/thi-truong-nha-dat.rss"],
                    ['name' => 'Quy hoạch - Hạ tầng', 'rss' => "$baseUrl/42221/bat-dong-san/quy-hoach-ha-tang.rss"],
                    ['name' => 'Dự án', 'rss' => "$baseUrl/4222/bat-dong-san/du-an.rss"],
                    ['name' => 'Bảo hiểm và thuế nhà đất', 'rss' => "$baseUrl/4266/bat-dong-san/bao-hiem-va-thue-nha-dat.rss"],
                ],
            ],
            [
                'name' => 'Hàng hóa',
                'rss' => "$baseUrl/2/hang-hoa.rss",
                'children' => [
                    ['name' => 'Vàng và kim loại quý', 'rss' => "$baseUrl/759/hang-hoa/vang-va-kim-loai-quy.rss"],
                    ['name' => 'Nhiên liệu', 'rss' => "$baseUrl/34/hang-hoa/nhien-lieu.rss"],
                    ['name' => 'Kim loại', 'rss' => "$baseUrl/742/hang-hoa/kim-loai.rss"],
                    ['name' => 'Nông sản thực phẩm', 'rss' => "$baseUrl/118/hang-hoa/nong-san-thuc-pham.rss"],
                ],
            ],
            [
                'name' => 'Tài chính',
                'rss' => "$baseUrl/734/tai-chinh.rss",
                'children' => [
                    ['name' => 'Ngân hàng', 'rss' => "$baseUrl/757/tai-chinh/ngan-hang.rss"],
                    ['name' => 'Bảo hiểm', 'rss' => "$baseUrl/3113/tai-chinh/bao-hiem.rss"],
                    ['name' => 'Thuế và Ngân sách', 'rss' => "$baseUrl/758/tai-chinh/thue-va-ngan-sach.rss"],
                ],
            ],
            [
                'name' => 'Kinh tế',
                'rss' => "$baseUrl/5307/kinh-te.rss",
                'children' => [
                    ['name' => 'Vĩ mô', 'rss' => "$baseUrl/761/kinh-te/vi-mo.rss"],
                    ['name' => 'Kinh tế - Đầu tư', 'rss' => "$baseUrl/768/kinh-te/kinh-te-dau-tu.rss"],
                ],
            ],
            [
                'name' => 'Thế giới',
                'rss' => "$baseUrl/736/the-gioi.rss",
                'children' => [
                    ['name' => 'Chứng khoán thế giới', 'rss' => "$baseUrl/773/the-gioi/chung-khoan-the-gioi.rss"],
                    ['name' => 'Tiền kỹ thuật số', 'rss' => "$baseUrl/4309/the-gioi/tien-ky-thuat-so.rss"],
                    ['name' => 'Tài chính quốc tế', 'rss' => "$baseUrl/772/the-gioi/tai-chinh-quoc-te.rss"],
                    ['name' => 'Kinh tế - Đầu tư', 'rss' => "$baseUrl/775/the-gioi/kinh-te-nganh.rss"],
                ],
            ],
            [
                'name' => 'Đông Dương',
                'rss' => "$baseUrl/1317/dong-duong.rss",
                'children' => [
                    ['name' => 'Vĩ mô', 'rss' => "$baseUrl/1326/dong-duong/vi-mo-dau-tu.rss"],
                    ['name' => 'Tài chính - Ngân hàng', 'rss' => "$baseUrl/1327/dong-duong/tai-chinh-ngan-hang.rss"],
                    ['name' => 'Thị trường chứng khoán', 'rss' => "$baseUrl/1328/dong-duong/thi-truong-chung-khoan.rss"],
                    ['name' => 'Kinh tế - Đầu tư', 'rss' => "$baseUrl/1329/dong-duong/kinh-te-nganh.rss"],
                ],
            ],
            [
                'name' => 'Tài chính cá nhân',
                'rss' => "$baseUrl/4259/tai-chinh-ca-nhan.rss",
                'children' => [
                    ['name' => 'Làm chủ đồng tiền', 'rss' => "$baseUrl/4260/tai-chinh-ca-nhan/lam-chu-dong-tien.rss"],
                    ['name' => 'Đầu tư – Kinh doanh nhỏ', 'rss' => "$baseUrl/4261/tai-chinh-ca-nhan/dau-tu-kinh-doanh-nho.rss"],
                    ['name' => 'Doanh nhân và khởi nghiệp', 'rss' => "$baseUrl/4262/tai-chinh-ca-nhan/doanh-nhan-va-khoi-nghiep.rss"],
                    ['name' => 'Chơi sang', 'rss' => "$baseUrl/4263/tai-chinh-ca-nhan/choi-sang.rss"],
                    ['name' => 'Xe - Công nghệ', 'rss' => "$baseUrl/4264/tai-chinh-ca-nhan/xe-cong-nghe.rss"],
                    ['name' => 'Tiêu dùng và lối sống', 'rss' => "$baseUrl/4265/tai-chinh-ca-nhan/tieu-dung-va-cuoc-song.rss"],
                    ['name' => 'Vì cộng đồng', 'rss' => "$baseUrl/735/tai-chinh-ca-nhan/vi-cong-dong.rss"],
                ],
            ],
            [
                'name' => 'Phân tích',
                'rss' => "$baseUrl/579/nhan-dinh-phan-tich.rss",
                'children' => [
                    ['name' => 'Nhận định thị trường', 'rss' => "$baseUrl/1636/nhan-dinh-phan-tich/nhan-dinh-thi-truong.rss"],
                    ['name' => 'Phân tích cơ bản', 'rss' => "$baseUrl/582/nhan-dinh-phan-tich/phan-tich-co-ban.rss"],
                    ['name' => 'Phân tích kỹ thuật', 'rss' => "$baseUrl/585/nhan-dinh-phan-tich/phan-tich-ky-thuat.rss"],
                ],
            ],
            [
                'name' => 'Tin mới',
                'rss' => "$baseUrl/0/tin-moi.rss",
                'children' => [],
            ],
        ];

        foreach ($categories as $category) {
            $parent = Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'rss_url' => $category['rss'],
                'parent_id' => null,
            ]);

            foreach ($category['children'] as $child) {
                Category::create([
                    'name' => $child['name'],
                    'slug' => Str::slug($category['name']).'/'.Str::slug($child['name']),
                    'rss_url' => $child['rss'],
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
