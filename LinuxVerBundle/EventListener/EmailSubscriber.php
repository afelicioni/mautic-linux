<?php
namespace MauticPlugin\LinuxVerBundle\EventListener;

use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Event\EmailBuilderEvent;
use Mautic\EmailBundle\Event\EmailSendEvent;

/**
 * Class EmailSubscriber
 */
class EmailSubscriber extends CommonSubscriber
{

    /**
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return array(
            EmailEvents::EMAIL_ON_BUILD   => array('onEmailBuild', 0),
            EmailEvents::EMAIL_ON_SEND    => array('onEmailGenerate', 0),
            EmailEvents::EMAIL_ON_DISPLAY => array('onEmailGenerate', 0)
        );
    }

    /**
     * @param EmailBuilderEvent $event
     */
    public function onEmailBuild(EmailBuilderEvent $event)
    {
        $content = $this->templating->render('LinuxVerBundle:SubscribedEvents\EmailToken:token.html.php');
        $event->addTokenSection('linuxver.token', 'plugin.linuxver.builder.header', $content);

    }

    /**
     * @param EmailSendEvent $event
     */
    public function onEmailGenerate(EmailSendEvent $event)
    {
        $oLVExtra = $this->getExtra();

        $sCodiceHTML = '';
        $sCodiceHTML .= '<b>Latest Stable Kernel</b><br />';
        $sCodiceHTML .= ''.$oLVExtra->ver.'';

        $sCodiceTesto = '';
        $sCodiceTesto .= 'Latest Stable Kernel'."\n";
        $sCodiceTesto .= ''.$oLVExtra->ver.''."\n";

        $content = $event->getContent();
        $content = str_replace('{linuxver_lastver}', $sCodiceHTML, $content);
        $event->setContent($content);
        $contentText = $event->getPlainText();
        $contentText = str_replace('{linuxver_lastver}', $sCodiceTesto, $contentText);
        $event->setPlainText($contentText);

        //$event->addToken('{linuxver_lastver}', $sCodice);
    }

    /**
     * @return array
     */
    private function getExtra()
    {
        $extra = new \stdClass;
        $extra->ver = NULL;

        //recupero contenuto remoto
        $sURL = "https://www.kernel.org/";
        $hCURL = curl_init($sURL);
        curl_setopt($hCURL, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($hCURL, CURLOPT_SSL_VERIFYPEER, false);
        $sOutput = curl_exec($hCURL);
        curl_close($hCURL);

        //estrazione contenuto
        $oDoc = new \DOMDocument;
        $oDoc->loadHTML($sOutput);
        $oXP = new \DOMXPath($oDoc);

        $oElemento= $oXP->query('//*[@id="latest_link"]/a');
        $extra->ver = trim($oElemento->item(0)->nodeValue);

        return $extra;
    }
}