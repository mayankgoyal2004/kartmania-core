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


    public function makeSlug($string)
    {
        return str_replace(" ", "-", strtolower($string));
    }
}


?>