-- Create the demo school
INSERT INTO `schools` (`edh_id`, `name`, `contact_email`, `contact_phone`, `address`, `payment_status`) VALUES
('edh00000', 'Demo School', 'demo@eduhelp.local', '1234567890', '123 Demo Street', 'paid');

-- Get the school_id of the demo school
SET @school_id = LAST_INSERT_ID();

-- Create the superuser
INSERT INTO `users` (`role`, `username`, `email`, `password_hash`) VALUES
('superuser', 'superuser', 'admin@eduhelp.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password

-- Create the headteacher for the demo school
INSERT INTO `users` (`school_id`, `role`, `edh_id`, `username`, `email`, `password_hash`, `gender`) VALUES
(@school_id, 'headteacher', 'edhm00000', 'headteacher', 'headteacher@eduhelp.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'male'); -- password

-- Create classes for the demo school
INSERT INTO `classes` (`school_id`, `class_name`) VALUES
(@school_id, 'Grade 1'),
(@school_id, 'Grade 2'),
(@school_id, 'Grade 3');

-- Get the class_ids of the demo school
SET @class_id_1 = (SELECT class_id FROM classes WHERE school_id = @school_id AND class_name = 'Grade 1');
SET @class_id_2 = (SELECT class_id FROM classes WHERE school_id = @school_id AND class_name = 'Grade 2');
SET @class_id_3 = (SELECT class_id FROM classes WHERE school_id = @school_id AND class_name = 'Grade 3');

-- Create subjects for the demo school
INSERT INTO `subjects` (`school_id`, `subject_name`) VALUES
(@school_id, 'Mathematics'),
(@school_id, 'English'),
(@school_id, 'Science'),
(@school_id, 'History'),
(@school_id, 'Geography');

-- Get the subject_ids of the demo school
SET @subject_id_math = (SELECT subject_id FROM subjects WHERE school_id = @school_id AND subject_name = 'Mathematics');
SET @subject_id_eng = (SELECT subject_id FROM subjects WHERE school_id = @school_id AND subject_name = 'English');
SET @subject_id_sci = (SELECT subject_id FROM subjects WHERE school_id = @school_id AND subject_name = 'Science');
SET @subject_id_hist = (SELECT subject_id FROM subjects WHERE school_id = @school_id AND subject_name = 'History');
SET @subject_id_geo = (SELECT subject_id FROM subjects WHERE school_id = @school_id AND subject_name = 'Geography');

-- Create teachers for the demo school
INSERT INTO `users` (`school_id`, `role`, `edh_id`, `username`, `email`, `password_hash`, `gender`) VALUES
(@school_id, 'teacher', 'edhm00001', 'teacher1', 'teacher1@eduhelp.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'male'),
(@school_id, 'teacher', 'edhf00001', 'teacher2', 'teacher2@eduhelp.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'female'),
(@school_id, 'teacher', 'edhm00002', 'teacher3', 'teacher3@eduhelp.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'male'),
(@school_id, 'teacher', 'edhf00002', 'teacher4', 'teacher4@eduhelp.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'female'),
(@school_id, 'teacher', 'edhm00003', 'teacher5', 'teacher5@eduhelp.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'male');

-- Get the teacher_ids of the demo school
SET @teacher_id_1 = (SELECT user_id FROM users WHERE school_id = @school_id AND username = 'teacher1');
SET @teacher_id_2 = (SELECT user_id FROM users WHERE school_id = @school_id AND username = 'teacher2');
SET @teacher_id_3 = (SELECT user_id FROM users WHERE school_id = @school_id AND username = 'teacher3');
SET @teacher_id_4 = (SELECT user_id FROM users WHERE school_id = @school_id AND username = 'teacher4');
SET @teacher_id_5 = (SELECT user_id FROM users WHERE school_id = @school_id AND username = 'teacher5');

-- Assign teachers to subjects and classes
INSERT INTO `teacher_subjects` (`teacher_id`, `class_id`, `subject_id`) VALUES
(@teacher_id_1, @class_id_1, @subject_id_math),
(@teacher_id_1, @class_id_2, @subject_id_math),
(@teacher_id_2, @class_id_1, @subject_id_eng),
(@teacher_id_2, @class_id_2, @subject_id_eng),
(@teacher_id_3, @class_id_1, @subject_id_sci),
(@teacher_id_3, @class_id_2, @subject_id_sci),
(@teacher_id_4, @class_id_3, @subject_id_hist),
(@teacher_id_5, @class_id_3, @subject_id_geo);

-- Create students for the demo school
INSERT INTO `students` (`school_id`, `class_id`, `edh_id`, `LIN`, `name`, `gender`, `dob`, `parent_contact`) VALUES
(@school_id, @class_id_1, 'edhm00001', 'LIN001', 'John Doe', 'male', '2010-01-01', '1234567890'),
(@school_id, @class_id_1, 'edhf00001', 'LIN002', 'Jane Doe', 'female', '2010-02-01', '1234567890'),
(@school_id, @class_id_1, 'edhm00002', 'LIN003', 'Peter Jones', 'male', '2010-03-01', '1234567890'),
(@school_id, @class_id_2, 'edhf00002', 'LIN004', 'Mary Smith', 'female', '2009-01-01', '1234567890'),
(@school_id, @class_id_2, 'edhm00003', 'LIN005', 'David Williams', 'male', '2009-02-01', '1234567890'),
(@school_id, @class_id_2, 'edhf00003', 'LIN006', 'Susan Brown', 'female', '2009-03-01', '1234567890'),
(@school_id, @class_id_3, 'edhm00004', 'LIN007', 'Michael Miller', 'male', '2008-01-01', '1234567890'),
(@school_id, @class_id_3, 'edhf00004', 'LIN008', 'Karen Wilson', 'female', '2008-02-01', '1234567890'),
(@school_id, @class_id_3, 'edhm00005', 'LIN009', 'James Taylor', 'male', '2008-03-01', '1234567890'),
(@school_id, @class_id_3, 'edhf00005', 'LIN010', 'Patricia Anderson', 'female', '2008-04-01', '1234567890');

-- Get the student_ids of the demo school
SET @student_id_1 = (SELECT student_id FROM students WHERE school_id = @school_id AND LIN = 'LIN001');
SET @student_id_2 = (SELECT student_id FROM students WHERE school_id = @school_id AND LIN = 'LIN002');
SET @student_id_3 = (SELECT student_id FROM students WHERE school_id = @school_id AND LIN = 'LIN003');
SET @student_id_4 = (SELECT student_id FROM students WHERE school_id = @school_id AND LIN = 'LIN004');
SET @student_id_5 = (SELECT student_id FROM students WHERE school_id = @school_id AND LIN = 'LIN005');
SET @student_id_6 = (SELECT student_id FROM students WHERE school_id = @school_id AND LIN = 'LIN006');
SET @student_id_7 = (SELECT student_id FROM students WHERE school_id = @school_id AND LIN = 'LIN007');
SET @student_id_8 = (SELECT student_id FROM students WHERE school_id = @school_id AND LIN = 'LIN008');
SET @student_id_9 = (SELECT student_id FROM students WHERE school_id = @school_id AND LIN = 'LIN009');
SET @student_id_10 = (SELECT student_id FROM students WHERE school_id = @school_id AND LIN = 'LIN010');

-- Assign subjects to students
INSERT INTO `student_subjects` (`student_id`, `subject_id`) VALUES
(@student_id_1, @subject_id_math),
(@student_id_1, @subject_id_eng),
(@student_id_1, @subject_id_sci),
(@student_id_2, @subject_id_math),
(@student_id_2, @subject_id_eng),
(@student_id_2, @subject_id_sci),
(@student_id_3, @subject_id_math),
(@student_id_3, @subject_id_eng),
(@student_id_3, @subject_id_sci),
(@student_id_4, @subject_id_math),
(@student_id_4, @subject_id_eng),
(@student_id_4, @subject_id_sci),
(@student_id_5, @subject_id_math),
(@student_id_5, @subject_id_eng),
(@student_id_5, @subject_id_sci),
(@student_id_6, @subject_id_math),
(@student_id_6, @subject_id_eng),
(@student_id_6, @subject_id_sci),
(@student_id_7, @subject_id_hist),
(@student_id_7, @subject_id_geo),
(@student_id_8, @subject_id_hist),
(@student_id_8, @subject_id_geo),
(@student_id_9, @subject_id_hist),
(@student_id_9, @subject_id_geo),
(@student_id_10, @subject_id_hist),
(@student_id_10, @subject_id_geo);
