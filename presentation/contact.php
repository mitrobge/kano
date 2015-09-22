<?php

class Contact
{
    // Public variables to be used in Smarty template
    public $mLinks;
    public $mLinkToHome;
    public $mLinkToSelf;
    public $mShowSuccessMessage = false;
    public $mShowErrorMessage = false;
    public $mCategories;
    public $mActiveLang;


    // Class constructor
    public function __construct()
    {
        $this->mLinkToHome = Link::Build('');
        $this->mLinkToSelf = Link::ToSelf();
        $this->mLinks = array(
            'toOrganization' => Link::ToOrganization(),
            'toProfile' => Link::ToOrganization('profile'),
            'toVision' => Link::ToOrganization('vision'),
            'toMilestones' => Link::ToOrganization('milestones'),
            'toCodeOfEthics' => Link::ToOrganization('code_of_ethics'),
            'toHumanResources' => Link::ToOrganization('human_resources'),
            'toBranches' => Link::ToOrganization('branches'),
            'toCareers' => Link::ToOrganization('careers'),
            'toCareerDetails' => Link::ToOrganization('career-details'),
        );
    }
    

    public function init()
    {
        $this->mActiveLang = Language::GetName();
       
        require_once SWIFTMAIL_DIR . 'swift_required.php';
        
        $this->mCategories = Services::GetCategories();

        // Create the category links
        for ($i = 0; $i < count($this->mCategories); $i++) {
            $this->mCategories[$i]['subcategories'] = 
                Services::GetCategoryChildren($this->mCategories[$i]['category_id']);
            for ($j = 0; $j < count($this->mCategories[$i]['subcategories']); $j++) {
                if ($this->mCategories[$i]['subcategories'][$j]['is_service']) {
                    $this->mCategories[$i]['subcategories'][$j]['link_to_service'] =
                        Link::ToService($this->mCategories[$i]['subcategories'][$j]['id'],
                            $this->mCategories[$i]['category_id']);
                } else {
                    $this->mCategories[$i]['subcategories'][$j]['services'] = 
                        Services::GetServices($this->mCategories[$i]['subcategories'][$j]['id']);
                    for ($z = 0; $z < count($this->mCategories[$i]['subcategories'][$j]['services']); $z++) {
                        $this->mCategories[$i]['subcategories'][$j]['services'][$z]['link_to_service'] =
                            Link::ToService($this->mCategories[$i]['subcategories'][$j]['services'][$z]['service_id'],
                                $this->mCategories[$i]['category_id']);
                    }
                }
            }
        }
        
        $admins_array = array();
            
            $admins = Administrator::GetWithPermission('ADMIN_CONTACT');
        
            for ($i = 0; $i < count($admins); $i++)
                    $admins_array[$admins[$i]['email']] = 
                    $admins[$i]['first_name'] . ' ' . $admins[$i]['last_name'];

        if (isset($_POST['contact_f1_submit'])) {
            
        //Create the Transport (this is the account of the mailer deamon)
            $transport = Swift_SmtpTransport::newInstance(SMTP_HOST, SMTP_PORT, SMTP_CRYPTO)
                ->setUsername(MAIL_SENDER)
                ->setPassword(MAIL_SENDER_PASS);

            $mailer = Swift_Mailer::newInstance($transport); 

            $message1 = Swift_Message::newInstance()
                
            //Give the message a subject
            ->setSubject('Επικοινωνία:Προσφορά')

            ->setFrom(array(MAIL_SENDER => 'TÜV AUSTRIA Hellas'))

            //Set the To addresses with an associative array
            ->setTo($admins_array)

            //Give it a body
            ->setBody('This is an automatically generated email:'.
                      '<BR><BR><B>Όνομα εταιρείας: </B>'. $_POST['company_name_1']. 
                      '<BR><BR><B>Όνομα υπευθύνου: </B>'. $_POST['company_responsible_1']. 
                      '<BR><BR><B>Υπηρεσία: </B>'.$_POST['standard_1'].
                      '<BR><BR><B>Τηλέφωνο: </B>'.$_POST['company_phone_1'].
                      '<BR><BR><B>Πόλη: </B>'.$_POST['company_address_1'].
                      '<BR><BR><B>E-mail: </B>'.$_POST['company_email_1'].
                      '<BR><BR><B>Σχόλια: </B>'.$_POST['message_1'],
                      'text/html');
            try {
                $result = $mailer->send($message1);
                $this->mShowSuccessMessage = true;
                return 0;
            } catch (Exception $e) {
                $this->mShowErrorMessage = true;
                return -1;
            }
        }
        
        if (isset($_POST['contact_f2_submit'])) {
            
        //Create the Transport (this is the account of the mailer deamon)
            $transport = Swift_SmtpTransport::newInstance(SMTP_HOST, SMTP_PORT, SMTP_CRYPTO)
                ->setUsername(MAIL_SENDER)
                ->setPassword(MAIL_SENDER_PASS);

            $mailer = Swift_Mailer::newInstance($transport); 

            $field_2 = array('0' => 'ΟΧΙ', '1' => 'ΟΧΙ', '2' => 'ΟΧΙ', '3' => 'ΟΧΙ', '4' => 'ΟΧΙ' );


            if(!empty($_POST['field_2'])){
            foreach($_POST['field_2'] as $key=>$value)
            {
                $field_2[$value]='ΝΑΙ';
            }
            }


            $message2 = Swift_Message::newInstance()

            //Give the message a subject
            ->setSubject('Επικοινωνία:Ενημέρωση')

            ->setFrom(array(MAIL_SENDER => 'TÜV AUSTRIA Hellas'))

            //Set the To addresses with an associative array
            ->setTo($admins_array)

            //Give it a body
                                    
            ->setBody('This is an automatically generated email:'.
                      '<BR><BR><B>Πιστοποίησης Συστημάτων Διαχείρισης & Προϊόντων: </B>'.$field_2[0].
                      '<BR><BR><B>Ανελκυστήρων και Ανυψωτικών Μηχανημάτων: </B>'.$field_2[1].
                      '<BR><BR><B>Βιομηχανικών Ελέγχων: </B>'.$field_2[2].
                      '<BR><BR><B>Πιστοποίησης προσώπων: </B>'.$field_2[3].
                      '<BR><BR><B>Εκπαίδευσης: </B>'.$field_2[4].
                      '<BR><BR><B>Όνομα εταιρείας: </B>'.$_POST['company_name_2'].
                      '<BR><BR><B>Όνομα υπευθύνου: </B>'.$_POST['company_responsible_2'].
                      '<BR><BR><B>E-mail: </B>'.$_POST['company_email_2'].
                      '<BR><BR><B>Τηλέφωνο: </B>'.$_POST['company_phone_2'].
                      '<BR><BR><B>Σχόλια: </B>'.$_POST['message_2'],
                      'text/html');
            try {
                $result = $mailer->send($message2);
                $this->mShowSuccessMessage = true;
                return 0;
            } catch (Exception $e) {
                $this->mShowErrorMessage = true;
                return -1;
            }
        }

        if (isset($_POST['contact_f3_submit'])) {
            
        //Create the Transport (this is the account of the mailer deamon)
            $transport = Swift_SmtpTransport::newInstance(SMTP_HOST, SMTP_PORT, SMTP_CRYPTO)
                ->setUsername(MAIL_SENDER)
                ->setPassword(MAIL_SENDER_PASS);

            $mailer = Swift_Mailer::newInstance($transport); 

            $message3 = Swift_Message::newInstance()

            //Give the message a subject
            ->setSubject('Επικοινωνία: Παράπονα')

            ->setFrom(array(MAIL_SENDER => 'TÜV AUSTRIA Hellas'))

            //Set the To addresses with an associative array
            ->setTo($admins_array)

            //Give it a body
                            
            ->setBody('This is an automatically generated email:'.
                      '<BR><BR><B>Όνομα εταιρείας: </B>'. $_POST['company_name_3']. 
                      '<BR><BR><B>Όνομα υπευθύνου: </B>'. $_POST['company_responsible_3']. 
                      '<BR><BR><B>E-mail: </B>'.$_POST['company_email_3'].
                      '<BR><BR><B>Τηλέφωνο: </B>'.$_POST['company_phone_3'].
                      '<BR><BR><B>Σχόλια: </B>'.$_POST['message_3'],
                      'text/html');
            try {
                $result = $mailer->send($message3);
                $this->mShowSuccessMessage = true;
                return 0;
            } catch (Exception $e) {
                $this->mShowErrorMessage = true;
                return -1;
            }
        }

    }

}

?>

