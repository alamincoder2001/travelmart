<style>
    .v-select{
		margin-top:-2.5px;
        float: right;
        min-width: 180px;
        margin-left: 5px;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
        height: 25px;
	}
	.v-select input[type=search], .v-select input[type=search]:focus{
		margin: 0px;
	}
	.v-select .vs__selected-options{
		overflow: hidden;
		flex-wrap:nowrap;
	}
	.v-select .selected-tag{
		margin: 2px 0px;
		white-space: nowrap;
		position:absolute;
		left: 0px;
	}
	.v-select .vs__actions{
		margin-top:-5px;
	}
	.v-select .dropdown-menu{
		width: auto;
		overflow-y:auto;
	}
	#searchForm select{
		padding:0;
		border-radius: 4px;
	}
	#searchForm .form-group{
		margin-right: 5px;
	}
	#searchForm *{
		font-size: 13px;
	}
	.record-table{
		width: 100%;
		border-collapse: collapse;
	}
	.record-table thead{
		background-color: #0097df;
		color:white;
	}
	.record-table th, .record-table td{
		padding: 3px;
		border: 1px solid #454545;
	}
    .record-table th{
        text-align: center;
    }
</style>
<div id="billRecord">
    <div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
        <div class="col-md-12">
            <form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
            <div class="form-group">
					<label>Search Type</label>
					<select class="form-control" v-model="searchType" @change="onChangeSearchType">
						<option value="">All</option>
						<option value="client">By Client</option>
						<option value="supplier">By Supplier</option>
						<option value="airline">By Airline</option>
						<option value="route">By Route</option>
                        <option value="pnr">By PNR</option>
					</select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'client' && clients.length > 0 ? '' : 'none'}">
					<label>Client</label>
					<v-select v-bind:options="clients" v-model="client" label="display_name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'supplier' && suppliers.length > 0 ? '' : 'none'}">
					<label>Supplier</label>
					<v-select v-bind:options="suppliers" v-model="supplier" label="display_name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'airline' && airlines.length > 0 ? '' : 'none'}">
					<label>Airline</label>
					<v-select v-bind:options="airlines" v-model="airline" label="ProductCategory_Name" @input="bills = []"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'route' && routes.length > 0 ? '' : 'none'}">
					<label>Route</label>
					<v-select v-bind:options="routes" v-model="route" label="display_text"></v-select>
				</div>

                <div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'user' && users.length > 0 ? '' : 'none'}">
					<label>User</label>
					<v-select v-bind:options="users" v-model="user" label="FullName"></v-select>
				</div>


                <div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'pnr' && pnrs.length > 0 ? '' : 'none'}">
					<label>PNR No</label>
					<v-select v-bind:options="pnrs" v-model="pnr" label="pnr_no"></v-select>
				</div>

				<div class="form-group" v-bind:style="{display: searchTypesForRecord.includes(searchType) ? '' : 'none'}">
					<label>Record Type</label>
					<select class="form-control" v-model="recordType" @change="bills = []">
						<option value="without_details">Without Details</option>
						<option value="with_details">With Details</option>
					</select>
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="dateFrom">
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="dateTo">
				</div>

				<div class="form-group" style="margin-top: -5px;">
					<input type="submit" value="Search">
				</div>
            </form>
        </div>
    </div>

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: bills.length > 0 ? '' : 'none'}">
		<div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
		<div class="col-md-12">
			<div class="table-responsive" id="reportContent">
				<table 
					class="record-table" 
					v-if="(searchTypesForRecord.includes(searchType)) && recordType == 'with_details'" 
					style="display:none" 
					v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'with_details' ? '' : 'none'}"
					>
					<thead>
						<tr>
							<th>Date</th>
							<th>Invoice No.</th>
							<th>Client Name</th>
							<th>Supplier Name</th>
							<th>Airline</th>
							<th>Route</th>
							<th>PNR No</th>
							<th>Ticket No</th>
							<th>Name</th>
							<th>Reminder Number</th>
							<th>Issue Date</th>
							<th>Flight Date</th>
							<th>Return Date</th>
							<th>Supplier Tax</th>
							<th>Customer Tax</th>
							<th>Price</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="bill in bills">
							<tr>
								<td>{{ bill.date }}</td>
								<td>{{ bill.invoice }}</td>
								<td>{{ bill.Customer_Name }}</td>
								<td>{{ bill.Supplier_Name }}</td>
								<td>{{ bill.billDetails[0].ProductCategory_Name }}</td>
								<td>{{ bill.billDetails[0].Product_Name }}</td>
								<td>{{ bill.billDetails[0].pnr_no }}</td>
								<td>{{ bill.billDetails[0].ticket }}</td>
								<td>{{ bill.billDetails[0].name }}</td>
								<td style="text-align:center;">{{ bill.billDetails[0].phone }}</td>
								<td>{{ bill.billDetails[0].issue_date }}</td>
								<td>{{ bill.billDetails[0].flight_date }}</td>
								<td>{{ bill.billDetails[0].return_date }}</td>
								<td style="text-align:right;">{{ bill.billDetails[0].supplier_tax }}</td>
								<td style="text-align:right;">{{ bill.billDetails[0].tax_amount }}</td>
								<td style="text-align:right;">{{ bill.billDetails[0].sale_rate }}</td>
								<td style="text-align:center;">
									<a href="" title="Bill Invoice" v-bind:href="`/bill-invoice-print/${bill.id}`" target="_blank"><i class="fa fa-file"></i></a>
									<?php if($this->session->userdata('accountType') != 'u'){?>
									<a v-bind:href="`/bill-edit/${bill.id}`" title="Edit Bill"><i class="fa fa-edit"></i></a>
									<a href="" title="Delete Bill" @click.prevent="deleteBill(bill.id)"><i class="fa fa-trash"></i></a>
									<?php }?>
								</td>
							</tr>
							<tr v-for="(product, sl) in bill.billDetails.slice(1)">
								<td colspan="4" v-bind:rowspan="bill.billDetails.length - 1" v-if="sl == 0"></td>
								<td>{{ product.ProductCategory_Name }}</td>
								<td>{{ product.Product_Name }}</td>
								<td>{{ product.pnr_no }}</td>
								<td>{{ product.ticket }}</td>
								<td>{{ product.name }}</td>
								<td style="text-align:center;">{{ product.phone }}</td>
								<td>{{ product.issue_date }}</td>
								<td>{{ product.flight_date }}</td>
								<td>{{ product.return_date }}</td>
								<td style="text-align:right;">{{ product.sale_rate }}</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="4"></td>
								<td colspan="10"><strong>Other Service: </strong>{{ bill.other_service ?? '-' }}</td>
								<td colspan="2" style="text-align:right;">{{ bill.service_amount }}</td>
								<td></td>
							</tr>
							<tr style="font-weight:bold;">
								<td colspan="14" style="font-weight:normal;"><strong>Note: </strong>{{ bill.note }}</td>
								<td style="text-align:right;" colspan="2">
									Total: {{ bill.total }}<br>
									Paid: {{ bill.paid }}<br>
									Due: {{ bill.due }}
								</td>
								<td></td>
							</tr>
						</template>
					</tbody>
				</table>

				<table 
					class="record-table" 
					v-if="(searchTypesForRecord.includes(searchType)) && recordType == 'without_details'" 
					style="display:none" 
					v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'without_details' ? '' : 'none'}"
					>
					<thead>
						<tr>
							<th>Date</th>
							<th>Invoice No.</th>
							<th>Client Name</th>
							<th>Supplier Name</th>
							<th>Saved By</th>
							<th>Sub Total</th>
							<!-- <th>VAT</th> -->
							<th>Discount</th>
							<th>Service Cost</th>
							<th>Total</th>
							<th>Paid</th>
							<th>Due</th>
							<th>Note</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="bill in bills">
							<td>{{ bill.date }}</td>
							<td>{{ bill.invoice }}</td>
							<td>{{ bill.Customer_Name }}</td>
							<td>{{ bill.Supplier_Name }}</td>
							<td>{{ bill.added_by }}</td>
							<td style="text-align:right;">{{ bill.sub_total }}</td>
							<!-- <td style="text-align:right;">{{ bill.vat }}</td> -->
							<td style="text-align:right;">{{ bill.discount }}</td>
							<td style="text-align:right;">{{ bill.service_amount }}</td>
							<td style="text-align:right;">{{ bill.total }}</td>
							<td style="text-align:right;">{{ bill.paid }}</td>
							<td style="text-align:right;">{{ bill.due }}</td>
							<td style="text-align:left;">{{ bill.note }}</td>
							<td style="text-align:center;">
								<a href="" title="Bill Invoice" v-bind:href="`/bill-invoice-print/${bill.id}`" target="_blank"><i class="fa fa-file"></i></a>
								<?php if($this->session->userdata('accountType') != 'u'){?>
								<a v-bind:href="`/bill-edit/${bill.id}`" title="Edit Bill"><i class="fa fa-edit"></i></a>
								<a href="" title="Delete Bill" @click.prevent="deleteBill(bill.id)"><i class="fa fa-trash"></i></a>
								<?php }?>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right;">Total</td>
							<td style="text-align:right;">{{ parseFloat(bills.reduce((prev, curr)=>{return prev + parseFloat(curr.sub_total)}, 0)).toFixed(2) }}</td>
							<!-- <td style="text-align:right;">{{ bills.reduce((prev, curr)=>{return prev + parseFloat(curr.vat)}, 0) }}</td> -->
							<td style="text-align:right;">{{ parseFloat(bills.reduce((prev, curr)=>{return prev + parseFloat(curr.discount)}, 0)).toFixed(2) }}</td>
							<td style="text-align:right;">{{ (bills.reduce((prev, curr)=>{return prev + parseFloat(curr.service_amount)}, 0)).toFixed(2) }}</td>
							<td style="text-align:right;">{{ parseFloat(bills.reduce((prev, curr)=>{return prev + parseFloat(curr.total)}, 0)).toFixed(2) }}</td>
							<td style="text-align:right;">{{ parseFloat(bills.reduce((prev, curr)=>{return prev + parseFloat(curr.paid)}, 0)).toFixed(2) }}</td>
							<td style="text-align:right;">{{ parseFloat(bills.reduce((prev, curr)=>{return prev + parseFloat(curr.due)}, 0)).toFixed(2) }}</td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
				</table>
				
				<table 
					class="record-table" 
					v-if="(searchTypesForSupplier.includes(searchType)) && recordType == 'without_details'" 
					style="display:none" 
					v-bind:style="{display: (searchTypesForSupplier.includes(searchType)) && recordType == 'without_details' ? '' : 'none'}"
					>
					<thead>
						<tr>
							<th>Date</th>
							<th>Invoice No.</th>
							<th>Client Name</th>
							<th>Supplier Name</th>
							<th>Saved By</th>
							<th>Purchase Total</th>
							<th>Paid</th>
							<th>Due</th>
							<th>Note</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="bill in bills">
							<td>{{ bill.date }}</td>
							<td>{{ bill.invoice }}</td>
							<td>{{ bill.Customer_Name }}</td>
							<td>{{ bill.Supplier_Name }}</td>
							<td>{{ bill.added_by }}</td>
							<td style="text-align:right;">{{ bill.purchase_total }}</td>
							<td style="text-align:right;">0.00</td>
							<td style="text-align:right;">{{ bill.purchase_total }}</td>
							<td style="text-align:left;">{{ bill.note }}</td>
							<td style="text-align:center;">
								<!-- <a href="" title="Bill Invoice" v-bind:href="`/bill-invoice-print/${bill.id}`" target="_blank"><i class="fa fa-file"></i></a> -->
								<?php if($this->session->userdata('accountType') != 'u'){?>
								<a v-bind:href="`/bill-edit/${bill.id}`" title="Edit Bill"><i class="fa fa-edit"></i></a>
								<a href="" title="Delete Bill" @click.prevent="deleteBill(bill.id)"><i class="fa fa-trash"></i></a>
								<?php }?>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right;">Total</td>
							<td style="text-align:right;">{{ parseFloat(bills.reduce((prev, curr)=>{return prev + parseFloat(curr.purchase_total)}, 0)).toFixed(2) }}</td>
							<td style="text-align:right;">0.00</td>
							<td style="text-align:right;">{{ (bills.reduce((prev, curr)=>{return prev + parseFloat(curr.purchase_total)}, 0)).toFixed(2) }}</td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
				</table>

				<template
					v-if="searchTypesForDetails.includes(searchType)"  
					style="display:none;" 
					v-bind:style="{display: searchTypesForDetails.includes(searchType) ? '' : 'none'}"
				>
					<table class="record-table" v-if="route != null || pnr != null">
						<thead>
							<tr>
								<th>Invoice No.</th>
								<th>Date</th>
								<th>Client Name</th>
								<th>Airline Name</th>
								<th>Route Name</th>
								<th>Issue Date</th>
								<th>Flight Date</th>
								<th>Sales Rate</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="bill in bills">
								<td>{{ bill.invoice }}</td>
								<td>{{ bill.date }}</td>
								<td>{{ bill.Customer_Name }}</td>
								<td>{{ bill.ProductCategory_Name }}</td>
								<td>{{ bill.Product_Name }}</td>
								<td>{{ bill.issue_date }}</td>
								<td>{{ bill.flight_date }}</td>
								<td style="text-align:right;">{{ bill.sale_rate }}</td>
							</tr>
						</tbody>
						<tfoot>
							<tr style="font-weight:bold;">
								<td colspan="7" style="text-align:right;">Total</td>
								<td style="text-align:right;">{{ parseFloat(bills.reduce((prev, curr) => { return prev + parseFloat(curr.sale_rate)}, 0)).toFixed(2) }}</td>
							</tr>
						</tfoot>
					</table>

					<table class="record-table" v-if="route == null && pnr == null">
						<thead>
							<tr>
								<th>Route Id</th>
								<th>Route Name</th>
								<th>Sale Rate</th>
							</tr>
						</thead>
						<tbody>
							<template v-for="bill in bills">
								<tr>
									<td colspan="3" style="text-align:center;background: #ccc;">{{ bill.category_name }}</td>
								</tr>
								<tr v-for="product in bill.products">
									<td>{{ product.product_code }}</td>
									<td>{{ product.product_name }}</td>
									<td style="text-align:right;">{{ product.sale_rate }}</td>
								</tr>
							</template>
						</tbody>
					</table>
				</template>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lodash.min.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#billRecord',

        data() {
            return {
                searchType: '',
				recordType: 'without_details',
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),

                client: null,
                clients: [],
                supplier: null,
                suppliers: [],
                user: null,
                users: [],
                airline: null,
                airlines: [],
                route: null,
                routes: [],
				pnr: null,
				pnrs: [],

                bills: [],
				searchTypesForRecord: ['', 'user', 'client'],
				searchTypesForSupplier: ['supplier'],
				searchTypesForDetails: ['airline', 'route', 'pnr']
            }
        },

        methods: {
            onChangeSearchType() {
				this.bills = [];
				if(this.searchType == 'route') {
					this.getRoutes();
				} 
				else if(this.searchType == 'user') {
					this.getUsers();
				}
				else if(this.searchType == 'airline') {
					this.getAirlines();
				}
				else if(this.searchType == 'client') {
					this.getClients();
				}
				else if(this.searchType == 'supplier') {
					this.getSuppliers();
				}
				else if(this.searchType == 'pnr') {
					this.getPnrs();
				}
			},

            getClients() {
				axios.get('/get_customers').then(res => {
					this.clients = res.data;
				})
			},

            getSuppliers() {
				axios.get('/get_suppliers').then(res => {
					this.suppliers = res.data;
				})
			},

            getUsers() {
				axios.get('/get_users').then(res => {
					this.users = res.data;
				})
			},

            getAirlines() {
				axios.get('/get_airlines').then(res => {
					this.airlines = res.data;
				})
			},

            getRoutes() {
				axios.get('/get_products').then(res=>{
					this.routes = res.data;
				})
			},

			getPnrs() {
				axios.get('/get_pnr').then(res => {
					this.pnrs = res.data;
				})
			},

            getSearchResult() {
				if(this.searchType != 'client'){
					this.client = null;
				}

				if(this.searchType != 'supplier'){
					this.supplier = null;
				}

				if(this.searchType != 'route'){
					this.route = null;
				}

				if(this.searchType != 'airline'){
					this.airline = null;
				}

				if(this.searchType != 'pnr'){
					this.pnr = null;
				}

				if(this.searchTypesForRecord.includes(this.searchType) || this.searchTypesForSupplier.includes(this.searchType)){
					this.getBillRecord();
				} else {
					this.getBillDetails();
				}
			},

            getBillRecord() {
                let filter = {
					userFullName: this.user == null || this.user.FullName == '' ? '' : this.user.FullName,
					clientId: this.client == null || this.client.Customer_SlNo == '' ? '' : this.client.Customer_SlNo,
					supplierId: this.supplier == null || this.supplier.Supplier_SlNo == '' ? '' : this.supplier.Supplier_SlNo,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				let url = '/get_bills';
				if(this.recordType == 'with_details'){
					url = '/get_bills_record';
				}

				axios.post(url, filter)
				.then(res => {
					if(this.recordType == 'with_details'){
						this.bills = res.data;
					} else {
						this.bills = res.data.bills;
					}
				})
            },

            getBillDetails() {
                let filter = {
					airlineId: this.airline == null || this.airline.ProductCategory_SlNo == '' ? '' : this.airline.ProductCategory_SlNo,
					routeId: this.route == null || this.route.Product_SlNo == '' ? '' : this.route.Product_SlNo,
					pnrNo: this.pnr == null || this.pnr.pnr_no == '' ? '' : this.pnr.pnr_no,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				axios.post('/get_billdetails', filter)
				.then(res => {
					let bills = res.data;

					if(this.route == null && this.pnr == null) {
						bills = _.chain(bills)
							.groupBy('ProductCategory_ID')
							.map(bill => {
								return {
									category_name: bill[0].ProductCategory_Name,
									products: _.chain(bill)
										.groupBy('Product_IDNo')
										.map(product => {
											return {
												product_code: product[0].Product_Code,
												product_name: product[0].Product_Name,
												sale_rate: product[0].sale_rate,
												// quantity: _.sumBy(product, item => Number(item.billDetails_TotalQuantity))
											}
										})
										.value()
								}
							})
							.value();
					}
					this.bills = bills;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
            },

            deleteBill(billId){
				let deleteConf = confirm('Are you sure?');
				if(deleteConf == false){
					return;
				}
				axios.post('/delete-bill', {billId: billId})
				.then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.getBillRecord();
					}
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},

			async print() {
				let dateText = '';
				if(this.dateFrom != '' && this.dateTo != ''){
					dateText = `Statement from <strong>${this.dateFrom}</strong> to <strong>${this.dateTo}</strong>`;
				}

				let userText = '';
				if(this.user != null && this.user.FullName != '' && this.searchType == 'user'){
					userText = `<strong>Sold by: </strong> ${this.user.FullName}`;
				}

				let clientText = '';
				if(this.client != null && this.client.Customer_SlNo != '' && this.searchType == 'client'){
					clientText = `<strong>Client: </strong> ${this.client.Customer_Name}<br>`;
				}

				let supplierText = '';
				if(this.supplier != null && this.supplier.Supplier_SlNo != '' && this.searchType == 'supplier'){
					supplierText = `<strong>Supplier: </strong> ${this.supplier.Supplier_Name}<br>`;
				}

				let routeText = '';
				if(this.route != null && this.route.Product_SlNo != '' && this.searchType == 'route'){
					routeText = `<strong>Route: </strong> ${this.route.Product_Name}`;
				}

				let airlineText = '';
				if(this.airline != null && this.airline.ProductCategory_SlNo != '' && this.searchType == 'airline'){
					airlineText = `<strong>Category: </strong> ${this.airline.ProductCategory_Name}`;
				}


				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Bill Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								${userText} ${clientText} ${supplierText} ${routeText} ${airlineText}
							</div>
							<div class="col-xs-6 text-right">
								${dateText}
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportContent').innerHTML}
							</div>
						</div>
					</div>
				`;

				var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}`);
				reportWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php');?>
				`);

				reportWindow.document.head.innerHTML += `
					<style>
						.record-table{
							width: 100%;
							border-collapse: collapse;
						}
						.record-table thead{
							background-color: #0097df;
							color:white;
						}
						.record-table th, .record-table td{
							padding: 3px;
							border: 1px solid #454545;
						}
						.record-table th{
							text-align: center;
						}
					</style>
				`;
				reportWindow.document.body.innerHTML += reportContent;

				if(this.searchType == '' || this.searchType == 'user' || this.searchType == 'supplier' || this.searchType == 'client'){
					let rows = reportWindow.document.querySelectorAll('.record-table tr');
					rows.forEach(row => {
						row.lastChild.remove();
					})
				}


				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
        }

    })
</script>