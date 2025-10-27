<?php

class Utils
{
    public function fetchFromApi($apiUrl)
    {
        // Initialize cURL
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as string
        curl_setopt($ch, CURLOPT_HTTPGET, true);        // Explicit GET request

        // Optional: Set headers if needed
        // curl_setopt($ch, CURLOPT_HTTPHEADER, [
        //     'Authorization: Bearer your_token',
        //     'Accept: application/json'
        // ]);

        // Execute request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            curl_close($ch);
            return [
                'success' => false,
                'error' => curl_error($ch)
            ];
        }

        curl_close($ch);

        // Decode JSON response
        $data = json_decode($response, true);

        return [
            'success' => true,
            'data' => $data
        ];
    }

    public function fetchGraphQlFromApi($query, $variables, $apiUrl)
    {
        // Initialize cURL
        $ch = curl_init();

        // Prepare GraphQL payload
        $payload = json_encode([
            "query" => $query,
            "variables" => $variables
        ]);

        // Set cURL options
        curl_setopt_array($ch, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload, // send query as JSON
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer your_token' // optional if needed
            ]
        ]);

        // Execute request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return [
                'success' => false,
                'error' => $error
            ];
        }

        curl_close($ch);

        // Decode JSON response
        $data = json_decode($response, true);

        return $data;
    }

public function sendToApi($data, $apiUrl, $method = 'POST')
{
    try {
        // Initialize cURL
        $ch = curl_init();
        
        // Prepare the payload
        $payload = json_encode($data);
        
        // Debug: Log the request
        error_log("Contact Form - API URL: " . $apiUrl);
        error_log("Contact Form - Request Data: " . $payload);
        
        // Set cURL options
        curl_setopt_array($ch, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false, // Add this for debugging SSL issues
            CURLOPT_VERBOSE => true, // Add this for detailed debug info
        ]);
        
        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Debug: Log the response
        error_log("Contact Form - HTTP Code: " . $httpCode);
        error_log("Contact Form - Response: " . $response);
        
        // Check for cURL errors
        if (curl_errno($ch)) {
            $curlError = curl_error($ch);
            error_log("Contact Form - cURL Error: " . $curlError);
            curl_close($ch);
            return [
                'success' => false,
                'message' => 'Connection error: ' . $curlError
            ];
        }
        
        curl_close($ch);
        
        // Decode JSON response
        $decodedResponse = json_decode($response, true);
        
        // Return success if HTTP status is 2xx
        if ($httpCode >= 200 && $httpCode < 300) {
            error_log("Contact Form - Success: Message sent successfully");
            return [
                'success' => true,
                'data' => $decodedResponse,
                'message' => 'Message sent successfully'
            ];
        } else {
            $errorMsg = $decodedResponse['message'] ?? 'Failed to send message. HTTP Code: ' . $httpCode;
            error_log("Contact Form - API Error: " . $errorMsg);
            return [
                'success' => false,
                'message' => $errorMsg,
                'error' => $decodedResponse,
                'http_code' => $httpCode
            ];
        }
        
    } catch (Exception $e) {
        error_log("Contact Form - Exception: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'System error: ' . $e->getMessage()
        ];
    }
}

    public function makeSlug($string)
    {
        return str_replace(" ", "-", strtolower($string));
    }
}

?>