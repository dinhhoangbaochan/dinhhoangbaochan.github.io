# Tìm hiểu source WordPress

Web view: [Wordpress Breakdown](dinhhoangbaochan.github.io/wordpress)

Tổng hợp các research qua đó giúp tìm hiểu cách hoạt động của WordPress cũng như kiến trúc của CMS này. Hiện tại các tìm hiểu sẽ được ghi chép một cách lung tung tuỳ vào thời điểm, tuy nhiên nhìn chung thì toàn bộ nghiên cứu sẽ bắt nguồn từ việc mình đi theo file inclusion trong source WordPress, từ đó sẽ cố gắng diễn giải mỗi file có vai trò gì, functions nào sẽ mang lại chức năng gì, etc.

## Requirements và setup

Để có thể nhanh chóng tập trung vào việc nghiên cứu và tìm hiểu, việc setup cũng nên đơn giản:
- Nếu bạn dùng Mac, hãy tải MAMP.
- Nếu bạn dùng Win, hãy tải XAMPP.
- Nếu bạn không thích cái nào thì cứ dùng Docker.

Vì các software này đã quá phổ biến và hướng dẫn cài đặt cũng nhiều trên mạng nên mình sẽ không nói lại.

1. [WP First Entrance: Request tới file index.php](dinhhoangbaochan.github.io/wordpress/first-entrance).
