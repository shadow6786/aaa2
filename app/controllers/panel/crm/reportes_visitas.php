<?php
class Reportes_visitas extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('pdf');
		$this->load->helper(array('form','url','codegen_helper','invertir_fecha','settings'));
		$this->load->model('panel/crm/visitas_model');
		$this->load->model('panel/crm/clasificaciones_model');
		$this->load->model('panel/sec/users_model');
		$this->load->model('panel/auth/mysecurity');
		$this->mysecurity->verifysecurity('rep_vst');
		
	}
	function index()
	{
		$this->load->library('form_validation');
		$this->data['custom_error'] = '';
		
		$this->form_validation->set_rules('fecha_ini','Fecha inicio','required|trim|xss_clean');
		$this->form_validation->set_rules('fecha_fin','fecha fin','required|trim|xss_clean');
		$this->form_validation->set_rules('clasificacion_vst','Clasificación','trim|xss_clean');
		
		if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {
         
		 //$this->output->enable_profiler(TRUE);
         $conf = load_settings();
		 $rolus = $this->users_model->get_usuario_roles($this->session->userdata('id_usr'));
		 $op = 0;
		 
		 if (in_array($conf['gerente_id'], $rolus))
		 {
		 	$op = 1;
		 }elseif (in_array($conf['supervisor_id'], $rolus))
		  {
		 	$op = 2;
		  }elseif(in_array($conf['vendedor_id'], $rolus))
		  {
		 	$op = 3;
		  }
		/* 
		 echo "USR:" . $this->session->userdata('id_usr');
		 echo "<br/>";
		  echo "OP:" . $op;
		   echo "<br/>";
		  echo "conf:" . $conf['gerente_id'];
		    echo "sup:" . $conf['supervisor_id'];
			  echo "vend:" . $conf['vendedor_id'];
		  echo "<br/>";
		  echo "ROLUS:";
		  print_r($rolus);
		  
		  */
		  if ($op ==0)
		  {
			echo "Ha sido imposible acceder al reporte";	
			exit;
		}
			
			
			 //get query vist report
			 $reporte = $this->visitas_model->get_reporte_visita_general(invierte_fecha_mysql($this->input->post('fecha_ini')),invierte_fecha_mysql($this->input->post('fecha_fin')),$this->input->post('clasificacion_vst'),$op,$this->session->userdata('id_usr'));
			 $data['op'] = $op;
			 $data['reporte'] = $reporte;
			 $data['fecha_ini'] = invierte_fecha_mysql($this->input->post('fecha_ini'));
			 $data['fecha_fin'] = invierte_fecha_mysql($this->input->post('fecha_fin'));
			 if ($this->input->post('clasificacion_vst') == 0){
				$data['clasificacion'] = "Todas";
			 }else
			 {
				$clas = $this->clasificaciones_model->get_clasificaciones_combo('nombre_cla',array('id_cla'=>$this->input->post('clasificacion_vst')));
				$data['clasificacion'] = $clas[0]['nombre_cla'];
			 }
			 //var_dump($reporte);
			 //exit;
			 ob_start();
			
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	
			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(0);
			//$pdf->SetFooterMargin(0);
			#desactivamos encabezado y pie de página
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			# el método SetAuthor nos permite incluir el nombre del autor
			$pdf->SetAuthor('Big-Ric.com');
			# el método SetCreator nos permite incluir el nombre de la
			# aplicacion que genera el pdf
			$pdf->SetCreator('Big-Ric.com');
			# el método SetTitle nos permite incluir un título
			$pdf->SetTitle('Reporte de vistas');
			# el método SetKeywords nos permite incluir palabras claves
			# separadas por espacios y dentro de una misma cadena
			$pdf->SetKeywords('Visitas vendedor supervisor gerente');
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
			// set default font subsetting mode
			$pdf->setFontSubsetting(true);
			// set font
			$pdf->SetFont('helvetica', '', 10);
	
			// Add a page
			// This method has several options, check the source code documentation for more information.
			$pdf->AddPage();
			
			//***Load view report general visit***
			$html = $this->load->view('panel/crm/reporte_visita_generado',$data,TRUE);
			#*************************************
			// Print text using writeHTMLCell()
			$pdf->writeHTML($html, true, false, true, false, '');
	
			// ---------------------------------------------------------
			//ob_flush();
			$name_file = "reporte-".time().".pdf";
			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$pdf->Output($name_file, 'D');
			
			}
			
			$this->data['clasificaciones'] = $this->clasificaciones_model->get_clasificaciones_combo('id_cla,nombre_cla','');
			$this->data["title"] = "Reporte visitas";
			$this->data["page_segment"] = "Reporte visitas";
			$this->data["scripts"]=array('plugins/bootstrap/js/bootstrap.js',
										 'plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
			$this->data["father"]="CRM";
			$this->data['main_content'] = 'panel/crm/reporte_visita_general';
			$this->load->view('panel/panel_template',$this->data);
		
	}
}