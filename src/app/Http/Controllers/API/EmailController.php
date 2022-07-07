<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendEmail;
use Config;

class EmailController extends Controller
{
    /**
     * Send email
     *
     * @param request $request
     *
     * @return void
     */
    public function sendEmail(Request $request)
    {
        $formData = [
            'email' => $request->email,
            'first_name' => $request->first_name,
            'template_name' => $request->template_name
        ];

        $rules = [
            'email' => 'required|email',
            'first_name' => 'required',
            'template_name' => 'required'
        ];

        $validator = Validator::make($formData, $rules);

        // Check if the parameters passed are invalid
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->messages()->all(),
            ], Response::HTTP_NOT_ACCEPTABLE);
        }

        $subject = 'Email from the laravel application';
        $template = 'test';

        $data = [
            'first_name' => $request->first_name,
            'subject' => $subject,
            'contactEmail' => config('mail.from.address'),
            'template' => 'email.' . $template,
            'to' => $request->email
        ];

        SendEmail::dispatch($data);

        return response()->json([
            'status' => true,
            'message' => "Email Sent",
        ], Response::HTTP_OK);
    }
}
