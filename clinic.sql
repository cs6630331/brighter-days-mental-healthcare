CREATE TABLE `_user` (
    `user_id` INT PRIMARY KEY AUTO_INCREMENT, 
    `user_name` VARCHAR(64) NOT NULL,
    `user_surname` VARCHAR(64) NOT NULL,
    `email` VARCHAR(255) UNIQUE NOT NULL,      
    `user_tel` VARCHAR(10) NOT NULL,          
    `citizen_id` VARCHAR(13),
    `password` TEXT,   
    `is_admin` BOOLEAN DEFAULT 0
);

CREATE TABLE `_doctor` (
    `doctor_id` INT PRIMARY KEY AUTO_INCREMENT, 
    `doctor_name` VARCHAR(64) NOT NULL,
    `doctor_surname` VARCHAR(64) NOT NULL,
    `doctor_tel` VARCHAR(10) NOT NULL,
    `doctor_education` TEXT NOT NULL,
    `morning_shift` BOOLEAN DEFAULT 1,
    `afternoon_shift` BOOLEAN DEFAULT 1,
    `is_active` BOOLEAN DEFAULT 1
);

CREATE TABLE `_appointment` (
    `appointment_id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `doctor_id` INT NOT NULL,
    `appointment_date` DATE NOT NULL,
    `appointment_time` TIME NOT NULL,
    `status` ENUM('confirmed', 'completed', 'cancelled') DEFAULT 'confirmed',
    `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `notes` TEXT,

    FOREIGN KEY (`user_id`) REFERENCES `_user`(`user_id`) ON DELETE CASCADE,
    FOREIGN KEY (`doctor_id`) REFERENCES `_doctor`(`doctor_id`) ON DELETE CASCADE,
    
    UNIQUE KEY `unique_doctor_time` (`doctor_id`, `appointment_date`, `appointment_time`)
);

INSERT INTO `_doctor` (
    `doctor_name`, 
    `doctor_surname`, 
    `doctor_tel`, 
    `doctor_education`, 
    `morning_shift`, 
    `afternoon_shift`, 
    `is_active`
) VALUES

('ก้องเกียรติ', 'เอกรัช', '0986525414', 'แพทยศาสตรบัณฑิต จุฬาลงกรณ์มหาวิทยาลัย', 1, 0, 1),
('มารตี', 'เทวพรหม', '0832515484', 'แพทยศาสตรบัณฑิต มหาวิทยาลัยมหิดล', 0, 1, 1),

('วิชัย', 'สภาปัตยกร', '0816447545', 'แพทยศาสตรบัณฑิต มหาวิทยาลัยเชียงใหม่', 1, 0, 1),
('สุดา', 'ป้องกัน', '0987527854', 'แพทยศาสตรบัณฑิต มหาวิทยาลัยสงขลานครินทร์', 0, 1, 1),

('นรภัทร', 'รักษ์สุข', '0896575174', 'แพทยศาสตรบัณฑิต มหาวิทยาลัยขอนแก่น', 1, 0, 1),
('สืบสกุล', 'สุวรรณสันติสุข', '0936284578', 'แพทยศาสตรบัณฑิต จุฬาลงกรณ์มหาวิทยาลัย', 0, 1, 1),

('พงศภัค', 'ดวงมณี', '0847548554', 'แพทยศาสตรบัณฑิต มหาวิทยาลัยเชียงใหม่', 1, 0, 1),
('มาลี', 'บริการ', '0996845274', 'แพทยศาสตรบัณฑิต มหาวิทยาลัยมหิดล', 0, 1, 1),

('วรท', 'เดชบุญ', '0825848875', 'แพทยศาสตรบัณฑิต มหาวิทยาลัยธรรมศาสตร์', 1, 0, 1),
('ณัฐณิชา', 'เมืองกลาง', '0968745172', 'แพทยศาสตรบัณฑิต มหาวิทยาลัยนเรศวร', 0, 1, 1);


INSERT INTO `_user` (
    `user_name`, 
    `user_surname`, 
    `email`, 
    `user_tel`, 
    `citizen_id`, 
    `password`, 
    `is_admin`
) VALUES

('ดารณี', 'จันทร์ดี', 'daranee@gmail.com', '0996584474', '1209011111110', 'daraneeeiei', 0),
('บารมี', 'งามจริง', 'suayja@gmail.com', '0823459787', '1209011111111', 'barameeeiei', 0),
('ประยุทธ', 'อาทิตย์โอชา', 'prayuth@gmail.com', '0837254001', '1209011111112', 'prayutheiei', 0),
('วรรณา', 'ใจงามจ้า', 'wanna123@gmail.com', '0845673511', '1209011111113', 'wannaeieiei', 0),
('อนุชา', 'ยาดี', 'anuchayadee@gmail.com', '0986789012', '1209011111114', 'anuchaja', 0),
('สุดารัตน์', 'รักจริง', 'rakjing@gmail.com', '0995246872', '1209011111115', 'yayasudarat', 0),
('วิชัยญา', 'สมบูรณ์เเบบ', 'wichai@gmail.com', '0878861474', '1209011111116', 'wiwieiei', 0),

('กรกวิณ', 'จันทร์เเรม', 'gorngawin@gmail.com', '0996584424', '1209011111117', 'gorngawin', 0),
('กุญชร', 'จริงใจ', 'kkurn@gmail.com', '0824459787', '1209011111118', 'chorneiei', 0),
('เมธาวิน', 'โอชา', 'methawin@gmail.com', '0837254002', '1209011111119', 'methawineiei', 0),
('วรรณา', 'อิรัญ', 'wannaluvcat@gmail.com', '0845673512', '1209011111120', 'wannaeieieija', 0),
('อนุภริ', 'จมปรรก', 'anupri@gmail.com', '0986789019', '1209011111121', 'anujajing', 0),
('ยนต์ชนก', 'พรรษา', 'yonjaaaa@gmail.com', '0975246872', '1209011111122', 'yonyonyoneiei', 0),
('สถาบันทนา', 'รักเพียงดาว', 'satha1234@gmail.com', '0878867745', '1209011111123', 'satha123456789', 0);

INSERT INTO `_appointment` (
    `user_id`,
    `doctor_id`, 
    `appointment_date`,
    `appointment_time`,
    `notes`
) VALUES
    (
        (SELECT user_id FROM `_user` WHERE user_name = 'วิชัยญา' AND user_surname = 'สมบูรณ์เเบบ'),
        (SELECT doctor_id FROM `_doctor` WHERE doctor_name = 'นรภัทร' AND doctor_surname = 'รักษ์สุข'),
        '2025-10-01', 
        '10:00:00',   
        'ช่วงนี้รู้สึกมีภาวะวิตกกังวล นอนไม่ค่อยหลับครับมีปัญหาหลายๆด้านทั้งเรื่องครอบครัวเรื่องงาน'
    ),

    (
        (SELECT user_id FROM `_user` WHERE user_name = 'วรรณา' AND user_surname = 'ใจงามจ้า'),
        (SELECT doctor_id FROM `_doctor` WHERE doctor_name = 'สืบสกุล' AND doctor_surname = 'สุวรรณสันติสุข'),
        '2025-10-01',  
        '14:00:00',
        '-'
    ),

    (
        (SELECT user_id FROM `_user` WHERE user_name = 'บารมี' AND user_surname = 'งามจริง'),
        (SELECT doctor_id FROM `_doctor` WHERE doctor_name = 'นรภัทร' AND doctor_surname = 'รักษ์สุข'),
        '2025-10-01', 
        '10:30:00',   
        'เคยคิดทำร้ายร่างกายตัวเองอยู่บ่อยครั้งครับ'
    ),

    (
        (SELECT user_id FROM `_user` WHERE user_name = 'ประยุทธ' AND user_surname = 'อาทิตย์โอชา'),
        (SELECT doctor_id FROM `_doctor` WHERE doctor_name = 'ณัฐณิชา' AND doctor_surname = 'เมืองกลาง'),
        '2025-10-03',  
        '15:30:00',
        '-'
    ),

    (
        (SELECT user_id FROM `_user` WHERE user_name = 'กุญชร' AND user_surname = 'จริงใจ'),
        (SELECT doctor_id FROM `_doctor` WHERE doctor_name = 'พงศภัค' AND doctor_surname = 'ดวงมณี'),
        '2025-10-02',  
        '10:30:00',
        'มีอาการย้ำคิดย้ำทำค่ะ'
    ),

    (
        (SELECT user_id FROM `_user` WHERE user_name = 'สุดารัตน์' AND user_surname = 'รักจริง'),
        (SELECT doctor_id FROM `_doctor` WHERE doctor_name = 'มาลี' AND doctor_surname = 'บริการ'),
        '2025-10-02',  
        '15:00:00',
        'มีอาการย้ำคิดย้ำทำค่ะ'
    );

    
SELECT 
    `_appointment`.`timestamp`,
    `_user`.`user_name`,
    `_user`.`user_surname`,
    `_doctor`.`doctor_name`,
    `_doctor`.`doctor_surname`,
    `_appointment`.`appointment_date`,
    `_appointment`.`appointment_time`
FROM 
    `_appointment` 
JOIN `_doctor` ON `_doctor`.doctor_id = `_appointment`.`doctor_id` 
JOIN `_user` ON `_user`.`user_id` = `_appointment`.`user_id` 
GROUP BY `_appointment`.`appointment_id`;


SELECT 
    `_appointment`.`appointment_date`,
    `_appointment`.`appointment_time`,
    `_user`.`user_name` AS patient_name,
    `_user`.`user_surname` AS patient_surname,
    `_doctor`.`doctor_name`,
    `_doctor`.`doctor_surname`,
    `_appointment`.`notes`
FROM 
    `_appointment`
JOIN `_doctor` ON `_doctor`.`doctor_id` = `_appointment`.`doctor_id`
JOIN `_user` ON `_user`.`user_id` = `_appointment`.`user_id`
WHERE 
    `_appointment`.`appointment_date` LIKE "2025-09%" AND
    `_appointment`.`status` = "completed"
ORDER BY 
    `_appointment`.`appointment_date`, `_appointment`.`appointment_time`;



SELECT
    `_appointment`.`appointment_date`,
    COUNT(`_doctor`.`doctor_id`) AS count
FROM
    `_appointment`
JOIN `_doctor` ON `_doctor`.`doctor_id` = `_appointment`.`doctor_id`
WHERE
    `_appointment`.`appointment_date` LIKE "2025-09%" AND
    `_appointment`.`status` = "completed"
GROUP BY
    `_appointment`.`appointment_date`;


SELECT
    `_appointment`.`timestamp`,
    COUNT(`_doctor`.`doctor_id`) AS count
FROM
    `_appointment`
JOIN `_doctor` ON `_doctor`.`doctor_id` = `_appointment`.`doctor_id`
WHERE
    `_appointment`.`timestamp` LIKE "2025-09%"
GROUP BY
    CAST(`_appointment`.`timestamp` AS DATE);