<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhySMSService
{
    protected $config;

    public function __construct()
    {
        $this->config = $this->getConfig();
    }

public function sendSMS($mobile, $message)
{
    \Log::info('sendSMS called', ['mobile' => $mobile, 'message' => $message]);

    if (!$this->config || $this->config['status'] != 1) {
        \Log::warning('WhySMS configuration invalid or disabled', ['config' => $this->config]);
        return ['status' => false, 'message' => 'WhySMS gateway not configured or disabled'];
    }

    try {
        \Log::info('Preparing to send SMS via WhySMS', [
            'url' => 'https://bulk.whysms.com/api/v3/sms/send',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->config['api_token'],
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'body' => [
                'recipient' => $mobile,
                'sender_id' => $this->config['sender_id'],
                'type' => 'plain',
                'message' => $message,
            ]
        ]);

        $token = trim($this->config['api_token']);

$response = Http::withHeaders([
    'Authorization' => 'Bearer ' . $token,
    'Accept' => 'application/json',
    'Content-Type' => 'application/json',
])->post('https://bulk.whysms.com/api/v3/sms/send', [
    'recipient' => $mobile,
    'sender_id' => $this->config['sender_id'],
    'type' => 'plain',
    'message' => $message,
]);


        \Log::info('WhySMS HTTP response received', ['status' => $response->status(), 'body' => $response->body()]);

        $res = $response->json();
        \Log::info('Parsed WhySMS response JSON', ['parsed' => $res]);

        if (isset($res['status']) && $res['status'] === 'success') {
            \Log::info('SMS sent successfully via WhySMS');
            return ['status' => true, 'message' => 'SMS sent successfully', 'data' => $res];
        }

        \Log::warning('SMS sending failed via WhySMS', ['error' => $res]);
        return ['status' => false, 'message' => 'SMS sending failed', 'error' => $res];

    } catch (\Exception $e) {
        \Log::error('Exception during SMS sending via WhySMS', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return ['status' => false, 'message' => 'Exception during sending SMS'];
    }
}


  public function sendOTP($mobile, $otp, $template = null)
{
    \Log::info('sendOTP called', [
        'mobile' => $mobile,
        'otp' => $otp,
        'input_template' => $template
    ]);

    $template = $template ?? $this->config['otp_template'] ?? 'Your OTP is #OTP#';

    \Log::info('Final OTP template used', ['template' => $template]);

    $message = str_replace('#OTP#', $otp, $template);

    \Log::info('Final OTP message prepared', ['message' => $message]);

    return $this->sendSMS($mobile, $message);
}


    public function checkBalance()
    {
        return ['status' => false, 'message' => 'WhySMS balance check not supported'];
    }

    protected function getConfig()
    {
        $setting = \DB::table('addon_settings')
            ->where('key_name', 'whysms')
            ->where('settings_type', 'sms_config')
            ->first();

        return $setting ? json_decode($setting->live_values, true) : null;
    }
}
