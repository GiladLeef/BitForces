<?php

class BitForcesNotificationEmail extends BitForcesNotification {
  protected     $receiver;
  public static $name = "Email";
  
  function getTemplateName() {
    return "notifications/email";
  }
  
  function getObjects() {
    $obj = array();
    $obj['username'] = Util::getUsernameById($this->notification->getUserId());
    return $obj;
  }
  
  function sendMessage($message, $subject) {
    $message = explode("##########", $message);
    Util::sendMail($this->receiver, $subject, $message[0], $message[1]);
  }
}

BitForcesNotification::add('Email', new BitForcesNotificationEmail());
