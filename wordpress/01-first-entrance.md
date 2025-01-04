# Request tới file index.php của WordPress

## index.php file

Tại folder `pw-cms`, tạo một file `index.php`. Tương tự với WordPress hay bất kỳ PHP app nào khác, request sẽ luôn hit file `index.php` trước tiên.

Nếu bạn đọc file `index.php` của WP thì WP cũng nói rõ, file này gần như không làm gì ngoại trừ việc load file `wp-blog-header.php`, khi đó file được load này mới chịu trách nhiệm xử lý các tác vụ kế tiếp. Ngoài ra thì file này còn define một cái constant là `WP_USE_THEMES`. Dù chưa biết constant này sẽ dùng vào việc gì nhưng dựa theo comment của WP thì có thể đoán được là WP sẽ dùng constant này để load các themes lên. Giờ chúng ta sẽ làm y chang vậy.

```php
<?php

define( 'PW_USE_THEMES', true );

require __DIR__ . '/pw-blog-header.php';
```

Nếu chạy vào thời điểm này thì chắc chắn sẽ gặp lỗi, vì vậy giờ mình sẽ tạo thêm một file là `pw-blog-header.php` và để rỗng tạm rồi reload.

## wp-blog-header.php

WP bắt đầu file này thông qua điều kiện kiểm tra xem biến `$wp_did_header` đã được set chưa. Cái này thì chắc chắn là chưa, vì vậy WP sẽ làm các tác vụ sau:
- Set biến `$wp_did_header`.
- Load file `wp-load.php`, qua đó include các thư viện của WordPress.
- Setup WordPress query qua việc gọi hàm `wp()`.
- Load file `/template-loader.php` để load template của theme.

## wp-load.php

File `wp-load.php` là file đóng vai trò như một bootstrap file. File này sẽ set một vài constants quan trọng cũng như load các file config như `wp-config.php` và `wp-settings.php`. 

### Set `ABSPATH`
Đầu tiên thì WP sẽ set constant `ABSPATH` (absolute path) như sau:

```php
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
```

Về cơ bản thì constant này như một constant wrapper (*thuật ngữ constant wrapper này có tồn tại hay không?!*) cho magic constant `__DIR__` nên nó gần như tương tự, chỉ khác là `ABSPATH` sẽ thêm một trailing slash. Bạn có thể dump hai constants này ra để kiểm chứng. Ví dụ, đây là kết quả mình dump trên windows:

```php
var_dump(__DIR__, ABSPATH); // string(25) "D:\XAMPP\htdocs\power-cms" string(26) "D:\XAMPP\htdocs\power-cms/"
```

### Thiết lập các kiểu error cần được log

Tiếp sau đó, WP sẽ thiết lập các mức độ error cần được log lại vào hệ thống. WordPress có thêm một comment là function `error_reporting` này có thể sẽ bị disable trong `php.ini`, vì vậy họ wrap chỗ này lại bằng `function_exists`.

```php
if ( function_exists( 'error_reporting' ) ) {
	error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
}
```

### Load Config


