<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SMSMisrService
{
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $sender;
    protected $environment;

    public function __construct()
    {
        $this->baseUrl = env('SMSMISR_BASE_URL');
        $this->username = env('SMSMISR_USERNAME');
        $this->password = env('SMSMISR_PASSWORD');
        $this->sender = env('SMSMISR_SENDER');
        $this->environment = env('SMSMISR_ENVIRONMENT');
    }

    /**
     * Send an SMS message
     */
    public function sendSMS($mobile, $message)
    {
        $response = Http::post("{$this->baseUrl}/SMS/", [
            'environment' => $this->environment,
            'username' => $this->username,
            'password' => $this->password,
            'sender' => $this->sender,
            'mobile' => $mobile,
            'message' => $message,
            'language' => '2', // 1 for English, 2 for Arabic, 3 for Unicode
        ]);

        return $response->json();
    }

    /**
     * Send OTP
     */
    public function sendOTP($mobile, $otp, $template)
    {
        $response = Http::post("{$this->baseUrl}/OTP/", [
            'environment' => $this->environment,
            'username' => $this->username,
            'password' => $this->password,
            'sender' => $this->sender,
            'mobile' => $mobile,
            'template' => $template,
            'otp' => $otp,
        ]);

        return $response->json();
    }

    /**
     * Check SMS Balance
     */
    public function checkBalance()
    {
        $response = Http::get("{$this->baseUrl}/Balance/", [
            'username' => $this->username,
            'password' => $this->password,
        ]);

        return $response->json();
    }
}
