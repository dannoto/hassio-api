<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Action extends CI_Controller
{

    function __construct()
    {

        parent::__construct();

        $this->load->model('main_model');
    }

    // exist_adepto
    public function SGVsbG8gd29ybGQ()
    {

        header("Content-Type: application/json");


        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $response = array();

            $adepto_site = $this->input->post('SGVsbG8gd29ybGQ');
            $adepto_site = parse_url($adepto_site, PHP_URL_SCHEME) . '://' . parse_url($adepto_site, PHP_URL_HOST)."/";



            if ($this->main_model->existAdepto($adepto_site)) {

                $response = array("status" => "true", "site" => $adepto_site);
                
            } else {

                $response = array("status" => "false", "site" => $adepto_site);
            }

            print_r(json_encode($response));
           
        }
    }
    
    // Insert adepto
    public function aW5zZXJ0X2FkZXB0bw()
    {

        header("Content-Type: application/json");


        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $response = array();


            $adepto_site = $this->input->post('SGVsbG8gd29ybGQ');

            
            
            if (strpos($adepto_site, "?") !== false ) {
                $main = 0;
            } else {
                $main = $this->input->post('main');
            }
            


            if ($this->main_model->insertAdepto($adepto_site, $main)) {

                $response = array("status" => "true", "site" => $adepto_site);
            } else {

                $response = array("status" => "false", "site" => $adepto_site);
            }

            print_r(json_encode($response));
           
        }
    }

    public function YTWGGLH2895N12()
    {

        header("Content-Type: application/json");


        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $response = array();

            $adepto_site = $this->input->post('SGVsbG8gd29ybGQ');
            $adepto_site = parse_url($adepto_site, PHP_URL_SCHEME) . '://' . parse_url($adepto_site, PHP_URL_HOST)."/";

    
            if ($this->main_model->insertAdeptoMain($adepto_site)) {

                $response = array("status" => "true", "site" => $adepto_site);
            } else {

                $response = array("status" => "false", "site" => $adepto_site);
            }

            print_r(json_encode($response));
           
        }
    }

    // GetAdepto
    public function Z2V0X2FkZXB0bw()
    {
        header("Content-Type: application/json");


        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $response = array();

            $adepto_site = $this->input->post('SGVsbG8gd29ybGQ');
            
            $adepto_site = parse_url($adepto_site, PHP_URL_SCHEME) . '://' . parse_url($adepto_site, PHP_URL_HOST)."/";


            if ($this->main_model->getAdepto($adepto_site)) {

                $response = $this->main_model->getAdepto($adepto_site);
            } else {

                $response = array("status" => "false", "site" => $adepto_site);
            }

            print_r(json_encode($response));
           
        }
    }

    // Cliques no visitante
    public function Y2xpcXVlc19uby12aXRhbWVudGU()
    {
   
        header("Content-Type: application/json");


        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $response = array();

            $adepto_site = htmlspecialchars($this->input->post('adp'));
            $link_clicado = htmlspecialchars($this->input->post('click'));
            $visitante_origem = htmlspecialchars($this->input->post('origin'));


            if ($this->main_model->cliques_no_visitante($adepto_site, $link_clicado, $visitante_origem)) {

                $response = array("status" => "true", "site" => $adepto_site);
            } else {

                $response = array("status" => "false", "site" => $adepto_site);
            }

            print_r(json_encode($response));
           
        }
    }
}
