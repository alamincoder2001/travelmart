<style>
    .v-select {
        margin-bottom: 5px;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
        margin: 0px;
    }

    .v-select .vs__selected-options {
        overflow: hidden;
        flex-wrap: nowrap;
    }

    .v-select .selected-tag {
        margin: 2px 0px;
        white-space: nowrap;
        position: absolute;
        left: 0px;
    }

    .v-select .vs__actions {
        margin-top: -5px;
    }

    .v-select .dropdown-menu {
        width: auto;
        overflow-y: auto;
    }

    #branchDropdown .vs__actions button {
        display: none;
    }

    #branchDropdown .vs__actions .open-indicator {
        height: 15px;
        margin-top: 7px;
    }
</style>

<div id="BillEntry" class="row">
    <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
        <div class="row">
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right"> Bill Invoice </label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" v-model="bill.invoice" readonly />
                    <!-- <v-select id="branchDropdown" v-bind:options="branches" label="Brunch_name" v-model="branch" disabled></v-select> -->
                </div>
            </div>
            <div class="form-group">
                <label for="date" class="col-sm-1 control-label">Bill Date </label>
                <div class="col-sm-3 no-padding-left">
                    <input type="date" id="date" class="form-control" v-model="bill.date" />
                </div>
            </div>
            <div class="form-group">
                <label for="mr_no" class="col-sm-1 control-label">M/R NO</label>
                <div class="col-sm-3 no-padding-left">
                    <input type="text" id="mr_no" class="form-control" v-model="bill.mr_no" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-md-6">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Client Information</h4>
                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>

                            <a href="#" data-action="close">
                                <i class="ace-icon fa fa-times"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Select Client</label>
                                <div class="col-md-7">
                                    <v-select v-bind:options="clients" v-model="client" label="display_name" v-on:input="clientOnChange"></v-select>
                                </div>
                            </div>
                            <div class="form-group clearfix" style="display: none;" :style="{display: client.display_name == 'New Client' ? '' : 'none' }">
                                <label class="control-label col-md-4">Client Name</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="client.Customer_Name" required autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Client Phone</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="client.Customer_Mobile" v-bind:disabled="client.display_name == 'New Client' ? false : true" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Client Email</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="client.Customer_Email" v-bind:disabled="client.display_name == 'New Client' ? false : true" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Client Address</label>
                                <div class="col-md-7">
                                    <textarea class="form-control" class="form-control" v-model="client.Customer_Address" cols="30" rows="2" v-bind:disabled="client.display_name == 'New Client' ? false : true" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Supplier Information</h4>
                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>

                            <a href="#" data-action="close">
                                <i class="ace-icon fa fa-times"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Select Supplier </label>
                                <div class="col-md-7">
                                    <v-select v-bind:options="suppliers" v-model="supplier" label="display_name"></v-select>
                                </div>
                            </div>
                            <div class="form-group clearfix" style="display: none;" :style="{display: supplier.display_name == 'New Supplier' ? '' : 'none' }">
                                <label class="control-label col-md-4">Supplier Name</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="supplier.Supplier_Name" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Supplier Phone</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="supplier.Supplier_Mobile" v-bind:disabled="supplier.display_name == 'New Supplier' ? false : true" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Supplier Email</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="supplier.Supplier_Email" v-bind:disabled="supplier.display_name == 'New Supplier' ? false : true" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-md-4">Supplier Address</label>
                                <div class="col-md-7">
                                    <textarea class="form-control" v-model="supplier.Supplier_Address" cols="30" rows="2" v-bind:disabled="supplier.display_name == 'New Supplier' ? false : true" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-9 col-lg-9">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Bill Information</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form v-on:submit.prevent="addToCart">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="airline" class="col-xs-4 control-label no-padding-right">Select Airline</label>
                                    <div class="col-xs-8">
                                        <v-select v-bind:options="airlines" v-model="airline" label="ProductCategory_Name"></v-select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label no-padding-right">Select Route</label>
                                    <div class="col-xs-7">
                                        <v-select v-bind:options="filterRoutes" v-model="route" label="Product_Name"></v-select>
                                    </div>
                                    <div class="col-xs-1" style="padding: 0;">
                                        <a href="<?= base_url('product') ?>" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Product"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
                                    </div>
                                </div>
                                <div class="form-group clearfix" style="display: none;" :style="{display: route.Product_SlNo == 'R01' ? '' : 'none' }">
                                    <label class="col-xs-4 control-label no-padding-right">Route Name</label>
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control" v-model="route.Product_Name" placeholder="Enter Route Name" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-xs-4 control-label no-padding-right">Name </label>
                                    <div class="col-xs-8">
                                        <input type="text" id="name" class="form-control" v-model="route.name" placeholder="Enter name" autocomplete="off" required />
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="address" class="col-sm-4 control-label">Address</label>
                                    <div class="col-sm-8 no-padding-right">
                                        <textarea class="form-control" id="address" cols="30" rows="2" v-model="route.address" placeholder="Enter address" required></textarea>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="phone" class="col-xs-4 control-label no-padding-right"> Phone Number </label>
                                    <div class="col-xs-8">
                                        <input type="text" id="phone" class="form-control" v-model="route.phone" placeholder="Enter phone" autocomplete="off" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="issue_date" class="col-xs-4 control-label no-padding-right">Issue Date</label>
                                    <div class="col-xs-8">
                                        <input type="date" id="issue_date" class="form-control" v-model="route.issue_date" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="flight_date" class="col-xs-4 control-label no-padding-right">Flight Date</label>
                                    <div class="col-xs-8">
                                        <input type="date" id="flight_date" class="form-control" v-model="route.flight_date" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="reminder_date" class="col-xs-4 control-label no-padding-right">Reminder Date</label>
                                    <div class="col-xs-8">
                                        <input type="date" id="reminder_date" class="form-control" v-model="route.reminder_date" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="return_date" class="col-xs-4 control-label no-padding-right">Return Date</label>
                                    <div class="col-xs-8">
                                        <input type="date" id="return_date" class="form-control" v-model="route.return_date" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr style="margin-top: 0px; margin-bottom: 10px;">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pnr_no" class="col-xs-4 control-label no-padding-right">PNR NO</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="pnr_no" class="form-control" v-model="route.pnr_no" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="flight_no" class="col-xs-4 control-label no-padding-right">Flight NO</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="flight_no" class="form-control" v-model="route.flight_no" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="supplier_fare" class="col-xs-4 control-label no-padding-right no-padding-right">Supplier Fare</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="supplier_fare" class="form-control" v-model="route.Product_Purchase_Rate" required autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="supplier_tax" class="col-xs-4 control-label no-padding-right no-padding-right">Supplier Tax</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="supplier_tax" class="form-control" v-model="route.supplier_tax" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ticket_no" class="col-xs-4 control-label no-padding-right">Ticket No</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="ticket_no" class="form-control" v-model="route.ticket" required autocomplete="off" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sales_amount" class="col-xs-4 control-label no-padding-right">Sale Amount</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="sales_amount" class="form-control" v-model="route.Product_SellingPrice" required autocomplete="off" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tax" class="col-xs-4 control-label no-padding-right">Tax In BDT</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="tax" class="form-control" v-model="route.tax_amount" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="routeDiscount" class="col-xs-4 control-label no-padding-right">Discount</label>
                                    <div class="col-xs-8">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <input type="number" min="0" id="routeDiscount" class="form-control" v-model="routeDiscount" v-on:input="calculateDiscount" autocomplete="off" />
                                            </div>
                                            <label class="col-xs-2 control-label">%</label>
                                            <div class="col-xs-6">
                                                <input type="number" min="0" id="discount" class="form-control" v-model="route.discount" v-on:input="calculateDiscount" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label no-padding-right"> </label>
                                    <div class="col-xs-8">
                                        <button type="submit" class="btn btn-default pull-right">Add Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row" style="padding-top: 5px;">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                                <thead>
                                    <tr>
                                        <th style="width:5%;color:#000;">SL</th>
                                        <th style="width:15%;color:#000;">Airline</th>
                                        <th style="width:15%;color:#000;">Route</th>
                                        <th style="width:10%;color:#000;">PNR NO</th>
                                        <th style="width:10%;color:#000;">Ticket</th>
                                        <th style="width:12%;color:#000;">Pur. Rate</th>
                                        <th style="width:12%;color:#000;">Supp. Tax</th>
                                        <th style="width:15%;color:#000;">Sale Amount</th>
                                        <th style="width:8%;color:#000;">Tax</th>
                                        <th style="width:7%;color:#000;">Discount</th>
                                        <th style="width:5%;color:#000;">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
                                    <tr v-for="(item, sl) in cart">
                                        <td>{{ sl + 1 }}</td>
                                        <td>{{ item.airline }}</td>
                                        <td>{{ item.routeName }}</td>
                                        <td>{{ item.pnr_no }}</td>
                                        <td>{{ item.ticket }}</td>
                                        <td>{{ item.purRate }}</td>
                                        <td>{{ item.supplier_tax }}</td>
                                        <td>{{ item.saleRate }}</td>
                                        <td>{{ item.taxAmount }}</td>
                                        <td>{{ item.discount }}</td>
                                        <td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td colspan="10"></td>
                                    </tr>

                                    <tr style="font-weight: bold;">
                                        <td colspan="5">Note</td>
                                        <td colspan="3">Total Tax</td>
                                        <td colspan="3">Total</td>
                                    </tr>

                                    <tr>
                                        <td colspan="5"><textarea style="width: 100%;font-size:13px;" placeholder="Note" v-model="bill.note"></textarea></td>
                                        <td colspan="3" style="padding-top: 15px;font-size:18px;">{{ cart.reduce((prev, curr) => { return prev + parseFloat(curr.taxAmount)}, 0) }} </td>
                                        <td colspan="3" style="padding-top: 15px;font-size:18px;">{{ bill.total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service" class="col-xs-4 control-label no-padding-right">Other Service</label>
                                <div class="col-xs-8">
                                    <textarea id="service" v-model="bill.other_service" class="form-control" cols="30" rows="2" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service_amount" class="col-xs-4 control-label no-padding-right">Service Amount</label>
                                <div class="col-xs-8">
                                    <input type="number" min="0" step="0.01" id="service_amount" class="form-control" v-model="bill.service_amount" v-on:input="calculateTotal" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-3 col-lg-3">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Amount Details</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="table-responsive">
                                <table style="color:#000;margin-bottom: 0px;border-collapse: collapse;">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Sub Total</label>
                                                <div class="col-xs-12">
                                                    <input type="number" id="subTotal" class="form-control" v-model="bill.subTotal" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr style="display: none;">
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Purchase Total</label>
                                                <div class="col-xs-12">
                                                    <input type="number" id="purchase_total" class="form-control" v-model="bill.purchase_total" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="display: none;">
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Vat Persent</label>

                                                <div class="col-xs-4">
                                                    <input type="number" min="0" id="vatPercent" class="form-control" v-model="vatPercent" v-on:input="calculateTotal" />
                                                </div>

                                                <label class="col-xs-1 control-label no-padding-right">%</label>

                                                <div class="col-xs-7">
                                                    <input type="number" min="0" id="vat" class="form-control" v-model="bill.vat" v-on:input="calculateTotal" />
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Discount Persent</label>

                                                <div class="col-xs-5">
                                                    <input type="number" min="0" id="discountPercent" class="form-control" v-model="discountPercent" v-on:input="calculateTotal" />
                                                </div>

                                                <label class="col-xs-1 control-label no-padding-right">%</label>

                                                <div class="col-xs-6">
                                                    <input type="number" min="0" id="discount" class="form-control" v-model="bill.discount" v-on:input="calculateTotal" />
                                                </div>

                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Total</label>
                                                <div class="col-xs-12">
                                                    <input type="number" id="total" class="form-control" v-model="bill.total" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Paid</label>
                                                <div class="col-xs-12">
                                                    <input type="number" id="paid" class="form-control" v-model="bill.paid" v-on:input="calculateTotal" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label">Due</label>
                                                <div class="col-xs-6">
                                                    <input type="number" id="due" class="form-control" v-model="bill.due" readonly />
                                                </div>
                                                <div class="col-xs-6">
                                                    <input type="number" id="previousDue" class="form-control" v-model="bill.previous_due" readonly style="color:red;" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group" style="padding-top: 5px;">
                                                <div class="col-xs-6">
                                                    <input type="button" class="btn btn-default btn-sm" value="Save" v-on:click="saveBill" v-bind:disabled="OnProgress ? true : false" style="color: black!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">
                                                </div>
                                                <div class="col-xs-6">
                                                    <a class="btn btn-info btn-sm" v-bind:href="`/bill-entry`" style="color: black!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">New Bill</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#BillEntry',

        data() {
            return {
                bill: {
                    id: parseInt('<?php echo $billId ?>'),
                    date: moment().format('YYYY-MM-DD'),
                    invoice: '<?php echo $invoice ?>',
                    mr_no: '',
                    client_id: '',
                    supplier_id: '',
                    subTotal: 0.00,
                    purchase_total: 0.00,
                    vat: 0.00,
                    discount: 0.00,
                    total: 0.00,
                    paid: 0.00,
                    due: 0.00,
                    previous_due: 0.00,
                    note: '',
                    other_service: '',
                    service_amount: 0.00,
                },

                vatPercent: 0,
                discountPercent: 0,
                routeDiscount: 0,

                clients: [],
                client: {
                    Customer_SlNo: '',
                    Customer_Code: '',
                    Customer_Name: '',
                    display_name: 'Select Client',
                    Customer_Mobile: '',
                    Customer_Email: '',
                    Customer_Address: ''
                },
                oldClientId: null,
                oldPreviousDue: 0,
                suppliers: [],
                supplier: {
                    Supplier_SlNo: null,
                    Supplier_Code: '',
                    Supplier_Name: '',
                    display_name: 'Select Supplier',
                    Supplier_Mobile: '',
                    Supplier_Email: '',
                    Supplier_Address: '',
                },
                // branches: [],
                // branch: {
                //     brunch_id: "<?php echo $this->session->userdata('BRANCHid'); ?>",
                // 	Brunch_name: "<?php echo $this->session->userdata('Brunch_name'); ?>"
                // },

                airlines: [],
                airline: {
                    ProductCategory_SlNo: '',
                    ProductCategory_Name: 'Select Airline'
                },

                routes: [],
                filterRoutes: [],
                route: {
                    Product_SlNo: '',
                    Product_Name: 'Select Route',
                    name: '',
                    phone: '',
                    // address: '',
                    route_id: '',
                    issue_date: '',
                    flight_date: '',
                    reminder_date: '',
                    return_date: '',
                    pnr_no: '',
                    ticket: '',
                    flight_no: '',
                    Product_Purchase_Rate: 0.00,
                    Product_SellingPrice: 0.00,
                    tax_amount: 0.00,
                    supplier_tax: 0.00,
                    discount: 0.00
                },

                cart: [],
                bill_due_on_update: 0.00,
                OnProgress: false,
            }
        },

        watch: {
            airline(airline) {
                if (airline == undefined) return;
                let data = this.routes.filter(item => item.ProductCategory_ID == airline.ProductCategory_SlNo);
                this.filterRoutes = data;
                this.filterRoutes.unshift({
                    Product_SlNo: 'R01',
                    Product_Name: 'New Route',
                    name: '',
                    phone: '',
                    route_id: '',
                    issue_date: '',
                    flight_date: '',
                    reminder_date: '',
                    return_date: '',
                    pnr_no: '',
                    ticket: '',
                    flight_no: '',
                    Product_Purchase_Rate: 0.00,
                    Product_SellingPrice: 0.00,
                    tax_amount: 0.00,
                    discount: 0.00
                })
            }
        },

        async created() {
            // this.getBranches();
            this.getClients();
            this.getSuppliers();
            this.getAirlines();
            this.getRoutes();

            if (this.bill.id != 0) {
                await this.getBills();
            }
        },

        methods: {
            // getBranches(){
            // 	axios.get('/get_branches').then(res=>{
            // 		this.branches = res.data;
            // 	})
            // },

            async getClients() {
                await axios.get('/get_customers').then(res => {
                    this.clients = res.data;
                    this.clients.unshift({
                        Customer_SlNo: 'C01',
                        Customer_Code: '',
                        Customer_Name: '',
                        display_name: 'New Client',
                        Customer_Mobile: '',
                        Customer_Email: '',
                        Customer_Address: '',
                    })
                })
            },

            async getSuppliers() {
                await axios.get('/get_suppliers').then(res => {
                    this.suppliers = res.data;
                    this.suppliers.unshift({
                        Supplier_SlNo: 'S01',
                        Supplier_Code: '',
                        Supplier_Name: '',
                        display_name: 'New Supplier',
                        Supplier_Mobile: '',
                        Supplier_Email: '',
                        Supplier_Address: '',
                    })
                })
            },

            async clientOnChange() {
                if (this.client.Customer_SlNo == '') {
                    return;
                }

                if (event.type == 'readystatechange') {
                    return;
                }

                if (this.bill.id != 0 && this.oldClientId != parseInt(this.client.Customer_SlNo)) {
                    let changeConfirm = confirm('Changing client will set previous due to current due amount. Do you really want to change client?');
                    if (changeConfirm == false) {
                        return;
                    }
                } else if (this.bill.id != 0 && this.oldClientId == parseInt(this.client.Customer_SlNo)) {
                    this.bill.previous_due = this.oldPreviousDue;
                    return;
                }

                await this.getClientDue();

                this.calculateTotal();
            },

            async getClientDue() {
                await axios.post('/get_client_due', {
                        clientId: this.client.Customer_SlNo
                    })
                    .then(res => {
                        if (res.data.length > 0) {
                            this.bill.previous_due = res.data[0].dueAmount;
                        } else {
                            this.bill.previous_due = 0;
                        }
                    })
            },

            getAirlines() {
                axios.get('/get_airlines').then(res => {
                    this.airlines = res.data;
                })
            },

            getRoutes() {
                axios.get('/get_products').then(res => {
                    this.routes = res.data;
                    this.filterRoutes = res.data;
                    this.filterRoutes.unshift({
                        Product_SlNo: 'R01',
                        Product_Name: 'New Route',
                        name: '',
                        phone: '',
                        // address: '',
                        route_id: '',
                        issue_date: '',
                        flight_date: '',
                        reminder_date: '',
                        return_date: '',
                        pnr_no: '',
                        ticket: '',
                        flight_no: '',
                        Product_Purchase_Rate: 0.00,
                        Product_SellingPrice: 0.00,
                        tax_amount: 0.00,
                        discount: 0.00
                    })
                })
            },

            addToCart() {
                if (this.airline.ProductCategory_SlNo == '') {
                    alert('Select Airline');
                    return;
                }

                if (this.route.Product_SlNo == '') {
                    alert('Select Route');
                    return;
                }

                if (this.route.Product_SellingPrice == 0 || this.route.Product_SellingPrice == '') {
                    alert('Enter sales rate');
                    return;
                }

                let route = {
                    routeId: this.route.Product_SlNo,
                    routeName: this.route.Product_Name,
                    airlineId: this.airline.ProductCategory_SlNo,
                    airline: this.airline.ProductCategory_Name,
                    name: this.route.name,
                    phone: this.route.phone,
                    // address: this.route.address,
                    issue_date: this.route.issue_date,
                    flight_date: this.route.flight_date,
                    reminder_date: this.route.reminder_date,
                    return_date: this.route.return_date,
                    pnr_no: this.route.pnr_no,
                    ticket: this.route.ticket,
                    flight_no: this.route.flight_no,
                    purRate: this.route.Product_Purchase_Rate,
                    saleRate: this.route.Product_SellingPrice,
                    taxAmount: this.route.tax_amount,
                    supplier_tax: this.route.supplier_tax,
                    discount: this.route.discount,
                }

                let cartInd = this.cart.findIndex(r => r.pnr_no != route.pnr_no);
                if (cartInd > -1) {
                    alert('PNR number dose not match!');
                    return;
                }

                this.cart.push(route);
                this.clearCart();
                this.calculateTotal();

            },

            removeFromCart(ind) {
                this.cart.splice(ind, 1);
                this.calculateTotal();
            },

            clearCart() {
                // this.route.pnr_no = '';
                this.route.ticket = '';
                this.routeDiscount = 0.00;
                this.route.discount = 0.00;
                this.route.tax_amount = 0.00;
            },

            calculateDiscount() {
                if (event.target.id == 'routeDiscount') {
                    this.route.discount = ((parseFloat(this.route.Product_SellingPrice) * parseFloat(this.routeDiscount)) / 100).toFixed(2);
                } else {
                    this.routeDiscount = (parseFloat(this.route.discount) / parseFloat(this.route.Product_SellingPrice) * 100).toFixed(2);
                }
            },

            calculateTotal() {
                this.bill.purchase_total = this.cart.reduce((prev, curr) => {
                    return prev + parseFloat(curr.purRate)
                }, 0).toFixed(2);

                let saleTotal = this.cart.reduce((prev, curr) => {
                    return prev + parseFloat(curr.saleRate)
                }, 0).toFixed(2);
                let taxTotal = this.cart.reduce((prev, curr) => {
                    return prev + parseFloat(curr.taxAmount)
                }, 0).toFixed(2);
                let discountTotal = this.cart.reduce((prev, curr) => {
                    return prev + parseFloat(curr.discount)
                }, 0).toFixed(2);

                this.bill.subTotal = (+saleTotal + +taxTotal) - discountTotal;

                if (event.target.id == 'vatPercent') {
                    this.bill.vat = ((parseFloat(this.bill.subTotal) * parseFloat(this.vatPercent)) / 100).toFixed(2);
                } else {
                    this.vatPercent = (parseFloat(this.bill.vat) / parseFloat(this.bill.subTotal) * 100).toFixed(2);
                }

                if (event.target.id == 'discountPercent') {
                    let total = this.cart.reduce((acc, pre) => {
                        return acc + +pre.saleRate
                    }, 0);
                    this.bill.discount = ((parseFloat(total) * parseFloat(this.discountPercent)) / 100).toFixed(2);
                } else {
                    let total = this.cart.reduce((acc, pre) => {
                        return acc + +pre.saleRate
                    }, 0);
                    this.discountPercent = (parseFloat(this.bill.discount) / parseFloat(total) * 100).toFixed(2);
                }

                this.bill.total = parseFloat((+this.bill.subTotal + +this.bill.service_amount + +this.bill.vat) - +this.bill.discount).toFixed(2)

                this.bill.due = parseFloat(+this.bill.total - +this.bill.paid).toFixed(2);
            },

            async saveBill() {
                if (this.client.Customer_SlNo == '') {
                    alert('Select Client!');
                    return;
                }

                if (this.supplier.Supplier_SlNo == '') {
                    alert('Select Supplier!');
                    return;
                }

                if (this.cart.length == 0) {
                    alert('Cart is empty');
                    return;
                }

                this.OnProgress = true;

                await this.getClientDue();

                let url = "/save-bill";
                if (this.bill.id != 0) {
                    url = "/update-bill";
                    this.bill.previous_due = parseFloat((this.bill.previous_due - this.bill_due_on_update)).toFixed(2);
                }

                this.bill.client_id = this.client.Customer_SlNo;
                this.bill.supplier_id = this.supplier.Supplier_SlNo;

                let data = {
                    bill: this.bill,
                    cart: this.cart
                }

                if (this.client.Customer_SlNo == 'C01') {
                    data.client = this.client;
                }

                if (this.supplier.Supplier_SlNo == 'S01') {
                    data.supplier = this.supplier;
                }

                axios.post(url, data)
                    .then(async res => {
                        let r = res.data;
                        if (r.success) {
                            let conf = confirm('Bill success, Do you want to view invoice?');
                            if (conf) {
                                window.open('/bill-invoice-print/' + r.billId, '_blank');
                                await new Promise(r => setTimeout(r, 1000));
                                window.location = '/bill-entry';
                            } else {
                                wwindow.location = '/bill-entry';
                            }
                        } else {
                            alert(r.message);
                            this.OnProgress = false;
                        }
                    })
            },

            async getBills() {
                await axios.post('/get_bills', {
                        billId: this.bill.id
                    })
                    .then(res => {
                        let r = res.data;
                        let bills = r.bills[0];

                        this.bill.date = bills.date;
                        this.bill.invoice = bills.invoice;
                        this.bill.mr_no = bills.mr_no;
                        this.bill.client_id = bills.client_id;
                        this.bill.supplier_id = bills.supplier_id;
                        this.bill.subTotal = bills.sub_total;
                        this.bill.purchase_total = bills.purchase_total;
                        this.bill.vat = bills.vat;
                        this.bill.discount = bills.discount;
                        this.bill.total = bills.total;
                        this.bill.paid = bills.paid;
                        this.bill.due = bills.due;
                        this.bill.previous_due = bills.previous_due;
                        this.bill.note = bills.note;
                        this.bill.other_service = bills.other_service;
                        this.bill.service_amount = bills.service_amount;

                        this.oldClientId = bills.client_id;
                        this.oldPreviousDue = bills.previous_due;
                        this.bill_due_on_update = bills.due;

                        this.vatPercent = parseFloat(this.bill.vat) * 100 / parseFloat(this.bill.subTotal);
                        this.discountPercent = parseFloat(this.bill.discount) * 100 / parseFloat(this.bill.subTotal);

                        this.client = {
                            Customer_SlNo: bills.client_id,
                            Customer_Code: bills.Customer_Code,
                            Customer_Name: bills.Customer_Name,
                            display_name: `${bills.Customer_Code} - ${bills.Customer_Name}`,
                            Customer_Mobile: bills.Customer_Mobile,
                            Customer_Email: bills.Customer_Email,
                            Customer_Address: bills.Customer_Address
                        }

                        this.supplier = {
                                Supplier_SlNo: bills.supplier_id,
                                Supplier_Code: bills.Supplier_Code,
                                Supplier_Name: bills.Supplier_Name,
                                display_name: `${bills.Supplier_Code} - ${bills.Supplier_Name}`,
                                Supplier_Mobile: bills.Supplier_Mobile,
                                Supplier_Email: bills.Supplier_Email,
                                Supplier_Address: bills.Supplier_Address,
                            },

                            r.billDetails.forEach(route => {
                                let cartRoute = {
                                    routeId: route.route_id,
                                    routeName: route.Product_Name,
                                    airlineId: route.airline_id,
                                    airline: route.ProductCategory_Name,
                                    name: route.name,
                                    phone: route.phone,
                                    // address: route.address,
                                    issue_date: route.issue_date,
                                    flight_date: route.flight_date,
                                    reminder_date: route.reminder_date,
                                    return_date: route.return_date,
                                    pnr_no: route.pnr_no,
                                    ticket: route.ticket,
                                    flight_no: route.flight_no,
                                    purRate: route.purchase_rate,
                                    supplier_tax: route.supplier_tax,
                                    saleRate: route.sale_rate,
                                    taxAmount: route.tax_amount,
                                    discount: route.discount,
                                }

                                this.cart.push(cartRoute);
                            })
                    })
            }
        }
    })
</script>