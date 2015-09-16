<?php

class Newsletter       
{
    public static function AddEmail($newsletterEmail, $newsletterSubject, $newsletterSender, $newsletterCompanyNews, $newsletterLegal, $newsletterEvents, $newsletterCat1, $newsletterCat2, $newsletterCat3, $newsletterCat4, $newsletterCat5, $newsletterAllCat)
    {
        require_once SWIFTMAIL_DIR . 'swift_required.php';

        $mActiveLang = Language::GetName();

        if ($mActiveLang == 'gr')
        {
            // Get a unique confirmation ID
            $confid = md5(uniqid(rand(), true));
            // Build the SQL query
            $sql = 'CALL newsletter_add_email(:newsletter_email, :confirmation_id, :newsletter_company_news, :newsletter_legal, :newsletter_events,
                                             :newsletter_cat1, :newsletter_cat2, :newsletter_cat3, :newsletter_cat4, :newsletter_cat5, :newsletter_allcat)';

            // Build the parameters array
            $params = array (':newsletter_email' => $newsletterEmail, 
                ':confirmation_id' => $confid,
                ':newsletter_company_news' => $newsletterCompanyNews, 
                ':newsletter_legal' => $newsletterLegal, 
                ':newsletter_events' => $newsletterEvents, 
                ':newsletter_cat1' => $newsletterCat1, 
                ':newsletter_cat2' => $newsletterCat2, 
                ':newsletter_cat3' => $newsletterCat3,
                ':newsletter_cat4' => $newsletterCat4,
                ':newsletter_cat5' => $newsletterCat5,
                ':newsletter_allcat' => $newsletterAllCat);

            // Execute the query and return the results
            $ret = DatabaseHandler::GetOne($sql, $params);
            

            if ($ret == false)
                return 0;

            //Create the Transport (this is the account of the mailer deamon)
            $transport = Swift_SmtpTransport::newInstance(SMTP_HOST, SMTP_PORT, SMTP_CRYPTO)
                ->setUsername(MAIL_SENDER)
                ->setPassword(MAIL_SENDER_PASS);

            $mailer = Swift_Mailer::newInstance($transport); 

            
            $message = Swift_Message::newInstance()

                //Give the message a subject
                ->setSubject(strip_tags($newsletterSubject))

                ->setFrom(array(MAIL_SENDER => $newsletterSender))

                //Set the To addresses with an associative array
                ->setTo(array($_POST['newsletter_email'] => ''))

                //Give it a body
                ->setBody('Αγαπητή κυρία, Αγαπητέ κύριε, <br>για να ολοκληρωθεί η εγγραφή σας στο newsletter της ΤÜV AUSTRIA Hellas
                κάντε κλικ <a href="'. Link::ToNewsletterSignupConfirm($_POST['newsletter_email'], $confid) . 
                '" target="_blank"><b><u>εδώ</u></b></a>. <br><br>Προσοχή: Το παρόν email ισχύει για 24 ώρες 
                από τη στιγμή που λάβατε το email αυτό.<br>Μετά τις 24 ώρες θα πρέπει να επαναλάβετε τη διαδικασία από την αρχή.
                <br><br>Ευχαριστούμε', 'text/html');
        }
        else
        {
            $confid = md5(uniqid(rand(), true));

            // Build the SQL query
            $sql = 'CALL newsletter_add_email(:newsletter_email, :confirmation_id, :newsletter_company_news, :newsletter_legal, :newsletter_events,
                                             :newsletter_cat1, :newsletter_cat2, :newsletter_cat3, :newsletter_cat4, :newsletter_cat5, :newsletter_allcat)';

            // Build the parameters array
            $params = array (':newsletter_email' => $newsletterEmail, 
                ':confirmation_id' => $confid,
                ':newsletter_company_news' => $newsletterCompanyNews, 
                ':newsletter_legal' => $newsletterLegal, 
                ':newsletter_events' => $newsletterEvents, 
                ':newsletter_cat1' => $newsletterCat1, 
                ':newsletter_cat2' => $newsletterCat2, 
                ':newsletter_cat3' => $newsletterCat3,
                ':newsletter_cat4' => $newsletterCat4,
                ':newsletter_cat5' => $newsletterCat5,
                ':newsletter_allcat' => $newsletterAllCat);


            // Execute the query and return the results
            $ret = DatabaseHandler::GetOne($sql, $params);

            if ($ret == false)
                return 0;

            //if (class_exists('Swift')) echo "class exists";

            //Create the Transport (this is the account of the mailer deamon)
            $transport = Swift_SmtpTransport::newInstance(SMTP_HOST, SMTP_PORT, SMTP_CRYPTO)
                ->setUsername(MAIL_SENDER)
                ->setPassword(MAIL_SENDER_PASS);

            $mailer = Swift_Mailer::newInstance($transport); 

            $message = Swift_Message::newInstance()

                //Give the message a subject
                ->setSubject(strip_tags($newsletterSubject))

                ->setFrom(array(MAIL_SENDER => $newsletterSender))

                //Set the To addresses with an associative array
                ->setTo(array($_POST['newsletter_email'] => ''))

                //Give it a body
                ->setBody('Dear Madame, Dear Sir, <br><br>to complete your registration in the newsletter of ΤÜV AUSTRIA Hellas
                please click on <a href="'. Link::ToNewsletterSignupConfirm($_POST['newsletter_email'], $confid) . 
                '" target="_blank"><b><u>here</u></b></a>. <br><br>Attention: The URL is valid for 24 hours.
                <br><br>After this period you have to repeat the newsletter subscription procedure.
                <br><br>Thank you, <br><br>The ΤÜV AUSTRIA Hellas team.', 'text/html');

        }


        try {
            $result = $mailer->send($message);
            return 1;
        } catch (Exception $e) {
            return -1;
        }
    }
    

    public static function ConfirmEmail($newsletterEmail, $confirmationId)
    {
        // Build the SQL query
        $sql = 'CALL newsletter_confirm_email(:newsletter_email, :confirmation_id)';

        // Build the parameters array
        $params = array (':newsletter_email' => $newsletterEmail, 
            ':confirmation_id' => $confirmationId);

        // Execute the query and return the results
        return DatabaseHandler::GetOne($sql, $params);
    }

    public static function GetEmails($confirmed = null)
    {
        // Build the SQL query
        $sql = 'CALL newsletter_get_emails(:confirmed)';

        // Build the parameters array
        $params = array (':confirmed' => $confirmed);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }

    public static function DeleteEmail($newsletterId)
    {
        // Build the SQL query
        $sql = 'CALL newsletter_delete_email(:newsletter_id)';

        // Build the parameters array
        $params = array (':newsletter_id' => $newsletterId);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
    }
    
    public static function UnsubscribeEmail($newsletter_email)
    {
        require_once SWIFTMAIL_DIR . 'swift_required.php';

        $mActiveLang = Language::GetName();

            //Create the Transport (this is the account of the mailer deamon)
            $transport = Swift_SmtpTransport::newInstance(SMTP_HOST, SMTP_PORT, SMTP_CRYPTO)
                ->setUsername(MAIL_SENDER)
                ->setPassword(MAIL_SENDER_PASS);

            $mailer = Swift_Mailer::newInstance($transport); 

            $message = Swift_Message::newInstance()

                //Give the message a subject
                ->setSubject('Διαγραφή από το newsletter')

                ->setFrom(array(MAIL_SENDER => 'admin@eparxis.com'))

                //Set the To addresses with an associative array
                ->setTo('kostas.mavropoulos@tuvaustriahellas.gr')

                //Give it a body
                ->setBody('Ο χρήστης με ηλεκοντρική διεύθυνση ' . $newsletter_email . ' επέλεξε να διαγραφεί από το newsletter', 'text/html');


        try {
            $result = $mailer->send($message);
            return 1;
        } catch (Exception $e) {
            return -1;
        }
    }

    public static function GetNewsletterTemplateDetails($languageId = null)
    {
        // Get current session's languageId if not specified
        if (is_null($languageId)) {
            $languageId = Language::Get();
        }

        // Build the SQL query
        $sql = 'CALL newsletter_get_template_details(:language_id)';

        // Build the parameters array
        $params = array (':language_id' => $languageId);

        // Execute the query and return the results
        return DatabaseHandler::GetAll($sql, $params);
    }

    public static function EditNewsletterTemplateDetails($newsletterTemplateId, $languageId, $newsletterTemplateTitle, $newsletterTemplateSender, 
        $newsletterPromptMsg, $newsletterButtonMsg, 
        $newsletterWaitMsg, $newsletterConfirmationAlertMsg, $newsletterConfirmationExistingUserMsg,
        $newsletterSubscriptionThankMsg, $newsletterSubscriptionMainMsg, $newsletterSubscriptionFailMsg)
    {

        // Build the SQL query
        $sql = 'CALL newsletter_edit_template_details(:newsletter_template_id, :language_id, :newsletter_template_title, :newsletter_template_sender, 
            :newsletter_prompt_msg, :newsletter_button_msg,
            :newsletter_wait_msg, :newsletter_confirmation_alert_msg, :newsletter_confirmation_existing_user_msg,
            :newsletter_subscription_thank_msg, :newsletter_subscription_main_msg, :newsletter_subscription_fail_msg)';

        // Build the parameters array
        $params = array (':newsletter_template_id' => $newsletterTemplateId,
            ':language_id' => $languageId,
            ':newsletter_template_title' => $newsletterTemplateTitle,
            ':newsletter_template_sender' => $newsletterTemplateSender,
            ':newsletter_prompt_msg' => $newsletterPromptMsg,
            ':newsletter_button_msg' => $newsletterButtonMsg,
            ':newsletter_wait_msg' => $newsletterWaitMsg,
            ':newsletter_confirmation_alert_msg' => $newsletterConfirmationAlertMsg,
            ':newsletter_confirmation_existing_user_msg' => $newsletterConfirmationExistingUserMsg,
            ':newsletter_subscription_thank_msg' => $newsletterSubscriptionThankMsg,
            ':newsletter_subscription_main_msg' => $newsletterSubscriptionMainMsg,
            ':newsletter_subscription_fail_msg' => $newsletterSubscriptionFailMsg);

        // Execute the query and return the results
        DatabaseHandler::Execute($sql, $params);
    }


}

?>
