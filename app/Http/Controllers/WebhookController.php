<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Services\WebhookService;
use Exception;

class WebhookController extends Controller
{
    protected $webhookService;

    public function __construct(WebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    public function handle(Request $request)
    {
        Log::info('Webhook received', ['payload' => $request->all()]);

        try {
            $validated = $request->validate([
                'source' => 'required|string',
                'payload' => 'required|array',
            ], [
                'source.required' => 'source is required',
            ]);

            $source = $validated['source'];
            $payload = $validated['payload'];

            $this->webhookService->processData($source, $payload);
            return response()->json(['status' => 'success'], 200);
        } catch (ValidationException $e) {
            // Log the validation errors
            Log::warning('Validation failed', ['errors' => $e->errors()]);

            // Return a custom error response
            return response()->json([
                'status' => 'validation_error',
                'errors' => $e->errors() // This will return the specific validation errors
            ], 422);
        } catch (Exception $e) {
            Log::error(
                'Error processing webhook',
                ['exception' => $e->getMessage()]
            );
            return response()->json([
                [
                    'error' => 'Internal server error',
                    'errorMessage' => $e->getMessage()
                ]
            ], 500);
        }
    }
}
