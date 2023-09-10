<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class ConvertCamelCaseToSnakeCase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Get the JSON content from the request
        $jsonContent = $request->getContent();

        // Decode the JSON content into an associative array
        $data = json_decode($jsonContent, true); 

        if ($data == null) {
            return $next($request);
        }

        

        // Convert camelCase keys to snake_case
        $snakeCaseData = $this->convertKeysToSnakeCase($data);

        // Encode the modified data back to JSON
        $jsonContent = json_encode($snakeCaseData); 

        // Replace the request content with the modified JSON
        $request->replace(json_decode($jsonContent, true)); 
        
        return $next($request);
    }

    private function convertKeysToSnakeCase($data)
    {
        $snakeCaseData = [];  

        if ($data == null) return;

        foreach ($data as $key => $value) {
            $snakeKey = Str::snake($key);
            if (is_array($value)) {
                $value = $this->convertKeysToSnakeCase($value);
            }
            $snakeCaseData[$snakeKey] = $value;
        }

        return $snakeCaseData;
    }
}
