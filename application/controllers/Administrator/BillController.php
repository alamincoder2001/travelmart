<?php 
class BillController extends CI_Controller
{
	public function __construct() {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
         if($access == '' ){
            redirect("Login");
        }
		$this->load->model('Model_table', "mt", TRUE); 
    }

	/*====================*/
	public function index()
	{
		$data['title'] 		= "Bill Entry";
		$data['getData'] 	= $this->Bill_model->get_bill_entry();
		$data['ExpHead'] 	= $this->Bill_model->getExpenseHead();
        $data['content'] 	= $this->load->view('Administrator/bill_entry/bill_entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
	}

	/*=============================*/
	public function store()
	{
		$attr = $this->input->post();
		if($this->Bill_model->insert_data('tbl_bill_entry', $attr)){
			$data['successMsg']="Save Successfully!";
			echo json_encode($data);
		}else{
			$data['errorMsg']="Save Unsuccessfully!";
			echo json_encode($data);
		}
	}


	/*====================*/
	public function edit($id = null)
	{
		$data['edit'] = $this->Bill_model->edit_data($id);
		$data['ExpHead'] 	= $this->Bill_model->getExpenseHead();
        $this->load->view('Administrator/bill_entry/edit_bill_entry', $data);
	}

	/*=============================*/
	public function update($id = null)
	{
		$attr = $this->input->post();
		if($this->Bill_model->update_data('tbl_bill_entry', $attr, $id)) :
			$data['successMsg']="Update Successfully!";
			echo json_encode($data);
		else:
			$data['errorMsg']="Update Unsuccessfully!";
			echo json_encode($data);
		endif;	
	}

	/*=============================*/
	public function delete($id = null)
	{
		if($this->Bill_model->delete_data($id)) :
			$data['successMsg']="Delete Successfully!";
			echo json_encode($data);
		else:
			$data['errorMsg']="Delete Unsuccessfully!";
			echo json_encode($data);
		endif;	
	}

	/*=============================*/
	public function search()
	{
		$type  = $this->input->post('stype');
		$sDate = $this->input->post('sDate');
		$eDate = $this->input->post('eDate');
		if($this->Bill_model->get_search_billEntry($type, $sDate, $eDate)){
			$data['getData'] = $this->Bill_model->get_search_billEntry($type, $sDate, $eDate);
			$this->load->view('Administrator/bill_entry/search_bill_entry', $data);
		}
	}








	/*============Expense Head Entry============*/
	/*============Expense Head Entry============*/
	/*============Expense Head Entry============*/
	/*============Expense Head Entry============*/
	/*====================*/
	public function Eindex()
	{
		$data['title'] 		= "Expense Head Entry";
		$data['getData'] 	= $this->Bill_model->getExpenseHead();
        $data['content'] 	= $this->load->view('Administrator/bill_entry/expense_head', $data, TRUE);
        $this->load->view('Administrator/index', $data);
	}

    public function expenseHeadFancyBox()
    {
        $data['title'] 		= "Expense Head Entry";
        $this->load->view('Administrator/bill_entry/expense_head_fancy_box', $data);
    }

    public function expenseHeadAll(){
        $data 	= $this->Bill_model->getExpenseHead();
        echo json_encode($data);
    }

	/*=============================*/
	public function Estore()
	{
		$attr = $this->input->post();
		if($this->Bill_model->insert_data('tbl_expense_head',$attr)){
			$data['successMsg']="Save Successfully!";
			echo json_encode($data);
		}else{
			$data['errorMsg']="Save Unsuccessfully!";
			echo json_encode($data);
		}
	}


	/*====================*/
	public function Eedit($id = null)
	{
		$data['edit'] = $this->Bill_model->editExpenseHead($id);
        $this->load->view('Administrator/bill_entry/edit_expense_head', $data);
	}

	/*=============================*/
	public function Eupdate($id = null)
	{
		$attr = $this->input->post();
		if($this->Bill_model->update_data('tbl_expense_head', $attr, $id)):
			$data['successMsg']="Update Successfully!";
			echo json_encode($data);
		else:
			$data['errorMsg']="Update Unsuccessfully!";
			echo json_encode($data);
		endif;	
	}

	/*=============================*/
	public function Edelete($id = null)
	{
		if($this->Bill_model->delete_data('tbl_expense_head',$id)) :
			$data['successMsg']="Delete Successfully!";
			echo json_encode($data);
		else:
			$data['errorMsg']="Delete Unsuccessfully!";
			echo json_encode($data);
		endif;	
	}

	public function billEntry() 
	{
		$access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }

		$invoice = $this->mt->generateBillInvoice();

        $data['title'] = "Bill Entry";
        $data['billId'] = 0;
        $data['invoice'] = $invoice;
        $data['content'] = $this->load->view('Administrator/bill/bill_entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
	}

	public function saveBill() 
	{
		$res = ['success' => false, 'message' => ''];

		try {
			$this->db->trans_begin();
			$data = json_decode($this->input->raw_input_stream);

			$invoice = $data->bill->invoice;
            $invoiceCount = $this->db->query("select * from tbl_billmaster where invoice = ?", $invoice)->num_rows();
            if($invoiceCount != 0){
                $invoice = $this->mt->generateBillInvoice();
            }

			// Client Add / Update 
			$clientId = $data->bill->client_id;
            if(isset($data->client)){
                $client = (array)$data->client;
                unset($client['Customer_SlNo']);
                unset($client['display_name']);

                $mobile_count = $this->db->query("select * from tbl_customer where Customer_Mobile = ? and Customer_brunchid = ?", [$data->client->Customer_Mobile, $this->session->userdata("BRANCHid")]);
                if(
                    $data->client->Customer_Mobile != '' && 
                    $data->client->Customer_Mobile != null && 
                    $mobile_count->num_rows() > 0
                ) {

                    $duplicateClient = $mobile_count->row();
                    unset($client['Customer_Code']);
                    $client["UpdateBy"]   = $this->session->userdata("FullName");
                    $client["UpdateTime"] = date("Y-m-d H:i:s");
                    $client["status"]     = 'a';

                    $this->db->where('Customer_SlNo', $duplicateClient->Customer_SlNo)->update('tbl_customer', $client);
                    $clientId = $duplicateClient->Customer_SlNo;
                }else{

                    $client['Customer_Code'] = $this->mt->generateCustomerCode();
                    $client['status'] = 'a';
                    $client['AddBy'] = $this->session->userdata("FullName");
                    $client['AddTime'] = date("Y-m-d H:i:s");
                    $client['Customer_brunchid'] = $this->session->userdata("BRANCHid");
    
                    $this->db->insert('tbl_customer', $client);
                    $clientId = $this->db->insert_id();
                }
                
            }

			// Supplier Add / Update 
			$supplierId = $data->bill->supplier_id;
            if(isset($data->supplier)){
                $supplier = (array)$data->supplier;
                unset($supplier['Supplier_SlNo']);
                unset($supplier['display_name']);

                $mobile_count = $this->db->query("select * from tbl_supplier where Supplier_Mobile = ? and Supplier_brinchid = ?", [$data->supplier->Supplier_Mobile, $this->session->userdata("BRANCHid")]);
                
                if(
                    $data->supplier->Supplier_Mobile != '' && 
                    $data->supplier->Supplier_Mobile != null && 
                    $mobile_count->num_rows() > 0
                ) {

                    $duplicateSupplier = $mobile_count->row();
                    unset($supplier['Supplier_Code']);
                    $supplier["UpdateBy"]   = $this->session->userdata("FullName");
                    $supplier["UpdateTime"] = date("Y-m-d H:i:s");
                    $supplier["Status"]     = 'a';

                    $this->db->where('Supplier_SlNo', $duplicateSupplier->Supplier_SlNo)->update('tbl_supplier', $supplier);
                    $supplierId = $duplicateSupplier->Supplier_SlNo;
                }else{

                    $supplier['Supplier_Code'] = $this->mt->generateSupplierCode();
                    $supplier['Status'] = 'a';
                    $supplier['AddBy'] = $this->session->userdata("FullName");
                    $supplier['AddTime'] = date('Y-m-d H:i:s');
                    $supplier['Supplier_brinchid'] = $this->session->userdata('BRANCHid');
    
                    $this->db->insert('tbl_supplier', $supplier);
                    $supplierId = $this->db->insert_id();
                }
            }

			// Bill master data insert
			$bill = array(
				'date' =>  $data->bill->date,
				'invoice' => $invoice,
				'mr_no' => $data->bill->mr_no,
				'client_id' => $clientId,
				'supplier_id' => $supplierId,
				'sub_total' => $data->bill->subTotal,
				'purchase_total' => $data->bill->purchase_total,
				'vat' => $data->bill->vat,
				'discount' => $data->bill->discount,
				'total' => $data->bill->total,
				'paid' => $data->bill->paid,
				'due' => $data->bill->due,
				'previous_due' => $data->bill->previous_due,
				'note' => $data->bill->note,
				'other_service' => $data->bill->other_service,
				'service_amount' => $data->bill->service_amount,
				'status' => 'a',
				'added_by' => $this->session->userdata("FullName"),
				'added_time' => date('Y-m-d H:i:s'),
				'branch_id' => $this->session->userdata('BRANCHid')
			);

			$this->db->insert('tbl_billmaster', $bill);
            
            $billId = $this->db->insert_id();

			// Bill details data insert
			foreach($data->cart as $cartItem){

                if($cartItem->routeId == 'R01' || $cartItem->routeId == '') {
                    $route = array(
                        'Product_Code' => $this->mt->generateProductCode(),
                        'Product_Name' => $cartItem->routeName,
                        'ProductCategory_ID' => $cartItem->airlineId,
                        'status' => 'a',
                        'AddBy' => $this->session->userdata("FullName"),
                        'AddTime' => date('Y-m-d H:i:s'),
                        'Product_branchid' => $this->session->userdata('BRANCHid')
                    );

                    $this->db->insert('tbl_product', $route);
                    $routeId = $this->db->insert_id();

                } else {
                    $routeId = $cartItem->routeId;
                }

                $billDetails = array(
                    'billmaster_id' => $billId,
                    'name' => $cartItem->name,
                    'phone' => $cartItem->phone,
                    // 'address' => $cartItem->address,
                    'airline_id' => $cartItem->airlineId,
                    'route_id' => $routeId,
                    'issue_date' => $cartItem->issue_date,
                    'flight_date' => $cartItem->flight_date,
                    'reminder_date' => $cartItem->reminder_date ?? '',
                    'return_date' => $cartItem->return_date,
                    'pnr_no' => $cartItem->pnr_no ?? '',
                    'ticket' => $cartItem->ticket,
                    'flight_no' => $cartItem->flight_no,
                    'purchase_rate' => $cartItem->purRate,
                    'sale_rate' => $cartItem->saleRate,
                    'tax_amount' => $cartItem->taxAmount,
                    'discount' => $cartItem->discount,
                    'status' => 'a',
                    'added_by' => $this->session->userdata("FullName"),
                    'added_time' => date('Y-m-d H:i:s'),
                    'branch_id' => $this->session->userdata('BRANCHid')
                );
    
                $this->db->insert('tbl_billdetails', $billDetails);
            }

			$this->db->trans_commit();
			$res = ['success'=>true, 'message'=>'Bill Save Success', 'billId'=>$billId];

		} catch (\Exception $ex) {
			$this->db->trans_rollback();
			$res = ['success'=>false, 'message'=>$ex->getMessage()];
		}

		echo json_encode($res);
	}

	public function billInvoicePrint($billId)  {
        $data['title'] = "Bill Invoice";
        $data['billId'] = $billId;
        $data['content'] = $this->load->view('Administrator/bill/billAndreport', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function updateBill() 
    {
        $res = ['success' => false, 'message' => ''];

        try {
            $this->db->trans_begin();
            $data = json_decode($this->input->raw_input_stream);
            $billId = $data->bill->id;
            $clientId = $data->bill->client_id;
            $supplierId = $data->bill->supplier_id;

            // client update
			if(isset($data->client)){
                $client = (array)$data->client;
                unset($client['Customer_SlNo']);
                unset($client['display_name']);
                unset($client['Customer_Code']);

                $client['UpdateBy'] = $this->session->userdata("FullName");
                $client['UpdateTime'] = date("Y-m-d H:i:s");
                $client['status'] = 'a';

                if($data->client->Customer_Mobile != '' && $data->client->Customer_Mobile != null) {

                    $mobile_count = $this->db->query("select * from tbl_customer where Customer_Mobile = ? and Customer_SlNo != ? and Customer_brunchid = ?", [$data->client->Customer_Mobile, $data->client->Customer_SlNo, $this->session->userdata("BRANCHid")]);

                    if($mobile_count->num_rows() > 0) {

                        $duplicateClient = $mobile_count->row();
                        $data->bill->previous_due = $this->mt->clientDue(" and c.Customer_SlNo = '$duplicateClient->Customer_SlNo'")[0]->dueAmount;
                        $clientId = $duplicateClient->Customer_SlNo;
                    }
                }

                $this->db->where('Customer_SlNo', $clientId)->update('tbl_customer', $client);
            }

            // supplier update
            if(isset($data->supplier)){
                $supplier = (array)$data->supplier;
                unset($supplier['Supplier_SlNo']);
                unset($supplier['display_name']);
                unset($supplier['Supplier_Code']);

                $supplier['UpdateBy'] = $this->session->userdata("FullName");
                $supplier['UpdateTime'] = date("Y-m-d H:i:s");
                $supplier['Status'] = 'a';

                if($data->supplier->Supplier_Mobile != '' && $data->supplier->Supplier_Mobile != null){

                    $mobile_count = $this->db->query("select * from tbl_supplier where Supplier_Mobile = ? and Supplier_SlNo != ? and Supplier_brinchid = ?", [$data->supplier->Supplier_Mobile, $data->supplier->Supplier_SlNo, $this->session->userdata("BRANCHid")]);

                    if($mobile_count->num_rows() > 0) {
                        $duplicateSupplier = $mobile_count->row();
                        $supplierId = $duplicateSupplier->Supplier_SlNo;
                    }
                }

                $this->db->where('Supplier_SlNo', $supplierId)->update('tbl_supplier', $supplier);
            }

            // Bill master data update
			$bill = array(
				'date' =>  $data->bill->date,
				'mr_no' => $data->bill->mr_no,
				'client_id' => $clientId,
				'supplier_id' => $supplierId,
				'sub_total' => $data->bill->subTotal,
				'purchase_total' => $data->bill->purchase_total,
				'vat' => $data->bill->vat,
				'discount' => $data->bill->discount,
				'total' => $data->bill->total,
				'paid' => $data->bill->paid,
				'due' => $data->bill->due,
				'previous_due' => $data->bill->previous_due,
				'note' => $data->bill->note,
				'other_service' => $data->bill->other_service,
				'service_amount' => $data->bill->service_amount,
				'updated_by' => $this->session->userdata("FullName"),
				'updated_time' => date('Y-m-d H:i:s'),
				'branch_id' => $this->session->userdata('BRANCHid')
			);

            $this->db->where('id', $billId);
            $this->db->update('tbl_billmaster', $bill);

            // old details data delete
            $this->db->query("delete from tbl_billdetails where billmaster_id = ?", $billId);

            // Bill details data insert
			foreach($data->cart as $cartItem){

                if($cartItem->routeId == 'R01' || $cartItem->routeId == '') {
                    $route = array(
                        'Product_Code' => $this->mt->generateProductCode(),
                        'Product_Name' => $cartItem->routeName,
                        'ProductCategory_ID' => $cartItem->airlineId,
                        'status' => 'a',
                        'AddBy' => $this->session->userdata("FullName"),
                        'AddTime' => date('Y-m-d H:i:s'),
                        'Product_branchid' => $this->session->userdata('BRANCHid')
                    );

                    $this->db->insert('tbl_product', $route);
                    $routeId = $this->db->insert_id();

                } else {
                    $routeId = $cartItem->routeId;
                }

                $billDetails = array(
                    'billmaster_id' => $billId,
                    'name' => $cartItem->name,
                    'phone' => $cartItem->phone,
                    // 'address' => $cartItem->address,
                    'airline_id' => $cartItem->airlineId,
                    'route_id' => $routeId,
                    'issue_date' => $cartItem->issue_date,
                    'flight_date' => $cartItem->flight_date,
                    'reminder_date' => $cartItem->reminder_date ?? '',
                    'return_date' => $cartItem->return_date,
                    'pnr_no' => $cartItem->pnr_no ?? '',
                    'ticket' => $cartItem->ticket,
                    'flight_no' => $cartItem->flight_no,
                    'purchase_rate' => $cartItem->purRate,
                    'sale_rate' => $cartItem->saleRate,
                    'tax_amount' => $cartItem->taxAmount,
                    'discount' => $cartItem->discount,
                    'status' => 'a',
                    'added_by' => $this->session->userdata("FullName"),
                    'added_time' => date('Y-m-d H:i:s'),
                    'branch_id' => $this->session->userdata('BRANCHid')
                );
    
                $this->db->insert('tbl_billdetails', $billDetails);
            }

            $res = ['success'=>true, 'message'=>'Bill Update Success', 'billId'=>$billId];
            $this->db->trans_commit();
            
        } catch (\Exception $ex) {
            $this->db->trans_rollback();
			$res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

	public function billRecord() 
	{
		$access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }

        $data['title'] = "Bill Record";
        $data['content'] = $this->load->view('Administrator/bill/billRecord', $data, TRUE);
        $this->load->view('Administrator/index', $data);
	}

	public function getBills(){
        $data = json_decode($this->input->raw_input_stream);
        $branchId = $this->session->userdata("BRANCHid");

        $clauses = "";
        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and bm.date between '$data->dateFrom' and '$data->dateTo'";
        }

        if(isset($data->userFullName) && $data->userFullName != ''){
            $clauses .= " and bm.added_by = '$data->userFullName'";
        }

        if(isset($data->clientId) && $data->clientId != ''){
            $clauses .= " and bm.client_id = '$data->clientId'";
        }

        if(isset($data->supplierId) && $data->supplierId != ''){
            $clauses .= " and bm.supplier_id = '$data->supplierId'";
        }


        if(isset($data->billId) && $data->billId != 0 && $data->billId != ''){
            $clauses .= " and id = '$data->billId'";
            $billDetails = $this->db->query("
                select 
                    bd.*,
                    r.Product_Code,
                    r.Product_Name,
                    al.ProductCategory_Name
                from tbl_billdetails bd
                join tbl_product r on r.Product_SlNo = bd.route_id
                join tbl_productcategory al on al.ProductCategory_SlNo = bd.airline_id
                where bd.billmaster_id = ?
            ", $data->billId)->result();
    
            $res['billDetails'] = $billDetails;
        }

        $bills = $this->db->query("
            select 
				concat(bm.invoice, ' - ', c.Customer_Name) as invoice_text,
				bm.*,
				c.Customer_Code,
				c.Customer_Name,
				c.Customer_Mobile,
				c.Customer_Email,
				c.Customer_Address,
				s.Supplier_Code,
				s.Supplier_Name,
                s.Supplier_Mobile,
                s.Supplier_Address,
				br.Brunch_name
            from tbl_billmaster bm
            left join tbl_customer c on c.Customer_SlNo = bm.client_id
            left join tbl_supplier s on s.Supplier_SlNo = bm.supplier_id
            left join tbl_brunch br on br.brunch_id = bm.branch_id
            where bm.branch_id = '$branchId'
            and bm.status = 'a'
            $clauses
            order by bm.date asc
        ")->result();
        
        $res['bills'] = $bills;

        echo json_encode($res);
    }

	public function getBillRecord(){
        $data = json_decode($this->input->raw_input_stream);
        $branchId = $this->session->userdata("BRANCHid");

        $clauses = "";

        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and bm.date between '$data->dateFrom' and '$data->dateTo'";
        }

        if(isset($data->userFullName) && $data->userFullName != ''){
            $clauses .= " and bm.added_by = '$data->userFullName'";
        }

        if(isset($data->clientId) && $data->clientId != ''){
            $clauses .= " and bm.client_id = '$data->clientId'";
        }

        if(isset($data->supplierId) && $data->supplierId != ''){
            $clauses .= " and bm.supplier_id = '$data->supplierId'";
        }

        $bills = $this->db->query("
            select 
                bm.*,
                c.Customer_Code,
                c.Customer_Name,
                c.Customer_Mobile,
                c.Customer_Address,
				s.Supplier_Code,
                s.Supplier_Name,
                br.Brunch_name,
                (
                    select ifnull(count(*), 0) from tbl_billdetails bd 
                    where bd.billmaster_id = 1
                    and bd.status != 'd'
                ) as total_routes
            from tbl_billmaster bm
            left join tbl_customer c on c.Customer_SlNo = bm.client_id
            left join tbl_supplier s on s.Supplier_SlNo = bm.supplier_id
            left join tbl_brunch br on br.brunch_id = bm.branch_id
            where bm.branch_id = '$branchId'
            and bm.status = 'a'
            $clauses
            order by bm.date asc
        ")->result();

        foreach($bills as $bill){
            $bill->billDetails = $this->db->query("
                select 
                    bd.*,
                    r.Product_Name,
                    al.ProductCategory_Name
                from tbl_billdetails bd
                join tbl_product r on r.Product_SlNo = bd.route_id
                join tbl_productcategory al on al.ProductCategory_SlNo = bd.airline_id
                where bd.billmaster_id = ?
                and bd.status != 'd'
            ", $bill->id)->result();
        }

        echo json_encode($bills);
    }

    public function billEdit($billId){
        $data['title'] = "Bill update";
        $bill = $this->db->query("select * from tbl_billmaster where id = ? ", $billId)->row();
        $data['billId'] = $billId;
        $data['invoice'] = $bill->invoice;
        $data['content'] = $this->load->view('Administrator/bill/bill_entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

	public function getBillDetails(){
        $data = json_decode($this->input->raw_input_stream);
        $branchId = $this->session->userdata("BRANCHid");

        $clauses = "";
        if(isset($data->clientId) && $data->clientId != ''){
            $clauses .= " and c.Customer_SlNo = '$data->clientId'";
        }

        if(isset($data->routeId) && $data->routeId != ''){
            $clauses .= " and p.Product_SlNo = '$data->routeId'";
        }

        if(isset($data->airlineId) && $data->airlineId != ''){
            $clauses .= " and al.ProductCategory_SlNo = '$data->airlineId'";
        }

        if(isset($data->pnrNo) && $data->pnrNo != ''){
            $clauses .= " and bd.pnr_no = '$data->pnrNo'";
        }

        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and bm.date between '$data->dateFrom' and '$data->dateTo'";
        }

        $billDetails = $this->db->query("
            select 
                bd.*,
                p.Product_Code,
                p.Product_Name,
                p.ProductCategory_ID,
                al.ProductCategory_Name,
                bm.invoice,
                bm.date,
                c.Customer_Code,
                c.Customer_Name
            from tbl_billdetails bd
            join tbl_product p on p.Product_SlNo = bd.route_id
            join tbl_productcategory al on al.ProductCategory_SlNo = p.ProductCategory_ID
            join tbl_billmaster bm on bm.id = bd.billmaster_id
            join tbl_customer c on c.Customer_SlNo = bm.client_id
            where bd.status != 'd'
            and bm.branch_id = ?
            $clauses
        ", $branchId)->result();

        echo json_encode($billDetails);
    }

    // Delete Bill
    public function deleteBill()
    {
        $res = ['success'=>false, 'message'=>''];
        try {
            
            $this->db->trans_begin();
            $data = json_decode($this->input->raw_input_stream);
            $billId = $data->billId;

            $bill = $this->db->select('*')->where('id', $billId)->get('tbl_billmaster')->row();
            if($bill->status != 'a'){
                $res = ['success'=>false, 'message'=>'Bill not found'];
                echo json_encode($res);
                exit;
            }

            // Delete bill details data
            $this->db->set('status', 'd')->where('billmaster_id', $billId)->update('tbl_billdetails');

            // Delete bill master data
            $this->db->set('status', 'd')->where('id', $billId)->update('tbl_billmaster');

            $this->db->trans_commit();
            $res = ['success'=>true, 'message'=>'Bill delete Success'];

        } catch (Exception $ex) {
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
            $this->db->trans_rollback();
        }

        echo json_encode($res);
    }

    public function getProfitLoss(){
        $data = json_decode($this->input->raw_input_stream);

        $customerClause = "";
        if($data->customer != null && $data->customer != ''){
            $customerClause = " and bm.client_id = '$data->customer'";
        }

        $dateClause = "";
        if(($data->dateFrom != null && $data->dateFrom != '') && ($data->dateTo != null && $data->dateTo != '')){
            $dateClause = " and bm.date between '$data->dateFrom' and '$data->dateTo'";
        }


        $bills = $this->db->query("
            select 
                bm.*,
                c.Customer_Code,
                c.Customer_Name,
                c.Customer_Mobile
            from tbl_billmaster bm
            join tbl_customer c on c.Customer_SlNo = bm.client_id
            where bm.branch_id = ? 
            and bm.status = 'a'
            $customerClause $dateClause
        ", $this->session->userdata('BRANCHid'))->result();

        foreach($bills as $bill){
            $bill->billDetails = $this->db->query("
                select
                    bd.*,
                    p.Product_Code,
                    p.Product_Name,
                    (bd.purchase_rate) as purchased_amount,
                    (select bd.sale_rate - purchased_amount) as profit_loss
                from tbl_billdetails bd 
                join tbl_product p on p.Product_SlNo = bd.route_id
                where bd.billmaster_id = ?
            ", $bill->id)->result();
        }

        echo json_encode($bills);
    }

    public function billReminderList() 
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }

        $data['title'] = "Bill Reminder List";
        $data['content'] = $this->load->view('Administrator/bill/bill_reminder', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getReminderList()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        if(($data->reminderDate != null && $data->reminderDate != '') ){
            $clauses = " and bd.reminder_date = '$data->reminderDate'";
        }

        $reminders = $this->db->query("
            select
                bd.*,
                bm.invoice,
                al.ProductCategory_Name as airline,
                r.Product_Name as route
            from tbl_billdetails bd 
            join tbl_billmaster bm on bm.id = bd.billmaster_id
            join tbl_productcategory al on al.ProductCategory_SlNo = bd.airline_id
            join tbl_product r on r.Product_SlNo = bd.route_id
            where bd.status = 'a'
            and bd.branch_id = ?
            $clauses
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($reminders);
    }

    public function mailInvoice(){
        $this->load->view('Administrator/bill/mail_invoice', TRUE);
    }

    function encode_img_base64( $img_path = false, $img_type = 'jpeg' ){
        if( $img_path ){
            //convert image into Binary data
            $img_data = fopen ( $img_path, 'rb' );
            $img_size = filesize ( $img_path );
            $binary_image = fread ( $img_data, $img_size );
            fclose ( $img_data );
    
            //Build the src string to place inside your img tag
            $img_src = "data:image/".$img_type.";base64,".str_replace ("\n", "", base64_encode($binary_image));
    
            return $img_src;
        }
    
        return false;
    }

    // send mail
    public function SendMailInvoice()
    {
        $res = ['success'=>false, 'message'=>''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $bills = $this->db->query("
            select 
                bm.*,
                c.Customer_Code,
                c.Customer_Name,
                c.Customer_Mobile,
                c.Customer_Address,
                c.Customer_Email,
                br.Brunch_name
            from tbl_billmaster bm
            left join tbl_customer c on c.Customer_SlNo = bm.client_id
            left join tbl_brunch br on br.brunch_id = bm.branch_id
            where bm.status = 'a'
            and bm.id = ?
            ", $data->invoice);

            $billDetails = $this->db->query("
            select 
                sd.*,
                p.Product_Code,
                p.Product_Name,
                al.ProductCategory_Name
            from tbl_billdetails sd 
            left join tbl_product p on p.Product_SlNo = sd.route_id
            join tbl_productcategory al on al.ProductCategory_SlNo = sd.airline_id
            where sd.billmaster_id = ?
            ", $data->invoice);

            $bill['bills'] = $bills->row();
            $bill['billDetails'] = $billDetails->result();
            $bill['in_word'] = $data->InWord;
            $this->load->library('pdf');
            $view = $this->load->view('Administrator/bill/mail_invoice', $bill, true);
            $this->pdf->createPDF($view, 'TravelMart-Invoice-'.$data->invoic_no, false);
            
            $from_email = "support@travelmartusa.com"; 
            $to_email = $data->email; 
    
            //Load email library 
            $this->load->library('email'); 
            $pdfFilePath = './uploads/TravelMart-Invoice-'.$data->invoic_no.'.pdf';
            $this->email->from($from_email, 'Travel Mart USA'); 
            $this->email->to($to_email);
            $this->email->subject('Invoice-'.$data->invoic_no); 
            $this->email->message('Dear Customer, Please see attachment Invoice!'); 
            $this->email->attach($pdfFilePath); 
            if($this->email->send()) {
                unlink($pdfFilePath);
                $res = ['success'=>true, 'message'=>'Mail Send Successfully!'];
            } else {
                $res = ['success'=>true, 'message'=>'Mail Send Failed!'];
            }
        } catch (\Exception $e) {
            $res = ['success'=>false, 'message'=>$e->getMessage()];
        }
        echo json_encode($res);
    }

    public function getPnr() 
    {
        $pnrs = $this->db->query("
            select 
                bd.* 
            from tbl_billdetails bd
            where bd.status = 'a'
            group by bd.pnr_no
            order by bd.pnr_no asc
        ")->result();

        echo json_encode($pnrs);
    }

}
