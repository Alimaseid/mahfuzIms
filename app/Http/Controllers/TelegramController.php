<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramController extends Controller
{
   public function send($message){
     return $this->sendMessage(-862580501,$message,'6249933232:AAG9SlE0qhOi0_AT_dDYyz0RGlmNMPzn9K8');
   }

   public function approve($orderDetail,$order_id,$rfn){
      return $this->inlineMessage('6249933232:AAG9SlE0qhOi0_AT_dDYyz0RGlmNMPzn9K8',-1001912978088,$orderDetail,$order_id,$rfn);
   }
   private function sendMessage($chatID, $messaggio, $token) {
        echo "sending message to " . $chatID . "\n";

        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
        $url = $url . "&text=" . urlencode($messaggio);
        $ch = curl_init();
        $optArray = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private function inlineMessage($token,$chat_id,$orderDetail,$order_id,$rfn){
        $keyboard = [
            [
                ['text' => 'Approve', 'url' => 'https://ims2.merkuz.com/fromTelegramAcceptOrder/'.$order_id.'/'.$chat_id.'/'.$token.'/'.$rfn],
                ['text' => 'Reject', 'url' => 'https://ims2.merkuz.com/fromTelegramRejectOrder/'.$order_id.'/'.$chat_id.'/'.$token.'/'.$rfn]
            ]
        ];

        $reply_markup = [
            'inline_keyboard' => $keyboard
        ];

        $parameters = [
            'chat_id' => $chat_id,
            'text' => $orderDetail,
            'reply_markup' => json_encode($reply_markup)
        ];
        $response = file_get_contents('https://api.telegram.org/bot6249933232:AAG9SlE0qhOi0_AT_dDYyz0RGlmNMPzn9K8/sendMessage?' . http_build_query($parameters));

        // Decode JSON
        $rsp = file_get_contents('https://api.telegram.org/bot6249933232:AAG9SlE0qhOi0_AT_dDYyz0RGlmNMPzn9K8/getUpdates');
        $update = json_decode($rsp, true);

        // Get message text
        $text = $update['result'];
        return $text;
    }
}
