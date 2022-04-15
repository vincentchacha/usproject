<?php

namespace App\Controllers;

class Collect_leads extends App_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        show_404();
    }

    //save external lead
    function save() {
        if (!get_setting("can_create_lead_from_public_form")) {
            show_404();
        }

        $this->validate_submitted_data(array(
            "company_name" => "required",
        ));

        //validate duplicate email address
        if ($this->request->getPost('email') && $this->Users_model->is_email_exists(trim($this->request->getPost('email')))) {
            echo json_encode(array("success" => false, 'message' => app_lang('duplicate_email')));
            exit();
        }

        $leads_data = array(
            "company_name" => $this->request->getPost('company_name'),
            "address" => $this->request->getPost('address'),
            "city" => $this->request->getPost('city'),
            "state" => $this->request->getPost('state'),
            "zip" => $this->request->getPost('zip'),
            "country" => $this->request->getPost('country'),
            "phone" => $this->request->getPost('phone'),
            "is_lead" => 1,
            "lead_status_id" => $this->Lead_status_model->get_first_status(),
            "created_date" => get_current_utc_time(),
            "owner_id" => 1 //add default admin
        );

        $leads_data = clean_data($leads_data);
        $lead_id = $this->Clients_model->ci_save($leads_data);

        if ($lead_id) {
            //lead created, create a contact on that lead
            $lead_contact_data = array(
                "first_name" => $this->request->getPost('first_name'),
                "last_name" => $this->request->getPost('last_name'),
                "client_id" => $lead_id,
                "user_type" => "lead",
                "email" => trim($this->request->getPost('email')),
                "created_at" => get_current_utc_time(),
                "is_primary_contact" => 1
            );

            $lead_contact_data = clean_data($lead_contact_data);
            $lead_contact_id = $this->Users_model->ci_save($lead_contact_data);

            if ($lead_contact_id) {
                log_notification("lead_created", array("lead_id" => $lead_id), "0");
                echo json_encode(array("success" => true, 'message' => app_lang('lead_created')));
                return true;
            }
        }

        echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
    }

    function lead_html_form_code_modal_form() {
        $lead_html_form_code = view("collect_leads/lead_html_form_code");
        $view_data['lead_html_form_code'] = $lead_html_form_code;

        return $this->template->view('collect_leads/lead_html_form_code_modal_form', $view_data);
    }

}

/* End of file Collect_leads.php */
/* Location: ./app/controllers/Collect_leads.php */