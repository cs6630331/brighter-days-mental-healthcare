# Brighter Days Mental Healthcare

Web Project สำหรับวิชา Web Development

## Starting Local Dev Server

1. ติดตั้ง [PHP](https://php.net/downloads.php) และ [Composer](https://getcomposer.org/download/)
2. Clone Repository นี้ลงคอมพิวเตอร์
```
git clone https://github.com/cs6630331/brighter-days-mental-healthcare.git
```
3. เข้า Project Folder ที่ clone มาแล้ว ให้รันคำสั่งดังกล่าวใน Folder เพื่อติดตั้ง PHPMailer
```
composer install
```
4. รัน Dev Server
```
php -S localhost:8080
```

## รันใน Host 193
ก่อนที่จะรัน host 193 จะต้องเปลี่ยนลิงก์ `href` และ `Location: ` ให้เริ่มต้นด้วย `https://202.44.40.193/~cs6630331/brighter-days-mental-healthcare/` แทนที่ `/` เรียบร้อยก่อน

**หมายเหตุ:** เพื่อการอธิบาย เรามีการเพิ่ม connect.php ด้วย (อย่างไรก็ตาม เรารู้ว่าเป็น practice ที่ไม่ดี)
