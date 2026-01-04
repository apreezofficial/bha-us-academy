<?php
/**
 * Pollinations AI Service for generating content and questions.
 */

class AIService {
    private static $apiUrl = "https://text.pollinations.ai/";

    /**
     * Generate text based on a prompt (Static wrapper)
     */
    public static function generateText($prompt, $model = "openai") {
        return self::generate($prompt, $model);
    }

    /**
     * Generate text based on a prompt
     */
    public static function generate($prompt, $model = "openai") {
        $url = self::$apiUrl . urlencode($prompt) . "?model=" . $model;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            return $response;
        }
        return false;
    }

    /**
     * Generate exam questions in JSON format
     */
    public static function generateExamQuestions($topic, $count = 5) {
        $prompt = "Generate $count multiple choice questions for a healthcare professional exam on the topic: '$topic'. 
        Return ONLY a JSON array of objects. Each object must have:
        'question': the question text,
        'options': an object with keys A, B, C, D and their values,
        'correct_answer': the key (A, B, C, or D) of the correct answer.
        Output MUST be pure JSON, no markdown formatting, no other text.";

        $response = self::generate($prompt);
        
        if ($response) {
            // Clean response if AI adds markdown blocks
            $response = trim($response);
            if (strpos($response, '```json') === 0) {
                $response = substr($response, 7, -3);
            } elseif (strpos($response, '```') === 0) {
                $response = substr($response, 3, -3);
            }
            
            $data = json_decode(trim($response), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            }
        }
        return false;
    }

    /**
     * Generate course content for a lesson
     */
    public static function generateLessonContent($courseTitle, $lessonTitle) {
        $prompt = "Write a detailed healthcare training lesson for the course '$courseTitle' on the specific topic: '$lessonTitle'. 
        The content should be professional, UK-policy aligned, and include:
        - Introduction
        - Key Principles
        - Best Practices
        - Summary.
        Use HTML formatting (h2, p, ul, li) but NO script tags and NO external CSS.";

        return self::generate($prompt);
    }
}
?>
