<?php
if (version_compare(PHP_VERSION, '5.0.0', '<') ) exit("Sorry, this version of PHPMailer will only run on PHP version 5 or greater!\n");

/** @ignore */
class PHPMailer
{
  /**
   * Email priority (1 = High, 3 = Normal, 5 = low).
   * @var int
   */
  public $Priority          = 3;

  /**
   * Sets the CharSet of the message.
   * @var string
   */
  public $CharSet           = 'UTF-8';

  /**
   * Sets the Content-type of the message.
   * @var string
   */
  public $ContentType       = 'text/html';

  /**
   * Sets the Encoding of the message. Options for this are
   *  "8bit", "7bit", "binary", "base64", and "quoted-printable".
   * @var string
   */
  public $Encoding          = '8bit';

  /**
   * Holds the most recent mailer error message.
   * @var string
   */
  public $ErrorInfo         = '';

  /**
   * Sets the From email address for the message.
   * @var string
   */
  public $From              = 'root@localhost';

  /**
   * Sets the From name of the message.
   * @var string
   */
  public $FromName          = 'Root User';

  /**
   * Sets the Sender email (Return-Path) of the message.  If not empty,
   * will be sent via -f to sendmail or as 'MAIL FROM' in smtp mode.
   * @var string
   */
  public $Sender            = '';

  /**
   * Sets the Subject of the message.
   * @var string
   */
  public $Subject           = '';

  /**
   * Sets the Body of the message.  This can be either an HTML or text body.
   * If HTML then run IsHTML(true).
   * @var string
   */
  public $Body              = '';

  /**
   * Sets the text-only body of the message.  This automatically sets the
   * email to multipart/alternative.  This body can be read by mail
   * clients that do not have HTML email capability such as mutt. Clients
   * that can read HTML will view the normal Body.
   * @var string
   */
  public $AltBody           = '';

  /**
   * Sets word wrapping on the body of the message to a given number of
   * characters.
   * @var int
   */
  public $WordWrap          = 0;

  /**
   * Method to send mail: ("mail", "sendmail", or "smtp").
   * @var string
   */
  public $Mailer            = 'smtp';

  /**
   * Sets the path of the sendmail program.
   * @var string
   */
  public $Sendmail          = '/usr/sbin/sendmail';

  /**
   * Path to PHPMailer plugins.  Useful if the SMTP class
   * is in a different directory than the PHP include path.
   * @var string
   */
  public $PluginDir         = '';

  /**
   * Sets the email address that a reading confirmation will be sent.
   * @var string
   */
  public $ConfirmReadingTo  = '';

  /**
   * Sets the hostname to use in Message-Id and Received headers
   * and as default HELO string. If empty, the value returned
   * by SERVER_NAME is used or 'localhost.localdomain'.
   * @var string
   */
  public $Hostname          = '';

  /**
   * Sets the message ID to be used in the Message-Id header.
   * If empty, a unique id will be generated.
   * @var string
   */
  public $MessageID         = '';

  /////////////////////////////////////////////////
  // PROPERTIES FOR SMTP
  /////////////////////////////////////////////////

  /**
   * Sets the SMTP hosts.  All hosts must be separated by a
   * semicolon.  You can also specify a different port
   * for each host by using this format: [hostname:port]
   * (e.g. "smtp1.example.com:25;smtp2.example.com").
   * Hosts will be tried in order.
   * @var string
   */
  public $Host          = 'localhost';

  /**
   * Sets the default SMTP server port.
   * @var int
   */
  public $Port          = 25;

  /**
   * Sets the SMTP HELO of the message (Default is $Hostname).
   * @var string
   */
  public $Helo          = '';

  /**
   * Sets connection prefix.
   * Options are "", "ssl" or "tls"
   * @var string
   */
  public $SMTPSecure    = '';

  /**
   * Sets SMTP authentication. Utilizes the Username and Password variables.
   * @var bool
   */
  public $SMTPAuth      = true;

  /**
   * Sets SMTP username.
   * @var string
   */
  public $Username      = '';

  /**
   * Sets SMTP password.
   * @var string
   */
  public $Password      = '';

  /**
   * Sets the SMTP server timeout in seconds.
   * This function will not work with the win32 version.
   * @var int
   */
  public $Timeout       = 10;

  /**
   * Sets SMTP class debugging on or off.
   * @var bool
   */
  public $SMTPDebug     = false;

  /**
   * Prevents the SMTP connection from being closed after each mail
   * sending.  If this is set to true then to close the connection
   * requires an explicit call to SmtpClose().
   * @var bool
   */
  public $SMTPKeepAlive = false;

  /**
   * Provides the ability to have the TO field process individual
   * emails, instead of sending to entire TO addresses
   * @var bool
   */
  public $SingleTo      = false;

  /**
   * Provides the ability to change the line ending
   * @var string
   */
  public $LE              = "\n";

  /**
   * Sets the PHPMailer Version number
   * @var string
   */
  public $Version         = '5.0.2';

  /////////////////////////////////////////////////
  // PROPERTIES, PRIVATE AND PROTECTED
  /////////////////////////////////////////////////

  private   $smtp           = NULL;
  private   $to             = array();
  private   $cc             = array();
  private   $bcc            = array();
  private   $ReplyTo        = array();
  private   $all_recipients = array();
  private   $attachment     = array();
  private   $CustomHeader   = array();
  private   $message_type   = '';
  private   $boundary       = array();
  protected $language       = array();
  private   $error_count    = 0;
  private   $sign_cert_file = "";
  private   $sign_key_file  = "";
  private   $sign_key_pass  = "";
  private   $exceptions     = false;

  /////////////////////////////////////////////////
  // CONSTANTS
  /////////////////////////////////////////////////

  const STOP_MESSAGE = 0; // message only, continue processing
  const STOP_CONTINUE = 1; // message?, likely ok to continue processing
  const STOP_CRITICAL = 2; // message, plus full stop, critical error reached

  /////////////////////////////////////////////////
  // METHODS, VARIABLES
  /////////////////////////////////////////////////

  /**
   * Constructor
   * @param boolean $exceptions Should we throw external exceptions?
   */
  public function __construct($exceptions = false) {
    $this->exceptions = ($exceptions == true);
  }

  /**
   * Sets message type to HTML.
   * @param bool $ishtml
   * @return void
   */
  public function IsHTML($ishtml = true) {
    if ($ishtml) {
      $this->ContentType = 'text/html';
    } else {
      $this->ContentType = 'text/plain';
    }
  }

  /**
   * Sets Mailer to send message using SMTP.
   * @return void
   */
  public function IsSMTP() {
    $this->Mailer = 'smtp';
  }

  /**
   * Sets Mailer to send message using PHP mail() function.
   * @return void
   */
  public function IsMail() {
    $this->Mailer = 'mail';
  }

  /**
   * Sets Mailer to send message using the $Sendmail program.
   * @return void
   */
  public function IsSendmail() {
    if (!stristr(ini_get('sendmail_path'), 'sendmail')) {
      $this->Sendmail = '/var/qmail/bin/sendmail';
    }
    $this->Mailer = 'sendmail';
  }

  /**
   * Sets Mailer to send message using the qmail MTA.
   * @return void
   */
  public function IsQmail() {
    if (stristr(ini_get('sendmail_path'), 'qmail')) {
      $this->Sendmail = '/var/qmail/bin/sendmail';
    }
    $this->Mailer = 'sendmail';
  }

  /////////////////////////////////////////////////
  // METHODS, RECIPIENTS
  /////////////////////////////////////////////////

  /**
   * Adds a "To" address.
   * @param string $address
   * @param string $name
   * @return boolean true on success, false if address already used
   */
  public function AddAddress($address, $name = '') {
    return $this->AddAnAddress('to', $address, $name);
  }

  /**
   * Adds a "Cc" address.
   * Note: this function works with the SMTP mailer on win32, not with the "mail" mailer.
   * @param string $address
   * @param string $name
   * @return boolean true on success, false if address already used
   */
  public function AddCC($address, $name = '') {
    return $this->AddAnAddress('cc', $address, $name);
  }

  /**
   * Adds a "Bcc" address.
   * Note: this function works with the SMTP mailer on win32, not with the "mail" mailer.
   * @param string $address
   * @param string $name
   * @return boolean true on success, false if address already used
   */
  public function AddBCC($address, $name = '') {
    return $this->AddAnAddress('bcc', $address, $name);
  }

  /**
   * Adds a "Reply-to" address.
   * @param string $address
   * @param string $name
   * @return boolean
   */
  public function AddReplyTo($address, $name = '') {
    return $this->AddAnAddress('ReplyTo', $address, $name);
  }

  /**
   * Adds an address to one of the recipient arrays
   * Addresses that have been added already return false, but do not throw exceptions
   * @param string $kind One of 'to', 'cc', 'bcc', 'ReplyTo'
   * @param string $address The email address to send to
   * @param string $name
   * @return boolean true on success, false if address already used or invalid in some way
   * @access private
   */
  private function AddAnAddress($kind, $address, $name = '') {
    if (!preg_match('/^(to|cc|bcc|ReplyTo)$/', $kind)) {
      echo 'Invalid recipient array: ' . kind;
      return false;
    }
    $address = trim($address);
    $name = trim(preg_replace('/[\r\n]+/', '', $name)); //Strip breaks and trim
    if (!self::ValidateAddress($address)) {
      $this->SetError($this->Lang('invalid_address').': '. $address);
      if ($this->exceptions) {
        throw new phpmailerException($this->Lang('invalid_address').': '.$address);
      }
      echo $this->Lang('invalid_address').': '.$address;
      return false;
    }
  if ($kind != 'ReplyTo') {
    if (!isset($this->all_recipients[strtolower($address)])) {
        array_push($this->$kind, array($address, $name));
        $this->all_recipients[strtolower($address)] = true;
    return true;
      }
  } else {
    if (!array_key_exists(strtolower($address), $this->ReplyTo)) {
        $this->ReplyTo[strtolower($address)] = array($address, $name);
    return true;
    }
  }
    return false;
  }

/**
 * Set the From and FromName properties
 * @param string $address
 * @param string $name
 * @return boolean
 */
  public function SetFrom($address, $name = '') {
    $address = trim($address);
    $name = trim(preg_replace('/[\r\n]+/', '', $name)); //Strip breaks and trim
    if (!self::ValidateAddress($address)) {
      $this->SetError($this->Lang('invalid_address').': '. $address);
      if ($this->exceptions) {
        throw new phpmailerException($this->Lang('invalid_address').': '.$address);
      }
      echo $this->Lang('invalid_address').': '.$address;
      return false;
    }
  $this->From = $address;
  $this->FromName = $name;
  return true;
  }

  /**
   * Check that a string looks roughly like an email address should
   * Static so it can be used without instantiation
   * Tries to use PHP built-in validator in the filter extension (from PHP 5.2), falls back to a reasonably competent regex validator
   * Conforms approximately to RFC2822
   * @link http://www.hexillion.com/samples/#Regex Original pattern found here
   * @param string $address The email address to check
   * @return boolean
   * @static
   * @access public
   */
  public static function ValidateAddress($address) {
    if (function_exists('filter_var')) { //Introduced in PHP 5.2
      if(filter_var($address, FILTER_VALIDATE_EMAIL) === FALSE) {
        return false;
      } else {
        return true;
      }
    } else {
      return preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $address);
    }
  }

  /////////////////////////////////////////////////
  // METHODS, MAIL SENDING
  /////////////////////////////////////////////////

  /**
   * Creates message and assigns Mailer. If the message is
   * not sent successfully then it returns false.  Use the ErrorInfo
   * variable to view description of the error.
   * @return bool
   */
  public function Send() {
    try {
      if ((count($this->to) + count($this->cc) + count($this->bcc)) < 1) {
        throw new phpmailerException($this->Lang('provide_address'), self::STOP_CRITICAL);
      }

      // Set whether the message is multipart/alternative
      if(!empty($this->AltBody)) {
        $this->ContentType = 'multipart/alternative';
      }

      $this->error_count = 0; // reset errors
      $this->SetMessageType();
      $header = $this->CreateHeader();
      $body = $this->CreateBody();

      if (empty($this->Body)) {
        throw new phpmailerException($this->Lang('empty_message'), self::STOP_CRITICAL);
      }

      // Choose the mailer and send through it
      switch($this->Mailer)
      {
      	case 'smtp':
          return $this->SmtpSend($header, $body);break;
        case 'sendmail':
          return $this->SendmailSend($header, $body);break;
        case 'mail': break;
        default:
          return $this->MailSend($header, $body);
      }

    } catch (phpmailerException $e) {
      $this->SetError($e->getMessage());
      if ($this->exceptions) {
        throw $e;
      }
      echo $e->getMessage()."\n";
      return false;
    }
  }

  /**
   * Sends mail using the $Sendmail program.
   * @param string $header The message headers
   * @param string $body The message body
   * @access protected
   * @return bool
   */
  protected function SendmailSend($header, $body) {
    if ($this->Sender != '') {
      $sendmail = sprintf("%s -oi -f %s -t", escapeshellcmd($this->Sendmail), escapeshellarg($this->Sender));
    } else {
      $sendmail = sprintf("%s -oi -t", escapeshellcmd($this->Sendmail));
    }
    if(!@$mail = popen($sendmail, 'w')) {
      throw new phpmailerException($this->Lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
    }
    fputs($mail, $header);
    fputs($mail, $body);
    $result = pclose($mail);
    if($result != 0) {
      throw new phpmailerException($this->Lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
    }
    return true;
  }

  /**
   * Sends mail using the PHP mail() function.
   * @param string $header The message headers
   * @param string $body The message body
   * @access protected
   * @return bool
   */
  protected function MailSend($header, $body) {
    $toArr = array();
    foreach($this->to as $t) {
      $toArr[] = $this->AddrFormat($t);
    }
    $to = implode(', ', $toArr);

    $params = sprintf("-oi -f %s", $this->Sender);
    if ($this->Sender != '' && strlen(ini_get('safe_mode'))< 1) {
      $old_from = ini_get('sendmail_from');
      ini_set('sendmail_from', $this->Sender);
      if ($this->SingleTo === true && count($toArr) > 1) {
        foreach ($toArr as $key => $val) {
          $rt = @mail($val, $this->EncodeHeader($this->SecureHeader($this->Subject)), $body, $header, $params);
        }
      } else {
        $rt = @mail($to, $this->EncodeHeader($this->SecureHeader($this->Subject)), $body, $header, $params);
      }
    } else {
      if ($this->SingleTo === true && count($toArr) > 1) {
        foreach ($toArr as $key => $val) {
          $rt = @mail($val, $this->EncodeHeader($this->SecureHeader($this->Subject)), $body, $header, $params);
        }
      } else {
        $rt = @mail($to, $this->EncodeHeader($this->SecureHeader($this->Subject)), $body, $header);
      }
    }
    if (isset($old_from)) {
      ini_set('sendmail_from', $old_from);
    }
    if(!$rt) {
      throw new phpmailerException($this->Lang('instantiate'), self::STOP_CRITICAL);
    }
    return true;
  }

  /**
   * Sends mail via SMTP using PhpSMTP
   * Returns false if there is a bad MAIL FROM, RCPT, or DATA input.
   * @param string $header The message headers
   * @param string $body The message body
   * @uses SMTP
   * @access protected
   * @return bool
   */
  protected function SmtpSend($header, $body)
  {
    //require_once $this->PluginDir . 'class.smtp.php';
    $bad_rcpt = array();

    if(!$this->SmtpConnect())
    {
      throw new phpmailerException($this->Lang('smtp_connect_failed'), self::STOP_CRITICAL);
    }
    $smtp_from = ($this->Sender == '') ? $this->From : $this->Sender;
    if(!$this->smtp->Mail($smtp_from)) {
      throw new phpmailerException($this->Lang('from_failed') . $smtp_from, self::STOP_CRITICAL);
    }

    // Attempt to send attach all recipients
    foreach($this->to as $to) {
      if (!$this->smtp->Recipient($to[0])) {
        $bad_rcpt[] = $to[0];
      }
    }
    foreach($this->cc as $cc) {
      if (!$this->smtp->Recipient($cc[0])) {
        $bad_rcpt[] = $cc[0];
      }
    }
    foreach($this->bcc as $bcc) {
      if (!$this->smtp->Recipient($bcc[0])) {
        $bad_rcpt[] = $bcc[0];
      }
    }
    if (count($bad_rcpt) > 0 ) { //Create error message for any bad addresses
      $badaddresses = implode(', ', $bad_rcpt);
      throw new phpmailerException($this->Lang('recipients_failed') . $badaddresses);
    }
    if(!$this->smtp->Data($header . $body)) {
      throw new phpmailerException($this->Lang('data_not_accepted'), self::STOP_CRITICAL);
    }
    if($this->SMTPKeepAlive == true) {
      $this->smtp->Reset();
    }
    return true;
  }

  /**
   * Initiates a connection to an SMTP server.
   * Returns false if the operation failed.
   * @uses SMTP
   * @access public
   * @return bool
   */
  public function SmtpConnect() {
    if(is_null($this->smtp)) {
      $this->smtp = new SMTP();
    }

    $this->smtp->do_debug = $this->SMTPDebug;
    $hosts = explode(';', $this->Host);
    $index = 0;
    $connection = $this->smtp->Connected();

    // Retry while there is no connection
    try {
      while($index < count($hosts) && !$connection) {
        $hostinfo = array();
        if (preg_match('/^(.+):([0-9]+)$/', $hosts[$index], $hostinfo)) {
          $host = $hostinfo[1];
          $port = $hostinfo[2];
        } else {
          $host = $hosts[$index];
          $port = $this->Port;
        }

        $tls = ($this->SMTPSecure == 'tls');
        $ssl = ($this->SMTPSecure == 'ssl');

        if ($this->smtp->Connect(($ssl ? 'ssl://':'').$host, $port, $this->Timeout)) {

          $hello = ($this->Helo != '' ? $this->Helo : $this->ServerHostname());
          $this->smtp->Hello($hello);

          if ($tls) {
            if (!$this->smtp->StartTLS()) {
              throw new phpmailerException($this->Lang('tls'));
            }

            //We must resend HELO after tls negotiation
            $this->smtp->Hello($hello);
          }

          $connection = true;
          if ($this->SMTPAuth) {
            if (!$this->smtp->Authenticate($this->Username, $this->Password)) {
              throw new phpmailerException($this->Lang('authenticate'));
            }
          }
        }
        $index++;
        if (!$connection) {
          throw new phpmailerException($this->Lang('connect_host'));
        }
      }
    } catch (phpmailerException $e) {
      $this->smtp->Reset();
      throw $e;
    }
    return true;
  }

  /**
   * Closes the active SMTP session if one exists.
   * @return void
   */
  public function SmtpClose() {
    if(!is_null($this->smtp)) {
      if($this->smtp->Connected()) {
        $this->smtp->Quit();
        $this->smtp->Close();
      }
    }
  }

  /**
  * Sets the language for all class error messages.
  * Returns false if it cannot load the language file.  The default language is English.
  * @param string $langcode ISO 639-1 2-character language code (e.g. Portuguese: "br")
  * @param string $lang_path Path to the language file directory
  * @access public
  */
  function SetLanguage($langcode = 'en', $lang_path = 'language/') {
    //Define full set of translatable strings
    $PHPMAILER_LANG = array(
      'provide_address' => 'You must provide at least one recipient email address.',
      'mailer_not_supported' => ' mailer is not supported.',
      'execute' => 'Could not execute: ',
      'instantiate' => 'Could not instantiate mail function.',
      'authenticate' => 'SMTP Error: Could not authenticate.',
      'from_failed' => 'The following From address failed: ',
      'recipients_failed' => 'SMTP Error: The following recipients failed: ',
      'data_not_accepted' => 'SMTP Error: Data not accepted.',
      'connect_host' => 'SMTP Error: Could not connect to SMTP host.',
      'file_access' => 'Could not access file: ',
      'file_open' => 'File Error: Could not open file: ',
      'encoding' => 'Unknown encoding: ',
      'signing' => 'Signing Error: ',
      'smtp_error' => 'SMTP server error: ',
      'empty_message' => 'Message body empty',
      'invalid_address' => 'Invalid address',
      'variable_set' => 'Cannot set or reset variable: '
    );
    //Overwrite language-specific strings. This way we'll never have missing translations - no more "language string failed to load"!
//    $l = true;
//    if ($langcode != 'en') { //There is no English translation file
//      $l = @include $lang_path.'phpmailer.lang-'.$langcode.'.php';
//    }
    $this->language = $PHPMAILER_LANG;
//    return ($l == true); //Returns false if language not found
	return true;
  }

  /**
  * Return the current array of language strings
  * @return array
  */
  public function GetTranslations() {
    return $this->language;
  }

  /////////////////////////////////////////////////
  // METHODS, MESSAGE CREATION
  /////////////////////////////////////////////////

  /**
   * Creates recipient headers.
   * @access public
   * @return string
   */
  public function AddrAppend($type, $addr) {
    $addr_str = $type . ': ';
    $addresses = array();
    foreach ($addr as $a) {
      $addresses[] = $this->AddrFormat($a);
    }
    $addr_str .= implode(', ', $addresses);
    $addr_str .= $this->LE;

    return $addr_str;
  }

  /**
   * Formats an address correctly.
   * @access public
   * @return string
   */
  public function AddrFormat($addr) {
    if (empty($addr[1])) {
      return $this->SecureHeader($addr[0]);
    } else {
      return $this->EncodeHeader($this->SecureHeader($addr[1]), 'phrase') . " <" . $this->SecureHeader($addr[0]) . ">";
    }
  }

  /**
   * Wraps message for use with mailers that do not
   * automatically perform wrapping and for quoted-printable.
   * Original written by philippe.
   * @param string $message The message to wrap
   * @param integer $length The line length to wrap to
   * @param boolean $qp_mode Whether to run in Quoted-Printable mode
   * @access public
   * @return string
   */
  public function WrapText($message, $length, $qp_mode = false) {
    $soft_break = ($qp_mode) ? sprintf(" =%s", $this->LE) : $this->LE;
    // If utf-8 encoding is used, we will need to make sure we don't
    // split multibyte characters when we wrap
    $is_utf8 = (strtolower($this->CharSet) == "utf-8");

    $message = $this->FixEOL($message);
    if (substr($message, -1) == $this->LE) {
      $message = substr($message, 0, -1);
    }

    $line = explode($this->LE, $message);
    $message = '';
    for ($i=0 ;$i < count($line); $i++) {
      $line_part = explode(' ', $line[$i]);
      $buf = '';
      for ($e = 0; $e<count($line_part); $e++) {
        $word = $line_part[$e];
        if ($qp_mode and (strlen($word) > $length)) {
          $space_left = $length - strlen($buf) - 1;
          if ($e != 0) {
            if ($space_left > 20) {
              $len = $space_left;
              if ($is_utf8) {
                $len = $this->UTF8CharBoundary($word, $len);
              } elseif (substr($word, $len - 1, 1) == "=") {
                $len--;
              } elseif (substr($word, $len - 2, 1) == "=") {
                $len -= 2;
              }
              $part = substr($word, 0, $len);
              $word = substr($word, $len);
              $buf .= ' ' . $part;
              $message .= $buf . sprintf("=%s", $this->LE);
            } else {
              $message .= $buf . $soft_break;
            }
            $buf = '';
          }
          while (strlen($word) > 0) {
            $len = $length;
            if ($is_utf8) {
              $len = $this->UTF8CharBoundary($word, $len);
            } elseif (substr($word, $len - 1, 1) == "=") {
              $len--;
            } elseif (substr($word, $len - 2, 1) == "=") {
              $len -= 2;
            }
            $part = substr($word, 0, $len);
            $word = substr($word, $len);

            if (strlen($word) > 0) {
              $message .= $part . sprintf("=%s", $this->LE);
            } else {
              $buf = $part;
            }
          }
        } else {
          $buf_o = $buf;
          $buf .= ($e == 0) ? $word : (' ' . $word);

          if (strlen($buf) > $length and $buf_o != '') {
            $message .= $buf_o . $soft_break;
            $buf = $word;
          }
        }
      }
      $message .= $buf . $this->LE;
    }

    return $message;
  }

  /**
   * Finds last character boundary prior to maxLength in a utf-8
   * quoted (printable) encoded string.
   * Original written by Colin Brown.
   * @access public
   * @param string $encodedText utf-8 QP text
   * @param int    $maxLength   find last character boundary prior to this length
   * @return int
   */
  public function UTF8CharBoundary($encodedText, $maxLength) {
    $foundSplitPos = false;
    $lookBack = 3;
    while (!$foundSplitPos) {
      $lastChunk = substr($encodedText, $maxLength - $lookBack, $lookBack);
      $encodedCharPos = strpos($lastChunk, "=");
      if ($encodedCharPos !== false) {
        // Found start of encoded character byte within $lookBack block.
        // Check the encoded byte value (the 2 chars after the '=')
        $hex = substr($encodedText, $maxLength - $lookBack + $encodedCharPos + 1, 2);
        $dec = hexdec($hex);
        if ($dec < 128) { // Single byte character.
          // If the encoded char was found at pos 0, it will fit
          // otherwise reduce maxLength to start of the encoded char
          $maxLength = ($encodedCharPos == 0) ? $maxLength :
          $maxLength - ($lookBack - $encodedCharPos);
          $foundSplitPos = true;
        } elseif ($dec >= 192) { // First byte of a multi byte character
          // Reduce maxLength to split at start of character
          $maxLength = $maxLength - ($lookBack - $encodedCharPos);
          $foundSplitPos = true;
        } elseif ($dec < 192) { // Middle byte of a multi byte character, look further back
          $lookBack += 3;
        }
      } else {
        // No encoded character found
        $foundSplitPos = true;
      }
    }
    return $maxLength;
  }


  /**
   * Set the body wrapping.
   * @access public
   * @return void
   */
  public function SetWordWrap() {
    if($this->WordWrap < 1) {
      return;
    }

    switch($this->message_type) {
      case 'alt':
      case 'alt_attachments':
        $this->AltBody = $this->WrapText($this->AltBody, $this->WordWrap);
        break;
      default:
        $this->Body = $this->WrapText($this->Body, $this->WordWrap);
        break;
    }
  }

  /**
   * Assembles message header.
   * @access public
   * @return string The assembled header
   */
  public function CreateHeader() {
    $result = '';

    // Set the boundaries
    $uniq_id = md5(uniqid(time()));
    $this->boundary[1] = 'b1_' . $uniq_id;
    $this->boundary[2] = 'b2_' . $uniq_id;

    $result .= $this->HeaderLine('Date', self::RFCDate());
    if($this->Sender == '') {
      $result .= $this->HeaderLine('Return-Path', trim($this->From));
    } else {
      $result .= $this->HeaderLine('Return-Path', trim($this->Sender));
    }

    // To be created automatically by mail()
    if($this->Mailer != 'mail') {
      if(count($this->to) > 0) {
        $result .= $this->AddrAppend('To', $this->to);
      } elseif (count($this->cc) == 0) {
        $result .= $this->HeaderLine('To', 'undisclosed-recipients:;');
      }
    }

    $from = array();
    $from[0][0] = trim($this->From);
    $from[0][1] = $this->FromName;
    $result .= $this->AddrAppend('From', $from);

    // sendmail and mail() extract Cc from the header before sending
    if(count($this->cc) > 0) {
      $result .= $this->AddrAppend('Cc', $this->cc);
    }

    // sendmail and mail() extract Bcc from the header before sending
    if((($this->Mailer == 'sendmail') || ($this->Mailer == 'mail')) && (count($this->bcc) > 0)) {
      $result .= $this->AddrAppend('Bcc', $this->bcc);
    }

    if(count($this->ReplyTo) > 0) {
      $result .= $this->AddrAppend('Reply-to', $this->ReplyTo);
    }

    // mail() sets the subject itself
    if($this->Mailer != 'mail') {
      $result .= $this->HeaderLine('Subject', $this->EncodeHeader($this->SecureHeader($this->Subject)));
    }

    if($this->MessageID != '') {
      $result .= $this->HeaderLine('Message-ID',$this->MessageID);
    } else {
      $result .= sprintf("Message-ID: <%s@%s>%s", $uniq_id, $this->ServerHostname(), $this->LE);
    }
    $result .= $this->HeaderLine('X-Priority', $this->Priority);
    $result .= $this->HeaderLine('X-Mailer', 'PHPMailer '.$this->Version.' (phpmailer.codeworxtech.com)');

    if($this->ConfirmReadingTo != '') {
      $result .= $this->HeaderLine('Disposition-Notification-To', '<' . trim($this->ConfirmReadingTo) . '>');
    }

    // Add custom headers
    for($index = 0; $index < count($this->CustomHeader); $index++) {
      $result .= $this->HeaderLine(trim($this->CustomHeader[$index][0]), $this->EncodeHeader(trim($this->CustomHeader[$index][1])));
    }
    if (!$this->sign_key_file) {
      $result .= $this->HeaderLine('MIME-Version', '1.0');
      $result .= $this->GetMailMIME();
    }

    return $result;
  }

  /**
   * Returns the message MIME.
   * @access public
   * @return string
   */
  public function GetMailMIME() {
    $result = '';
    switch($this->message_type) {
      case 'plain':
        $result .= $this->HeaderLine('Content-Transfer-Encoding', $this->Encoding);
        $result .= sprintf("Content-Type: %s; charset=\"%s\"", $this->ContentType, $this->CharSet);
        break;
      case 'attachments':
      case 'alt_attachments':
        if($this->InlineImageExists()){
          $result .= sprintf("Content-Type: %s;%s\ttype=\"text/html\";%s\tboundary=\"%s\"%s", 'multipart/related', $this->LE, $this->LE, $this->boundary[1], $this->LE);
        } else {
          $result .= $this->HeaderLine('Content-Type', 'multipart/mixed;');
          $result .= $this->TextLine("\tboundary=\"" . $this->boundary[1] . '"');
        }
        break;
      case 'alt':
        $result .= $this->HeaderLine('Content-Type', 'multipart/alternative;');
        $result .= $this->TextLine("\tboundary=\"" . $this->boundary[1] . '"');
        break;
    }

    if($this->Mailer != 'mail') {
      $result .= $this->LE.$this->LE;
    }

    return $result;
  }

  /**
   * Assembles the message body.  Returns an empty string on failure.
   * @access public
   * @return string The assembled message body
   */
  public function CreateBody() {
    $body = '';

    if ($this->sign_key_file) {
      $body .= $this->GetMailMIME();
    }

    $this->SetWordWrap();

    switch($this->message_type) {
      case 'alt':
        $body .= $this->GetBoundary($this->boundary[1], '', 'text/plain', '');
        $body .= $this->EncodeString($this->AltBody, $this->Encoding);
        $body .= $this->LE.$this->LE;
        $body .= $this->GetBoundary($this->boundary[1], '', 'text/html', '');
        $body .= $this->EncodeString($this->Body, $this->Encoding);
        $body .= $this->LE.$this->LE;
        $body .= $this->EndBoundary($this->boundary[1]);
        break;
      case 'plain':
        $body .= $this->EncodeString($this->Body, $this->Encoding);
        break;
      case 'attachments':
        $body .= $this->GetBoundary($this->boundary[1], '', '', '');
        $body .= $this->EncodeString($this->Body, $this->Encoding);
        $body .= $this->LE;
        $body .= $this->AttachAll();
        break;
      case 'alt_attachments':
        $body .= sprintf("--%s%s", $this->boundary[1], $this->LE);
        $body .= sprintf("Content-Type: %s;%s" . "\tboundary=\"%s\"%s", 'multipart/alternative', $this->LE, $this->boundary[2], $this->LE.$this->LE);
        $body .= $this->GetBoundary($this->boundary[2], '', 'text/plain', '') . $this->LE; // Create text body
        $body .= $this->EncodeString($this->AltBody, $this->Encoding);
        $body .= $this->LE.$this->LE;
        $body .= $this->GetBoundary($this->boundary[2], '', 'text/html', '') . $this->LE; // Create the HTML body
        $body .= $this->EncodeString($this->Body, $this->Encoding);
        $body .= $this->LE.$this->LE;
        $body .= $this->EndBoundary($this->boundary[2]);
        $body .= $this->AttachAll();
        break;
    }

    if ($this->IsError()) {
      $body = '';
    } elseif ($this->sign_key_file) {
      try {
        $file = tempnam('', 'mail');
        file_put_contents($file, $body);
        $signed = tempnam("", "signed");
        if (@openssl_pkcs7_sign($file, $signed, "file://".$this->sign_cert_file, array("file://".$this->sign_key_file, $this->sign_key_pass), NULL)) {
          @unlink($file);
          @unlink($signed);
          $body = file_get_contents($signed);
        } else {
          @unlink($file);
          @unlink($signed);
          throw new phpmailerException($this->Lang("signing").openssl_error_string());
        }
      } catch (phpmailerException $e) {
        $body = '';
        if ($this->exceptions) {
          throw $e;
        }
      }
    }

    return $body;
  }

  /**
   * Returns the start of a message boundary.
   * @access private
   */
  private function GetBoundary($boundary, $charSet, $contentType, $encoding) {
    $result = '';
    if($charSet == '') {
      $charSet = $this->CharSet;
    }
    if($contentType == '') {
      $contentType = $this->ContentType;
    }
    if($encoding == '') {
      $encoding = $this->Encoding;
    }
    $result .= $this->TextLine('--' . $boundary);
    $result .= sprintf("Content-Type: %s; charset = \"%s\"", $contentType, $charSet);
    $result .= $this->LE;
    $result .= $this->HeaderLine('Content-Transfer-Encoding', $encoding);
    $result .= $this->LE;

    return $result;
  }

  /**
   * Returns the end of a message boundary.
   * @access private
   */
  private function EndBoundary($boundary) {
    return $this->LE . '--' . $boundary . '--' . $this->LE;
  }

  /**
   * Sets the message type.
   * @access private
   * @return void
   */
  private function SetMessageType() {
    if(count($this->attachment) < 1 && strlen($this->AltBody) < 1) {
      $this->message_type = 'plain';
    } else {
      if(count($this->attachment) > 0) {
        $this->message_type = 'attachments';
      }
      if(strlen($this->AltBody) > 0 && count($this->attachment) < 1) {
        $this->message_type = 'alt';
      }
      if(strlen($this->AltBody) > 0 && count($this->attachment) > 0) {
        $this->message_type = 'alt_attachments';
      }
    }
  }

  /**
   *  Returns a formatted header line.
   * @access public
   * @return string
   */
  public function HeaderLine($name, $value) {
    return $name . ': ' . $value . $this->LE;
  }

  /**
   * Returns a formatted mail line.
   * @access public
   * @return string
   */
  public function TextLine($value) {
    return $value . $this->LE;
  }

  /////////////////////////////////////////////////
  // CLASS METHODS, ATTACHMENTS
  /////////////////////////////////////////////////

  /**
   * Adds an attachment from a path on the filesystem.
   * Returns false if the file could not be found
   * or accessed.
   * @param string $path Path to the attachment.
   * @param string $name Overrides the attachment name.
   * @param string $encoding File encoding (see $Encoding).
   * @param string $type File extension (MIME) type.
   * @return bool
   */
  public function AddAttachment($path, $name = '', $encoding = 'base64', $type = 'application/octet-stream')
  {
  	try {
      if ( !@is_file($path) ) {
        throw new phpmailerException($this->Lang('file_access') . $path, self::STOP_CONTINUE);
      }
      $filename = basename($path);
      if ( $name == '' ) {
        $name = $filename;
      }

      $this->attachment[] = array(
        0 => $path,
        1 => $filename,
        2 => $name,
        3 => $encoding,
        4 => $type,
        5 => false,  // isStringAttachment
        6 => 'attachment',
        7 => 0
      );

    } catch (phpmailerException $e) {
      $this->SetError($e->getMessage());
      if ($this->exceptions) {
        throw $e;
      }
      echo $e->getMessage()."\n";
      if ( $e->getCode() == self::STOP_CRITICAL ) {
        return false;
      }
    }
    return true;
  }

  /**
  * Return the current array of attachments
  * @return array
  */
  public function GetAttachments() {
    return $this->attachment;
  }

  /**
   * Attaches all fs, string, and binary attachments to the message.
   * Returns an empty string on failure.
   * @access private
   * @return string
   */
  private function AttachAll() {
    // Return text of body
    $mime = array();
    $cidUniq = array();
    $incl = array();

    // Add all attachments
    foreach ($this->attachment as $attachment) {
      // Check for string attachment
      $bString = $attachment[5];
      if ($bString) {
        $string = $attachment[0];
      } else {
        $path = $attachment[0];
      }

      if (in_array($attachment[0], $incl)) { continue; }
      $filename    = $attachment[1];
      $name        = $attachment[2];
      $encoding    = $attachment[3];
      $type        = $attachment[4];
      $disposition = $attachment[6];
      $cid         = $attachment[7];
      $incl[]      = $attachment[0];
      if ( $disposition == 'inline' && isset($cidUniq[$cid]) ) { continue; }
      $cidUniq[$cid] = true;

      $mime[] = sprintf("--%s%s", $this->boundary[1], $this->LE);
      $mime[] = sprintf("Content-Type: %s; name=\"%s\"%s", $type, $this->EncodeHeader($this->SecureHeader($name)), $this->LE);
      $mime[] = sprintf("Content-Transfer-Encoding: %s%s", $encoding, $this->LE);

      if($disposition == 'inline') {
        $mime[] = sprintf("Content-ID: <%s>%s", $cid, $this->LE);
      }

      $mime[] = sprintf("Content-Disposition: %s; filename=\"%s\"%s", $disposition, $this->EncodeHeader($this->SecureHeader($name)), $this->LE.$this->LE);

      // Encode as string attachment
      if($bString) {
        $mime[] = $this->EncodeString($string, $encoding);
        if($this->IsError()) {
          return '';
        }
        $mime[] = $this->LE.$this->LE;
      } else {
        $mime[] = $this->EncodeFile($path, $encoding);
        if($this->IsError()) {
          return '';
        }
        $mime[] = $this->LE.$this->LE;
      }
    }

    $mime[] = sprintf("--%s--%s", $this->boundary[1], $this->LE);

    return join('', $mime);
  }

  /**
   * Encodes attachment in requested format.
   * Returns an empty string on failure.
   * @param string $path The full path to the file
   * @param string $encoding The encoding to use; one of 'base64', '7bit', '8bit', 'binary', 'quoted-printable'
   * @see EncodeFile()
   * @access private
   * @return string
   */
	private function EncodeFile($path, $encoding = 'base64')
	{
		try {
			if (!is_readable($path)) throw new phpmailerException($this->Lang('file_open') . $path, self::STOP_CONTINUE);
      		if (function_exists('get_magic_quotes'))
      		{
		        function get_magic_quotes()
		        {
		          return false;
		        }
      		}

//      if (PHP_VERSION < 6)
//      {
//        $magic_quotes = get_magic_quotes_runtime();
//        set_magic_quotes_runtime(0);
//      }

      $file_buffer  = file_get_contents($path);
      $file_buffer  = $this->EncodeString($file_buffer, $encoding);
      //if (PHP_VERSION < 6) { set_magic_quotes_runtime($magic_quotes); }
      return $file_buffer;
    }
    catch (Exception $e)
    {
      $this->SetError($e->getMessage());
      return '';
    }
  }

  /**
   * Encodes string to requested format.
   * Returns an empty string on failure.
   * @param string $str The text to encode
   * @param string $encoding The encoding to use; one of 'base64', '7bit', '8bit', 'binary', 'quoted-printable'
   * @access public
   * @return string
   */
  public function EncodeString ($str, $encoding = 'base64') {
    $encoded = '';
    switch(strtolower($encoding)) {
      case 'base64':
        $encoded = chunk_split(base64_encode($str), 76, $this->LE);
        break;
      case '7bit':
      case '8bit':
        $encoded = $this->FixEOL($str);
        //Make sure it ends with a line break
        if (substr($encoded, -(strlen($this->LE))) != $this->LE)
          $encoded .= $this->LE;
        break;
      case 'binary':
        $encoded = $str;
        break;
      case 'quoted-printable':
        $encoded = $this->EncodeQP($str);
        break;
      default:
        $this->SetError($this->Lang('encoding') . $encoding);
        break;
    }
    return $encoded;
  }

  /**
   * Encode a header string to best (shortest) of Q, B, quoted or none.
   * @access public
   * @return string
   */
  public function EncodeHeader($str, $position = 'text') {
    $x = 0;

    switch (strtolower($position)) {
      case 'phrase':
        if (!preg_match('/[\200-\377]/', $str)) {
          // Can't use addslashes as we don't know what value has magic_quotes_sybase
          $encoded = addcslashes($str, "\0..\37\177\\\"");
          if (($str == $encoded) && !preg_match('/[^A-Za-z0-9!#$%&\'*+\/=?^_`{|}~ -]/', $str)) {
            return ($encoded);
          } else {
            return ("\"$encoded\"");
          }
        }
        $x = preg_match_all('/[^\040\041\043-\133\135-\176]/', $str, $matches);
        break;
      case 'comment':
        $x = preg_match_all('/[()"]/', $str, $matches);
        // Fall-through
      case 'text':
      default:
        $x += preg_match_all('/[\000-\010\013\014\016-\037\177-\377]/', $str, $matches);
        break;
    }

    if ($x == 0) {
      return ($str);
    }

    $maxlen = 75 - 7 - strlen($this->CharSet);
    // Try to select the encoding which should produce the shortest output
    if (strlen($str)/3 < $x) {
      $encoding = 'B';
      if (function_exists('mb_strlen') && $this->HasMultiBytes($str)) {
        // Use a custom function which correctly encodes and wraps long
        // multibyte strings without breaking lines within a character
        $encoded = $this->Base64EncodeWrapMB($str);
      } else {
        $encoded = base64_encode($str);
        $maxlen -= $maxlen % 4;
        $encoded = trim(chunk_split($encoded, $maxlen, "\n"));
      }
    } else {
      $encoding = 'Q';
      $encoded = $this->EncodeQ($str, $position);
      $encoded = $this->WrapText($encoded, $maxlen, true);
      $encoded = str_replace('='.$this->LE, "\n", trim($encoded));
    }

    $encoded = preg_replace('/^(.*)$/m', " =?".$this->CharSet."?$encoding?\\1?=", $encoded);
    $encoded = trim(str_replace("\n", $this->LE, $encoded));

    return $encoded;
  }

  /**
   * Checks if a string contains multibyte characters.
   * @access public
   * @param string $str multi-byte text to wrap encode
   * @return bool
   */
  public function HasMultiBytes($str) {
    if (function_exists('mb_strlen')) {
      return (strlen($str) > mb_strlen($str, $this->CharSet));
    } else { // Assume no multibytes (we can't handle without mbstring functions anyway)
      return false;
    }
  }

  /**
   * Correctly encodes and wraps long multibyte strings for mail headers
   * without breaking lines within a character.
   * Adapted from a function by paravoid at http://uk.php.net/manual/en/function.mb-encode-mimeheader.php
   * @access public
   * @param string $str multi-byte text to wrap encode
   * @return string
   */
  public function Base64EncodeWrapMB($str) {
    $start = "=?".$this->CharSet."?B?";
    $end = "?=";
    $encoded = "";

    $mb_length = mb_strlen($str, $this->CharSet);
    // Each line must have length <= 75, including $start and $end
    $length = 75 - strlen($start) - strlen($end);
    // Average multi-byte ratio
    $ratio = $mb_length / strlen($str);
    // Base64 has a 4:3 ratio
    $offset = $avgLength = floor($length * $ratio * .75);

    for ($i = 0; $i < $mb_length; $i += $offset) {
      $lookBack = 0;

      do {
        $offset = $avgLength - $lookBack;
        $chunk = mb_substr($str, $i, $offset, $this->CharSet);
        $chunk = base64_encode($chunk);
        $lookBack++;
      }
      while (strlen($chunk) > $length);

      $encoded .= $chunk . $this->LE;
    }

    // Chomp the last linefeed
    $encoded = substr($encoded, 0, -strlen($this->LE));
    return $encoded;
  }

  /**
  * Encode string to quoted-printable.
  * Only uses standard PHP, slow, but will always work
  * @access public
  * @param string $string the text to encode
  * @param integer $line_max Number of chars allowed on a line before wrapping
  * @return string
  */
  public function EncodeQPphp( $input = '', $line_max = 76, $space_conv = false) {
    $hex = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
    $lines = preg_split('/(?:\r\n|\r|\n)/', $input);
    $eol = "\r\n";
    $escape = '=';
    $output = '';
    while( list(, $line) = each($lines) ) {
      $linlen = strlen($line);
      $newline = '';
      for($i = 0; $i < $linlen; $i++) {
        $c = substr( $line, $i, 1 );
        $dec = ord( $c );
        if ( ( $i == 0 ) && ( $dec == 46 ) ) { // convert first point in the line into =2E
          $c = '=2E';
        }
        if ( $dec == 32 ) {
          if ( $i == ( $linlen - 1 ) ) { // convert space at eol only
            $c = '=20';
          } else if ( $space_conv ) {
            $c = '=20';
          }
        } elseif ( ($dec == 61) || ($dec < 32 ) || ($dec > 126) ) { // always encode "\t", which is *not* required
          $h2 = floor($dec/16);
          $h1 = floor($dec%16);
          $c = $escape.$hex[$h2].$hex[$h1];
        }
        if ( (strlen($newline) + strlen($c)) >= $line_max ) { // CRLF is not counted
          $output .= $newline.$escape.$eol; //  soft line break; " =\r\n" is okay
          $newline = '';
          // check if newline first character will be point or not
          if ( $dec == 46 ) {
            $c = '=2E';
          }
        }
        $newline .= $c;
      } // end of for
      $output .= $newline.$eol;
    } // end of while
    return $output;
  }

  /**
  * Encode string to RFC2045 (6.7) quoted-printable format
  * Uses a PHP5 stream filter to do the encoding about 64x faster than the old version
  * Also results in same content as you started with after decoding
  * @see EncodeQPphp()
  * @access public
  * @param string $string the text to encode
  * @param integer $line_max Number of chars allowed on a line before wrapping
  * @param boolean $space_conv Dummy param for compatibility with existing EncodeQP function
  * @return string
  * @author Marcus Bointon
  */
  public function EncodeQP($string, $line_max = 76, $space_conv = false) {
    if (function_exists('quoted_printable_encode')) { //Use native function if it's available (>= PHP5.3)
      return quoted_printable_encode($string);
    }
    $filters = stream_get_filters();
    if (!in_array('convert.*', $filters)) { //Got convert stream filter?
      return $this->EncodeQPphp($string, $line_max, $space_conv); //Fall back to old implementation
    }
    $fp = fopen('php://temp/', 'r+');
    $string = preg_replace('/\r\n?/', $this->LE, $string); //Normalise line breaks
    $params = array('line-length' => $line_max, 'line-break-chars' => $this->LE);
    $s = stream_filter_append($fp, 'convert.quoted-printable-encode', STREAM_FILTER_READ, $params);
    fputs($fp, $string);
    rewind($fp);
    $out = stream_get_contents($fp);
    stream_filter_remove($s);
    $out = preg_replace('/^\./m', '=2E', $out); //Encode . if it is first char on a line, workaround for bug in Exchange
    fclose($fp);
    return $out;
  }

  /**
   * Encode string to q encoding.
   * @link http://tools.ietf.org/html/rfc2047
   * @param string $str the text to encode
   * @param string $position Where the text is going to be used, see the RFC for what that means
   * @access public
   * @return string
   */
  public function EncodeQ ($str, $position = 'text') {
    // There should not be any EOL in the string
    $encoded = preg_replace('/[\r\n]*/', '', $str);

    switch (strtolower($position)) {
      case 'phrase':
        $encoded = preg_replace("/([^A-Za-z0-9!*+\/ -])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);
        break;
      case 'comment':
        $encoded = preg_replace("/([\(\)\"])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);
      case 'text':
      default:
        // Replace every high ascii, control =, ? and _ characters
        $encoded = preg_replace('/([\000-\011\013\014\016-\037\075\077\137\177-\377])/e',
              "'='.sprintf('%02X', ord('\\1'))", $encoded);
        break;
    }

    // Replace every spaces to _ (more readable than =20)
    $encoded = str_replace(' ', '_', $encoded);

    return $encoded;
  }

  /**
   * Adds a string or binary attachment (non-filesystem) to the list.
   * This method can be used to attach ascii or binary data,
   * such as a BLOB record from a database.
   * @param string $string String attachment data.
   * @param string $filename Name of the attachment.
   * @param string $encoding File encoding (see $Encoding).
   * @param string $type File extension (MIME) type.
   * @return void
   */
  public function AddStringAttachment($string, $filename, $encoding = 'base64', $type = 'application/octet-stream') {
    // Append to $attachment array
    $this->attachment[] = array(
      0 => $string,
      1 => $filename,
      2 => $filename,
      3 => $encoding,
      4 => $type,
      5 => true,  // isStringAttachment
      6 => 'attachment',
      7 => 0
    );
  }

  /**
   * Adds an embedded attachment.  This can include images, sounds, and
   * just about any other document.  Make sure to set the $type to an
   * image type.  For JPEG images use "image/jpeg" and for GIF images
   * use "image/gif".
   * @param string $path Path to the attachment.
   * @param string $cid Content ID of the attachment.  Use this to identify
   *        the Id for accessing the image in an HTML form.
   * @param string $name Overrides the attachment name.
   * @param string $encoding File encoding (see $Encoding).
   * @param string $type File extension (MIME) type.
   * @return bool
   */
  public function AddEmbeddedImage($path, $cid, $name = '', $encoding = 'base64', $type = 'application/octet-stream') {

    if ( !@is_file($path) ) {
      $this->SetError($this->Lang('file_access') . $path);
      return false;
    }

    $filename = basename($path);
    if ( $name == '' ) {
      $name = $filename;
    }

    // Append to $attachment array
    $this->attachment[] = array(
      0 => $path,
      1 => $filename,
      2 => $name,
      3 => $encoding,
      4 => $type,
      5 => false,  // isStringAttachment
      6 => 'inline',
      7 => $cid
    );

    return true;
  }

  /**
   * Returns true if an inline attachment is present.
   * @access public
   * @return bool
   */
  public function InlineImageExists() {
    foreach($this->attachment as $attachment) {
      if ($attachment[6] == 'inline') {
        return true;
      }
    }
    return false;
  }

  /////////////////////////////////////////////////
  // CLASS METHODS, MESSAGE RESET
  /////////////////////////////////////////////////

  /**
   * Clears all recipients assigned in the TO array.  Returns void.
   * @return void
   */
  public function ClearAddresses() {
    foreach($this->to as $to) {
      unset($this->all_recipients[strtolower($to[0])]);
    }
    $this->to = array();
  }

  /**
   * Clears all recipients assigned in the CC array.  Returns void.
   * @return void
   */
  public function ClearCCs() {
    foreach($this->cc as $cc) {
      unset($this->all_recipients[strtolower($cc[0])]);
    }
    $this->cc = array();
  }

  /**
   * Clears all recipients assigned in the BCC array.  Returns void.
   * @return void
   */
  public function ClearBCCs() {
    foreach($this->bcc as $bcc) {
      unset($this->all_recipients[strtolower($bcc[0])]);
    }
    $this->bcc = array();
  }

  /**
   * Clears all recipients assigned in the ReplyTo array.  Returns void.
   * @return void
   */
  public function ClearReplyTos() {
    $this->ReplyTo = array();
  }

  /**
   * Clears all recipients assigned in the TO, CC and BCC
   * array.  Returns void.
   * @return void
   */
  public function ClearAllRecipients() {
    $this->to = array();
    $this->cc = array();
    $this->bcc = array();
    $this->all_recipients = array();
  }

  /**
   * Clears all previously set filesystem, string, and binary
   * attachments.  Returns void.
   * @return void
   */
  public function ClearAttachments() {
    $this->attachment = array();
  }

  /**
   * Clears all custom headers.  Returns void.
   * @return void
   */
  public function ClearCustomHeaders() {
    $this->CustomHeader = array();
  }

  /////////////////////////////////////////////////
  // CLASS METHODS, MISCELLANEOUS
  /////////////////////////////////////////////////

  /**
   * Adds the error message to the error container.
   * @access protected
   * @return void
   */
  protected function SetError($msg) {
    $this->error_count++;
    if ($this->Mailer == 'smtp' and !is_null($this->smtp)) {
      $lasterror = $this->smtp->getError();
      if (!empty($lasterror) and array_key_exists('smtp_msg', $lasterror)) {
        $msg .= '<p>' . $this->Lang('smtp_error') . $lasterror['smtp_msg'] . "</p>\n";
      }
    }
    $this->ErrorInfo = $msg;
  }

  /**
   * Returns the proper RFC 822 formatted date.
   * @access public
   * @return string
   * @static
   */
  public static function RFCDate() {
    $tz = date('Z');
    $tzs = ($tz < 0) ? '-' : '+';
    $tz = abs($tz);
    $tz = (int)($tz/3600)*100 + ($tz%3600)/60;
    $result = sprintf("%s %s%04d", date('D, j M Y H:i:s'), $tzs, $tz);

    return $result;
  }

  /**
   * Returns the server hostname or 'localhost.localdomain' if unknown.
   * @access private
   * @return string
   */
  private function ServerHostname() {
    if (!empty($this->Hostname)) {
      $result = $this->Hostname;
    } elseif (isset($_SERVER['SERVER_NAME'])) {
      $result = $_SERVER['SERVER_NAME'];
    } else {
      $result = 'localhost.localdomain';
    }

    return $result;
  }

  /**
   * Returns a message in the appropriate language.
   * @access private
   * @return string
   */
  private function Lang($key) {
    if(count($this->language) < 1) {
      $this->SetLanguage('en'); // set the default language
    }

    if(isset($this->language[$key])) {
      return $this->language[$key];
    } else {
      return 'Language string failed to load: ' . $key;
    }
  }

  /**
   * Returns true if an error occurred.
   * @access public
   * @return bool
   */
  public function IsError() {
    return ($this->error_count > 0);
  }

  /**
   * Changes every end of line from CR or LF to CRLF.
   * @access private
   * @return string
   */
  private function FixEOL($str) {
    $str = str_replace("\r\n", "\n", $str);
    $str = str_replace("\r", "\n", $str);
    $str = str_replace("\n", $this->LE, $str);
    return $str;
  }

  /**
   * Adds a custom header.
   * @access public
   * @return void
   */
  public function AddCustomHeader($custom_header) {
    $this->CustomHeader[] = explode(':', $custom_header, 2);
  }

  /**
   * Evaluates the message and returns modifications for inline images and backgrounds
   * @access public
   * @return $message
   */
  public function MsgHTML($message, $basedir = '') {
    preg_match_all("/(src|background)=\"(.*)\"/Ui", $message, $images);
    if(isset($images[2])) {
      foreach($images[2] as $i => $url) {
        // do not change urls for absolute images (thanks to corvuscorax)
        if (!preg_match('#^[A-z]+://#',$url)) {
          $filename = basename($url);
          $directory = dirname($url);
          ($directory == '.')?$directory='':'';
          $cid = 'cid:' . md5($filename);
          $ext = pathinfo($filename, PATHINFO_EXTENSION);
          $mimeType  = self::_mime_types($ext);
          if ( strlen($basedir) > 1 && substr($basedir,-1) != '/') { $basedir .= '/'; }
          if ( strlen($directory) > 1 && substr($directory,-1) != '/') { $directory .= '/'; }
          if ( $this->AddEmbeddedImage($basedir.$directory.$filename, md5($filename), $filename, 'base64',$mimeType) ) {
            $message = preg_replace("/".$images[1][$i]."=\"".preg_quote($url, '/')."\"/Ui", $images[1][$i]."=\"".$cid."\"", $message);
          }
        }
      }
    }
    $this->IsHTML(true);
    $this->Body = $message;
    $textMsg = trim(strip_tags(preg_replace('/<(head|title|style|script)[^>]*>.*?<\/\\1>/s','',$message)));
    if (!empty($textMsg) && empty($this->AltBody)) {
      $this->AltBody = html_entity_decode($textMsg);
    }
    if (empty($this->AltBody)) {
      $this->AltBody = 'To view this email message, open it in a program that understands HTML!' . "\n\n";
    }
  }

  /**
   * Gets the MIME type of the embedded or inline image
   * @param string File extension
   * @access public
   * @return string MIME type of ext
   * @static
   */
  public static function _mime_types($ext = '') {
    $mimes = array(
      'hqx'   =>  'application/mac-binhex40',
      'cpt'   =>  'application/mac-compactpro',
      'doc'   =>  'application/msword',
      'bin'   =>  'application/macbinary',
      'dms'   =>  'application/octet-stream',
      'lha'   =>  'application/octet-stream',
      'lzh'   =>  'application/octet-stream',
      'exe'   =>  'application/octet-stream',
      'class' =>  'application/octet-stream',
      'psd'   =>  'application/octet-stream',
      'so'    =>  'application/octet-stream',
      'sea'   =>  'application/octet-stream',
      'dll'   =>  'application/octet-stream',
      'oda'   =>  'application/oda',
      'pdf'   =>  'application/pdf',
      'ai'    =>  'application/postscript',
      'eps'   =>  'application/postscript',
      'ps'    =>  'application/postscript',
      'smi'   =>  'application/smil',
      'smil'  =>  'application/smil',
      'mif'   =>  'application/vnd.mif',
      'xls'   =>  'application/vnd.ms-excel',
      'ppt'   =>  'application/vnd.ms-powerpoint',
      'wbxml' =>  'application/vnd.wap.wbxml',
      'wmlc'  =>  'application/vnd.wap.wmlc',
      'dcr'   =>  'application/x-director',
      'dir'   =>  'application/x-director',
      'dxr'   =>  'application/x-director',
      'dvi'   =>  'application/x-dvi',
      'gtar'  =>  'application/x-gtar',
      'php'   =>  'application/x-httpd-php',
      'php4'  =>  'application/x-httpd-php',
      'php3'  =>  'application/x-httpd-php',
      'phtml' =>  'application/x-httpd-php',
      'phps'  =>  'application/x-httpd-php-source',
      'js'    =>  'application/x-javascript',
      'swf'   =>  'application/x-shockwave-flash',
      'sit'   =>  'application/x-stuffit',
      'tar'   =>  'application/x-tar',
      'tgz'   =>  'application/x-tar',
      'xhtml' =>  'application/xhtml+xml',
      'xht'   =>  'application/xhtml+xml',
      'zip'   =>  'application/zip',
      'mid'   =>  'audio/midi',
      'midi'  =>  'audio/midi',
      'mpga'  =>  'audio/mpeg',
      'mp2'   =>  'audio/mpeg',
      'mp3'   =>  'audio/mpeg',
      'aif'   =>  'audio/x-aiff',
      'aiff'  =>  'audio/x-aiff',
      'aifc'  =>  'audio/x-aiff',
      'ram'   =>  'audio/x-pn-realaudio',
      'rm'    =>  'audio/x-pn-realaudio',
      'rpm'   =>  'audio/x-pn-realaudio-plugin',
      'ra'    =>  'audio/x-realaudio',
      'rv'    =>  'video/vnd.rn-realvideo',
      'wav'   =>  'audio/x-wav',
      'bmp'   =>  'image/bmp',
      'gif'   =>  'image/gif',
      'jpeg'  =>  'image/jpeg',
      'jpg'   =>  'image/jpeg',
      'jpe'   =>  'image/jpeg',
      'png'   =>  'image/png',
      'tiff'  =>  'image/tiff',
      'tif'   =>  'image/tiff',
      'css'   =>  'text/css',
      'html'  =>  'text/html',
      'htm'   =>  'text/html',
      'shtml' =>  'text/html',
      'txt'   =>  'text/plain',
      'text'  =>  'text/plain',
      'log'   =>  'text/plain',
      'rtx'   =>  'text/richtext',
      'rtf'   =>  'text/rtf',
      'xml'   =>  'text/xml',
      'xsl'   =>  'text/xml',
      'mpeg'  =>  'video/mpeg',
      'mpg'   =>  'video/mpeg',
      'mpe'   =>  'video/mpeg',
      'qt'    =>  'video/quicktime',
      'mov'   =>  'video/quicktime',
      'avi'   =>  'video/x-msvideo',
      'movie' =>  'video/x-sgi-movie',
      'doc'   =>  'application/msword',
      'word'  =>  'application/msword',
      'xl'    =>  'application/excel',
      'eml'   =>  'message/rfc822'
    );
    return (!isset($mimes[strtolower($ext)])) ? 'application/octet-stream' : $mimes[strtolower($ext)];
  }

  /**
  * Set (or reset) Class Objects (variables)
  *
  * Usage Example:
  * $page->set('X-Priority', '3');
  *
  * @access public
  * @param string $name Parameter Name
  * @param mixed $value Parameter Value
  * NOTE: will not work with arrays, there are no arrays to set/reset
  */
  public function set($name, $value = '') {
    try {
      if (isset($this->$name) ) {
        $this->$name = $value;
      } else {
        throw new phpmailerException($this->Lang('variable_set') . $name, self::STOP_CRITICAL);
      }
    } catch (Exception $e) {
      $this->SetError($e->getMessage());
      if ($e->getCode() == self::STOP_CRITICAL) {
        return false;
      }
    }
    return true;
  }

  /**
   * Strips newlines to prevent header injection.
   * @access public
   * @param string $str String
   * @return string
   */
  public function SecureHeader($str) {
    $str = str_replace("\r", '', $str);
    $str = str_replace("\n", '', $str);
    return trim($str);
  }

  /**
   * Set the private key file and password to sign the message.
   *
   * @access public
   * @param string $key_filename Parameter File Name
   * @param string $key_pass Password for private key
   */
  public function Sign($cert_filename, $key_filename, $key_pass) {
    $this->sign_cert_file = $cert_filename;
    $this->sign_key_file = $key_filename;
    $this->sign_key_pass = $key_pass;
  }
}

/** @ignore */
class phpmailerException extends Exception
{
  public function errorMessage()
  {
    $errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
    return $errorMsg;
  }
}

/** @ignore */
class SMTP
{
  /**
   *  SMTP server port
   *  @var int
   */
  public $SMTP_PORT = 25;

  /**
   *  SMTP reply line ending
   *  @var string
   */
  public $CRLF = "\r\n";

  /**
   *  Sets whether debugging is turned on
   *  @var bool
   */
  public $do_debug;       // the level of debug to perform

  /**
   *  Sets VERP use on/off (default is off)
   *  @var bool
   */
  public $do_verp = false;

  /////////////////////////////////////////////////
  // PROPERTIES, PRIVATE AND PROTECTED
  /////////////////////////////////////////////////

  private $smtp_conn; // the socket to the server
  private $error;     // error if any on the last call
  private $helo_rply; // the reply the server sent to us for HELO

  /**
   * Initialize the class so that the data is in a known state.
   * @access public
   * @return void
   */
  public function __construct()
  {
    $this->smtp_conn = 0;
    $this->error = null;
    $this->helo_rply = null;

    $this->do_debug = 0;
  }

  /////////////////////////////////////////////////
  // CONNECTION FUNCTIONS
  /////////////////////////////////////////////////

  /**
   * Connect to the server specified on the port specified.
   * If the port is not specified use the default SMTP_PORT.
   * If tval is specified then a connection will try and be
   * established with the server for that number of seconds.
   * If tval is not specified the default is 30 seconds to
   * try on the connection.
   *
   * SMTP CODE SUCCESS: 220
   * SMTP CODE FAILURE: 421
   * @access public
   * @return bool
   */
  public function Connect($host, $port = 0, $tval = 30) {
    // set the error val to null so there is no confusion
    $this->error = null;

    // make sure we are __not__ connected
    if($this->connected()) {
      // already connected, generate error
      $this->error = array("error" => "Already connected to a server");
      return false;
    }

    if(empty($port)) {
      $port = $this->SMTP_PORT;
    }

    // connect to the smtp server
    $errno  = '';
    $errstr = '';
    $tval   = '';
    $this->smtp_conn = @fsockopen($host,    // the host of the server
                                 $port,    // the port to use
                                 $errno,   // error number if any
                                 $errstr,  // error message if any
                                 $tval);   // give up after ? secs
    // verify we connected properly
    if(empty($this->smtp_conn)) {
      $this->error = array("error" => "Failed to connect to server",
                           "errno" => $errno,
                           "errstr" => $errstr);
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": $errstr ($errno)" . $this->CRLF . '<br />';
      }
      return false;
    }

    // SMTP server can take longer to respond, give longer timeout for first read
    // Windows does not have support for this timeout function
    if(substr(PHP_OS, 0, 3) != "WIN")
     socket_set_timeout($this->smtp_conn, $tval, 0);

    // get any announcement
    $announce = $this->get_lines();

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $announce . $this->CRLF . '<br />';
    }

    return true;
  }

  /**
   * Initiate a TLS communication with the server.
   *
   * SMTP CODE 220 Ready to start TLS
   * SMTP CODE 501 Syntax error (no parameters allowed)
   * SMTP CODE 454 TLS not available due to temporary reason
   * @access public
   * @return bool success
   */
  public function StartTLS() {
    $this->error = null; # to avoid confusion

    if(!$this->connected()) {
      $this->error = array("error" => "Called StartTLS() without being connected");
      return false;
    }

    fputs($this->smtp_conn,"STARTTLS" . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 220) {
      $this->error =
         array("error"     => "STARTTLS not accepted from server",
               "smtp_code" => $code,
               "smtp_msg"  => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    // Begin encrypted connection
    if(!stream_socket_enable_crypto($this->smtp_conn, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
      return false;
    }

    return true;
  }

  /**
   * Performs SMTP authentication.  Must be run after running the
   * Hello() method.  Returns true if successfully authenticated.
   * @access public
   * @return bool
   */
  public function Authenticate($username, $password) {
    // Start authentication
    fputs($this->smtp_conn,"AUTH LOGIN" . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($code != 334) {
      $this->error =
        array("error" => "AUTH not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    // Send encoded username
    fputs($this->smtp_conn, base64_encode($username) . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($code != 334) {
      $this->error =
        array("error" => "Username not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    // Send encoded password
    fputs($this->smtp_conn, base64_encode($password) . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($code != 235) {
      $this->error =
        array("error" => "Password not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    return true;
  }

  /**
   * Returns true if connected to a server otherwise false
   * @access public
   * @return bool
   */
  public function Connected() {
    if(!empty($this->smtp_conn)) {
      $sock_status = socket_get_status($this->smtp_conn);
      if($sock_status["eof"]) {
        // the socket is valid but we are not connected
        if($this->do_debug >= 1) {
            echo "SMTP -> NOTICE:" . $this->CRLF . "EOF caught while checking if connected";
        }
        $this->Close();
        return false;
      }
      return true; // everything looks good
    }
    return false;
  }

  /**
   * Closes the socket and cleans up the state of the class.
   * It is not considered good to use this function without
   * first trying to use QUIT.
   * @access public
   * @return void
   */
  public function Close() {
    $this->error = null; // so there is no confusion
    $this->helo_rply = null;
    if(!empty($this->smtp_conn)) {
      // close the connection and cleanup
      fclose($this->smtp_conn);
      $this->smtp_conn = 0;
    }
  }

  /////////////////////////////////////////////////
  // SMTP COMMANDS
  /////////////////////////////////////////////////

  /**
   * Issues a data command and sends the msg_data to the server
   * finializing the mail transaction. $msg_data is the message
   * that is to be send with the headers. Each header needs to be
   * on a single line followed by a <CRLF> with the message headers
   * and the message body being seperated by and additional <CRLF>.
   *
   * Implements rfc 821: DATA <CRLF>
   *
   * SMTP CODE INTERMEDIATE: 354
   *     [data]
   *     <CRLF>.<CRLF>
   *     SMTP CODE SUCCESS: 250
   *     SMTP CODE FAILURE: 552,554,451,452
   * SMTP CODE FAILURE: 451,554
   * SMTP CODE ERROR  : 500,501,503,421
   * @access public
   * @return bool
   */
  public function Data($msg_data) {
    $this->error = null; // so no confusion is caused

    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Data() without being connected");
      return false;
    }

    fputs($this->smtp_conn,"DATA" . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 354) {
      $this->error =
        array("error" => "DATA command not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    /* the server is ready to accept data!
     * according to rfc 821 we should not send more than 1000
     * including the CRLF
     * characters on a single line so we will break the data up
     * into lines by \r and/or \n then if needed we will break
     * each of those into smaller lines to fit within the limit.
     * in addition we will be looking for lines that start with
     * a period '.' and append and additional period '.' to that
     * line. NOTE: this does not count towards limit.
     */

    // normalize the line breaks so we know the explode works
    $msg_data = str_replace("\r\n","\n",$msg_data);
    $msg_data = str_replace("\r","\n",$msg_data);
    $lines = explode("\n",$msg_data);

    /* we need to find a good way to determine is headers are
     * in the msg_data or if it is a straight msg body
     * currently I am assuming rfc 822 definitions of msg headers
     * and if the first field of the first line (':' sperated)
     * does not contain a space then it _should_ be a header
     * and we can process all lines before a blank "" line as
     * headers.
     */

    $field = substr($lines[0],0,strpos($lines[0],":"));
    $in_headers = false;
    if(!empty($field) && !strstr($field," ")) {
      $in_headers = true;
    }

    $max_line_length = 998; // used below; set here for ease in change

    while(list(,$line) = @each($lines)) {
      $lines_out = null;
      if($line == "" && $in_headers) {
        $in_headers = false;
      }
      // ok we need to break this line up into several smaller lines
      while(strlen($line) > $max_line_length) {
        $pos = strrpos(substr($line,0,$max_line_length)," ");

        // Patch to fix DOS attack
        if(!$pos) {
          $pos = $max_line_length - 1;
          $lines_out[] = substr($line,0,$pos);
          $line = substr($line,$pos);
        } else {
          $lines_out[] = substr($line,0,$pos);
          $line = substr($line,$pos + 1);
        }

        /* if processing headers add a LWSP-char to the front of new line
         * rfc 822 on long msg headers
         */
        if($in_headers) {
          $line = "\t" . $line;
        }
      }
      $lines_out[] = $line;

      // send the lines to the server
      while(list(,$line_out) = @each($lines_out)) {
        if(strlen($line_out) > 0)
        {
          if(substr($line_out, 0, 1) == ".") {
            $line_out = "." . $line_out;
          }
        }
        fputs($this->smtp_conn,$line_out . $this->CRLF);
      }
    }

    // message data has been sent
    fputs($this->smtp_conn, $this->CRLF . "." . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 250) {
      $this->error =
        array("error" => "DATA not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }

  /**
   * Sends the HELO command to the smtp server.
   * This makes sure that we and the server are in
   * the same known state.
   *
   * Implements from rfc 821: HELO <SP> <domain> <CRLF>
   *
   * SMTP CODE SUCCESS: 250
   * SMTP CODE ERROR  : 500, 501, 504, 421
   * @access public
   * @return bool
   */
  public function Hello($host = '') {
    $this->error = null; // so no confusion is caused

    if(!$this->connected()) {
      $this->error = array(
            "error" => "Called Hello() without being connected");
      return false;
    }

    // if hostname for HELO was not specified send default
    if(empty($host)) {
      // determine appropriate default to send to server
      $host = "localhost";
    }

    // Send extended hello first (RFC 2821)
    if(!$this->SendHello("EHLO", $host)) {
      if(!$this->SendHello("HELO", $host)) {
        return false;
      }
    }

    return true;
  }

  /**
   * Sends a HELO/EHLO command.
   * @access private
   * @return bool
   */
  private function SendHello($hello, $host) {
    fputs($this->smtp_conn, $hello . " " . $host . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER: " . $rply . $this->CRLF . '<br />';
    }

    if($code != 250) {
      $this->error =
        array("error" => $hello . " not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    $this->helo_rply = $rply;

    return true;
  }

  /**
   * Starts a mail transaction from the email address specified in
   * $from. Returns true if successful or false otherwise. If True
   * the mail transaction is started and then one or more Recipient
   * commands may be called followed by a Data command.
   *
   * Implements rfc 821: MAIL <SP> FROM:<reverse-path> <CRLF>
   *
   * SMTP CODE SUCCESS: 250
   * SMTP CODE SUCCESS: 552,451,452
   * SMTP CODE SUCCESS: 500,501,421
   * @access public
   * @return bool
   */
  public function Mail($from) {
    $this->error = null; // so no confusion is caused

    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Mail() without being connected");
      return false;
    }

    $useVerp = ($this->do_verp ? "XVERP" : "");
    fputs($this->smtp_conn,"MAIL FROM:<" . $from . ">" . $useVerp . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 250) {
      $this->error =
        array("error" => "MAIL not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }

  /**
   * Sends the quit command to the server and then closes the socket
   * if there is no error or the $close_on_error argument is true.
   *
   * Implements from rfc 821: QUIT <CRLF>
   *
   * SMTP CODE SUCCESS: 221
   * SMTP CODE ERROR  : 500
   * @access public
   * @return bool
   */
  public function Quit($close_on_error = true) {
    $this->error = null; // so there is no confusion

    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Quit() without being connected");
      return false;
    }

    // send the quit command to the server
    fputs($this->smtp_conn,"quit" . $this->CRLF);

    // get any good-bye messages
    $byemsg = $this->get_lines();

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $byemsg . $this->CRLF . '<br />';
    }

    $rval = true;
    $e = null;

    $code = substr($byemsg,0,3);
    if($code != 221) {
      // use e as a tmp var cause Close will overwrite $this->error
      $e = array("error" => "SMTP server rejected quit command",
                 "smtp_code" => $code,
                 "smtp_rply" => substr($byemsg,4));
      $rval = false;
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $e["error"] . ": " . $byemsg . $this->CRLF . '<br />';
      }
    }

    if(empty($e) || $close_on_error) {
      $this->Close();
    }

    return $rval;
  }

  /**
   * Sends the command RCPT to the SMTP server with the TO: argument of $to.
   * Returns true if the recipient was accepted false if it was rejected.
   *
   * Implements from rfc 821: RCPT <SP> TO:<forward-path> <CRLF>
   *
   * SMTP CODE SUCCESS: 250,251
   * SMTP CODE FAILURE: 550,551,552,553,450,451,452
   * SMTP CODE ERROR  : 500,501,503,421
   * @access public
   * @return bool
   */
  public function Recipient($to) {
    $this->error = null; // so no confusion is caused

    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Recipient() without being connected");
      return false;
    }

    fputs($this->smtp_conn,"RCPT TO:<" . $to . ">" . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 250 && $code != 251) {
      $this->error =
        array("error" => "RCPT not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }

  /**
   * Sends the RSET command to abort and transaction that is
   * currently in progress. Returns true if successful false
   * otherwise.
   *
   * Implements rfc 821: RSET <CRLF>
   *
   * SMTP CODE SUCCESS: 250
   * SMTP CODE ERROR  : 500,501,504,421
   * @access public
   * @return bool
   */
  public function Reset() {
    $this->error = null; // so no confusion is caused

    if(!$this->connected()) {
      $this->error = array(
              "error" => "Called Reset() without being connected");
      return false;
    }

    fputs($this->smtp_conn,"RSET" . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 250) {
      $this->error =
        array("error" => "RSET failed",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }

    return true;
  }

  /**
   * Starts a mail transaction from the email address specified in
   * $from. Returns true if successful or false otherwise. If True
   * the mail transaction is started and then one or more Recipient
   * commands may be called followed by a Data command. This command
   * will send the message to the users terminal if they are logged
   * in and send them an email.
   *
   * Implements rfc 821: SAML <SP> FROM:<reverse-path> <CRLF>
   *
   * SMTP CODE SUCCESS: 250
   * SMTP CODE SUCCESS: 552,451,452
   * SMTP CODE SUCCESS: 500,501,502,421
   * @access public
   * @return bool
   */
  public function SendAndMail($from) {
    $this->error = null; // so no confusion is caused

    if(!$this->connected()) {
      $this->error = array(
          "error" => "Called SendAndMail() without being connected");
      return false;
    }

    fputs($this->smtp_conn,"SAML FROM:" . $from . $this->CRLF);

    $rply = $this->get_lines();
    $code = substr($rply,0,3);

    if($this->do_debug >= 2) {
      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
    }

    if($code != 250) {
      $this->error =
        array("error" => "SAML not accepted from server",
              "smtp_code" => $code,
              "smtp_msg" => substr($rply,4));
      if($this->do_debug >= 1) {
        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
      }
      return false;
    }
    return true;
  }

  /**
   * This is an optional command for SMTP that this class does not
   * support. This method is here to make the RFC821 Definition
   * complete for this class and __may__ be implimented in the future
   *
   * Implements from rfc 821: TURN <CRLF>
   *
   * SMTP CODE SUCCESS: 250
   * SMTP CODE FAILURE: 502
   * SMTP CODE ERROR  : 500, 503
   * @access public
   * @return bool
   */
  public function Turn() {
    $this->error = array("error" => "This method, TURN, of the SMTP ".
                                    "is not implemented");
    if($this->do_debug >= 1) {
      echo "SMTP -> NOTICE: " . $this->error["error"] . $this->CRLF . '<br />';
    }
    return false;
  }

  /**
  * Get the current error
  * @access public
  * @return array
  */
  public function getError() {
    return $this->error;
  }

  /////////////////////////////////////////////////
  // INTERNAL FUNCTIONS
  /////////////////////////////////////////////////

  /**
   * Read in as many lines as possible
   * either before eof or socket timeout occurs on the operation.
   * With SMTP we can tell if we have more lines to read if the
   * 4th character is '-' symbol. If it is a space then we don't
   * need to read anything else.
   * @access private
   * @return string
   */
  private function get_lines() {
    $data = "";
    while($str = @fgets($this->smtp_conn,515))
    {
      if($this->do_debug >= 4) {
        echo "SMTP -> get_lines(): \$data was \"$data\"" . $this->CRLF . '<br />';
        echo "SMTP -> get_lines(): \$str is \"$str\"" . $this->CRLF . '<br />';
      }
      $data .= $str;
      if($this->do_debug >= 4) {
        echo "SMTP -> get_lines(): \$data is \"$data\"" . $this->CRLF . '<br />';
      }
      // if 4th character is a space, we are done reading, break the loop
      if(substr($str,3,1) == " ") { break; }
    }
    return $data;
  }

}

/**
 +------------------------------------------------------------------------------
 * 邮件类
 * 基于phpmailer进行封装,支持链式操作
 +------------------------------------------------------------------------------
 * @version 4.0
 * @author WangXian
 * @package libraries
 * @email wo@wangxian.me
 * @creation_date 2011-8-3
 * @last_modified 2011-8-3
 +------------------------------------------------------------------------------
 */
class Email
{
	private $smtp_host		= "";		// SMTP Server.  Example: mail.earthlink.net
	private	$smtp_user		= "";		// SMTP Username
	private	$smtp_pass		= "";		// SMTP Password
	private	$smtp_port		= 25;		// SMTP Port

	private $from      = ''; //发件人
	private $from_name = ''; //发件人名称
	private $to 	   = array(); //收件人
	private $cc 	   = array(); //抄送人列表
	private $bcc 	   = array(); //密送人列表

	private $subject   = ''; //邮件标题
	private $message   = ''; //邮件内容

	private $attach    = array(); //邮件附件


	/**
	 * 构造函数
	 * @param $smtp_host
	 * @param $smtp_user
	 * @param $smtp_pass //密码
	 * @param $smtp_port //端口，默认25
	 */
	function __construct($smtp_host, $smtp_user, $smtp_pass, $smtp_port=25)
	{
		$this->smtp_host = $smtp_host;
		$this->smtp_user = $smtp_user;
		$this->smtp_pass = $smtp_pass;
		$this->smtp_port = $smtp_port;
	}

	/**
	 * 发件人
	 * @param string $from
	 * @param string $from_name
	 * @return object $this
	 */
	public function from($from, $from_name='')
	{
		$this->from = $from;
		$this->from_name = $from_name;
		return $this;
	}

	/**
	 * 收件人
	 * @param mixed $emails 一个string，多个为array()
	 * @return object $this
	 */
	public function to($emails)
	{
		if( is_array($emails) ) $this->to = $emails;
		else $this->to = (array)$emails;
		return $this;
	}

	/**
	 * 抄送
	 * @param mixed $emails 一个string，多个为array()
	 * @return object $this
	 */
	public function cc($emails)
	{
		if( is_array($emails) ) $this->cc = $emails;
		else $this->cc = (array)$emails;
		return $this;
	}

	/**
	 * 密送
	 * @param mixed $emails 一个string，多个为array()
	 * @return object $this
	 */
	public function bcc($emails)
	{
		if( is_array($emails) ) $this->bcc = $emails;
		else $this->bcc = (array)$emails;
		return $this;
	}

	/**
	 * 设置邮件标题
	 * @param string $subject
	 * @return object $this
	 */
	public function subject($subject)
	{
		$this->subject = $subject;
		return $this;
	}

	/**
	 * 邮件内容，可以是html文档
	 * @param string $msg 邮件内容
	 * @return object $this
	 */
	public function message($msg)
	{
		$this->message = $msg;
		return $this;
	}

	/**
	 * 邮件附件，一个或多个，多个为数组
	 * @param string $attach 文件绝对路径
	 * @return object $this
	 */
	public function attach($attach)
	{
		if( is_array($attach) ) $this->attach = $attach;
		else $this->attach = (array)$attach;
		return $this;
	}

	/**
	 * 发送邮件
	 * @return boolean
	 */
	public function send()
	{
		$mail = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP

		$mail->SMTPDebug  = 1;	// enables SMTP debug information (for testing)
								// 1 = errors and messages
								// 2 = messages only
		$mail->Host       = $this->smtp_host; // SMTP server
		$mail->Username   = $this->smtp_user; // SMTP account username
		$mail->Password   = $this->smtp_pass; // SMTP account password
		$mail->Port		  = $this->smtp_port;

		$mail->SetFrom($this->from, $this->from_name);
		$mail->Subject    = $this->subject; //邮件标题
		$mail->MsgHTML( $this->message );   //邮件内容

		//收件人列表
		$count_to = count($this->to);
		for($i=0;$i<$count_to;$i++)
		{
		   $mail->AddAddress($this->to[$i]);
		}

		// cc
		$count_cc = count($this->cc);
		for($i=0;$i<$count_cc;$i++)
		{
			$mail->AddCC( $this->cc[$i] );
		}

		// bcc
		$count_bcc = count($this->bcc);
		for($i=0;$i<$count_bcc;$i++)
		{
		   $mail->AddBCC( $this->bcc[$i] );
		}

		//附件列表
		$count_attach = count($this->attach);
		for($j=0;$j<$count_attach;$j++)
		{
			$mail->AddAttachment($this->attach[$j]);
		}


		if( $mail->Send() ) return true;
		else return array('message'=>$mail->ErrorInfo);

	}

	/**
	 * test
	 * @ignore
	 */
	function smail($emails,$title,$attachment=array())
	{
		$mail             = new PHPMailer();
		$body             = '我是标题，怎么了！';

		$mail->CharSet = "UTF-8";
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
	    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		//$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
		$mail->SMTPDebug  = 1;           // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only

		$mail->Host       = "smtp.sina.com"; // SMTP server
		$mail->Username   = "mcp8815@sina.com"; // SMTP account username
		$mail->Password   = "/*mcp8815123456*/";        // SMTP account password


		$mail->SetFrom($mail->Username, '[抓取工具]');
		//$mail->AddReplyTo("name@yourdomain.com","First Last");
		$mail->Subject    = $title; //邮件标题
		$mail->MsgHTML($body); //邮件内容

		//收件人列表
		for($i=0;$i<count($emails);$i++)
		{
		   $mail->AddAddress($emails[$i]);
		}

		//附件列表
		for($j=0;$j<count($attachment);$j++)
		{
			$mail->AddAttachment($attachment[$j]);
		}

		if(!$mail->Send())
		  echo "Mailer Error: " . $mail->ErrorInfo."\n";
		else
		  echo "Message sent!\n";
	}
}

/* End of file Email.class.php */
/* Location: ./ePHP/libraries/Email.class.php */