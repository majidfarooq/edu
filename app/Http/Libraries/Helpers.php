<?php


namespace App\Http\Libraries;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class Helpers
{

    /** Upload file
     * @param file $file
     * @param location
     * @return string
     */
    public function uploadFile($file = null, $location = null)
    {
        $path = '';
        if (!is_null($file) && !is_null($location)) {
            $file = $file;
            $path = $file->store('public/'.$location);
            return $path;
        }
        return $path;
    }

    public function encrypt_string($string_to_encrypt)
    {
        $id = '_'.$string_to_encrypt;
        $timestamp = time();
        $randomKey = rand();
        $key = base64_encode($timestamp . $randomKey . $id);
        return $key;
    }

    public function decrypt_string($encrypted_string)
    {
        $password=base64_decode($encrypted_string);
        $password=explode('_',$password);
        if(isset($password[1])){
            return $password[1];
        }else{
            return false;
        }
    }

    public function EduMailer($attributes){

        Mail::send($attributes['file'],['data' => $attributes],function($message) use ($attributes){
            $message->from('no-reply@edubrokers.com','edubrokers.com');
            $message->to([$attributes['email']]);
            if(isset($attributes['cc'])){
                $message->cc([$attributes['cc']]);
            }
            $message->replyTo('no-reply@edubrokers.com', $attributes['subject']);
            $message->subject($attributes['subject']);
        });
    }
}
