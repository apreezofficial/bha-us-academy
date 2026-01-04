<?php
require_once 'includes/config.php';

try {
    // 1. Category
    $stmt = $pdo->prepare("INSERT IGNORE INTO categories (name, slug) VALUES ('Healthcare Essentials', 'healthcare-essentials')");
    $stmt->execute();
    $cat_id = $pdo->lastInsertId() ?: $pdo->query("SELECT id FROM categories WHERE slug = 'healthcare-essentials'")->fetchColumn();

    // 2. Course
    $stmt = $pdo->prepare("INSERT IGNORE INTO courses (category_id, title, slug, description, image, price, certificate_price) 
        VALUES (?, 'Mandatory Healthcare Training - All-in-One', 'mandatory-healthcare-training', 'A comprehensive all-in-one bundle covering the essential modules required for UK healthcare compliance.', 'https://images.unsplash.com/photo-1576091160550-21735999fsf?auto=format&fit=crop&q=80&w=2070', 0.00, 25.00)");
    $stmt->execute([$cat_id]);
    $course_id = $pdo->lastInsertId() ?: $pdo->query("SELECT id FROM courses WHERE slug = 'mandatory-healthcare-training'")->fetchColumn();

    // 3. Lessons
    $lessons = [
        ['Infection Prevention and Control', '<h2>1. Introduction</h2><p>Infection Prevention and Control (IPC) is a scientific approach and practical solution designed to prevent harm caused by infection to patients and health workers.</p><h2>2. Standard Precautions</h2><ul><li>Hand Hygiene</li><li>Personal Protective Equipment (PPE)</li><li>Safe Management of Sharps</li></ul>', 1],
        ['Safeguarding Adults at Risk', '<h2>1. Introduction</h2><p>Safeguarding means protecting an adult’s right to live in safety, free from abuse and neglect.</p><h2>2. Types of Abuse</h2><ul><li>Physical</li><li>Emotional</li><li>Financial</li><li>Neglect</li></ul>', 2],
        ['Moving and Handling', '<h2>1. Introduction</h2><p>Incorrect moving and handling can cause serious injury to both staff and patients.</p><h2>2. Principles of Safe Moving</h2><ul><li>Plan the move</li><li>Keep the load close</li><li>Stable base</li></ul>', 3]
    ];

    foreach ($lessons as $l) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO lessons (course_id, title, content, sort_order) VALUES (?, ?, ?, ?)");
        $stmt->execute([$course_id, $l[0], $l[1], $l[2]]);
    }

    // 4. Exam
    $stmt = $pdo->prepare("INSERT IGNORE INTO exams (course_id, title, passing_score) VALUES (?, 'Healthcare Essentials Final Assessment', 80)");
    $stmt->execute([$course_id]);
    $exam_id = $pdo->lastInsertId() ?: $pdo->query("SELECT id FROM exams WHERE course_id = $course_id")->fetchColumn();

    // 5. Questions
    $questions = [
        ['What is the single most important action to prevent infection?', json_encode(['A' => 'Wearing gloves', 'B' => 'Hand washing', 'C' => 'Wearing a mask', 'D' => 'Using sanitizer only']), 'B'],
        ['Which of these is NOT a primary form of abuse?', json_encode(['A' => 'Physical', 'B' => 'Financial', 'C' => 'Constructive criticism', 'D' => 'Neglect']), 'C']
    ];

    foreach ($questions as $q) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO questions (exam_id, question_text, options, correct_answer) VALUES (?, ?, ?, ?)");
        $stmt->execute([$exam_id, $q[0], $q[1], $q[2]]);
    }

    echo "Course 'Healthcare Essentials' seeded successfully!";

} catch (PDOException $e) {
    echo "Error Seeding: " . $e->getMessage();
}
