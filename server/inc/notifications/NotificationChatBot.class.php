<?php

class BitForcesNotificationChatBot extends BitForcesNotification {
  protected     $receiver;
  public static $name = "ChatBot";
  
  function getTemplateName() {
    return "notifications/chatbot";
  }
  
  function getObjects() {
    return array();
  }
  
  function sendMessage($message, $subject = "") {
    $username = APP_NAME;
    $data = "payload=" . json_encode(array(
          "username" => $username,
          "text" => $message
        )
      );
    
    $ch = curl_init($this->receiver);
    
    if (SConfig::getInstance()->getVal(DConfig::NOTIFICATIONS_PROXY_ENABLE) == 1) {
      curl_setopt($ch, CURLOPT_PROXY, SConfig::getInstance()->getVal(DConfig::NOTIFICATIONS_PROXY_SERVER));
      curl_setopt($ch, CURLOPT_PROXYPORT, SConfig::getInstance()->getVal(DConfig::NOTIFICATIONS_PROXY_PORT));
      $type = CURLPROXY_HTTP;
      switch (SConfig::getInstance()->getVal(DConfig::NOTIFICATIONS_PROXY_TYPE)) {
        case DProxyTypes::HTTPS:
          $type = CURLPROXY_HTTPS;
          break;
        case DProxyTypes::SOCKS4:
          $type = CURLPROXY_SOCKS4;
          break;
        case DProxyTypes::SOCKS5:
          $type = CURLPROXY_SOCKS5;
          break;
      }
      curl_setopt($ch, CURLOPT_PROXYTYPE, $type);
      curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, "true");
    }
    
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    
    return $result;
  }
}

BitForcesNotification::add('ChatBot', new BitForcesNotificationChatBot());

