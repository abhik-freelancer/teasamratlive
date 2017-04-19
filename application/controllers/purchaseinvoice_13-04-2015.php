<?php 
//we need to call PHP's session object to access it through CI
class Purchaseinvoice extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   
   	//$this->load->helper('createbody_helper');
    //$this->load->helper('sessiondata_helper');
	
    $this->load->model('vendormastermodel','',TRUE);
    $this->load->model('warehousemastermodel','',TRUE);
	$this->load->model('grademastermodel','',TRUE);
	$this->load->model('gardenmastermodel','',TRUE);
	$this->load->model('purchaseinvoicemastermodel','',TRUE);
	 
}
	
 function index()
 {
   
   
     /*load session data*/	
	
	 $session = sessiondata_method();
		 
	/*get the detail of the page body*/
	
	 $headercontent['vendor'] = $this->vendormastermodel->vendorlist($session);
	 $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();
	 $headercontent['grade'] = $this->grademastermodel->gradelist();
	 $headercontent['garden'] = $this->gardenmastermodel->gardenlist();
	 $headercontent['teagroup'] = $this->purchaseinvoicemastermodel->teagrouplist();
	 $result1 = $this->purchaseinvoicemastermodel->getCurrentservicetax($session['startyear'].'-04-01',$session['endyear'].'-03-31');
	 $result2 = $this->purchaseinvoicemastermodel->getCurrentvatrate($session['startyear'].'-04-01',$session['endyear'].'-03-31');
	 $result['servicetax'] = $result1;
	 $result['vatrate'] = $result2;
	
	
	 $page = 'purchase_invoice/add_view';
	 $header = '';
	 
	/*load helper class to create view*/
	
	createbody_method($result,$page,$header,$session,$headercontent);
		
 	
 }
 
 	
	
	function callSamplepage()
	{
		$page = 'purchase_invoice/sample_view';
		$this->load->view($page, '');
		
	}
	
	function savedata()
	{
		
		 $session = sessiondata_method();
		$value['purchase_invoice_number'] =  $this->input->post('taxinvoice');
		$value['sale_number'] =  $this->input->post('salenumber');
		$value['purchase_invoice_date'] =  date("Y-m-d", strtotime($this->input->post('taxinvoicedate')));
		$value['sale_date'] =  date("Y-m-d", strtotime($this->input->post('saledate')));
		if($this->input->post('vendor') > 0)
		{
			$value['vendor_id'] =  $this->input->post('vendor');
		}
		$value['promt_date'] =  date("Y-m-d", strtotime($this->input->post('promtdate')));
		$value['tea_value'] = $this->input->post('teavalueinput');
		$value['brokerage'] = $this->input->post('brokerageinput');
		$value['service_tax'] = $this->input->post('servicetaxinput');
		//$value['type'] =  $this->input->post('type');
		//$value['rate_type_value'] = $this->input->post('optionrate');
		$value['total_vat'] = $this->input->post('calculatevatinput');
		$value['total_cst'] = $this->input->post('calculatecstinput');
		$value['chestage_allowance'] = $this->input->post('chestallow');
		$value['stamp'] =  $this->input->post('stampcharge');
		$value['total'] =  $this->input->post('totalinput');
		$value['company_id'] =  $session['company'];
		$value['year_id'] = $session['yearid'];
		$value['from_where'] = "AS";
		$status = $this->purchaseinvoicemastermodel->saveInvoicemaster($value);
		
		// $count = $this->input->post('countdetail');
		 $lotarr =  ($this->input->post('detaillot'));
		 $count = (count( $lotarr));
		 $doarr =  ($this->input->post('detaildo'));
		 $invoicearr = ($this->input->post('detailinvoice'));
		 $netarr = ($this->input->post('detailnet'));
		 $warehouseidarr = ($this->input->post('detailwarehouseid'));
		 $gardenidarr = ($this->input->post('detailgardenid'));
		 $gradeidarr = ($this->input->post('detailgradeid'));
		 $gpnoidarr = ($this->input->post('detailgpno'));
		 $dtarr = $this->input->post('detaildate');
		 $chfromarr = ($this->input->post('detailchfrom'));
		 $chtoarr = ($this->input->post('detailchto'));
		 $packagearr = ($this->input->post('detailpackage'));
		 $stamparr = ($this->input->post('detailstamp'));
		 $grossarr = ($this->input->post('detailgross'));
		 $brokarr = ($this->input->post('detaillistbrokerage'));
		 $vatarr = ($this->input->post('detailvat'));
		 $pricearr = ($this->input->post('detailprice'));
		 $staxarr = ($this->input->post('detailstax'));
		 $valuearr = ($this->input->post('detailvalue'));
		 $listtotalarr = ($this->input->post('detaillisttotal'));
		 $listtotalweightarr = ($this->input->post('detaillisttweight'));
		 $ratetypearr = ($this->input->post('rate_type'));
		 $ratetypevaluearr = ($this->input->post('detailvat'));
		 $ratetypeidarr = ($this->input->post('rate_type_id'));
		 $servicetaxidarr = ($this->input->post('stax_id'));
		 $detailteagroupidarr = ($this->input->post('detailteagroupid'));
		 	 
		 
		 
		for($i= 0; $i<$count; $i++)
		{
			$value_detail['purchase_master_id']= $status;
			$value_detail['lot']= $lotarr[$i];
			$value_detail['do']=  $doarr[$i];
			$value_detail['invoice_number']= $invoicearr[$i];
			if($gardenidarr[$i] > 0)
			{
				$value_detail['garden_id']= $gardenidarr[$i];
			}
			if($gradeidarr[$i] > 0)
			{
				$value_detail['grade_id']= $gradeidarr[$i];
			}
			if($warehouseidarr[$i] > 0)
			{
				$value_detail['warehouse_id']= $warehouseidarr[$i];
			}
			$value_detail['gp_number']= $gpnoidarr[$i];
			$value_detail['date']= date("Y-m-d", strtotime($dtarr[$i]));
			$value_detail['package']= $packagearr[$i];
			$value_detail['stamp']= $stamparr[$i];
			$value_detail['gross']= $grossarr[$i];
			$value_detail['brokerage']= $brokarr[$i];
			$value_detail['total_weight']= $listtotalweightarr[$i];
			//$value_detail['vat']= $vatarr[$i];
			$value_detail['price']=$pricearr[$i];
			$value_detail['service_tax']=$staxarr[$i];
			$value_detail['value_cost']=$valuearr[$i];
			$value_detail['total_value']=$listtotalarr[$i];
			$value_detail['chest_from']=$chfromarr[$i];
			$value_detail['chest_to']=$chtoarr[$i];
			$value_detail['net']=$netarr[$i];
			$value_detail['rate_type']=$ratetypearr[$i];
			$value_detail['rate_type_value']=$ratetypevaluearr[$i];
			$value_detail['rate_type_id']=$ratetypeidarr[$i];
			$value_detail['service_tax_id']=$servicetaxidarr[$i];
			$value_detail['teagroup_master_id']=$detailteagroupidarr[$i];
			$status2 = $this->purchaseinvoicemastermodel->saveInvoicedetail($value_detail);
			

			$value_item['grade_id'] = $gradeidarr[$i];
			$value_item['garden_id'] = $gardenidarr[$i];
			$value_item['invoice_number'] = $invoicearr[$i];
			$value_item['package'] = $packagearr[$i];
			$value_item['net'] = $netarr[$i];
			$value_item['gross'] = $grossarr[$i];
			$value_item['bill_id'] = $status;
			$value_item['from_where'] = "PR";
			$statusitem = $this->purchaseinvoicemastermodel->saveItemamster($value_item);
			
			
			//$samplenamearr = $this->input->post('samplename');
			//$samplenetarr  = $this->input->post('samplenet');
			$samplenamearr = $this->input->post('detailsamplename');
			$samplenetarr  = $this->input->post('detailsamplenet');
			
			$arrsample = explode('*',$samplenamearr[$i]);
			$arrsamplenet = explode('*',$samplenetarr[$i]);
			
			$sample = 0;
			foreach ($arrsample as $number)
			{
				
				$samplevalue['purchase_invoice_detail_id'] = $status2;
				$samplevalue['sample_number'] = $number;
				$samplevalue['sample_net'] = $arrsamplenet[$sample];
				
				if($number != '')
				{
					$status3 = $this->purchaseinvoicemastermodel->saveInvoicesample($samplevalue);
				}$sample++;
			}
			
			
		}
		
		$lastinsertdata = $this->purchaseinvoicemastermodel->lastvoucherid();
		
		if(count ($lastinsertdata) > 0)
		{	
			$lastid = $lastinsertdata[0]->id;
			$lastyear = $lastinsertdata[0]->year;
		}
		else
		{
			$lastyear = 0;
		}
		$currentyear = date("Y");
		
		
		if($lastyear == $currentyear)
		{
			if($lastid != '')
			{
				$currentid = ($lastid) + 1;
			}
			else
			{
				$currentid = 1;
			}
		
			if($currentid <= 9)
			{
				$currentid = '0000'.$currentid;
			}
			elseif($currentid <= 99)
			{
				$currentid = '000'.$currentid;
			}
			elseif($currentid <= 999)
			{
				$currentid = '00'.$currentid;
			}
			elseif($currentid <= 9999)
			{
				$currentid = '0'.$currentid;
			}
			else
			{
				$currentid = $currentid;	
			}
		 }
		 else
		 {
			 $currentid = '0001';
		 }
		// $this->load->helper('sessiondata_helper');
		
		 
		 
		$year = $session['startyear'].'-'. $session['endyear'];
		
		$valuevoucher['voucher_number'] = "PR/".$currentid.$year;
		$valuevoucher['voucher_date']  = date("Y-m-d", strtotime($this->input->post('taxinvoicedate')));
		$valuevoucher['narration']  = "Purchase Invoice Number ".$this->input->post('taxinvoice').$this->input->post('taxinvoice').$valuevoucher['voucher_date'];
		
		$lastserial = $this->purchaseinvoicemastermodel->getserialnumber($session['company'],$session['yearid']);
		if(count($lastserial) >0)
		{
			$valuevoucher['serial_number'] = ($lastserial[0]->serial_number) + 1;
		}
		else
		{
			$valuevoucher['serial_number'] = 1;
		}
		$valuevoucher['transaction_type'] = "PR";
		$valuevoucher['company_id'] = $session['company'];
		$valuevoucher['created_by'] = $session['user_id'];
		$valuevoucher['year_id'] = $session['yearid'];
		$status4 = $this->purchaseinvoicemastermodel->insertVoucher($valuevoucher);
		
		if($value_detail['rate_type'] == 'V')
		{
			$amount1 = ($value['tea_value'] + $value['brokerage'] + $value['service_tax'] + $value['stamp']) - $value['chestage_allowance'];
			$valuevoucherdetail1['voucher_master_id'] = $status4;
			$valuevoucherdetail1['account_master_id'] = 6;
			$valuevoucherdetail1['voucher_amount'] = $amount1;
			$valuevoucherdetail1['is_debit'] = "Y";
			$status5 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail1);
			
			$amount2 = $value['total_vat'];
			$valuevoucherdetail2['voucher_master_id'] = $status4;
			$valuevoucherdetail2['account_master_id'] = 5;
			$valuevoucherdetail2['voucher_amount'] = $amount2;
			$valuevoucherdetail2['is_debit'] = "Y";
			$status6 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail2);
			
			$amount3 = $value['total'];
			$vendorAcc = $this->purchaseinvoicemastermodel->getVendorAccount($value['vendor_id']);
			$valuevoucherdetail3['voucher_master_id'] = $status4;
			$valuevoucherdetail3['account_master_id'] = $vendorAcc[0]->id;
			$valuevoucherdetail3['voucher_amount'] = $amount3;
			$valuevoucherdetail3['is_debit'] = "N";
			$status7 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail3);

		}
		if($value_detail['rate_type'] == 'C')
		{
			$amount1 = ($value['tea_value'] + $value['brokerage'] + $value['service_tax'] + $value['stamp'] + $value['total_cst']) - $value['chestage_allowance'];
			$valuevoucherdetail1['voucher_master_id'] = $status4;
			$valuevoucherdetail1['account_master_id'] = 6;
			$valuevoucherdetail1['voucher_amount'] = $amount1;
			$valuevoucherdetail1['is_debit'] = "Y";
			$status5 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail1);
			
			$amount3 = $value['total'];
			$vendorAcc = $this->purchaseinvoicemastermodel->getVendorAccount($value['vendor_id']);
			$valuevoucherdetail3['voucher_master_id'] = $status4;
			$valuevoucherdetail3['account_master_id'] = $vendorAcc[0]->id;
			$valuevoucherdetail3['voucher_amount'] = $amount3;
			$valuevoucherdetail3['is_debit'] = "N";
			$status7 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail3);
		}
		
		$bill['bill_id'] = $status;
		$bill['bill_amount'] = $value['total'];
		$bill['company_id'] = $session['company'];
		$bill['year_id'] = $session['yearid'];
		$bill['voucher_id'] = $status4;
		$bill['due_amount'] = $value['total'];
		$bill['from_where'] = "PR";
		$status8 = $this->purchaseinvoicemastermodel->insertVendorBill($bill);
		$status9 = $this->purchaseinvoicemastermodel->updateVoucherid($status4,$status);
		
		//header('Location: '.base_url().'purchaseinvoice/showlistpurchaseinvoice');
		
		 $session = sessiondata_method();
		 $sess_array = array(
				'vendor' => $value['vendor_id'],
         		'startdate' => $session['startyear'].'-04-01',
				'enddate' => $session['endyear'].'-03-31',
				'pryear' => $session['yearid'],
				'prcom' => $session['company']
				
				);
		 
		 $this->session->set_userdata('purchase_invoice_list_detail', $sess_array);
		 redirect('purchaseinvoice/showlistpurchaseinvoice', 'refresh');
	}
	
	
	function showlistpurchaseinvoice()
	{
		
		if($this->session->userdata('logged_in'))
		   {
			 /*load session data*/	
			// $this->load->helper('sessiondata_helper');
			 $session = sessiondata_method();
			
			 
			 $session_purchase = $this->session->userdata('purchase_invoice_list_detail');
			
			 if($session_purchase['vendor'] == '')
			 {
				$session_vendor = 0;
				$session_invoice['vendor'] = 0;
				$session_invoice['startdate'] = $session['startyear'].'-04-01';
				$session_invoice['enddate'] = $session['endyear'].'-03-31';
				$session_invoice['prcom'] = $session['company'];
		        $session_invoice['pryear']  = $session['yearid'];
				//$this->session->set_userdata('purchase_invoice_list_detail', $session_invoice);
				 $result = $this->purchaseinvoicemastermodel->getPurchaselistingdata($session_invoice);
				
			}
			else
			{
				$session_vendor = $session_purchase['vendor'];	 	
				$result = $this->purchaseinvoicemastermodel->getPurchaselistingdata($session_purchase);
			}
			// $session_purchase = $this->session->userdata('purchase_invoice_list_detail');
			
			/*get the detail of the page body*/
			 
			  $headercontent['vendor'] = $this->purchaseinvoicemastermodel->getVendorlist($session_vendor);
						
			 $page = 'purchase_invoice/list_view';
			 $header = 'purchase_invoice/header_view';
			 
			/*load helper class to create view*/
			//$this->load->helper('createbody_helper');
			 createbody_method($result,$page,$header,$session,$headercontent);
				
			}
			
			else
		   {
			 //If no session, redirect to login page
			 redirect('login', 'refresh');
		   }
	}
	
	function getlistpurchaseinvoice()
	{
		 $session = sessiondata_method();
		
		 $vendor = $this->input->post('vendor');
		 $startdate = $this->input->post('startdate');
		 $enddate = $this->input->post('enddate');
		 $company = $session['company'];
		 $year = $session['yearid'];
		  
		 
		   $sess_array = array(
				'vendor' => $vendor,
         		'startdate' => $startdate,
				'enddate' => $enddate,
				'pryear' => $year,
				'prcom' => $company
				
				);
		 
		 $this->session->set_userdata('purchase_invoice_list_detail', $sess_array);
		// $this->purchaseinvoicemastermodel->getPurchaselistingdata($this->session->userdata('purchase_invoice_list_detail'));
		 
		exit;
		
		 
	}
	
	function edit()
	{
	 $uriarr = ($this->uri->ruri_to_assoc(3));
         /*echo('<pre>');
         print_r($uriarr);
         echo('</pre>');*/
	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 $headercontent['vendor'] = $this->vendormastermodel->vendorlist($session);
	 $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();
	 $headercontent['grade'] = $this->grademastermodel->gradelist();
	 $headercontent['garden'] = $this->gardenmastermodel->gardenlist();
	 $headercontent['teagroup'] = $this->purchaseinvoicemastermodel->teagrouplist();
	 $result1 = $this->purchaseinvoicemastermodel->getCurrentservicetax($session['startyear'].'-04-01',$session['endyear'].'-03-31');
	 $result2 = $this->purchaseinvoicemastermodel->getCurrentvatrate($session['startyear'].'-04-01',$session['endyear'].'-03-31');
	 $result3 = $this->purchaseinvoicemastermodel->getCurrentcstrate($session['startyear'].'-04-01',$session['endyear'].'-03-31');
	 $result['servicetax'] = $result1;
	 $result['vatrate'] = $result2;
	 $result['cstrate'] = $result3;
	 $result['invoiceid'] = $uriarr['invoice'];
	 $result['saveddata'] = $this->purchaseinvoicemastermodel->editdata($uriarr['invoice']);
	  
	
	 $page = 'purchase_invoice/edit_view';
	 $header = '';
	 createbody_method($result,$page,$header,$session,$headercontent);
		
	}
	
	function getlistingindetail()
	{
		 $session = sessiondata_method();
		
		 $invoiceid = $this->input->post('id');
		 $result = $this->purchaseinvoicemastermodel->getPurchaselistingdetaildata($invoiceid,$session['yearid'],$session['company']);
		
		 $row = '';
		 
		 foreach($result as $record)
		 {
		 $do = '';
		 if($record->do != '')
		 {
			$do = $record->do;
		 }
		 $stamp = '';
		 if($record->stamp != '')
		 {
			$stamp = $record->stamp;
		 }
		  $brokerage = '';
		 if($record->brokerage != '')
		 {
			$brokerage = $record->brokerage;
		 }
		 $gpnumber = '';
		 if($record->gp_number != '')
		 {
			$gpnumber = $record->gp_number;
		 }
		 $date = '';
		 if($record->date != '')
		 {
			$date = $record->date;
		 }
		  $vat = '';
		  $type = '';
		 if($record->rate_type != '')
		 {
			if($record->rate_type == 'V')
			$type =  'VAT';
			else
			$type =  'CST';
		 }
	
		 if($record->rate_type_value != '')
		 {
			
			$vat = $type.' => '.$record->rate_type_value;
		 }
		  $stax = '';
		 if($record->service_tax != '')
		 {
			$stax = $record->service_tax;
		 }
		 
		 $row .= '<tr  style="border-bottom:1pt solid black;"><td>'.$record->lot.'<br/>'.$do.'</td><td>'.$record->invoice_number.'</td><td>'.$record->garden_name.'<br/>'.$record->name.'</td><td>'.$record->grade.'<br/>'.$record->chest_from.' - '.$record->chest_to.'</td><td>'.$gpnumber.'<br/>'.date("d-m-Y", strtotime($date)).'<input type="hidden"  name="date[]" value="'.$date.'"/></td><td>'.$record->package.'<br/>'.$stamp.'<br/>'.$record->net.'</td><td><table><tr><td>'.str_replace(",","</br>",$record->samplenumber).'</td><td> => </td><td>'.str_replace(",","</br>",$record->samplenet).'</td></tr></table></td><td>'.$record->gross.'<br/>'.$brokerage.'</td><td>'.$record->total_weight.'<br/>'.$vat.'</td><td>'.$record->price.'<br/>'.$stax.'</td><td>'.$record->value_cost.'</td><td>'.$record->total_value.'</td></tr>';
		
			}		
			echo $row;
		 
		 
		
	}
	function update()
	{
		
		$uriarr = ($this->uri->ruri_to_assoc(3));
		 $session = sessiondata_method(); 
		$value['id'] = $uriarr['invoice'];
		$value['purchase_invoice_number'] =  $this->input->post('taxinvoice');
		$value['sale_number'] =  $this->input->post('salenumber');
		$value['purchase_invoice_date'] =  date("Y-m-d", strtotime($this->input->post('taxinvoicedate')));
		$value['sale_date'] =  date("Y-m-d", strtotime($this->input->post('saledate')));
		if($this->input->post('vendor') > 0)
		{
			$value['vendor_id'] =  $this->input->post('vendor');
		}
		$value['promt_date'] =  date("Y-m-d", strtotime($this->input->post('promtdate')));
		$value['tea_value'] = $this->input->post('teavalueinput');
		$value['brokerage'] = $this->input->post('brokerageinput');
		$value['service_tax'] = $this->input->post('servicetaxinput');
		//$value['type'] =  $this->input->post('type');
		//$value['rate_type_value'] = $this->input->post('optionrate');
		$value['total_cst'] =  $this->input->post('calculatecstinput');
		$value['total_vat'] =  $this->input->post('calculatevatinput');
		$value['chestage_allowance'] = $this->input->post('chestallow');
		$value['stamp'] =  $this->input->post('stampcharge');
		$value['total'] =  $this->input->post('totalinput');
		$value['company_id'] =  $session['company'];
		$value['year_id'] = $session['yearid'];
		$value['from_where'] = "AS";
		$status = $this->purchaseinvoicemastermodel->updateInvoicemaster($value);
		
		 $this->purchaseinvoicemastermodel->deleteInvoicemaster($uriarr['invoice']);
				
		// $count = $this->input->post('countdetail');
		 $detailtableidarr =  ($this->input->post('detailtableid'));
		 $lotarr =  ($this->input->post('detaillot'));
	 	 $count = (count( $lotarr));
		 $doarr =  ($this->input->post('detaildo'));
		 $invoicearr = ($this->input->post('detailinvoice'));
		 $netarr = ($this->input->post('detailnet'));
		 $warehouseidarr = ($this->input->post('detailwarehouseid'));
		 $gardenidarr = ($this->input->post('detailgardenid'));
		 $gradeidarr = ($this->input->post('detailgradeid'));
		 $gpnoidarr = ($this->input->post('detailgpno'));
		 $dtarr = $this->input->post('detaildate');
		 $chfromarr = ($this->input->post('detailchfrom'));
		 $chtoarr = ($this->input->post('detailchto'));
		 $packagearr = ($this->input->post('detailpackage'));
		 $stamparr = ($this->input->post('detailstamp'));
		 $grossarr = ($this->input->post('detailgross'));
		 $brokarr = ($this->input->post('detaillistbrokerage'));
		 $vatarr = ($this->input->post('detailvat'));
		 $pricearr = ($this->input->post('detailprice'));
		 $staxarr = ($this->input->post('detailstax'));
		 $valuearr = ($this->input->post('detailvalue'));
		 $listtotalarr = ($this->input->post('detaillisttotal'));
		 $listtotalweightarr = ($this->input->post('detaillisttweight'));
		 $ratetypearr = ($this->input->post('rate_type'));
		 $ratetypevaluearr = ($this->input->post('detailvat'));
		 $ratetypeidarr = ($this->input->post('rate_type_id'));
		 $servicetaxidarr = ($this->input->post('stax_id'));
		  $detailteagroupidarr = ($this->input->post('detailteagroupid'));
		 
	
		for($i= 0; $i<$count; $i++)
		{
			
			
			$value_detail['purchase_master_id']= $uriarr['invoice'];
			$value_detail['lot']= $lotarr[$i];
			$value_detail['do']=  $doarr[$i];
			$value_detail['invoice_number']= $invoicearr[$i];
			if($gardenidarr[$i] > 0)
			{
				$value_detail['garden_id']= $gardenidarr[$i];
			}
			if($gradeidarr[$i] > 0)
			{
				$value_detail['grade_id']= $gradeidarr[$i];
			}
			if($warehouseidarr[$i] > 0)
			{
				$value_detail['warehouse_id']= $warehouseidarr[$i];
			}
			$value_detail['gp_number']= $gpnoidarr[$i];
			$value_detail['date']= date("Y-m-d", strtotime($dtarr[$i]));
			$value_detail['package']= $packagearr[$i];
			$value_detail['stamp']= $stamparr[$i];
			$value_detail['gross']= $grossarr[$i];
			$value_detail['brokerage']= $brokarr[$i];
			$value_detail['total_weight']= $listtotalweightarr[$i];
			$value_detail['price']=$pricearr[$i];
			$value_detail['service_tax']=$staxarr[$i];
			$value_detail['value_cost']=$valuearr[$i];
			$value_detail['total_value']=$listtotalarr[$i];
			$value_detail['chest_from']=$chfromarr[$i];
			$value_detail['chest_to']=$chtoarr[$i];
			$value_detail['net']=$netarr[$i];
			$value_detail['rate_type']=$ratetypearr[$i];
			$value_detail['rate_type_value']=$ratetypevaluearr[$i];
			$value_detail['rate_type_id']=$ratetypeidarr[$i];
			$value_detail['service_tax_id']=$servicetaxidarr[$i];
			$value_detail['teagroup_master_id']=$detailteagroupidarr[$i];
			
			if($detailtableidarr[$i] == 0)
			{
				$status2 = $this->purchaseinvoicemastermodel->saveInvoicedetail($value_detail);
			}
			else
			{	
				$status2 = $detailtableidarr[$i];
				$this->purchaseinvoicemastermodel->updateInvoicedetail($value_detail,$detailtableidarr[$i]);
				$this->purchaseinvoicemastermodel->delsample($detailtableidarr[$i]);
				
			}
			
			$value_item['grade_id'] = $gradeidarr[$i];
			$value_item['garden_id'] = $gardenidarr[$i];
			$value_item['invoice_number'] = $invoicearr[$i];
			$value_item['package'] = $packagearr[$i];
			$value_item['net'] = $netarr[$i];
			$value_item['gross'] = $grossarr[$i];
			$value_item['bill_id'] = $status;
			$value_item['from_where'] = "PR";
			$statusitem = $this->purchaseinvoicemastermodel->saveItemamster($value_item);
			
					
			$samplenamearr = $this->input->post('detailsamplename');
			$samplenetarr  = $this->input->post('detailsamplenet');
			
			//$detailID = $status2;
			if($samplenamearr[$i] != '')
			{
				$arrsample = explode('*',$samplenamearr[$i]);
				$arrsamplenet = explode('*',$samplenetarr[$i]);
								
				$sample = 0;
			
				
				foreach ($arrsample as $number)
				{
					$samplevalue['purchase_invoice_detail_id'] = $status2;
					$samplevalue['sample_number'] = $number;
					$samplevalue['sample_net'] = $arrsamplenet[$sample];
									
					if($number != '')
					{
						$status3 = $this->purchaseinvoicemastermodel->saveInvoicesample($samplevalue);
					}$sample++;
				
				}
				
			}
			
			
		}	
		 $status4 = $this->purchaseinvoicemastermodel->updatedateVoucherMaster($value['purchase_invoice_date'],$this->input->post('voucherid'));
		 $del = $this->purchaseinvoicemastermodel-> deleteVoucherdetail($this->input->post('voucherid'));
		 
		 if($value_detail['rate_type'] == 'V')
		{
			$amount1 = ($value['tea_value'] + $value['brokerage'] + $value['service_tax'] + $value['stamp']) - $value['chestage_allowance'];
			$valuevoucherdetail1['voucher_master_id'] = $this->input->post('voucherid');
			$valuevoucherdetail1['account_master_id'] = 6;
			$valuevoucherdetail1['voucher_amount'] = $amount1;
			$valuevoucherdetail1['is_debit'] = "Y";
			$status5 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail1);
			
			$amount2 = $value['total_vat'];
			$valuevoucherdetail2['voucher_master_id'] = $this->input->post('voucherid');
			$valuevoucherdetail2['account_master_id'] = 5;
			$valuevoucherdetail2['voucher_amount'] = $amount2;
			$valuevoucherdetail2['is_debit'] = "Y";
			$status6 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail2);
			
			$amount3 = $value['total'];
			$vendorAcc = $this->purchaseinvoicemastermodel->getVendorAccount($value['vendor_id']);
			$valuevoucherdetail3['voucher_master_id'] = $this->input->post('voucherid');
			$valuevoucherdetail3['account_master_id'] = $vendorAcc[0]->id;
			$valuevoucherdetail3['voucher_amount'] = $amount3;
			$valuevoucherdetail3['is_debit'] = "N";
			$status7 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail3);

		}
		if($value_detail['rate_type'] == 'C')
		{
			$amount1 = ($value['tea_value'] + $value['brokerage'] + $value['service_tax'] + $value['stamp'] + $value['total_cst']) - $value['chestage_allowance'];
			$valuevoucherdetail1['voucher_master_id'] = $this->input->post('voucherid');
			$valuevoucherdetail1['account_master_id'] = 6;
			$valuevoucherdetail1['voucher_amount'] = $amount1;
			$valuevoucherdetail1['is_debit'] = "Y";
			$status5 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail1);
			
			$amount3 = $value['total'];
			$vendorAcc = $this->purchaseinvoicemastermodel->getVendorAccount($value['vendor_id']);
			$valuevoucherdetail3['voucher_master_id'] = $this->input->post('voucherid');
			$valuevoucherdetail3['account_master_id'] = $vendorAcc[0]->id;
			$valuevoucherdetail3['voucher_amount'] = $amount3;
			$valuevoucherdetail3['is_debit'] = "N";
			$status7 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail3);
		}
		$status8 = $this->purchaseinvoicemastermodel->updatedateBillMaster($this->input->post('voucherid'),$value['total'] );
		
		 header('Location: '.base_url().'purchaseinvoice/showlistpurchaseinvoice');
	}
	
	function getTaxlist()
	{
	  $startdate = date("Y-m-d", strtotime($this->input->post('startdate')));
	  $enddate = date("Y-m-d", strtotime($this->input->post('enddate')));
	  $ratetype = $this->input->post('type');
	  $row = '<select id="optionrate" name="optionrate"  class="optionrate" onchange="calculateCurrentVatratetotal()"><option value="0">Select</option>';

	  if($ratetype == 'V')
	  {
	  	  $result = $this->purchaseinvoicemastermodel->getCurrentvatrate($startdate,$enddate);
		  if(count($result) > 0)
		  {
			  foreach($result as $value)
			  {
				$row .= '<option value="'.$value->id.'">'.$value->vat_rate.'</option>';
			  }
		  }$row .= '</select>';
	  }
	  if($ratetype == 'C')
	  {
	  	  $result = $this->purchaseinvoicemastermodel->getCurrentcstrate($startdate,$enddate);
		  if(count($result) > 0)
		  {
			  foreach($result as $value)
			  {
				$row .= '<option value="'.$value->id.'">'.$value->cst_rate.'</option>';
			  }
		  }$row .= '</select>';
	  }
	  
	  echo ($row);
	  exit;
	}
	
	function deleteInvoicedetail()
	{
		$result = $this->purchaseinvoicemastermodel->deleteInvoicedetail($this->input->post('detailid'));
		
	}
	
	function deleteRecord()
	{
		$parentId = $this->input->post('masterid');
		$result = $this->purchaseinvoicemastermodel->deleteRecord($parentId);
		
	}
}

?>
