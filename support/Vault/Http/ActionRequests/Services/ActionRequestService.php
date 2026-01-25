<?php

namespace Support\Vault\Http\ActionRequests\Services;

use App\Models\ActionRequest;
use DateTime;
use Support\Mail\Mail;
use Support\Vault\Sanctum\Log;

class ActionRequestService
{
    public function generate(array $data): array
    {  
        $generateToken = $this->generateToken($data['type']);
        
        $useOldTokens = ActionRequest::where('user', $data['user'])
                                    ->where('type', $data['type'])
                                    ->get();
        foreach ($useOldTokens as $token)
        {
            $token->used = 1;
            $token->save();
        }
        $expirationDate = new DateTime(); 
        $expirationDate->modify('+ 10 minutes');
        $expirationDate = $expirationDate->format('Y-m-d H:i:s'); 

        $actionRequest = new ActionRequest;
        $actionRequest->type = $data['type'];
        $actionRequest->user = $data['user'];
        $actionRequest->email = $data['email'];
        $actionRequest->payload = json_encode($data['payload'] ?? []);
        $actionRequest->token_hash = $generateToken['tokenHash'];
        $actionRequest->expires_at = $expirationDate;
        $result = $actionRequest->save();
        
        if (!$result){
            return [
                'success' => false,
                'message' => 'error while creating request'
            ];
        }
        return [
            'success' => true,
            'message' => 'success!',
            'token' => $generateToken['token'],
            'type' => $data['type'],
            'email' => $data['email'],
        ];
    }
    public function generateToken(string $type): array
    {
        switch ($type) {
            case 'email_verification':
            case 'account_activation':
            case 'password_reset':
                $token = bin2hex(random_bytes(16));
                $tokenHash = hash('sha256', $token);

                while (ActionRequest::where('token_hash', $tokenHash)->where('used', 0)->exists()) {
                    $token = bin2hex(random_bytes(16));
                    $tokenHash = hash('sha256', $token);
                }
                break;
            
            case 'data_update':
            case 'custom_action':
                $token = (string) random_int(10000000, 99999999); 
                $tokenHash = hash('sha256', $token);

                while (ActionRequest::where('token_hash', $tokenHash)->where('used', 0)->exists()) {
                    $token = (string) random_int(10000000, 99999999); 
                    $tokenHash = hash('sha256', $token);
                }
                break;
            default:
                $token = bin2hex(random_bytes(16));
                break;
        }

        

        return [
            'token' => $token,
            'tokenHash' => $tokenHash,
        ];
    }
    public function isRequestUsed($id) {
        return ActionRequest::where('id', $id)
                            ->where('used', 0)
                            ->exists();
    }
    public function getRequestData(string $token, string $type): ?ActionRequest {
        $tokenHash = hash('sha256', $token);
    
        return ActionRequest::where('token_hash', $tokenHash)
                            ->where('type', $type)
                            ->first();
    }
    
    public function updateRequest($requestData){
        $requestData->used = 1;
        $result = $requestData->save();
        if (!$result){
            return [
                'success' => false,
                'message' => 'Error while processing'
            ];
        }
        return [
            'success' => true,
            'message' => 'User activated successfully'
        ];
    }
    public function checkUrlToken(string $token, string $type):bool {
        $tokenHash = hash('sha256', $token);
        return ActionRequest::where('token_hash', $tokenHash)->where('type', $type)->exists();
    }
    public function checkPinToken(string $token, string $type):bool {
        $tokenHash = hash('sha256', $token);
        return ActionRequest::where('token_hash', $tokenHash)
                        ->where('type', $type)
                        ->where('user', auth()->user()->unique_id)
                        ->where('used', 0)
                        ->exists();
    }
    public function sendEmail(string $email, string $token, string $type):array
    {
        $emailData = $this->switchEMailData($token, $type);
        $mail = Mail::to($email)
            ->subject($emailData['title'])
            ->body($emailData['body']);

        if (!$mail->send()) {
            Log::error("Error: " . $mail->getError());
            return [
                'success' => false,
                'message' => "Error: " . $mail->getError()
            ];
        } 
        return [
            'success' => true,
            'message' => "Email send successfully"
        ];
    }
    public function switchEmailData(string $token, string $type):array
    {
        $domain = config('app.url');
        switch ($type){
            case 'password_reset':
                $title = 'Password reset';
                $body = "Your code to finish the password reset is: <b>".$token."</b>.
                The code is valid for next 10 minutes.";
                break;
            case 'email_verification':
                $title = 'Email verification';
                $body = 'CLick link below to verify your email.
                <a href="'. $domain . '/action-request/email-verification/' . $token .'">Verify my email</a>
                The url is valid for next 10 minutes.';
                break;
            case 'data_update':
                $title = 'Data Update';
                $body = "Your code to finish updating data is: <b>".$token."</b>.
                The code is valid for next 10 minutes.";
                break;
            case 'account_activation':
                $title = 'Account Activation';
                $body = 'CLick link below to activate your account. <br>
                <a href="'. $domain . '/action-request/account-activation/' . $token .'">Activate account</a>';
                break;
            case 'custom_action':
                $title = 'Code Request';
                $body = "Your code to finish the action reset is: <b>".$token."</b>.
                The code is valid for next 10 minutes.";
                break;
            default:
                $title = 'Request';
                $body = 'CLick link below to finish the action.
                <a href="'. $domain . '/action-request/custom-action/' . $token .'">Action</a>
                The url is valid for next 10 minutes.';
                break;
        };
        
        $body2 = str_replace("\n", "<br>", $body);
        
        return [
            'title' => $title,
            'body' => $body
        ];

    }
}