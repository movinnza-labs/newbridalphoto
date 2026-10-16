-- Admin login users for The Bridal Photography
-- Run once in phpMyAdmin (SQL tab) on the site's database.
-- Passwords are stored as bcrypt hashes. Re-running is safe (updates the password).

INSERT INTO tb_users (username, email, password_hash, is_active, created_at, updated_at) VALUES
('swarupa.kadav@movinnza.in', 'swarupa.kadav@movinnza.in', '$2y$10$6qchbNqi/abjU2iut.r17OXH8gBwpna0HIjoIJYxU0/QE9MxCgLtS', 1, NOW(), NOW()),
('thebridal11@gmail.com',     'thebridal11@gmail.com',     '$2y$10$/Nik0k6S1KAT2KYCFzCAKO85Ku.CCheiLvEFeEt3JE9BXplZOkC9S', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash), is_active = 1, updated_at = NOW();
