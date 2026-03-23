<?php

namespace App\Services;

class MockPaymentService
{
    public function charge(string $email, float $amount): array
    {
        return [
            'success' => true,
            'transaction_id' => 'mock_' . uniqid(),
            'amount' => $amount,
            'email' => $email,
        ];
    }
}
