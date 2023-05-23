<?php
    class Graph extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $access = $this->session->userdata('userId');
            $this->branchId = $this->session->userdata('BRANCHid');
            if($access == '' ){
                redirect("Login");
            }
            $this->load->model('Model_table', "mt", TRUE);
        }
        
        public function graph(){
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }
            $data['title'] = "Graph";
            $data['content'] = $this->load->view('Administrator/graph/graph', $data, true);
            $this->load->view('Administrator/index', $data);
        }

        public function getGraphData(){
            // Monthly Record
            $monthlyRecord = [];
            $year = date('Y');
            $month = date('m');
            $dayNumber = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for($i = 1; $i <= $dayNumber; $i++){
                $date = $year . '-' . $month . '-'. sprintf("%02d", $i);
                $query = $this->db->query("
                    select ifnull(sum(bm.total), 0) as bill_amount 
                    from tbl_billmaster bm 
                    where bm.date = ?
                    and bm.status = 'a'
                    and bm.branch_id = ?
                    group by bm.date
                ", [$date, $this->branchId]);

                $amount = 0.00;

                if($query->num_rows() == 0){
                    $amount = 0.00;
                } else {
                    $amount = $query->row()->bill_amount;
                }
                $bill = [sprintf("%02d", $i), $amount];
                array_push($monthlyRecord, $bill);
            }

            $yearlyRecord = [];
            for($i = 1; $i <= 12; $i++) {
                $yearMonth = $year . sprintf("%02d", $i);
                $query = $this->db->query("
                    select ifnull(sum(bm.total), 0) as bill_amount 
                    from tbl_billmaster bm 
                    where extract(year_month from bm.date) = ?
                    and bm.status = 'a'
                    and bm.branch_id = ?
                    group by extract(year_month from bm.date)
                ", [$yearMonth, $this->branchId]);

                $amount = 0.00;
                $monthName = date("M", mktime(0, 0, 0, $i, 10));

                if($query->num_rows() == 0){
                    $amount = 0.00;
                } else {
                    $amount = $query->row()->bill_amount;
                }
                $bill = [$monthName, $amount];
                array_push($yearlyRecord, $bill);
            }

            // Sales text for marquee
            $bills_text = $this->db->query("
                select 
                    concat(
                        'Invoice: ', bm.invoice,
                        ', Client: ', c.Customer_Code, ' - ', c.Customer_Name,
                        ', Amount: ', bm.total,
                        ', Paid: ', bm.paid,
                        ', Due: ', bm.due
                    ) as bill_text
                from tbl_billmaster bm 
                join tbl_customer c on c.Customer_SlNo = bm.client_id
                where bm.status = 'a'
                and bm.branch_id = ?
                order by bm.id desc limit 20
            ", $this->branchId)->result();

            // Today's Sale
            $todaysSale = $this->db->query("
                select 
                    ifnull(sum(ifnull(bm.total, 0)), 0) as total_amount
                from tbl_billmaster bm
                where bm.status = 'a'
                and bm.date = ?
                and bm.branch_id = ?
            ", [date('Y-m-d'), $this->branchId])->row()->total_amount;

            // This Month's Sale
            $thisMonthSale = $this->db->query("
                select 
                    ifnull(sum(ifnull(bm.total, 0)), 0) as total_amount
                from tbl_billmaster bm
                where bm.status = 'a'
                and month(bm.date) = ?
                and year(bm.date) = ?
                and bm.branch_id = ?
            ", [$month, $year, $this->branchId])->row()->total_amount;

            // Today's Cash Collection
            $todaysCollection = $this->db->query("
                select 
                ifnull((
                    select sum(ifnull(bm.paid, 0)) 
                    from tbl_billmaster bm
                    where bm.status = 'a'
                    and bm.branch_id = " . $this->branchId . "
                    and bm.date = '" . date('Y-m-d') . "'
                ), 0) +
                ifnull((
                    select sum(ifnull(cp.CPayment_amount, 0)) 
                    from tbl_customer_payment cp
                    where cp.CPayment_status = 'a'
                    and cp.CPayment_TransactionType = 'CR'
                    and cp.CPayment_brunchid = " . $this->branchId . "
                    and cp.CPayment_date = '" . date('Y-m-d') . "'
                ), 0) +
                ifnull((
                    select sum(ifnull(ct.In_Amount, 0)) 
                    from tbl_cashtransaction ct
                    where ct.status = 'a'
                    and ct.Tr_branchid = " . $this->branchId . "
                    and ct.Tr_date = '" . date('Y-m-d') . "'
                ), 0) as total_amount
            ")->row()->total_amount;

            // Cash Balance
            $cashBalance = $this->mt->getTransactionSummary()->cash_balance;

            // Top Customers
            $topCustomers = $this->db->query("
                select 
                    c.Customer_Name as customer_name,
                    ifnull(sum(bm.total), 0) as amount
                from tbl_billmaster bm 
                join tbl_customer c on c.Customer_SlNo = bm.client_id
                where bm.branch_id = ?
                group by bm.client_id
                order by amount desc 
                limit 10
            ", $this->branchId)->result();

            // Top Products
            $topRoutes = $this->db->query("
                select 
                    p.Product_Name as product_name,
                    count(bd.route_id) as sold_quantity
                from tbl_billdetails bd
                join tbl_product p on p.Product_SlNo = bd.route_id
                group by bd.route_id
                order by sold_quantity desc
                limit 5
            ")->result();


            // Customer Due
            $clientDueResult = $this->mt->clientDue();
            $clientDue = array_sum(array_map(function($due) {
                return $due->dueAmount;
            }, $clientDueResult));

            // Supplier Due
            $supplierDueResult = $this->mt->supplierDue();
            $supplierDue = array_sum(array_map(function($due) {
                return $due->due;
            }, $supplierDueResult));

            // Bank balance
            $bankTransactions = $this->mt->getBankTransactionSummary();
            $bankBalance = array_sum(array_map(function($bank){
                return $bank->balance;
            }, $bankTransactions));

            // Invest balance
            $investTransactions = $this->mt->getInvestmentTransactionSummary();
            $investBalance = array_sum(array_map(function($bank){
                return $bank->balance;
            }, $investTransactions));

            // Loan balance
            $loanTransactions = $this->mt->getLoanTransactionSummary();
            $loanBalance = array_sum(array_map(function($bank){
                return $bank->balance;
            }, $loanTransactions));

            //Assets Value
            $assets = $this->mt->assetsReport();
            $assets_value = array_reduce($assets, function($prev, $curr){ return $prev + $curr->approx_amount;});

            //stock value
            // $stocks = $this->mt->currentStock();
            // $stockValue = array_sum(
            //     array_map(function($product){
            //         return $product->stock_value;
            //     }, $stocks)
            // );

            //this month profit loss
            $bills = $this->db->query("
                select 
                    bm.*
                from tbl_billmaster bm
                where bm.branch_id = ? 
                and bm.status = 'a'
                and month(bm.date) = ?
                and year(bm.date) = ?
            ", [$this->branchId, $month, $year])->result();

            foreach($bills as $bill){
                $bill->billDetails = $this->db->query("
                    select
                        bd.*,
                        (bd.purchase_rate) as purchased_amount,
                        (select bd.sale_rate - purchased_amount) as profit_loss
                    from tbl_billdetails bd
                    where bd.billmaster_id = ?
                ", $bill->id)->result();
            }

            $profits = array_reduce($bills, function($prev, $curr){ 
                return $prev + array_reduce($curr->billDetails, function($p, $c){
                    return $p + $c->profit_loss;
                });
            });

            // $total_transport_cost = array_reduce($bills, function($prev, $curr){ 
            //     return $prev + $curr->SaleMaster_Freight;
            // });
            
            $total_discount = array_reduce($bills, function($prev, $curr){ 
                return $prev + $curr->discount;
            });

            $total_vat = array_reduce($bills, function($prev, $curr){ 
                return $prev + $curr->vat;
            });


            $other_income_expense = $this->db->query("
                select
                (
                    select ifnull(sum(ct.In_Amount), 0)
                    from tbl_cashtransaction ct
                    where ct.Tr_branchid = '$this->branchId'
                    and ct.status = 'a'
                    and month(ct.Tr_date) = '$month'
                    and year(ct.Tr_date) = '$year'
                ) as income,
            
                (
                    select ifnull(sum(ct.Out_Amount), 0)
                    from tbl_cashtransaction ct
                    where ct.Tr_branchid = '$this->branchId'
                    and ct.status = 'a'
                    and month(ct.Tr_date) = '$month'
                    and year(ct.Tr_date) = '$year'
                ) as expense,

                (
                    select ifnull(sum(it.amount), 0)
                    from tbl_investment_transactions it
                    where it.branch_id = '$this->branchId'
                    and it.transaction_type = 'Profit'
                    and it.status = 1
                    and month(it.transaction_date) = '$month'
                    and year(it.transaction_date) = '$year'
                ) as profit_distribute,

                (
                    select ifnull(sum(lt.amount), 0)
                    from tbl_loan_transactions lt
                    where lt.branch_id = '$this->branchId'
                    and lt.transaction_type = 'Interest'
                    and lt.status = 1
                    and month(lt.transaction_date) = '$month'
                    and year(lt.transaction_date) = '$year'
                ) as loan_interest,

                (
                    select ifnull(sum(a.valuation - a.as_amount), 0)
                    from tbl_assets a
                    where a.branchid = '$this->branchId'
                    and a.buy_or_sale = 'sale'
                    and a.status = 'a'
                    and month(a.as_date) = '$month'
                    and year(a.as_date) = '$year'
                ) as assets_sales_profit_loss,
            
                (
                    select ifnull(sum(ep.total_payment_amount), 0)
                    from tbl_employee_payment ep
                    where ep.branch_id = '$this->branchId'
                    and ep.status = 'a'
                    and month(ep.payment_date) = '$month'
                    and year(ep.payment_date) = '$year'
                ) as employee_payment,

                (
                    select ifnull(sum(dd.damage_amount), 0) 
                    from tbl_damagedetails dd
                    join tbl_damage d on d.Damage_SlNo = dd.Damage_SlNo
                    where d.Damage_brunchid = '$this->branchId'
                    and dd.status = 'a'
                    and month(d.Damage_Date) = '$month'
                    and year(d.Damage_Date) = '$year'
                ) as damaged_amount,

                (
                    select ifnull(sum(rd.SaleReturnDetails_ReturnAmount) - sum(sd.Purchase_Rate * rd.SaleReturnDetails_ReturnQuantity), 0)
                    from tbl_salereturndetails rd
                    join tbl_salereturn r on r.SaleReturn_SlNo = rd.SaleReturn_IdNo
                    join tbl_salesmaster sm on sm.SaleMaster_InvoiceNo = r.SaleMaster_InvoiceNo
                    join tbl_saledetails sd on sd.Product_IDNo = rd.SaleReturnDetailsProduct_SlNo and sd.SaleMaster_IDNo = sm.SaleMaster_SlNo
                    where r.Status = 'a'
                    and r.SaleReturn_brunchId = '$this->branchId'
                    and month(r.SaleReturn_ReturnDate) = '$month'
                    and year(r.SaleReturn_ReturnDate) = '$year'
                ) as returned_amount
            ")->row();

            $net_profit = (
                $profits + 
                $other_income_expense->income + $total_vat
            ) - (
                $total_discount + 
                $other_income_expense->returned_amount + 
                $other_income_expense->damaged_amount + 
                $other_income_expense->expense + 
                $other_income_expense->employee_payment + 
                $other_income_expense->profit_distribute + 
                $other_income_expense->loan_interest + 
                $other_income_expense->assets_sales_profit_loss 
            );


            $responseData = [
                'monthly_record'    => $monthlyRecord,
                'yearly_record'     => $yearlyRecord,
                'bills_text'        => $bills_text,
                'todays_sale'       => $todaysSale,
                'this_month_sale'   => $thisMonthSale,
                'todays_collection' => $todaysCollection,
                'cash_balance'      => $cashBalance,
                'top_customers'     => $topCustomers,
                'top_routes'        => $topRoutes,
                'client_due'        => $clientDue,
                'supplier_due'      => $supplierDue,
                'bank_balance'      => $bankBalance,
                'invest_balance'    => $investBalance,
                'loan_balance'      => $loanBalance,
                'asset_value'       => $assets_value,
                // 'stock_value'       => $stockValue,
                'this_month_profit' => $net_profit,
            ];

            echo json_encode($responseData, JSON_NUMERIC_CHECK);
        }
    }
?>