<?php

/**
 * Mailer class
 */
class FW_Mailer
{
	/**
	  * Send mail
	  *
	  * @param string $sBody - message text body
	  * @param string $sToAddress - address to
	  * @param string $sToName - name to
	  * @param string $sFromAddress - address from
	  * @param string $sFromName - name from
	  * @param string $sSubject - subject
	  *
	  * @return bool
	  */
	public static function send(
	    $sBody, $sToAddress, $sToName, $sFromAddress, $sFromName, $sSubject
	)
	{
		$config = array('auth' => 'login',
				'username' => 'robot@sites-vip.com',
				'password' => 'qweqwetrewq',
				'ssl' => 'tls');

		$tr = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
		Zend_Mail::setDefaultTransport($tr);

		$oMail = new Zend_Mail('UTF-8');

		$oMail->setBodyHtml($sBody);
		$oMail->setFrom($sFromAddress, $sFromName);
		$oMail->setReplyTo($sFromAddress, $sFromName);
		$oMail->addTo($sToAddress, $sToName);
		$oMail->setSubject($sSubject);

		if (APPLICATION_ENV == 'testing')
		{
		    return true;
		}

		if ($oMail->send()) {
		    return true;
		} else {
//			Logger::log(
//				'Mailer::send: error  Zend_Mail->send() ',
//			    $iPriority = Zend_Log::ERR
//            );
		}
		return false;
	}

	public static function sendToSite($fromName, $fromEmail, $message)
    {
        self::send(
            $message,
            'pavel_lagoda@ukr.net',
            'МФК Монолит',
            $fromEmail,
            $fromName,
            'Message from Site'
        );

    }

}
