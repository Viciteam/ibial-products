<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use GuzzleHttp\Client;
use Closure;

class checktoken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $baseUrl = env('ACCOUNTS_URL');
        
        $getToken = $request->header();
        $token = $getToken['authorization'][0];

        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNTNhOGUyN2VjYzAyZmRjMzY1ZGUyZjA5MGNlNzA5YjQxM2NlYjJjNTZjZDBhOTAwODY4MjFlNzY3OWMxYTVlOWQzOWY1ZDczMjM4ZjZhNjkiLCJpYXQiOjE1OTc3Mjc3MTcsIm5iZiI6MTU5NzcyNzcxNywiZXhwIjoxNjI5MjYzNzE2LCJzdWIiOiIxMDI5Iiwic2NvcGVzIjpbXX0.JQGdXYI2KqvR6BymQ_RkA2kmL53psm_Ynib8eciQtSPae803VyH8laFUWavRJUAMo90jIWnWUkrj5qst-Q8vj1CIcjit0coiekATOl9MTDpeLDRD7nnO_hbuXt74lLNaf6N9zlfBNZX77LGGeSWcL1NqvQFL3T26Vtgzzu7w_uhWp5tz25NM2uE4FZM1HkofEVpD1tHiqYUw4sU9OqibitH-9VlucRLOeSOBfBlnEcFbpZTD5IeRcIrVJoO5diTQrurUFs9ebzhkXMvMJkiv4VqJcypsOIejJT-V3_bLOhzVKxkmP_OKq-KkIRC19UIYKuXP0qvFvqEL3CPF9G9NXY_fpsHUbyBLUmdhDr5uD-qQU5HDldDljUIUnrIAoxxSPM3cTRsvQy18CZhfFrLC0rlRDkLwfh3xKoUsCc279nhWlVarFey8wptiMAgRzbMZ9xWQFCzCctIg4EaodFCDZntKh9JKLfkN546FGdWLKbKPifnNlVtmsMCL6szYrPcUYx8q4HSXbs7H4A0Qq1LJTm89seki75p_dfySCbKsgrAflNEZI5WV7qABgcu-wOjLvMPj47j5jvN9DvRWXvQAyUSL98x7CRU969poDPW6oSlmZl7sdKBQAvSDdbD_jJdOvnMg4IX2MJdB0qywlYiNfm-GCJQf49QGKuKkNVQHymw',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYmFmZWQ1OTcxMWRiZWFhMTdkOTYzYzczMzlmMzNkZDU4ZjM3ZjY3MjkwYWFhOGYwMWU5OWQ2NzA2NTNhMzdkY2MzNTkyOTg1NjY3YThjYTgiLCJpYXQiOjE1OTk4MDMxMDIsIm5iZiI6MTU5OTgwMzEwMiwiZXhwIjoxNjMxMzM5MTAyLCJzdWIiOiIxMDI5Iiwic2NvcGVzIjpbXX0.tMu5XlO4zWorftukiR0fzeOKuTeTeR7Y_xXdMf59lOJNW439tmJoLEegLtB0gGex7JTe6tCRLjgSaGtXQ3Y5-sJC1zjbFONmYrCVksUxf44_U3V5BXZNB0u2bAfQtL1DIGkEEzhu8aQ9F52rHOJd9jCqRFDIaB1DRAIGlifGcSC-JejFBMVKHoAcNLOghD8pFLXEI7LzfF7H4Kh_AFmCg-UbLB1MyUBpqrAC8t9ZA-8hIGfNNOvNpUkDNiH8OF3S3Ad-qfF86tvMqurhw_QgOgzKJJBZgNXZt5LzdT5Ler172tfWepOrSOmgc_4MCbCtYm-cEgWT4LEcts_Z-el5ZeIxL8N7zWvEe9inIuk6RuSbRYjwm5KmlbaDrKkZ-XWPuboyHhTQoR5UcHaPXhjv5kGtAuhZXJXV_3UbtvXRj8fAFyKHBQ_-iL0TXm32sJS03aaWiclA0ZrwKSJlQ3jnMadvOP8wzPyOCKOIhv60rXFqmOrH7NUvAFrpQoZn_0HOvk5EUMQ7mIXELrWf5BYFoxcUEh3vD8f8ZQkXqhn1ZV7gLsnT21MzpdfSr52zfWKV9dTlGOw4XMLZTAf12SkhEJOexiDKUt95SoC3HKr5OxGvGZ3PsDeHwOlW4NkCKwbvNFOFKOwE0ilmvLw6gJurnBrwRPxcsSf0HFCFmf1N9j0',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl."/api/v1/getUser");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            'Access-Control-Allow-Origin: *',
            "Accept:application/json",
            'Authorization: '.$token,
        ));

        $output = curl_exec($ch);
        curl_close($ch);

        $output = json_decode($output);

        if(isset($output->message)){
            return response()->json([
                'message' => $output->message,
                'status' => '401',
            ]);
        }
        
        $request->request->add(['user_id' => $output->success->id]);
        return $next($request);
        // dump($output);
        // dump($request);
        // return response()->json('Invalid Token', 401);

        
        // $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');
        // $response = $client->post('/api/v1/getUser', $headers);
        
        // try {
        //     $response = $client->post('/api/v1/getUser', $headers);
        // }catch (\GuzzleHttp\Exception\BadResponseException $e) {
        //     dump(json_decode($e->getResponse()->getBody()->getContents()));
        // }

        // $response = json_decode($response);

        // dump($response);
        // dump($response->getStatusCode());
        // dump($response->getHeaderLine('content-type'));
        // dump($response->getBody());


        // $getAuth = $request->header();
        // dump($getAuth['authorization'][0]);


        // exit;

        // return $next($request);
        // return response()->json([
        //     'name' => 'Abigail',
        //     'state' => 'CA',
        // ]);
    }
}
