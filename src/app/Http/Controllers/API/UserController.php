<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendEmail;
use App\Jobs\CreateUser;
use Config;
use Redirect;
use Session;
use App\Services\KafkaProducerService;

class UserController extends Controller
{
    public function create() 
    {
        return view('create');
    }

    /**
     * Create 
     *
     * @param request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        $formData = [
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' =>  $request->last_name,
        ];

        $rules = [
            'email' => 'required|email|unique:users',
            'first_name' => 'required',
            'last_name' => 'required'
        ];

        $validator = Validator::make($formData, $rules);

        // Check if the parameters passed are invalid
        if($validator->fails()) {
            return redirect::back()->withErrors($validator, 'create_user_form')->withInput();
        }

        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ];

        $subject = "Welcome to Queue montoring Dashboard";

        $emailData = [
            'first_name' => $request->first_name,
            'subject' => $subject,
            'contactEmail' => config('mail.from.address'),
            'template' => 'email.welcome',
            'to' => $request->email
        ];

        CreateUser::dispatch($userData)->chain([
            new SendEmail($emailData)
        ]);

        return redirect()->route('horizon.index');
    }

     /**
     * Create 
     *
     * @param request $request
     *
     * @return void
     */
    public function sendMessage(Request $request, KafkaProducerService $kafkaService)
    {
        $message = 'Hello from Laravel to Kafka!';
        $kafkaService->produceMessage($message);
        return 'Message sent to Kafka!';
    }
}
