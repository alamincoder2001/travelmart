const billInvoice = Vue.component("bill-invoice", {
  template: ` 
        <div>
            <div class="row">
                <div class="col-xs-12">
                    <form v-on:submit.prevent="sendMail">
                        <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>&nbsp; &nbsp; 
                        <input type="email" v-model="bills.Customer_Email" style="display: none;">
                        <button type="submit"><i class="fa fa-envelope"></i> send Mail</button>
                    </form>
                </div>
            </div>

            <div id="invoiceContent">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <div _h098asdh>
                            Bill Invoice
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <table _a284de>
                            <tr>
                                <td width="13%"><strong>Invoice</strong></td>
                                <td width="2%">:</td>
                                <td width="30%">{{ bills.invoice }}</td>
                                <td width="55%"></td>
                            </tr>
                            
                            <tr>
                                <td width="13%"><strong>Date</strong></td>
                                <td width="2%">:</td>
                                <td width="30%">{{ bills.date }} {{ bills.added_time | formatDateTime('h:mm A') }}</td>
                                <td width="55%"></td>
                            </tr>
                        </table>
                        <div class="client">
                            <strong>To</strong><br>
                            <p>{{ bills.Customer_Name }}</p>
                            <p>{{ bills.Customer_Address }}</p>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 15px;">
                    <div class="col-xs-12">
                        <table _a584de>
                            <thead>
                                <tr>
                                    <td>SL</td>
                                    <td>PNR NO</td>
                                    <td>Ticket</td>
                                    <td>Name</td>
                                    <td>Airline</td>
                                    <td>Route</td>
                                    <td>Fare</td>
                                    <td>Discount</td>
                                    <td>Tax</td>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(route, sl) in cart">
                                    <td>{{ sl + 1 }}</td>
                                    <td>{{ route.pnr_no }}</td>
                                    <td>{{ route.ticket }}</td>
                                    <td>{{ route.name }}</td>
                                    <td>{{ route.ProductCategory_Name }}</td>
                                    <td>{{ route.Product_Name }}</td>
                                    <td>{{ route.sale_rate }}</td>
                                    <td>{{ route.discount }}</td>
                                    <td>{{ route.tax_amount }}</td>
                                    <td>{{ (parseFloat(route.sale_rate) + parseFloat(route.tax_amount) - parseFloat(route.discount)).toFixed(2) }}</td>
                                </tr>
                                <tr v-if="bills.service_amount > 0">
                                    <td>{{ cart.length + 1 }}</td>
                                    <td style="font-weight: bold;">Service:</td>
                                    <td colspan="6" style="text-align:left">{{ bills.other_service }}</td>
                                    <td style="text-align:right">{{ bills.service_amount }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div style="margin-top: 10px;">
                            <table class="pull-left">
                                <tr>
                                    <td><strong>Previous Due</strong></td>
                                    <td><strong>: </strong></td>
                                    <td style="text-align:right">&nbsp;&nbsp;{{ bills.previous_due == null ? '0.00' : bills.previous_due  }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Current Due</strong></td>
                                    <td><strong>: </strong></td>
                                    <td style="text-align:right">&nbsp;&nbsp;{{ bills.due == null ? '0.00' : bills.due  }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="border-bottom: 1px solid #ccc;"></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Due</strong></td>
                                    <td><strong>: </strong></td>
                                    <td style="text-align:right">&nbsp;&nbsp;{{ (parseFloat(bills.previous_due) + parseFloat(bills.due == null ? 0.00 : bills.due)).toFixed(2) }}</td>
                                </tr>
                            </table>
                        </div>
                        <br><br><br>
                        <div style="margin-top: 10px;">
                            <table class="pull-left">
                                <tr>
                                    <td><strong>Date of Issue</strong></td>
                                    <td><strong>: </strong></td>
                                    <td style="text-align:right;">&nbsp;&nbsp;{{ cart[0].issue_date }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date of Travels</strong></td>
                                    <td><strong>: </strong></td>
                                    <td style="text-align:right;">&nbsp;&nbsp;{{ cart[0].flight_date }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date of Return</strong></td>
                                    <td><strong>: </strong></td>
                                    <td style="text-align:right;">&nbsp;&nbsp;{{ cart[0].return_date }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <table _t92sadbc2>
                            <tr style="display:none;">
                                <td><strong>VAT:</strong></td>
                                <td style="text-align:right">{{ bills.vat }}</td>
                            </tr>
                            <tr style="display:none;">
                                <td><strong>Tax Amount:</strong></td>
                                <td style="text-align:right">{{ cart.reduce((prev, curr) => { return prev + parseFloat(curr.tax_amount)}, 0) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Sub Total BDT:</strong></td>
                                <td style="text-align:right">{{ bills.sub_total }}</td>
                            </tr>
                            <tr>
                                <td><strong>Discount:</strong></td>
                                <td style="text-align:right">{{ bills.discount }}</td>
                            </tr>
                            <tr><td colspan="2" style="border-bottom: 1px solid #ccc"></td></tr>
                            <tr>
                                <td><strong>Total BDT:</strong></td>
                                <td style="text-align:right">{{ bills.total }}</td>
                            </tr>
                            <tr>
                                <td><strong>Paid:</strong></td>
                                <td style="text-align:right">{{ bills.paid }}</td>
                            </tr>
                            <tr><td colspan="2" style="border-bottom: 1px solid #ccc"></td></tr>
                            <tr>
                                <td><strong>Due:</strong></td>
                                <td style="text-align:right">{{ bills.due }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row" style="padding-top: 10px;">
                    <div class="col-xs-12">
                        <strong>In Word: </strong> {{ convertNumberToWords(bills.total) }}<br>
                        
                        <p style="white-space: pre-line; padding-top: 5px;"><strong>Note: </strong> {{ bills.note }}</p>
                    </div>
                </div>
            </div>
        </div>
    `,

  props: ["bill_id"],

  data() {
    return {
      bills: {
        id: null,
        invoice: null,
        client_id: null,
        date: null,
        Customer_Name: null,
        Customer_Address: null,
        Customer_Mobile: null,
        total: null,
        discount: null,
        vat: null,
        other_service: null,
        service_amount: null,
        sub_total: null,
        paid: null,
        due: null,
        previous_due: null,
        note: null,
        added_by: null,
      },
      cart: [],
      style: null,
      companyProfile: null,
      currentBranch: null,
    };
  },

  filters: {
    formatDateTime(dt, format) {
      return dt == "" || dt == null ? "" : moment(dt).format(format);
    },
  },

  created() {
    this.setStyle();
    this.getBills();
    this.getCurrentBranch();
  },

  methods: {
    getBills() {
      axios.post("/get_bills", { billId: this.bill_id }).then((res) => {
        this.bills = res.data.bills[0];
        this.cart = res.data.billDetails;
      });
    },

    getCurrentBranch() {
      axios.get("/get_current_branch").then((res) => {
        this.currentBranch = res.data;
      });
    },

    sendMail() {
      let data = {
        email: this.bills.Customer_Email,
        invoice: this.bills.id,
        invoic_no: this.bills.invoice,
        InWord: this.convertNumberToWords(this.bills.total),
      };

      axios.post("/send_mail", data).then((res) => {
        let r = res.data;
        if (r.success) {
          alert(r.message);
        }
      });
    },

    setStyle() {
      this.style = document.createElement("style");
      this.style.innerHTML = `
                div[_h098asdh]{
                    /*background-color:#e0e0e0;*/
                    font-weight: bold;
                    font-size:15px;
                    margin-bottom:15px;
                    padding: 5px;
                    /*border-top: 1px dotted #454545;
                    border-bottom: 1px dotted #454545;*/
                }
                div[_d9283dsc]{
                    padding-bottom:25px;
                    border-bottom: 1px solid #ccc;
                    margin-bottom: 15px;
                }
                table[_a584de]{
                    width: 100%;
                    text-align:center;
                }
                table[_a584de] thead{
                    font-weight:bold;
                }
                table[_a584de] td{
                    padding: 3px;
                    font-size: 12px;
                    border: 1px solid #ccc;
                }
                table[_t92sadbc2]{
                    width: 100%;
                }
                table[_t92sadbc2] td{
                    padding: 2px;
                }

                table[_a284de]{
                    width: 100%;
                    text-align:left;
                    font-size: 15px;
                    font-weight: 500;
                    letter-spacing: .5px;
                }
                .client {
                    padding-top: 15px;
                }
                .client p {
                    margin: 0px;
                    font-size: 15px;
                    font-weight: 500;
                    letter-spacing: .5px;
                }
            `;
      document.head.appendChild(this.style);
    },

    convertNumberToWords(amountToWord) {
      var words = new Array();
      words[0] = "";
      words[1] = "One";
      words[2] = "Two";
      words[3] = "Three";
      words[4] = "Four";
      words[5] = "Five";
      words[6] = "Six";
      words[7] = "Seven";
      words[8] = "Eight";
      words[9] = "Nine";
      words[10] = "Ten";
      words[11] = "Eleven";
      words[12] = "Twelve";
      words[13] = "Thirteen";
      words[14] = "Fourteen";
      words[15] = "Fifteen";
      words[16] = "Sixteen";
      words[17] = "Seventeen";
      words[18] = "Eighteen";
      words[19] = "Nineteen";
      words[20] = "Twenty";
      words[30] = "Thirty";
      words[40] = "Forty";
      words[50] = "Fifty";
      words[60] = "Sixty";
      words[70] = "Seventy";
      words[80] = "Eighty";
      words[90] = "Ninety";
      amount = amountToWord == null ? "0.00" : amountToWord.toString();
      var atemp = amount.split(".");
      var number = atemp[0].split(",").join("");
      var n_length = number.length;
      var words_string = "";
      if (n_length <= 9) {
        var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        var received_n_array = new Array();
        for (var i = 0; i < n_length; i++) {
          received_n_array[i] = number.substr(i, 1);
        }
        for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
          n_array[i] = received_n_array[j];
        }
        for (var i = 0, j = 1; i < 9; i++, j++) {
          if (i == 0 || i == 2 || i == 4 || i == 7) {
            if (n_array[i] == 1) {
              n_array[j] = 10 + parseInt(n_array[j]);
              n_array[i] = 0;
            }
          }
        }
        value = "";
        for (var i = 0; i < 9; i++) {
          if (i == 0 || i == 2 || i == 4 || i == 7) {
            value = n_array[i] * 10;
          } else {
            value = n_array[i];
          }
          if (value != 0) {
            words_string += words[value] + " ";
          }
          if (
            (i == 1 && value != 0) ||
            (i == 0 && value != 0 && n_array[i + 1] == 0)
          ) {
            words_string += "Crores ";
          }
          if (
            (i == 3 && value != 0) ||
            (i == 2 && value != 0 && n_array[i + 1] == 0)
          ) {
            words_string += "Lakhs ";
          }
          if (
            (i == 5 && value != 0) ||
            (i == 4 && value != 0 && n_array[i + 1] == 0)
          ) {
            words_string += "Thousand ";
          }
          if (
            i == 6 &&
            value != 0 &&
            n_array[i + 1] != 0 &&
            n_array[i + 2] != 0
          ) {
            words_string += "Hundred and ";
          } else if (i == 6 && value != 0) {
            words_string += "Hundred ";
          }
        }
        words_string = words_string.split("  ").join(" ");
      }
      return words_string + " Taka Only";
    },

    async print() {
      let invoiceContent = document.querySelector("#invoiceContent").innerHTML;
      let printWindow = window.open(
        "",
        "PRINT",
        `width=${screen.width}, height=${screen.height}, left=0, top=0`
      );
      if (this.currentBranch.print_type == "3") {
        printWindow.document.write(`
                    <html>
                        <head>
                            <title>Invoice</title>
                            <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                            <style>
                                body, table{
                                    font-size:11px;
                                }
                            </style>
                        </head>
                        <body>
                            <div style="text-align:center;">
                                <img src="/uploads/company_profile_thum/${this.currentBranch.Company_Logo_org}" alt="Logo" style="height:80px;margin:0px;" /><br>
                                <strong style="font-size:18px;">${this.currentBranch.Company_Name}</strong><br>
                                <p style="white-space:pre-line;">${this.currentBranch.Repot_Heading}</p>
                            </div>
                            ${invoiceContent}
                        </body>
                    </html>
                `);
      } else if (this.currentBranch.print_type == "2") {
        printWindow.document.write(`
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <title>Invoice</title>
                        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                        <style>
                            html, body{
                                width:500px!important;
                            }
                            body, table{
                                font-size: 13px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="row">
                            <div class="col-xs-12" style="margin-bottom: 5px;">
                                <img src="/uploads/company_profile_thum/travel-mart.jpeg" alt="Logo" style="width:100%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                ${invoiceContent}
                            </div>
                        </div>
                    </body>
                    </html>
				`);
      } else {
        printWindow.document.write(`
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <title>Invoice</title>
                        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                        <style>
                            body, table{
                                font-size: 13px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-xs-12" style="margin-bottom: 5px;">
                                                    <img src="/uploads/company_profile_thum/travel-mart.jpeg" alt="Logo" style="width:100%" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    ${invoiceContent}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <div style="width:100%;height:50px;">&nbsp;</div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row" style="margin-bottom:5px; padding-bottom:6px;">
                                <div class="col-xs-12">
                                    Thank you for your kind Co-operation
                                </div>
                                <div class="col-xs-12" style="padding-top: 70px;padding-bottom:8px;">
                                    <img src="/uploads/sill.jpeg" width="150px" />
                                </div>
                                <div class="col-xs-12">
                                    Shahidul Islam Babu, Chief Executive Officer, Travel Mart USA.
                                </div>
                            </div>
                            <div style="position:fixed;left:0;bottom:15px;width:100%;">
                                <div class="row" style="text-align:center;">
                                    <div class="col-xs-12"  style="font-size:14px; padding-bottom: 5px;">
                                        This is a computer generated statement and dose not require any signature.
                                    </div>
                                    <div class="col-xs-12" style="border-top: 1px solid #ccc;font-size:11px;">
                                    House-114, Flat-2B (2nd Floor), Road-15, Block-C, Banani, Dhaka-1212, Bangladesh, Cell: +8801833079597, +8801714092703, E-mail: travelmartusa@yahoo.com, 729, Thierlot Avenue, Floor-1, Bronx NY 10473, New York, USA, Cell: 669 265 9014, E-mail: travelmartusa@gmail.com
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </body>
                    </html>
				`);
      }
      let invoiceStyle = printWindow.document.createElement("style");
      invoiceStyle.innerHTML = this.style.innerHTML;
      printWindow.document.head.appendChild(invoiceStyle);
      printWindow.moveTo(0, 0);

      printWindow.focus();
      await new Promise((resolve) => setTimeout(resolve, 1000));
      printWindow.print();
      printWindow.close();
    },
  },
});
