<?php
require 'vendor/autoload.php'; // Asegúrate de que has instalado la librería de Stripe

\Stripe\Stripe::setApiKey('sk_test_51Q0vhZ051Vj2NhP2jmWLVsDE5vOCkcCDh7yUSGPoD71vqEhPCu4RM4aibEk38KQuwWBeSyPxLduMzeAJYPTf0ihD00AFvk3Crc');

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => $data['currency'],
                'product_data' => [
                    'name' => 'Total del carrito',
                ],
                'unit_amount' => $data['amount'],
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'https://tu_dominio.com/exito',
        'cancel_url' => 'https://tu_dominio.com/cancelado',
    ]);

    echo json_encode(['id' => $session->id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
