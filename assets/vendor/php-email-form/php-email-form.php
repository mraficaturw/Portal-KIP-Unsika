<?php

class PHP_Email_Form {
    public $ajax = false;
    public $to;
    public $from_name;
    public $from_email;
    public $subject;
    public $smtp = null;
    private $messages = [];

    public function add_message($message, $label = '', $length = 0) {
        $this->messages[] = [
            'message' => $message,
            'label' => $label,
            'length' => $length
        ];
    }

    public function send() {
        // Build email body from messages
        $body = '';
        foreach ($this->messages as $msg) {
            $body .= $msg['label'] . ': ' . $msg['message'] . "\n";
        }

        // Set headers
        $headers = 'From: ' . $this->from_name . ' <' . $this->from_email . '>' . "\r\n";
        $headers .= 'Reply-To: ' . $this->from_email . "\r\n";
        $headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";

        // Send email using PHP mail function
        $success = mail($this->to, $this->subject, $body, $headers);

        // Return response based on ajax setting
        if ($this->ajax) {
            return json_encode([
                'success' => $success,
                'message' => $success ? 'Email sent successfully' : 'Failed to send email'
            ]);
        } else {
            return $success ? 'Email sent successfully' : 'Failed to send email';
        }
    }
}

?>
