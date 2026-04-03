<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAdvisorController extends Controller
{
    public function advise(Request $request)
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:1000'],
            'context_type' => ['nullable', 'string', 'in:general,product,service'],
            'context_id' => ['nullable', 'integer'],
        ]);

        $contextSummary = '';

        if (($data['context_type'] ?? null) === 'product' && ! empty($data['context_id'])) {
            $product = Product::find($data['context_id']);
            if ($product) {
                $contextSummary = 'Sản phẩm: ' . $product->name . " (Giá: " . $product->price . ") - " . ($product->description ?? '');
            }
        }

        if (($data['context_type'] ?? null) === 'service' && ! empty($data['context_id'])) {
            $service = Service::find($data['context_id']);
            if ($service) {
                $contextSummary = 'Dịch vụ: ' . $service->name . ' - ' . ($service->description ?? '');
            }
        }

        $systemPrompt = 'Bạn là trợ lý AI cho cửa hàng thú cưng The Quad Pets. '
            . 'Hãy tư vấn sản phẩm và dịch vụ phù hợp cho thú cưng của khách hàng. '
            . 'Trả lời ngắn gọn, rõ ràng, bằng tiếng Việt, thân thiện và dễ hiểu. '
            . 'Nếu câu hỏi không liên quan đến thú cưng, hãy lịch sự từ chối.';

        $userPrompt = 'Câu hỏi của khách: ' . $data['question'];
        if ($contextSummary !== '') {
            $userPrompt .= "\n\nNgữ cảnh thêm: " . $contextSummary;
        }

        $apiKey = config('services.openai.key');
        $model = config('services.openai.model', 'gpt-4.1-mini');

        if (! $apiKey) {
            return response()->json([
                'error' => 'AI tạm thời chưa được cấu hình. Vui lòng liên hệ quản trị viên.',
            ], 500);
        }

        try {
            $response = Http::withToken($apiKey)
                ->timeout(15)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'temperature' => 0.7,
                ]);

            if (! $response->successful()) {
                Log::warning('AI advisor API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return response()->json([
                    'error' => 'Xin lỗi, trợ lý AI đang bận. Vui lòng thử lại sau.',
                ], 502);
            }

            $payload = $response->json();
            $answer = $payload['choices'][0]['message']['content'] ?? null;

            if (! $answer) {
                return response()->json([
                    'error' => 'Xin lỗi, trợ lý AI chưa thể trả lời ngay. Vui lòng thử lại.',
                ], 502);
            }

            return response()->json([
                'answer' => trim($answer),
            ]);
        } catch (\Throwable $e) {
            Log::error('AI advisor exception', ['message' => $e->getMessage()]);

            return response()->json([
                'error' => 'Đã xảy ra lỗi khi gọi trợ lý AI. Vui lòng thử lại sau.',
            ], 500);
        }
    }
}
