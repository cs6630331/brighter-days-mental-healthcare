# Brighter Days Mental Healthcare

Web Project สำหรับวิชา Web Development

**หมายเหตุ:** เนื่องจากมีข้อมูลสำคัญใน `connect.php` เราจึงไม่ใส่มาใน github ดังนั้นคุณต้องสร้างไฟล์ `connect.php` ก่อน

## Starting Local Dev Server

1. ติดตั้ง [PHP](https://php.net/downloads.php) และ [Composer](https://getcomposer.org/download/)
2. Clone Repository นี้ลงคอมพิวเตอร์
```
git clone https://github.com/cs6630331/brighter-days-mental-healthcare.git
```
3. สร้างไฟล์ `connect.php` ไว้ที่ Project Root Directory โดยในไฟล์ต้องมีลักษณะดังนี้
```php
<?php
  // เปลี่ยนชื่อ mental_healthcare, root, pass1234 ให้เป็น ชื่อ Schema, username, และ password ตามลำดับ
	$pdo = new PDO("mysql:host=localhost:3306; dbname=mental_healthcare", "root", "pass1234");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
```
4. เข้า Project Folder ที่ clone มาแล้ว ให้รันคำสั่งดังกล่าวใน Folder เพื่อติดตั้ง PHPMailer
```
composer install
```
5. รัน Dev Server
```
php -S localhost:8080
```

## รันใน Host 193
ก่อนที่จะรัน host 193 จะต้องเปลี่ยนลิงก์ `href` และ `Location: ` ให้เริ่มต้นด้วย `https://202.44.40.193/~cs6630331/brighter-days-mental-healthcare/` แทนที่ `/` เรียบร้อยก่อน
