<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpellCheckController extends Controller
{
    /**
     * Handle the AJAX POST, call LanguageTool, and return JSON.
     */
    public function correctText(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:5000',
        ]);

        try {
            // Send form-encoded data to LanguageTool
            $response = Http::asForm()
                ->timeout(15)
                ->post('https://api.languagetool.org/v2/check', [
                    'text'        => $request->text,
                    'language'    => 'en-US',
                    'enabledOnly' => 'false',
                ]);

            $data      = $response->json();
            $corrected = $this->applyCorrections($request->text, $data['matches'] ?? []);
            $errors    = $this->formatErrors($data['matches'] ?? []);

            return response()->json(compact('corrected', 'errors'));
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Correction failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Apply the first suggested replacement for each error, from the end backwards.
     */
    private function applyCorrections(string $originalText, array $matches): string
    {
        $text = $originalText;

        foreach (array_reverse($matches) as $error) {
            $offset      = $error['offset'];
            $length      = $error['length'];
            $replacement = $error['replacements'][0]['value'] ?? null;

            if ($replacement !== null && $offset + $length <= strlen($text)) {
                $text = substr_replace($text, $replacement, $offset, $length);
            }
        }

        return $text;
    }

    /**
     * Normalize the raw LanguageTool matches into a simple array for JSON,
     * filtering out whitespace-only suggestions.
     */
    private function formatErrors(array $matches): array
    {
        return collect($matches)
            // Remove erors that are white spaces
            ->filter(function ($error) {
                $first = $error['replacements'][0]['value'] ?? '';
                return trim($first) !== '';
            })
            // Map remaining errors
            ->map(function ($error) {
                return [
                    'type'        => $error['rule']['category']['name'] ?? 'Unknown',
                    'message'     => $error['message'] ?? '',
                    'context'     => $error['context']['text'] ?? '',
                    'offset'      => $error['offset'],
                    'length'      => $error['length'],
                    'suggestions' => array_column($error['replacements'] ?? [], 'value'),
                ];
            })
            ->values() // Reindex array
            ->toArray();
    }
}
