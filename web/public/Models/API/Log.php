<?php
namespace Crapblox\Models;

class Log extends ModelBase {

    // Log system used for on-site notifications
    // and also used for the admin logging functionality . .

    // Log(Message, Level)
    // ex: $Logger->Log("Test", $Log->Level->Info);
    public function Log($Message) {
        $stmt = $this->Connection->prepare(
            "INSERT INTO logs 
                    (log_message) 
                VALUES 
                    (?)"
        );
        $stmt->execute([
            $Message
        ]);
        $stmt = null;

        $webhookurl = "https://craplink.madhouselabs.net/webhook";
        $data = array('content' => $Message);
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );
        
        file_get_contents($webhookurl, false, stream_context_create($options));
    }

    public function Notify($Message, $Recipient, $Sender, $Title) {
        $stmt = $this->Connection->prepare(
            "INSERT INTO logs 
                    (log_message, log_recipient, log_sender, log_title) 
                VALUES 
                    (?, ?, ?, ?)"
        );
        $stmt->execute([
            $Message,
            $Recipient,
            $Sender,
            $Title,
        ]);
        $stmt = null;
    }

    // GetLogByMessage(Message)
    // ex: $Logger->GetLogByMessage("Test");
    public function GetLogByMessage($Message) {

    }
}