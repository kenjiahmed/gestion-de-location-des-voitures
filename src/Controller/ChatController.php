<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    #[Route('/chat/message', name: 'app_chat_message', methods: ['POST'])]
    public function message(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $message = isset($data['message']) ? trim($data['message']) : '';

        if ('' === $message) {
            return new JsonResponse(['error' => 'Empty message'], 400);
        }

        $openaiKey = getenv('OPENAI_API_KEY') ?: ($_SERVER['OPENAI_API_KEY'] ?? null);

        if ($openaiKey) {
            try {
                $payload = [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => "Tu es un assistant utile, poli et bref. Réponds en français quand l'utilisateur parle français."],
                        ['role' => 'user', 'content' => $message],
                    ],
                    'max_tokens' => 300,
                    'temperature' => 0.6,
                ];


                $url = 'https://api.openai.com/v1/chat/completions';
                $jsonPayload = json_encode($payload);
                $headers = [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $openaiKey,
                ];

                $reply = null;

                if (function_exists('curl_version')) {
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                    $result = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $curlErr = curl_error($ch);
                    curl_close($ch);

                    if ($result !== false && ($httpCode === 200 || $httpCode === 201)) {
                        $json = json_decode($result, true);
                        if (isset($json['choices'][0]['message']['content'])) {
                            $reply = trim($json['choices'][0]['message']['content']);
                        }
                    } else {
                        // log or ignore; we'll fallback below
                    }
                } else {
                    // fallback: file_get_contents
                    $opts = [
                        'http' => [
                            'method'  => 'POST',
                            'header'  => "Content-Type: application/json\r\nAuthorization: Bearer " . $openaiKey . "\r\n",
                            'content' => $jsonPayload,
                            'timeout' => 10,
                        ]
                    ];
                    $context  = stream_context_create($opts);
                    $result = @file_get_contents($url, false, $context);
                    if ($result !== false) {
                        $json = json_decode($result, true);
                        if (isset($json['choices'][0]['message']['content'])) {
                            $reply = trim($json['choices'][0]['message']['content']);
                        }
                    }
                }

                if ($reply !== null) {
                    return new JsonResponse(['reply' => $reply]);
                }
                // else fall through to local rules

            } catch (\Exception $e) {
                // On exception, fall back to rules below. Optionally log the exception.
            }
        }

        // Fallback: simple keyword-based replies (local)
        $lower = mb_strtolower($message);

        if (strpos($lower, 'bonjour') !== false || strpos($lower, 'salut') !== false || strpos($lower, 'hello') !== false) {
            $reply = "Salut ! Je suis l'assistant. Comment puis-je t'aider aujourd'hui ?";
        } elseif (strpos($lower, 'réservation') !== false || strpos($lower, 'reservation') !== false || strpos($lower, 'reser') !== false) {
            $reply = "Pour faire une réservation, va dans le catalogue, choisis une voiture, et clique sur 'Réserver'. Veux-tu que je t'explique les étapes ?";
        } elseif (strpos($lower, 'prix') !== false || strpos($lower, 'coût') !== false || strpos($lower, 'cout') !== false) {
            $reply = "Les prix dépendent du véhicule et de la durée. Ouvre la fiche d'un véhicule pour voir le tarif journalier.";
        } else {
            $reply = "Je peux aider avec les réservations, le catalogue, ou des infos sur les véhicules. Tu as dit : \"{$message}\"";
        }

        return new JsonResponse(['reply' => $reply]);
    }
}

